<?
@session_start();
?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache"> 
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
        <meta name="description" content="서울천일초등학교 영재교육원 학생 건강상태 자가진단" />
        <!-- google android pwa -->
        <link rel="manifest" href="/manifest.json?refreshed=<?=time();?>">
        <meta name="theme-color" content="#2185d0" />
        <link rel="shortcut icon" href="/icons/favicon.ico">
        <!-- apple webapps -->
        <link rel="apple-touch-icon" href="/icons/maskable_icon_x128.png" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="apple-mobile-web-app-title" content="천일초 건강상태 자가진단" />
		<title>서울천일초등학교 영재교육원 학생 건강상태 자가진단</title>
        <link rel="stylesheet" href="/assets/semantic/semantic.min.css">
        <script src="/assets/jquery/jquery-3.6.0.min.js"></script>
        <script src="/assets/jquery-cookie/jquery.cookie.js"></script>
        <script src="/assets/semantic/semantic.min.js"></script>
        <link rel="stylesheet" href="/assets/css/gifted.css?refreshed=<?=time();?>">
        <script>
            var last = "1.0.3";
            var choice_school = 0;
            var autologin = localStorage.getItem('autologin');
            var ssn = localStorage.getItem('user_ssn');
            var school_name = localStorage.getItem('school-name');
            var school_code = localStorage.getItem('school-code');
            var student_name = localStorage.getItem('student-name');
            var softver = localStorage.getItem('softver');

            function storageClear() {
                alert('clear');
                localStorage.clear();
                sessionStorage.clear();
                location.reload();
            }

            function logout() {
                localStorage.removeItem('autologin');
                localStorage.removeItem('school-name');
                localStorage.removeItem('school-code');
                localStorage.removeItem('student-name');
                location.reload()
            }
        </script>
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js')
                .then((reg) => {
                    return 0;
                });
            }
	</script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-B921Y92GLP"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-B921Y92GLP');
	</script>
        <script>
            $(function() {

                history.pushState(null, null, location.href);
                $(window).bind("pageshow", function(event) {
                    if (event.originalEvent.persisted) {
                        document.location.reload();
                    }
                });


				//                if((autologin != undefined) && (school_name != undefined) && (student_name != undefined)) {
				if((autologin != undefined) && (ssn != undefined)) {
                    if(!softver) softver = "1.0.0";
                    $('div#cookie').remove();
                    $('#autologin').addClass('checked');
                    $('#autologin > input:checkbox').attr('checked', "");

                    $('#contentBody').load('/covid19.userPassword.php');
                    $('#school-name').addClass('ui disabled input');
                    $('#stu-name').addClass('ui disabled input');
                } else {
                    if(!softver) softver = "1.0.2";
                    $('#contentBody').load('/loginForm.html')
                }

                if(softver != last) softver = "최신버전으로 업데이트가 필요합니다. <a class='ui button red' onclick='storageClear();'>업데이트</a>";
                else $('.softver').html(softver);

                $('#school-name').click(function() {
                    choice_school = 0;
                    $(this).val("");
                    $(this).focus();
                })				
            })
        </script>
    </head>

    <body>
        <div id="container">
            <div style="width:100%;height:100%;padding:10px;">
                <span style="display:inline-block;float:right;font-weight:bold;color:rgba(0,0,0,.6);font-size:12pt;">ver <span class="softver"></span></span>
                <div style="clear:both"></div>
                <div style="width:100%;height:calc(100% - 20px);padding:20px;">
                    <h2 class="ui header">
                        <img src="/assets/images/logo.png" style="width:40px;height:auto;margin-bottom:20px;margin-left:-10px" alt="서울천일초등학교 로고">
                        <div style="clear:both"></div>
                        건강상태 자가진단
                        <div class="sub header">Health condition self-check</div>
                    </h2>
                    <div id="contentBody">
		    </div>
			<div style="width:100%;height:auto;overflow:hidden;text-align:center;margin:15px 0px;padding-top:10px;border-top:1px dotted #ccc">Copyright © 2022 <a href="//2ero.dev" target="_blank">2ero.dev</a>. All Rights Reserved.</div>
		</div>
            </div>
            <div id="apple-webapps-install">
                <div style="margin:0 auto;">
                    <div id="apple-message-box">
                        <h1 style="margin:0;padding:5px 0px;font-size:12pt;width:100%;display:block;text-align:center;"><i class="info circle icon"></i>애플사의 기기시네요!</h1>
                        좀 더 편안하게 접근해보세요!<br>
                        하단에 있는 더 보기 메뉴 ( 
                        <svg width="17px" viewBox="0 0 17 22" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="inline-block align-top" style="margin-right: 2px; margin-top: -4px;">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-101.000000, -570.000000)" fill="#4478BF" stroke="#4478BF" stroke-width="0.3">
                                    <g transform="translate(102.000000, 571.000000)">
                                        <polygon points="7.0968 12.536475 7.8468 12.536475 7.8468 0.537225 7.0968 0.537225"></polygon>
                                        <polygon points="7.4712 -8.2600593e-14 3.97845 3.4935 4.50945 4.02375 8.00145 0.53025"></polygon>
                                        <polygon points="7.4712 -8.2600593e-14 6.9417 0.53025 10.4337 4.02375 10.9647 3.4935"></polygon>
                                        <path d="M12,5.47065 L10.0965,5.47065 L10.0965,6.3699 L12,6.3699 C13.15875,6.3699 14.1015,7.31265 14.1015,8.47065 L14.1015,17.47065 C14.1015,18.6294 13.15875,19.5714 12,19.5714 L3,19.5714 C1.842,19.5714 0.89925,18.6294 0.89925,17.47065 L0.89925,8.47065 C0.89925,7.31265 1.842,6.3699 3,6.3699 L4.8465,6.3699 L4.8465,5.47065 L3,5.47065 C1.34325,5.47065 0,6.8139 0,8.47065 L0,17.47065 C0,19.1274 1.34325,20.47065 3,20.47065 L12,20.47065 C13.6575,20.47065 15,19.1274 15,17.47065 L15,8.47065 C15,6.8139 13.6575,5.47065 12,5.47065"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>)를 터치 하신 후<br>홈 화면에 추가( <i class="plus square outline icon"></i>) 를 누르시면 더 쉽게 접속하세요!
                    </div>
                    <div class="apple-home-touch">
                        <i class="angle down icon" style=""></i>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(function() {
            $(document).ready(function() {
                var browserUA = navigator.userAgent.toLowerCase();
                if(browserUA.indexOf('android') > -1) {
                    return 'android';
                } else if ((browserUA.indexOf('iphone') > -1 || browserUA.indexOf('ipad') > -1 || browserUA.indexOf('ipod') > -1) && (window.navigator.standalone == false)) {
                    $('#apple-webapps-install').fadeIn(2000)
                } else {
                    return 'other';
                }
            })
        })
        </script>
    </body>
</html>
