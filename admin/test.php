<?

include_once $_SERVER["DOCUMENT_ROOT"]."/dbconn.php";
$result=$db->query("INSERT INTO test_admin (adm_id,adm_pw,adm_name) VALUES ('chunil1001', SHA2('chunil1001', 512), '천일초', '')");
if(!$result) echo 'ERRR';
