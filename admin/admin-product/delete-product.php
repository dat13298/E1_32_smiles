<?php
require_once('../function.php');
session_start();
check_login();
init_connection();
$id = intval($_GET['id'] ?? '');
deleteProduct( $id);
header('location:index.php');