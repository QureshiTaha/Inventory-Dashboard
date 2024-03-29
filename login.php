<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    header("location: /index");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Makends - Login</title>

    <!-- Custom fonts for this template-->
    <!-- fontawesomefreeHere -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" id="loginForm" onsubmit="submitLoginForm(event)">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="userEmail" placeholder="Admin Email / Username">
                                        </div>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-user" id="userPassword" placeholder="Password">
                                            <div class="input-group-append" style="border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem;">
                                                <span class="input-group-text bg toggle-password" onclick="togglePassword()">
                                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group pt-2">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                        <hr>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" integrity="sha512-ahmSZKApTDNd3gVuqL5TQ3MBTj8tL5p2tYV05Xxzcfu6/ecvt1A0j6tfudSGBVuteSoTRMqMljbfdU0g2eDNUA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        function submitLoginForm(event) {
            event.preventDefault(); // Prevent default form submission
            var email = document.getElementById('userEmail').value;
            var password = document.getElementById('userPassword').value;
            var rememberMe = document.getElementById('customCheck').checked;

            if (email.length == "") {
                alert('Please enter your email or Username');
                email.focus();
                return;
            } else if (password.length == "") {
                alert('Please enter your password');
                return;
            }

            var currentLocation = window.location;
            var apiUrl = currentLocation.origin + currentLocation.pathname.replace(/\/[^\/]+$/, '') + '/common/function.php';

            // Make an AJAX call to your PHP file
            var xhr = new XMLHttpRequest();
            xhr.open('POST', apiUrl, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Set up the data to be sent
            var data = 'email=' + encodeURIComponent(email) +
                '&password=' + encodeURIComponent(password) +
                '&rememberMe=' + rememberMe;

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    try {

                        var response = JSON.parse(xhr.responseText);

                        // Handle the response
                        if (response.success) {
                            console.log(response.message);
                            // Redirect or perform other actions for a successful login
                            window.location.href = window.location.href.replace('login', 'index');
                        } else {
                            console.error(response.message);
                            alert(response.message)
                        }
                    } catch (error) {
                        alert('An error occurred: ' + error.message);
                    }
                }
            };
            // Send the request
            xhr.send(data);
        }

        function togglePassword() {
            const passwordInput = document.getElementById('userPassword');
            const icon = document.getElementById('togglePasswordIcon');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('fa-eye-slash');
        }
    </script>

</body>

</html>