<?php  include('config.php'); 
        include('includes/registerUser.php');
		include('includes/head_section.php');
		// print_r($_SESSION);
?>

<title>Classic Shopping || Sign up </title>
</head>
<body>
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
<div class="container">

	<div style="width: 40%; margin: 20px auto;">
		<form method="post" action="register.php" >
			<h2>Register on Classic Shopping </h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input  type="text" name="username" value="<?php echo $username; ?>"  placeholder="Username">
			<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
			<input type="password" name="password_1" placeholder="Password">
            <input type="password" name="password_2" placeholder="Password confirmation">
            
			<button type="submit" class="btn" name="reg_user">Register</button>
			<p>
				Already a member? <a href="login.php">Sign in</a>
			</p>
		</form>
	</div>
</div>

	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
