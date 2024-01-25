 <?php

  $configPath = __DIR__ . '\config.json';

  if (!file_exists($configPath)) {
    //redirect to Home
    header('Location: index.php');
  }
  $dbConfig = json_decode(file_get_contents($configPath), true);

  $HOST = $dbConfig['host'];
  $USER = $dbConfig['user'];
  $PASSWORD = $dbConfig['password'];
  $DBNAME = $dbConfig['dbname'];
  // $HOST = "localhost";
  // $USER = "makendsc_taha";
  // $PASSWORD = 'G@$F.vqbs*Xz';
  // $DBNAME = "makendsc_az_db";
  try {
    $con = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);
    $conn = $con;
    if (mysqli_connect_errno()) {
      echo "Failed to connect to Database: " . mysqli_connect_error();
      exit();
    }
    $_SESSION['base-slug'] = '/inventory';
  } catch (\Throwable $th) {
    throw $th;
  }



  ?> 