<?php
require_once('../function.php');
init_connection();
$clinics = getAllClinicToDisplay();
header('Content-Type: application/json');
echo json_encode($clinics);