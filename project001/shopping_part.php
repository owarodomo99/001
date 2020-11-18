<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
<?php $scales = getScales(); ?>
<?php $vendors = getVendors(); ?>
<?php  include('includes/head_section.php'); ?>
	<title>LifeBlog | Sign in </title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
	<div class="navbar">
		<div class="logo_div">
			<a href="index2.php"><h1>Classic Shopping</h1></a>
		</div>
		<ul>
	  		<li><a class="active" href="index2.php">Home</a></li>
			<li><a href="shopping_part.php"><img src="static/images/cart.png" width="23px" ></a></li>
	  		<li><a href="#contact">Contact</a></li>
	  		<li><a href="#about">About</a></li>
		</ul>
	</div>
	<!-- // Navbar -->
	<!-- more content still to come here ... -->
	<?php
/*session_start();*/
require_once ("dbcontroller.php");
$db_handle = new DBController();
if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (! empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM products WHERE productCode='" . $_GET["code"] . "'");
                $itemArray = array(
                    $productByCode[0]["productCode"] => array(
                        'name' => $productByCode[0]["productName"],
                        'code' => $productByCode[0]["productCode"],
                        'quantity' => $_POST["quantity"],
                        'price' => $productByCode[0]["buyPrice"],
                        'scale' => $productByCode[0]["productScale"]
                    )
                );
            	if (! empty($_SESSION["cart_item"])) {
                	if (in_array($productByCode[0]["productCode"], array_keys($_SESSION["cart_item"]))) {
                    	foreach ($_SESSION["cart_item"] as $k => $v) {
                        	if ($productByCode[0]["productCode"] == $k) {
                            	if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                	$_SESSION["cart_item"][$k]["quantity"] = 0;
                            	}
                            	$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                        	}
                    	}
                	} else {
                    	$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                	}
            	} else {
                	$_SESSION["cart_item"] = $itemArray;
                }
            }
           
        	break;
        case "remove":
            if (! empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<HTML>
<HEAD>
<TITLE>eCommerce software with discount coupon</TITLE>
<link href="static/css/public_styling.css" rel="stylesheet" />
<script src="static/js/jquery-3.2.1.min.js"></script>
</HEAD>
<BODY>
<form id="applyDiscountForm" method="post"
        action="cart.php? action=empty"
        onsubmit="">
        
        <div id="shopping-cart">
            <div class="txt-heading">Cart</div>
    <?php
    if (isset($_SESSION["cart_item"])) {
        $total_quantity = 0;
        $total_price = 0;
        ?>	
                <table class="tbl-cart" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr>
                        <th style="text-align: left;">Name</th>
                        <th style="text-align: left;">Code</th>
                        <th style="text-align: right;" width="5%">Quantity</th>
                        <th style="text-align: right;" width="10%">Unit Price</th>
                        <th style="text-align: right;" width="10%">Price</th>
                        <th style="text-align: center;" width="5%">Remove</th>
                    </tr>	
                        <?php
        foreach ($_SESSION["cart_item"] as $item) {
            $item_price = $item["quantity"] * $item["price"];
            ?>
                    <tr>
                        <td><?php echo $item["name"]; ?></td>
                        <td><?php echo $item["code"]; ?></td>
                        <td style="text-align: right;"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align: right;"><?php echo "$ " . $item["price"]; ?></td>
                        <td style="text-align: right;"><?php echo "$ " . number_format($item_price, 2); ?></td>
                        <td style="text-align: center;"><a
                            href="shopping_part.php?action=remove&page=<?php echo $item["scale"]; ?>&code=<?php echo $item["code"]; ?>"
                            class="btnRemoveAction"><img
                                src="static/images/icon-delete.png" width="23px" alt="Remove Item" /></a></td>
                    </tr>
                            <?php
            $total_quantity += $item["quantity"];
            $total_price += ($item["price"] * $item["quantity"]);
        }
        ?>
                    <tr>
                        <td colspan="2" align="right">Total:<input
                            type="hidden" name="totalPrice"
                            id="totalPrice"
                            value="<?php echo $total_price; ?>"></td>
                        <td align="right"><?php echo $total_quantity; ?></td>
                        <td align="right" colspan="2"><strong><?php echo "$ " . number_format($total_price, 2); ?></strong></td>
                        <td></td>
                    </tr>
                <?php     
                if (!empty($discountPrice) && $total_price > $discountPrice) {
                    $total_price_after_discount = $total_price - $discountPrice;
            ?>
                    <tr>
                        <td colspan="3" align="right">Discount:<input
                            type="hidden" name="discountPrice"
                            id="discountPrice"
                            value="<?php echo $discountPrice; ?>"></td>
                        <td align="right" colspan="2"><strong><?php echo "$ " . number_format($discountPrice, 2); ?></strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">Total afterDiscount:</td>
                        <td align="right" colspan="2"><strong><?php echo "$ " . number_format($total_price_after_discount, 2); ?></strong></td>
                        <td></td>
                    </tr>
                    <?php 
                }
                ?>
                </tbody>
            </table>		
            <?php
    } else {
        ?>
                <div class="no-records">Your Cart is Empty</div>
            <?php
    }
    ?>
        </div>
        <div class="discount-action">
            <input type="submit" value="Submit" />
        </div>
    </form>
	<br />
    <div id="product-grid">
        <div class="txt-heading">Products</div>
            <?php
            $product_array = $db_handle->runQuery("SELECT * FROM products WHERE productScale='" . $_GET["page"] . "' || productVendor='" . $_GET["page"] . "'");
            if (! empty($product_array)) {
                foreach ($product_array as $key => $value) {
                    ?>
                    <div class="product-item">
            <form method="post"
                action="shopping_part.php?action=add&page=<?php echo $product_array[$key]['productScale'];?>&code=<?php echo $product_array[$key]["productCode"]; ?>">
                <div class="product-tile-footer" style="width: 302px;">
                    <div class="product-title"><?php echo $product_array[$key]["productName"]; ?></div>
                    <div class=""><?php echo "Product quantity: " . $product_array[$key]["quantityInStock"] . " "; ?></div>
					<div class=""><?php echo "Price: " . "$" . $product_array[$key]["buyPrice"]; ?></div>
                    <div class="cart-action">
                    <input type="text" class="product-quantity" name="quantity" value="1" size="2" />
					<input type="submit" value="Add to Cart" class="btnAddAction" />
                    </div>
                </div>
            </form>
        </div>
                    <?php
                }
        	}
        ?>
    </div>
    <div class="post-sidebar" style = 'position:fixed;
	top:100px;
left:1700px;' >
		<div class="card">
			<div class="card-header">
				<h2 	style = 'text-align: left;'>Topics</h2>
			</div>
			<div class="card-content">
				<?php foreach ($scales as $topic): ?>
					<a 
						href="shopping_part.php?page=<?php echo $topic['productScale']; ?>">
						<?php echo $topic['productScale']; ?>
					</a> 
				<?php endforeach ?>
				<?php foreach ($vendors as $topic): ?>
					<a 
						href="shopping_part.php?page=<?php echo $topic['productVendor']; ?>">
						<?php echo $topic['productVendor']; ?>
					</a> 
				<?php endforeach ?>
			</div>
		</div>
	</div>
</BODY>
</HTML>
		</div>
</div>
<!-- // container -->
</body>

</html>