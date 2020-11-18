<?php 
	
	$username = "";
	$email    = "";
	$errors = array(); 

	
	if (isset($_POST['reg_user'])) {
		
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];

		// validation
		if (empty($username)) {  array_push($errors, "Please enter your username!"); }
		if (empty($email)) { array_push($errors,"Please enter your Email!"); }
		if (empty($password_1)) { array_push($errors,"Please enter your password!"); }
		if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match");}

		//check user exist
		$user_check = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

        $result = mysqli_query($conn, $user_check);
		$user = mysqli_fetch_assoc($result);

		if ($user) {
			if ($user['username'] === $username) {
			  array_push($errors, "Username already exists");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "Email already exists");
			}
        }
        
        
        //encrypt
		if (count($errors) == 0) {
			// print_r($_SESSION);
			$password = md5($password_1); 
			$query = "INSERT INTO users (username, email, password, created_at, updated_at) 
					  VALUES('$username', '$email', '$password', now(), now())";
			mysqli_query($conn, $query);

			// get id of created user
			$reg_user_id = mysqli_insert_id($conn); 
			
			// add user to session array
			$_SESSION['user'] = getUserById($reg_user_id);


			// if user is admin, redirect to admin area
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
				$_SESSION['message'] = "You are now logged in";
				// redirect to admin area
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "You are now logged in";
				// redirect to public area
				header('location: index.php');				
				exit(0);
			}
		}
    }
    
	// Get user info from user id
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		// returns user in an array format: 
		// ['id'=>1 'username' => 'Awa', 'email'=>'a@a.com', 'password'=> 'mypass']
		return $user; 
	}
?>