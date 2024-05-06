<?php
session_start();
require_once ('../function.php');
check_login();
init_connection();
$contacts = getAllContact();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Feedback</title>
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
            <div class="table-title" style="background-color:purple;">
                <div class="row">
                    <div class="col-sm-12">
                        <h2><b>Feedback List</b></h2>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>username</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($contacts as $contact) {?>
                    <tr>
                        <th scope="row"><?= $contact['contact_id']; ?></th>
                        <td><?= $contact['contact_name']; ?></td>
                        <td><?= $contact['contact_title']; ?></td>
                        <td><?= $contact['contact_message']; ?></td>
                        <td><?= $contact['contact_phone']; ?></td>
                        <td><?= $contact['contact_email']; ?></td>
                        <td><?php $dateTime = new DateTime($contact['contact_created_at']);
                            $formatDateTime = date_format($dateTime, 'd-m-Y H:i:s');
                            echo $formatDateTime;
                            ?>
                        </td>
                        <td><?php if ($contact['contact_is_deleted'] == 1) {
                                echo "The response has been processed";
                            } else {
                                echo "The response has not yet been processed";
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($contact['contact_is_deleted'] == 1): ?>
                                <a href="restore-contact.php?id=<?php echo $contact['contact_id'] ?>" class="restore"><i class="fa-solid fa-rotate-left"></i></a>
                            <?php else: ?>
                                <a href="delete-contact.php?id=<?= $contact['contact_id'] ?>" ><i class="fa-solid fa-square-check" style="color: #2db48b;"></i></a>
                            <?php endif; ?>
                        </td>
                        <td></td>

                    </tr>
                <?php }?>
                <!-- More rows as needed -->
                </tbody>
            </table>

            <div class="clearfix">
                <a href="../admin-dashboard/" class="btn btn-danger">Back</a>
            </div>

        </div>
    </div>
</div>
<script>confirmDelete()</script>
</body>
</html>