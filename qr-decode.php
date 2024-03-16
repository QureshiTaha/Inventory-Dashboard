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

    <title>Product Details - Drapes and tassels | Makends</title>

    <!-- Custom fonts for this template-->
    <!-- fontawesomefreeHere -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" media='all'>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" media='all'>
    <link rel="stylesheet" href="css/style.css" media='all'>



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
                        <table id="data-tables-product" class="table table-striped">
                            <thead>
                                <tr id="tableHead">
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>

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

<?php if (isset($_GET['id']) && $_GET['id'] > 0) { ?>

    <script>
        jQuery(document).ready(function() {
            jQuery('#accordionSidebar').hide();
            jQuery('.dropdown-item.settings').hide()


            fetch('<?= $apiURL; ?>common/function.php?data_action=get_deta_meta_by_id', {
                    method: 'POST',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    // Add id and metakey in body
                    body: `id=${<?= $_GET['id']; ?>}&meta_key=product`,
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tableHead = document.getElementById('tableHead');
                        const tableBody = document.getElementById('tableBody');

                        // var payloadObject = JSON.parse(data.data[0].meta_value);

                        var headData = data.data[0];
                        var tableData = data.data[1];
                        var checkboxs = [];
                        console.log(headData);

                        if (headData.length > 0) {
                            headData.forEach(data => {
                                if (data.type == 'checkbox') checkboxs.push(data.name);
                                tableHead.innerHTML += `<th>${data.label}</th>`;
                            })

                            // populate table with meta tableData
                            tableData.forEach(data => {
                                let productRow = {};
                                productRow['id'] = data.id;
                                product = JSON.parse(data.meta_value);
                                let row = Array.from({
                                    length: headData.length
                                }, () => ''); // Create an array with empty strings for each column
                                let checkboxValues = {};

                                checkboxs.forEach(checkbox => {
                                    checkboxValues[checkbox] = '';
                                });

                                for (const key in product) {
                                    if (Object.hasOwnProperty.call(product, key)) {
                                        const value = product[key];
                                        if (checkboxs.some(checkbox => key.includes(checkbox))) {
                                            let keyArray = key.split('-');
                                            checkboxValues[keyArray[0]] = `${checkboxValues[keyArray[0]] ? checkboxValues[keyArray[0]] + ', ' : ''}${value}`;
                                        } else {
                                            const index = headData.findIndex(header => header.name === key);
                                            if (index !== -1) {
                                                if (key == 'logo' || key == 'image') {
                                                    row[index] = `<td id="${key}"><img src="img/${value}" width="120" alt="${key}" srcset=""></td>`
                                                    productRow[key] = value;
                                                } else {
                                                    row[index] = `<td id="${key}">${value}</td>`;
                                                    productRow[key] = value;
                                                }
                                            }
                                        }
                                    }
                                }
                                checkboxs.forEach(checkbox => {
                                    const index = headData.findIndex(header => header.name === checkbox);
                                    if (index !== -1) {
                                        if (checkbox == 'end_use' || checkbox == 'wash_care') {
                                            var endUseIcons = checkboxValues[checkbox].split(',')
                                            row[index] += `<td id="${checkbox}">${
                                        endUseIcons.map(endUse => `
                                        <img src="img/svg_icons/${endUse.trim()}" height="23" alt="${endUse.trim().replace('.svg', '').replace('.png', '')}" srcset="">
                                        `).join('')
                                    }</td>`;
                                            productRow[checkbox] = checkboxValues[checkbox];

                                        } else {
                                            row[index] += `<td id="${checkbox}">${checkboxValues[checkbox]}</td>`;
                                            productRow[checkbox] = checkboxValues[checkbox];
                                        }

                                    }
                                });

                                tableBody.innerHTML += `<tr id="row_${data.id}">${row.join('')}</tr>`;

                                // Insert checkbox values at their respective positions
                            });
                        }





                    } else {
                        console.log('Error:', data.message);
                    }
                })
        })
    </script>

<?php } ?>

</html>