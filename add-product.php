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

                                        <div id="formData" class="row gx-3 mb-3">
                                        </div>

                                        <button class="btn btn-primary" type="submit">Add Product</button>

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

    jQuery(document).ready(function() {
        // get_all_custom_field_entity_type
        fetch('<?= $apiURL; ?>/common/function.php?fields=&&action=get_all_custom_field_entity_type&&entityType=product', {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Custom Fields:', data.data);
                    // [{
                    //         "id": "45",
                    //         "field_id": "9",
                    //         "priority": "0",
                    //         "entity_type": "product",
                    //         "entity_id": "field_1709805559634",
                    //         "label": "SR. No",
                    //         "name": "serial_number",
                    //         "type": "number",
                    //         "options": "",
                    //         "created_at": "2024-03-07 15:30:27"
                    //     },
                    //     ...
                    // ]
                    // append to form
                    // var addToform = data.data;
                    if (typeof(data.data) == 'object') {
                        data.data.forEach(addToform => {
                            var payload = '';
                            if (addToform.type == 'radio') {
                                options = addToform.options.split('\n');
                                payload += `
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1">${addToform.label}</label>                 
                                        <div class=" d-flex flex-row ">`
                                options.forEach(option => {
                                    optionSplit = option.split(':');
                                    payload += `
                                    <div class="form-check col-md-3">
                                            <input class="form-check-input" id="${addToform.name}" type="${addToform.type}" name="${addToform.name}" value="${optionSplit[0]}">
                                            <label class="form-check-label" for="${addToform.name}">${optionSplit[1]}</label></div>`
                                });
                                payload += `</div></div>`
                            } else if (addToform.type == 'checkbox') {
                                options = addToform.options.split('\n');
                                payload += `
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1">${addToform.label}</label>
                                        <div class=" d-flex flex-row ">`
                                options.forEach(option => {
                                    optionSplit = option.split(':');
                                    payload += `
                                    <div class="form-check col-md-3">
                                            <input class="form-check-input" id="${addToform.name}" type="${addToform.type}" name="${addToform.name+"-"+optionSplit[0]}" value="${optionSplit[0]}">
                                            <label class="form-check-label" for="${addToform.name}">${optionSplit[1]}</label></div>`
                                });
                                payload += `</div></div>`;
                            } else {
                                payload += `<div class="col-md-6 mb-3">
                                <label class="small mb-1">${addToform.label}</label>
                                <input class="form-control ${addToform.id}" id="${addToform.name}" type="${addToform.type}" name="${addToform.name}" placeholder="${addToform.label}" value="">
                                </div>`;
                            }
                            document.getElementById('formData').innerHTML += payload;
                        })
                    }

                } else {
                    console.log('Error:', data.message);
                }
            })
    })

    function addProduct(e) {
        e.preventDefault();
        var form = new FormData(e.target);
        // set checkbox value to string name:value
        // let checkbox = '';
        // let checkboxName = '';
        // form.forEach((value, name) => {
        //     if (name.includes('[]')) {
        //         console.log(name, value);
        //         checkbox += `${name.replace('[]', '')}:${value},`;
        //         checkboxName = name;
        //         index = index + 1;
        //     }
        // })
        // form.delete(checkboxName);
        // form.set(`${checkboxName.replace('[]', '')}`, checkbox);

        form = Object.fromEntries(form);

        var submitForm = {
            meta_key: 'product',
            meta_value: JSON.stringify(form)
        }

        fetch('<?= $apiURL; ?>/common/function.php?data_action=add_deta_meta', {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: Object.entries(submitForm).map(([k, v]) => {
                    return k + '=' + v
                }).join('&'),
            })
            .then(response => response.json())
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

    };
</script>

</html>