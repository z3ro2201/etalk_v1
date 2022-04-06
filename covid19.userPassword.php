                    <div class="userForm">
                        <form class="ui large form" action="/covid19.userLoginProc.php" method="POST" onsubmit="return chkField();">
                            <div class="field">
                                <h3 class="ui header center aligned">
                                    <div id="welcome-message"></div>
                                    <input type="hidden" name="user_name" id="student-name">
                                    <input type="hidden" name="school_code" id="school-code">
                                    <input type="hidden" name="school_name" id="school-name">
                                </h3>
                                <div class="ui center aligned container">
                                    <div class="field">
                                        <div class="ui action input">
                                            <input type="hidden" name="lm" value="wakeOn">
                                            <input type="hidden" name="user_ssn" id="user-ssn">
                                            <input type="number" pattern="[0-9]*" id="user_passwd" name="user_passwd" placeholder="비밀번호 입력">
                                            <button class="ui teal right labeled icon button">
                                                <i class="arrow right link icon"></i>
                                                로그인
                                            </button>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <button class="ui teal button" type="button" onclick="logout()">다른계정 로그인</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <script>
                    $(function() {
                        $('#user-ssn').val(localStorage.getItem('user_ssn'));
                        $('#school-name').val(school_name);
                        $('#school-code').val(school_code);
                        $('#student-name').val(student_name);
                        $('#welcome-message').html('비밀번호를 입력하세요.<br><div class="sub header">(분실하신 경우 담당선생님께 문의하세요.)</div>');
                    })
                    </script>
                    <script>
                        function chkField() {
                            if(document.getElementById('user_passwd').value.length < 4) {
                                alert('비밀번호를 입력해주세요.');
                                document.getElementById('user_passwd').focus();
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
