<?
@session_start();
include_once $_SERVER["DOCUMENT_ROOT"]."/dbconn.php";
$userdata = $db->query("SELECT * FROM chk_user WHERE user_ssn = '$_SESSION[ssn]'")->fetch_assoc();

?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache"> 
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
        <meta name="description" content="서울천일초등학교 영재교육원" />
        <!-- google android pwa -->
        <link rel="manifest" href="/manifest.json?refreshed=<?=time();?>">
        <meta name="theme-color" content="#2185d0" />
        <link rel="shortcut icon" href="/icons/favicon.ico">
        <!-- apple webapps -->
        <link rel="apple-touch-icon" href="/icons/maskable_icon_x128.png" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="apple-mobile-web-app-title" content="천일초 건강상태 자가진단" />
        <title>서울천일초등학교 영재교육원 학생 알리미</title>
        <link rel="stylesheet" href="/assets/semantic/semantic.min.css?refreshed=<?=time();?>">
        <script src="/assets/jquery/jquery-3.6.0.min.js"></script>
        <script src="/assets/jquery-cookie/jquery.cookie.js"></script>
        <script src="/assets/semantic/semantic.min.js?refreshed=<?=time();?>"></script>
	<link rel="stylesheet" href="/assets/css/gifted.css?refreshed=<?=time();?>">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-B921Y92GLP"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-B921Y92GLP');
	</script>
        <script>
            var last = "1.0.2";
            var choice_school = 0;
            var autologin = localStorage.getItem('autologin');
            var ssn = localStorage.getItem('user_ssn');
            var school_name = localStorage.getItem('school-name');
            var school_code = localStorage.getItem('school-code');
            var student_name = localStorage.getItem('student-name');
            var softver = localStorage.getItem('softver');
        </script>
        <script>
            $(function() {
                history.pushState(null, null, location.href);
                $(window).bind("pageshow", function(event) {
                    if (event.originalEvent.persisted) {
                        document.location.reload();
                    }
                });
                
                if(softver != last) softver = "최신버전으로 업데이트가 필요합니다. <a class='ui button red' onclick='storageClear();'>업데이트</a>";
                else $('.softver').html(softver);

            })
	</script>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCvHM40GI7gQm-DfvVA3jGJQhe9-x7fXTc",
    authDomain: "etalk-1ba3a.firebaseapp.com",
    projectId: "etalk-1ba3a",
    storageBucket: "etalk-1ba3a.appspot.com",
    messagingSenderId: "132659207809",
    appId: "1:132659207809:web:944690946c9f1b20faf780",
    measurementId: "G-GMNS4LHH4E"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>
<script src="/assets/firebase/sw.js"></script>
<script src="/assets/firebase/messaging_get_token.js"></script>
<script src="/assets/firebase/messaging_recive_message.js"></script>
<script src="/assets/firebase/messaging_on_background_message.js"></script>
<script>
$(document).ready( function () {
  if ('serviceWorker' in navigator && 'PushManager' in window )
  {
    // Register serviceWorker
    navigator.serviceWorker.register('/sw.js').then(function(swReg) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', swReg.scope);
      // Add Button Listener
      $("#button").on("updateBtn", function (e, isSub) {
        if (Notification.permission === 'denied')
          return $(this).html("Denied");
        if( isSub )
          $(this).attr("data-next-action","unsub").html("unsubscribe!");
        else
          $(this).attr("data-next-action","sub").html("subscribe!");
        $(this).removeAttr("disabled");
      }).on("click", function (e) {
        //Disabled Button until user response..
        $(this).attr("disabled", true);
        if( $(this).attr("data-next-action") == "sub" )
        { // Subscribing...
          swReg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: convertedVPkey
          })
          .then(function(subscription) {
             $.ajax({
                method : 'POST',
                url : '/push-send',
                dataType : 'json',
                data : {
                  subscription: JSON.stringify(subscription),
                  data: JSON.stringify({
                    title : 'TITLE',
                    body : 'Push send test..',
                    params : {
                      url : '/'
                    }
                  })
              }
            }).done( function (res){
              console.log(res);
              $("#button").trigger("updateBtn",[true]);
            }).fail( function (err) {
              console.log(err);
            });
          })
          .catch(function(err) {
            console.log('Failed to subscribe the user: ', err);
            $("#button").trigger("updateBtn",[false]);
          });
        }
        else
        { // Unsubscribing..
          swReg.pushManager.getSubscription().then(function(subscription) {
            if (subscription)
              return subscription.unsubscribe();
          })
          .catch(function(error) {
            console.log('Error unsubscribing', error);
            $("#button").trigger("updateBtn",[true]);
          })
          .then(function() {
            console.log('User is unsubscribed.');
            $("#button").trigger("updateBtn",[false]);
          });
        }
      });
      // Check Subscribe > and Update Button
      swReg.pushManager.getSubscription().then( function(subscription) {
        isSubscribed = !(subscription === null);
        //Update Button
        $("#button").trigger("updateBtn", [isSubscribed]);
        if (isSubscribed)
          console.log('User is subscribed.');
        else
          console.log('User is NOT subscribed.');
      });
    }).catch(function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  }
});
</script>
    </head>

    <body>
        <div id="container">
            <div style="width:100%;height:100%;padding:10px;">
                <span style="position:absolute;right:10px;font-weight:bold;color:rgba(0,0,0,.6);font-size:12pt;"><a class="ui blue button" href="/covid19.checkSheet.php">자가진단</a><a class="ui blue button" href="/covid19.userLogon.php">처음화면</a></span>
                <div style="clear:both"></div>
                <div style="width:100%;height:calc(100% - 20px);padding:20px;">
                    <h2 class="ui header">
                        <img src="/assets/images/logo.png" style="width:40px;height:auto;margin-bottom:20px;margin-left:-10px" alt="서울천일초등학교 로고">
                        <div style="clear:both"></div>
			<?if($_GET['test'] == null) {?>건강상태 자가진단<?} else {?>영재교육원 GETS<?}?>
			<div class="sub header"><?if($_GET['test'] == null) {?>Health condition self-check<? } else {?>Gifted Education Talking System<?}?></div>
                    </h2>
                    <div id="contentBody" class="center">
