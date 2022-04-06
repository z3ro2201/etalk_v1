<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.header.php";
if($_SESSION['loginUser'] == false) @header('Location: /admin/login.php');
$member_count = $db->query("SELECT COUNT(*) AS cnt FROM chk_user")->fetch_assoc();
/* 페이징 시작 */
    $today = date('Y-m-d');
    if(!$_GET['days']) {
        $query_string_0 = "";
        $days=$today;
    }
    else {
        $days=$_GET['days'];
        $query_string_0 = "&days=$_GET[days]";
    }
    $normal = $db->query("SELECT COUNT(*) as normal FROM check_report WHERE user_val = '0' AND regdate = '$days'")->fetch_assoc()['normal']; // 정상
    $confirm = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE user_val >= '1' AND regdate = '$days'")->fetch_assoc()['confirm']; // 확인필요
    $tot = $db->query("SELECT COUNT(*) as confirm FROM check_report WHERE regdate = '$days'")->fetch_assoc();

    $nope = $member_count['cnt'] - $tot['confirm'];
    
    /*$sql = "select * from check_report where $active $gowork regdate = '$days' order by nid desc"; 
    $result = $db->query($sql);*/

    //페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.

    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;
    
    $sql = "select count(*) as cnt from check_report where $gowork regdate = '$days' order by nid desc";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $allPost = $row['cnt']; //전체 게시글의 수
    $onePage = 15; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수
    if($page < 1 || ($allPage && $page > $allPage)) {
?>
<script>
    alert('존재하지 않는 페이지 입니다.');
    history.back();
</script>
<?
    exit;
}
    $oneSection = 10;
    $currentSection = ceil($page / $oneSection); //현재 섹션
    $allSection = ceil($allPage / $oneSection); //전체 섹션의 수
    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지
    if($currentSection == $allSection) {
        $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
    }
    $prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.
    

    if($allSection != 0){
    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) { 
        $paging .= "<a class='icon item'  href='$_SERVER[PHP_SELF]?page=$prevPage$query_string_0$query_string_1'><i class='left chevron icon'></i></a>";
    }
    for($i = $firstPage; $i <= $lastPage; $i++) {
        if($i == $page) {
            $paging .= "<a class='item'>$i</a>";
        } else {
            $paging .= "<a class='item' href='$_SERVER[PHP_SELF]?page=$i$query_string_0$query_string_1'>$i</a>";
        }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) { 
        $paging .= "<a class='icon item' href='$_SERVER[PHP_SELF]?page=$nextPage$query_string_0$query_string_1'><i class='right chevron icon'></i></a>";
    }    
    } else {
        $paging .= "<a class='item disabled'>0</a>";
    }
    /* 페이징 끝 */
    $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문
    $sql = "select * from check_report where $gowork regdate = '$days' order by nid desc $sqlLimit"; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
    $result = $db->query($sql);
?>
            <div class="ui masthead vertical segment">
                <div class="ui container">
                    <div class="introduction">
                        <h1 class="ui header">
                            학생 건강상태 자가진단
                            <div class="sub header">
                                서울천일초등학교 영재교육원에 등교중인 학생들의 일일 건강상태 자가진단 현황입니다.
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="main ui intro container">
                <div class="ui row" style="padding:10px 0px;">
                    <form class="ui form" action="<?=$_SERVER['PHP_SELF'];?>" method="GET">
                        <div class="three fields">
                            <div class="field">
                                <label>등교여부</label>
                                <select class="ui fluid dropdown" name="gowork">
                                    <option value=""<?if($_GET['gowork'] == '') echo " selected";?>>전체</option>
                                    <option value="Y"<?if($_GET['gowork'] == 'Y') echo " selected";?>>등교가능</option>
                                    <option value="N"<?if($_GET['gowork'] == 'N') echo " selected";?>>등교중지</option>
                                </select>
                            </div>
                            <div class="field">
                                <label>조사일자</label>
                                <input type="date" name="days" value="<?if($_GET['days'] == null) echo date('Y-m-d'); else echo $_GET['days'];?>">
                            </div>
                            <div class="field">
                                <label>&nbsp;</label>
                                <button class="ui blue button">검색</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ui row" style="padding:10px 0px">
                    <div class="ui grid">
                        <div class="two column row">
                            <div class="left floated column">
                                <div class="ui row" style="padding:10px 0px;">
                                    전체 <?=$member_count[cnt];?>명 / 정상: <?=$normal;?>명 / 유증상 <?=$confirm;?> 명 / 미참여 <?=$nope;?> 명
                                </div>
                            </div>
                            <div class="right floated column right aligned">
                                <div class="ui basic buttons">
                                    <button class="ui icon button" onclick="window.open('/admin/export.php');">
                                        <i class="download icon"></i>
                                        목록다운로드
                                    </button>
                                    <button class="ui icon button" onclick="window.open('/admin/print.php');">
                                        <i class="print icon"></i>
                                        인쇄
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="ui celled padded table">
                        <thead>
                            <tr class="center aligned">
                                <th rowspan="2">참여여부</th>
                                <th rowspan="2">성명</th>
                                <th rowspan="2">학교명</th>
                                <th colspan="2">발열 및<br>임상증상 여부</th>
                                <th colspan="3">신속항원검사(자가진단) 실시여부</th>
				<th colspan="2">PCR 등 검사 후 결과대기여부</th>
                            </tr>
                            <tr class="center aligned">
                                <th>아니오</th>
                                <th>예</th>
                                <th>검사하지 않음</th>
                                <th>얘</th>
                                <th>아니오</th>
				<th>아니오</th>
				<th>예</th>
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
								$ssn_data = $db->query("SELECT * FROM chk_user WHERE user_ssn = '".$row[user_ssn]."'")->fetch_array();
                            ?>
                            <tr class="center aligned">
                                <td>
                                    <?=$row['user_val']==0?'<a class="ui blue label">정상</a>':'<a class="ui red label">확인필요</a>';?><br>
                                    <?=date('H:i:s', strtotime($row['regdatetime']));?>
                                </td>
                                <td><?=$ssn_data['user_name'];?></td>
                                <td><?=$ssn_data['user_schoolname'];?></td>
                                <td><?=$row['user_q1']==0?'O':'';?></td>
                                <td><?=$row['user_q1']==0?'':'O';?></td>
                                <td><?=$row['user_q2']==-1?'O':'';?></td>
                                <td><?=$row['user_q2']==0?'O':'';?></td>
                                <td><?=$row['user_q2']==1?'O':'';?></td>
				<td><?=$row['user_q3']==0?'O':'';?></td>
                                <td><?=$row['user_q3']==0?'':'O';?></td>
                            </tr>
                            <? }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="11">
                                    <div class="ui right floated pagination menu">
                                        <?php echo $paging ?>
                                        <?php echo $test;?>
                                    </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.footer.php";?>
