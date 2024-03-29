<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit;
}

$configPath = __DIR__ . '/config.json';

if (!file_exists($configPath)) {
    //redirect to Home
    header('Location: index.php');
}

try {
    include("config.php");
} catch (\Throwable $th) {
    unlink($configPath);
    header('Location: index.php?err=Invalid Configuration');
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $_SESSION['api-url']; ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">INVENTORY</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo $_SESSION['api-url']; ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">



    <div class='<?php echo isset($_GET['debug']) ? '' : 'd-none'; ?>'>
        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Components</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="buttons.html">Buttons</a>
                    <a class="collapse-item" href="cards.html">Cards</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>x`
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    </div>








    <!-- Heading -->
    <div class="sidebar-heading">
        Managements
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userManagements" aria-expanded="true" aria-controls="userManagements">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
        <div id="userManagements" class="collapse" aria-labelledby="headingUserManagements" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Managements:</h6>
                <a class="collapse-item" href="users">All User</a>
                <a class="collapse-item" href="add-user">Add User</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productManagements" aria-expanded="true" aria-controls="productManagements">
            <i class="fas fa-fw fa-table"></i>

            <span>Product</span>
        </a>
        <div id="productManagements" class="collapse" aria-labelledby="headingproductManagements" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stock Managements:</h6>
                <a class="collapse-item" href="products">All products</a>
                <a class="collapse-item" href="add-product">Add products</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accountsManagements" aria-expanded="true" aria-controls="accountsManagements">
            <i class="fas fa-fw fa-file"></i>

            <span>Accounts</span>
        </a>
        <div id="accountsManagements" class="collapse" aria-labelledby="headingAccountsManagements" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Invoices:</h6>
                <a class="collapse-item" href="invoices">All Invoices</a>
                <a class="collapse-item" href="create-invoice">Create Invoice</a>
            </div>
        </div>
    </li>




    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current pathname
        var currentPath = window.location.pathname;

        // Iterate through all collapse items in the navigation
        var collapseItems = document.querySelectorAll(".collapse-item");
        collapseItems.forEach(function(collapseItem) {
            // Check if the current pathname matches the link's href or starts with it
            if (currentPath === collapseItem.getAttribute("href") || currentPath.endsWith(collapseItem.getAttribute("href")) || currentPath.endsWith(collapseItem.getAttribute("href") + "/")) {
                // Add "active" class to the collapse item
                collapseItem.classList.add("active");

                // Find the parent collapse and show it
                var parentCollapse = collapseItem.closest(".collapse");
                if (parentCollapse) {
                    parentCollapse.classList.add("show");
                }

                // Find the grandparent nav-link and add "active" class to it
                var grandparentNavLink = collapseItem.closest(".nav-item").querySelector(".nav-link");
                if (grandparentNavLink) {
                    grandparentNavLink.classList.remove("collapsed");
                }
                var greatGrandparentNavLink = collapseItem.closest(".nav-item");
                if (greatGrandparentNavLink) {
                    greatGrandparentNavLink.classList.add("active");
                }
            }
        });
    });
</script>