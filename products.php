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

    <title>Product Management</title>

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
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Product Management</h1>
                    </div>
                    <div class="py-3">
                        <div class="alert d-none alert-success alert-dismissible fade show" id="myAlert" role="alert">
                            <strong id="alertName">xxx</strong> <span id="AlertMessage">xxxxxss</span>
                            <button type="button" class="btn-close" onclick="myAlert.classList.add('d-none')" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    <table id="data-tables-product" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Product Modal Number</th>
                                <th>Product price</th>
                                <th>Stock Quantity</th>
                                <th>Product Action</th>
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

    function deleteProduct(ID) {
        event.preventDefault();
        //Aske Confirmation before deleting
        return confirm('Are you sure you want to delete this product?');


        fetch('http://localhost/Inventory/common/function.php?action=delete_product', {
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
                    myAlert.querySelector('#alertName').textContent = 'Product Deleted';
                    myAlert.querySelector('#AlertMessage').textContent = data.data;
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            })
    }

    function editProduct(ID) {
        event.preventDefault();

        var name = $(`#edit-modal-${ID} #productName`).val();
        var modalNumber = $(`#edit-modal-${ID} #productModalNumber`).val();
        var description = $(`#edit-modal-${ID} #productDescription`).val();
        var price = $(`#edit-modal-${ID} #productPrice`).val();
        var quantity = $(`#edit-modal-${ID} #productQuantity`).val();


        var productData = {
            id: ID,
            name,
            modalNumber,
            name,
            description,
            price,
            modalNumber,
            quantity
        }

        fetch('http://localhost/Inventory/common/function.php?action=edit_product', {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: Object.entries(productData).map(([k, v]) => {
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

                    // alert('product added successfully');
                } else {
                    myAlert.classList.remove('d-none');
                    myAlert.classList.remove('alert-success');
                    myAlert.classList.add('alert-danger');
                    document.getElementById('alertName').innerText = "Error";
                    document.getElementById('AlertMessage').innerText = data.message;
                }
            })
    }
    fetch('http://localhost/Inventory/common/function.php?action=get_all_products')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the retrieved Products to the table
                const tableBody = document.querySelector('#data-tables-product tbody');
                for (let index = 0; index < data.data.length; index++) {
                    const product = data.data[index];
                    const row = document.createElement('tr');
                    const newModal = document.createElement('div');
                    row.innerHTML = `
                        <td>${index+1}</td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>${product.modalNumber}</td>
                        <td>${product.price}</td>
                        <td>${product.quantity}</td>
                        <td><button type="button" class="btn bg-success-icon" data-toggle="modal" data-target="#edit-modal-${product.id}"> <i class="fas fa-edit"></i> </button>
                        <button type="button" class=" btn bg-danger-icon" onclick="deleteProduct(${product.id})"> <i class="fas fa-trash"></i> </button></td>
                    `
                    tableBody.appendChild(row);

                    newModal.innerHTML = `<div class="modal fade" id="edit-modal-${product.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">EditPproduct</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="edit-form-${product.id}">
                                                                <div class="form-group">
                                                                    <label for="productName">Product Name</label>
                                                                    <input type="text" class="form-control" id="productName" value="${product.name}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="productDescription">Product Description</label>
                                                                    <input type="text" class="form-control" id="productDescription" value="${product.description}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="productModalNumber">Product Modal Number</label>
                                                                    <input type="text" class="form-control" id="productModalNumber" value="${product.modalNumber}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="productPrice">Product Price</label>
                                                                    <input type="number" class="form-control" id="productPrice" value="${product.price}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="productQuantity">Product Quantity</label>
                                                                    <input type="number" class="form-control" id="productQuantity" value="${product.quantity}">
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="editProduct(${product.id})">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>`

                    jQuery("#my-modals").append(newModal);


                }

                $('#data-tables-product').DataTable();

            } else {
                console.error('Failed to fetch products:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
</script>

</html>