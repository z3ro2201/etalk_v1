<?
@session_start();
@header("Content-Type:text/html;charset=utf-8");
include_once $_SERVER["DOCUMENT_ROOT"]."/dbconn.php";

$user_name = $_POST['student_name'];
$user_passwd = $_POST['user_passwd'];
$school_code = $_POST['school_code'];
$school_name = $_POST['school_name'];
$sessid = session_id();
$login_ip = $_SERVER['REMOTE_ADDR'];
echo "test";

if($_POST['lm'] == "login") {
	/*
		암호화를 위한 쿼리 함수
	$sql = "SELECT * FROM chk_user WHERE user_name = AES_ENCRYPT('$user_name', '$sha256_key') AND user_schoolname = AES_ENCRYPT('$school_name', '$sha256_key') AND user_schoolcode = AES_ENCRYPT('$school_code', '$sha256_key')";*/
	$sql = "SELECT * FROM chk_user WHERE user_name ='$user_name' AND user_schoolname = '$school_name' AND user_schoolcode = '$school_code'";

	$result = $db->query($sql)->fetch_assoc();

	if(!$result) {		
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_schoolcode'] = $school_code;
		$_SESSION['user_schoolname'] = $school_name;

		@header('Location: /covid19.userAdd.php');
		exit;
	}

	$_SESSION['user_name'] = $result['user_name'];
	$_SESSION['user_ssn'] = $result['user_ssn'];
	$_SESSION['user_schoolcode'] = $result['user_schoolcode'];
	$_SESSION['user_schoolname'] = $result['user_schoolname'];
	$_SESSION['SESSID'] = $sessid;
	echo "<script>\nlocalStorage.setItem('user_ssn', '$result[user_ssn]');\nwindow.location.href='/';\n</script>\r";
	exit();
}

if($_POST['lm'] == "insert") {
	$sql = "SELECT COUNT(*) AS cnt FROM chk_user WHERE user_schoolcode = '$school_code'";
	$count = (int)$db->query($sql)->fetch_assoc()['cnt'] + 1;
	//$new_ssn = base64_encode(hash('sha256', $school_code . "_STD_" . $count, true));
$new_ssn = $school_code."_STD_".$count;
	/* 암호화를 위한 테이블 쿼리
	$sql = "INSERT INTO chk_user (user_ssn, user_name, user_passwd, user_schoolcode, user_schoolname) VALUES ('$new_ssn', HEX(AES_ENCRYPT('$user_name', '$sha256_key')), SHA2('$user_passwd', 512), HEX(AES_ENCRYPT('$school_code', '$sha256_key')), HEX(AES_ENCRYPT('$school_name', '$sha256_key')))";*/
	$sql = "INSERT INTO chk_user (user_ssn, user_name, user_passwd, user_schoolcode, user_schoolname, sessid, login_ip) VALUES ('$new_ssn', '$user_name', SHA2('$user_passwd', 512), '$school_code', '$school_name', '$sessid', '$login_ip')";
	$result = $db->query($sql);
	if(!$result) {
		echo "<meta charset=\"utf-8\">\n";
		echo "<script>\nalert('시스템에 문제가 발생하였습니다.\\n담당선생님께 문의해주세요.');\nlocation.history.back(-1);\n</script>\r";
		exit();
	}

	// 암호화된 사용자 정보로 변경
	$sql = "SELECT * FROM chk_user WHERE user_ssn = '$new_ssn'";

	$data = $db->query($sql)->fetch_assoc();

	echo "<script>\nlocalStorage.setItem('user_ssn', '$new_ssn');localStorage.setItem('softver', '1.0.1');\nwindow.location.href='/';\n</script>\r";
	exit();
}

if($_POST['lm'] == "wakeOn") {
	$sessid = $_POST['sessid'];
	$user_ssn = $_POST['user_ssn'];
	$sql = "SELECT * FROM chk_user WHERE user_ssn = '$user_ssn' AND user_passwd = SHA2('$user_passwd', 512)";

	$result = $db->query($sql)->fetch_assoc();

	if(!$result) {
		echo "<meta charset=\"utf-8\">\n";
		echo "<script>\nalert('입력하신 비밀번호가 다릅니다.\\n다시한번 확인해 주세요.\\n만약 비밀번호를 잊어버리셨다면 담당선생님께 문의해주세요.');\nlocation.href='/';\n</script>\r";
		exit();
	}

	$_SESSION['ssn'] = $user_ssn;
	if($result[sessid] !== $sessid) {
		echo "<meta charset=\"utf-8\">\n";
		echo "<script>\nalert('새로운 로그인정보입니다.');</script>";
	}

	@header('Location: /covid19.userLogon.php');
	exit();
}

echo "<meta charset=\"utf-8\">\n";
echo "<script>\nalert('잘못된 접근입니다.');\n location.href = '/';\n</script>\r";
exit();

?>
