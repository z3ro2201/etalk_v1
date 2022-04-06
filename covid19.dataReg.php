<?
include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.header.php";
(string)$name = $userdata['user_name'];
(string)$schoolname = $userdata['user_schoolname'];
(string)$schoolcode = $userdata['user_schoolcode'];
(int)$q1 = $_POST['symptom_test'];
(int)$q2 = $_POST['diagnosis_test2'];
if($q2 == -1) (int)$q2_tot = 0;
else (int)$q2_tot = $q2;
(int)$q3 = $_POST['diagnosis_test'];
//(int)$q4 = $_POST['self_quarantine'];
(int)$total = $q1 + $q2_tot + $q3;
//if($total == -1) $total = 0;
(string)$date = date('Y-m-d');
(string)$datetime = date('Y-m-d H:i:s');
$sql = "SELECT COUNT(*) AS cnt FROM check_report WHERE user_ssn = '".$_SESSION['ssn']."' AND regdate = '$date'";
$result = $db->query($sql)->fetch_assoc();
if(!$result['cnt']) $sql = "INSERT INTO check_report (user_ssn,user_name,user_schoolcode,user_schoolname,user_q1,user_q2,user_q3,user_q4,user_val,regdate,regdatetime) VALUES ('".$_SESSION['ssn']."','$name', '$schoolcode', '$schoolname', '$q1', '$q2', '$q3', '0', '$total', '$date', '$datetime')";
//if(!$result['cnt']) $sql = "INSERT INTO check_report (user_ssn,user_q1,user_q2,user_q3,user_q4,user_val,regdate,regdatetime) VALUES ('".$_SESSION['ssn']."', '$q1', '$q2', '$q3', '$q4', '$total', '$date', '$datetime')";
else $sql = "UPDATE check_report SET user_q1 = '$q1', user_q2 = '$q2', user_q3 = '$q3', user_val = '$total', regdatetime = '$datetime' WHERE user_ssn = '".$_SESSION['ssn']."' AND regdate = '$date'";
$db->query($sql);
?>
                        <div class="userForm">
                            <form class="ui large form">
                                <div class="field" id="logonImage">
                                    <div id="messageImage"></div>
                                </div>
                                <div class="field">
                                    <h3 class="ui header center aligned">
                                        <div id="student-name"></div>
                                        <div class="sub header" id="school-name"></div>
                                        <input type="hidden" id="school-code">
                                    </h3>
                                    <div class="ui center aligned container">
                                        오늘의 (<span class="check-date"></span>) 자가진단참여를 완료하였습니다.<br>
                                        <div style="margin:10px">
                                            <button class="ui blue button" type="button" onclick="location.href='/covid19.userLogon.php'">확인</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="messagebox">
                                <?
                                    if($total == 0 || $total == -1) echo "코로나19 예방을 위한 자가진단 설문결과 의심 증상에 해당되는 항목이 없어 출근이 가능함을 안내드립니다.";
                                    else echo"<a class=\"ui orange label\">유증상</a>\n<span style=\"margin:10px;display:block;color:#f2711c;\">현재 귀하의 건강상태는 가정내에서 관리가 필요한 상황이므로 주변분들의 건강한 학교생활을 위해 잠시 등교하지 않도록 협조하여 주시기 바랍니다.<br>\n발열, 호흡기 증상 등 코로나19가 의심되는 증상이 있는 경우 콜센터(1339, 지역번호+120) 또는 관할보건소에 문의하고 선별진료소 방문 후 진료·검사받기 등 안내에 따라주시기 바랍니다.</span>";
                                ?>
                            </div>
                        </div>
                        <script>
                        $(function() {
                            var now = new Date();
                            var month = now.getMonth() + 1
								$('#student-name').html("<?=$userdata[user_name];?>");
							$('#school-name').html("(<?=$userdata[user_schoolname];?>)");
                            $('#school-code').val(school_code);
                            $('.check-date').html(now.getFullYear() + "." + month + "." + now.getDate() + ".");
                        })
                        </script>
                        <style>
                            .messagebox{margin:30px 0px;width:100%;height:auto !important;background:rgba(0,0,0,.05);padding:15px;font-weight:bold;color:rgba(0,0,0,.6);}
                        </style>
<? include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.footer.php";?>
