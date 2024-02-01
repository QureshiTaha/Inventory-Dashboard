<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrao -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Your Application</title>
</head>

<body>

    <?php
    $configPath = __DIR__ . '/common/config.json';
    $htaccessPath = __DIR__ . '/.htaccess';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = "https://";
    } else {
        $protocol = "http://";
    }

    $domain = $protocol . $_SERVER['HTTP_HOST'];
    $url =  $domain . $_SERVER['REQUEST_URI'];
    $baseSlug = "/" . basename(parse_url($url, PHP_URL_PATH)) . "/";

    // Check if the config file exists
    if (!file_exists($configPath) || !file_exists($htaccessPath)) {
        echo "<div class='container mt-5'>";
        if (isset($_GET['err']) &&  $_GET['err']) {
            echo '<div class="container" style="height: 5vh;"><div class="my-5 alert alert-danger" role="alert">' . $_GET['err'] . '</div>';
        }
        // Display modal to set database credentials
        echo '<div class="d-flex justify-content-center align-items-center " style="height: 80vh;><div class="card shadow mb-4">
        <div class="col-md-6">
        <div class="card-header py-3 text-center bg-dark">
          <h6 class="m-0 font-weight-bold text-primary">Makends Admin</h6>
        </div>
        <div class="card-body bg-light">
          <form id="configForm" onsubmit="saveDatabaseCredentials()">
            
          <div id="configForm1">
            <label class="small mb-1" for="host">Host:</label>
            <input class="form-control" type="text" id="host" name="host" value="localhost" required /><br />
      
            <label class="small mb-1" for="user">User:</label>
            <input class="form-control" type="text" id="user" name="user" value="root" required /><br />
      
            <label class="small mb-1" for="password">Password:</label>
            <input class="form-control" type="password" id="password" name="password"/><br />
      
            <label class="small mb-1" for="dbname">Database Name:</label>
            <input class="form-control" type="text" id="dbname" name="dbname" value="inventory" required /><br />
          </div>

          <div id="configForm2" style="display: none;">
            <label class="small mb-1" for="domainName">Domain Name</label>
            <input class="form-control" type="text" id="domainName" name="domainName" value="' . $domain . '" required /><br />

            <label class="small mb-1" for="baseSlug">Base Slug</label>
            <input class="form-control" type="text" id="baseSlug" name="baseSlug" value="' . $baseSlug . '" required /><br />
          </div> 
        
            
      <div class="d-flex ">
      <input id="toggle-button" class="form-control btn btn-success col-md-3 " onClick="toggleConfigForm()" type="button" value="Next" />
      <input id="submit-button" style="display: none;" class="form-control btn btn-success col-md-3 offset-md-6" type="button" onclick="saveDatabaseCredentials()" value="Save" />
      </div>
          </form>
        </div>
      </div>
      </div>
      </div>
      ';
        echo "
        <script>
        function toggleConfigForm() {
            var configForm1 = document.getElementById('configForm1');
            var configForm2 = document.getElementById('configForm2');
            var toggleButton = document.getElementById('toggle-button');
            var submitButton = document.getElementById('submit-button');

            toggleButton.value = toggleButton.value === 'Next' ? 'Back' : 'Next';

            if (configForm1.style.display === 'none') {
                configForm1.style.display = 'block';
                configForm2.style.display = 'none';
                submitButton.style.display = 'none';

            }
            else {
                configForm1.style.display = 'none';
                configForm2.style.display = 'block';
                submitButton.style.display = 'block';
            }
        }
        var currentLocation = window.location;
        var apiUrl = currentLocation.origin + currentLocation.pathname.replace(/\/[^\/]+$/, '') + '/save-credentials.php';

            var modal = document.getElementById('myModal');
            var span = document.getElementsByClassName('close')[0];
            modal.style.display = 'block';
            span.onclick = function() {
                modal.style.display = 'none';
            };
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };

            function saveDatabaseCredentials() {
                event.preventDefault();
                console.log('Form submitted');
                const formData = new FormData(document.getElementById('configForm'));

                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                    console.log();
                });

                fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        console.log('response',response);
                        return response.json(); })
                    .then(result => {
                        console.log(result);
                        console.log('Credentials saved:', result);
                       window.location.href = window.location.href;
                    })
                    .catch(error => {
                        console.error('Error saving credentials:', error);
                    });
            }
        </script>
        </div>";
    } else {
        // Config file exists, check and create tables
        checkAndCreateTables();

        // Redirect to the dashboard
        header('Location: dashboard');
        exit;
    }
    ?>

    <script>
        //document ready
        window.onload = function() {

        }
    </script>

</body>

</html>

<?php
function  checkAndCreateTables()
{
    $dbConfig = json_decode(file_get_contents(__DIR__ . '/common/config.json'), true);
    var_dump($dbConfig);

    $conn = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL statements for creating tables
    $tableStatements = [
        "activity" => "CREATE TABLE IF NOT EXISTS `activity` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `session_details` varchar(255) NOT NULL,
            `ip` varchar(255) NOT NULL,
            `activity` varchar(55) NOT NULL,
            `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
        "admin" => "CREATE TABLE IF NOT EXISTS `admin` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(70) NOT NULL,
            `password` varchar(255) NOT NULL,
            `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `name` (`name`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
        "invoices" => "CREATE TABLE IF NOT EXISTS `invoices` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `invoice_id` int(11) NOT NULL,
            `invoice_data` text NOT NULL,
            `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
            `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
        "product" => "CREATE TABLE IF NOT EXISTS `product` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `modalNumber` varchar(55) NOT NULL,
            `hsnCode` int(50) DEFAULT NULL,
            `name` varchar(255) NOT NULL,
            `description` text DEFAULT NULL,
            `price` decimal(10,2) NOT NULL,
            `quantity` int(11) NOT NULL,
            `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
        "user" => "CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `address` varchar(350) NOT NULL,
            `mobile` varchar(255) NOT NULL,
            `role` tinyint(4) NOT NULL DEFAULT 1,
            `password` varchar(255) NOT NULL,
            `tax` varchar(100) NOT NULL,
            `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
        "insertAdmin" => "INSERT INTO `admin` (`name`, `email`, `password`) VALUES ('admin', 'admin@admin.com', 'admin@123') ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `password` = VALUES(`password`);"
    ];

    // Execute SQL statements
    foreach ($tableStatements as $tableName => $sqlStatement) {
        if ($conn->query($sqlStatement) === TRUE) {
            echo "Table '$tableName' created successfully.<br>";
        } else {
            echo "Error creating table '$tableName': " . $conn->error . "<br>";
        }
    }

    $conn->close();
}

?>