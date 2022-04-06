<?
@header('Content-Type:application/json;charset=utf-8');
 error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
$url = "http://openapi.seoul.go.kr:8088/504744597876697435334a70766254/json/TbCorona19CountStatus/1/7/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>