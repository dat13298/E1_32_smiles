<?php
session_start();
require_once('../function.php');
check_login();


//$user = getUser($UserId);
$userInfo = getUser($_SESSION['user_id']);
$rows=getAllUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/dashboard.css">
    <script src="https://kit.fontawesome.com/ad6cc57e98.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script.js"></script>
</head>
<body>
<div class="main--content">

    <div class="header--wrapper">
        <div class="header--title">
            <span>Primary</span>
            <h2>Dashboard</h2>
        </div>

        <div class="user--info">
            <a href="#">
                <i class="fas fa-sign-out-alt"></i>
                <span> <a href="../logout.php">Logout</a></span>
            </a>
        </div>
    </div>

    <div class="crud--container">
        <h1 class="main--title">Management Content</h1>
        <div class="card--wrapper">

            <a href="../admin-professional/index.php">
                <div class="crud--card light-lighterblue">
                    <div class="card--header">
                        <div class="amount">

                            <span class="amount--value">
                                Professional Education
                            </span>
                        </div>
                        <i class="fa-solid fa-laptop-file icon dark-lightblue"></i>
                    </div>
                </div>
            </a>

            <a href="../admin-patient/index.php">
                <div class="crud--card light-red">
                    <div class="card--header">
                        <div class="amount">

                            <span class="amount--value">
                                Patient Education
                            </span>

                        </div>
                        <i class="fa-solid fa-person-chalkboard icon dark-red"></i>
                    </div>
                </div>
            </a>

            <a href="../admin-research">
                <div class="crud--card light-green">
                    <div class="card--header">
                        <div class="amount">
                            <span class="amount--value">
                                Research
                            </span>
                        </div>
                        <i class="fa-solid fa-book icon dark-green"></i>
                    </div>
                </div>
            </a>

            <a href="../admin-product/index.php">
                <div class="crud--card light-blue">
                    <div class="card--header">
                        <div class="amount">
                            <span class="amount--value">
                                Product
                            </span>
                        </div>
                        <i class="fa-solid fa-box icon dark-blue"></i>
                    </div>
                </div>
            </a>

            <a href="../admin-clinic/index.php">
                <div class="crud--card light-yellow">
                    <div class="card--header">
                        <div class="amount">

                                <span class="amount--value">
                                    Clinic
                                </span>
                        </div>
                        <i class="fa-solid fa-building icon dark-yellow"></i>
                    </div>

                </div>
            </a>
            <a href="../admin-contact-us/index.php">
                <div class="crud--card light-purple">
                    <div class="card--header">
                        <div class="amount">

                                <span class="amount--value">
                                    Contact Us
                                </span>
                        </div>
                        <i class="fa-solid fa-envelope icon dark-purple"></i>
                    </div>

                </div>
            </a>


        </div>
    </div>


    <?php if($userInfo['role'] == "admin") { ?>
    <div class="tabular--wrapper">

        <div class="data--wrapper">
            <div class="data--title">
                <h1 class="main--title">User Data</h1>
            </div>

            <div class="user--info">
                <a href="add-user.php">
                    <button class="add-button"><i class="fa-solid fa-plus"></i> Add New User</button>
                </a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Create at</th>
                    <th>Update at</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>
                <tbody>
                <?php $order = 0;
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php $order += 1;
                            echo $order; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['password_hash']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo $row['updated_at']; ?></td>
                        <td><?php if ($row['status'] == 1) {
                                echo "Active";
                            } else {
                                echo "Inactive";
                            }

                            ?></td>
                        <td>
                            <a href="edit-user.php?user_id=<?php echo $row['user_id'] ?>" class="edit"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                            <?php if ($row['is_deleted'] == 1): ?>
                                <a href="restore-user.php?user_id=<?php echo $row['user_id'] ?>" class="restore"><i class="fa-solid fa-rotate-left"></i></a>
                            <?php else: ?>
                                <a href="delete-user.php?user_id=<?php echo $row['user_id'] ?>" class="delete"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="9"></td>
                </tr>
                </tfoot>

                </thead>
            </table>

        </div>

    </div>
    <?php } ?>


</div>
</body>
<script>confirmDelete()</script>
</html>