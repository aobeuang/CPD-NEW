<?php 
function trimleft($text, $char)
{
	$text = ltrim($text, '0');
	if (strpos($text, '.')===0)
	{
		$text = "0".$text;
	}
	return $text;
}
?>

<link type="text/css" rel="stylesheet" href="/assets/default/vendors/datetime/jquery.datetimepicker.css" />
<script src="/assets/default/vendors/datetime/jquery.datetimepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<?php $this->load->helper('form');

$text_color_theme = '#428bca';

$mode = '';
if(isset($_GET['mode'])){
	if($_GET['mode']=="view"){
		$mode = "view";
	}
}




$plan_name = array();
$plan_code = array();
$i = 0;
$plan_name[$i] = "ข้าวหอมมะลิ";   $plan_code[$i] = "1"; $i++;
$plan_name[$i] = "ข้าวเหนียว";   $plan_code[$i] = "2"; $i++;
$plan_name[$i] = "ข้าวจ้าว";   $plan_code[$i] = "3"; $i++;
$plan_name[$i] = "มันสำปะหลัง";   $plan_code[$i] = "4"; $i++;
$plan_name[$i] = "ปาล์มน้ำมัน";   $plan_code[$i] = "5"; $i++;
$plan_name[$i] = "ยางพารา";   $plan_code[$i] = "6"; $i++;
$plan_name[$i] = "ลำไย";   $plan_code[$i] = "7"; $i++;
$plan_name[$i] = "ทุเรียน";   $plan_code[$i] = "8"; $i++;
$plan_name[$i] = "มังคุด";   $plan_code[$i] = "9"; $i++;
$plan_name[$i] = "สับปะรด";   $plan_code[$i] = "10"; $i++;
$plan_name[$i] = "ถั่วเหลือง";   $plan_code[$i] = "11"; $i++;
$plan_name[$i] = "ข้าวโพดเลี้ยงสัตว์";   $plan_code[$i] = "12"; $i++;
$plan_name[$i] = "อ้อย";   $plan_code[$i] = "13"; $i++;



$ani_name = array(); $ani_code = array();
$i = 0;
$ani_name[$i] = "ผึ้งเลี้ยง";  $ani_code[$i] = "11"; $i++;
$ani_name[$i] = "กระบือ";  $ani_code[$i] = "21"; $i++;
$ani_name[$i] = "สุกร";  $ani_code[$i] = "22"; $i++;
$ani_name[$i] = "ไก่";  $ani_code[$i] = "12"; $i++;
$ani_name[$i] = "เป็ด";  $ani_code[$i] = "13"; $i++;
$ani_name[$i] = "โคนม";  $ani_code[$i] = "23"; $i++;
$ani_name[$i] = "โคเนื้อ";  $ani_code[$i] = "24"; $i++;
$ani_name[$i] = "แพะเนื้อ";  $ani_code[$i] = "25"; $i++;
$ani_name[$i] = "แพะนม";  $ani_code[$i] = "26"; $i++;
$ani_name[$i] = "กวาง";  $ani_code[$i] = "27"; $i++;

$ani_name[$i] = "สัตว์บกอื่น ๆ";  $ani_code[$i] = "28"; $i++;

//$ani_name[$i] = "ผักทุกชนิด";  $ani_code[$i] = "26"; $i++;

//$ani_name[$i] = "พืชอื่น ๆ";  $ani_code[$i] = "99"; $i++;
$ani_name2 = array(); $ani_code2 = array();
$i = 0;
$ani_name2[$i] = "กุ้ง";  $ani_code2[$i] = "01"; $i++;
$ani_name2[$i] = "ปลา";  $ani_code2[$i] = "02"; $i++;
$ani_name2[$i] = "หอย";  $ani_code2[$i] = "03"; $i++;
$ani_name2[$i] = "สัตว์น้ำอื่น ๆ";  $ani_code2[$i] = "04"; $i++;

?>

<style type="text/css">
@import
	url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700);

p.narrow {
	width: 60%;
	margin: 10px auto;
}

.liner {
	height: 2px;
	background: #ddd;
	position: absolute;
	width: 80%;
	margin: 0 auto;
	left: 0;
	right: 0;
	top: 50%;
	z-index: 1;
}

.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus
	{
	color: #555555;
	cursor: default;
	/* background-color: #ffffff; */
	border: 0;
	border-bottom-color: transparent;
}

span.round-tabs {
	width: 70px;
	height: 70px;
	line-height: 70px;
	display: inline-block;
	border-radius: 100px;
	background: white;
	z-index: 2;
	position: absolute;
	left: 0;
	text-align: center;
	font-size: 25px;
}

span.round-tabs.one {
	color: rgb(34, 194, 34);
	border: 2px solid rgb(34, 194, 34);
}

li.active span.round-tabs.one {
	background: #fff !important;
	border: 2px solid #ddd;
	color: rgb(34, 194, 34);
}

span.round-tabs.two {
	color: #febe29;
	border: 2px solid #febe29;
}

li.active span.round-tabs.two {
	background: #fff !important;
	border: 2px solid #ddd;
	color: #febe29;
}

span.round-tabs.three {
	color: #3e5e9a;
	border: 2px solid #3e5e9a;
}

li.active span.round-tabs.three {
	background: #fff !important;
	border: 2px solid #ddd;
	color: #3e5e9a;
}

span.round-tabs.four {
	color: #f1685e;
	border: 2px solid #f1685e;
}

li.active span.round-tabs.four {
	background: #fff !important;
	border: 2px solid #ddd;
	color: #f1685e;
}

span.round-tabs.five {
	color: #999;
	border: 2px solid #999;
}

li.active span.round-tabs.five {
	background: #fff !important;
	border: 2px solid #ddd;
	color: #999;
}

.nav-tabs>li.active>a span.round-tabs {
	background: #fafafa;
}

.nav-tabs>li {
	width: 20%;
}
/*li.active:before {
content: " ";
position: absolute;
left: 45%;
opacity:0;
margin: 0 auto;
bottom: -2px;
border: 10px solid transparent;
border-bottom-color: #fff;
z-index: 1;
transition:0.2s ease-in-out;
}*/
.nav-tabs>li:after {
	content: " ";
	position: absolute;
	left: 45%;
	opacity: 0;
	margin: 0 auto;
	bottom: 0px;
	border: 5px solid transparent;
	border-bottom-color: #ddd;
	transition: 0.1s ease-in-out;
}

