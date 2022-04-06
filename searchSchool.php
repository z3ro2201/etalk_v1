<?
	@header("Content-Type:application/json");
	
	include_once $_SERVER["DOCUMENT_ROOT"]."../components/dbconn.php";

	$arr = array();

	if($_GET['schoolname']){
		$cnt = $db->query("SELECT COUNT(*) AS tot FROM test_schoollist WHERE school_name LIKE '%".$_GET['schoolname']."%' ORDER BY nid ASC")->fetch_assoc();
		$sql = "SELECT * FROM test_schoollist WHERE school_name LIKE '%".$_GET['schoolname']."%' ORDER BY nid ASC";
		$qry = $db->query($sql);
		$i=0;

		if($qry) {
			$arr["code"] = 200;
			$arr["message"] = "OK";
			$arr["schoolinfo"]["count"] = $cnt['tot'];
			while($row = $qry->fetch_assoc()) {
				$arr["schoolinfo"][$i]["name"] = $row['school_name'];
				$arr["schoolinfo"][$i]["code"] = $row['school_code'];
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

