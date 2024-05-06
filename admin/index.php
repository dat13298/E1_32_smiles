<?php
session_start();
require_once('function.php');

$email = $_POST['email'] ?? '';
$password_raw = $_POST['password'] ?? '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errorMessages = validateUserForm($email,$password_raw);

    if(empty($errorMessages)){

        $password = hash('sha256', $password_raw);
        $userId = successLogin($email, $password);

        if(successLogin($email,$password)){
            session_start();
            $_SESSION['user_id'] = $userId; // Store user ID in session
            $_SESSION['logged'] = true;
            header('Location: admin-dashboard/index.php');
            exit(); // Always good practice to call exit after headers redirection
        }else{
            $errorMessages['password'] = "Invalid User or Password";
        }

    }

}

?>

<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Login Page</title>
    <link href='style/login.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script type='text/javascript'></script>
    <script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
</head>

<body oncontextmenu='return false' class='snippet-body'>
<div class="container">
    <div class="row">
        <div class="offset-md-2 col-lg-5 col-md-7 offset-lg-4 offset-md-3">
            <div class="panel border bg-white">
                <div class="panel-heading">
                    <h3 class="pt-3 font-weight-bold">Login</h3>
                </div>
                <div class="panel-body p-3">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                        <div class="form-group py-2">
                            <div class="input-field"> <span class="far fa-user p-2"></span> <input type="email" name="email" placeholder="Email" > </div>
                        </div>

                        <?php if (isset($errorMessages['email'])): ?>
                            <div class="errormsg">
                                <div class="alert alert-danger"><?php echo $errorMessages['email']; ?></div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group py-2">
                            <div class="input-field"> <span class="fas fa-lock p-2"></span> <input type="password" name="password" placeholder="Enter your Password"> </div>
                        </div>

                        <?php if (isset($errorMessages['password'])): ?>
                            <div class="errormsg">
                                <div class="alert alert-danger"><?php echo $errorMessages['password']; ?></div>
                            </div>
                        <?php endif; ?>


                        <button class="btn btn-primary btn-block mt-3" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</body>
</html>