.nav-tabs>li.active:after {
	content: " ";
	position: absolute;
	left: 45%;
	opacity: 1;
	margin: 0 auto;
	bottom: 0px;
	border: 10px solid transparent;
	border-bottom-color: #ddd;
}

.nav-tabs>li a {
	width: 70px;
	height: 70px;
	margin: 20px auto;
	border-radius: 100%;
	padding: 0;
}

.nav-tabs>li a:hover {
	background: transparent;
}

.tab-content {
	
}

.tab-content .head {
	font-family: 'Roboto Condensed', sans-serif;
	font-size: 25px;
	text-transform: uppercase;
	padding-bottom: 10px;
}

.btn-outline-rounded {
	padding: 10px 40px;
	margin: 20px 0;
	border: 2px solid transparent;
	border-radius: 25px;
}

.btn.green {
	background-color: #5cb85c;
	/*border: 2px solid #5cb85c;*/
	color: #ffffff;
}

@media ( max-width : 585px) {
	.board {
		width: 90%;
		height: auto !important;
	}
	span.round-tabs {
		font-size: 16px;
		width: 50px;
		height: 50px;
		line-height: 50px;
	}
	.tab-content .head {
		font-size: 20px;
	}
	.nav-tabs>li a {
		width: 50px;
		height: 50px;
		line-height: 50px;
	}
	.nav-tabs>li.active:after {
		content: " ";
		position: absolute;
		left: 35%;
	}
	.btn-outline-rounded {
		padding: 12px 20px;
	}
}

select.form-control.input-sm {
	background: #00a1ff !important;
	border: 0px !important;
	border-radius: 0px !important;
	color: #FFF !important;
	font-weight: 500 !important;
	font-size: 13px !important;
	font-family: 'Roboto', sans-serif;
	-webkit-box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
	-moz-box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
	box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
}

.pagination>li>a, .pagination>li>span {
	background: #00a1ff !important;
	border: 0px !important;
	border-radius: 0px !important;
	color: #FFF !important;
	font-weight: 500 !important;
	font-size: 13px !important;
	font-family: 'Roboto', sans-serif;
	-webkit-box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
	-moz-box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
	box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
}

.table-striped>tbody>tr:nth-of-type(odd) {
	background-color: #00a1ff !important;
	color: #FFF !important;
	font-size: 13px !important;
	/*font-family: 'Roboto', sans-serif;*/
	font-weight: 500 !important;
}

tr.even {
	background: #bfbfbf !important;
	color: #000 !important;
	font-size: 13px !important;
	font-weight: 500 !important;
	font-family: 'Roboto', sans-serif;
}

th.sorting, .sorting_asc {
	font-family: 'Roboto', sans-serif;
	font-weight: 500 !important;
	border: 1px solid #FFF !important;
	color: #FFF;
	border: 1px solid #93CE37;
	border-bottom: 3px solid #9ED929;
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#30b3ff+0,00a1ff+100 */
	background: rgb(48, 179, 255);
	/* Old browsers */
	background: -moz-linear-gradient(top, rgba(48, 179, 255, 1) 0%,
		rgba(0, 161, 255, 1) 100%);
	/* FF3.6-15 */
	background: -webkit-linear-gradient(top, rgba(48, 179, 255, 1) 0%,
		rgba(0, 161, 255, 1) 100%);
	/* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, rgba(48, 179, 255, 1) 0%,
		rgba(0, 161, 255, 1) 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#30b3ff',
		endColorstr='#00a1ff', GradientType=0);
	/* IE6-9 */
	-webkit-border-top-left-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	-moz-border-radius: 5px 5px 0px 0px;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}

.main {
	margin-top: 5px;
	margin-bottom: 25px;
}

input.form-control.input-sm {
	background: #00a1ff !important;
	border: 0px !important;
	border-radius: 0px !important;
	color: #FFF !important;
	font-weight: 500 !important;
	font-size: 13px !important;
	font-family: 'Roboto', sans-serif;
	-webkit-box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
	-moz-box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
	box-shadow: 0px 0px 18px 0px rgba(0, 0, 0, 0.18);
}

.my_center {
	margin: auto;
	width: 50%;
	padding: 20px;
}

.my_title_center {
	/*margin: auto;
                    width: 80%;
        */
	color: <?php echo$text_color_theme; ?>;
	padding: 40px;
}

.col-xs-2 {
	width: 14%;
}

#content_data_area {
	width: 90%;
	margin: auto;
}

.h_sub_title {
	font-weight: 600;
    padding: 20px 30px;
    font-size: 16px;
}

.dropselectsec {
	width: 68%;
	padding: 6px 5px;
	border: 1px solid #ccc;
	border-radius: 3px;
	color: #333;
	margin-left: 10px;
	outline: none;
	font-weight: normal;
}

.dropselectsec1 {
	width: 74%;
	padding: 6px 5px;
	border: 1px solid #ccc;
	border-radius: 3px;
	color: #333;
	margin-left: 10px;
	outline: none;
	font-weight: normal;
}

.mar_ned {
	margin-bottom: 10px;
}

.row {
	margin-right: 0px;
	margin-left: 0px;
}

.table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th
	{
	background-color: #E5EEF4;
	color: #000;
}

th
{
	text-align: center;
}
.display-right .select2
{
	width: 180px!important;
	float: right;
}
label.required:after {content: " *"; color: red;}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
/* .select2-search__field */
/* { */
/* 	display: none!important; */
/* } */
.modal-dialog
{
position: static!important;
}

input#home_phone_no,#cell_phone {
    -moz-appearance:textfield;
}

#budget_year_div .select2-container{
	width: 100px!important;
}

