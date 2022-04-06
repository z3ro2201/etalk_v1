<?
include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.header.php";
if($_SESSION['ssn'] == null) @header('location:/');
//$userdata = $db->query("SELECT * FROM chk_user WHERE user_ssn = '$_SESSION[ssn]'")->fetch_assoc();
//var_dump($userdata);
?>
                    <div class="userForm">
                        <form class="ui large form">
                            <div class="field" id="logonImage">
                                <img src="/assets/images/walking_mask_boy.png" alt="mask title image">
                                <img src="/assets/images/walking_mask_girl.png" alt="mask title image">
                            </div>
                            <div class="field">
                                <h3 class="ui header center aligned">
                                    <div id="student-name"></div>
                                    <div class="sub header" id="school-name"></div>
                                    <input type="hidden" id="school-code">
                                </h3>
                                <div class="ui center aligned container">
                                    안녕하세요.<br>
                                    <span class="check-date"></span> <span class="check-message">오늘의 자가진단을 시작해주세요.</span><br>
                                    (검사진행이 정상적으로 진행되지 않는 경우 아래 로그아웃 버튼을 누르고 인증 후 검사를 다시 진행해주세요.)
                                    <div style="margin:10px">
                                        <button class="ui button" type="button" onclick="logout()" id="btnLogout">로그아웃</button> 
										<button class="ui blue button" type="button" id="self-check" onclick="location.href='/covid19.checkSheet.php';">자가진단 시작하기</button>
									
                                        <div class="check-val"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                  <script>
                        function logout() {
                            localStorage.removeItem('autologin');
//                            localStorage.removeItem('school-name');
//                            localStorage.removeItem('school-code');
//                            localStorage.removeItem('student-name');
							localStorage.removeItem('user_ssn');                            
                            location.href="/";
                        }
                  </script>
                    <script>
                    $(function() {
                        var now = new Date();
                        var month = now.getMonth() + 1;
						$('#student-name').html("<?=$userdata['user_name'];?>");
						$('#school-name').html("(<?=$userdata['user_schoolname'];?>)");
                        $('#school-code').val(school_code);
                        $('.check-date').html(now.getFullYear() + "." +  month + "." + now.getDate() + ".");
                        $(document).ready(function() {
                            if(choice_school == 0) {
                                $.ajax({
                                    type: 'GET',
                                    url: '/covid19.dataCheck.php',
                                    data: { ssn: ssn, schoolcode: school_code, username: student_name },
                                    dataType: "json"
                                }).done(function(json) {
                                    $.each(json.covid19, function(index, item) {
                                        if((item['count'] != 0) && (item.code != undefined))
                                        {
                                            $('.check-message').html("오늘의 자가진단이 종료되었습니다.");
                                            if(item['code'] == 0)$('.check-val').html('<a class="ui blue label">등교가능</a>');
                                            else $('.check-val').html('<a class="ui orange label">등교중지</a>');
                                        }
                                    });
                                    console.log(json);
                                });
                            }
                        })
                    })
                    </script>
<? include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.footer.php";?>
