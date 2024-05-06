<?php
require_once('../function.php');
init_connection();
$products = getProductToDisplay();
header('Content-Type: application/json');
echo json_encode($products);
