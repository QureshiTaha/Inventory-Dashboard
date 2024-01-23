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

    <title>User Management</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/style.css">

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
                <div class="container-fluid mb-3">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
                    </div>
                    <div class="py-3">
                        <div class="alert d-none alert-success alert-dismissible fade show" id="myAlert" role="alert">
                            <strong id="alertName">xxx</strong> <span id="AlertMessage">xxxxxxxx</span>
                            <button type="button" class="btn-close" onclick="myAlert.classList.add('d-none')" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    <table id="data-tables-users" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>address</th>
                                <th>GST No</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <span id="my-modals"></span>
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

    function deleteUser(ID) {
        event.preventDefault();
        //Aske Confirmation before deleting
        if(!confirm('Are you sure you want to delete this user?')) return


        fetch('http://localhost/Inventory/common/function.php?action=delete_user', {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: `id=${ID}`,
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    myAlert.classList.remove('d-none');
                    myAlert.classList.add('alert-success');
                    myAlert.classList.remove('alert-danger');
                    myAlert.querySelector('#alertName').textContent = 'User Deleted';
                    myAlert.querySelector('#AlertMessage').textContent = data.data;
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            })
    }

    function editUser(ID) {
        event.preventDefault();

        var name = $(`#edit-modal-${ID} #name`).val();
        var email = $(`#edit-modal-${ID} #email`).val();
        var mobile = $(`#edit-modal-${ID} #mobile`).val();
        var password = $(`#edit-modal-${ID} #password`).val();
        var role = $(`#edit-modal-${ID} #role`).val();
        var address = $(`#edit-modal-${ID} #address`).val().toString().trim();
        var tax = $(`#edit-modal-${ID} #tax`).val();



        var userData = {
            id: ID,
            name: name,
            email: email,
            mobile: mobile,
            address: address,
            tax: tax,
            password: password,
            role: role,

        }
        fetch('http://localhost/Inventory/common/function.php?action=edit_user', {
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
                    myAlert.classList.remove('d-none');
                    myAlert.classList.remove('alert-danger');
                    myAlert.classList.add('alert-success');
                    document.getElementById('alertName').innerText = name;
                    document.getElementById('AlertMessage').innerText = " updated successfully!";
                    $(`#edit-modal-${ID}`).modal('hide');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);

                    // alert('User added successfully');
                } else {
                    myAlert.classList.remove('d-none');
                    myAlert.classList.remove('alert-success');
                    myAlert.classList.add('alert-danger');
                    document.getElementById('alertName').innerText = "Error";
                    document.getElementById('AlertMessage').innerText = data.message;
                }
            })
    }
    fetch('http://localhost/Inventory/common/function.php?action=get_all_users')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the retrieved users to the table
                const tableBody = document.querySelector('#data-tables-users tbody');
                for (let index = 0; index < data.data.length; index++) {
                    const users = data.data[index];
                    const row = document.createElement('tr');
                    const newModal = document.createElement('div');
                    row.innerHTML = `
                        <td>${index +1}</td>
                        <td>${users.name}</td>
                        <td>${users.email}</td>
                        <td>${users.mobile}</td>
                        <td title="${users.address}" class="text-truncate" style="max-width: 200px;">${users.address}</td>
                        <td>${users.tax}</td>
                        <td>${users.role == '1' ? 'customer' : 'vendor'}</td>
                        <td><button type="button" class="btn bg-success-icon" data-toggle="modal" data-target="#edit-modal-${users.id}"> <i class="fas fa-edit"></i> </button>
                        <button type="button" class=" btn bg-danger-icon" onclick="deleteUser(${users.id})"> <i class="fas fa-trash"></i> </button></td>
                    `
                    tableBody.appendChild(row);

                    newModal.innerHTML = `<div class="modal fade" id="edit-modal-${users.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="edit-form-${users.id}">
                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" class="form-control" id="name" name="name" value="${users.name}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" class="form-control" id="email" name="email" value="${users.email}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="mobile">Mobile</label>
                                                                    <input type="number" oninput="this.value = this.value.replace(/\D+/g, \'\');" class="form-control" id="mobile" name="mobile" value="${users.mobile}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="small mb-1" for="tax">GST Number</label>
                                                                    <input class="form-control" id="tax" type="text" name="tax" value="${users.tax}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="small mb-1" for="address">Address</label>
                                                                    <textarea name="address" id="address" 
                                                                        rows="3"
                                                                        placeholder="Enter address"
                                                                        style="width: 100%;resize: none;"
                                                                        maxlength="200"
                                                                        oninput="this.value = this.value.slice(0, 200)"
                                                                        class="form-control">${users.address}</textarea>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="role">Role</label>
                                                                    <select class="form-control" id="role" name="role">
                                                                        <option value="1" ${users.role == '1' ? 'selected' : ''}>Customer</option>
                                                                        <option value="2" ${users.role == '2' ? 'selected' : ''}>Vendor</option>
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="editUser(${users.id})">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>`

                    jQuery("#my-modals").append(newModal);


                }

                $('#data-tables-users').DataTable();

            } else {
                console.error('Failed to fetch products:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
</script>

</html>