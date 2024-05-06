<?php
require_once('../function.php');
init_connection();

$userId = intval($_GET['user_id']);
$row = getUser($userId);
$password_raw = $_POST['password'] ?? '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password_hash = hash('sha256', $password_raw);
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    $errorMessages = validateUser($username, $password_hash, $phone, $email);

    if(empty($errorMessages)){
        editUser($username, $password_hash,$phone, $email,  $userId);
        header('location: index.php');
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
</head>
<body>

<div class="container">
    <div class="form-container bg-light border rounded p-4 shadow">
        <h4 class="mb-3">Edit Professional</h4>
        <form action="edit-user.php?user_id=<?php echo $row['user_id'] ?>" method="post" enctype="multipart/form-data" onsubmit="return validateUpdateForm()">


            <div class="mb-3">
                <label for="nameInput" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username Here" name="username" value="<?php echo $row['username']; ?>">
            </div>

            <?php if (isset($errorMessages['username'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['username']; ?></div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="emailInput" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password Here" name="password" value="<?php echo $row['password_hash']; ?>">
            </div>

            <?php if (isset($errorMessages['password_hash'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['password_hash']; ?></div>
                </div>
            <?php endif; ?>


            <div class="mb-3">
                <label for="formFile" class="form-label">Phone</label>
                <input class="form-control" type="number" id="phone" name="phone" value="<?php echo $row['phone']; ?>">
            </div>

            <?php if (isset($errorMessages['phone'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['phone']; ?></div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="formFile" class="form-label">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $row['email']; ?>">
            </div>

            <?php if (isset($errorMessages['email'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['email']; ?></div>
                </div>
            <?php endif; ?>



            <button type="submit" class="btn btn-success">Edit</button>
            <a href="index.php" class="btn btn-secondary">Back</a>


        </form>
    </div>
</div>


</body>
</html>

