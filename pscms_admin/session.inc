<?php
error_reporting(E_ALL & ~ E_NOTICE);
//error_reporting(E_ALL);
require("cookie.inc");
extract($_REQUEST);
$sava_path="./session/";
session_save_path($sava_path);
session_start();
extract($_SESSION);
?>
