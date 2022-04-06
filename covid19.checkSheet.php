<?
include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.header.php";
if($_SESSION['ssn'] == null) @header('location:/');
//$userdata = $db->query("SELECT * FROM chk_user WHERE user_ssn = '")
?>
<form name="chkSheet" onsubmit="return checkForm();" action="/covid19.dataReg.php" method="POST">
<input type="hidden" name="student_name" id="student-name" value="<?=$userdata['user_name'];?>">
<input type="hidden" name="school_code" id="school-code" value="<?=$userdata['user_schoolcode'];?>">
<input type="hidden" name="school_name" id="school-name" value="<?=$userdata['user_schoolname'];?>">
<div class="rows top">
    <span style="display:block;">
        1. 학생 본인이 코로나19가 의심되는 아래의 임상증상<sup>*</sup>이 있나요?<br>
        * (주요임상증상) 발열(37.5℃ 이상), 기침, 호흡곤란, 오한, 근육통, 두통, 인후통, 후각·미각소실<br>
        ※ 단 학교에서 선별진료소 검사결과(음성)을 확인 후 등교를 허용한 경우, 또는 선천성질환·만성질환(천식 등)으로 인한 증상인 경우 '아니오'를 선택하세요.
    </span>
    <div class="clearfix"></div>
    <div class="button-group">
        <input type="radio" name="symptom_test" value="0" id="symptom_no">
        <label class="chkbtn" for="symptom_no">아니오</label>
        <input type="radio" name="symptom_test" value="1" id="symptom_yes">
        <label class="chkbtn" for="symptom_yes">예</label>
    </div>
    <div class="clearfix"></div>
</div>

<div class="rows">
    <span style="display:block;">
        2. 학생 본인은 오늘(어제 저녁 포함) 신속항원검사(자가진단)를 실시했나요?<br>
        ※ 코로나19 완치자의 경우, 확진일로부터 45일간 신속항원검사(자가진단)는 실시하지 않음("검사하지 않음"으로 선택)
    </span>
    <div class="clearfix"></div>
    <div class="button-group">
        <input type="radio" name="diagnosis_test2" value="-1" id="diagnosis_test2_no">
        <label class="chkbtn" for="diagnosis_test2_no">검사하지않음</label>
        <input type="radio" name="diagnosis_test2" value="0" id="diagnosis_test2_yes_1">
	<label class="chkbtn" for="diagnosis_test2_yes_1">음성</label>
	<input type="radio" name="diagnosis_test2" value="1" id="diagnosis_test2_yes_2">
	<label class="chkbtn" for="diagnosis_test2_yes_2">양성</label>
    </div>
    <div class="clearfix"></div>
</div>


<div class="rows">
    <span style="display:block;">
	3. 학생 본인이 PCR등 검사를 받고 그 결과를 기다리고 있나요?<br>
    </span>
    <div class="clearfix"></div>
    <div class="button-group">
        <input type="radio" name="diagnosis_test" value="0" id="diagnosis_test_no">
        <label class="chkbtn" for="diagnosis_test_no">아니오</label>
        <input type="radio" name="diagnosis_test" value="1" id="diagnosis_test_yes">
        <label class="chkbtn" for="diagnosis_test_yes">예</label>
    </div>
    <div class="clearfix"></div>
</div>

<div class="rows footer">
    <span style="display:block;color:red;font-weight:bold;text-align:center">
        [나의 동거인이 확진자인 경우]
    </span>
    <div class="clearfix"></div>
    <span style="display:block;color:red;">
	나의 동거인이 확진되어 재택치료중인 경우 10일간 수동감시 대상이 됩니다.<br>
	* 확진자의 검사일(검체채취일) 기준 3일 내 PCR 검사(지정의료기관에 방문하여 전문가용 신속항원검사 대체 가능) 권고 및 6~7일차 신속항원검사 권고<br>
	* 검사결과 확인시까지 등교 중지(자택 대기) 권고<br>
	(동거인이 PCR 검사 또는 전문가용 신속항원검사를 받고 그 결과를 기다리고 있는 경우를 포함하되, 감염취약시설 종사자로 선제 검사를 실시한 경우는 제외)
    </span>
    <div class="clearfix"></div>
</div>
<div class="rows no-border center">
    <button type="submit" class="btnSubmit">제출</button>
</div>
</form>

<style>
.center{text-align:center;}
.clearfix{clear:both;}
.rows{border-bottom:1px solid #ccc;padding:25px 5px;line-height:150%}
.rows.no-border{border-bottom:none;border-top:none;}
.rows.top{border-top:2px solid rgba(0,0,0,.6);}
.rows.footer{border-bottom:2px solid rgba(0,0,0,.6);}
.button-group{width:100%;height:auto !important;margin:10px 0px;}
.button-group input[type=radio]{display:none;}
.button-group label.chkbtn{display:inline-block;width:calc(100% / 2);float:left;padding:25px;text-align:center;background:#e0e1e2 none;color:rgba(0,0,0,.6);font-weight:700;line-height:1em;font-style:normal;}
.button-group input[type=radio]:checked + label.chkbtn{background:#2185d0;color:#FFF;}
.btnSubmit{width:80%;height:64px;color:#fff;background:#2185d0;border:0;}
</style>

<script>
$(function() {
/*    $('#student-name').val(student_name);
    $('#school-name').val(school_name);
    $('#school-code').val(school_code);
 */})
function checkForm() {
    if($('input:radio[name=symptom_test]').is(':checked') == false)
    {
        alert('본인의 코로나19 의심증상여부를 확인해 주세요.');
        return false;
    }
    if($('input:radio[name=diagnosis_test2]').is(':checked') == false)
    {
        alert('신속항원검사(자가진단)실시여부를 확인해주세요.')
        return false;
    }

    if($('input:radio[name=diagnosis_test]').is(':checked') == false)
    {
        alert('PCR 등 검사 후 결과대기여부를 확인해주세요.')
        return false;
    }
}
</script>
<? include_once $_SERVER["DOCUMENT_ROOT"]."/covid19.footer.php";?>
