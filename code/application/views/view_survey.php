<?php
 $this->load->helper('form');

$text_color_theme = '#428bca';

$mode = '';
// if(isset($_GET['mode'])){
// 	if($_GET['mode']=="view"){
// 		$mode = "view";
// 	}
// }


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

// $plan_name[$i] = "ข้าวเจ้า";   $plan_code[$i] = "13"; $i++;
// $plan_name[$i] = "ข้าวเหนียว";   $plan_code[$i] = "14"; $i++;
// $plan_name[$i] = "ข้าวฟ่าง";   $plan_code[$i] = "15"; $i++;
// $plan_name[$i] = "ข้าวโพดเลี้ยงสัตว์";   $plan_code[$i] = "30"; $i++;
// $plan_name[$i] = "ถั่วเขียว";   $plan_code[$i] = "34"; $i++;
// $plan_name[$i] = "มันสำปะหลัง";   $plan_code[$i] = "35"; $i++;
// $plan_name[$i] = "อ้อยโรงงาน";   $plan_code[$i] = "66"; $i++;
// $plan_name[$i] = "งา";   $plan_code[$i] = "65"; $i++;
// $plan_name[$i] = "ถั่วลิสง";   $plan_code[$i] = "32"; $i++;
// $plan_name[$i] = "ถั่วเหลือง";   $plan_code[$i] = "33"; $i++;
// $plan_name[$i] = "ทานตะวัน";   $plan_code[$i] = "61"; $i++;
// $plan_name[$i] = "ปาล์มน้ำมัน";   $plan_code[$i] = "62"; $i++;
// $plan_name[$i] = "มะพร้าว";   $plan_code[$i] = "63"; $i++;
// $plan_name[$i] = "ละหุ่ง";   $plan_code[$i] = "64"; $i++;
// $plan_name[$i] = "ปอแก้ว";   $plan_code[$i] = "73"; $i++;
// $plan_name[$i] = "ฝ้าย";   $plan_code[$i] = "74"; $i++;
// $plan_name[$i] = "กระเทียม";   $plan_code[$i] = "23"; $i++;
// $plan_name[$i] = "ข้าวโพดฟักอ่อน";   $plan_code[$i] = "31"; $i++;
// $plan_name[$i] = "พริกแห้งใหญ่";   $plan_code[$i] = "24"; $i++;
// $plan_name[$i] = "มะเขือเทศ";   $plan_code[$i] = "25"; $i++;
// $plan_name[$i] = "มันฝรั่ง";   $plan_code[$i] = "36"; $i++;
// $plan_name[$i] = "หอมหัวใหญ่";   $plan_code[$i] = "27"; $i++;
// $plan_name[$i] = "หอมแดง";   $plan_code[$i] = "28"; $i++;
// $plan_name[$i] = "กล้วยหอม";   $plan_code[$i] = "42"; $i++;
// $plan_name[$i] = "กล้วยไข่";   $plan_code[$i] = "43"; $i++;
// $plan_name[$i] = "ทุเรียน";   $plan_code[$i] = "44"; $i++;
// $plan_name[$i] = "มะนาว";   $plan_code[$i] = "29"; $i++;
// $plan_name[$i] = "มังคุด";   $plan_code[$i] = "45"; $i++;
// $plan_name[$i] = "ลำไย";   $plan_code[$i] = "40"; $i++;
// $plan_name[$i] = "ลิ้นจี่";   $plan_code[$i] = "41"; $i++;
// $plan_name[$i] = "ลองกอง";   $plan_code[$i] = "46"; $i++;
// $plan_name[$i] = "มะขามหวาน";   $plan_code[$i] = "47"; $i++;
// $plan_name[$i] = "มะขามเปรี้ยว";   $plan_code[$i] = "48"; $i++;
// $plan_name[$i] = "มะละกอ";   $plan_code[$i] = "49"; $i++;
// $plan_name[$i] = "มะพร้าวอ่อน";   $plan_code[$i] = "50"; $i++;
// $plan_name[$i] = "สับปะรด";   $plan_code[$i] = "51"; $i++;
// $plan_name[$i] = "เงาะ";   $plan_code[$i] = "52"; $i++;
// $plan_name[$i] = "กาแฟ";   $plan_code[$i] = "71"; $i++;
// $plan_name[$i] = "ยางพารา";   $plan_code[$i] = "91"; $i++;
// $plan_name[$i] = "ไผ่";   $plan_code[$i] = "93"; $i++;
// $plan_name[$i] = "สะตอ";   $plan_code[$i] = "22"; $i++;
// $plan_name[$i] = "ส้มโอ";   $plan_code[$i] = "53"; $i++;
// $plan_name[$i] = "ส้มเขียวหวาน";   $plan_code[$i] = "54"; $i++;
// $plan_name[$i] = "ชา";   $plan_code[$i] = "72"; $i++;
// $plan_name[$i] = "กล้วยไม้";   $plan_code[$i] = "94"; $i++;
// $plan_name[$i] = "พริกไทย";   $plan_code[$i] = "21"; $i++;
// $plan_name[$i] = "ยาสูบ";   $plan_code[$i] = "75"; $i++;
// $plan_name[$i] = "พืชอาหารสัตว์";   $plan_code[$i] = "92"; $i++;



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
/* written by riliwan balogun http://www.facebook.com/riliwan.rabo*/
.board {
	width: 90%;
	margin: 60px auto;
	/*  height: 500px; */
	background: #fff;
	/*box-shadow: 10px 10px #ccc,-10px 20px #ddd;*/
}

