 <?php

  ini_set('display_errors', 'off');
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
  function getAllInvoiceWithFilter($con, $filterBy = "")
  {
    $sql = "SELECT * FROM invoices $filterBy";
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
	  (SELECT COUNT(id) FROM invoices WHERE MONTH(date_created) = MONTH(NOW())) as totalSalesMonthly,
	  (SELECT COUNT(id) FROM invoices WHERE YEAR(date_created) = YEAR(NOW())) as totalSalesYearly,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices) as totalSalesValue,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices WHERE MONTH(date_created) = MONTH(NOW())) as totalSalesValueMonthly,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices WHERE YEAR(date_created) = YEAR(NOW())) as totalSalesValueYearly";

    $result = mysqli_query($con, $sqli);
    $row = mysqli_fetch_assoc($result);

    // Return the result directly
    return $row;
  }

  function getFilteredStats($con, $filterBy = "")
  {
    //Fetch Total Products count ,Total stock value,Sales filter by weekly,monthly yearly
    $filterCondition = "";
    switch ($filterBy) {
      case "daily":
        $filterCondition = "WHERE DATE(date_created) = DATE(NOW())";
        break;
      case "weekly":
        $filterCondition = "WHERE WEEK(date_created) = WEEK(NOW())";
        break;
      case "monthly":
        $filterCondition = "WHERE MONTH(date_created) = MONTH(NOW())";
        break;
      case "yearly":
        $filterCondition = "WHERE YEAR(date_created) = YEAR(NOW())";
        break;
      case "isTaxable":
        $filterCondition = "WHERE JSON_EXTRACT(invoice_data, '$.InvoiceData.isTaxable') = 'true'";
        break;
      case "isNotTaxable":
        $filterCondition = "WHERE JSON_EXTRACT(invoice_data, '$.InvoiceData.isTaxable') = 'false'";
        break;
      default:
        break;
    }

    $sqli = "SELECT
    (SELECT COUNT(id) FROM product) as totalProducts,
    (SELECT SUM(quantity) FROM product) as totalStock,
    (SELECT SUM(quantity * price) FROM product) as stockValue,
    (SELECT COUNT(id) FROM user) as totalUsers,
    (SELECT COUNT(id) FROM invoices) as totalSales,
    (SELECT COUNT(id) FROM invoices $filterCondition) as totalSalesFiltered,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices) as totalSalesValue,
    (SELECT COALESCE(SUM(JSON_EXTRACT(invoice_data, '$.InvoiceData.total')), 0) FROM invoices $filterCondition) as totalSalesValueFiltered";

    $result = mysqli_query($con, $sqli);
    $row = mysqli_fetch_assoc($result);
    // Return the result directly
    return $row;
    // echo $sqli;
  }
  // Common Functions End

  ?> 