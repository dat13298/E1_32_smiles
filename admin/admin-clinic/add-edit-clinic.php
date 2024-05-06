
<?php
session_start();
require_once('../function.php');
check_login();
init_connection();
$id = intval($_GET['id'] ?? '');
$row = $id ? getClinic( $id) : [];
$errorMessages = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['itemName'];
    $description = $_POST['description'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];
    $uploadedFile = $_FILES['formFile']['tmp_name'];
    $uploadedFileName = $_FILES['formFile']['name'];
    $errorMessages = validateFormClinic($name, $description, $phonenumber, $address, $uploadedFileName, $id);
    if(empty($errorMessages) && $uploadedFileName == '' && $id){
        $imagePath = $row['media_path'];
        updateClinic( $name, $address, $phonenumber, $description,$imagePath, $id);
        return;
    }
    if(empty($errorMessages) && $uploadedFileName != '' && $id){
        $imagePath = validateFile($uploadedFile, $uploadedFileName);
        if($imagePath){
            updateClinic( $name, $address, $phonenumber, $description, $imagePath, $id);
            return;
        }
    }
    if(empty($errorMessages) && $uploadedFileName != ''){
        $imagePath = validateFile($uploadedFile, $uploadedFileName);
        if($imagePath){
            echo 'okokoko';
            addClinic( $name, $address, $phonenumber, $description, $imagePath);
            header('location: index.php');
        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }

        .errormsg {
            margin: 5px 0px 10px 0px;
        }

    </style>
    <!-- <script src="../script.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="<?= $id ? $id : '' ?>">
<div class="container">
    <div class="form-container bg-light border rounded p-4 shadow">
        <h4 class="mb-3"><?php echo $row ? 'Edit Clinic' : 'Add Clinic' ?></h4>
        <div class="my-3">
            <form action="add-edit-clinic.php<?php echo $id ? "?id=$id" : ''; ?>"
                  method="post"
                  id="myForm"
                  onsubmit="return validateFormClinic()"
                  enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="itemName" class="form-label">Clinic Name</label>
                    <input
                            type="text"
                            class="form-control"
                            id="itemName"
                            name="itemName"
                            placeholder="Enter item name"
                            value="<?= $id ? $row['clinic_name'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['name'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['name']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="description"
                            value="<?= $id ? $row['clinic_description'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['description'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['description']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="phonenumber" class="form-label">Phonenumber</label>
                    <input
                            type="text"
                            class="form-control"
                            id="phonenumber"
                            name="phonenumber"
                            placeholder="phonenumber"
                            value="<?= $id ? $row['clinic_phone_number'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['phoneNumber'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['phoneNumber']; ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($errorMessages['phoneNumberIsNumber'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['phoneNumberIsNumber']; ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($errorMessages['phoneNumberLength'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['phoneNumberLength']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input
                            type="text"
                            class="form-control"
                            id="address"
                            name="address"
                            placeholder="address"
                            value="<?= $id ? $row['clinic_address'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['address'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['address']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <label for="formFile" class="form-label">File</label>
                <img id="preview-image" style="height: 100px" src="<?= $id ? $row['media_path'] : '' ?>" alt="">
                <div>
                    <input
                            type="file"
                            onchange="previewImage(event)"
                            class="form-control-file border"
                            name="formFile" id="formFile"
                            value="<?= $id ? $row['media_path'] : '' ?>"
                            accept="image/*" >
                    <?php if (isset($errorMessages['file'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['file']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-success"><?= $id ? 'Save' : 'Add' ?></button>
                <a href="/admin/admin-clinic/" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="../script.js"></script>
</body>
</html>
