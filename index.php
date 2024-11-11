<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "employees";

$mysql = mysqli_connect($servername, $username, $password, $database);

// Check if connection was successful, if not, terminate script with an error message
if (!$mysql) {
  die("Sorry, we failed to connect: " . mysqli_connect_error());
}

// Flags to check if an operation (insert, update, delete) was successful
$insert = false;
$update = false;
$delete = false;

// Handle POST request to determine the type of CRUD operation
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Check if the request is for updating an existing record
  if (isset($_POST['snoEdit'])) {
    $sno = $_POST["snoEdit"];
    $name = $_POST["nameEdit"];
    $email = $_POST["emailEdit"];
    $address = $_POST["addressEdit"];
    $phone  = $_POST["phoneEdit"];

    // SQL query to update the record in the database
    $sql = "UPDATE `manage employees` SET `Name` = '$name', `Email` = '$email', `Address` = '$address', `Phone` = '$phone' WHERE `manage employees`.`Serial Number` = $sno";
    $result = mysqli_query($mysql, $sql);

    // Set update flag if update was successful
    if ($result) {
      $update = true;
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error!</strong> The record was not updated successfully because of this error -->" . mysqli_error($mysql) . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>";
    }
  } elseif (isset($_POST['snoDelete'])) { // Check if the request is for deleting a record
    $sno = $_POST['snoDelete'];

    // SQL query to delete the record from the database
    $sql = "DELETE FROM `manage employees` WHERE `Serial Number` = $sno";
    $result = mysqli_query($mysql, $sql);

    // Set delete flag if delete was successful
    if ($result) {
      $delete = true;
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error!</strong> The record was not deleted successfully because of this error -->" . mysqli_error($mysql) . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>";
    }
  } else { // If no specific edit or delete operation, assume insert operation

    // Get form input values for inserting a new record
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone  = $_POST["phone"];

    // SQL query to insert the new record into the database
    $sql = "INSERT INTO `manage employees` (`Name`, `Email`, `Address`, `Phone`) VALUES ('$name', '$email', '$address', '$phone')";
    $result = mysqli_query($mysql, $sql);

    // Set insert flag if insert was successful
    if ($result) {
      $insert = true;
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> The record was not inserted successfully because of this error -->" . mysqli_error($mysql) . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span>
        </button>
      </div>";
    }
  }
}
?>

<!-- HTML document with language set to English -->
<html lang="en">

<head>
  <!-- Character encoding for the document -->
  <meta charset="utf-8" />
  <!-- Viewport settings for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Page title -->
  <title>PHP CRUD Operations Using MySQLI with Modal Form</title>
  <!-- Google font stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" />
  <!-- Bootstrap CSS for responsive, mobile-first design -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <!-- Material Icons library for icon usage -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
  <!-- Font Awesome library for additional icons -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- DataTables CSS library for table styling and functionality -->
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

  <!-- Inline styling for custom styling of page elements -->
  <style>
    /* Styling for body, tables, modals, and other elements */
    body {
      color: #566787;
      background: #233245;
      font-family: "Varela Round", sans-serif;
      font-size: 13px;
    }

    .table-responsive {
      margin: 30px 0;
    }

    .table-wrapper {
      background: #fff;
      padding: 20px 25px;
      border-radius: 3px;
      min-width: 1000px;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    }

    .table-title {
      padding-bottom: 15px;
      background: #435d7d;
      color: #fff;
      padding: 16px 30px;
      min-width: 100%;
      margin: -20px -25px 10px;
      border-radius: 3px 3px 0 0;
    }

    .table-title h2 {
      margin: 5px 0 0;
      font-size: 24px;
    }

    .table-title .btn-group {
      float: right;
    }

    .table-title .btn {
      color: #fff;
      float: right;
      font-size: 13px;
      border: none;
      min-width: 50px;
      border-radius: 2px;
      border: none;
      outline: none !important;
      margin-left: 10px;
    }

    .table-title .btn i {
      float: left;
      font-size: 21px;
      margin-right: 5px;
    }

    .table-title .btn span {
      float: left;
      margin-top: 2px;
    }

    table.table tr th,
    table.table tr td {
      border-color: #e9e9e9;
      padding: 12px 15px;
      vertical-align: middle;
    }

    table.table tr th:last-child {
      width: 100px;
    }

    table.table-striped tbody tr:nth-of-type(odd) {
      background-color: #fcfcfc;
    }

    table.table-striped.table-hover tbody tr:hover {
      background: #f5f5f5;
    }

    table.table th i {
      font-size: 13px;
      margin: 0 5px;
      cursor: pointer;
    }

    table.table td:last-child i {
      opacity: 0.9;
      font-size: 22px;
      margin: 0 5px;
    }

    table.table td a {
      font-weight: bold;
      color: #566787;
      display: inline-block;
      text-decoration: none;
      outline: none !important;
    }

    table.table td a:hover {
      color: #2196f3;
    }

    table.table td a.edit {
      color: #ffc107;
    }

    table.table td a.delete {
      color: #f44336;
    }

    table.table td i {
      font-size: 19px;
    }

    /* Modal styles */
    .modal .modal-dialog {
      max-width: 400px;
    }

    .modal .modal-header,
    .modal .modal-body,
    .modal .modal-footer {
      padding: 20px 30px;
    }

    .modal .modal-content {
      border-radius: 3px;
      font-size: 14px;
    }

    .modal .modal-footer {
      background: #ecf0f1;
      border-radius: 0 0 3px 3px;
    }

    .modal .modal-title {
      display: inline-block;
    }

    .modal .form-control {
      border-radius: 2px;
      box-shadow: none;
      border-color: #dddddd;
    }

    .modal textarea.form-control {
      resize: vertical;
    }

    .modal .btn {
      border-radius: 2px;
      min-width: 100px;
    }

    .modal form label {
      font-weight: normal;
    }
  </style>
