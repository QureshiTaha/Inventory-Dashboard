<?php
// session_start();

// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
// 	header("location: qt-admin");
// 	exit;
// }
include("config.php");

function gcip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	//whether ip is from the proxy  
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	//whether ip is from the remote address  
	else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function sendResponse($data = [], $status = true, $message = "")
{
	$response = array('success' => $status, 'message' => $message, 'data' => $data);
	echo json_encode($response);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password'] && empty($_GET['action']))) {
	$username = $_POST['email'];
	$password = $_POST['password'];
	$rememberMe = isset($_POST['rememberMe']) ? true : false;
	header('Content-Type: application/json');


	$IP = gcip();

	$browserName =  $_SERVER['HTTP_USER_AGENT'];
	$browser = get_browser();
	$session  = array($browserName, $browser, $IP);
	$browser = serialize($session);

	$sqli = "INSERT INTO `activity`(`username`, `session_details`, `ip`,`activity`) VALUES ('$username','$browser','$IP','Login')";
	$con->query($sqli);


	//to prevent from mysqli injection  
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysqli_real_escape_string($con, $username);
	$password = mysqli_real_escape_string($con, $password);

	$sql = "select * from admin where (name = '$username' OR email = '$username')  and password = '$password'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

	if ($count == 1) {
		session_start();
		$_SESSION["loggedin"] = true;
		$_SESSION["id"] = $row['id'];
		$_SESSION["username"] = $username;
		$response["success"] = true;
		$response["message"] = "Login successful!";
		echo json_encode($response);
	} else {
		$response['message'] = 'Login failed. Invalid username or password.!';
		echo json_encode($response);
	}
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['loggedin']) && $_GET['loggedin'] == 'false') {
	session_start();

	include('config.php');
	$username = $_SESSION['username'];


	$IP = gcip();
	$browserName =  $_SERVER['HTTP_USER_AGENT'];
	$browser = get_browser();
	$session  = array($browserName, $browser, $IP);
	$browser = serialize($session);

	$sqli = "INSERT INTO `activity`(`username`, `session_details`, `ip`,`activity`) VALUES ('$username','$browser','$IP','Logout')";
	$con->query($sqli);

	$_SESSION = array();
	session_destroy();
	header("location: /login");
	exit;

	$id = $_GET['delc'];
	mysqli_query($con, "DELETE FROM category WHERE id=$id");
	$msg = "category Deleted!";
	header('location: category?pop=del&msg=' . $msg);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
	// Handle API requests
	$action = $_GET['action'];
	header('Content-Type: application/json');



	if ($action === 'get_all_products') {
		$products = getAllProducts($con);
		sendResponse($products, true, 'Products retrieved successfully');
	} else if ($action === 'get_all_users') {
		$users = getAllUsers($con);
		sendResponse($users, true, 'Users retrieved successfully');
	} else {
		sendResponse([], false, 'Invalid action');
	}
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {

	$action = $_GET['action'];
	header('Content-Type: application/json');
	// var_dump($_POST);


	if ($action === 'add_user') {
		$isValid = false;

		if (empty($_POST['name'])) {
			sendResponse([], false, 'Name is required');
			$isValid = false;
		} else if (empty($_POST['email'])) {
			sendResponse([], false, 'Email is required');
			$isValid = false;
		} else if (empty($_POST['mobile'])) {
			sendResponse([], false, 'Mobile is required');
			$isValid = false;
		} else if (empty($_POST['password'])) {
			sendResponse([], false, 'Password is required');
			$isValid = false;
		} else {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$password = $_POST['password'];
			$role = $_POST['role'] ? $_POST['role'] : 1;
			$isValid = true;
		}

		//Validations..


		if ($isValid) {
			$sqli = "INSERT INTO `user`(`name`, `email`, `mobile`, `password`, `role`) VALUES ('$name','$email','$mobile','$password','$role')";

			try {
				if ($con->query($sqli)) {
					sendResponse($_POST, true, 'User added successfully');
				} else {
					sendResponse([], false, 'Something went wrong while adding user');
				}
			} catch (Error $th) {
				sendResponse([], false, $th->getMessage());
			}
		}
	} else if ($action === 'edit_user') {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$password = $_POST['password'];
		$role = $_POST['role'] ? $_POST['role'] : 1;

		$sqli = "UPDATE `user` SET `name` = '$name', `email` = '$email', `mobile` = '$mobile', `password` = '$password', `role` = '$role' WHERE `user`.`id` = $id";

		try {
			if ($con->query($sqli)) {
				sendResponse($_POST, true, 'User updated successfully');
			} else {
				sendResponse([], false, 'Something went wrong while updating user');
			}
		} catch (Error $th) {
			sendResponse([], false, $th->getMessage());
		}
	} else if ($action === 'delete_user') {
		$id = $_POST['id'];
		$sqli = "DELETE FROM `user` WHERE `user`.`id` = $id";
		try {
			if ($con->query($sqli)) {
				sendResponse($_POST, true, 'User deleted successfully');
			} else {
				sendResponse([], false, 'Something went wrong while deleting user');
			}
		} catch (Error $th) {
			sendResponse([], false, $th->getMessage());
		}
	} else {
		sendResponse([], false, 'Invalid action');
	}
}


function getAllProducts($con)
{
	$sql = "SELECT * FROM product";
	$result = mysqli_query($con, $sql);

	$products = array();

	while ($row = mysqli_fetch_assoc($result)) {
		$products[] = $row;
	}

	return $products;
}
function getAllUsers($con)
{
	$sql = "SELECT * FROM user";
	$result = mysqli_query($con, $sql);

	$user = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$user[] = $row;
	}

	return $user;
}
