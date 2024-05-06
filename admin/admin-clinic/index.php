<?php
session_start();
require_once('../function.php');
check_login();
init_connection();
$clinics = getAllClinic();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Clinic</title>
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
            <div class="table-title" style="background-color: rgb(255, 238, 0);">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>Clinic List</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="add-edit-clinic.php" class="btn btn-primary" data-toggle="modal"><i
                                    class="fa-solid fa-plus"></i> <span>Add Clinic</span></a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Clinic Name</th>
                    <th>Media</th>
                    <th>Description</th>
                    <th>Phonenumber</th>
                    <th>Address</th>
                    <th>Create At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody><?php $order = 0; foreach ($clinics as $clinic) {
                    ?>
                    <tr>
                        <td><?php $order += 1;
                            echo $order; ?></td>
                        <td><?= $clinic['clinic_name']; ?></td>
                        <td><img style="height: 100px;" src="<?= $clinic['media_path']; ?>" alt="image"></td>
                        <td><?= $clinic['clinic_description']; ?></td>
                        <td><?= $clinic['clinic_phone_number']; ?></td>
                        <td><?= $clinic['clinic_address']; ?></td>
                        <td><?php $dateTime = new DateTime($clinic['clinic_create_at']);
                            $formatDateTime = date_format($dateTime, 'd-m-Y H:i:s');
                            echo $formatDateTime;
                            ?>
                        </td>
                        <td><?php if ($clinic['clinic_is_deleted'] == 1) {
                                echo "Inactive";
                            } else {
                                echo "Active";
                            }
                            ?>

                        </td>
                        <td>
                            <a href="add-edit-clinic.php?id=<?php echo $clinic['clinic_id'] ?>" class="edit"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                            <?php if ($clinic['clinic_is_deleted'] == 1): ?>
                                <a href="restore-clinic.php?id=<?php echo $clinic['clinic_id'] ?>" class="restore"><i class="fa-solid fa-rotate-left"></i></a>
                            <?php else: ?>
                                <a href="delete-clinic.php?id=<?php echo $clinic['clinic_id'] ?>" class="delete"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
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