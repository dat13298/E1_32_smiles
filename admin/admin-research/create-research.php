<?php
session_start();
require_once '../function.php';
check_login();
init_connection();
$errorMessages = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $category = $_POST['category'];
    $description = $_POST['media_description'];
    $uploadedFile = $_FILES['post_image']['tmp_name'];
    $uploadedFileName = $_FILES['post_image']['name'];
    $imagePath = validateFile($uploadedFile, $uploadedFileName);
    // Validate title and content
    if (empty($post_title)) {
        $errorMessages['title'] = 'Title is required.';
    }
    if (empty($post_content)) {
        $errorMessages['content'] = 'Content is required.';
    }

    if ($imagePath && empty($errorMessages)) {
        createPost($post_title, $post_content, $category, $description, $imagePath);
    } else {
        $errorMessages['file'] = 'Upload failed or validation failed.';
    }

}
$categories = getResearchCategory();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Professional</title>
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
    <script src="../script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
    <div class="form-container bg-light border rounded p-4 shadow">
        <h4 class="mb-3">Add Research</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="post_title" class="form-label">Title</label>
                <input type="text" class="form-control" id="post_title" placeholder="Enter Title Here"
                       name="post_title">
                <?php if (isset($errorMessages['title'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['title']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="post_content" class="form-label">Content</label>
                <textarea class="form-control" id="post_content" rows="3" name="post_content"></textarea>
                <?php if (isset($errorMessages['content'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['content']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="post_image" class="form-label">Media File</label>
                <input class="form-control" type="file" id="post_image" name="post_image">
                <?php if (isset($errorMessages['file'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['file']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="media_description" class="form-label">Media Title</label>
                <input class="form-control" type="text" id="media_description" name="media_description">
                <?php if (isset($errorMessages['mediaTitle'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['mediaTitle']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Choose category:</label>
                <select class="form-select" name="category" id="category">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
</body>
</html>


