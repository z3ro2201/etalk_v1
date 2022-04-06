<?
@session_start();
include_once("../dbconn.php");
if($_SESSION['loginUser'] == false) @header('Location: /admin/login.php');
// 회원정보 조회
$sql = "SELECT * FROM test_admin WHERE adm_id = '".$_SESSION['loginUser']."'";
$result = $db->query($sql);
if(!$result) @header('Location: /admin/login.php');
?>
<!doctype html>
<html lang="ko">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="Pragma" content="no-cache"> 
      <meta http-equiv="Cache-Control" content="no-cache">
      <meta http-equiv="Expires" content="-1">
      <meta name="robots" content="nolist">
      <meta name="googlebot" content="nolist">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
      <meta name="description" content="서울천일초등학교 영재교육원 학생 건강상태 자가진단" />
      <!-- google android pwa -->
      <title>서울천일초등학교 영재교육원 학생 건강상태 자가진단 관리자페이지</title>
      <link rel="stylesheet" href="/assets/semantic/semantic.min.css?refreshed=<?=time();?>">
      <script src="/assets/jquery/jquery-3.6.0.min.js"></script>
      <script src="/assets/semantic/semantic.min.js?refreshed=<?=time();?>"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>
      <style>
        html,body{width:100%;height:100%;overflow:hidden;}
        #container{width:100%;height:100%;overflow:auto;}
        .clearfix{clear:both;}
        .admin{height:--webkit-calc(100% - 52px);height:-moz-calc(100% - 52px);height:calc(100% - 52px);margin-top:54px;}
      </style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-B921Y92GLP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-B921Y92GLP');
</script>
  </head>

  <body>
    <div id="container">
      <div class="ui top fixed menu">
        <div class="item">
          <img src="/assets/images/logo.png">
		</div>
        <a class="item" href="/admin/admin.dashboard.php">코로나 현황판</a>
        <a class="item" href="/admin/admin.userlist.php">사용자현황</a>
        <a class="item" href="/admin/admin.checklist.php">자가검진참여자현항</a>
		<a class="item" href="/admin/admin.nopelist.php">자가검진미참여자현항</a>
        <a class="item" href="/admin/logout.php">로그아웃</a>
      </div>
      <div class="admin">
