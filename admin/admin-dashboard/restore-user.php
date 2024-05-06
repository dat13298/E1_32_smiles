<?php
require_once('../function.php');
init_connection();
$id = intval($_GET['user_id'] ?? '');
restoreUser($id);
header('Location: index.php');
?>