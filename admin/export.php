<?
include_once("../dbconn.php");
$date = date('ymd');
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=covid19-$date".".xls" ); 
header( "Content-Description: 서울천일초등학교" ); 
/* 페이징 시작 */
    $today = date('Y-m-d');
    if(!$_GET['days']) $days=$today;
    else $days=$_GET['days'];
    $normal = $db->query("SELECT COUNT(*) as normal FROM check_report WHERE user_val = '0' AND regdate = '$days'")->fetch_assoc()['normal']; // 정상
    $confirm = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE user_val >= '1' AND regdate = '$days'")->fetch_assoc()['confirm']; // 확인필요

    //페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.

    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;
    
    $sql = "select * from check_report where regdate = '$days' order by nid desc"; 
    $result = $db->query($sql);
?>
<table cellpadding="0" cellspacing="0" border="1">
    <tr align="left">
        <td cospan="11">작성일:<?=$days;?></td>
    </tr>
    <tr align="center">
        <td>성명</td>
        <td>학교명</td>
        <td>참여여부</td>
        <td>등교가능</td>
        <td>등교중지</td>
        <td>발열 및 임상증상 여부_아니오</td>
        <td>발열 및 임상증상 여부_예</td>
        <td>신속항원검사 실시여부_검사하지않음</td>
	<td>신속항원검사 실시여부_예</td>
	<td>신속항원검사 실시여부_아니오</td>
        <td>PCR 등 검사를 받고 결과대기여부_아니오</td>
	<td>PCR 등 검사를 받고 결과대기여부_예</td>
    </tr>
    <? while($row = $result->fetch_assoc()) { ?>
    <tr align="center">
        <td><?=$row['user_name'];?></td>
        <td><?=$row['user_schoolname'];?></td>
        <td>참여<br><?=date('H:i', strtotime($row['datetime']));?></td>
        <td><?=$row['user_val']==0?'O':'';?></td>
        <td><?=$row['user_val']==0?'':'O';?></td>
        <td><?=$row['user_q1']==0?'O':'';?></td>
        <td><?=$row['user_q1']==0?'':'O';?></td>
        <td><?=$row['user_q2']==-1?'O':'';?></td>
	<td><?=$row['user_q2']==0?'O':'';?></td>
	<td><?=$row['user_q2']==1?'O':'';?></td>
        <td><?=$row['user_q3']==0?'O':'';?></td>
        <td><?=$row['user_q3']==0?'':'O';?></td>
	</tr>
    <? } ?>
</table>
