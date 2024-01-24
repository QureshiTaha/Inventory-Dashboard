 <?php

$HOST = "localhost";
$USER = "root";
$PASSWORD = '';
$DBNAME = "inventory";
// $HOST = "localhost";
// $USER = "makendsc_taha";
// $PASSWORD = 'G@$F.vqbs*Xz';
// $DBNAME = "makendsc_az_db";
$con = mysqli_connect($HOST,$USER,$PASSWORD,$DBNAME);
$conn = $con;

if (mysqli_connect_errno()) {
  echo "Failed to connect to Database: " . mysqli_connect_error();
  exit();
}

$_SESSION['base-slug'] = '/inventory';


?> 