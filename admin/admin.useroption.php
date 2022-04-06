<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.header.php";
if(!$_GET['option'] || !$_GET['userid']) {?>
<script>
	alert('잘못된 접근입니다.');
	location.href="/admin/admin.dashboard.php";
</script>
<?}
switch($_GET['option']) {
	case "reset":
		$option = "초기화";
		$addmsg = "\\n(초기화된 비밀번호는 1234 입니다.)";
		$sql = "UPDATE chk_user SET user_passwd = SHA2('1234', 512) WHERE user_ssn = '$_GET[userid]'";
		break;
	case "delete":
		$option = "회원 삭제";
		$sql = "DELETE FROM chk_user WHERE user_ssn = '$_GET[userid]'";
		break;
	case "trustd":
		$trustd_data = $db->query("SELECT * FROM chk_user WHERE user_ssn = '$_GET[userid]'")->fetch_assoc();
		if($trustd_data[user_trustd] == '0') {
			$option = "접근가능 대상 허가처리";
			$sql = "UPDATE chk_user SET user_trustd = '1' WHERE user_ssn = '".$_GET[userid]."'";
		} else {
			$option = "접근가능 대상 거부처리";
			$sql = "UPDATE chk_user SET user_trustd = '0' WHERE user_ssn = '".$_GET[userid]."'";
		}
		break;
	default:
?><script>
	alert('잘못된 접근입니다.');
	location.href="/admin/admin.dashboard.php";
</script>
<?
}
$result = $db->query($sql);
if(!$result) $message = "시스템에 오류가 발생하여 정상적으로 수행하지 못하였습니다.";
else $message = "$option가 완료되었습니다.$addmsg";
?>
<script>
	alert('<?=$message;?>');
	window.location.href="/admin/admin.userlist.php";
</script>
<?include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.footer.php";?>
