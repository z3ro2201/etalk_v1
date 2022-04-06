<?
include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.header.php";
if(!$_SESSION['user_name'] || !$_SESSION['user_schoolcode'] || !$_SESSION['user_schoolname']) @header('Location: /');
?>
                    <div class="userForm">
                        <form class="ui large form" action="/covid19.userLoginProc.php" onsubmit="return chkPassword();" method="POST">
                            <div class="field">
                                <h3 class="ui header center aligned">
                                    <div id="welcome-message"></div>
                                    <input type="hidden" name="student_name" id="student-name" value="<?=$_SESSION['user_name'];?>">
                                    <input type="hidden" name="school_name" id="school-name" value="<?=$_SESSION['user_schoolname'];?>">
                                    <input type="hidden" name="school_code" id="school-code" value="<?=$_SESSION['user_schoolcode'];?>">
                                    <input type="hidden" name="lm" value="insert">
                                </h3>
                                <div class="ui center aligned container">
                                    <div class="field" style="text-align:left">
                                        <label>비밀번호 입력</label>
                                        <input type="number" id="passwd1" name="user_passwd" pattern="[0-9]*" inputmode="numeric" name="user_passwd1" placeholder="비밀번호 입력" maxlength="4">
                                    </div>
                                    <div class="field" style="text-align:left">
                                        <label>비밀번호 확인</label>
                                        <input type="number" id="passwd2" name="user_passwd2" pattern="[0-9]*" inputmode="numeric" name="user_passwd2" placeholder="비밀번호 확인" maxlength="4">
                                    </div>
                                    <div class="field">
                                        <button class="ui teal button" type="submit">비밀번호 등록</button>
                                    </div>
                                    <div class="field">
                                        <button class="ui red button" type="button" onclick="logout()">취소</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <script>
                    $(function() {
						$('#welcome-message').html(`<?=$_SESSION['school_name'];?> <?=$_SESSION['user_name'];?>님의 첫 방문을 환영합니다.<br>사용하실 비밀번호를 입력해주세요.<br><div class="sub header">(암호는 숫자만 입력해주세요.)</div>`);
                    })
                    </script>
                    <script>
                        function chkPassword() {
                            if(document.getElementById('passwd1').value.length < 4) {
                                alert('비밀번호는 4자리 입니다.');
                                document.getElementById('passwd1').focus();
                                return false;
                            }
                            if(document.getElementById('passwd2').value.length < 4) {
                                alert('비밀번호는 4자리 입니다.');
                                document.getElementById('passwd2').focus();
                                return false;
                            }
                            if(document.getElementById('passwd1').value != document.getElementById('passwd2').value) {
                                alert('비밀번호가 서로 다릅니다.');
                                document.getElementById('passwd1').focus();
                                return false;
                            }
                        }
                        function logout() {
                            localStorage.removeItem('autologin');
                            localStorage.removeItem('school-name');
                            localStorage.removeItem('school-code');
                            localStorage.removeItem('student-name');
                            location.reload()
                        }
                    </script>
<? include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.footer.php";?>
