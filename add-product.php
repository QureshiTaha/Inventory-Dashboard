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

    <title>Add Product</title>

    <!-- Custom fonts for this template-->
    <!-- fontawesomefreeHere -->
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
                        <h1 class="h3 mb-0 text-gray-800">Add Product</h1>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-xl-8">
                            <!-- Account details card-->
                            <div class="card mb-4">
                                <div class="card-header">Product Details</div>
                                <div class="card-body">
                                    <form id="addProduct" onsubmit="addProduct(event)">
                                        <!-- Form Row-->
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="small mb-1">Brand Name</label>
                                                <input class="form-control" id="brandName" name="brandName" placeholder="Enter Brand Name" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="productName">Product Name</label>
                                                <input class="form-control" id="productName" type="text" name="productName" placeholder="Enter Product Name" value="">
                                            </div>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="productDescription">Product Description</label>
                                                <input class="form-control" id="productDescription" type="text" name="productDescription" placeholder="Enter Product Description" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="modalNumber">Modal Number</label>
                                                <input class="form-control" id="modalNumber" type="text" name="modalNumber" placeholder="Enter Modal Number" value="">
                                            </div>


                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1">Stock Quantity</label>
                                                <input class="form-control" id="stockQuantity" oninput="this.value = this.value.replace(/\D+/g, '');" type="number" name="stockQuantity" placeholder="Enter Stock Quantity" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="productPrice">Product Price</label>
                                                <input class="form-control" id="productPrice" type="amount" oninput="this.value = this.value.replace(/\D+/g, '');" name="productPrice" placeholder="Enter Product Price" value="">
                                            </div>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="hsnCode">HSN Code</label>
                                                <input class="form-control" id="hsnCode" type="num" oninput="this.value = this.value.replace(/\D+/g, '');" name="hsnCode" placeholder="Enter HSN Code" value="">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Add Item</button>

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

    function addProduct(event) {
        event.preventDefault(); // Prevent default form submission
        // modalNumber 	name 	description 	price 	quantity
        var name = document.getElementById('productName').value;
        var description = document.getElementById('productDescription').value;
        var price = document.getElementById('productPrice').value;
        var quantity = document.getElementById('stockQuantity').value;
        var modalNumber = document.getElementById('modalNumber').value;
        var hsnCode = document.getElementById('hsnCode').value;
        var brandName = document.getElementById('brandName').value;

        var productData = {
            name,
            brandName,
            modalNumber,
            hsnCode,
            name,
            description,
            price,
            quantity
        }
        fetch('<?= $apiURL; ?>/common/function.php?action=add_product', {
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
                    console.log('Product added:', data.data);
                    myAlert.classList.remove('d-none');
                    myAlert.classList.remove('alert-danger');
                    myAlert.classList.add('alert-success');
                    document.getElementById('alertName').innerText = name;
                    document.getElementById('AlertMessage').innerText = " added successfully!";
                    document.getElementById('addProduct').reset();
                    // alert('product added successfully');
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
</script>

</html>