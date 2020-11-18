<?php
require_once('config.php');
require_once( ROOT_PATH . '/includes/public_functions.php');
require_once(ROOT_PATH . '/includes/head_section.php');
require_once(ROOT_PATH . '/includes/registerUser.php');
require_once(ROOT_PATH . '/includes/loginUser.php');
$scales = getScales();
$vendors = getVendors();
?>
<title>Classic Shopping || Home </title>
</head>
<body>
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
	<?php include(ROOT_PATH . '/includes/banner.php') ?>
	<div class="container">
		<div class="content">
			<hr><h2 class="content-title">Categorize by Scale</h2><hr>
			<!-- more content still to come here ... -->
			<?php foreach ($scales as $post): ?>
				<div class="post" style="margin-left: 29px; width: 110px;">
					<a href="shopping_part.php?page=<?php echo $post['productScale']; ?>">
						
			        <!-- Added this if statement... -->
						<div class="post_info">
							<h3><?php echo $post['productScale'] ?></h3>
							<div class="info">
								<span class="read_more">Show more...</span>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach ?>
		</div>
		<div class="content">
			<hr><h2 class="content-title">Categorize by Vendor</h2><hr>
			<!-- more content still to come here ... -->
			<?php foreach ($vendors as $post): ?>
				<div class="post" style="margin-left: 45px; width: 240px;">
					<a href="shopping_part.php?page=<?php echo $post['productVendor']; ?>">
						
			        <!-- Added this if statement... -->
						<div class="post_info">
							<h3><?php echo $post['productVendor'] ?></h3>
							<div class="info">
								<span class="read_more">Show more...</span>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</body>

</html>