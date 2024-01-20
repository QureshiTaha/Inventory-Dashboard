<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Makends - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        //INCLUDE SIDEBAR
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Create Invoices</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="container my-4">

                        <form id="invoiceForm">
                            <!-- Select user from searchable selector -->
                            <div class="form-group">
                                <label for="userSelect">Select User:</label>
                                <select id="userSelect" name="userSelect" class="form-control select2" required>
                                    <!-- Populate options dynamically using JavaScript -->
                                    <option value="3">Dummy</option>
                                    <option value="2">alan</option>
                                    <option value="1">zay</option>
                                </select>
                            </div>

                            <!-- Add product with quantity -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="productSelect">Select Product:</label>
                                    <select id="productSelect" name="productSelect" class="form-control select2" required>
                                        <!-- Populate options dynamically using JavaScript -->
                                        <option value="3">Dummy</option>
                                        <option value="2">Dummy1</option>
                                        <option value="1">Dummy2</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-primary btn-block" onclick="addProduct()">Add Product</button>
                                </div>
                            </div>

                            <!-- Table to display added products -->
                            <table id="invoiceTable" class="table table-bordered">
                                <!-- Table headers -->
                                <thead class="thead-light">
                                    <tr>
                                        <th>SR. NO</th>
                                        <th>Product Name</th>
                                        <th>Modal Number</th>
                                        <th>Quantity</th>
                                        <th>Price per Unit</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <!-- Table body will be populated dynamically -->
                                <tbody></tbody>
                            </table>

                            <!-- Additional fields -->
                            <div class="form-group">
                                <label for="subtotal">Sub Total:</label>
                                <span id="subtotal" class="form-control-plaintext">0.00</span>
                            </div>

                            <div class="form-group">
                                <label for="tax">TAX @ 18.0%:</label>
                                <span id="tax" class="form-control-plaintext">0.00</span>
                            </div>

                            <div class="form-group">
                                <label for="total">Total ₹:</label>
                                <span id="total" class="form-control-plaintext">0.00</span>
                            </div>

                            <div class="form-group">
                                <label for="received">Received ₹:</label>
                                <input type="number" id="received" name="received" class="form-control" min="0" value="0" step="0.01" required>
                            </div>

                            <div class="form-group">
                                <label for="balance">Balance ₹:</label>
                                <span id="balance" class="form-control-plaintext">0.00</span>
                            </div>

                            <!-- Submit button -->
                            <input type="submit" class="btn btn-success" value="Submit Invoice">
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('./common/footer.php'); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <script>
        // Initialize Select2 for searchable selects
        jQuery(document).ready(function() {
            jQuery('.select2').select2();
        });

        function addProduct() {

        }

        function searchUsers(query) {
        $.ajax({
            url: 'functions.php',
            method: 'GET',
            data: { query: query },
            dataType: 'json',
            success: function (data) {
                // Update the user select options dynamically
                var userSelect = $('#userSelect');
                userSelect.empty();
                $.each(data, function (index, user) {
                    userSelect.append('<option value="' + user.id + '">' + user.name + ' (' + user.email + ')</option>');
                });
            },
            error: function () {
                console.log('Error in user search AJAX');
            }
        });
    }
    </script>



</body>

</html>