<?php
session_start();
require_once ('../function.php');
check_login();
init_connection();
$products = getAllProduct();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product</title>
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
            <div class="table-title" style="background-color: blue;">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>Product List</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="add-edit-product.php" class="btn btn-primary" data-toggle="modal"><i
                                    class="fa-solid fa-plus"></i> <span>Add Product</span></a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Categorization</th>
                    <th scope="col">Media</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody><?php $order = 0; foreach ($products as $product) {
                    ?>
                    <tr>
                        <td><?php $order += 1;
                            echo $order; ?></td>
                        <td><?= $product['product_name']; ?></td>
                        <td><?= $product['category_name']; ?></td>
                        <td><img style="height: 100px;" src="<?= $product['media_path']; ?>" alt="image"></td>
                        <td><?= $product['product_description']; ?></td>

                        <td><?= $product['product_price']; ?></td>

                        <td><?php $dateTime = new DateTime($product['product_created_at']);
                            $formatDateTime = date_format($dateTime, 'd-m-Y H:i:s');
                            echo $formatDateTime;
                            ?>
                        </td>
                        <td><?php if ($product['product_is_deleted'] == 1) {
                                echo "Inactive";
                            } else {
                                echo "Active";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="add-edit-product.php?id=<?php echo $product['product_id'] ?>" class="edit"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                            <?php if ($product['product_is_deleted'] == 1): ?>
                                <a href="restore-product.php?id=<?php echo $product['product_id'] ?>" class="restore"><i class="fa-solid fa-rotate-left"></i></a>
                            <?php else: ?>
                                <a href="delete-product.php?id=<?php echo $product['product_id'] ?>" class="delete"><i class="fa-solid fa-trash"></i></a>
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