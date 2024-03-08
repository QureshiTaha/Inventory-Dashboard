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
    <!-- fontawesomefreeHere -->
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

                    <div class="table-responsive">
                        <table id="data-tables-product" class="table table-striped" style="width:100%">
                            <thead>
                                <tr id="tableHead">
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="tableBody">
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
        if (confirm('Are you sure you want to delete this product?') == false) return


        fetch('<?= $apiURL; ?>/common/function.php?action=delete_product', {
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
                    myAlert.querySelector('#AlertMessage').textContent = data.message;
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
        var hsnCode = $(`#edit-modal-${ID} #hsnCode`).val();


        var productData = {
            id: ID,
            name,
            modalNumber,
            name,
            description,
            price,
            modalNumber,
            hsnCode,
            quantity
        }

        fetch('<?= $apiURL; ?>/common/function.php?action=edit_product', {
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
    fetch('<?= $apiURL; ?>common/function.php?data_action=get_deta_meta', {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: `meta_key=product`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the retrieved Products to the table
                const tableHead = document.getElementById('tableHead');
                const tableBody = document.getElementById('tableBody');
                var headData = data.data[0];
                var tableData = data.data[1];
                // console.log(tableData);
                //tableData = [
                //     {
                //         "id": "1",
                //         "field_ID": "",
                //         "meta_key": "product",
                //         "meta_value": "{\"product_title\":\"Classic Sheers\",\"serial_number\":\"28\",\"sheer\":\"SRD 750 51P\",\"shade\":\"66582\",\"wash_care-bucket\":\"bucket\",\"wash_care-iron\":\"iron\",\"wash_care-p\":\"p\",\"end_use\":\"End USE ICON\",\"weight\":\"73\",\"composition\":\"100% Polyster\",\"quantity\":\"100\",\"message\":\"Alos available in Flame Retardent (NFPA 710)\",\"qr_code\":\"www.makends.com\",\"show_logo\":\"true\"}"
                //     }
                // ]

                // set table head as key
                var checkboxs = [];

                if (headData.length > 0) {
                    headData.forEach(data => {
                        if (data.type == 'checkbox') checkboxs.push(data);
                        tableHead.innerHTML += `<th>${data.label}</th>`;
                    })

                    // populate table with meta tableData
                    tableData.forEach(data => {
                        product = JSON.parse(data.meta_value);
                        var tableKeys = Object.values(JSON.parse(data.meta_value));
                        tableKeys.forEach(key => {
                            if (key) {
                                tableBody.innerHTML += `<td>${key}</td>`;
                            }
                        })
                    })
                }

                // $('#data-tables-product').DataTable();

            } else {
                console.error('Failed to fetch products:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
</script>

</html>