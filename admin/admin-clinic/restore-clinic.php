<?php
session_start();
require_once('../function.php');
check_login();
init_connection();
$id = intval($_GET['id'] ?? '');
restoreClinic($id);
header('Location: index.php');
?>