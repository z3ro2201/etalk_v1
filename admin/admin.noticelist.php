<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.header.php";
if($_SESSION['loginUser'] == false) @header('Location: /admin/login.php');
//$member_count = $db->query("SELECT COUNT(*) AS cnt FROM chk_user")->fetch_assoc();
/* 페이징 시작 */
    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;
    
    $sql = "select count(*) as cnt from covid19_notice where (1) order by id desc";
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
    $sql = "select * from covid19_notice where (1) order by id desc $sqlLimit"; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
    $result = $db->query($sql);
?>
            <div class="ui masthead vertical segment">
                <div class="ui container">
                    <div class="introduction">
                        <h1 class="ui header">
                            공지사항
                            <div class="sub header">
							영재교육원 내부 사용자들에게 전달할 공지사항을 작성합니다.
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="main ui intro container">
                <div class="ui row" style="padding:10px 0px">
                    <div class="ui grid">
                        <div class="two column row">
                            <div class="right floated column right aligned">
                                <div class="ui basic buttons">
                                    <a class="ui icon button" href="/admin/admin.noticewrite.php">
                                       글 작성 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="ui celled padded table">
                        <thead>
                            <tr class="center aligned">
                                <th style="width:60px;">&nbsp;</th>
                                <th>제목</th>
                                <th style="width:200px;">작성일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            while($row = $result->fetch_assoc())
                            {
                            ?>
                            <tr class="center aligned">
                                <td><?=$row[id];?></td>
				<td><a href="/admin/admin.noticeview.php?id=<?=$row['id'];?>"><?=$row['b_sbj'];?></a></td>
                                <td><?=$row['b_regdate'];?></td>
                            </tr>
                            <? }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="9">
                                    <div class="ui right floated pagination menu">
										<?php echo $paging ?>
									</div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/admin.footer.php";?>
