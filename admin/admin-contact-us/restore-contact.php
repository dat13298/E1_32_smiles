
<?php
require_once('../function.php');
session_start();
check_login();
init_connection();
$id = intval($_GET['id'] ?? '');
restoreContact($id);
header('location:index.php');
