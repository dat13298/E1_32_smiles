<?php
session_start();
require_once('../function.php');
check_login();
init_connection();

$posts = getAllPostResearch();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Research</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/research.css">
    <script src="https://kit.fontawesome.com/ad6cc57e98.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script.js"></script>
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">

        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>Research List</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="create-research.php" class="btn btn-primary" data-toggle="modal"><i
                                    class="fa-solid fa-plus"></i> <span>Add Post</span></a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Media</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody><?php $order = 0; foreach ($posts as $post) {
                    $post_id = $post['post_id'];
                    $category_id = $post['category_id'];
                    $category = getCategoryByCategoryID($category_id);
                    $media = getMediaByPostID($post_id);
                    ?>
                    <tr>
                        <td><?php $order += 1;
                            echo $order; ?></td>
                        <td><?php echo ($category['category_name']); ?></td>
                        <td><?php echo $post['post_title'] ?></td>
                        <td><?php if ($media['media_type'] == 'image'): ?>
                                <img id="current_media" src="<?php echo $media['media_path']; ?>"
                                     alt="Current Media" style="width: 300px; height: auto;">
                            <?php elseif ($media['media_type'] == 'video'): ?>
                                <video id="current_media" controls style="width: 300px; height: auto;">
                                    <source src="<?php echo $media['media_path']; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?></td>
                        <td>
                            <?php
                            echo substr($post['post_content'], 0, 255);
                            if (strlen($post['post_content']) > 255) {
                                echo "...";
                            }
                            ?>
                        </td>
                        <td><?php echo $post['post_created_at'] ?></td>
                        <td><?php if ($post['post_is_deleted'] == 1) {
                                echo "Inactive";
                            } else {
                                echo "Active";
                            }
                            ?>

                        </td>
                        <td>
                            <a href="edit-research.php?post_id=<?php echo $post['post_id'] ?>" class="edit"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                            <?php if ($post['post_is_deleted'] == 1): ?>
                                <a href="restore-research.php?post_id=<?php echo $post['post_id'] ?>" class="restore"><i class="fa-solid fa-rotate-left"></i></a>
                            <?php else: ?>
                                <a href="delete-research.php?post_id=<?php echo $post['post_id'] ?>" class="delete"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>


                </tbody>
            </table>

            <div class="clearfix">
                <a href="../admin-dashboard/index.php" class="btn btn-danger">Back</a>
            </div>

        </div>
    </div>
</div>
<script>confirmDelete()</script>
</body>