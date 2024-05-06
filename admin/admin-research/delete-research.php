<?php
require_once "../function.php";
init_connection();
check_login();

$post_id = intval(isset($_GET['post_id']) ? $_GET['post_id'] : '');

if ($post_id) {
    deleteResearch($post_id);
    header('Location: index.php');
}