section {
    display: inline-block;
    box-shadow: 1px 2px 15px #e4e7ed;
    margin: 10px 1%;
    padding: 20px 0;
    width: 98%;
}
[type="radio"]:not(:checked), [type="radio"]:checked {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
[type="radio"]:not(:checked)+span:before, [type="radio"]:not(:checked)+span:after {
    border: 2px solid #5a5a5a;
}
[type="radio"]:not(:checked)+span:before, [type="radio"]:not(:checked)+span:after, [type="radio"]:checked+span:before, [type="radio"]:checked+span:after, [type="radio"].with-gap:checked+span:before, [type="radio"].with-gap:checked+span:after {
    border-radius: 50%;
}
[type="radio"]:not(:checked)+span, [type="radio"]:checked+span{
	position: relative;
    padding-left: 35px;
    cursor: pointer;
    display: inline-block;
    height: 25px;
    line-height: 25px;
    -webkit-transition: .28s ease;
    transition: .28s ease;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
[type="radio"]+span:before, [type="radio"]+span:after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    margin: 4px;
    width: 16px;
    height: 16px;
    z-index: 0;
    -webkit-transition: .28s ease;
    transition: .28s ease;
}
[type="radio"]:not(:checked)+span:after {
    -webkit-transform: scale(0);
    transform: scale(0);
}
[type="radio"]:checked+span:after {
    -webkit-transform: scale(0.5);
    transform: scale(0.5);
}
[type="radio"]:checked+span:after {
	background-color: #005C97;
}
[type="radio"]:checked+span:before {
    border: 2px solid transparent;
}
[type="radio"]:checked+span:after, [type="radio"]:checked+span:before {
    border: 2px solid #005C97;
}
input[type="checkbox"]:checked+span:before {
	color: #005C97;
}

</style>
<script src="/assets/default/js/notify.min.js"></script>
<script>
	function validateEmail(email) {
	  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	  return re.test(email);
	}
	function checkID(id)
	{
		var sum;
	    if(id.length != 13)
		     return false;
	     
	    for(i=0, sum=0; i < 12; i++)
	    sum += parseFloat(id.charAt(i))*(13-i); 
	    
	    if((11-sum%11)%10!=parseFloat(id.charAt(12)))
	    return false;return true;
	}
	function my_alert(txt_alert){
		alert_popup(txt_alert);
	}
	function format_words(txt){
		var format_word = 'กรุณากรอกข้อมูล'+txt+'ก่อนค่ะ';
		return format_word;
	}


	function alert_popup(txt)
	{
		var html = '<div class="" style="font-size:20px;"  >';
		html += '<div class="row">';
		html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:  center;">';
		html += '<lable for id="coop_member_id" style="font-color:red">'+txt+'</lable>';
		html += '</div>	';			
		html += '</div>';
		html += '</div>';
		$('#myModal').modal({backdrop: 'static', keyboard: false}) ;
		$('.modal-body').html(html);
		$('#myModal').modal({backdrop: 'static', keyboard: false}) ;

	}
	
	function tab_active(tab_id){
// 		alert(tab_id);
		var temp_name = '';
		var flag = true;
		if(tab_id==2){	
			
			 temp_name = 'first_name'; txt_word = 'ชื่อ';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
        	);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 temp_name = 'last_name'; txt_word = 'นามสกุล';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
        	);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 
			 temp_name = 'idcard'; txt_word = 'เลขที่บัตรประจำตัวประชาชน';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			 $('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
        	);
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 txt_word = 'เลขที่บัตรประจำตัวประชาชนให้ถูกต้อง';
			 if($('#'+temp_name).val()!='' && !checkID($('#'+temp_name).val())){
				 //my_alert(format_words(txt_word));
				 $('#'+temp_name).notify(
	              "โปรดระบุ"+txt_word, 
	              { position:"left middle" }
	        	);
				 $('#'+temp_name).focus();
				 console.log(txt_word);
				 console.log(temp_name);
				 console.log($('#'+temp_name).val());
				 return false;
			}

			 
			 temp_name = 'household_code'; txt_word = 'รหัสครัวเรือน';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
		 	$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
        	);
			 $('#'+temp_name).focus();
			 return false;
			 }


			 temp_name = 'thebirthdate'; txt_word = 'วันเดือนปีเกิด';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
        	);
			$('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 
			 temp_name = 'status'; txt_word = ' ระบุสถานะอื่นๆ';
			 if($('#'+temp_name).val()=='4' && $('#family_status_others').val()==""){
			 //my_alert(format_words(txt_word));
		 	$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#family_status_others').focus();
			 return false;
			 }

			 temp_name = 'status'; txt_word = ' ระบุหมายเลขบัตรประชาชนคู่สมรสที่ถูกต้อง';
			 var family_citizen_id = $('#family_citizen_id').val();
			 if($('#'+temp_name).val()=='2' && !checkID(family_citizen_id)){
			 //my_alert(format_words(txt_word));
			 $('#family_citizen_id').notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#family_citizen_id').focus();
			 return false;
			 }

			 temp_name = 'status'; txt_word = ' ระบุชื่อคู่สมรส';
			 if($('#'+temp_name).val()=='2' && $('#family_name').val()==""){
			 //my_alert(format_words(txt_word));
			 $('#family_name').notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#family_name').focus();
			 return false;
			 }			 
			
			 temp_name = 'house_no'; txt_word = 'บ้านเลขที่';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 return false;
			 }

			 temp_name = 'province_id'; txt_word = 'จังหวัด';
			 if($('#'+temp_name).val()==''){
			// my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }

			 temp_name = 'district_id'; txt_word = 'อำเภอ';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 
			 temp_name = 'email'; txt_word = 'อีเมลให้ถูกต้อง';
			 if($('#'+temp_name).val()!='' && !validateEmail($('#'+temp_name).val())){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }		

			 temp_name = 'postal_code'; txt_word = 'รหัสไปรษณีย์';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 return false;
			 }

			 temp_name = 'province_code'; txt_word = 'รหัสจังหวัด';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }

			 temp_name = 'coop_name'; txt_word = 'สหกรณ์';
			 if($('#'+temp_name).val()=='' && $('#farmer_group_name').val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 
			 temp_name = 'farmer_group_name';  txt_word = 'สหกรณ์';
			 if($('#'+temp_name).val()=='' && $('#coop_name').val()==''){
			// my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 temp_name = 'typeCoop';
			 text_word = 'สหกรณ์ หรือ กลุ่มเกษตรกร';
			 if($('#coop_id').val()==''){


				$('#coop_name_div').hasClass('display');

				if($('#coop_name_div').hasClass('display') !=true)
				{
					 txt_word = 'สหกรณ์';
					 //my_alert(format_words(txt_word));
					$('#'+temp_name).notify(
		              "โปรดระบุ"+txt_word, 
		              { position:"left middle" }
    				);
					$('#coop_name').focus();
					 console.log('coop_name');
				}
				else if($('#coop_group').hasClass('display')!=true)
				{
					 txt_word = 'กลุ่มเกษตรกร';
					 //my_alert(format_words(txt_word));

					$('#'+temp_name).notify(
		              "โปรดระบุ"+txt_word, 
		              { position:"left middle" }
		    		);
					$('#farmer_group_name').focus();

					 console.log('farmer_group_name');
				}else{
					//my_alert(format_words(txt_word));
					$('#'+temp_name).notify(
		              "โปรดระบุ"+txt_word, 
		              { position:"left middle" }
		    		);
				}

				 console.log(txt_word);
				 return false;
			 }


			 
			 temp_name = 'budget_year'; txt_word = 'ปีงบประมาณ';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));

			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 temp_name = 'budget_year'; txt_word = 'ปีงบประมาณ';
			 if($('#'+temp_name).val()!='' && $('#'+temp_name).val().length > 4){
			 //my_alert(format_words(txt_word));

			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }


			 temp_name = 'joining_date'; txt_word = 'วันที่เข้าเป็นสมาชิก';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 
			 temp_name = 'survey_code'; txt_word = 'รหัสแบบสำรวจ';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 temp_name = 'registration_number'; txt_word = 'เลขทะเบียนสมาชิก';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }

			 temp_name = 'stock_register'; txt_word = 'ทะเบียนหุ้น';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }
			 temp_name = 'shares_num'; txt_word = 'จำนวนหุ้น';
			 if($('#'+temp_name).val()==''){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 console.log(txt_word);
			 console.log(temp_name);
			 return false;
			 }



		}/*go tab 2*/

		if(tab_id==3){ /*go tab4 ,check tab2*/
			 temp_name = 'land_holding_rai'; txt_word = 'ข้อมูลพื้นที่ครอบครอง';
			 if(($('#land_holding_rai').val()=='')&&($('#land_holding_ngan').val()=='')&&($('#land_holding_squarewa').val()=='')){
			 //my_alert(format_words(txt_word));
			$('#'+temp_name).notify(
              "โปรดระบุ"+txt_word, 
              { position:"left middle" }
    		);
			 $('#'+temp_name).focus();
			 return false;
			 }

			 var pin_own = $('.own_land_pin');
				txt_word = 'เลขที่บัตรประจำตัวประชาชนให้ถูกต้อง';
				for(var i = 0; i < pin_own.length; i++){
					if($(pin_own[i]).val() !="" && !checkID($(pin_own[i]).val())){
						//my_alert(format_words(txt_word));
						$('#'+temp_name).notify(
			              "โปรดระบุ"+txt_word, 
			              { position:"left middle" }
			    		);
						$(pin_own[i]).focus();
						return false;
						}
					
				}
				var pin_hire = $('.hire_land_pin');
				txt_word = 'เลขที่บัตรประจำตัวประชาชนให้ถูกต้อง';
				for(var i = 0; i < pin_hire.length; i++){
					if($(pin_hire[i]).val() !="" && !checkID($(pin_hire[i]).val())){
						//my_alert(format_words(txt_word));
						$('#'+temp_name).notify(
			              "โปรดระบุ"+txt_word, 
			              { position:"left middle" }
			    		);
						$(pin_hire[i]).focus();
						return false;
						}
				}
		}
		if(tab_id==4){ /*go tab5 ,check tab3*/


			// พืช
			var table_plant = 'tblAddRow31';
			var typeempty = false;		
			var focusObj = null;
			$('#'+table_plant+' tr').each(function(i, obj1) {							
				$(obj1).find('td input').each(function(i, obj2) {
					if ($(obj2).val()!='' && $(obj2).val()!='on')
					{
						$(obj1).find('.plant_type1').each(function(i, obj3) {
							if ($(obj3).val()=='')
							{
								typeempty = true;
							}
							focusObj = obj3;
						});
					}						
				});
			});
			if (typeempty)
			{
				txt_word = ' เลือกชนิดพันธ์พืชให้ครบ ';
				//my_alert(format_words(txt_word));
				$(focusObj).notify(
	              "โปรดระบุ"+txt_word, 
	              { position:"right middle" }
	    		);
				$(focusObj).focus();
				return false;
			}

			// สัตว์บก
			var table_animal1 = 'tblAddRow321';
			var typeempty1 = false;		
			var focusObj1 = null;
			$('#'+table_animal1+' tr').each(function(i, obj1) {							
				$(obj1).find('td input').each(function(i, obj2) {
					if ($(obj2).val()!='' && $(obj2).val()!='on')
					{
						$(obj1).find('.animal_type1').each(function(i, obj3) {
							if ($(obj3).val()=='')
							{
								typeempty1 = true;
							}
							focusObj1 = obj3;
						});
					}						
				});
			});
			if (typeempty1)
			{
				txt_word = ' เลือกชนิดสัตว์บกให้ครบ ';
				//my_alert(format_words(txt_word));
				$(focusObj).notify(
	              "โปรดระบุ"+txt_word, 
	              { position:"right middle" }
	    		);
				$(focusObj1).focus();
				return false;
			}

			// สัตว์น้ำ
			var table_animal2 = 'tblAddRow322';
			var typeempty2 = false;		
			var focusObj2 = null;
			$('#'+table_animal2+' tr').each(function(i, obj1) {							
				$(obj1).find('td input').each(function(i, obj2) {
					if ($(obj2).val()!='' && $(obj2).val()!='on')
					{
						$(obj1).find('.animal_type2').each(function(i, obj3) {
							if ($(obj3).val()=='')
							{
								typeempty2 = true;
							}
							focusObj2 = obj3;
						});
					}						
				});
			});
			if (typeempty2)
			{
				txt_word = ' เลือกชนิดสัตว์น้ำให้ครบ ';
				//my_alert(format_words(txt_word));

				$(focusObj).notify(
	              "โปรดระบุ"+txt_word, 
	              { position:"right middle" }
	    		);
				$(focusObj2).focus();
				return false;
			}

		}
		if(tab_id==5){ /*go tab6 ,check tab4*/

		}
		if(tab_id==6){ /*go tab7 ,check tab5*/

		}
		if(tab_id==7){ /*go tab8 ,check tab6*/

		}

		/* pre */
		if(tab_id>1) {
			$('#steb' + (tab_id - 1)).removeClass('in');
			$('#steb' + (tab_id - 1)).removeClass('active');
		}
		/* next */
		if(tab_id<7) {
			$('#steb' + tab_id).addClass('in');
			$('#steb' + tab_id).addClass('active');
		}
		if(tab_id<=7) {
			$('#steb' + tab_id).addClass('in');
			$('#steb' + tab_id).addClass('active');
		}


		for(i=1;i<=7;i++){ /*reset*/
			$('#tabtab'+i).removeClass('complete');
			$('#tabtab'+i).removeClass('active');
			$('#tabtab'+i).addClass('disabled');
			$('#tabtab'+tab_id).removeClass('complete').removeClass('disabled').addClass('active');
		}
		for(i=1;i<=tab_id;i++){ /*less*/
			$('#tabtab'+i).removeClass('disabled');
			$('#tabtab'+i).removeClass('active');
			$('#tabtab'+i).addClass('complete');
			$('#tabtab'+tab_id).removeClass('complete').removeClass('disabled').addClass('active');
		}
		for(i=1;i>tab_id;i++){/*more*/
			$('#tabtab'+i).removeClass('complete');
			$('#tabtab'+i).removeClass('active');
			$('#tabtab'+i).addClass('disabled');
			$('#tabtab'+tab_id).removeClass('complete').removeClass('disabled').addClass('active');
		}
		$('#tabtab'+tab_id).removeClass('complete').removeClass('disabled').addClass('active');

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

