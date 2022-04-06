<?
@session_start();
if($_SESSION['loginUser'] == false) @header('Location: /admin/login.php');
else @header('Location: /admin/admin.dashboard.php');
echo "test";
