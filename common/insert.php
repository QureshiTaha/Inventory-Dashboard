<?php
session_start();
$baseSlug = $_SESSION['base-slug'];

if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
  header("location: qt-admin");
  print_r("EXIT");
  exit;
}
include("config.php");

print_r($_SERVER["REQUEST_METHOD"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  var_dump($_POST);

  $target_dir = "../assets/uploads/";
  $target_dir_2 = $baseSlug . "/src/assets/uploads/";
  $Randname = md5(uniqid(rand(), true));
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }


  $name =  $_POST['name'];
  $modal_number = $_POST['modal_number'];
  $description =  $_POST['description'];
  $active = '1';
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $imgurl = $target_dir_2 . $Randname . htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));



  if ($uploadOk == 0) {
    $msg =  "Sorry, your file was not uploaded." . $_FILES["fileToUpload"]["name"];
    header('location: /admin-dashboard?pop=del&msg=' . $msg);
  } else {
    // rename File before moving it
    $target_file = $target_dir . $Randname . htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    } else {
      $msg = "Sorry, there was an error uploading your Image.";
      header('location: /admin-dashboard?pop=del&msg=' . $msg);
    }
  }

  $sql = "INSERT INTO `products`(`product_name`, `imgurl`, `modal_number`, `price`, `description`, `active`,`quantity`) VALUES 
  ('$name','$imgurl','$modal_number','$price','$description','1','$quantity')";
  if ($con->query($sql)) {
    $msg = "record inserted successfully";
    header('location: /admin-dashboard?ins=ins&msg=' . $msg);
  } else {
    $msg =  "Error: " . $sql . "<br>" . $conn->error;
    header('location: /admin-dashboard?pop=del&msg=' . $msg);
  }
}
