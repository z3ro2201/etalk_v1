<?
session_start();
include_once $_SERVER["DOCUMENT_ROOT"]."/dbconn.php";
if($_SESSION['loginUser'] == true) @header('Location: /admin/index.php');

$id = htmlspecialchars($_POST['id']);
$pw = htmlspecialchars($_POST['password']);

$result = $db->query("SELECT * FROM test_admin WHERE adm_id = '$id' AND adm_pw = SHA2('$pw', 512)");

if(!$result) exit("<script> alert('잘못된 정보입니다.\\n다시한번 확인해주십시요.'); location.href='/admin/login.php';</script>");

$sql = "UPDATE test_admin SET adm_ip = '$_SERVER[REMOTE_ADDR]' WHERE adm_id = '$id'";
$db->query($sql);
$_SESSION['loginUser'] = $id;
@header('Location: /admin/index.php');
