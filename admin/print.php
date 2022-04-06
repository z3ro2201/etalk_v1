<?
include_once("../dbconn.php");
$member_count = $db->query("SELECT COUNT(*) AS cnt FROM chk_user")->fetch_assoc();
/* 페이징 시작 */
    $today = date('Y-m-d');
    if(!$_GET['days']) $days=$today;
    else $days=$_GET['days'];

    $normal = $db->query("SELECT COUNT(*) as normal FROM check_report WHERE user_val = '0' AND regdate = '$days'")->fetch_assoc()['normal']; // 정상
    $confirm = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE user_val >= '1' AND regdate = '$days'")->fetch_assoc()['confirm']; // 확인필요
    $tot = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE regdate = '$days'")->fetch_assoc();

    $nope = $member_count['cnt'] - $tot['all'];
    
    $sql = "select * from check_report where regdate = '$days' order by nid desc"; 
    $result = $db->query($sql);
?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache"> 
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
        <meta name="description" content="서울특별시강동송파교육지원청 영재교육원 (서울천일초등학교) 학생 건강상태 자가진단" />
		<title>서울특별시강동송파교육지원청 영재교육원 (서울천일초등학교) 학생 건강상태 자가진단</title>
        <link rel="stylesheet" href="/assets/semantic/semantic.min.css">
        <script src="/assets/jquery/jquery-3.6.0.min.js"></script>
        <script src="/assets/semantic/semantic.min.js"></script>
        <script for=window event=onload>
            window.print();
        </script>
    </head>

    <body>
        <div id="container">
            <div class="main ui intro container">
                <div class="ui row" style="padding:10px 0px">
                    대상일 <?=date('Y년 m월 d일', strtotime($days));?> / 전체 <?=$member_count[cnt];?>명 / 정상: <?=$normal;?>명 / 유증상 <?=$confirm;?> 명 / 미참여 <?=$nope;?> 명
                </div>
                <table class="ui celled padded table">
                    <thead>
                        <tr class="center aligned">
                            <th rowspan="2">참여여부</th>
                                <th rowspan="2">성명</th>
                                <th rowspan="2">학교명</th>
                                <th colspan="2">발열 및<br>임상증상 여부</th>
                                <th colspan="2">본인 또는 동거인<br>진단검사 후 결과대기</th>
                                <th colspan="2">본인 또는 동거인<br>자가격리</th>
                            </tr>
                            <tr class="center aligned">
                                <th>가능</th>
                                <th>중지</th>
                                <th>가능</th>
                                <th>중지</th>
                                <th>가능</th>
                                <th>중지</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            while($row = $result->fetch_assoc())
                            {
                                $datetime = explode(' ', $row['b_date']);
                                $date = $datetime[0];
                                $time = $datetime[1];
                                if($date == Date('Y-m-d')) $row['b_date'] = $time;
                                else $row['b_date'] = $date;
                            ?>
                            <tr class="center aligned">
                                <td>
                                    <?=$row['user_val']==0?'<a class="ui blue label">정상</a>':'<a class="ui red label">확인필요</a>';?><br>
                                    <?=date('H:i:s', strtotime($row['regdatetime']));?>
                                </td>
                                <td><?=$row['user_name'];?></td>
                                <td><?=$row['user_schoolname'];?></td>
                                <td><?=$row['user_q1']==0?'O':'';?></td>
                                <td><?=$row['user_q1']==0?'':'O';?></td>
                                <td><?=$row['user_q2']==0?'O':'';?></td>
                                <td><?=$row['user_q2']==0?'':'O';?></td>
                                <td><?=$row['user_q3']==0?'O':'';?></td>
                                <td><?=$row['user_q3']==0?'':'O';?></td>
                            </tr>
                            <? }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
