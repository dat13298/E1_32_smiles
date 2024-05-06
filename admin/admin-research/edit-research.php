<?php
session_start();
require_once '../function.php';
check_login();
init_connection();
$post_id = intval(isset($_GET['post_id']) ? $_GET['post_id'] : '');
$post = getPostByID($post_id);
$media = getMediaByPostID($post_id);
$categories = getResearchCategory();
$errorMessages = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $category = $_POST['category'];
    $description = $_POST['media_description'];
    $imagePath = null; // Giá trị mặc định là null

    // Kiểm tra nếu có file mới được tải lên
    if (!empty($_FILES['post_image']['name'])) {
        $uploadedFile = $_FILES['post_image']['tmp_name'];
        $uploadedFileName = $_FILES['post_image']['name'];
        $imagePath = validateFile($uploadedFile, $uploadedFileName);

        if (!$imagePath) {
            $errorMessages['file'] = 'Upload failed or validation failed.';
        }
    }

    // Validate title and content
    if (empty($post_title)) {
        $errorMessages['title'] = 'Title is required.';
    }
    if (empty($post_content)) {
        $errorMessages['content'] = 'Content is required.';
    }

    // Cập nhật bài viết nếu không có lỗi
    if (empty($errorMessages)) {
        $updateSuccess = updatePost($post_id, $category, $post_title, $post_content, $imagePath,  $description);
        if ($updateSuccess) {
            // Chuyển hướng người dùng về trang index sau khi cập nhật thành công
            header('Location: index.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Research</title>
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
        <h4 class="mb-3">Edit Research</h4>
        <form action="edit-research.php?post_id=<?php echo $post_id?>" method="post" enctype="multipart/form-data"
              onsubmit="return validateUpdateForm()">
            <div class="mb-3">
                <label for="post_title" class="form-label">Title</label>
                <input type="text" class="form-control" id="post_title" placeholder="Enter Title Here"
                       name="post_title" value="<?php echo $post['post_title'] ?>">
                <?php if (isset($errorMessages['title'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['title']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="post_content" class="form-label">Content</label>
                <textarea class="form-control" id="post_content" rows="3"
                          name="post_content"><?php echo $post['post_content'] ?></textarea>
                <?php if (isset($errorMessages['content'])): ?>
                    <div class="errormsg">
                        <div class="alert alert-danger"><?php echo $errorMessages['content']; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($media['media_path'])): ?>
                <div class="mb-3">
                    <label for="current_media" class="form-label">Current Media File</label>
                    <div>
                        <?php if ($media['media_type'] == 'image'): ?>
                            <img id="current_media" src="<?php echo $media['media_path']; ?>"
                                 alt="Current Media" style="width: 100%; max-width: 400px; height: auto;">
                        <?php elseif ($media['media_type'] == 'video'): ?>
                            <video id="current_media" controls style="width: 100%; max-width: 400px; height: auto;">
                                <source src="<?php echo $media['media_path']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
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
                <input class="form-control" type="text" id="media_description" name="media_description"
                       value="<?php echo $media['media_text'] ?>">
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
            <button type="submit" class="btn btn-success">Save</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
</body>
</html>