</script>


<div id="main-wrapper">

	<div id="main-container2" class="container-fluid col-md-12 col-xs-12">

		<?php if(isset($user_survey_data['citizen_id'])){?>
			<?php if ($mode=="view"){?>
	            <h2><span class="glyphicon glyphicon-eye-open"></span> ดูแบบสำรวจ</h2>
				<?php } else {?>
	            <h2><span class="glyphicon glyphicon-edit"></span> แก้ไขแบบสำรวจ</h2>
        	<?php }?>
        <?php }else {?> 
       		<h2><span class="glyphicon glyphicon-plus"></span> สร้างแบบสำรวจ</h2>
		<?php } ?>
		


		<!--login html -->
		<div>
			<div>
				<div class="row">
					<div class="board">
						<div class="board-inner">
							<style type="text/css">
								.bs-wizard {margin-top: 40px;}

								/*Form Wizard*/

								.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0px;}
								.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
								.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
								.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
								.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
								.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute;width: 34px;height: 34px;display: block;background: #234595;top: 22px;left: 50%;margin-top: -15px;margin-left: -15px;border-radius: 50%;}
								.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {    content: ' ';width: 28px;height: 28px;background: #234595;border-radius: 50px;position: absolute;top: 3px;left: 3px;border: 5px solid #ffffff;}
								.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
								.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #234595;}
								.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
								.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%; }
								.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
								.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar { width: 100%;}
								.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
								.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
								.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
								.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
								.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
								.bs-wizard > .bs-wizard-step.active .bs-wizard-info{color:#234595;}
								.bs-wizard > .bs-wizard-step.active .bs-wizard-stepnum{color:#234595;}

							</style>

							<div id="myDIVprogress" class="row bs-wizard" style="border-bottom:0;  ">

								<?php if($mode=="view"){ ?>
									<script type="text/javascript">
										$(document).ready(function(){
											$("#accountForm :input").prop("disabled", true);
											/*$("#accountForm :select").prop("disabled", true);*/
											$("#accountForm :checkbox").prop("disabled", true);
											$("#accountForm :radio").prop("disabled", true);
										});
									</script>
								<?php }else{ ?>

									<div id="tabtab1" class="col-md-2 bs-wizard-step active">
										<div class="progress"><div class="progress-bar"></div></div>
										<a href="#steb1" onclick="tab_active(1);" data-toggle="tab" onclick="" title="steb1" class="bs-wizard-dot"  id="st1"></a>
										<div class="bs-wizard-info text-center">ข้อมูลทั่วไป</div>
									</div>

									<div id="tabtab2" class="col-md-2 bs-wizard-step disabled"><!-- complete -->
										<div class="progress"><div class="progress-bar"></div></div>
										<a href="#steb2" onclick="tab_active(2);" data-toggle="tab"  title="steb2" class="bs-wizard-dot"  id="st2"></a>
										<div class="bs-wizard-info text-center">พื้นที่ครอบครอง</div>
									</div>

									<div id="tabtab3" class="col-md-2 bs-wizard-step disabled"><!-- complete -->
										<div class="progress"><div class="progress-bar"></div></div>
										<a href="#steb3" onclick="tab_active(3);" data-toggle="tab"  title="steb3" class="bs-wizard-dot"  id="st3"></a>
										<div class="bs-wizard-info text-center">การปลูกพืชและเลี้ยงสัตว์</div>
									</div>

									<div id="tabtab4" class="col-md-2 bs-wizard-step disabled"><!-- active -->
										<div class="progress"><div class="progress-bar"></div></div>
										<a href="#steb4" onclick="tab_active(4);" data-toggle="tab"  title="steb4" class="bs-wizard-dot"  id="st4"></a>
										<div class="bs-wizard-info text-center">ปัญหาที่พบ</div>
									</div>

									<div id="tabtab5" class="col-md-2 bs-wizard-step disabled"><!-- active -->
										<div class="progress"><div class="progress-bar"></div></div>
										<a href="#steb5" onclick="tab_active(5);" data-toggle="tab"  title="steb5" class="bs-wizard-dot"  id="st5"></a>
										<div class="bs-wizard-info text-center">ข้อมูลหนี้สิน</div>
									</div>

									<div id="tabtab6" class="col-md-2 bs-wizard-step disabled"><!-- active -->
										<div class="progress"><div class="progress-bar"></div></div>
										<a href="#steb6" onclick="tab_active(6);" data-toggle="tab"  title="steb6" class="bs-wizard-dot" id="st6"></a>
										<div class="bs-wizard-info text-center">ข้อมูลการเลี้ยงโคนม</div>
									</div>

								<?php } ?>

							</div>
						</div>
						<div class="modal fade" id="myModal" role="dialog">
						    <div class="modal-dialog" style="width: 500px">
						    
							      <!-- Modal content-->
							      <div class="modal-content">
							        <div class="modal-header" style="height: 45px;">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          
							        </div>
							        <div class="modal-body">
							        
							        </div>
							        <div class="modal-footer">
							          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
							        </div>
							      </div>
							      
							</div>
				  		</div>
						<?php
						$action_page = 'do_survey_add';
					///	if(isset($user_survey_data['citizen_id'])){ $action_page = 'do_survey_edit'; } ?>
						<form id="accountForm" method="post" action="<?php echo site_url('admin/'.$action_page); ?>">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
							<div class="row form-result">
								<div class="tab-content">
									<?php 
										$tab_idxx=1;
										$view_active="";
										if($mode=="view"){
											$view_active=" in active";
										}
									?>
									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; ?>">
										<?php include_once("tab".$tab_idxx."_form_data_v2.php"); $tab_idxx++; ?>
									</div>
									<div class="tab-pane fade <?php echo $view_active; ?>" id="steb<?php echo $tab_idxx; ?>">
										<?php   include_once("tab".$tab_idxx."_form_data_v2.php"); $tab_idxx++; ?>
									</div>
									<div class="tab-pane fade <?php echo $view_active; ?>" id="steb<?php echo $tab_idxx; ?>">
										<?php include_once("tab".$tab_idxx."_form_data_v2.php"); $tab_idxx++; ?>
									</div>
									<div class="tab-pane fade <?php echo $view_active; ?>" id="steb<?php echo $tab_idxx; ?>">
										<?php include_once("tab".$tab_idxx."_form_data_v2.php"); $tab_idxx++; ?>
									</div>
									<div class="tab-pane fade <?php echo $view_active; ?>" id="steb<?php echo $tab_idxx; ?>">
										<?php   include_once("tab".$tab_idxx."_form_data_v2.php"); $tab_idxx++; ?>
									</div>
									<div class="tab-pane fade <?php echo $view_active; ?>" id="steb<?php echo $tab_idxx; ?>">
										<?php  include_once("tab".$tab_idxx."_form_data_v2.php"); $tab_idxx++; ?>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<!--end  html -->
		
	</div>
</div>


<script type="text/javascript">
	$(window).load(function(){

		$(function(){

			/* Thai initialisation for the jQuery UI date picker plugin. */
			/* Written by pipo (pipo@sixhead.com). */
			( function( factory ) {
				if ( typeof define === "function" && define.amd ) {

					// AMD. Register as an anonymous module.
					define( [ "../widgets/datepicker" ], factory );
				} else {

					// Browser globals
					factory( jQuery.datepicker );
				}
			}( function( datepicker ) {

			datepicker.regional.th = {
				closeText: "ปิด",
				prevText: "&#xAB;&#xA0;ย้อน",
				nextText: "ถัดไป&#xA0;&#xBB;",
				currentText: "วันนี้",
				monthNames: [ "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
				"กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม" ],
				monthNamesShort: [ "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				"ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค." ],
				dayNames: [ "อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์" ],
				dayNamesShort: [ "อา.","จ.","อ.","พ.","พฤ.","ศ.","ส." ],
				dayNamesMin: [ "อา.","จ.","อ.","พ.","พฤ.","ศ.","ส." ],
				weekHeader: "Wk",
				dateFormat: "dd/mm/yy",
				firstDay: 0,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: "" };
			datepicker.setDefaults( datepicker.regional.th );

			return datepicker.regional.th;

			} ) );

			function DateThai($strDate) {
			    $strYear = $strDate.getFullYear() + 543;
			    $strMonth = $strDate.getMonth() + 1;
			    $strDay = $strDate.getDate();
			    return $strYear+","+$strMonth+","+$strDay;
			}

		    // กรณีใช้แบบ input
		    $("#thebirthdate").datetimepicker({
		        timepicker:false,
		        maxDate: new Date(DateThai(new Date())),
		        yearStart: 2460,
		        yearEnd: <?php echo date("Y")+543; ?>,
		        format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000 
		        defaultDate:new Date(DateThai(new Date())), 
		        onSelectDate:function(dp,$input){
		            var yearT=new Date(dp).getFullYear()-0;  
		            var yearTH=yearT;
		            var fulldate=$input.val();
		            var fulldateTH=fulldate.replace(yearT,yearTH);
		            $input.val(fulldateTH);
		        },
		    });       
		    // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
		    /*$("#thebirthdate").on("mouseenter mouseleave",function(e){
		        var dateValue=$(this).val();
		        if(dateValue!=""){
		                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
		                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
		                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
		                if(e.type=="mouseenter"){
		                    var yearT=arr_date[2]-543;
		                }       
		                if(e.type=="mouseleave"){
		                    var yearT=parseInt(arr_date[2])+543;
		                }   
		                dateValue=dateValue.replace(arr_date[2],yearT);
		                $(this).val(dateValue);                                                 
		        }       
		    });*/
		 	// กรณีใช้แบบ input
		 	$.datepicker.setDefaults( $.datepicker.regional[ "th" ] );
		    $("#joining_date").datetimepicker({
		        timepicker:false,
		        maxDate: new Date(DateThai(new Date())),
		        yearStart: 2460,
		        yearEnd: <?php echo date("Y")+543; ?>,
		        format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000  
		        defaultDate:new Date(DateThai(new Date())),
		        onSelectDate:function(dp,$input){
		            var yearT=new Date(dp).getFullYear()-0;  
		            var yearTH=yearT;
		            var fulldate=$input.val();
		            var fulldateTH=fulldate.replace(yearT,yearTH);
		            $input.val(fulldateTH);
		        },
		    });       
		    // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
		    /*$("#joining_date").on("mouseenter mouseleave",function(e){
		        var dateValue=$(this).val();
		        if(dateValue!=""){
		                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
		                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
		                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
		                if(e.type=="mouseenter"){
		                    var yearT=arr_date[2]-543;
		                }       
		                if(e.type=="mouseleave"){
		                    var yearT=parseInt(arr_date[2])+543;
		                }   
		                dateValue=dateValue.replace(arr_date[2],yearT);
		                $(this).val(dateValue);                                                 
		        }       
		    });*/

		});

	});

	$('select[name="province_id"]').on('change',function(){

		var provinceId=$(this).val();$.ajax({
			type:"GET",url:"<?php echo site_url('admin/listjson_local/'); ?>"+provinceId,data:{
				province:provinceId},success:function(data){
				var a=JSON.parse(data);$('select[name="district_id"]').prop("disabled",false);
				$("#district_id").html(a.response);
				console.log(a.response);
			}});

		/*$('#district_id').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกอำเภอ"
				});
		});
		
		$("#sub_district_id").html('');
		$('#sub_district_id').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกตำบล"
				});
		});*/
		
	});
	$('select[name="district_id"]').on('change',function(){

		var district_id=$(this).val();$.ajax({
			type:"GET",url:"<?php echo site_url('admin/listjson_local2/'); ?>"+district_id,data:{
				district_id:district_id},success:function(data){
				var a=JSON.parse(data);$('select[name="sub_district_id"]').prop("disabled",false);
				$("#sub_district_id").html(a.response);
				console.log(a.response);
			}});

		/*$('#sub_district_id').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกตำบล"
				});
		});*/
	});

	$("input").on("keyup", function() {
		var valueee = $(this).val();
		var id=$(this).attr('id');
		if ($(this).attr('id')!='email')
		{
			valueee = valueee.replace(/@/g , "");
		}

		valueee = valueee.replace(/</g , "");
		valueee = valueee.replace(/>/g , "");
		valueee = valueee.replace(/#/g , "");
		valueee = valueee.replace(/#/g , "");
		valueee = valueee.replace(/&/g , "");
		valueee = valueee.replace(/\(/g , "");
		valueee = valueee.replace(/\)/g , "");
		valueee = valueee.replace(/\$/g , "");
		valueee = valueee.replace(/!/g , "");
		valueee = valueee.replace(/\^/g , "");
		valueee = valueee.replace(/\[/g , "");
		valueee = valueee.replace(/\]/g , "");
		valueee = valueee.replace(/{/g , "");
		valueee = valueee.replace(/}/g , "");
		valueee = valueee.replace(/\\/g , "");
		valueee = valueee.replace(/\*/g , "");
		valueee = valueee.replace(/\+/g , "");
		valueee = valueee.replace(/~/g , "");
		valueee = valueee.replace(/\|/g , "");
		valueee = valueee.replace(/\?/g , "");
		valueee = valueee.replace(/%/g , "");
		valueee = valueee.replace(/:/g , "");
		valueee = valueee.replace(/;/g , "");
		valueee = valueee.replace(/\_/g , "");
		
		$(this).val(valueee);
	});
	
</script>
<script type="text/javascript">

	function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;

	    if (charCode==8)
		    return true;
	    
	    if (charCode!=8 && charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	} 

	// no html
	function isValidInput(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;

	    if (charCode==8)
		    return true;

	    if (charCode==34 || charCode==39  || charCode==60 || charCode==62 ) {
	        return false;
	    }
	    return true;
	} 
	
	function isAlpha(e) {
		var reg = /^[a-zA-Zก-๗]+$/i;
		var reg_num_thai = /^[๑-๗]+$/i;
		console.log(reg.test(e.key));
		console.log(reg_num_thai.test(e.key));

		if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
		{
			return true;
		}else{
			return false;
		}
	} 

	function isAlphaNumeric(e) {
		var reg = /^[a-zA-Zก-๗0-9]+$/i;
		var reg_num_thai = /^[๑-๗]+$/i;
		console.log(reg.test(e.key));
		console.log(reg_num_thai.test(e.key));
		if (e.keyCode==8 || e.keyCode==37 || e.keyCode==39 || e.key==' ' || e.key=='/' || e.key=='-')
		{
			return true;
		}
		if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
		{
			return true;
		}else{
			return false;
		}
	} 	
	
	function isDate(e) {
		var reg = /^[0-9]+$/i;
		if (e.keyCode==8 || e.keyCode==37 || e.keyCode==39)
		{
			return true;
		}
		if((reg.test(e.key)||(e.key=='-')) && !e.key !='฿' )
		{
			return true;
		}else{
			return false;
		}
	} 			

	function isHomePhoneNumber(evt) {

	    evt = (evt) ? evt : window.event;

	    var charCode = (evt.which) ? evt.which : evt.keyCode;

	    if (charCode==8)
		    return true;
	    
	    if (charCode!=8 && charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    
	    if (evt.target.value.length>9)
	    {
	    	return false;
	    }
		
	    return true;
	} 

	function isPhoneNumber(evt) {

	    evt = (evt) ? evt : window.event;

	    var charCode = (evt.which) ? evt.which : evt.keyCode;

	    if (charCode==8)
		    return true;
	    
	    if (charCode!=8 && charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    
	    if (evt.target.value.length>9)
	    {
	    	return false;
	    }
		
	    return true;
	} 


	function isPostalCode(evt) {

	    evt = (evt) ? evt : window.event;

	    var charCode = (evt.which) ? evt.which : evt.keyCode;

	    if (charCode==8)
		    return true;
	    
	    if (charCode!=8 && charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    

	    if (evt.target.value.length>4)
	    {
	    	return false;
	    }
		
	    return true;
	} 


	function isPinNumber(evt) {

	    evt = (evt) ? evt : window.event;

	    var charCode = (evt.which) ? evt.which : evt.keyCode;

	    if (charCode==8)
		    return true;
	    
	    if (charCode!=8 && charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    

	    if (evt.target.value.length>12)
	    {
	    	return false;
	    }
		
	    return true;
	} 

	function isDecimal(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if ((charCode !=8) && (charCode != 46)  && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}
	
	$(window).load(function(){

		$(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
			if ((event.which !=8) && (event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				return false;
			}
            return true;
		});

		$(".allownumericwithoutdecimal").on("keypress",function (event) {
			console.log($(this).val().length);

			var charCode = (event.which) ? event.which : event.keyCode;
			if (charCode==8)
			{
			    return true;
			}

			var reg = /^[0-9]+$/i;
			if(reg.test(event.key))
			{
				if($(this).val().length >=13)
				{
					return false;
				}
				return true;
			}else{
				if(event.key ==  '.' || event.shiftKey || (  event.key !=  '0' && event.key !=  '1'  && event.key !=  '2'  && event.key !=  '3' 
					 && event.key !=  '4'  && event.key !=  '5'  && event.key !=  '6'  && event.key !=  '7' 
						 && event.key !=  '8'  && event.key !=  '9'   ) && event.keyCode!=8 ){
					return false;
				}
				if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
						// Allow: Ctrl/cmd+A
					(event.keyCode == 65 && (event.ctrlKey === true || event.metaKey === true)) ||
						// Allow: Ctrl/cmd+C
					(event.keyCode == 67 && (event.ctrlKey === true || event.metaKey === true)) ||
						// Allow: Ctrl/cmd+X
					(event.keyCode == 88 && (event.ctrlKey === true || event.metaKey === true)) ||
						// Allow: home, end, left, right
					(event.keyCode >= 35 && event.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
				}
				return false;
			}

			if($(this).val().length >=13)
				return false;
		});

		function isNumberKey(evt)
		{
			var charCode=(evt.which)?evt.which:event.keyCode
			if(charCode>31&&(charCode<48||charCode>57))
				return false;return true;
		}

	});

	

	$(document).ready(function() {
		$('form').on('keyup keypress', function(e) {
		  var keyCode = e.keyCode || e.which;
		  if (keyCode === 13) { 
		    e.preventDefault();
		    return false;
		  }
		});
		$('form').on('focus', 'input[type=number]', function (e) {
			  $(this).on('mousewheel.disableScroll', function (e) {
			    e.preventDefault()
			  })
		});
		$('form').on('blur', 'input[type=number]', function (e) {
			  $(this).off('mousewheel.disableScroll')
		});


		$('#coop_name_div').click(function(){
			$('#org_type1').click();
		});
		/*$('#province_id').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกจังหวัด"
				});
		});
		$('#district_id').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกอำเภอ"
				});
		});				
		$('#sub_district_id').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกตำบล"
				});
		});
		$('#name_title').each(function( index ) {
			$(this).select2({
				  placeholder: "เลือกคำนำหน้า",
				  width:'140px'
				});
		});*/

		$('#status').each(function( index ) {
			$(this).select2({
				  placeholder: "สถานะภาพ",
				  width:'100px'
				});
		});
		
		$('#education').each(function( index ) {
			$(this).select2({
				  placeholder: "ระดับการศึกษา"
				});
		});

	  	$('.hasDatepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
						
		//Number of steps in all
		var steps = 7;
		//Current step
		var current = 1;
		//progress element
		var btnContainer = document.getElementById("myDIVprogress");
		var btns = btnContainer.getElementsByClassName("bs-wizard-dot");

		$('#first_name').keydown(function(e) {
			console.log(e.key);
			var reg = /^[a-zA-Zก-๗]+$/i;
			var reg_num_thai = /^[๑-๗]+$/i;
			console.log(reg.test(e.key));
			console.log(reg_num_thai.test(e.key));

			if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
			{
				return;
			}else{
				e.preventDefault();
				}				    
		});

		
		$('#last_name').keydown(function(e) {
			console.log(e.key);
			var reg = /^[a-zA-Zก-๗]+$/i;
			var reg_num_thai = /^[๑-๗]+$/i;
			console.log(reg.test(e.key));
			console.log(reg_num_thai.test(e.key));

			if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
			{
				return;
			}else{
				e.preventDefault();
				}

		    
		});
		$('.first_name_land').keydown(function(e) {

			console.log(e.key);
			var reg = /^[a-zA-Zก-๗]+$/i;
			var reg_num_thai = /^[๑-๗]+$/i;
			console.log(reg.test(e.key));
			console.log(reg_num_thai.test(e.key));

			if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
			{
				return;
			}else{
				e.preventDefault();
				}

		    
		});
		$('.last_name_land').keydown(function(e) {

			console.log(e.key);
			var reg = /^[a-zA-Zก-๗]+$/i;
			var reg_num_thai = /^[๑-๗]+$/i;
			console.log(reg.test(e.key));
			console.log(reg_num_thai.test(e.key));

			if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
			{
				return;
			}else{
				e.preventDefault();
				}			    
		});

		$('#home_phone_no').keydown(function(e) {
			var reg = /^[0-9]+$/i;
			if(reg.test(e.key))
			{
				if($(this).val().length >=13)
				{
					e.preventDefault();
				}
				return;
			}else{
				if(e.key ==  '.' || e.shiftKey || (  e.key !=  '0' && e.key !=  '1'  && e.key !=  '2'  && e.key !=  '3' 
					 && e.key !=  '4'  && e.key !=  '5'  && e.key !=  '6'  && e.key !=  '7' 
						 && e.key !=  '8'  && e.key !=  '9'   ) && e.keyCode!=8 ){
					e.preventDefault();
				}
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
						// Allow: Ctrl/cmd+A
					(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||/
						// Allow: Ctrl/cmd+C
					(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+X
					(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
				}
				e.preventDefault();
			}
		});


		$('#cell_phone').keydown(function(e) {
			var reg = /^[0-9]+$/i;
			if(reg.test(e.key))
			{
				if($(this).val().length >=13)
				{
					e.preventDefault();
				}
				return;
			}else{
				if(Number.isInteger(e.key)  || e.key ==  '.' || e.shiftKey || e.key ==  '>'){
					e.preventDefault();
				}
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
						// Allow: Ctrl/cmd+A
					(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+C
					(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+X
					(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
				}
				e.preventDefault();
			}
		});

		 
	});
	
	jQuery(document).on('keydown', 'input.own_land_ngan', function(ev) {
		 var $this = $(this)

         t = setInterval(

             function () {
                 if (($this.val() < 0 || $this.val() >= 4) ) {
                     if ($this.val() < 1) {
                         $this.val(0)
                     }

                     if ($this.val() >= 4) {
                         $this.val(3)
                     }

                 }
             }, 50)
		    
		});
	
	jQuery(document).on('keydown', 'input.own_land_squarewa', function(ev) {
		var $this = $(this)

        f = setInterval(

            function () {
                if (($this.val() < 0 || $this.val() >= 100)) {
                    if ($this.val() < 0) {
                        $this.val(0)
                    }

                    if ($this.val() >= 100) {
                        $this.val(99)
                    }

                }
            }, 50)
		    
		});

	jQuery(document).on('keydown', 'input.hire_land_ngan', function(ev) {
		 var $this = $(this)

        t = setInterval(

            function () {
                if (($this.val() < 0 || $this.val() >= 4) ) {
                    if ($this.val() < 1) {
                        $this.val(0)
                    }

                    if ($this.val() >= 4) {
                        $this.val(3)
                    }

                }
            }, 50)
		    
		});
	
	jQuery(document).on('keydown', 'input.hire_land_squarewa', function(ev) {
		var $this = $(this)

       f = setInterval(

           function () {
               if (($this.val() < 0 || $this.val() >= 100)) {
                   if ($this.val() < 0) {
                       $this.val(0)
                   }

                   if ($this.val() >= 100) {
                       $this.val(99)
                   }

               }
           }, 50)
		    
	});
</script>	