<?php
session_start();
require_once('../function.php');
check_login();

$folderName = basename(dirname(__FILE__));
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['post_image'] ?? null;
    $category = 2;
    $title = $_POST['post_title'] ?? '';
    $content = $_POST['post_content'] ?? '';
    $mediaTitle = $_POST['media_description'] ?? '';

    // Validate form data and file
    $errorMessages = validatePost($title, $content, $file, $mediaTitle);

    if (empty($errorMessages)) {
        // Handle file upload; returns the file path or false
        $uploadedFile = $file['tmp_name'];
        $uploadedFileName = $file['name'];
        $fileType = $file['type'];

        // Validate and upload file
        $filePath = validateFile($uploadedFile, $uploadedFileName, $folderName);

        if ($filePath !== false) {
            // Successfully uploaded, proceed with database insertion
            $postId = addPatientPosts($title, $content, $category);
            if ($postId !== false) {
                $mediaId = addFileMedia($fileType, $filePath, $mediaTitle);
                if ($mediaId !== false) {
                    addPairToItemMedia($postId, $mediaId, 'posts');
                    header('location: index.php');
                } else {
                    $errorMessages['database'] = "Failed to insert media information into the database.";
                }
            } else {
                $errorMessages['database'] = "Failed to insert post into the database.";
            }
        } else {
            $errorMessages['file'] = "This file is not an image or video type";
        }
    }
    // Handle or display $errorMessages as needed
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }
        .errormsg{
            margin:5px 0px 10px 0px;
        }
  
    </style>
    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <div class="form-container bg-light border rounded p-4 shadow">
        <h4 class="mb-3">Add Patient</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

            <div class="mb-3">
                <label for="nameInput" class="form-label">Title</label>
                <input type="text" class="form-control" id="post_title" placeholder="Enter Title Here" name="post_title">
                <?php if (isset($errorMessages['title'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['title']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="emailInput" class="form-label">Content</label>
                <textarea class="form-control" id="post_content" rows="3" name="post_content"></textarea>
                <?php if (isset($errorMessages['content'])): ?>
                    <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['content']; ?></div>
                    </div>
                <?php endif; ?>
            </div>


            <div class="mb-3">
                <label for="formFile" class="form-label">Media File</label>
                <input class="form-control" type="file" id="post_image" name="post_image">
                <?php if (isset($errorMessages['file'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['file']; ?></div>
                    </div>
                <?php endif; ?>
            </div>

                        <div class="mb-3">
                <label for="formFile" class="form-label">Media Title</label>
                <input class="form-control" type="text" id="media_description" name="media_description">
                <?php if (isset($errorMessages['mediaTitle'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['mediaTitle']; ?></div>
                    </div>
                <?php endif; ?>
            </div>


            <button type="submit" class="btn btn-success">Add</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>


</body>
</html>


