 <?php

  $configPath = __DIR__ . '/config.json';

  if (!file_exists($configPath)) {
    //redirect to Home
    header('Location: index.php');
  }
  $dbConfig = json_decode(file_get_contents($configPath), true);


  $HOST = $dbConfig['host'];
  $USER = $dbConfig['user'];
  $PASSWORD = $dbConfig['password'];
  $DBNAME = $dbConfig['dbname'];

  try {
    $con = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);
    $conn = $con;
    if (mysqli_connect_errno()) {
      echo "Failed to connect to Database: " . mysqli_connect_error();
      exit();
    }


    //GET DOMAIN

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $protocol = "https://";
    } else {
      $protocol = "http://";
    }

    $domain_ = $protocol . $_SERVER['HTTP_HOST'];

    $baseSlug = !empty($dbConfig['baseSlug']) ? $dbConfig['baseSlug'] : '/';
    $domain = !empty($dbConfig['domainName']) ? $dbConfig['domainName'] : $domain_;
    $apiURL = $domain . $baseSlug;


    $_SESSION['base-slug'] = $baseSlug;
    $_SESSION['domain'] = $domain;
    $_SESSION['api-url'] = $apiURL;
  } catch (\Throwable $th) {
    throw $th;
  }



  ?> 