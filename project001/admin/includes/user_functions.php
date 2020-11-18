<?php
// Admin user variables
$user_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
// general variables
$errors = [];


// if user clicks the create admin button
if (isset($_POST['create_user'])) {
	createUser($_POST);
}
// if user clicks the Edit admin button
if (isset($_GET['edit-user'])) {
	$isEditingUser = true;
	$user_id = $_GET['edit-user'];
	editUser($user_id);
}
// if user clicks the update admin button
if (isset($_POST['update_user'])) {
	updateuser($_POST);
}
// if user clicks the Delete admin button
if (isset($_GET['delete-user'])) {
	$user_id = $_GET['delete-user'];
	deleteUser($user_id);
}


function getUsers()
{
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role !='Admin' or role is null";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}

function getDataUsers()
{
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role IS  NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}


function esc(String $value)
{
	// bring the global db connect object into function
	global $conn;
	// remove empty space sorrounding string
	$val = trim($value);
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
// Receives a string like 'Some Sample String'
// and returns 'some-sample-string'
function makeSlug(String $string)
{
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}

function createUser($request_values)
{
	global $conn, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	$role="";

	// form validation
	if (empty($username)) {
		array_push($errors, "Enter your username");
	}
	if (empty($email)) {
		array_push($errors, "Enter your Email ");
	}
	if (empty($password)) {
		array_push($errors, "Enter your password");
	}
	if ($password != $passwordConfirmation) {
		array_push($errors, "The two passwords do not match");
	}


	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // if user exists
		if ($user['username'] === $username) {
			array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
			array_push($errors, "Email already exists");
		}
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password); //encrypt the password before saving in the database
		$query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
				  VALUES('$username', '$email', '$role', '$password', now(), now())";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "user created successfully";
		header('location: adminusers.php');
		exit(0);
	}
}


function editUser($user_id)
{
	global $conn, $username, $role, $isEditingUser, $user_id, $email;

	$sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $admin['username'];
	$email = $admin['email'];
}


function updateUser($request_values)
{
	global $conn, $errors, $role, $username, $isEditingUser, $user_id, $email;
	// get id of the admin to be updated
	$user_id = $request_values['user_id'];
	// set edit state to false
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if (isset($request_values['role'])) {
		$role = $request_values['role'];
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$user_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = " user updated successfully";
		header('location: users.php');
		exit(0);
	}
}
// delete admin user 
function deleteUser($user_id)
{
	global $conn;
	$sql = "DELETE FROM users WHERE id=$user_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "User successfully deleted";
		header("location: users.php");
		exit(0);
	}
}
