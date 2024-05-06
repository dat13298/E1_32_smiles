<?php
session_start();
require_once ('../function.php');
check_login();


$folderName = basename(dirname(__FILE__));
$errorMessages = [];
$categories = getProfessionalCategory();

$PostId = intval($_GET['post_id']); // Ensure $PostId is correctly obtained

if ($PostId > 0) {
    $rows = getProfessionalPosts($PostId);
} else {
    // Redirect or handle the error if $PostId is not valid
    $errorMessages['post'] = "Invalid post ID.";
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $file = $_FILES['post_image'] ?? null;
    $title = $_POST['post_title'] ?? '';
    $category = $_POST['category'];
    $content = $_POST['post_content'] ?? '';
    $mediaTitle = $_POST['media_description'] ?? '';

    // Validate form data and file
    $errorMessages = validatePost($title, $content, $file, $mediaTitle);

    if (empty($errorMessages)) {
        // Handle file upload; returns the file path or false
        $uploadedFile = $file['tmp_name'];
        $uploadedFileName = $file['name'];


        $editSuccess = editProfessionalPosts($PostId, $category, $title, $content, $uploadedFile, $uploadedFileName, $mediaTitle, $folderName);
        if (!$editSuccess) {
            $errorMessages['file'] = "Failed to edit the post.";
        } 
        else{
            echo "<p>Post edited successfully.</p>";
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
    <title>Edit Professional</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <h4 class="mb-3">Edit Professional</h4>
        <form action="edit-professional.php?post_id=<?php echo $PostId ?>" method="post" enctype="multipart/form-data"
              onsubmit="return validateUpdateForm()">


            <div class="mb-3">
                <label for="nameInput" class="form-label">Title</label>
                <input type="text" class="form-control" id="post_title" placeholder="Enter Title Here" name="post_title" value="<?php echo $rows['post_title']; ?>">
                <?php if (isset($errorMessages['title'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['title']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">

                <label for="emailInput" class="form-label">Content</label>
                <textarea class="form-control" id="post_content" rows="3" name="post_content" ><?php echo $rows['post_content']; ?></textarea>
                <?php if (isset($errorMessages['content'])): ?>
                    <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['content']; ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="current_media" class="form-label"><strong>Current Media File</strong></label>
                <div>
                    <?php if ($rows['media_type'] == 'image/png' ||  $rows['media_type'] == 'image/jpg' || $rows['media_type'] == 'image/jpeg'): ?>
                        <img id="current_media" src="<?php echo $rows['media_path']; ?>"
                             alt="Current Media" style="width: 300px; height: auto;">
                    <?php elseif ($rows['media_type'] == 'video/mp4'): ?>
                        <video id="current_media" controls style="width: 300px; height: auto;">
                            <source src="<?php echo $rows['media_path']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                </div>
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
                <input class="form-control" type="text" id="media_description" name="media_description" value="<?php echo $rows['media_text'] ?>">
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
                        <option value="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>



            <button type="submit" class="btn btn-success">Edit</button>
            <a href="index.php" class="btn btn-secondary">Back</a>


        </form>
    </div>
</div>


</body>
</html>