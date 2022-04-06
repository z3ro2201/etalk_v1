<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.header.php";
$member_count = $db->query("SELECT COUNT(*) AS cnt FROM chk_user")->fetch_assoc();
/* 페이징 시작 */
    $today = date('Y-m-d');
    if($_GET['fields']) $fields=$_GET['fields'];
    
    // 검색기능
    if($_GET['q'] == 'name') $q = "user_name = '$fields'";
    else if($_GET['q'] == 'school') $q = "user_school = '$fields'";
    else $q = "(1)";

    $sql = "select * from check_report where $q order by nid desc"; 
    $result = $db->query($sql);

    //echo $sql;


    //페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.

    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;
    
    $sql = "select count(*) as cnt from chk_user where $q order by nid desc";
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
    
    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) { 
        $paging .= "<a class='icon item'  href='$_SERVER[PHP_SELF]?page=$prevPage'><i class='left chevron icon'></i></a>";
    }    
    for($i = $firstPage; $i <= $lastPage; $i++) {
        if($i == $page) {
            $paging .= "<a class='item'>$i</a>";
        } else {
            $paging .= "<a class='item' href='$_SERVER[PHP_SELF]?page=$i'>$i</a>";
        }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) { 
        $paging .= "<a class='icon item' href='$_SERVER[PHP_SELF]?page=$nextPage'><i class='right chevron icon'></i></a>";
    }    

    /* 페이징 끝 */
    $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문
    $sql = "select * from chk_user where $q order by nid desc $sqlLimit"; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
    $result = $db->query($sql);
?>
            <div class="ui masthead vertical segment">
                <div class="ui container">
                    <div class="introduction">
                        <h1 class="ui header">
                            사용자 현황
                            <div class="sub header">
                                서울천일초등학교 영재교육원 건강상태 자가진단에 등록된 사용자 목록입니다.
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="main ui intro container">
                <div class="ui row" style="padding:10px 0px;">
                    <form class="ui form" action="/admin/userlist.php" method="GET">
                        <div class="three fields">
                            <div class="field">
                                <label>검색방식</label>
                                <select class="ui fluid dropdown" name="q">
                                    <option value=""<?if($_GET['q'] == '') echo " selected";?>></option>
                                    <option value="name"<?if($_GET['q'] == 'name') echo " selected";?>>성명</option>
                                    <option value="school"<?if($_GET['q'] == 'school') echo " selected";?>>학교명</option>
                                </select>
                            </div>
                            <div class="field">
                                <label>검색어</label>
                                <input type="text" name="fields" value="<?if($_GET['fields']) echo $_GET['fields'];?>">
                            </div>
                            <div class="field">
                                <label>&nbsp;</label>
                                <button class="ui blue button">검색</button>
                                <button type="button" class="ui black button" onclick="location.href='/admin/userlist.php';">전체목록</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ui row" style="padding:10px 0px">
                    <table class="ui celled padded table">
                        <thead>
							<tr class="center aligned">
<!--								<th>접근허가<br>여부</th>-->
                                <th>성명</th>
                                <th>학교명</th>
								<th>기능</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            while($row = $result->fetch_assoc())
                            {
                            ?>
							<tr class="center aligned">
<!--				<td><?if($row['user_trustd'] == 0) echo "거부"; else echo "허가";?></td>-->
                                <td><?=$row['user_name'];?></td>
                                <td><?=$row['user_schoolname'];?></td>
                                <td>
                                    <a href="/admin/admin.useroption.php?option=reset&userid=<?=$row[user_ssn];?>" class="ui inverted blue button">비밀번호 초기화</a>
									<a href="/admin/admin.useroption.php?option=delete&userid=<?=$row[user_ssn];?>" class="ui inverted red button">삭제</a>
					<?if($row['user_trustd'] == 0) { ?><a href="/admin/admin.useroption.php?option=trustd&userid=<?=$row[user_ssn];?>" class="ui inverted green button">접근허가</a>
									<?}else{?><a href="/admin/admin.useroption.php?option=trustd&userid=<?=$row[user_ssn];?>" class="ui inverted orange button">접근거부</a><?}?>
                                </td>
                            </tr>
                            <? }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">
                                    <div class="ui right floated pagination menu">
                                        <?php echo $paging ?>
                                    </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <? echo $_PHPSELF;?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.footer.php";?>
