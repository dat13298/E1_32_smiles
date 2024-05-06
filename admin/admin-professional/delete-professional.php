<?php
session_start();
require_once ('../function.php');
$PostId=intval($_GET['post_id']);
deleteProfessionalPosts($PostId);
header('location: index.php');
?>



