<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
<?php 
	if (isset($_GET['page'])) {
		$posts = getPost($_GET['page']);
	}
	$topics = getAllTopics();
?>
<?php $scales = getScales(); ?>
<?php $vendors = getVendors(); ?>
<?php include('includes/head_section.php'); ?>
<title> Categorys | LifeBlog</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
	<div class="navbar">
		<div class="logo_div">
			<a href="index.php"><h1>Classic Shopping</h1></a>
		</div>
		<ul>
	  		<li><a class="active" href="index.php">Home</a></li>
	  		<li><a href="#contact">Contact</a></li>
	  		<li><a href="#about">About</a></li>
		</ul>
	</div>
	<!-- // Navbar -->
	
	<div class="content" >
		<!-- Page wrapper -->
		<div class="post-wrapper">
			<!-- full post div -->
			<div class="full-post-div">
				<div class="post-body-div">
				<table style="width:100%">
  					<tr>
    					<th>Code</th>
    					<th>Line</th>
    					<th>Scale</th>
						<th>Vendor</th>
						<th>Stock</th>
						<th>Price</th>
  					</tr>
					<?php foreach ($posts as $post): ?>
  					<tr >
    					<td><?php echo $post['productCode'] ?></td>
    					<td><?php echo $post['productLine'] ?></td>
    					<td><?php echo $post['productScale'] ?></td>
						<td><?php echo $post['productVendor'] ?></td>
						<td><?php echo $post['quantityInStock'] ?></td>
						<td><?php echo $post['buyPrice'] ?></td>
  					</tr>
					<?php endforeach ?>
				</table>
				</div>
			</div>
			<!-- // full post div -->
			
			<!-- comments section -->
			<!--  coming soon ...  -->
		</div>
		<!-- // Page wrapper -->

		<!-- post sidebar -->
		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>Topics</h2>
				</div>
				<div class="card-content">
					<?php foreach ($scales as $topic): ?>
						<a 
							href="single_post.php?page=<?php echo $topic['productScale']; ?>">
							<?php echo $topic['productScale']; ?>
						</a> 
					<?php endforeach ?>
				</div>
				<div class="card-content">
					<?php foreach ($vendors as $topic): ?>
						<a 
							href="single_post.php?page=<?php echo $topic['productVendor']; ?>">
							<?php echo $topic['productVendor']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- // post sidebar -->
	</div>
</div>
<!-- // content -->
</body>

</html>