<?
@header('Content-Type:application/json;charset=utf-8');
$apikey = "";
$url = "http://openapi.seoul.go.kr:8088/$apikey/json/TbCorona19CountStatus/1/7/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
