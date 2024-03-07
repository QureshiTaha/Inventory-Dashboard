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

    <title>Admin Settings</title>

    <!-- Custom fonts for this template-->
    <!-- fontawesomefreeHere -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" defer></script>

</head>

<body id="page-top">

    <style>
        .customFieldsContainer {
            margin-top: 20px;
        }

        .custom-field-tab {
            padding: 5px;
            border: 1px solid #ccc;
            cursor: move;
            background-color: #fff;
        }

        .custom-field-tab:hover {
            box-shadow: 0px 0px 10px #d8d8d8;
        }

        .custom-field-tab:active {
            /* transform: scale(1.01); */
        }

        .sidebarListChild {
            margin-left: 50px;
        }

        .custom-field-tab .delete-btn {
            height: 1.5rem;
            width: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0.5rem;
        }

        .nav-tabs>li {
            float: left;
            margin-bottom: -1px;
        }

        .nav>li {
            position: relative;
            display: block;
        }

        .bg-f2 {
            background-color: #f2f2f2;
        }

        .nav-tabs>li.active>a,
        .nav-tabs>li.active>a:focus,
        .nav-tabs>li.active>a:hover {
            color: #555;
            cursor: default;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-bottom-color: rgb(221, 221, 221);
            border-bottom-color: transparent;
        }

        .nav-tabs>li>a {
            margin-right: 2px;
            line-height: 1.42857143;
            border: 1px solid transparent;
            border-radius: 4px 4px 0 0;
        }

        .nav>li>a {
            text-decoration: none;
            position: relative;
            display: block;
            padding: 10px 15px;
        }
    </style>
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
                        <h1 class="h3 mb-0 text-gray-800">Admin Settings</h1>
                        <?php
                        // Fetch USER DATA
                        // $conn 
                        $ID =  $_SESSION['id'];
                        $sql = "SELECT * FROM admin WHERE id =  '" . $ID . "'";
                        $user = $conn->query($sql)->fetch_assoc();

                        ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-xl-8">
                            <!-- Account details card-->
                            <div class="card mb-4 ">


                                <div id="exTab2" class=" ">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a href="#1" data-toggle="tab">Profile</a>
                                        </li>
                                        <li class="active"><a href="#2" data-toggle="tab">Advance</a>
                                        </li>
                                        <li><a href="#3" data-toggle="tab">credits</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content  p-2 bg-f2">
                                        <div class="tab-pane" id="1">
                                            <div class="container">
                                                <h3>Profile Settings</h3>
                                                <?php
                                                if (isset($_POST['submit'])) {
                                                    // Validate the input
                                                    $id = $_POST['id'];
                                                    $password = $_POST['password'];
                                                    $name = $_POST['name'];
                                                    $email = $_POST['email'];

                                                    // Update the password in the database
                                                    $sql = "UPDATE admin SET password = '$password', name = '$name', email = '$email' WHERE id = $id";

                                                    if ($conn->query($sql) === TRUE) {

                                                        // UPDATE session
                                                        $_SESSION['username'] = $name;
                                                        $_SESSION['email'] = $email;

                                                        echo '
                                                        <div class="">
                                                            <div class="alert alert-success alert-dismissible fade show" id="myAlertSuccess" role="alert">
                                                                <strong id="alertName">Admin</strong> <span id="AlertMessage">Updated Successfully</span>
                                                                <button type="button" class="btn-close p-3" onclick="myAlertSuccess.classList.add(\'d-none\')" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                        ';
                                                    } else {
                                                        echo '
                                                        <div class="">
                                                            <div class="alert alert-danger alert-dismissible fade show" id="myAlertDanger" role="alert">
                                                                <strong id="alertName">Admin</strong> <span id="AlertMessage">Updated Fail</span>
                                                                <button type="button" class="btn-close p-3" onclick="myAlertDanger.classList.add(\'d-none\')" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                        ';
                                                    }
                                                    //wait 2 sec and reload window
                                                    echo '<script>setTimeout(function(){ window.location.href = window.location.href; }, 2000);</script>';
                                                }
                                                ?>

                                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" value="<?= $user['name']; ?>" name="name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" value="<?= $user['email']; ?>" name="email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <!-- Toggle password View js script-->
                                                        <div class="input-group mb-3">
                                                            <input type="password" class="form-control" id="password" value="<?= $user['password']; ?>" name="password">
                                                            <div class="input-group-append" style="border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem;">
                                                                <span class="input-group-text bg toggle-password" onclick="togglePassword()">
                                                                    <i id="togglePasswordIcon" class="fa fa-eye-slash "></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            function togglePassword() {
                                                                const passwordInput = document.getElementById('password');
                                                                const icon = document.getElementById('togglePasswordIcon');
                                                                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                                                passwordInput.setAttribute('type', type);
                                                                if (type === "password") {
                                                                    icon.classList.add("fa-eye-slash");
                                                                    icon.classList.remove("fa-eye");
                                                                } else {
                                                                    icon.classList.add("fa-eye");
                                                                    icon.classList.remove("fa-eye-slash");
                                                                }
                                                            }
                                                        </script>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>




                                        <div class="tab-pane active" id="2">
                                            <!-- Advance Settings -->
                                            <div class="container">
                                                <h3>Advance Settings</h3>
                                                <?php
                                                if ($_SESSION['id'] != 1) {
                                                ?>
                                                    <p>
                                                        <i class="fas fa-exclamation-triangle "></i>
                                                        This feature is not available
                                                    </p>
                                                <?php
                                                } else {
                                                ?>

                                                    <!-- Modal for adding new field types -->
                                                    <button type="button" id="addFieldButton" class="btn btn-primary" data-toggle="modal" data-target="#addFieldModal">
                                                        Add New Field
                                                    </button>
                                                    <button type="button" id="save" class="btn btn-primary" onclick="saveAllCustomFields()">
                                                        Save All
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="addFieldModal" tabindex="-1" role="dialog" aria-labelledby="addFieldModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="addFieldModalLabel">Add New Field Type</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form onsubmit="addNewField(event)">
                                                                    <div class="modal-body">
                                                                        <label for="fieldLabel" class="form-label">Field Label:</label>
                                                                        <input type="text" oninput="updateFieldName(event,'fieldName')" name="fieldLabel" class="form-control" id="fieldLabel">
                                                                        <label for="fieldName" class="form-label">Field Name:</label>
                                                                        <input type="text" name="fieldName" class="form-control" id="fieldName">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" id="addFieldSubmit" class="btn btn-primary">Add Field</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Accordion for displaying added field types -->
                                                    <div class="py-3">
                                                        <div class="alert d-none alert-success alert-dismissible fade show" id="myAlert" role="alert">
                                                            <strong id="alertName"></strong> <span id="AlertMessage"></span>
                                                            <button type="button" class="btn-close p-3" onclick="myAlert.classList.add('d-none')" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    <div class="accordion accordion-flush my-3" id="accordion"></div>


                                                    <!-- JavaScript for handling the modal and accordion -->

                                                <?php } ?>
                                            </div>
                                        </div>


                                        <div class="tab-pane" id="3">
                                            <div class="container">
                                                <h1>Credits</h1>
                                                <!-- Credits Section Start -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <div class="card-body">
                                                                <h5 class="card-title"></h5>
                                                                <!-- With supporting text below as a natural lead-in to additional content. -->
                                                                <p class="card-text">
                                                                    Build with love by <a href="https://makend.com" class="">Makend Team.</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Credits Section END -->
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var myAlert = document.getElementById('myAlert');
                    // or ready function get all fields
                    jQuery(document).ready(function() {

                        fetch('<?= $apiURL; ?>/common/function.php?fields=&&action=get_all_field', {
                                method: 'POST',
                                headers: {
                                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                }
                            })
                            .then(response => response.json())
                            .then(async (data) => {
                                console.log(data);
                                if (data.success) {
                                    for (let i = 0; i < data.data.length; i++) {
                                        document.getElementById('accordion').innerHTML += `
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading${data.data[i].name}">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${data.data[i].name}" aria-expanded="false" aria-controls="collapse${data.data[i].name}">
                                                                    ${data.data[i].label}
                                                                </button>
                                                            </h2>
                                                            <div id="collapse${data.data[i].name}" class="accordion-collapse collapse" aria-labelledby="heading${data.data[i].name}" data-bs-parent="#accordion">
                                                                <div class="accordion-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <p>nameKey: <strong>${data.data[i].name}</strong></p>
                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteAccordian('${data.data[i].id}')" >Delete Parent Field</button>
                                                                 </div>
                                                                    <button type="button" class="btn btn-primary" onclick="addCustomField(${data.data[i].id},'${data.data[i].name}')" >Add Custom Input Field</button>
                                                                    <div class="custom-fields-container py-3" id="customFieldsContainer${data.data[i].id}"></div>
                                                                </div>
                                                            </div>
                                                        </div>`
                                        // get_all_custom_field_by_EntityType
                                        const customFields = await get_all_custom_field_by_EntityType(data.data[i].name);
                                        console.log("customFields", customFields, i);

                                        customFields.forEach((customField, index) => {
                                            addCustomField(data.data[i].id, customField.entity_type, customField.id, customField.label, customField.name,
                                                customField.field_id, customField.entity_id, customField.type, index, customField.options);
                                        })

                                    }

                                }
                            })




                    });

                    function delay() {
                        setTimeout(function() {
                            var accordions = document.getElementsByClassName('accordion-item');
                            for (var i = 0; i < accordions.length; i++) {
                                var accordion = accordions[i];
                                console.log("accordion", accordion);
                                var customFieldContainer = accordion.getElementsByClassName('custom-fields-container');
                                var customFieldContainerID = "#" + customFieldContainer[0].id;
                                console.log("customFieldContainerID->", customFieldContainerID);
                                $(customFieldContainerID).sortable({
                                    // Update Form name=id value from previous form if drag
                                    update: function(event, ui) {
                                        var form = ui.item.find('form');
                                        var customFieldsContainer = form.closest('.custom-fields-container');
                                        var priorityIndex = 0;
                                        jQuery(customFieldsContainer).find('.custom-field-tab').each(function() {
                                            jQuery(this).find('input[name="priority"]').val(priorityIndex);
                                            priorityIndex++;
                                        })
                                    },
                                    change: function(event, ui) {
                                        var newId = ui.item.attr("id");
                                    },
                                    opacity: 0.9,
                                    animation: 150,
                                    revert: true,
                                });
                            }
                        }, 1000);
                    }

                    if (document.readyState == 'complete') {
                        delay();
                        console.log(":loaded2");
                    } else {
                        document.onreadystatechange = function() {
                            if (document.readyState === "complete") {
                                delay();

                            }
                        }
                    }






                    function saveAllCustomFields(e) {
                        var accordions = document.getElementsByClassName('accordion-item');
                        for (var i = 0; i < accordions.length; i++) {
                            var accordion = accordions[i];
                            var entityId = accordion.getAttribute('data-entity-id');
                            var entityType = accordion.getAttribute('data-entity-type');
                            var customFieldTabs = accordion.getElementsByClassName('custom-field-tab');
                            for (var j = 0; j < customFieldTabs.length; j++) {
                                var customFieldTab = customFieldTabs[j];
                                var form = customFieldTab.querySelector('form');
                                var formData = new FormData(form);
                                var formObject = Object.fromEntries(formData);
                                console.log('Form Object:', formObject);

                                // ajax add_new_custom_field
                                fetch('<?= $apiURL; ?>/common/function.php?fields=&&action=add_new_custom_field', {
                                        method: 'POST',
                                        headers: {
                                            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                        },
                                        body: Object.entries(formObject).map(([k, v]) => {
                                            return k + '=' + v
                                        }).join('&'),
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            myAlert.classList.remove('d-none');
                                            myAlert.classList.remove('alert-danger');
                                            myAlert.classList.add('alert-success');
                                            document.getElementById('alertName').innerText = name;
                                            document.getElementById('AlertMessage').innerText = " added successfully!";


                                            setTimeout(function() {
                                                window.location.reload();
                                            }, 2000);
                                            // alert('product added successfully');
                                        } else {
                                            console.error('Error:', data);
                                            myAlert.classList.remove('d-none');
                                            myAlert.classList.remove('alert-success');
                                            myAlert.classList.add('alert-danger');
                                            document.getElementById('alertName').innerText = "Error";
                                            document.getElementById('AlertMessage').innerText = data.message;
                                        }
                                    });


                            }
                        }
                    }


                    function addCustomField(id_, entity_type, primaryID = null, label = null, name = null, field_id = null, entity_id = null, type = null, priority = null, options = null) {
                        var id = "#customFieldsContainer" + id_;
                        var field = entity_id != null ? entity_id.replace("field_", "") : Date.now();
                        var field_ID = "#" + (entity_id != null ? entity_id : "field_" + field);

                        jQuery(id).append(
                            `<div class="custom-field-tab d-flex mb-3 ${type}" id="field_${field}">
                                <div class="container-fluid">
                                    <form>
                                    <!-- <input type="text" name="fieldName" class="form-control my-2" placeholder="Field Name"> -->
                                            
                                    <input type="hidden" name="priority" class="form-control col-9" value="${priority}" >
                                    <input type="hidden" name="id" class="form-control col-9" value="${primaryID}" >
                                    <input type="hidden" name="field_id" class="form-control col-9" value="${id_}" >
                                    <input type="hidden" name="entity_type" class="form-control col-9" value="${entity_type}" >
                                    <input type="hidden" name="entity_id" class="form-control col-9" value="field_${field}" >

                                    <!--For Label -->
                                        <label for="label" class="form-label small mt-2">Label:</label>
                                        <input type="text" value="${label||""}" name="label" class="form-control col-9" placeholder="Field Label" oninput="updateFieldName(event,'fieldName_${field}')" required>

                                    <!--For Name-->
                                        <label for="fieldName" class="form-label small mt-2">Field Name:</label>
                                        <input type="text" id="fieldName_${field}" name="name" class="form-control col-9" value="${name||""}" placeholder="Field Name" required >

                                        <div class="d-flex align-items-center">
                                        <label for="type" class="form-label small m-2">Type:</label>
                                        <select id="type" name="type" class="form-control my-2 col-5" onchange="toggleOption(event)" required>
                                            <option disabled value=""></option>
                                            <option disabled value="label">----Common Inputs---</option>
                                            <option ${type == "text" ? "selected" : ""} value="text">Text</option>
                                            <option ${type == "textarea" ? "selected" : ""} value="textarea">Text Area</option>
                                            <option ${type == "number" ? "selected" : ""} value="number">Number</option>
                                            <option ${type == "date" ? "selected" : ""} value="date">Date Picker</option>
                                            <option ${type == "bool" ? "selected" : ""} value="bool">True/False</option>
                                            <option disabled value="label">----Custom Inputs---</option>
                                            <option ${type == "select" ? "selected" : ""} value="select">Select</option>
                                            <option ${type == "radio" ? "selected" : ""} value="radio">Radio Button</option>
                                            <option ${type == "checkbox" ? "selected" : ""} value="checkbox">Checkbox</option>
                                            <option ${type == "group" ? "selected" : ""} value="group">group</option>
                                            <option disabled value="label">----Theam Settiings---</option>
                                            <option ${type == "sidebarListParent" ? "selected" : ""} value="sidebarListParent">sidebarListParent</option>
                                            <option ${type == "sidebarListChild" ? "selected" : ""} value="sidebarListChild">sidebar List Child</option>
                                            <!-- Add more options for other field types -->
                                        </select>
                                        </div>
                                        <div class="options my-2 ${type == 'radio'|| type == 'checkbox' ? 'd-flex' : 'd-none' }  align-items-center ">
                                        <label for="options" class="form-label small m-2">Options:</label>
                                        <textarea type="textarea" name="options" class="form-control col-9" placeholder="value:Label\nred:Red\nblue:Blue">${options? options : ""}</textarea>
                                        </div>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-danger delete-btn btn-sm" onclick="deleteField(field_${field})" >X</button>
                            </div>`
                        );
                        //scroll to the new Field
                        if (primaryID == null) {
                            console.log("field_ID", field_ID);
                            $('html, body').animate({
                                scrollTop: $(field_ID).offset().top
                            }, 500);
                            $(field_ID).focus()
                        }


                    }

                    function toggleOption(e) {
                        console.log(e.target.value);
                        // add class to nearest ".custom-field-tab"
                        // remove all existing class
                        $(e.target).closest('.custom-field-tab').removeClass().addClass(`custom-field-tab d-flex mb-3 ${e.target.value}`);
                        if (e.target.value == 'select' || e.target.value == 'radio' || e.target.value == 'checkbox') {
                            // this form remove class d-none and add d-flex else add d-flex and remove d-none
                            $(e.target).parent().parent().find('.options').removeClass('d-none').addClass('d-flex');
                        } else {
                            $(e.target).parent().parent().find('.options').removeClass('d-flex').addClass('d-none');
                        }
                    }

                    function updateFieldName(e, id) {
                        newName = e.target.value.toLowerCase().replace(/\s+/g, '_');
                        console.log(newName);
                        document.getElementById(id).value = newName;
                    }

                    function deleteField(id) {
                        if (window.confirm('Are you sure you wanted to delete this field?')) {
                            var FieldID = jQuery(id).attr('id')
                            fetch('<?= $apiURL; ?>common/function.php?field=custom_fields&&id=' + FieldID, {
                                    method: 'DELETE',
                                    headers: {
                                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                    }
                                }).then(response => response.json())
                                .then(response => {
                                    console.log(response);
                                    if (response.success) {
                                        jQuery(id).remove()
                                        myAlert.classList.remove('d-none');
                                        myAlert.classList.remove('alert-danger');
                                        myAlert.classList.add('alert-success');
                                        document.getElementById('alertName').innerText = name;
                                        document.getElementById('AlertMessage').innerText = " deleted successfully!";
                                        setTimeout(() => {
                                            window.location.reload()
                                        }, 1000)
                                    } else {
                                        myAlert.classList.remove('d-none');
                                        myAlert.classList.remove('alert-success');
                                        myAlert.classList.add('alert-danger');
                                        document.getElementById('alertName').innerText = "Error";
                                        document.getElementById('AlertMessage').innerText = response.message;

                                    }
                                    // scroll to msg
                                    $('html, body').animate({
                                        scrollTop: $(myAlert).offset().top
                                    }, 500);
                                })
                        }

                    }

                    // Main Field
                    function deleteAccordian(id) {
                        console.log(id);
                        if (window.confirm('Are you sure you wanted to delete this field?')) {
                            var FieldID = jQuery(id).attr('id')
                            fetch('<?= $apiURL; ?>common/function.php?field=fields&&id=' + id, {
                                    method: 'DELETE',
                                    headers: {
                                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                    }
                                }).then(response => response.json())
                                .then(response => {
                                    console.log(response);
                                    if (response.success) {
                                        jQuery(id).remove()
                                        myAlert.classList.remove('d-none');
                                        myAlert.classList.remove('alert-danger');
                                        myAlert.classList.add('alert-success');
                                        document.getElementById('alertName').innerText = name;
                                        document.getElementById('AlertMessage').innerText = " deleted successfully!";
                                    } else {
                                        myAlert.classList.remove('d-none');
                                        myAlert.classList.remove('alert-success');
                                        myAlert.classList.add('alert-danger');
                                        document.getElementById('alertName').innerText = "Error";
                                        document.getElementById('AlertMessage').innerText = response.message;
                                    }
                                    // scroll to msg
                                    $('html, body').animate({
                                        scrollTop: $(myAlert).offset().top
                                    }, 500);

                                })
                        }
                    }

                    // Main Field
                    function addNewField(e) {
                        e.preventDefault();
                        var form = new FormData(e.target);
                        form = Object.fromEntries(form);

                        fetch('<?= $apiURL; ?>/common/function.php?fields=&&action=add_new_field', {
                                method: 'POST',
                                headers: {
                                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                },
                                body: Object.entries(form).map(([k, v]) => {
                                    return k + '=' + v
                                }).join('&'),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    myAlert.classList.remove('d-none');
                                    myAlert.classList.remove('alert-danger');
                                    myAlert.classList.add('alert-success');
                                    document.getElementById('alertName').innerText = name;
                                    document.getElementById('AlertMessage').innerText = " added successfully!";

                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                    // alert('product added successfully');
                                } else {
                                    console.error('Error:', data);
                                    myAlert.classList.remove('d-none');
                                    myAlert.classList.remove('alert-success');
                                    myAlert.classList.add('alert-danger');
                                    document.getElementById('alertName').innerText = "Error";
                                    document.getElementById('AlertMessage').innerText = data.message;
                                }
                            });
                    }

                    async function get_all_custom_field_by_EntityType(entityType) {
                        try {
                            const response = await fetch('<?= $apiURL; ?>/common/function.php?fields=&&action=get_all_custom_field_entity_type&&entityType=' + entityType, {
                                method: 'POST',
                                headers: {
                                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                                }
                            });
                            const data = await response.json();
                            if (data.success) {
                                return data.data;
                            } else {
                                console.error('Error:', data);
                                return [];
                            }
                        } catch (error) {
                            console.error('Error fetching data:', error);
                            return [];
                        }
                    }
                </script>
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

</html>