<?php

session_start();
require_once ('../function.php');
check_login();

$rows=getProfessionalAllPosts();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Professional Education</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/education.css">
    <script src="https://kit.fontawesome.com/ad6cc57e98.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script.js"></script>
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">

        <div class="table-wrapper">
            <div class="table-title-professional">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>Professional Education Posts List</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="add-professional.php" class="btn btn-success" data-toggle="modal"><i class="fa-solid fa-plus"></i> <span>Add Post</span></a>
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
                <tbody>

                    
                    <?php $order = 0;
                    foreach($rows as $row) { 
                        ?>
                <tr>
                    <td><?php $order+=1; echo $order;  ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><?php echo $row['post_title']?></td>
                    <td><?php if ($row['media_type'] == 'image/png' ||  $row['media_type'] == 'image/jpg' || $row['media_type'] == 'image/jpeg'): ?>
                            <img id="current_media" src="<?php echo $row['media_path']; ?>"
                                 alt="Current Media" style="width: 300px; height: auto;">
                        <?php elseif ($row['media_type'] == 'video/mp4'): ?>
                            <video id="current_media" controls style="width: 300px; height: auto;">
                                <source src="<?php echo $row['media_path']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php 
                        echo substr($row['post_content'], 0, 255);
                         if(strlen($row['post_content']) > 255){
                         echo "...";
                        }
                    ?>
                    </td>
                    <td><?php echo $row['post_created_at'] ?></td>
                    <td><?php if($row['post_is_deleted']==1) {
                        echo "Inactive";
                    }else{
                        echo "Active";
                    }
                     ?>
                        
                    </td>
                    <td>
                        <a href="edit-professional.php?post_id=<?php echo $row['post_id'] ?>" class="edit"><i
                                    class="fa-regular fa-pen-to-square"></i></a>
                        <?php if ($row['post_is_deleted'] == 1): ?>
                            <a href="restore-professional.php?post_id=<?php echo $row['post_id'] ?>" class="restore"><i class="fa-solid fa-rotate-left"></i></a>
                        <?php else: ?>
                            <a href="delete-professional.php?post_id=<?php echo $row['post_id'] ?>" class="delete"><i class="fa-solid fa-trash"></i></a>
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
                








