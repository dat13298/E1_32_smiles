<?php
session_start();
require_once ('../function.php');
check_login();
init_connection();
$folderName = basename(dirname(__FILE__));
$id = intval($_GET['id'] ?? '');
$row = $id ? getProduct($id) : [];
$categories = getAllCategoryProduct();
$errorMessages = [];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['itemName'];
    $categoryProduct = intval($_POST['category']);
    $description = $_POST['description'];
    $price = $_POST['price'];
    $uploadedFile = $_FILES['formFile']['tmp_name'];
    $uploadedFileName = $_FILES['formFile']['name'];
    $errorMessages = validateFormProduct($name, $categoryProduct, $description, $price, $uploadedFileName, $id);
    if(empty($errorMessages) && $uploadedFileName == '' && $id){
        $imagePath = $row['media_path'];
        updateProduct($name, $categoryProduct, $description, $price, $imagePath, $id);
        return;
    }
    if(empty($errorMessages) && $uploadedFileName != '' && $id){
        $imagePath = validateFile($uploadedFile, $uploadedFileName, $folderName);
        if($imagePath){
            updateProduct($name, $categoryProduct, $description, $price, $imagePath, $id);
            return;
        }
    }
    if(empty($errorMessages) && $uploadedFileName != ''){
        $imagePath = validateFile($uploadedFile, $uploadedFileName, $folderName);
        if($imagePath){
            addProduct($name, $categoryProduct, $description, $price, $imagePath);
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
    <title>Product Form</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body id="<?= $id ? $id : '' ?>">
<div class="container">
    <div class="form-container bg-light border rounded p-4 shadow">
        <h4 class="mb-3"><?php echo $row ? 'Edit Product' : 'Add Product' ?></h4>
        <div class="my-3">
            <form action="add-edit-product.php<?php echo $id ? "?id=$id" : ''; ?>"
                  method="post"
                  id="myForm"
                  onsubmit="return validateFormProduct()"
                  enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="itemName" class="form-label">Product Name</label>
                    <input
                            type="text"
                            class="form-control"
                            id="itemName"
                            name="itemName"
                            placeholder="Enter item name"
                            value="<?= $id ? $row['product_name'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['name'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['name']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Choose category:</label>
                    <select class="form-select" name="category" id="category">
                        <option value="">Choose category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
                        <?php endforeach;?>
                    </select>
                    <?php if (isset($errorMessages['selected'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['selected']; ?></div>
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
                            value="<?= $id ? $row['product_description'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['description'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['description']; ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="price">Price</label>
                    <input
                            type="text"
                            class="form-control"
                            id="price"
                            name="price"
                            placeholder="Price"
                            value="<?= $id ? $row['product_price'] : '' ?>"
                    >
                    <?php if (isset($errorMessages['price'])): ?>
                        <div class="errormsg">
                            <div class="alert alert-danger"><?php echo $errorMessages['price']; ?></div>
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
                <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../script.js"></script>
</body>
</html>