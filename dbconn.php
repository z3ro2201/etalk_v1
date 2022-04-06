<?php
$sha256_key = "";
$db = new mysqli("", "", "", "");
if (mysqli_connect_error()) {
        exit("ERROR");
}

$db->query("SET NAMES utf8");
?>