.board .nav-tabs {
	position: relative;
	/* border-bottom: 0; */
	/* width: 80%; */
	margin: 2px auto;
	margin-bottom: 0;
	box-sizing: border-box;
}

.board>div.board-inner {
	background: #fafafa
		url(http://subtlepatterns.com/patterns/geometry2.png);
	background-size: 30%;
}

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
	color: <?php echo$text_color_theme;
	?>;
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
	background-color: #ececec;
	color: #000;
}

.col-md-6 input[type=text],.col-md-5 input[type=text],.col-md-4 input[type=text],.col-md-3 input[type=text],
.col-md-6 input[type=number],.col-md-5 input[type=number],.col-md-4 input[type=number],.col-md-3 input[type=number],
.col-sm-6 input[type=number],.col-sm-5 input[type=number],.col-sm-4 input[type=number],.col-sm-3 input[type=number],
.col-sm-6 input[type=text],.col-sm-5 input[type=text],.col-sm-4 input[type=text],.col-sm-3 input[type=text]
 {
 	float: right;
}
#adress #province .select2
{
	float: right;
/* 	margin-right: 7px!important; */
	width: 140px!important;
} 
#adress #district .select2
{
float: right;
/* 	margin-right: 25px!important; */
	width: 150px!important;
}
#adress #sub_district .select2
{
float: right;
	width: 150px!important;
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

label{
float: left;
padding-right: 10px;
}

</style>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>


<div id="main-wrapper">

	<div id="main-container2" class="container-fluid col-md-12 col-xs-12">

		<?php if(isset($user_survey_data['citizen_id'])){?>
            <h2><span class="glyphicon glyphicon-eye-open"></span> ดูแบบสำรวจ</h2>
        <?php }else {?> 
       		<h2><span class="glyphicon glyphicon-plus"></span> สร้างแบบสำรวจ</h2>
		<?php } ?>
		


		<!--login html -->
		<section style="background:#efefe9; /*height: 760px;*/">
			<div <?php /* class="container"*/ ?>>
				<div class="row">
					<div class="board">
						<!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
						<div class="board-inner">
							<center> <h3 class="my_title_center">แบบสำรวจข้อมูลการผลิตและการตลาดของสมาชิกสหกรณ์/กลุ่มเกษตรกร</h3></center>


							<?php 
// 							if(sizeof($list_array)>1)
// 							{
							?>
<!-- 							<ul> -->
							<?php 
// 								foreach ($list_array as $list_survey)
// 								{
							?>
<!--								<li><a><?php //echo $list_survey;?></a></li>
							<?php 	
// 								}
							?>
<!-- 							</ul> -->
							<?php 
// 							}
							
							?>

							<style type="text/css">
								.bs-wizard {margin-top: 40px;}

								/*Form Wizard*/

								.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0px;}
								.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
								.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
								.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
								.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
								.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #5bc0de; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
								.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #ffffff; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
								.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
								.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #5bc0de;}
								.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
								.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%; }
								.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
								.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar { width: 100%;}
								.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
								.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
								.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
								.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
								.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
								.bs-wizard > .bs-wizard-step.active .bs-wizard-info{color:#5bc0de;}
								.bs-wizard > .bs-wizard-step.active .bs-wizard-stepnum{color:#5bc0de;}

								/*END Form Wizard*/
			/*
								#steb2{
									display:none;
								}
								#steb3{
									display:none;
								}
								#steb4{
									display:none;
								}
								#steb5{
									display:none;
								}
								#steb6{
									display:none;
								}
								#steb7{
									display:none;
								}*/
							</style>

							<div id="myDIVprogress" class="row bs-wizard" style="border-bottom:0;  ">

<?php //if($mode=="view"){ ?>
<!-- 	<div id="tabtab1" class="col-xs-2 bs-wizard-step complete"> -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 1</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> --
		<a href="#steb1"  data-toggle="tab" onclick="" title="steb1" class="bs-wizard-dot"></a>
<!-- 		<div class="bs-wizard-info text-center">ข้อมูลทั่วไป</div> --
<!-- 	</div> --

	<div id="tabtab2" class="col-xs-2 bs-wizard-step complete "><!-- complete -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 2</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> -->
<!-- 		<a href="#steb2"   data-toggle="tab"  title="steb2" class="bs-wizard-dot"></a> -->
<!-- 		<div class="bs-wizard-info text-center">ข้อมูลเอกสารสิทธิ์</div> -->
<!-- 	</div> 

	<div id="tabtab3" class="col-xs-2 bs-wizard-step complete "><!-- complete -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 3</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> -->
<!-- 		<a href="#steb3"   data-toggle="tab"  title="steb3" class="bs-wizard-dot"></a> -->
<!-- 		<div class="bs-wizard-info text-center">ส่วนการปลูกพืชและสัตว์<br/>(ปีที่ผ่านมา)</div> -->
<!-- 	</div> 

	<div id="tabtab4" class="col-xs-2 bs-wizard-step complete "><!-- active -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 4</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> -->
<!-- 		<a href="#steb4"   data-toggle="tab"  title="steb4" class="bs-wizard-dot"></a> -->
<!-- 		<div class="bs-wizard-info text-center">ส่วนปัญหาที่พบ<br/>ในการประกอบอาชีพ</div> -->
<!-- 	</div> 

	<div id="tabtab5" class="col-xs-2 bs-wizard-step  complete"><!-- active -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 5</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> -->
<!-- 		<a href="#steb5"   data-toggle="tab"  title="steb5" class="bs-wizard-dot"></a> -->
<!-- 		<div class="bs-wizard-info text-center">ส่วนข้อมูลหนี้สิน</div> -->
<!-- 	</div> 

	<div id="tabtab6" class="col-xs-2 bs-wizard-step complete "><!-- active -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 6</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> -->
<!-- 		<a href="#steb6"   data-toggle="tab"  title="steb6" class="bs-wizard-dot"></a> -->
<!-- 		<div class="bs-wizard-info text-center">ส่วนการปลูกพืช<br/>(ปัจจุบัน)</div> -->
<!-- 	</div> -->

<!-- 	<div id="tabtab7" class="col-xs-2 bs-wizard-step active "><!-- active -->
<!-- 		<div class="text-center bs-wizard-stepnum">ส่วนที่ 7</div> -->
<!-- 		<div class="progress"><div class="progress-bar"></div></div> -->
<!-- 		<a href="#steb7"   data-toggle="tab"  title="steb7" class="bs-wizard-dot"></a> -->
<!-- 		<div class="bs-wizard-info text-center">ส่วนข้อมูล<br/>การเลี้ยงโคนม</div> -->
<!-- 	</div> -->

<?php //}else{ ?>

<!-- 								<div id="tabtab1" class="col-md-2 bs-wizard-step active"> -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 1</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> --
									<a href="#steb1" onclick="tab_active(1);" data-toggle="tab" onclick="" title="steb1" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">ข้อมูลทั่วไป</div> -->
<!-- 								</div> --

								<div id="tabtab2" class="col-md-2 bs-wizard-step disabled"><!-- complete -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 2</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> --
									<a href="#steb2" onclick="tab_active(2);" data-toggle="tab"  title="steb2" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">พื้นที่ครอบครอง</div> -->
<!-- 								</div> --

								<div id="tabtab3" class="col-md-2 bs-wizard-step disabled"><!-- complete -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 3</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> --
									<a href="#steb3" onclick="tab_active(3);" data-toggle="tab"  title="steb3" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">การปลูกพืชและสัตว์</div> -->
<!-- 								</div> --

								<div id="tabtab4" class="col-md-2 bs-wizard-step disabled"><!-- active -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 4</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> --
									<a href="#steb4" onclick="tab_active(4);" data-toggle="tab"  title="steb4" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">ส่วนปัญหาที่พบ</div> -->
<!-- 								</div> --

								<div id="tabtab5" class="col-md-2 bs-wizard-step disabled"><!-- active -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 5</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> --
									<a href="#steb5" onclick="tab_active(5);" data-toggle="tab"  title="steb5" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">ข้อมูลหนี้สิน</div> -->
<!-- 								</div> --

								<div id="tabtab6" class="col-md-2 bs-wizard-step disabled"><!-- active -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 6</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> --
									<a href="#steb6" onclick="tab_active(6);" data-toggle="tab"  title="steb6" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">ข้อมูลการเลี้ยงโคนม</div> -->
<!-- 								</div> -->

<!--								<div id="tabtab7" class="col-xs-2 bs-wizard-step disabled"><!-- active -->
<!-- 									<div class="text-center bs-wizard-stepnum">ส่วนที่ 7</div> -->
<!-- 									<div class="progress"><div class="progress-bar"></div></div> 
									<a href="#steb7" onclick="tab_active(7);" data-toggle="tab"  title="steb7" class="bs-wizard-dot"></a>
<!-- 									<div class="bs-wizard-info text-center">ส่วนข้อมูล<br/>การเลี้ยงโคนม</div> -->
<!-- 								</div> -->
<?php //} ?>


<!-- 							</div> -->








							<?php /*

                    <ul class="nav nav-tabs" id="myTab">
                        <div class="liner"></div>
                        <li class="active">
                            <a href="#home" data-toggle="tab" title="welcome">
                                    <span class="round-tabs one">
                              <i class="glyphicon glyphicon-user"></i>
                      </span>
                            </a>
                        </li>

                        <li>
                            <a href="#profile" data-toggle="tab" title="profile">
                                    <span class="round-tabs two">
                         <i class="glyphicon glyphicon-lock"></i>
                     </span>
                            </a>
                        </li>
                        <li>
                            <a href="#messages" data-toggle="tab" title="bootsnipp goodies">
                                    <span class="round-tabs three">
                          <i class="glyphicon glyphicon-pencil"></i>
                     </span> </a>
                        </li>

                        <li>
                            <a href="#settings" data-toggle="tab" title="blah blah">
                                    <span class="round-tabs four">
                              <i class="glyphicon glyphicon-shopping-cart"></i>
                         </span>
                            </a>
                        </li>

                        <li>
                            <a href="#doner" data-toggle="tab" title="completed">
                                    <span class="round-tabs five">
                              <i class="glyphicon glyphicon-download-alt"></i>
                         </span> </a>
                        </li>

                    </ul>
*/ ?>


<!-- 						</div> -->


<?php ?>
						<?php
						$action_page = 'do_survey_add';
					///	if(isset($user_survey_data['citizen_id'])){ $action_page = 'do_survey_edit'; } ?>
						<form id="accountForm" method="post" action="<?php echo site_url('admin/'.$action_page); ?>" class="form-inline step-form-wrapper">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
							<div id="content_data_area"  class="row form-result">
								<div class="tab-content">
								
									<?php $tab_idxx=1;?>
									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; ?>">
										<?php include_once("survey/tab1_form_data.php"); $tab_idxx++; ?>
									</div>

									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; ?>">
										<?php include_once("survey/tab2_form_data.php"); $tab_idxx++; ?>
									</div>
									
									
									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; ?>">
										<?php include_once("survey/tab3_form_data.php"); $tab_idxx++; ?>
									</div>

									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; $tab_idxx++; ?>">
										<?php include_once("survey/tab4_form_data.php"); $tab_idxx++; ?>
									</div>
									
									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; $tab_idxx++; ?>">
										<?php   include_once("survey/tab5_form_data.php"); $tab_idxx++; ?>
									</div>

									<div class="tab-pane fade in active" id="steb<?php echo $tab_idxx; ?>">
										<?php  include_once("survey/tab6_form_data.php"); $tab_idxx++; ?>
									</div> 
									<div class="clearfix"></div>
								</div>


								<?php /*
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <br/><br/>
                        <button type="button" class="btn btn-primary" style="text-align: center; width: 100%; padding: 10px;margin-bottom:50px;">Next</button>
                            </div>
                    <div class="col-md-4"></div>
                </div>
*/ ?>
							</div>
						</form>



					</div>
				</div>
			</div>

		</section>
		<!--end  html -->
		
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css">


<script type="text/javascript">

$(function (){

	$('input').each(function ()
	{
			$(this).prop('disabled',true);
	});
	$('select').each(function ()
			{
					$(this).prop('disabled',true);
			});

	$('select').on('change',function(){
		$(this).prop('disabled',true);

		});
})

</script>

















		
	</div>
	<?php /*
	<button class="btn btn-info b10" type="submit" id="save-and-go-back-button">
          <i class="fa fa-"></i>เริ่มกรอกใหม่ตั้งแต่ต้น</button>
    <button class="btn btn-info b10" type="submit" id="save-and-go-back-button">
          <i class="fa fa-"></i>ย้อนกลับ</button>
	<button class="btn btn-info b10" type="submit" id="save-and-go-back-button">
          <i class="fa fa-"></i>ขั้นต่อไป</button>
 */ ?>
</div>

