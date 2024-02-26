<!DOCTYPE html>
<html lang="en">
<?php $filter = isset($_GET['filter']) ? $_GET['filter'] : ""; ?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoices | Makends - Dashboard</title>

    <!-- Custom fonts for this template-->
    <!-- fontawesomefreeHere -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <!-- Custom styles for this template-->
    <!-- <link rel="stylesheet" media="all" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link media="all" href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .table td,
        .table th {
            text-align: left;
        }
    </style>


</head>
<style>
    .modal-dialog.modal-lg {
        max-width: 70%;
    }

    tr,
    td,
    th {
        text-align: center;
        vertical-align: middle;

    }

    /* Responsive for tablet and phone */
    @media only screen and (max-width: 600px) {
        .modal-dialog.modal-lg {
            max-width: 100%;
        }
    }
</style>

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
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sales</div>
                                            <div class="h5 font-weight-bold text-gray-800"><span id="totalSales">0</span></div>
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sales <?= $filter ? $filter : "All" ?></div>
                                            <div class="h5 font-weight-bold text-gray-800"><span id="totalSalesFiltered">0</span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-inr fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
                        <div class="alert d-none alert-success alert-dismissible fade show" id="myAlert" role="alert">
                            <strong id="alertName">xxx</strong> <span id="AlertMessage">xxxxxxxx</span>
                            <button type="button" class="btn-close" onclick="myAlert.classList.add('d-none')" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="makends-custom-select py-2">
                        <select class="form-select" onchange="location = '?filter=' + this.value;">
                            <option value="">All</option>
                            <option <?= $filter == "daily" ? "selected" : "" ?> value="daily">Daily</option>
                            <option <?= $filter == "monthly" ? "selected" : "" ?> value="monthly">Monthly</option>
                            <option <?= $filter == "yearly" ? "selected" : "" ?> value="yearly">Yearly</option>
                            <option <?= $filter == "weekly" ? "selected" : "" ?> value="weekly">Weekly</option>
                            <option <?= $filter == "isTaxable" ? "selected" : "" ?> value="isTaxable">isTaxable</option>
                            <option <?= $filter == "isNotTaxable" ? "selected" : "" ?> value="isNotTaxable">isNotTaxable</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table id="data-tables-invoices" class="table  table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Invoice ID</th>
                                    <th>Customer Name</th>
                                    <th>Invoice Type</th>
                                    <th>Date</th>
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
        function toInvoiceNumber(nr, n = 3, str) {
            return Array(n - String(nr).length + 1).join(str || '0') + nr;
        }

        function _printData(id) {
            var HTML_Width = jQuery("#" + id).width();
            var HTML_Height = jQuery("#" + id).height();
            var top_left_margin = 10;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas(jQuery("#" + id)[0]).then(function(canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4), canvas_image_width, canvas_image_height);
                }
                var name = '#' + (id).slice(id.length - 18, id.length) + '.pdf';
                pdf.save(name);
                // jQuery("#"+id).hide();
            });
        }

        function printData(id) {
            console.log(id);
            var divToPrint = document.getElementById(id);
            var headerContent = `
            <head>
            <meta name="viewport" content="width =device-width, initial-scale=1.0">
            <link rel="stylesheet" media="print" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
            <link rel="stylesheet" media="print" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" type="text/css" media="print"/>
            
            </head>
            `;
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
            newWin.document.title = '#invoice' + (id).replace('printable-invoice', '');
            newWin.document.write(headerContent + divToPrint.outerHTML + footerContent);
            var styles = `<style>
                        @media print {
                    .printable-invoice {
                        width: 100%;
                    }
                    bode {
                        font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                        line-height: 1.5;
                    }
                    tr, td, th {
                        text-align: center;
                        vertical-align: middle;
                    }
                    hr {
                        border-top: 1px solid rgba(0,0,0,.1) !important;
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

        function formatDate(d) {
            date = new Date(d)
            var day, month, year;

            year = date.getFullYear();
            month = date.getMonth() + 1;
            day = date.getDate();

            if (month < 10) {
                month = '0' + month;
            }

            if (day < 10) {
                day = '0' + day;
            }
            // 2013-01-08

            return year + '-' + month + '-' + day
        }

        function updateInvoice(id) {
            var InvoiceID = jQuery(`#invoiveID-${toInvoiceNumber(id)}`).val();
            var InvoiceDate = jQuery(`#invoiveDate-${toInvoiceNumber(id)}`).val();
            console.log(id, InvoiceID, InvoiceDate);
            // Ajax post on action edit_invoice

            var InvoiceData = {
                id,
                InvoiceID,
                InvoiceDate
            }

            fetch('<?= $apiURL; ?>/common/function.php?action=edit_invoice', {
                    method: 'POST',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    body: Object.entries(InvoiceData).map(([k, v]) => {
                        return k + '=' + v
                    }).join('&'),
                }).then(response => response.json())
                .then(data => {
                    console.log(data);
                    alert(data.message)
                    if (data.success) {
                        window.location.reload();
                    }
                })

        }
        <?php
        // $filter = $_GET['filter'] ? $_GET['filter'] : "";

        $filterQuery;

        switch ($filter) {
            case 'daily':
                // Filter for the current day
                $filterQuery = "WHERE DATE(date_created) = CURRENT_DATE()";
                break;
            case 'month':
                // Filter for the current month
                $filterQuery = "WHERE MONTH(date_created) = MONTH(CURRENT_DATE()) AND YEAR(date_created) = YEAR(CURRENT_DATE())";
                break;
            case 'weekly':
                // Filter for the current week
                $filterQuery = "WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_DATE())";
                break;
            case 'yearly':
                // Filter for the current year
                $filterQuery = "WHERE YEAR(date_created) = YEAR(CURRENT_DATE())";
                break;
            case 'isTaxable':
                // Filter for invoices with isTaxable = true in InvoiceData JSON
                $filterQuery = "WHERE JSON_EXTRACT(invoice_data, \'$.InvoiceData.isTaxable\') = \'true\'";
                break;
            case 'isNotTaxable':
                // Filter for invoices with isTaxable = false in InvoiceData JSON
                $filterQuery = "WHERE JSON_EXTRACT (invoice_data, \'$.InvoiceData.isTaxable\') = \'false\'";
                break;
            default:
                $filterQuery = "";
                break;
        }


        ?>
        fetch('<?= $apiURL; ?>common/function.php?action=filtered_stats&filterQuery=<?= $filter; ?>')
        .then(response => {
            return response.json()
        })
        .then(data => {
            console.log("dta",data);
            if (data.success) {
                // Add the retrieved Invoices the stats box
                const totalSales = data.data.totalSales;
                const totalSalesValue = data.data.totalSalesValue;
                const totalSalesFiltered = data.data.totalSalesFiltered;
                $("#totalSales").text(totalSales ? totalSales : 0);
                $("#totalSalesValue").text(totalSalesValue ? totalSalesValue : 0);
                $("#totalSalesFiltered").text(totalSalesFiltered ? totalSalesFiltered : 0);

            }
        })


        fetch('<?= $apiURL; ?>/common/function.php?action=get_all_invoice&&filterQuery=<?= $filterQuery; ?>')
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
                        <div class="modal fade " id="edit-modal-${toInvoiceNumber(Invoices.id)}" tabindex="-2" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Invoice #${toInvoiceNumber(Invoices.id)}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="padding: 0;">
                                        <form onSumbit="return false">
                                            <div id="edit-invoice-${toInvoiceNumber(Invoices.id)}" class="edit-invoice card-body">
                                                <div class="form-group">
                                                    <label for="invoiveID-${toInvoiceNumber(Invoices.id)}">Invoice Number </label>
                                                    <input type="number" value="${toInvoiceNumber(Invoices.id)}" id="invoiveID-${toInvoiceNumber(Invoices.id)}" name="invoiveID-${toInvoiceNumber(Invoices.id)}" class="form-control" min="0">
                                                </div>
                                                <div class="form-group">
                                                    <label for="invoiveDate-${toInvoiceNumber(Invoices.id)}">Invoice Date </label>
                                                    <input type="date" value="${formatDate(Invoices.date_created)}" id="invoiveDate-${toInvoiceNumber(Invoices.id)}" name="invoiveDate-${toInvoiceNumber(Invoices.id)}" class="form-control" min="0">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    <input class="btn btn-primary" onClick="updateInvoice(${toInvoiceNumber(Invoices.id)})" type="submit" value="update">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade bd-example-modal-lg" id="modal-${toInvoiceNumber(Invoices.id)}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Invoice #${toInvoiceNumber(Invoices.id)}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="padding: 0;">
                                    <div id="printable-invoice-${toInvoiceNumber(Invoices.id)}" class="printable-invoice card-body">
                                    <div class="container">
                                    <header >
                                    <div style="margin: 0; padding: 0.75em;background-color:#f2f2f2; align-items: center; display: flex; justify-content: space-between;">
                                    <div class="row" style="justify-content: left;">
                                    <div style="margin-left: 20px"><span style="color: #000000; font-size: 20px; margin: 0; padding: 0;"><strong>COCOBERRY</strong></span></div>
                                    </div>
                                    <div class="row" style="background-color:#f2f2f2; justify-content: right;">
                                    <div style="margin-right: 20px"><span style="color: #7e8d9f; font-size: 15px; margin: 0; padding: 0;"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp; GROUND FLOOR 5981/2 FACTORY ROAD New Delhi</span></div>
                                    <div style="margin-right: 20px"><span style="color: #7e8d9f; font-size: 15px; margin: 0; padding: 0;"> <i class="fas fa-phone"></i>&nbsp;&nbsp;9599618843 </span></div>
                                    <div style="margin-right: 20px"><span style="color: #7e8d9f; font-size: 15px; margin: 0; padding: 0;"> <i class="fas fa-envelope "></i>&nbsp;&nbsp;cocoberry.db@gmail.com </span></div>
                                    </div>
                                    </header>
                                            <div class="row" style="margin: 0; padding: 0; align-items: center;">
                                                <div style="text-align: left;" class="col-md-6">
                                                    <p style="color: #7e8d9f; font-size: 15px; margin: 0; padding: 0;">
                                                       GSTIN: 07AMEPA7702M1Z4 <br />State: 07-Delhi
                                                    </p>
                                                </div>
                                                <div style="text-align: right;" class="col-md-6">
                                                    <div>
                                                        <img src="./img/cocoberry-dark-square-white.png" class="img-fluid" alt="logo" width="100" />
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
                                                <div style="width: 100%; display: flex; justify-content: space-between;">
                                                    <div style="width: 50%; text-align: left;">
                                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                            <li style="color: #000000;">
                                                                To: <span style="color: #5d9fc5;"><strong>${customerData.name}</strong></span>
                                                            </li>
                                                            <li style="color: #000000;"><b>${customerData.address}</b></li>
                                                            <li style="color: #000000;">Contact:<b> ${customerData.mobile}</b></li>
                                                            <li style="color: #000000;">STATE: <b>${customerData.state}</b></li>
                                                            <li style="color: #000000;">GSTIN : <b> ${customerData.tax}</b></li>
                                                        </ul>
                                                    </div>
                                                    <div style="width: 50%; text-align: right;">
                                                    <!-- <p style="color: #000000; margin: 0; padding: 0;">Invoice</p> -->
                                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                            <li style="color: #000000;">
                                                                <span >Invoice No:<b> ${toInvoiceNumber(Invoices.id)} </b></span>
                                                            </li>
                                                            <li style="color: #000000;">
                                                                <span >Invoice Date:<b> ${formatDate(Invoices.date_created)} </b></span>
                                                            </li>
                                                            <!-- <li style="color: #000000;">
                                                                <span >Creation Date:  ${new Date(Invoices.date_created).toISOString().slice(0, 10)}</span>
                                                            </li> -->
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div style="justify-content: center; margin: 20px 5px 20px 5px ; " class="row">
                                                    <table style="margin: 50px 0px; width: 100%; border-collapse: collapse; margin-top: 1em;" class="table table-striped table-bordered">
                                                        <thead style="background-color: #84b0ca; color: white;">
                                                            ${productData.length > 0 ? `
                                                            <tr>
                                                                <th style="padding: 0.55em;">SR.<br>NO</th>
                                                                <th style="padding: 0.55em;">Brand Name</th>
                                                                <th style="padding: 0.75em;">Modal Number</th>
                                                                <th style="padding: 0.75em;">Product Name</th>
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
                                                                <td style="padding: 0.75em;">${item.brandName}</td>
                                                                <td style="padding: 0.75em;">${item.ModalNumber}</td>
                                                                <td style="padding: 0.75em;">${item.name}</td>
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
                                                                <td style="padding: 0.75em;"></td>
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
                                                    <p style="font-size: 18px; margin-top: 1em; padding: 0;" >
                                                            <strong>Pay To-</strong>
                                                        </p>
                                                        <p style="font-size: 15px; margin: 0; padding: 0;">
                                                        ${ InvoiceData?.InvoiceData?.isTaxable == "true" ? `
                                                            <strong>Bank Name:</strong> State Bank Of India, Mumbai Central, Mumbai<br />
                                                            <strong>Bank Account No.:</strong> 41427644038<br />
                                                            <strong>Bank IFSC code:</strong> SBIN0000547<br />
                                                            <strong>Account Holder's Name:</strong> COCOBERRY
                                                            ` : `
                                                            <strong>Bank Name:</strong> HDFC Bank <br />
                                                            <strong>Bank Account No.:</strong> 00601000268749<br />
                                                            <strong>Bank IFSC code:</strong> HDFC0000060<br />
                                                            <strong>Account Holder's Name:</strong> Akram S Selia
                                                            <strong>Branch Code:</strong> 0060
                                                            ` }
                                                            
                                                        </p>
                                                        <br>
                                                        <span style="font-size: 18px;" >INVOICE AMOUNT IN WORDS</span>
                                                        <p style="font-size: 15px;padding:5px; background-color: #f2f2f2; margin: 0;">
                                                        <strong>
                                                        ${totalInWords.toLocaleUpperCase()}
                                                        </strong>
                                                        </p>
                                                        <br>
                                                        <span style="font-size: 18px;" >TERMS AND CONDITIONS</span>
                                                        <p style="font-size: 15px; background-color: #f2f2f2; margin: 0; padding: 5px;">
                                                            1. No Guarantee No Exchange No Claim<br />2. Goods once Sold will not be taken back<br />3. All Disputes are Subject to Delhi Jurisdiction<br />4. Interest @ 24 will be charged if the bill is not paid within 7 days
                                                        </p>
                                                        
                                                    </div>
                                                    <div style="width: 34%;">
                                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                            <li style="color: #000000; "><span style="text-align:left">  SubTotal :         </span><span style="float: right;">₹ ${InvoiceData.InvoiceData.subTotal}</span></li>
                                                            ${ InvoiceData?.InvoiceData?.discount > 0 ?
                                                                    `
                                                                    <li style="color: #000000; "><span style="text-align:left">  Discount (${InvoiceData?.InvoiceData?.discount}%):         </span><span style="float: right;">- ₹ ${(InvoiceData?.InvoiceData?.discount * InvoiceData.InvoiceData.subTotal) / 100}</span></li>
                                                                    `: ``}
                                                            <li style="color: #000000; "><span style="text-align:left">  Delevery Charge :  </span><span style="float: right;">₹ ${InvoiceData.InvoiceData?.deleveryCharge > 0 ? InvoiceData.InvoiceData?.deleveryCharge : "FREE"}</span></li>
                                                            <li style="color: #000000; "><span style="text-align:left">  Packaging Charge : </span><span style="float: right;">₹ ${InvoiceData.InvoiceData?.packagingCharge > 0 ? InvoiceData.InvoiceData?.packagingCharge : "FREE"}</span></li>
                                                            <li style="color: #000000; "><span style="text-align:left">  Cartoon Charge :   </span><span style="float: right;">₹ ${InvoiceData.InvoiceData?.cartoonCharge > 0 ? InvoiceData.InvoiceData?.cartoonCharge : "FREE"}</span></li>
                                                            <li style="color: #000000; display: none; ">Additional Charge : ₹ ${InvoiceData.InvoiceData.additionalCharge ? InvoiceData?.InvoiceData?.additionalCharge:0}</li>
                                                            
                                                            ${ InvoiceData?.InvoiceData?.isTaxable == "true"? `
                                                            <li style="color: #000000;"><span style="text-align:left"> GSTIN (18%) </span><span style="float: right;">₹ ${(InvoiceData.InvoiceData.subTotal * 0.18).toFixed(2)}</span></li>
                                                            ` : `` }
                                                            
                                                            <li style="color: #000000; "><span style="text-align:left">Received : </span><span style="float: right;">- ₹ ${InvoiceData.InvoiceData.received ? InvoiceData?.InvoiceData?.received:0}</span></li>
                                                            <br>
                                                            <li style="color: #000000; display:flex;justify-content:space-between;width:100%"><span>Total Amount</span><span style="font-size: 20px;"><strong>₹ ${InvoiceData.InvoiceData.total}</strong></span></li>
                                                            <li style="color: #000000; display:flex;justify-content:space-between;width:100%"><span>Balance</span><span style="font-size: 20px;"><strong>₹ ${parseFloat((InvoiceData.InvoiceData.total- (InvoiceData.InvoiceData.received ? InvoiceData?.InvoiceData?.received:0) - ((InvoiceData?.InvoiceData?.discount ? InvoiceData?.InvoiceData?.discount : 0)  * InvoiceData.InvoiceData.subTotal) / 100)).toFixed(2)}</strong></span></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr />
                                                        <p><strong>For, COCOBERRY </strong></p>
                                                        <img src="./img/coco-sign.jpg" alt="Authorized Signatory" width="25%" />
                                                        <p><strong>Authorized Signatory</strong></p>
                                                    
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a onclick="printData('printable-invoice-${toInvoiceNumber(Invoices.id)}')" class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i
                                    class="fas fa-print text-primary"></i> Print</a>
                                </div>
                            </div>
                        </div>`;
                        const cell = document.createElement('td');
                        cell.innerHTML = index + 1;
                        row.appendChild(cell);

                        const cell1 = document.createElement('td');
                        cell1.innerHTML = toInvoiceNumber(Invoices.id);
                        row.appendChild(cell1);

                        const cell2 = document.createElement('td');
                        cell2.innerHTML = customerData.name;
                        row.appendChild(cell2);

                        // const cell3 = document.createElement('td');
                        // cell3.innerHTML = customerData.name;
                        // row.appendChild(cell3);

                        const cell4 = document.createElement('td');
                        cell4.innerHTML = InvoiceData.InvoiceData.isTaxable == "true" ? "Taxable" : "Non Taxable";
                        row.appendChild(cell4);

                        const cell5 = document.createElement('td');
                        cell5.innerHTML = formatDate(Invoices.date_created);
                        row.appendChild(cell5);

                        const cell6 = document.createElement('td');
                        cell6.innerHTML = `
                        <td><button type="button" class="btn bg-success-icon" data-toggle="modal" data-target="#modal-${toInvoiceNumber(Invoices.id)}"> <i class="fas fa-eye"></i> </button>
                        <td><button type="button" class="btn bg-success-icon" data-toggle="modal" data-target="#edit-modal-${toInvoiceNumber(Invoices.id)}"> <i class="fas fa-edit"></i> </button>
                    `;
                        row.appendChild(cell6);

                        tableBody.appendChild(row);

                        jQuery("#my-modals").append(newModal);
                    }
                    jQuery(function() {
                        var regExp = /[0-9\.\,]/;
                        jQuery('input[type="number"]').on('keydown keyup', function(e) {
                            var value = String.fromCharCode(e.which) || e.key;
                            if (!regExp.test(value) &&
                                e.which != 188 // ,
                                &&
                                e.which != 190 // .
                                &&
                                e.which != 8 // backspace
                                &&
                                e.which != 46 // delete
                                &&
                                (e.which < 37 // arrow keys
                                    ||
                                    e.which > 40)) {
                                e.preventDefault();
                                return false;
                            }
                        });
                    });
                    $('#data-tables-invoices').DataTable();

                }
            });
    </script>



</body>

</html>