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
                        <table id="data-tables-product" class="table table-striped" style="width:100%">
                            <thead>
                                <tr id="tableHead">
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="printElement" class="d-flex justify-content-center align-items-center">
                    <div class="border border-dark bg-transparent container w-75 m-5 p-3">
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-column w-100">
                                <div class="col-12 py-3 mx-2">
                                    <h3 id="product_title">Clasic Sheers</h3>
                                    <h6>Sr No : <span id="serial_number">123</span></h6>
                                    <h6>Price Code : <span id="price_code">B</span></h6>
                                </div>

                                <div class="col-12">
                                    <div class="row border-bottom border-dark mx-2 pb-3">
                                        <div class=" col-4 border-end border-dark">
                                            <h6><strong>Quality</strong></h6>
                                            <h6 id="quality">Sheer SRD 7505IP</h6>
                                        </div>
                                        <div class=" col-4 border-end border-dark">
                                            <h6><strong>Shade</strong></h6>
                                            <h6 id="shade">66582</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6><strong>Composition</strong></h6>
                                            <h6 id="composition">100% Polyester</h6>
                                        </div>
                                    </div>
                                    <div class="row mx-2 pt-3">
                                        <div class="col-3 border-end border-dark">
                                            <h6><strong>Weight (6SM)</strong></h6>
                                            <h6 id="weight">73</h6>
                                        </div>
                                        <div class="col-3 border-end border-dark">
                                            <h6><strong>Width (CM)</strong></h6>
                                            <h6 id="width">140</h6>
                                        </div>
                                        <div class="col-3 border-end border-dark">
                                            <h6><strong>Wash care</strong></h6>
                                            <h6 id="wash_care">
                                                <img src="img\svg_icons\fd4f95c5-7310-48b7-bbe0-dfe5270542d9.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\e3dc3ac0-9ea8-4ffa-aac3-cf1b47397aa9.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\199200b9-c34c-426f-a47c-510876190e1c.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\680da7a2-b3f4-4be9-93d4-b0d0abcc6840.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\c7c2c3c8-bf59-40c9-91ff-59e736435a2a.svg" height="20" alt="Decore" srcset="">
                                            </h6>
                                        </div>
                                        <div class="col-3">
                                            <h6><strong>End use</strong></h6>
                                            <h6 id="end_use">
                                                <img src="img\svg_icons\fd4f95c5-7310-48b7-bbe0-dfe5270542d9.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\e3dc3ac0-9ea8-4ffa-aac3-cf1b47397aa9.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\199200b9-c34c-426f-a47c-510876190e1c.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\680da7a2-b3f4-4be9-93d4-b0d0abcc6840.svg" height="20" alt="Decore" srcset="">
                                                <img src="img\svg_icons\c7c2c3c8-bf59-40c9-91ff-59e736435a2a.svg" height="20" alt="Decore" srcset="">
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row mx-2 pt-3">
                                        <div class="col-12">
                                            <p><strong id="message">Alos available in Flame Retardent (NFPA 710)</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-3 col-2 d-flex flex-column ">
                                <div class="col-3 py-3 my-3 " style="height: 8rem ; width: auto">
                                    <!-- <img src="https://via.placeholder.com/600" height="120" alt="Decore" srcset=""> -->
                                    <img src="img\logo.png" width="120" alt="Decore" srcset="">
                                </div>
                                <div class="col-3 py-3 my-3">
                                    <div class="qr-code">
                                        <!-- <img src="https://via.placeholder.com/600" height="120" alt="QR code" srcset=""> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


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
    generate("https://makends.com");

    function generate(user_input) {

        document.querySelector(".qr-code").style = "";
        //remove original
        document.querySelector(".qr-code").innerHTML = "";
        var qrcode = new QRCode(document.querySelector(".qr-code"), {
            text: `${user_input}`,
            width: 120, //128
            height: 120,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        console.log(qrcode);
    }



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

    function editDataMeta(ID) {
        event.preventDefault();
        confirm('Are you sure you want to edit this product?')
    }

    function deleteDetaMeta(ID) {
        event.preventDefault();
        confirm('Are you sure you want to Delete this product?')
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
                        if (data.type == 'checkbox') checkboxs.push(data.name);
                        tableHead.innerHTML += `<th>${data.label}</th>`;
                    })
                    tableHead.innerHTML += `<th>Action</th>`;



                    // populate table with meta tableData
                    tableData.forEach(data => {
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
                                        row[index] = `<td id="${key}">${value}</td>`;
                                    }
                                }
                            }
                        }
                        checkboxs.forEach(checkbox => {
                            const index = headData.findIndex(header => header.name === checkbox);
                            if (index !== -1) {
                                row[index] += `<td id="${checkbox}">${checkboxValues[checkbox]}</td>`;
                            }
                        });

                        row[row.length] = `
                        <td ><div class="d-flex flex-row"><button class="btn btn-primary btn-sm me-1" onclick="printData('${data.id}')">
                        <i class="fas fa-print"> </i></button><button class="btn btn-success btn-sm me-1" onclick="editDataMeta('${data.id}')">
                        <i class="fas fa-edit"></i></button>` + `<button class="btn btn-danger btn-sm me-1" onclick="deleteDetaMeta('${data.id}')"><i class="fas fa-trash"></i></button></div></td>`;

                        tableBody.innerHTML += `<tr id="${data.id}">${row.join('')}</tr>`;

                        // Insert checkbox values at their respective positions
                    });
                }

                $('#data-tables-product').DataTable();

            } else {
                console.error('Failed to fetch products:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));



    function printData(id) {
        console.log(id);
        var divToPrint = document.getElementById('printElement');
        var parent = document.getElementById(id);
        // Ittrate all elements in parent and append value to printable
        var data = [];
        for (var i = 0; i < parent.children.length; i++) {
            if (parent.children[i].id) {
                let ammend = {
                    name: parent.children[i].id,
                    value: parent.children[i].innerHTML
                };
                data.push(ammend);
            }
        }

        console.log(data);

        data.forEach(data => {
            var ammendID = `#printElement #${data.name}`;
            console.log(ammendID, data.value);
            jQuery(ammendID).html(data.value);
            if (data.name == 'qr_code') {
                generate(data.value);
            } else if (data.name == 'show_logo') {
                jQuery(ammendID).html(data.value == 'true' ? '<img src="./img/makends-dark.png" alt="Company Logo" style="float: right; max-width: 100px; height: auto; margin-right: 10px;">' : '');
            }

        });

        var footerContent = `
        <div style="position: fixed; bottom: 0; width: 100%; text-align: center; padding-top: 1rem;">
            <a href="https://makends.com" target="_blank" style="text-decoration: none;">
                <span style="color: #5d9fc5; font-weight: bold; float: left; margin-right: 10px; display: inline-block; vertical-align: middle;">makends.com</span>
            </a>
            <a href="https://makends.com" target="_blank" style="text-decoration: none;">
                <img src="./img/makends-dark.png" alt="Company Logo" style="float: right; max-width: 100px; height: auto; margin-right: 10px;">
            </a>
        </div>
    `;

        var newWin = window.open('');
        newWin.document.write(`<html><head><title>PRINT</title><link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" media='print' rel="stylesheet">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" media='all'>
    <link rel="stylesheet" href="css/style.css" media='all'></head><body>`);
        newWin.document.title = 'new';
        newWin.document.write(divToPrint.outerHTML + footerContent);
        newWin.document.write('</body></html>');
        newWin.print();
        newWin.close();
    }
</script>

</html>