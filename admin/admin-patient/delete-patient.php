<?php
session_start();
require_once('../function.php');

$PostId=intval($_GET['post_id']);
$rows=getPatientPosts($PostId);

deletePatientPosts($PostId);
header('location: index.php');
?>



