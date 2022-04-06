<?
	@header("Content-Type:application/json");
	
	include_once $_SERVER["DOCUMENT_ROOT"]."/dbconn.php";

	$arr = array();
	$date = date('Y-m-d');

	if($_GET['schoolcode']){
		$cnt = $db->query("SELECT COUNT(*) AS tot FROM check_report WHERE user_ssn = '".$_GET['ssn']."' AND user_schoolcode = '" . $_GET['schoolcode'] . "' AND user_name = '" . $_GET['username']. "' AND regdate = '$date' ORDER BY nid ASC")->fetch_assoc();
		$sql = "SELECT * FROM check_report WHERE user_ssn = '".$_GET['ssn']."' AND user_schoolcode = '" . $_GET['schoolcode'] . "' AND user_name = '" . $_GET['username']. "' AND regdate = '$date' ORDER BY nid ASC";

		$qry = $db->query($sql);
		$i=0;

		if($qry) {
			$arr["code"] = 200;
			$arr["message"] = "OK";
			$arr["covid19"]["count"] = $cnt['tot'];
			while($row = $qry->fetch_assoc()) {
				$arr["covid19"][$i]["username"] = $row['user_name'];
				$arr["covid19"][$i]["schoolname"] = $row['user_schoolname'];
				if($row['user_val'] >= 1) $arr["covid19"][$i]["code"] = 1;
				else $arr["covid19"][$i]["code"] = 0;
				$i++;
			}
		} else {
			$arr["code"] = 204;
			$arr["message"] = "No Content";
		}
	} else {
		$arr["code"] = 204;
		$arr["message"] = "No Content";
	}

	//if($arr == null) $arr["code"] = "403";

	print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
?>

