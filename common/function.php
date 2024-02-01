<?php
// session_start();

// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
// 	header("location: qt-admin");
// 	exit;
// }
ini_set('display_errors', 'off');
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
	error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

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
	header("location: " . $apiURL . "login");
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
	} else if ($action === 'get_product_by_id') {
		$product = getProductByID($con);
		sendResponse($product, true, 'Product retrieved successfully');
	} else if ($action === 'get_all_users') {
		$users = getAllUsers($con);
		sendResponse($users, true, 'Users retrieved successfully');
	} else if ($action === 'get_user_by_id') {
		$user = getUserByID($con);
		sendResponse($user, true, 'User retrieved successfully');
	} else if ($action === 'get_all_invoice') {
		$invoice = getAllInvoice($con);
		sendResponse($invoice, true, 'Invoice retrieved successfully');
	} else if ($action === "dashboard_stats") {
		$stats = getDashboardStats($con);
		sendResponse($stats, true, 'Dashboard stats retrieved successfully');
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
		} else {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$password = $_POST['password'];
			$role = $_POST['role'] ? $_POST['role'] : 1;
			$tax = !empty($_POST['tax']) ? $_POST['tax'] : "";
			$address = !empty($_POST['address']) ? $_POST['address'] : "";
			$isValid = true;
		}

		//Validations..


		if ($isValid) {
			$sqli = "INSERT INTO `user`(`name`, `email`, `mobile`, `password`, `role`,`tax`,`address`) VALUES ('$name','$email','$mobile','$password','$role','$tax','$address')";

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
		$tax = !empty($_POST['tax']) ? $_POST['tax'] : "";
		$address = !empty($_POST['address']) ? $_POST['address'] : "";
		$sqli = "UPDATE `user` SET `name` = '$name', `email` = '$email', `mobile` = '$mobile', `password` = '$password', `role` = '$role', `tax` = '$tax', `address` = '$address' WHERE `user`.`id` = $id";

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
	} else if ($action === 'add_product') {

		$name = $_POST['name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$modalNumber = $_POST['modalNumber'];
		$hsnCode = $_POST['hsnCode'] ? $_POST['hsnCode'] : "";

		$sqli = "SELECT * FROM product WHERE modalNumber = '$modalNumber'";
		$result = mysqli_query($con, $sqli);

		// validation for name price and quantity 

		$isValid = false;

		if (empty($quantity)) {
			sendResponse([], false, 'Product Quantity is required');
			$isValid = false;
		} else if (empty($name)) {
			sendResponse([], false, 'Product Name is required');
			$isValid = false;
		} else if (empty($price)) {
			sendResponse([], false, 'Product Price is required');
			$isValid = false;
		} else if (mysqli_num_rows($result) > 0) {
			sendResponse([], false, 'Modal number already exists in Invantory');
			$isValid = false;
		} else {
			$isValid = true;
		}

		//Validate Modal number exists in db






		$sqli = "INSERT INTO `product`(`name`, `description`, `price`, `quantity`, `modalNumber`,`hsnCode`) VALUES ('$name','$description','$price','$quantity','$modalNumber','$hsnCode')";

		try {
			if ($con->query($sqli)) {
				sendResponse($_POST, true, 'Product added successfully');
			} else {
				sendResponse([], false, 'Something went wrong while adding product');
			}
		} catch (Error $th) {
			sendResponse([], false, $th->getMessage());
		}
	} else if ($action === 'delete_product') {
		$id = $_POST['id'];
		$sqli = "DELETE FROM `product` WHERE `product`.`id` = $id";
		try {
			if ($con->query($sqli)) {
				sendResponse($_POST, true, 'Product deleted successfully');
			} else {
				sendResponse([], false, 'Something went wrong while deleting product');
			}
		} catch (Error $th) {
			sendResponse([], false, $th->getMessage());
		}
	} else if ($action === 'edit_product') {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$modalNumber = $_POST['modalNumber'];
		$hsnCode = $_POST['hsnCode'];

		$sqli = "UPDATE `product` SET `name` = '$name', `description` = '$description', `price` = '$price', `quantity` = '$quantity', `modalNumber` = '$modalNumber', `hsnCode` = '$hsnCode' WHERE `product`.`id` = $id";

		try {
			if ($con->query($sqli)) {
				sendResponse($_POST, true, 'Product updated successfully');
			} else {
				sendResponse([], false, 'Something went wrong while updating product');
			}
		} catch (Error $th) {
			sendResponse([], false, $th->getMessage());
		}
	} else if ($action === 'save_invoice') {
		$isValid = false;
		$invoiceID = time();
		$InvoiceData = $_POST['invoiceData'];
		$customerID = $InvoiceData["customerID"];
		$customerData = getUserByID($con, $customerID);
		$products = $InvoiceData['product'];
		$InvoiceDataJson = [
			'invoiceID' => $invoiceID,
			'InvoiceData' => $InvoiceData,
			'customerData' => $customerData
		];
		$serializedData = json_encode($InvoiceDataJson);

		$sql = "INSERT INTO `invoices` (`invoice_id`, `invoice_data`) VALUES (?, ?)";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("is", $invoiceID, $serializedData);
		if ($stmt->execute()) {
			for ($i = 1; $i < count($products); $i++) {
				$product = $products[$i];
				$productName = $product['name'];
				$quantity = $product['quantity'] != '' ? $product['quantity'] + 0 : 0;

				$productFetch = getProductByName($con, $productName);

				if ($productFetch && $productFetch[0]) {
					$productID = $productFetch[0]['id'];
					$stockQuantity = $productFetch[0]['quantity'];
					$updatedQuantity = $stockQuantity - $quantity;
					$updateSql = "UPDATE product SET quantity = '$updatedQuantity' WHERE id = $productID";
					$con->query($updateSql);
				}
			}
			sendResponse([], true, 'Invoice saved successfully');
		} else {
			sendResponse([], false, 'Something went wrong while saving invoice');
		}
	} else {
		sendResponse([], false, 'Invalid action');
	}
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
	$search = $_GET['search'];

	if ($search === 'users') {
		$query = !empty($_GET['query']) ? $_GET['query'] : ' ';
		// Use prepared statements to prevent SQL injection
		$search_query = "SELECT id, name, email,mobile FROM user WHERE name LIKE ? OR email LIKE ? OR mobile LIKE ? ORDER BY id DESC LIMIT 10 ";
		$stmt = $con->prepare($search_query);
		$likeParam = "%$query%";
		$stmt->bind_param("sss", $likeParam, $likeParam, $likeParam);
		$stmt->execute();
		$result = $stmt->get_result();
		$users = [];
		while ($row = $result->fetch_assoc()) {
			$users[] = $row;
		}
		$stmt->close();

		// Return the results as JSON
		sendResponse($users, true, 'User search successful');
	} else if ($search === 'products') {
		$query = !empty($_GET['query']) ? $_GET['query'] : ' ';
		$search_query = "SELECT id, name, modalNumber FROM product WHERE name LIKE ? OR modalNumber LIKE ? ORDER BY id DESC LIMIT 10 ";
		$stmt = $con->prepare($search_query);
		$likeParam = "%$query%";
		$stmt->bind_param("ss", $likeParam, $likeParam);
		$stmt->execute();
		$result = $stmt->get_result();
		$users = [];
		while ($row = $result->fetch_assoc()) {
			$users[] = $row;
		}
		$stmt->close();
		// Return the results as JSON
		sendResponse($users, true, 'Product search successful');
	} else {
		sendResponse([], false, 'Invalid action or missing query parameter');
	}
} else {
	sendResponse([], false, 'Invalid action');
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
function getProductByID($con, $productID = null)
{
	$id = $productID ? $productID : $_GET['id'];
	$sql = "SELECT * FROM product WHERE id = $id";
	$result = mysqli_query($con, $sql);
	$product = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$product[] = $row;
	}
	return $product;
}
function getProductByName($con, $productName = null)
{
	$name = $productName ? $productName : $_GET['name'];
	$sql = "SELECT * FROM product WHERE name = '$name'";
	$result = mysqli_query($con, $sql);
	$product = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$product[] = $row;
	}
	return $product;
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
function getUserByID($con, $userID = null)
{
	$id = $userID ? $userID : $_GET['id'];
	$sql = "SELECT * FROM user WHERE id = $id";
	$result = mysqli_query($con, $sql);
	$user = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$user[] = $row;
	}
	return $user;
}
function getAllInvoice($con)
{
	$sql = "SELECT * FROM invoices";
	$result = mysqli_query($con, $sql);
	$invoice = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$invoice[] = $row;
	}
	return $invoice;
}
function getDashboardStats($con)
{
	//Fetch Total Products count ,Total stock value,Sales this month and Total Users
	$sqli = "SELECT
    (SELECT COUNT(id) FROM product) as totalProducts,
    (SELECT SUM(quantity) FROM product) as totalStock,
    (SELECT SUM(quantity * price) FROM product) as stockValue,
    (SELECT COUNT(id) FROM user) as totalUsers,
    (SELECT COUNT(id) FROM invoices) as totalSales,
	(SELECT COUNT(id) FROM invoices WHERE MONTH(date_updated) = MONTH(NOW())) as totalSalesMonthly,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices) as totalSalesValue,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices WHERE MONTH(date_updated) = MONTH(NOW())) as totalSalesValueMonthly";

	$result = mysqli_query($con, $sqli);
	$row = mysqli_fetch_assoc($result);

	// Return the result directly
	return $row;
}
