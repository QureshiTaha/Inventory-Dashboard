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
                        <h1 class="h3 mb-0 text-gray-800">All Invoices</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->


                    <div class="py-3">
                        <div class="alert d-none alert-success alert-dismissible fade show" id="myAlert" role="alert">
                            <strong id="alertName">xxx</strong> <span id="AlertMessage">xxxxxxxx</span>
                            <button type="button" class="btn-close" onclick="myAlert.classList.add('d-none')" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="">

                        <table id="data-tables-invoices" class="table  table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Invoice ID</th>
                                    <th>Customer Name</th>
                                    <th>Invoice Type</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                    <!-- Content Row -->



                </div>
                <!-- /.container-fluid -->
                <span id="my-modals"></span>
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
        // function printData() {
        //     var divToPrint = document.getElementById("printable-invoice");
        //     newWin = window.open("");
        //     newWin.document.write(divToPrint.outerHTML);
        //     // Add html footer to every page

        //     newWin.print();
        //     newWin.close();
        // }

        function printData(id) {
            console.log(id);
            var divToPrint = document.getElementById(id);
            var footerContent = `
                    <div style="position: fixed; bottom: 0; width: 100%; text-align: center; padding-top: 1rem;">
                    <a href="https://makends.com" target="_blank" style="text-decoration: none;"><span style="color: #5d9fc5; font-weight: bold;float: left; margin-right: 10px; display: inline-block; vertical-align: middle;">makends.com</span></a>
                    <a href="https://makends.com" target="_blank" style="text-decoration: none;">
                    <img src="./img/makends-dark.png" alt="Company Logo" style="float: right; max-width: 100px; height: auto; margin-right: 10px;">
                    </a>
                    </div>
                `;

            // var newWin = window.open("");
            var newWin = window.open('');
            newWin.document.write('<title>Invoice</title>');
            newWin.document.title = '#' + (id).slice(id.length - 18, id.length);
            newWin.document.write(divToPrint.outerHTML + footerContent);
            var styles = `<style>
                        @media print {
                    .printable-invoice {
                        width: 100%;
                    }
                    .container {
                        max-width: 100%;
                    }
                    .row {
                        display: flex;
                        flex-wrap: wrap;
                    }
                    .col-md-6 {
                        flex: 0 0 50%;
                        max-width: 50%;
                    }
                    .col-md-12 {
                        flex: 0 0 100%;
                        max-width: 100%;
                    }
                    .text-right {
                        text-align: right;
                    }
                    img.logo {
                        max-width: 100%;
                        height: auto;
                    }
                    /* Add more styles as needed */

                    /* tr:odd */
                    .table tbody tr:nth-of-type(odd) {
                        background-color: #f8f9fa;
                    }
                    
                    .invoice-footer {
                        position: fixed;
                        bottom: 0;
                        width: 100%;
                        text-align: center;
                        padding-top: 1rem;
                    }
                }</style>`;
            newWin.document.write(styles);

            newWin.print();
            newWin.close();
        }


        function convertToIndianWords(amount) {
            const units = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
            const teens = ['eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
            const tens = ['', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
            const scales = ['', 'thousand', 'lakh', 'crore'];

            function convertToWordsLessThanThousand(n) {
                if (n < 10) {
                    return units[n];
                } else if (n < 20) {
                    return teens[n - 11];
                } else if (n < 100) {
                    return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? ' ' + units[n % 10] : '');
                } else {
                    return units[Math.floor(n / 100)] + ' hundred' + (n % 100 !== 0 ? ' and ' + convertToWordsLessThanThousand(n % 100) : '');
                }
            }

            function convertAmountToWords(amount) {
                let wholePart = Math.floor(amount);
                const decimalPart = Math.round((amount - wholePart) * 100); // considering up to two decimal places

                const wholeWords = convertToWordsLessThanThousand(wholePart);
                const decimalWords = decimalPart > 0 ? 'and ' + convertToWordsLessThanThousand(decimalPart) + ' paise' : '';

                if (wholeWords === 'zero') {
                    return 'zero rupees only';
                }

                const words = [];
                let scaleIndex = 0;

                while (wholePart > 0) {
                    const chunk = wholePart % 1000;
                    if (chunk !== 0) {
                        words.unshift(convertToWordsLessThanThousand(chunk) + ' ' + scales[scaleIndex]);
                    }
                    wholePart = Math.floor(wholePart / 1000);
                    scaleIndex++;
                }

                return words.join(' ') + ' rupees ' + decimalWords + ' only';
            }

            return convertAmountToWords(amount);
        }

        fetch('<?= $apiURL; ?>/common/function.php?action=get_all_invoice')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add the retrieved Invoices to the table
                    const tableBody = document.querySelector('#data-tables-invoices tbody');
                    for (let index = 0; index < data.data.length; index++) {
                        const Invoices = data.data[index];
                        const InvoiceData = JSON.parse(Invoices.invoice_data);
                        const productData = InvoiceData.InvoiceData.product.length ? InvoiceData.InvoiceData.product : [];
                        const customerData = InvoiceData.customerData.length ? InvoiceData.customerData[0] : {};
                        const totalInWords = convertToIndianWords(parseFloat(InvoiceData.InvoiceData.total).toFixed(2));
                        const row = document.createElement('tr');
                        const newModal = document.createElement('div');
                        console.log(productData.map((item) => item.quantity).reduce((a, b) => parseFloat(a) ? a : 0 + parseFloat(b) ? b : 0));
                        newModal.innerHTML = `
                        <div class="modal fade bd-example-modal-lg" id="modal-${Invoices.invoice_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Invoice #${Invoices.invoice_id}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="printable-invoice-${Invoices.invoice_id}" class="printable-invoice card-body">
                                    <div style="margin-bottom: 2rem; margin-top: 3rem;" class="container">
                                            <div class="row">
                                                <div style="text-align: left;" class="col-md-6">
                                                    <p style="color: #000000; font-size: 20px; margin: 0; padding: 0;">
                                                        <strong>COCOBERRY</strong>
                                                    </p>
                                                    <p style="color: #7e8d9f; font-size: 15px; margin: 0; padding: 0;">
                                                        GROUND FLOOR 5981/2 FACTORY ROAD New Delhi <br />Phone no.: 9599618843 <br />Email: cocoberry.db@gmail.com <br />GSTIN: 07AMEPA7702M1Z4 <br />State: 07-Delhi
                                                    </p>
                                                </div>
                                                <div style="text-align: right;" class="col-md-6">
                                                    <div>
                                                        <img src="./img/cocoberry-dark-square.png" class="img-fluid" alt="logo" width="100" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                            <div style="margin: 0; padding: 0;" class="container">
                                            ${ InvoiceData?.InvoiceData?.isTaxable == "true"? `
                                                <div class="col-md-12 mb-3">
                                                    <div style="text-align: center;">
                                                        <strong>
                                                            <span style="color: #5d9fc5; font-size: 2em; margin-left: 0;">Tax Invoice</span>
                                                        </strong>
                                                    </div>
                                                </div>
                                                            ` : `
                                                            <div class="col-md-12 mb-3">
                                                    <div style="text-align: center;">
                                                        <strong>
                                                            <span style="color: #5d9fc5; font-size: 2em; margin-left: 0;">Delevery Chalan</span>
                                                        </strong>
                                                    </div>
                                                </div>
                                                            ` }
                                                <div style="width: 100%;" class="row">
                                                    <div style="width: 50%; text-align: left;">
                                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                            <li style="color: #000000;">
                                                                To: <span style="color: #5d9fc5;"><strong>${customerData.name}</strong></span>
                                                            </li>
                                                            <li style="color: #000000;">${customerData.address}</li>
                                                            <li style="color: #000000;"><i class="fas fa-phone"></i> ${customerData.mobile}</li>
                                                            <li style="color: #000000;">GSTIN Number: ${customerData.tax}</li>
                                                        </ul>
                                                    </div>
                                                    <div style="width: 50%; text-align: right;">
                                                    <!-- <p style="color: #000000; margin: 0; padding: 0;">Invoice</p> -->
                                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                            <li style="color: #000000;">
                                                                <span >Invoice No: ${Invoices.invoice_id}</span>
                                                            </li>
                                                            <!-- <li style="color: #000000;">
                                                                <span >Creation Date: ${new Date(Invoices.date_updated).toISOString().slice(0, 10)}</span>
                                                            </li> -->
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div style="justify-content: center; margin: 4em 1em 2em 1em ; " class="row">
                                                    <table style="margin: 50px 0px; width: 100%; border-collapse: collapse; margin-top: 1em;" class="table table-striped table-borderless">
                                                        <thead style="background-color: #84b0ca; color: white;">
                                                            ${productData.length > 0 ? `
                                                            <tr>
                                                                <th style="padding: 0.55em;">SR.<br>NO</th>
                                                                <th style="padding: 0.75em;">Product Name</th>
                                                                <th style="padding: 0.75em;">Modal Number</th>
                                                                ${ InvoiceData?.InvoiceData?.isTaxable == "true"? `<th style="padding: 0.75em;">HSN Code</th>`:``}
                                                                <th style="padding: 0.75em;">Quantity</th>
                                                                <th style="padding: 0.75em;">Price Per Unit</th>
                                                                <th style="padding: 0.75em;">Amount</th>
                                                            </tr>
                                                            ` : ''}
                                                        </thead>
                                                        <tbody style="">
                                                            ${productData.map((item, index) => index != 0 ? `
                                                            <tr>
                                                                <td style="padding: 0.75em;">${item.id}</td>
                                                                <td style="padding: 0.75em;">${item.name}</td>
                                                                <td style="padding: 0.75em;">${item.ModalNumber}</td>
                                                                ${ InvoiceData?.InvoiceData?.isTaxable == "true"? `<td style="padding: 0.75em;">${item.hsnCode || "-"}</td>`:``}
                                                                <td style="padding: 0.75em;">${item.quantity}</td>
                                                                <td style="padding: 0.75em;">₹ ${item.PricePerUnit}</td>
                                                                <td style="padding: 0.75em;">₹ ${item.amount}</td>
                                                            </tr>
                                                            ` : "").join('')}

                                                            <tr style="background-color: #f2f2f2; border-top: 1px solid black;">
                                                                <td style="padding: 0.75em;"></td>
                                                                <td style="padding: 0.75em;"></td>
                                                                ${ InvoiceData?.InvoiceData?.isTaxable == "true"? `<td style="padding: 0.75em;"></td>`:``}
                                                                <td style="padding: 0.75em;">Total Items</td>
                                                                <td style="padding: 0.75em;">${productData.map((item) => item.quantity).reduce((a, b) => (parseFloat(a) ? parseFloat(a) : 0) + (parseFloat(b) ? parseFloat(b) : 0))}</td>
                                                                <td style="padding: 0.75em;">Total Amount</td>
                                                                <td style=" padding: 0.75em;">₹ ${productData.map((item) => item.amount).reduce((a, b) => (parseFloat(a) ? parseFloat(a) : 0) + (parseFloat(b) ? parseFloat(b) : 0))}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <hr />
                                                <div style="margin: 0; padding: 0; display: flex; justify-content: space-between;" class="row">
                                                    <div style="width: 65%;">
                                                        <span style="font-size: 18px;" class="fs-1">INVOICE AMOUNT IN WORDS</span>
                                                        <p style="font-size: 15px; background-color: #f2f2f2; margin: 0; padding: 0;" class="text-muted text-uppercase">
                                                            ${totalInWords.toLocaleUpperCase()}
                                                        </p>
                                                        <span style="font-size: 18px;" class="fs-1">TERMS AND CONDITIONS</span>
                                                        <p style="font-size: 15px; background-color: #f2f2f2; margin: 0; padding: 0;" class="text-muted">
                                                            1. No Guarantee No Exchange No Claim<br />2. Goods once Sold will not be taken back<br />3. All Disputes are Subject to Delhi Jurisdiction<br />4. Interest @ 24 will be charged if the bill is not paid within 7 days
                                                        </p>
                                                        <p style="font-size: 18px; margin-top: 1em; padding: 0;" class="text-muted">
                                                            <strong>Pay To-</strong>
                                                        </p>
                                                        <p style="font-size: 15px; margin: 0; padding: 0;" class="fs-1">
                                                            <strong>Bank Name:</strong> State Bank Of India, Mumbai Central, Mumbai<br />
                                                            <strong>Bank Account No.:</strong> 41427644038<br />
                                                            <strong>Bank IFSC code:</strong> SBIN0000547<br />
                                                            <strong>Account Holder's Name:</strong> COCOBERRY
                                                        </p>
                                                    </div>
                                                    <div style="width: 34%; text-align: right;">
                                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                            <li style="color: #000000; ">SubTotal : ₹ ${InvoiceData.InvoiceData.subTotal}</li>
                                                            <li style="color: #000000; ">Additional Charge : ₹ ${InvoiceData.InvoiceData.additionalCharge ? InvoiceData?.InvoiceData?.additionalCharge:0}</li>
                                                            ${ InvoiceData?.InvoiceData?.isTaxable == "true"? `
                                                            <li style="color: #000000; margin-left: 3em;">GSTIN (18%) ₹ ${(InvoiceData.InvoiceData.subTotal * 0.18).toFixed(2)}</li>
                                                            ` : `` }
                                                            <li style="color: #000000; ">Received : ₹ ${InvoiceData.InvoiceData.received ? InvoiceData?.InvoiceData?.received:0}</li>
                                                            <hr />
                                                            <p style="color: #000000; float: right;">
                                                            <span style="margin-right: 1em;">Total Amount</span><span style="font-size: 20px;"><strong>₹ ${InvoiceData.InvoiceData.total}</strong></span>
                                                            <span style="margin-right: 1em;">Balance</span><span style="font-size: 20px;"><strong>₹ ${parseFloat(InvoiceData.InvoiceData.total- (InvoiceData.InvoiceData.received ? InvoiceData?.InvoiceData?.received:0)).toFixed(2)}</strong></span>
                                                            </p>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div style="display: flex; justify-content: space-between;" class="row">
                                                    <div style="width: 75%;">
                                                        <p><strong>For, COCOBERRY </strong></p>
                                                    </div>
                                                    <div style="width: 25%;">
                                                        <img src="./img/cocoberry-invoice-sign.png" alt="Authorized Signatory" style="max-width: 100%;" />
                                                        <p><strong>Authorized Signatory</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a onclick="printData('printable-invoice-${Invoices.invoice_id}')" class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i
                                    class="fas fa-print text-primary"></i> Print</a>
                                </div>
                            </div>
                        </div>`;
                        const cell = document.createElement('td');
                        cell.innerHTML = index + 1;
                        row.appendChild(cell);

                        const cell1 = document.createElement('td');
                        cell1.innerHTML = Invoices.invoice_id;
                        row.appendChild(cell1);

                        const cell2 = document.createElement('td');
                        cell2.innerHTML = customerData.name;
                        row.appendChild(cell2);

                        const cell3 = document.createElement('td');
                        cell3.innerHTML = customerData.name;
                        row.appendChild(cell3);

                        const cell4 = document.createElement('td');
                        cell4.innerHTML = InvoiceData.InvoiceData.isTaxable == "true" ? "Taxable" : "Non Taxable";
                        row.appendChild(cell4);

                        const cell5 = document.createElement('td');
                        cell5.innerHTML = Invoices.date_updated;
                        row.appendChild(cell5);

                        const cell6 = document.createElement('td');
                        cell6.innerHTML = `
                        <td><button type="button" class="btn bg-success-icon" data-toggle="modal" data-target="#modal-${Invoices.invoice_id}"> <i class="fas fa-eye"></i> </button>
                    `;
                        row.appendChild(cell6);

                        tableBody.appendChild(row);

                        jQuery("#my-modals").append(newModal);
                    }
                    $('#data-tables-invoices').DataTable();
                }
            });
    </script>



</body>

</html>