</head>

<body>
  <!-- PHP code for displaying success or error alerts based on CRUD operations -->
  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been Insert successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if ($delete) {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <!-- Main container for the employee table area -->
  <div class="container-xl table_area">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Manage <b>Employees</b></h2>
            </div>
            <div class="col-sm-6">
              <!-- Button to add a new employee -->
              <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons"></i>
                <span>Add New Employee</span></a>
              <!-- <a
                href="#deleteEmployeeModal"
                class="btn btn-danger"
                data-toggle="modal"><i class="material-icons"></i> <span>Delete</span></a> -->
            </div>
          </div>
        </div>
        <!-- Table for displaying employee data -->
        <table id="myTable" class="table table-hover dt-responsive">
          <thead>
            <tr>
              <th>SNo.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // PHP script to retrieve employee records from MySQL database
            $sql = "SELECT * FROM `manage employees`";
            $result = mysqli_query($mysql, $sql);
            // show only records number in database
            $num =  mysqli_num_rows($result);
            if ($num > 0) {
              $snum = 1;
              // Loop through records and display each row
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                            <td style='text-align:left' >$snum</td>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Email'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                            <td>
                            <!-- Edit and delete icons for each record -->
                              <a href='#editEmployeeModal' class='edit' data-toggle='modal'
                                ><i
                                  class='material-icons'
                                  id=" . $row['Serial Number'] . "
                                  data-toggle='tooltip'
                                  title=''
                                  data-original-title='Edit'
                                  ></i
                                ></a
                              >
                              <a
                                href='#deleteEmployeeModal'
                                class='delete'
                                data-toggle='modal'
                                ><i
                                  class='material-icons'
                                  id=d" . $row['Serial Number'] . "
                                  data-toggle='tooltip'
                                  title=''
                                  data-original-title='Delete'
                                  ></i
                                ></a
                              >
                            </td>
                          </tr>";
                $snum++;
              };
            }
            ?>

          </tbody>
        </table>

      </div>
    </div>
  </div>
  <!-- Modal forms for add, edit, and delete employee actions -->
  <!-- add Modal HTML -->
  <div id="addEmployeeModal" class="modal fade" aria-hidden="true" style="display: none">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Form to add a new employee -->
        <form action="./" method="post">
          <div class="modal-header">
            <h4 class="modal-title">Add Employee</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              ×
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required="" />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required="" />
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea class="form-control" name="address" required=""></textarea>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" required="" />
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
            <input type="submit" class="btn btn-success" value="Add" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Modal HTML -->
  <div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="./" method="post">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="modal-header">
            <h4 class="modal-title">Edit Employee</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              ×
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Name</label>
              <input type="text" id="nameEdit" name="nameEdit" class="form-control" required="" />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" id="emailEdit" name="emailEdit" class="form-control" required="" />
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea class="form-control" id="addressEdit" name="addressEdit" required=""></textarea>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" class="form-control" id="phoneEdit" name="phoneEdit" required="" />
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
            <input type="submit" class="btn btn-info" value="Update" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Delete Modal HTML -->
  <div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Employee</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            ×
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning">
            <small>This action cannot be undone.</small>
          </p>
        </div>
        <form action="./" method="post" class="modal-footer">
          <input type="hidden" name="snoDelete" id="snoDelete">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
          <input type="submit" class="btn btn-danger" value="Delete" />
        </form>
      </div>
    </div>
  </div>
</body>

<!-- Script files for jQuery, Bootstrap, DataTables, and custom scripts for handling button actions and modal popups -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
  // Initialize the DataTable library for the table with id 'myTable'
  let table = new DataTable('#myTable');

  // Set a timer to automatically hide alert messages after 2 seconds
  window.setTimeout(function () {
    $(".alert").fadeTo(500, 0).slideUp(500, function () {
      $(this).remove(); // Remove alert from DOM after it fades out
    });
  }, 2000);

  // Select all elements with the 'edit' class to add event listeners for editing functionality
  const editBtns = document.querySelectorAll('.edit');

  // Loop through each 'edit' button and add a click event listener
  Array.from(editBtns).forEach(btn => {
    btn.addEventListener('click', (e) => {
      // Access the corresponding row and retrieve the text content of each cell for Name, Email, Address, and Phone
      const row = e.target.parentNode.parentNode.parentNode;
      const name = row.getElementsByTagName('td')[1].innerText;
      const email = row.getElementsByTagName('td')[2].innerText;
      const address = row.getElementsByTagName('td')[3].innerText;
      const phone = row.getElementsByTagName('td')[4].innerText;

      // Set the values of the edit form fields based on the row data
      snoEdit.value = e.target.id;
      nameEdit.value = name;
      emailEdit.value = email;
      addressEdit.value = address;
      phoneEdit.value = phone;
    })
  });

  // Select all elements with the 'delete' class to add event listeners for delete functionality
  const deleteBtns = document.querySelectorAll('.delete');

  // Loop through each 'delete' button and add a click event listener
  Array.from(deleteBtns).forEach(btn => {
    btn.addEventListener('click', (e) => {
      // Extract the ID of the row to be deleted by removing the first character ('d') from the id attribute
      snoDelete.value = e.target.id.substr(1);
    })
  });
</script>

</html>