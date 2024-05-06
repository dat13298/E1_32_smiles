<?php
    require_once('../function.php');
    $errorMessages = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $status = 1;
        $password_hash = hash('sha256', $_POST['password']);
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';

        $errorMessages = validateUser($username, $password_hash, $phone, $email);

        if(empty($errorMessages)){
            $add = addUser($username, $password_hash,$phone, $email, $status);
            if(!$add){
                $errorMessages['phone'] = "Error add user";
            }
            header('location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Professional</title>
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
</head>
<body>

<div class="container">
    <div class="form-container bg-light border rounded p-4 shadow">
        <h4 class="mb-3">Add New User</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" onsubmit="return validateForm()">

            <div class="mb-3">
                <label for="nameInput" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username Here" name="username">
            </div>

            <?php if (isset($errorMessages['username'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['username']; ?></div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="emailInput" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password Here" name="password">
            </div>

            <?php if (isset($errorMessages['password_hash'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['password_hash']; ?></div>
                </div>
            <?php endif; ?>


            <div class="mb-3">
                <label for="formFile" class="form-label">Phone</label>
                <input class="form-control" type="number" id="phone" name="phone">
            </div>

            <?php if (isset($errorMessages['phone'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['phone']; ?></div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="formFile" class="form-label">Email</label>
                <input class="form-control" type="email" id="email" name="email">
            </div>

            <?php if (isset($errorMessages['email'])): ?>
                <div class="errormsg">
                    <div class="alert alert-danger"><?php echo $errorMessages['email']; ?></div>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success">Add</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

</body>
</html>