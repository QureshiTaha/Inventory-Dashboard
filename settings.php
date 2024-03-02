<?php
?>
<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Settings</title>

    <!-- Custom fonts for this template-->
    <!-- fontawesomefreeHere -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body id="page-top">
    <style>
        .nav-tabs>li {
            float: left;
            margin-bottom: -1px;
        }

        .nav>li {
            position: relative;
            display: block;
        }

        .bg-f2 {
            background-color: #f2f2f2;
        }

        .nav-tabs>li.active>a,
        .nav-tabs>li.active>a:focus,
        .nav-tabs>li.active>a:hover {
            color: #555;
            cursor: default;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-bottom-color: rgb(221, 221, 221);
            border-bottom-color: transparent;
        }

        .nav-tabs>li>a {
            margin-right: 2px;
            line-height: 1.42857143;
            border: 1px solid transparent;
            border-radius: 4px 4px 0 0;
        }

        .nav>li>a {
            text-decoration: none;
            position: relative;
            display: block;
            padding: 10px 15px;
        }
    </style>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include('./common/sidebar.php');
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include('./common/topbar.php');
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Admin Settings</h1>
                        <?php
                        // Fetch USER DATA
                        // $conn 
                        $ID =  $_SESSION['id'];
                        $sql = "SELECT * FROM admin WHERE id =  '" . $ID . "'";
                        $user = $conn->query($sql)->fetch_assoc();

                        ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-xl-8">
                            <!-- Account details card-->
                            <div class="card mb-4 ">


                                <div id="exTab2" class=" ">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a href="#1" data-toggle="tab">Profile</a>
                                        </li>
                                        <li class="active"><a href="#2" data-toggle="tab">Advance</a>
                                        </li>
                                        <li><a href="#3" data-toggle="tab">credits</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content  p-2 bg-f2">
                                        <div class="tab-pane" id="1">
                                            <div class="container">
                                                <h3>Profile Settings</h3>
                                                <?php
                                                if (isset($_POST['submit'])) {
                                                    // Validate the input
                                                    $id = $_POST['id'];
                                                    $password = $_POST['password'];
                                                    $name = $_POST['name'];
                                                    $email = $_POST['email'];

                                                    // Update the password in the database
                                                    $sql = "UPDATE admin SET password = '$password', name = '$name', email = '$email' WHERE id = $id";

                                                    if ($conn->query($sql) === TRUE) {

                                                        // UPDATE session
                                                        $_SESSION['username'] = $name;
                                                        $_SESSION['email'] = $email;

                                                        echo '
                                                        <div class="">
                                                            <div class="alert alert-success alert-dismissible fade show" id="myAlertSuccess" role="alert">
                                                                <strong id="alertName">Admin</strong> <span id="AlertMessage">Updated Successfully</span>
                                                                <button type="button" class="btn-close p-3" onclick="myAlertSuccess.classList.add(\'d-none\')" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                        ';
                                                    } else {
                                                        echo '
                                                        <div class="">
                                                            <div class="alert alert-danger alert-dismissible fade show" id="myAlertDanger" role="alert">
                                                                <strong id="alertName">Admin</strong> <span id="AlertMessage">Updated Fail</span>
                                                                <button type="button" class="btn-close p-3" onclick="myAlertDanger.classList.add(\'d-none\')" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                        ';
                                                    }
                                                    //wait 2 sec and reload window
                                                    echo '<script>setTimeout(function(){ window.location.href = window.location.href; }, 2000);</script>';
                                                }
                                                ?>

                                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" value="<?= $user['name']; ?>" name="name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" value="<?= $user['email']; ?>" name="email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <!-- Toggle password View js script-->
                                                        <div class="input-group mb-3">
                                                            <input type="password" class="form-control" id="password" value="<?= $user['password']; ?>" name="password">
                                                            <div class="input-group-append" style="border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem;">
                                                                <span class="input-group-text bg toggle-password" onclick="togglePassword()">
                                                                    <i id="togglePasswordIcon" class="fa fa-eye-slash "></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            function togglePassword() {
                                                                const passwordInput = document.getElementById('password');
                                                                const icon = document.getElementById('togglePasswordIcon');
                                                                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                                                passwordInput.setAttribute('type', type);
                                                                if (type === "password") {
                                                                    icon.classList.add("fa-eye-slash");
                                                                    icon.classList.remove("fa-eye");
                                                                } else {
                                                                    icon.classList.add("fa-eye");
                                                                    icon.classList.remove("fa-eye-slash");
                                                                }
                                                            }
                                                        </script>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>

                                        <?php
                                        // var_dump($con);
                                        $user = getAdminByID($con, 1);
                                        // var_dump($user[0]);
                                        $adminMeta = json_decode($user[0]['admin_meta'], true) ? json_decode($user[0]['admin_meta'], true) : array();

                                        /* $adminMeta = {
                                            "companyName": "makends",
                                            "companyAddress": "348 lokhandwala building ground floor Flat no 8G bapty road, mumbai, Maharashtra 400008",
                                            "taxName": "GSTIN",
                                            "taxID": "07AMEPA7702M1Z4",
                                            "email": "07AMEPA7702M1Z4",
                                            "contact": "9326239256",
                                            "termsAndConditions": "1. Terms 1 |2. Terms 2 |3. Terms 3 |4.Terms 4",
                                            "bankName": "State Bank Of India, Mumbai Central, Mumbai",
                                            "bankAccountNumber": "41427644038",
                                            "accountHolderName": "COCOBERRY",
                                            "logoPath": "/img/cocoberry-dark-square.png",
                                            "signPath": "/img/cocoberry-invoice-sign.png"
                                          } */


                                        // var_dump($adminMeta);


                                        ?>


                                        <div class="tab-pane active" id="2">
                                            <!-- Advance Settings -->
                                            <div class="container">
                                                <h3>Advance Settings</h3>
                                                <?php
                                                if ($_SESSION['id'] != 1) {
                                                ?>
                                                    <p>
                                                        <i class="fas fa-exclamation-triangle "></i>
                                                        This feature is not available
                                                    </p>
                                                <?php
                                                } else {
                                                ?>
                                                    <form class="">
                                                        <div class="form-group">
                                                            <!-- TODO : Add Advance Settings -->
                                                        </div>
                                                    </form>

                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="3">
                                            <div class="container">
                                                <h1>Credits</h1>
                                                <!-- Credits Section Start -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <div class="card-body">
                                                                <h5 class="card-title"></h5>
                                                                <!-- With supporting text below as a natural lead-in to additional content. -->
                                                                <p class="card-text">
                                                                    Build with love by <a href="https://makend.com" class="">Makend Team.</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Credits Section END -->
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <?php

            include('./common/footer.php');
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
</body>

</html>