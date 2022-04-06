<?
session_start();
if($_SESSION['loginUser'] == true) @header('Location: /admin/index.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>서울천일초등학교 영재교육원 학생 건강상태 자가진단</title>
  <link rel="stylesheet" href="/assets/semantic/semantic.min.css">
  <script src="/assets/jquery/jquery-3.6.0.min.js"></script>
  <script src="/assets/semantic/semantic.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-B921Y92GLP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-B921Y92GLP');
</script>
  <style type="text/css">
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
  <script>
  $(document)
    .ready(function() {
      $('.ui.form')
        .form({
          fields: {
            text: {
              identifier  : 'id',
              rules: [
                {
                  type   : 'empty',
                  prompt : '관리자 ID를 입력해주세요.'
                }
              ]
            },
            password: {
              identifier  : 'password',
              rules: [
                {
                  type   : 'empty',
                  prompt : '비밀번호를 입력해주세요.'
                }
              ]
            }
          }
        })
      ;
    })
  ;
  </script>
</head>
<body>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="/assets/images/logo.png" class="image">
      <div class="content">
        학생 건강상태 자가진단
      </div>
    </h2>
    <form class="ui large form" action="/admin/loginProc.php" method="POST">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="id" placeholder="사용자 ID">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="비밀번호">
          </div>
        </div>
        <div class="ui fluid large teal submit button">로그인</div>
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      시스템 사용권한은 별도로 문의주세요.
    </div>
<div style="width:100%;height:auto;overflow:hidden;text-align:center;padding-top:10px;margin:15px 0px;border-top:1px dotted #ccc">Copyright © 2022 <a href="//2ero.dev" target="_blank">2ero.dev</a>. All Rights Reserved.</div>
  </div>
</div>

</body>

</html>
