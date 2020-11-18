<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/user_functions.php'); ?>
<?php 

	$users = getUsers();		
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>user || Manage users</title>
</head>
<body>
	
    <?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
    
	<div class="container content">
		
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		
		<div class="action">
			<h1 class="page-title">Create/Edit  User</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>" >

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				

				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_user">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="back"><a href="./dashboard.php"style="color:white">Back</a> </button>
					<button type="submit" class="btn" name="create_user">Save User</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($users)): ?>
				<h1>No users in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>user</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($users as $key => $user): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $user['username']; ?>, &nbsp;
								<?php echo $user['email']; ?>	
							</td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="users.php?edit-user=<?php echo $user['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="users.php?delete-user=<?php echo $user['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>