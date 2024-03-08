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


  // Common Functions
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
  function getAdminByID($con, $userID = null)
  {
    $id = $userID ? $userID : $_GET['id'];
    $sql = "SELECT * FROM admin WHERE id = $id";
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

  function getAllFields($con)
  {
    $sql = "SELECT * FROM fields";
    $result = mysqli_query($con, $sql);
    $fields = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $fields[] = $row;
    }

    return $fields;
  }

  function getAllCustomFields($con)
  {
    $sql = "SELECT * FROM custom_fields";
    $result = mysqli_query($con, $sql);
    $fields = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $fields[] = $row;
    }

    return $fields;
  }


  function getAllCustomFieldsByEntityType($con, $entity_type)
  {
    $sql = "SELECT * FROM custom_fields WHERE entity_type = '$entity_type' order by `priority` asc";
    $result = mysqli_query($con, $sql);
    $fields = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $fields[] = $row;
    }

    return $fields;
  }

  function deleteCustomField($con, $id)
  {
    $sql = "DELETE FROM fields WHERE id = '$id'";
    mysqli_query($con, $sql);

    return true;
  }

  function deleteCustomFieldType($con, $id)
  {
    $sql = "DELETE FROM custom_fields WHERE entity_id = '$id'";
    mysqli_query($con, $sql);

    return true;
  }

  function AddDataMeta($con, $metaKey, $metaValue)
  {
    $sql = "INSERT INTO data_meta (`meta_key`,`meta_value`) VALUES ('" . $metaKey . "','" . $metaValue . "')";
    mysqli_query($con, $sql);
    return true;
  }

  function getDataMetaByKey($con, $metaKey){
    $sql = "SELECT * FROM data_meta WHERE meta_key = '$metaKey'";
    $result = mysqli_query($con, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }

    return $data;
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

  // Common Functions End

  ?> 