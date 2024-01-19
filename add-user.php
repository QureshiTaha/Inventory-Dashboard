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

    <title>Add User</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

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
                        <h1 class="h3 mb-0 text-gray-800">Add User</h1>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-xl-8">
                            <!-- Account details card-->
                            <div class="card mb-4">
                                <div class="card-header">Account Details</div>
                                <div class="card-body">
                                    <form id="addUser" onsubmit="addUser(event)">
                                        <!-- Form Row-->
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (first name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="name">Full Name</label>
                                                <input class="form-control" id="name" type="text" name="name" placeholder="Enter full name" value="">
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control" id="email" type="email" name="email" placeholder="Enter Email" value="">
                                            </div>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (first name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="mobile">Mobile</label>
                                                <input class="form-control" id="mobile" type="numeric" oninput="this.value = this.value.replace(/\D+/g, '');" name="mobile" placeholder="Enter Mobile number" value="">
                                            </div>
                                            <!-- Form Group (last name)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input class="form-control" id="password" type="text" name="password" placeholder="Enter password" value="">
                                            </div>
                                        </div>
                                        <!-- Form Group (Roles)-->
                                        <div class="mb-3">
                                            <label class="small mb-1">Role</label>
                                            <select class="form-select" id="role" aria-label="Default select example">
                                                <option value="1">Customer</option>
                                                <option value="2">Vendor</option>
                                            </select>
                                        </div>
                                        <!-- Submit button-->
                                        <button class="btn btn-primary" type="submit">Add user</button>

                                    </form>
                                    <div class="py-3">
                                        <div class="alert d-none alert-success alert-dismissible fade show" id="myAlert" role="alert">
                                            <strong id="alertName"></strong> <span id="AlertMessage"></span>
                                            <button type="button" class="btn-close p-3" onclick="myAlert.classList.add('d-none')" data-bs-dismiss="alert" aria-label="Close"></button>
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
<script>
    var myAlert = document.getElementById('myAlert');

    function addUser(event) {
        event.preventDefault(); // Prevent default form submission
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var mobile = document.getElementById('mobile').value;
        var password = document.getElementById('password').value;
        var role = document.getElementById('role').value;

        var userData = {
            name: name,
            email: email,
            mobile: mobile,
            password: password,
            role: role
        }
        fetch('http://localhost/Inventory/common/function.php?action=add_user', {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: Object.entries(userData).map(([k, v]) => {
                    return k + '=' + v
                }).join('&'),
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('User added:', data.data);
                    myAlert.classList.remove('d-none');
                    myAlert.classList.remove('alert-danger');
                    myAlert.classList.add('alert-success');
                    document.getElementById('alertName').innerText = name;
                    document.getElementById('AlertMessage').innerText = " added successfully!";
                    document.getElementById('addUser').reset();
                    // alert('User added successfully');
                } else {
                    console.log('Error:', data.message);
                    myAlert.classList.remove('d-none');
                    myAlert.classList.remove('alert-success');
                    myAlert.classList.add('alert-danger');
                    document.getElementById('alertName').innerText = "Error";
                    document.getElementById('AlertMessage').innerText = data.message;
                }
            })
    }
    // fetch('http://localhost/Inventory/common/function.php?action=get_all_users')
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //             console.log('Users retrieved:', data.data);
    //             // Process the retrieved users here

    //             // Add the retrieved users to the table
    //             const tableBody = document.querySelector('#data-tables-users tbody');
    //             for (let index = 0; index < data.data.length; index++) {
    //                 const users = data.data[index];
    //                 console.log(users);
    //                 const row = document.createElement('tr');
    //                 row.innerHTML = `
    //                     <td>${index}</td>
    //                     <td>${users.name}</td>
    //                     <td>${users.email}</td>
    //                     <td>${users.mobile}</td>
    //                     <td>${users.role == '1' ? 'customer' : 'vendor'}</td>
    //                 `
    //                 tableBody.appendChild(row);

    //             }

    //             $('#data-tables-users').DataTable();

    //         } else {
    //             console.error('Failed to fetch products:', data.message);
    //         }
    //     })
    //     .catch(error => console.error('Error:', error));
</script>

</html>