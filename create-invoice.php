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
    <!-- fontawesomefreeHere -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/select-2.css">

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
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="container my-4">
                        <form id="invoiceForm">
                            <div class="form-group">
                                <div class="p-0 m-0 col-md-3 col-sm-12">
                                    <label for="invoiceType">Tax Invoice:</label>
                                    <select id="invoiceType" name="userSelect" class="form-control">
                                        <option value="2" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12 m-0 p-0">
                                <div class="form-group">
                                    <label for="userSelect">Select User:</label>
                                    <select id="userSelect" name="userSelect" class="form-control select2" required>
                                    </select>
                                </div>
                            </div>

                            <!-- Add product with quantity -->
                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="productSelect">Select Product:</label>
                                    <select id="productSelect" name="productSelect" class="form-control select2" required>
                                    </select>
                                </div>

                                <div class="form-group col-md-2 col-sm-12">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" oninput="this.value = this.value.replace(/\D+/g, '');" id="quantity" max="0" name="quantity" class="form-control" value="0" required>
                                </div>

                                <div class="form-group col-md-2 col-sm-12">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-primary btn-block" onclick="addProduct()">Add Product</button>
                                </div>
                            </div>

                            <!-- Table to display added products -->
                            <div class="table-responsive">
                            <table id="invoiceTable" class="table" >
                                <!-- Table headers -->
                                <thead class="thead-light">
                                    <tr>
                                        <th>SR. NO</th>
                                        <th>Product Name</th>
                                        <th>Modal Number</th>
                                        <th>Quantity</th>
                                        <th>Price per Unit</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- Table body will be populated dynamically -->
                                <tbody id="invoiceTableBody"></tbody>
                            </table>
                            </div>

                            <hr>
                            <div class="d-flex align-items-end justify-content-end text-right">
                                <div class="col-md-12 form-group ">
                                    <div class="form-group text-right">
                                        <div class="form-group">
                                            <label for="subtotal">Sub Total:</label>
                                            <span id="subTotal" class="form-control-plaintext">0.00</span>
                                        </div>

                                        <div class="tax-group form-group">
                                            <label for="tax">GST @ 18.0%:</label>
                                            <span id="tax" class="form-control-plaintext">0.00</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="total">Total ₹:</label>
                                            <span id="grandTotal" class="form-control-plaintext">0.00</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex align-items-end justify-content-end text-right">
                                        <div class="col-md-12 form-group ">
                                            <div class="form-group text-left">
                                                <label>Additional Charges</label>
                                                <div class="form-group row">
                                                    <div class="form-group p-2 col-md-3">
                                                        <label for="additionalItem">Additional Item</label>
                                                        <input type="text" id="additionalItem" name="additionalItem" placeholder="Enter Item" class="form-control">
                                                    </div>
                                                    <div class="form-group p-2 col-md-3">
                                                        <label for="additionalCharge">Amount ₹:</label>
                                                        <input type="number" id="additionalCharge" name="additionalCharge" class="form-control" min="0" value="0" step="0.10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                    <div class="form-group p-2 col-md-3">
                                                        <label>&nbsp;</label>
                                                        <button type="button" class="btn btn-primary btn-block" onclick="addAdditionalCharge()">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group text-left">
                                        <div class="form-group col-md-6">
                                            <label for="received">Received ₹:</label>
                                            <!-- allow float -->
                                            <input type="number" id="received" name="received" class="form-control" min="0" value="0" step="0.10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="balance">Balance ₹:</label>
                                            <span id="balance" class="form-control-plaintext">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit button -->
                        </form>
                        <div class="col-md-3 col-sm-12">
                            <button onclick="generateInvoice()" class=" btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Invoice</button>
                        </div>
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
        async function addProduct() {
            var productSelect = document.getElementById('productSelect');
            var productID = productSelect.options[productSelect.selectedIndex].value;
            var productData = await addProductByID(productID);
            //reset all inputs
            // jQuery('#productSelect').val(null).trigger('change');
            // jQuery('#quantity').val("");
        }

        async function getProductByID(productID) {
            return await fetch("<?= $apiURL; ?>/common/function.php?action=get_product_by_id&id=" + productID)
                .then(response => response.json())
                .then(data => data.data[0]);
        }

        //productSelect onchange set the min and max quantity
        jQuery('#productSelect').on('change', async function() {
            var productSelect = document.getElementById('productSelect');
            var productID = productSelect.options[productSelect.selectedIndex].value;
            var productData = await getProductByID(productID);
            var quantity = productData.quantity;

            if (quantity > 0) {
                jQuery('#quantity').attr('min', 1);
                jQuery('#quantity').attr('max', quantity);
            } else {
                jQuery('#quantity').attr('min', 0);
                jQuery('#quantity').attr('max', 0);
            }
        })

        //on change quantity set it to its max if greater then max
        jQuery('#quantity').on('input', function() {
            var quantity = parseInt(jQuery('#quantity').val());
            if (quantity > parseInt(jQuery('#quantity').attr('max'))) {
                jQuery('#quantity').val(jQuery('#quantity').attr('max'));
            }
            //Check if any item already in table loop through table 
            var invoiceTable = document.getElementById('invoiceTable');
            var quantityInTable = 0;
            if (invoiceTable.rows.length > 1) {
                for (var i = 1; i < invoiceTable.rows.length; i++) {
                    //check with Product Name [modalNumber]
                    var row = invoiceTable.rows[i];
                    var productString = jQuery('#productSelect').text().trim();
                    var productName = productString.substring(0, productString.indexOf("[")).trim().toLocaleLowerCase();
                    if (row.cells[1].firstChild.textContent.trim().toLocaleLowerCase() == productName.trim().toLocaleLowerCase()) {
                        //increment quantity
                        quantityInTable += parseInt(row.cells[3].firstChild.textContent);
                    }
                }

                if (quantityInTable + quantity > parseInt(jQuery('#quantity').attr('max'))) {
                    jQuery('#quantity').val(jQuery('#quantity').attr('max') - quantityInTable);
                }
            }


        })

        function updateAllData() {
            //wait 200 ms
            setTimeout(function() {
                var subTotal = 0;
                var tax = 0;
                var grandTotal = 0;
                var invoiceTable = document.getElementById('invoiceTable');
                if (invoiceTable.rows.length > 1) {
                    for (var i = 1; i < invoiceTable.rows.length; i++) {
                        var row = invoiceTable.rows[i];
                        var price = parseFloat(row.cells[4].firstChild.textContent);
                        var total = parseFloat(row.cells[5].firstChild.textContent);
                        subTotal = subTotal + total;
                        tax = isTaxInvoice() ? parseFloat(subTotal) * 0.18 : 0;
                        grandTotal = parseFloat(subTotal) + parseFloat(tax);

                        jQuery('#subTotal').html(parseFloat(subTotal).toFixed(2).toString());
                        jQuery('#tax').html(parseFloat(tax).toFixed(2).toString());
                        jQuery('#grandTotal').html(parseFloat(grandTotal).toFixed(2).toString());

                        var received = jQuery('#received').val();
                        balance = grandTotal - received;
                        jQuery('#balance').html(parseFloat(balance).toFixed(2).toString());
                    }
                } else {
                    console.log('empty table');
                    jQuery('#subTotal').html("0.00");
                    jQuery('#tax').html("0.00");
                    jQuery('#grandTotal').html("0.00");
                    jQuery('#balance').html("0.00");
                }
                //reset all inputs
                jQuery('#quantity').val("");
                jQuery('#additionalCharge').val("");
                jQuery('#additionalItem').val("");
            }, 100);

        }

        function generateInvoice() {
            event.preventDefault();
            //Check Is user Selected
            var userSelect = jQuery('#userSelect');
            if (!userSelect.val()) {
                alert('Please Select User');
                userSelect.focus();
                return;
            }
            //Check Is Sub Total
            var subTotal = jQuery('#subTotal');
            if (subTotal.text() == "0.00") {
                alert('Please Add Product');
            }

            $customerID = jQuery('#userSelect').val();
            // create all Products in table IN JSON format 
            var product = [];
            var productTable = document.getElementById('invoiceTable');

            for (var i = 0; i < productTable.rows.length; i++) {
                product[i] = {
                    id: productTable.rows[i].cells[0].firstChild.textContent,
                    name: productTable.rows[i].cells[1].firstChild.textContent,
                    ModalNumber: productTable.rows[i].cells[2]?.firstChild?.textContent ? productTable.rows[i].cells[2].firstChild.textContent : "",
                    quantity: productTable.rows[i].cells[3]?.firstChild?.textContent ? productTable.rows[i].cells[3].firstChild.textContent : "",
                    PricePerUnit: productTable.rows[i].cells[4].firstChild.textContent,
                    amount: productTable.rows[i].cells[5].firstChild.textContent
                }
            }

            // subTotal
            var subTotal = jQuery('#subTotal').text();
            var total = jQuery('#grandTotal').text();
            var received = jQuery('#received').val();
            var balance = jQuery('#balance').text();
            var isTaxable = isTaxInvoice();

            var invoiceData = {
                customerID: $customerID,
                subTotal: subTotal,
                total: total,
                received: received,
                balance: balance,
                isTaxable: isTaxable,
                product: product
            }

            // save_invoice
            jQuery.ajax({
                url: "<?= $apiURL; ?>/common/function.php?action=save_invoice",
                method: "POST",
                data: {
                    invoiceData: invoiceData
                }

            }).done(function(data) {
                alert('Invoice Created Successfully');
                window.location.reload();
                // reload
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);

            })



        }

        function addAdditionalCharge() {
            var additionalCharge = jQuery('#additionalCharge');
            var additionalItem = jQuery('#additionalItem');

            //Add in table Create new roe
            var invoiceTable = document.getElementById('invoiceTable');

            var row = document.createElement('tr');
            var cell1 = document.createElement('td');
            var cell2 = document.createElement('td');
            var cell3 = document.createElement('td');
            var cell4 = document.createElement('td');
            var cell5 = document.createElement('td');
            var cell6 = document.createElement('td');
            var removeButtonTD = document.createElement('td');
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn', 'btn-danger');
            removeButton.innerText = 'X';
            removeButton.addEventListener('click', function() {
                row.remove();
                var index = document.getElementById('invoiceTable').rows.length;
                for (var i = 0; i < index; i++) {
                    document.getElementById('invoiceTable').rows[i].cells[0].innerText = i + 1
                }
            })

            var index = document.getElementById('invoiceTable').rows.length;

            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.innerHTML = 'Remove';

            removeButton.onclick = function() {
                invoiceTable.deleteRow(row.rowIndex);
                updateAllData();
            }

            cell1.innerText = index;
            cell2.innerText = additionalItem.val();
            cell3.innerText = "";
            cell4.innerText = "";
            cell5.innerText = parseFloat(additionalCharge.val()).toFixed(2);
            cell6.innerText = parseFloat(additionalCharge.val()).toFixed(2);


            row.appendChild(cell1);
            row.appendChild(cell2);
            row.appendChild(cell3);
            row.appendChild(cell4);
            row.appendChild(cell5);
            row.appendChild(cell6);
            row.appendChild(removeButtonTD);

            document.getElementById('invoiceTableBody').appendChild(row);
            removeButtonTD.appendChild(removeButton);


            //Update Sub Total
            var subTotal = document.getElementById('subTotal');
            subTotal.value = parseFloat(subTotal.value) + parseFloat(additionalCharge.value)

            var grandTotal = document.getElementById('grandTotal');
            grandTotal.value = parseFloat(subTotal.value) + parseFloat(additionalCharge.value)

            updateAllData();

        }

        const isTaxInvoice = () => {
            var invoiceType = jQuery("#invoiceType");
            if (invoiceType.val() == 1) {
                return true
            } else {
                return false
            }
        }


        async function addProductByID(id) {
            fetch("<?= $apiURL; ?>/common/function.php?action=get_product_by_id&id=" + id)
                .then(response => response.json())
                .then(data => {
                    var product = data.data[0];
                    var quantityInput = document.getElementById('quantity');
                    var quantity = quantityInput.value;
                    var row = document.createElement('tr');

                    var cell1 = document.createElement('td');
                    var cell2 = document.createElement('td');
                    var cell3 = document.createElement('td');
                    var cell4 = document.createElement('td');
                    var cell5 = document.createElement('td');
                    var cell6 = document.createElement('td');
                    var removeButtonTD = document.createElement('td');
                    var removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.classList.add('btn', 'btn-danger');
                    removeButton.innerText = 'X';
                    removeButton.addEventListener('click', function() {
                        row.remove();
                        var index = document.getElementById('invoiceTable').rows.length;
                        for (var i = 0; i < index; i++) {
                            document.getElementById('invoiceTable').rows[i].cells[0].innerText = i + 1
                        }
                        updateAllData();
                    })

                    var index = document.getElementById('invoiceTable').rows.length;

                    cell1.innerText = index;
                    cell2.innerText = product.name;
                    cell3.innerText = product.modalNumber;
                    cell4.innerText = quantity;
                    cell5.innerText = product.price;
                    cell6.innerText = (product.price * quantity);


                    row.appendChild(cell1);
                    row.appendChild(cell2);
                    row.appendChild(cell3);
                    row.appendChild(cell4);
                    row.appendChild(cell5);
                    row.appendChild(cell6);
                    row.appendChild(removeButtonTD);

                    document.getElementById('invoiceTableBody').appendChild(row);
                    removeButtonTD.appendChild(removeButton);
                    updateAllData();

                    return;
                })
        }
        jQuery(document).ready(function() {
            isTaxInvoice() ? jQuery('.tax-group').show() : jQuery('.tax-group').hide();

            jQuery('#invoiceType').change(function() {
                isTaxInvoice() ? jQuery('.tax-group').show() : jQuery('.tax-group').hide();
                updateAllData();
            })
            jQuery('#userSelect').select2({
                ajax: {
                    url: "<?= $apiURL; ?>/common/function.php",
                    cache: true,
                    dataType: 'json',
                    method: 'GET',
                    data: function(params) {
                        var query = {
                            query: params.term,
                            search: "users",
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: (data.data || []).map(function(user) {
                                return {
                                    id: user.id,
                                    text: user.name + ' [' + user.email + ']' + ' [' + user.mobile + ']',

                                }
                            })
                        }
                    }
                }
            });

            jQuery('#productSelect').select2({
                ajax: {
                    url: "<?= $apiURL; ?>/common/function.php",
                    cache: true,
                    dataType: 'json',
                    method: 'GET',
                    data: function(params) {
                        var query = {
                            query: params.term,
                            search: "products",
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: (data.data || []).map(function(product) {
                                return {
                                    id: product.id,
                                    text: product.name + ' [' + product.modalNumber + ']',
                                }
                            })
                        }
                    }


                }
            })



            jQuery("#invoiceTableBody").change(function() {
                updateAllData()
            })


            jQuery('#received').on('input', function() {
                var balance = parseFloat(document.getElementById('grandTotal').textContent);
                var received = jQuery('#received').val();
                balance = balance - received;
                jQuery('#balance').html(parseFloat(balance).toFixed(2).toString());
            })
        });
    </script>



</body>

</html>