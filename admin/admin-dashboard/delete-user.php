<?php
require_once('../function.php');
$UserId=intval($_GET['user_id']);
deleteUser($UserId);
header('location: index.php');
?>



