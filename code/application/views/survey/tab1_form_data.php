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


<?php $intab_id =1; ?>
<h4 class="h_sub_title"> </h4>
<style>
	legend {
		display: block;
		margin-left: 3px;
		padding-top: 2px;
		text-shadow: 2px 2px 3px rgba(150, 150, 150, 0.75);
		font-family:Verdana, Geneva, sans-serif;
		font-size:1.3em;
	}
	fieldset{
		border:1px solid #c0c0c0 !important;
		margin-bottom:30px;
	}
    .disable
    {
    	display:none!important;
    }
	.input-no-spinner {
    -moz-appearance: textfield;
    }
    .input-no-spinner::-webkit-outer-spin-button,
    .input-no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }  
    .delrow{display:none}
    
    #nameprefix .select2.select2-container{width:150px!important}
    
    .form-control{padding-left:3px!important;padding-right:0px!important;font-size:13px;padding-top: 1px;padding-bottom: 1px;}
</style>

<h2 class="tab-title">ข้อมูลทั่วไป</h2>
<fieldset>
<legend class="h_sub_title">1. ข้อมูลสมาชิก</legend>

<?php /*
<label>เลขที่บัตรประจำตัวประชาชน</label>
<div class="form-inline">
    <div class="col-sm-9  col-lg-4 input-group "> <input  type="text" placeholder="รหัสบัตรประชาชน" name="code" id="idcard" maxlength="13" pattern="\d{13}" title="รหัสบัตรประชาชน 13 หลัก" class="form-control allownumericwithoutdecimal" >
        <input type="hidden" name="group_id" id="group_id" value="52"></div><div class="col-sm-2 col-lg-2 input-group "> <button type="submit" name="btn" value="save" class="btn btn-primary"><i class="fa fa-plus"></i> ค้นหา</button></div></div>

<br/><br/>
<br/><hr/><br/>
*/ ?>

		<script src="/assets/default/js/jquery-ui.js"></script>
		<link rel="stylesheet" href="/assets/default/css/select2/select2.min.css">
		<script src="/assets/default/js/select2/select2.full.min.js"></script>

<script>

$(function(){

		$("#family_status1").on('change',function(){
			$("#spouse").addClass('disable');
		});
		$("#family_status2").on('change',function(){
			$("#spouse").removeClass('disable');
		});
		$("#family_status3").on('change',function(){
			$("#spouse").addClass('disable');
		});
		$("#family_status4").on('change',function(){
			$("#spouse").addClass('disable');
		});
});


function formatRepo (serie) {
	if (serie.loading) return serie.name;
    var markup = '<div class="clearfix">' +
    '<div clas="col-sm-10">' +
    '<div class="clearfix">' +
    '<div class="col-xs-12">' + serie.name + '</div>' +
    '</div>';
    markup += '</div></div>';
    return markup;
}

function formatRepoSelection (serie) {
	return serie.name;
}

</script>


<?php 
    $temp_prefix = array("นาย"=>"นาย","นาง"=>"นาง","น.ส."=>"นางสาว","พล.ต.อ."=>"พลตำรวจเอก","พล.ต.อ.หญิง"=>"พลตำรวจเอก หญิง","พล.ต.ท"=>"พลตำรวจโท","พล.ต.ท หญิง"=>"พลตำรวจโท หญิง","พล.ต.ต"=>"พลตำรวจตรี","พล.ต.ต หญิง"=>"พลตำรวจตรี หญิง","พ.ต.อ."=>"พันตำรวจเอก","พ.ต.อ.หญิง"=>"พันตำรวจเอก หญิง","พ.ต.อ.(พิเศษ)"=>"พันตำรวจเอกพิเศษ","พ.ต.อ.(พิเศษ) หญิง"=>"พันตำรวจเอกพิเศษ หญิง","พ.ต.ท."=>"พันตำรวจโท","พ.ต.ท.หญิง"=>"พันตำรวจโท หญิง","พ.ต.ต."=>"พันตำรวจตรี","พ.ต.ต.หญิง"=>"พันตำรวจตรี หญิง","ร.ต.อ."=>"ร้อยตำรวจเอก","ร.ต.อ.หญิง"=>"ร้อยตำรวจเอก หญิง","ร.ต.ท."=>"ร้อยตำรวจโท","ร.ต.ท.หญิง"=>"ร้อยตำรวจโท หญิง","ร.ต.ต."=>"ร้อยตำรวจตรี","ร.ต.ต.หญิง"=>"ร้อยตำรวจตรี หญิง","ด.ต."=>"นายดาบตำรวจ","ด.ต.หญิง"=>"ดาบตำรวจหญิง","ส.ต.อ."=>"สิบตำรวจเอก","ส.ต.อ.หญิง"=>"สิบตำรวจเอก หญิง","ส.ต.ท."=>"สิบตำรวจโท","ส.ต.ท.หญิง"=>"สิบตำรวจโท หญิง","ส.ต.ต."=>"สิบตำรวจตรี","ส.ต.ต.หญิง"=>"สิบตำรวจตรี หญิง","จ.ส.ต."=>"จ่าสิบตำรวจ","จ.ส.ต.หญิง"=>"จ่าสิบตำรวจ หญิง","พลฯ"=>"พลตำรวจ","พลฯ หญิง"=>"พลตำรวจ หญิง","พล.อ."=>"พลเอก","พล.อ.หญิง"=>"พลเอก หญิง","พล.ท."=>"พลโท","พล.ท.หญิง"=>"พลโท หญิง","พล.ต."=>"พลตรี","พล.ต.หญิง"=>"พลตรี หญิง","พ.อ."=>"พันเอก","พ.อ.หญิง"=>"พันเอก หญิง","พ.อ.(พิเศษ)"=>"พันเอกพิเศษ","พ.อ.(พิเศษ) หญิง"=>"พันเอกพิเศษ หญิง","พ.ท."=>"พันโท","พ.ท.หญิง"=>"พันโท หญิง","พ.ต."=>"พันตรี","พ.ต.หญิง"=>"พันตรี หญิง","ร.อ."=>"ร้อยเอก","ร.อ.หญิง"=>"ร้อยเอก หญิง","ร.ท."=>"ร้อยโท","ร.ท.หญิง"=>"ร้อยโท หญิง","ร.ต."=>"ร้อยตรี","ร.ต.หญิง"=>"ร้อยตรี หญิง","ส.อ."=>"สิบเอก","ส.อ.หญิง"=>"สิบเอก หญิง","ส.ท."=>"สิบโท","ส.ท.หญิง"=>"สิบโท หญิง","ส.ต."=>"สิบตรี","ส.ต.หญิง"=>"สิบตรี หญิง","จ.ส.อ."=>"จ่าสิบเอก","จ.ส.อ.หญิง"=>"จ่าสิบเอก หญิง","จ.ส.ท."=>"จ่าสิบโท","จ.ส.ท.หญิง"=>"จ่าสิบโท หญิง","จ.ส.ต."=>"จ่าสิบตรี","จ.ส.ต.หญิง"=>"จ่าสิบตรี หญิง","พลฯ"=>"พลทหารบก","ว่าที่ พ.ต."=>"ว่าที่ พ.ต.","ว่าที่ พ.ต.หญิง"=>"ว่าที่ พ.ต.หญิง","ว่าที่ ร.อ."=>"ว่าที่ ร.อ.","ว่าที่ ร.อ.หญิง"=>"ว่าที่ ร.อ.หญิง","ว่าที่ ร.ท."=>"ว่าที่ ร.ท.", "ว่าที่ ร.ท.หญิง"=>"ว่าที่ ร.ท.หญิง","ว่าที่ ร.ต."=>"ว่าที่ ร.ต.","ว่าที่ ร.ต.หญิง"=>"ว่าที่ ร.ต.หญิง","พล.ร.อ."=>"พลเรือเอก","พล.ร.อ.หญิง"=>"พลเรือเอก หญิง","พล.ร.ท."=>"พลเรือโท","พล.ร.ท.หญิง"=>"พลเรือโท หญิง","พล.ร.ต."=>"พลเรือตรี","พล.ร.ต.หญิง"=>"พลเรือตรี หญิง","น.อ."=>"นาวาเอก","น.อ.หญิง"=>"นาวาเอก หญิง","น.อ.(พิเศษ)"=>"นาวาเอกพิเศษ","น.อ.(พิเศษ) หญิง"=>"นาวาเอกพิเศษ หญิง","น.ท."=>"นาวาโท","น.ท.หญิง"=>"นาวาโท หญิง","น.ต."=>"นาวาตรี","น.ต.หญิง"=>"นาวาตรี หญิง","ร.อ."=>"เรือเอก","ร.อ.หญิง"=>"เรือเอก หญิง","ร.ท."=>"เรือโท","ร.ท.หญิง"=>"เรือโท หญิง","ร.ต."=>"เรือตรี","ร.ต.หญิง"=>"เรือตรี หญิง","พ.จ.อ."=>"พันจ่าเอก","พ.จ.อ.หญิง"=>"พันจ่าเอก หญิง","พ.จ.ท."=>"พันจ่าโท","พ.จ.ท.หญิง"=>"พันจ่าโท หญิง","พ.จ.ต."=>"พันจ่าตรี","พ.จ.ต.หญิง"=>"พันจ่าตรี หญิง","จ.อ."=>"จ่าเอก","จ.อ.หญิง"=>"จ่าเอก หญิง","จ.ท."=>"จ่าโท","จ.ท.หญิง"=>"จ่าโท หญิง","จ.ต."=>"จ่าตรี","จ.ต.หญิง"=>"จ่าตรี หญิง","พลฯ"=>"พลทหารเรือ","พล.อ.อ."=>"พลอากาศเอก","พล.อ.อ.หญิง"=>"พลอากาศเอก หญิง","พล.อ.ท."=>"พลอากาศโท","พล.อ.ท.หญิง"=>"พลอากาศโท หญิง","พล.อ.ต."=>"พลอากาศตรี",               "พล.อ.ต.หญิง"=>"พลอากาศตรี หญิง","น.อ."=>"นาวาอากาศเอก","น.อ.หญิง"=>"นาวาอากาศเอก หญิง","น.อ.(พิเศษ)"=>"นาวาอากาศเอกพิเศษ","น.อ.(พิเศษ) หญิง"=>"นาวาอากาศเอกพิเศษ หญิง","น.ท."=>"นาวาอากาศโท","น.ท.หญิง"=>"นาวาอากาศโท หญิง","น.ต."=>"นาวาอากาศตรี","น.ต.หญิง"=>"นาวาอากาศตรี หญิง","ร.อ."=>"เรืออากาศเอก","ร.อ.หญิง"=>"เรืออากาศเอก หญิง","ร.ท."=>"เรืออากาศโท","ร.ท.หญิง"=>"เรืออากาศโท หญิง","ร.ต."=>"เรืออากาศตรี","ร.ต.หญิง"=>"เรืออากาศตรี หญิง","พ.อ.อ."=>"พันจ่าอากาศเอก","พ.อ.อ.หญิง"=>"พันจ่าอากาศเอก หญิง","พ.อ.ท."=>"พันจ่าอากาศโท","พ.อ.ท.หญิง"=>"พันจ่าอากาศโท หญิง","พ.อ.ต."=>"พันจ่าอากาศตรี","พ.อ.ต.หญิง"=>"พันจ่าอากาศตรี หญิง","จ.อ."=>"จ่าอากาศเอก","จ.อ.หญิง"=>"จ่าอากาศเอก หญิง","จ.ท."=>"จ่าอากาศโท","จ.ท.หญิง"=>"จ่าอากาศโท หญิง","จ.ต."=>"จ่าอากาศตรี","จ.ต.หญิง"=>"จ่าอากาศตรี หญิง","พลฯ"=>"พลทหารอากาศ","หม่อม"=>"หม่อม","ม.จ."=>"หม่อมเจ้า","ม.ร.ว."=>"หม่อมราชวงศ์","ม.ล."=>"หม่อมหลวง","ดร."=>"ดร.","ศ.ดร."=>"ศ.ดร.","ศ."=>"ศ.","ผศ.ดร."=>"ผศ.ดร.","ผศ."=>"ผศ.","รศ.ดร."=>"รศ.ดร.","รศ."=>"รศ.","นพ."=>"นพ.","พญ."=>"แพทย์หญิง","นสพ."=>"สัตวแพทย์","สพญ."=>"สพญ.","ทพ."=>"ทพ.","ทพญ."=>"ทพญ.","ภก."=>"เภสัชกร","ภกญ."=>"ภกญ.","พระ"=>"พระ","พระครู"=>"พระครู","พระมหา"=>"พระมหา","พระสมุห์"=>"พระสมุห์","พระอธิการ"=>"พระอธิการ","สามเณร"=>"สามเณร","แม่ชี"=>"แม่ชี", "บาทหลวง"=>"บาทหลวง");
?>


<div class="row mar_ned">
    <div class="col-md-12 col-xs-3">
<!--         <h4 align="left">ชื่อสมาชิก</h4> -->
    </div>
    <div class="col-md-12 col-xs-9">
        <div class="row fixed-row">
            <div id="nameprefix" class="col-md-8 col-xs-4 wdth form-group">
            
            	<?php if(isset($user_survey_data['citizen_id'])){?>
                <input type="hidden"  name="mode" id="mode" value="edit">
				<?php } ?>
            
            	<?php if (empty($user_survey_data) && isset($mahadthai[0])):?>
            		<?php 
            			$user_survey_data['NAME_TITLE'] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_PREFIX'] : "";
            		 	$user_survey_data['CITIZEN_PREFIX'] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_PREFIX'] : "";
            			$user_survey_data['citizen_firstname'] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_PNAME'] : "";
            			$user_survey_data['citizen_lastname'] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_SNAME'] : "";
            			$user_survey_data['citizen_id'] = isset($mahadthai[0]) ? $mahadthai[0]['IN_D_PIN'] : "";
            			$user_survey_data[strtoupper('house_no')] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_HNO'] : "";
            			$user_survey_data[strtoupper('village_no')] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_VNO'] : "";
            			$user_survey_data[strtoupper('citizen_address1')] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_ROAD'] : "";            			
            			$tmp = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_BDATE'] : "";            			
            			$date = strtotime($tmp);
            			$bdate = date("m-d", $date);
            			$byear = date("Y", $date);
            			$byear = $byear-543;
           				$bdate = $byear."-".$bdate;
            			$user_survey_data['citizen_birthdate'] = $bdate;    

            			$tmp = isset($mahadthai[0]) ? $mahadthai[0]['IN_D_MDATE'] : "";
            			$tmp2 = explode("/", $tmp);
            			$ldate = "";
            			if (count($tmp2)==3)
            			{
            				$tmp2[2] = $tmp2[2]-543; 
            				$ldate = implode("-",$tmp2); 
            			}
            			$user_survey_data['JOINING_DATE'] = $ldate;
            			
            			$user_survey_data[strtoupper('budget_year')] = isset($mahadthai[0]) ? $mahadthai[0]['IN_D_YEAR'] : "";
            			
            			$user_survey_data[strtoupper('cooperative_code')] = isset($coop) ? $coop['REGISTRY_NO_2'] : "";
            			$user_survey_data[strtoupper('farmer_group_name')] = isset($coop) ? $coop['REGISTRY_NO_2'] : "";
            			
            			$user_survey_data[strtoupper('province_code')] = isset($coop) ? $coop['PROVINCE_ID'] : "";
            			 
            			
            			
            			$user_survey_data[strtoupper('org_type')] = 1;
            			
            			
            			$user_survey_data[strtoupper('family_status')] = !empty($user_survey_data[strtoupper('family_status')]) ? $user_survey_data[strtoupper('family_status')] : "1";
            			
            			$user_survey_data[strtoupper('citizen_lane')] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_LANE'] : "";
            			$user_survey_data[strtoupper('citizen_road')] = isset($mahadthai[0]) ? $mahadthai[0]['OU_D_ROAD'] : "";
            		
            			?>
            		
            		<?php // $prefix = isset($mahadthai[0]) && isset($mahadthai[0]['OU_D_PREFIX'])? $mahadthai[0]['OU_D_PREFIX'] : "";?>
            		
            	<?php endif?>
             
             	
             	<?php $prefix = "";
                if(isset($user_survey_data[strtoupper('name_title')])){
                    $prefix =$user_survey_data[strtoupper('name_title')];
                }

                ?>            

			 	<?php 
			    $temp_prefix = array("นาย"=>"นาย","นาง"=>"นาง","น.ส."=>"นางสาว","พล.ต.อ."=>"พลตำรวจเอก","พล.ต.อ.หญิง"=>"พลตำรวจเอก หญิง","พล.ต.ท"=>"พลตำรวจโท","พล.ต.ท หญิง"=>"พลตำรวจโท หญิง","พล.ต.ต"=>"พลตำรวจตรี","พล.ต.ต หญิง"=>"พลตำรวจตรี หญิง","พ.ต.อ."=>"พันตำรวจเอก","พ.ต.อ.หญิง"=>"พันตำรวจเอก หญิง","พ.ต.อ.(พิเศษ)"=>"พันตำรวจเอกพิเศษ","พ.ต.อ.(พิเศษ) หญิง"=>"พันตำรวจเอกพิเศษ หญิง","พ.ต.ท."=>"พันตำรวจโท","พ.ต.ท.หญิง"=>"พันตำรวจโท หญิง","พ.ต.ต."=>"พันตำรวจตรี","พ.ต.ต.หญิง"=>"พันตำรวจตรี หญิง","ร.ต.อ."=>"ร้อยตำรวจเอก","ร.ต.อ.หญิง"=>"ร้อยตำรวจเอก หญิง","ร.ต.ท."=>"ร้อยตำรวจโท","ร.ต.ท.หญิง"=>"ร้อยตำรวจโท หญิง","ร.ต.ต."=>"ร้อยตำรวจตรี","ร.ต.ต.หญิง"=>"ร้อยตำรวจตรี หญิง","ด.ต."=>"นายดาบตำรวจ","ด.ต.หญิง"=>"ดาบตำรวจหญิง","ส.ต.อ."=>"สิบตำรวจเอก","ส.ต.อ.หญิง"=>"สิบตำรวจเอก หญิง","ส.ต.ท."=>"สิบตำรวจโท","ส.ต.ท.หญิง"=>"สิบตำรวจโท หญิง","ส.ต.ต."=>"สิบตำรวจตรี","ส.ต.ต.หญิง"=>"สิบตำรวจตรี หญิง","จ.ส.ต."=>"จ่าสิบตำรวจ","จ.ส.ต.หญิง"=>"จ่าสิบตำรวจ หญิง","พลฯ"=>"พลตำรวจ","พลฯ หญิง"=>"พลตำรวจ หญิง","พล.อ."=>"พลเอก","พล.อ.หญิง"=>"พลเอก หญิง","พล.ท."=>"พลโท","พล.ท.หญิง"=>"พลโท หญิง","พล.ต."=>"พลตรี","พล.ต.หญิง"=>"พลตรี หญิง","พ.อ."=>"พันเอก","พ.อ.หญิง"=>"พันเอก หญิง","พ.อ.(พิเศษ)"=>"พันเอกพิเศษ","พ.อ.(พิเศษ) หญิง"=>"พันเอกพิเศษ หญิง","พ.ท."=>"พันโท","พ.ท.หญิง"=>"พันโท หญิง","พ.ต."=>"พันตรี","พ.ต.หญิง"=>"พันตรี หญิง","ร.อ."=>"ร้อยเอก","ร.อ.หญิง"=>"ร้อยเอก หญิง","ร.ท."=>"ร้อยโท","ร.ท.หญิง"=>"ร้อยโท หญิง","ร.ต."=>"ร้อยตรี","ร.ต.หญิง"=>"ร้อยตรี หญิง","ส.อ."=>"สิบเอก","ส.อ.หญิง"=>"สิบเอก หญิง","ส.ท."=>"สิบโท","ส.ท.หญิง"=>"สิบโท หญิง","ส.ต."=>"สิบตรี","ส.ต.หญิง"=>"สิบตรี หญิง","จ.ส.อ."=>"จ่าสิบเอก","จ.ส.อ.หญิง"=>"จ่าสิบเอก หญิง","จ.ส.ท."=>"จ่าสิบโท","จ.ส.ท.หญิง"=>"จ่าสิบโท หญิง","จ.ส.ต."=>"จ่าสิบตรี","จ.ส.ต.หญิง"=>"จ่าสิบตรี หญิง","พลฯ"=>"พลทหารบก","ว่าที่ พ.ต."=>"ว่าที่ พ.ต.","ว่าที่ พ.ต.หญิง"=>"ว่าที่ พ.ต.หญิง","ว่าที่ ร.อ."=>"ว่าที่ ร.อ.","ว่าที่ ร.อ.หญิง"=>"ว่าที่ ร.อ.หญิง","ว่าที่ ร.ท."=>"ว่าที่ ร.ท.", "ว่าที่ ร.ท.หญิง"=>"ว่าที่ ร.ท.หญิง","ว่าที่ ร.ต."=>"ว่าที่ ร.ต.","ว่าที่ ร.ต.หญิง"=>"ว่าที่ ร.ต.หญิง","พล.ร.อ."=>"พลเรือเอก","พล.ร.อ.หญิง"=>"พลเรือเอก หญิง","พล.ร.ท."=>"พลเรือโท","พล.ร.ท.หญิง"=>"พลเรือโท หญิง","พล.ร.ต."=>"พลเรือตรี","พล.ร.ต.หญิง"=>"พลเรือตรี หญิง","น.อ."=>"นาวาเอก","น.อ.หญิง"=>"นาวาเอก หญิง","น.อ.(พิเศษ)"=>"นาวาเอกพิเศษ","น.อ.(พิเศษ) หญิง"=>"นาวาเอกพิเศษ หญิง","น.ท."=>"นาวาโท","น.ท.หญิง"=>"นาวาโท หญิง","น.ต."=>"นาวาตรี","น.ต.หญิง"=>"นาวาตรี หญิง","ร.อ."=>"เรือเอก","ร.อ.หญิง"=>"เรือเอก หญิง","ร.ท."=>"เรือโท","ร.ท.หญิง"=>"เรือโท หญิง","ร.ต."=>"เรือตรี","ร.ต.หญิง"=>"เรือตรี หญิง","พ.จ.อ."=>"พันจ่าเอก","พ.จ.อ.หญิง"=>"พันจ่าเอก หญิง","พ.จ.ท."=>"พันจ่าโท","พ.จ.ท.หญิง"=>"พันจ่าโท หญิง","พ.จ.ต."=>"พันจ่าตรี","พ.จ.ต.หญิง"=>"พันจ่าตรี หญิง","จ.อ."=>"จ่าเอก","จ.อ.หญิง"=>"จ่าเอก หญิง","จ.ท."=>"จ่าโท","จ.ท.หญิง"=>"จ่าโท หญิง","จ.ต."=>"จ่าตรี","จ.ต.หญิง"=>"จ่าตรี หญิง","พลฯ"=>"พลทหารเรือ","พล.อ.อ."=>"พลอากาศเอก","พล.อ.อ.หญิง"=>"พลอากาศเอก หญิง","พล.อ.ท."=>"พลอากาศโท","พล.อ.ท.หญิง"=>"พลอากาศโท หญิง","พล.อ.ต."=>"พลอากาศตรี",               "พล.อ.ต.หญิง"=>"พลอากาศตรี หญิง","น.อ."=>"นาวาอากาศเอก","น.อ.หญิง"=>"นาวาอากาศเอก หญิง","น.อ.(พิเศษ)"=>"นาวาอากาศเอกพิเศษ","น.อ.(พิเศษ) หญิง"=>"นาวาอากาศเอกพิเศษ หญิง","น.ท."=>"นาวาอากาศโท","น.ท.หญิง"=>"นาวาอากาศโท หญิง","น.ต."=>"นาวาอากาศตรี","น.ต.หญิง"=>"นาวาอากาศตรี หญิง","ร.อ."=>"เรืออากาศเอก","ร.อ.หญิง"=>"เรืออากาศเอก หญิง","ร.ท."=>"เรืออากาศโท","ร.ท.หญิง"=>"เรืออากาศโท หญิง","ร.ต."=>"เรืออากาศตรี","ร.ต.หญิง"=>"เรืออากาศตรี หญิง","พ.อ.อ."=>"พันจ่าอากาศเอก","พ.อ.อ.หญิง"=>"พันจ่าอากาศเอก หญิง","พ.อ.ท."=>"พันจ่าอากาศโท","พ.อ.ท.หญิง"=>"พันจ่าอากาศโท หญิง","พ.อ.ต."=>"พันจ่าอากาศตรี","พ.อ.ต.หญิง"=>"พันจ่าอากาศตรี หญิง","จ.อ."=>"จ่าอากาศเอก","จ.อ.หญิง"=>"จ่าอากาศเอก หญิง","จ.ท."=>"จ่าอากาศโท","จ.ท.หญิง"=>"จ่าอากาศโท หญิง","จ.ต."=>"จ่าอากาศตรี","จ.ต.หญิง"=>"จ่าอากาศตรี หญิง","พลฯ"=>"พลทหารอากาศ","หม่อม"=>"หม่อม","ม.จ."=>"หม่อมเจ้า","ม.ร.ว."=>"หม่อมราชวงศ์","ม.ล."=>"หม่อมหลวง","ดร."=>"ดร.","ศ.ดร."=>"ศ.ดร.","ศ."=>"ศ.","ผศ.ดร."=>"ผศ.ดร.","ผศ."=>"ผศ.","รศ.ดร."=>"รศ.ดร.","รศ."=>"รศ.","นพ."=>"นพ.","พญ."=>"แพทย์หญิง","นสพ."=>"สัตวแพทย์","สพญ."=>"สพญ.","ทพ."=>"ทพ.","ทพญ."=>"ทพญ.","ภก."=>"เภสัชกร","ภกญ."=>"ภกญ.","พระ"=>"พระ","พระครู"=>"พระครู","พระมหา"=>"พระมหา","พระสมุห์"=>"พระสมุห์","พระอธิการ"=>"พระอธิการ","สามเณร"=>"สามเณร","แม่ชี"=>"แม่ชี", "บาทหลวง"=>"บาทหลวง");
			    ?>
                  
             	<?php if (!empty($prefix)):?>
             	<label for="sort" class="col-md-3 control-label" style="width: 126px;padding-right: 0px;">ชื่อ-นามสกุล</label>
             	<?php echo !empty($temp_prefix[$prefix])?$temp_prefix[$prefix]:$prefix?>
             	<input type="hidden" name="name_title" value="<?php echo $prefix?>" />
             	<?php else:?>          	
				<label for="sort" class="col-md-3 control-label" style="width: 126px;padding-right: 0px;">ชื่อ-นามสกุล</label> 
             	<?php endif?>

				<?php if (isset($user_survey_data['citizen_firstname'])) :?>
					<?php echo $user_survey_data['citizen_firstname']?>
            		<input type="hidden" class="form-control" id="first_name"  name='first_name' placeholder="ชื่อ" required="" value="<?php if (isset($user_survey_data['citizen_firstname'])) echo $user_survey_data['citizen_firstname']?>">
            	<?php else:?>
					<input type="text" class="form-control" id="first_name"  name='first_name' placeholder="ชื่อ" required="" value="<?php if (isset($mahadthai[0]['OU_D_PNAME'])) echo $mahadthai[0]['OU_D_PNAME']?>" onkeypress="return isAlpha(event)">
				<?php endif?>
				
				<?php if (isset($user_survey_data['citizen_lastname'])) :?>
            		<?php echo $user_survey_data['citizen_lastname']?>
            		<input type="hidden" class="form-control" id="last_name" name="last_name" placeholder="นามสกุล" required=""  value="<?php if (isset($user_survey_data['citizen_lastname'])) echo $user_survey_data['citizen_lastname']?>">
	            <?php else:?>
            	<input type="text" class="form-control" id="last_name" name="last_name" placeholder="นามสกุล" required=""  value="<?php if (isset($mahadthai[0]['OU_D_SNAME'])) echo $mahadthai[0]['OU_D_SNAME']?>" onkeypress="return isAlpha(event)">
            	<?php endif?>
            </div> <!-- end -->
        </div>
    </div>
</div>




<div class="row mar_ned">

<!--     <div class="row"> -->

<!--         <div class="col-md-3 col-xs-4 wdth"> -->
<!--             <p align="left"><stong>เลขที่บัตรประจำตัวประชาชน</stong></p> -->
<!--         </div> -->
<!--         <div class="col-md-3 col-xs-4 wdth"> -->
<!--             <p align="left"><stong>รหัสครัวเรือน</stong></p> -->
<!--         </div> -->
<!--         <div class="col-md-2 col-xs-4 wdth"> -->
<!--             <p align="left"><stong>วันเดือนปีเกิด</stong></p> -->
<!--         </div> -->
<!--     </div> -->





    <div class="col-md-12 col-xs-12">
        <div class="row fixed-row">

            <div class="col-md-4 col-xs-4 wdth form-group">
<?php
//echo "<pre>"; 
//print_r($user_survey_data);
$idcard_is = "";
if(isset($_GET['citizen_id'])){
    $idcard_is =$_GET['citizen_id'];
}

$coop_id = "";
if(isset($_GET['coop'])){
	$coop_id =$_GET['coop'];
}


?>
            	<?php  if(isset($user_survey_data['citizen_id'])) {?>
            	
            		<div class="col-md-12 col-xs-12 wdth">
					<label>รหัสบัตรประชาชน</label>
					<?php echo $user_survey_data['citizen_id']?>
					</div>
                	<input type="hidden" style="width: 150px;"  max="13" maxlength="13" value="<?php
                    if(isset($user_survey_data['citizen_id'])){ echo $user_survey_data['citizen_id']; } ?>" class="form-control allownumericwithoutdecimal" id="idcard" name="idcard" placeholder="เลขบัตรประจำตัว 13 หลัก">
            
            	<?php } else if (isset($idcard_is)){ ?>
            	<div class="col-md-12 col-xs-12 wdth">
					<label>รหัสบัตรประชาชน</label>
					<?php echo $idcard_is?>
					<input type="hidden" style="width: 150px;"  max="13" maxlength="13" value="<?php
					if(isset($idcard_is)){ echo $idcard_is; } ?>" class="form-control allownumericwithoutdecimal" id="idcard" name="idcard" placeholder="เลขบัตรประจำตัว 13 หลัก">
					</div>
            	<?php } else {?>
            	<label  class="required">รหัสบัตรประชาชน</label>
                	<input type="number" style="width: 150px;"  max="13" maxlength="13" value="<?php if(isset($idcard_is)){ echo $idcard_is; } ?>" class="form-control allownumericwithoutdecimal" id="idcard" name="idcard" placeholder="เลขบัตรประจำตัว 13 หลัก" >
            	
            	<?php }?>
            
            </div>
<!--             <div class="col-md-4 col-xs-3 wdth form-group"> -->
<!--             <label  class="required">รหัสครัวเรือน</label> 
               <input type="number" style="width: 150px;" class="form-control" id="household_code" name="household_code" placeholder="" value="<?php //if(isset($user_survey_data[strtoupper('household_code')])){ echo $user_survey_data[strtoupper('household_code')]; } ?>" >
<!--             </div> -->
            <div class="col-md-4 col-xs-3 wdth form-group">
             	
             	
				<?php  
				
				
						$temp_type = 'text';  
						$temp_field = 'citizen_birthdate'; 
						$bdate = "";
						$bdate_year = "";						
						if(isset($user_survey_data[$temp_field]))
						{  
							$date = strtotime($user_survey_data[$temp_field]);
							$bdate = date("d-m-", $date);							
							$bdate_year=date('Y',$date)+543;							
							$temp_type = 'hidden'; 				
						}?>
				
					<?php if(isset($user_survey_data[$temp_field])):?>

						<div class="col-md-12 col-xs-12 wdth fixed-row">
						<label>วันเดือนปีเกิด</label>
						<?php echo $bdate.$bdate_year;?>
		                <input type="<?php echo $temp_type; ?>" class="form-control " id="thebirthdate" name="thebirthdate" data-date-language="th" data-provide="datepicker" placeholder="" style="width: 150px;" value="<?php if (isset($user_survey_data[$temp_field])){
		                    $date = strtotime($user_survey_data[$temp_field]);
		                    $bdate = date("d-m-Y", $date);
		                    echo $bdate; } ?>" >	
						</div>
				
					<?php else:?>
						
						<label  class="required">วันเดือนปีเกิด</label>
		                <input type="<?php echo $temp_type; ?>" class="form-control " id="thebirthdate" name="thebirthdate" data-date-language="th" data-provide="datepicker" placeholder="" style="width: 150px;" value="<?php if (isset($user_survey_data[$temp_field])){
		                    $date = strtotime($user_survey_data[$temp_field]);
		                    $bdate = date("d-m-Y", $date);
		                    echo $bdate; } ?>"
		                    
		                    onkeypress="return isDate(event)"
			                    
		                    >

                    <?php endif?>
            </div>
        </div>
    </div>



</div>


<div class="row mar_ned personal-form">

    <div class="row">
    <div class="col-md-12 col-xs-9">
        <div class="row">

            <div class="col-md-12 col-xs-4 wdth">
                <div class="row">
                	<div class="col-md-4 col-xs-12" style="margin-left: -15px; padding-right: 0;">
                        <label class="required first-feild">สถานะภาพ</label>
                        <select style="text-align: center!important;" class="form-control" name="family_status" id="status">
                        	<option <?php if (!empty($user_survey_data[strtoupper('family_status')]) && $user_survey_data[strtoupper('family_status')]==1) echo 'selected=selected'?> value="1">โสด</option>
                        	<option <?php if (!empty($user_survey_data[strtoupper('family_status')]) && $user_survey_data[strtoupper('family_status')]==2) echo 'selected=selected'?> value="2">สมรส</option>
                        	<option <?php if (!empty($user_survey_data[strtoupper('family_status')]) && $user_survey_data[strtoupper('family_status')]==3) echo 'selected=selected'?> value="3">หม้าย/หย่าร่าง</option>
                        	<option <?php if (!empty($user_survey_data[strtoupper('family_status')]) && $user_survey_data[strtoupper('family_status')]==4) echo 'selected=selected'?> value="4">อื่นๆ</option>
                        </select>
                    </div>
					<?php 
					if(empty($user_survey_data[strtoupper('family_status')]))
					{
						$user_survey_data[strtoupper('family_status')] =0;
					}
		
					?>
					<div class="col-md-4 col-xs-12 form-group status_spouse <?php if ($user_survey_data[strtoupper('family_status')]!=2) echo 'display'?>" >
						<label  class="required secondary-feild"> ชื่อคู่สมรส        	</label>
				        <input id="family_name" name="family_name" type="text" style="width: 150px" class="form-control" value ="<?php if(isset($user_survey_data[strtoupper('family_name')])){ echo $user_survey_data[strtoupper('family_name')]; } ?>"/>
					</div>
					<div style="padding-right: 0;padding-left: 0;" class="col-md-4 col-xs-12 form-group status_spouse <?php if ($user_survey_data[strtoupper('family_status')]!=2) echo 'display'?>" >
						<label   class="required" style="width: 130px;">รหัสบัตรประชาชน </label>
				        <input id="family_citizen_id" name="family_citizen_id" type="text" style="width: 150px" maxlength="13" class="form-control" value ="<?php if(isset($user_survey_data[strtoupper('family_citizen_id')])){ echo $user_survey_data[strtoupper('family_citizen_id')]; } ?>" onkeypress="return isNumber(event)"/>
					</div>
                    <div class="col-md-4 col-xs-6 form-group other-choise spouse_other <?php if ($user_survey_data[strtoupper('family_status')]!=4) echo 'display'?>">
                            <input  type="text" class="form-control" id="family_status_others" name="family_status_others" placeholder="อื่นๆ"   value="<?php if(isset($user_survey_data[strtoupper('family_status_others')])){ echo $user_survey_data[strtoupper('family_status_others')]; } ?>"  >                        
                    </div>


                </div>
            </div>

        </div>
    </div>

</div>
<style>
.display
{
	display: none!important;
}
.row
{
	margin-top: 7px;
}

</style>
<script type="text/javascript">
	$(document).ready(function (){
			$('#status').on('change',function(){
				console.log($(this).val());
				var display_status = $(this).val();

				if(display_status === '2')
				{
					console.log($(this).val());
					$('.status_spouse').removeClass('display');
					$('.spouse_other').addClass('display');
				}
				else if(display_status === '4')
				{
					console.log($(this).val());
					$('.spouse_other').removeClass('display');
					$('.status_spouse').addClass('display');
				}
				else
				{
					$('.spouse_other').addClass('display');
					$('.status_spouse').addClass('display');
				}
			});
		});
</script>



<div class="row mar_ned personal-form">
		<div class="col-md-12 col-xs-9">
		<div class="row">

			<div class="col-md-8 col-xs-4 wdth form-group">
				<label  class="required first-feild">ระดับการศึกษา</label>
				<select id="education" class="form-control" name="education_code">
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==8){ echo "selected=selected"; } ?> value="8">ไม่ได้ศึกษา</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==7){ echo "selected=selected"; } ?> value="7">ประถมศึกษา</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==6){ echo "selected=selected"; } ?>value="6">มัธยมศึกษาตอนต้น</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==5){ echo "selected=selected"; } ?> value="5">มัธยมศึกษาตอนปลาย</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==4){ echo "selected=selected"; } ?> value="4">ปวช</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==3){ echo "selected=selected"; } ?> value="3">อนุปริญญา/ปวส</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==2){ echo "selected=selected"; } ?> value="2">ปริญญาตรี</option>
					<option <?php if(isset($user_survey_data[strtoupper('education_code')]) && $user_survey_data[strtoupper('education_code')]==1){ echo "selected=selected"; } ?> value="1">สูงกว่าปริญญาตรี</option>
				</select>
			</div>
		</div>
		</div>
	</div>


<div class="row mar_ned personal-form" style="margin-bottom: 0;">

        <div class="col-md-12 col-xs-9">
            <div class="row">

                <div class="col-sm-3 col-xs-4 wdth">
					<label class="form-group required first-feild">บ้านเลขที่  </label>
                    <input style="width:76px;" type="text" class="form-control" id="house_no" name="house_no" placeholder="" value="<?php if(isset($user_survey_data[strtoupper('house_no')])){ echo $user_survey_data[strtoupper('house_no')]; } ?>" onkeypress="return isAlphaNumeric(event)">
                </div>
                <div class="col-sm-2 col-xs-4 wdth">
                	<label class="form-group">หมู่ที่  </label>
                    <input style="width:75px" type="number" class="form-control" id="village_no" name="village_no" placeholder="" value="<?php if(isset($user_survey_data[strtoupper('village_no')])){ echo $user_survey_data[strtoupper('village_no')]; } ?>" onkeypress="return isAlphaNumeric(event)">
                </div>
                
  
                <div class="col-sm-3 col-xs-4 wdth">
					<label class="form-group ">ซอย </label>
                    <input style="width: 150px" type="text" class="form-control" id="lane" name="lane" placeholder="" value="<?php if(isset($user_survey_data[strtoupper('CITIZEN_LANE')])){ echo $user_survey_data[strtoupper('CITIZEN_LANE')]; } ?>" onkeypress="return isAlphaNumeric(event)">
                </div>
                <div class="col-sm-4 col-xs-4 wdth">
                    <?php /*
                    <input type="text" class="form-control" id="adr" name="adr" placeholder="" value="<?php if (isset($mahadthai[0]) && isset($mahadthai[0]['OU_D_ALLEY'])) echo $mahadthai[0]['OU_D_ALLEY']?> <?php if (isset($mahadthai[0]['OU_D_LANE'])) echo $mahadthai[0]['OU_D_LANE']?> <?php if (isset($mahadthai[0]['OU_D_ROAD'])) echo $mahadthai[0]['OU_D_ROAD']?>">
                       */ ?>
					<label class="form-group">ถนน </label>
                    <input style="width: 228px;" type="text" class="form-control" id="road" name="road" placeholder="" value="<?php if(isset($user_survey_data['CITIZEN_ROAD'])){ echo $user_survey_data['CITIZEN_ROAD']; } ?>" onkeypress="return isAlphaNumeric(event)">

                </div>
            </div>            
        </div>

    </div>
</div>





<div class="row mar_ned personal-form">
    <div class="col-md-12 col-xs-9">
        <div class="row" id="adress" style="vertical-align: middle;">
            <div class="col-sm-6 col-xs-6 wdth" id="province">
            
            	<?php $province = isset($mahadthai[0]) && isset($mahadthai[0]['PROVICE_NAME'])? $mahadthai[0]['PROVICE_NAME'] : "";?>
             	<?php $province_obj = getProvinceByName($province);?>
             	<?php $province_id = is_object($province_obj) ? $province_obj->PROVINCE_ID : ""?>
             	<?php $province_code = is_object($province_obj) ? $province_obj->PROVINCE_CODE : ""?>
				<label class="form-group required first-feild"">จังหวัด </label>
             	<select class="form-control" id="province_id" name="province_id" >
                    <option value="">==กรุณาเลือก==</option>
                    <?php
                    $all_prov = count(count($data_getAllprovinces));
                    $province_selected = false;
                    for($i=0;$i<=count($data_getAllprovinces);$i++){
                        if(!empty($data_getAllprovinces[$i]->PROVINCE_NAME)) {
                            if(trim($data_getAllprovinces[$i]->PROVINCE_NAME!='')){
                            	
                            	$selected = "";
                            	if (trim($province)==trim($data_getAllprovinces[$i]->PROVINCE_NAME)) 
                            	{
                            		$selected = " selected='selected' ";
                            		$province_selected = true;
                            	}
                            		
                            	echo ' <option '.$selected.' value="' . $data_getAllprovinces[$i]->PROVINCE_ID . '">' . trim($data_getAllprovinces[$i]->PROVINCE_NAME) . '</option>';
                       	 	}
                        }
                    }?>

                </select>
                <input type="hidden"   id="province_name" name="province_name"  >
            </div>
            <div class="col-sm-6 col-xs-6 wdth" style="padding-left: 43px;">
				<label class="form-group required first-feild">รหัสไปรษณีย์ </label>
                <input type="text"  maxlength="5"  class="form-control allownumericwithoutdecimal" id="postal_code" name="postal_code" placeholder="รหัสไปรษณีย์ " value="<?php if(isset($user_survey_data['citizen_zipcode'])){ echo $user_survey_data['citizen_zipcode']; } ?>" onkeypress="return isPostalCode(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false">
            </div>
		</div>
	</div>
</div>
<div class="row mar_ned personal-form">
    <div class="col-md-12 col-xs-9">
		<div class="row" id="adress" style="vertical-align: middle;">
            <div class="col-sm-6 col-xs-4 wdth" id="district" >
            	
                	<?php $current_amphor = isset($mahadthai[0]) && isset($mahadthai[0]['OU_D_DISTRICT'])? $mahadthai[0]['OU_D_DISTRICT'] : "";?>           		
             		<?php if ($province=="กรุงเทพมหานคร") :?>
             			<?php $current_amphor = str_replace("เขต","", $current_amphor);?>
             			<?php $current_amphor = str_replace("อ.","", $current_amphor);?>    
             		<?php else:?>
             			<?php $current_amphor = str_replace("อ.","", $current_amphor);?>           	
                	<?php endif?>
                	<?php 
                	
                		$amphurs = getAmphurByProvince2($province_id) ;
                		$amphur_selected = false;
                	
                	?>
 
                	<?php $current_amphor_arr = getAmphurByProvinceIDAmphurName($province_id, $current_amphor)?>   
                	<?php $current_amphur_ID = !empty($current_amphor_arr) ? $current_amphor_arr['amphor_id']:""?>
                	<?php $current_amphur_code = !empty($current_amphor_arr) ? $current_amphor_arr['amphor_code']:""?>
                	
            <label class="form-group required first-feild">เขต/อำเภอ </label>
                <select class="form-control" id="district_id" name="district_id" <?php if (!$province_selected):?>disabled<?php endif?> >
                	
                	<option value="">==กรุณาเลือก==</option>
                
                	<?php foreach ($amphurs as $amphur):?>

                		<?php if ($province=="กรุงเทพมหานคร") :?>
	             			<?php $amphur['amphor_name'] = str_replace("เขต","", $amphur['amphor_name']);?>
	             			<?php $amphur['amphor_name'] = str_replace("อ.","", $amphur['amphor_name']);?>    
	             		<?php else:?>
	             			<?php $amphur['amphor_name'] = str_replace("อ.","", $amphur['amphor_name']);?>           	
	                	<?php endif?>
	                	
                		<?php 
                			$selected = $amphur['amphor_name']==$current_amphor? " selected='selected' ": "";
                			if (!empty($selected)) $amphur_selected=true;
                		?>
                		
                		<option  <?php echo $selected?> value="<?php echo $amphur['amphor_id']?>"><?php echo $amphur['amphor_name']?></option>
                			
                	<?php endforeach?>                	

                
                </select>
                <input type="hidden"   id="district_name" name="district_name"   >
            </div>

            <div class="col-sm-6 col-xs-4 wdth" id="sub_district" style="padding-left: 43px;">
            
            		<?php $current_tambol_str = isset($mahadthai[0]) && isset($mahadthai[0]['OU_D_SUBD'])? $mahadthai[0]['OU_D_SUBD'] : "";?>
             		<?php $current_tambol_str = str_replace("ต.","", $current_tambol_str);?>
             		<?php $current_tambol = getTambolByAmphurIDTambolName($current_amphur_ID, $current_tambol_str) ?>
             		<?php $current_tambol_code = !empty($current_tambol)? $current_tambol['tambol_code'] : ""; ?>
             		<?php $current_tambol_id = !empty($current_tambol)? $current_tambol['tambol_id'] : ""; ?>
                	<?php $tambols = getTambolByAmphur($current_amphur_ID) ?>
                	                	
            	<label class="form-group thrid-feild">แขวง/ตำบล </label>
                <select class="form-control" id="sub_district_id" name="sub_district_id" <?php if (!$amphur_selected):?>disabled<?php endif?> >
                    <option value="">==กรุณาเลือก==</option>
                    
                    <?php $district_selected = false;?>
                	<?php foreach ($tambols as $tambol):?>
                	
                		<?php 
                			$selected = $tambol['tambol_name']==$current_tambol_str? " selected='selected' ": "";
                			if (!empty($selected)) $district_selected = true;	
                		?>
                		
                		<option  <?php echo $selected?> value="<?php echo $tambol['tambol_id']?>"><?php echo $tambol['tambol_name']?></option>
                			
                	<?php endforeach?>                	
                    

                </select>
                <input type="hidden"   id="sub_district_name" name="sub_district_name"  >
            </div>
        
        </div>
    </div>


</div>




<div class="row mar_ned personal-form">

    <div class="row">

<!--         <div class="col-md-4 col-xs-4 wdth"> -->
<!--             <p align="left"><stong>รหัสไปรษณีย์</stong></p> -->
<!--         </div> -->
<!--         <div class="col-md-4 col-xs-4 wdth"> -->
<!--             <p align="left"><stong>เบอร์โทรศัพท์บ้าน</stong></p> -->
<!--         </div> -->
<!--         <div class="col-md-4 col-xs-4 wdth"> -->
<!--             <p align="left"><stong>เบอร์มือถือ</stong></p> -->
<!--         </div> -->
        
    </div>


    <div class="col-md-12 col-xs-9">
        <div class="row">

            <div class="col-md-4 col-xs-4 wdth">
            <label class="form-group first-feild">เบอร์โทรศัพท์บ้าน </label>
                <input style="width: 150px" type="text" class="form-control" id="home_phone_no" name="home_phone_no" placeholder="ตัวอย่าง 022225555" maxlength="10" value="<?php if(isset($user_survey_data[strtoupper('home_phone_no')])){ echo $user_survey_data[strtoupper('home_phone_no')]; } ?>"  onkeypress="return isHomePhoneNumber(event)">
            </div>
            <div class="col-md-4 col-xs-4 wdth">
            	<label class="form-group secondary-feild">เบอร์มือถือ </label>
                <input style="width: 172px" type="text" class="form-control" id="cell_phone" name="cell_phone" placeholder="ตัวอย่าง 0955558888" maxlength="10"  value="<?php if(isset($user_survey_data[strtoupper('cell_phone')])){ echo $user_survey_data[strtoupper('cell_phone')]; } ?>"  onkeypress="return isPhoneNumber(event)">
            </div>
            <div class="row">
	        	<div class="col-md-4 col-xs-4 wdth">
	        		<label class="form-group thrid-feild">อีเมล </label>
	                <input type="text" class="form-control" id="email" name="email" placeholder=""  value="<?php if(isset($user_survey_data[strtoupper('cell_email')])){ echo $user_survey_data[strtoupper('cell_email')]; } ?>">
	            </div>
			</div>
        </div>
    </div>

	<div class="row mar_ned">

<!-- 		<div class="row"> -->

<!-- 			<div class="col-md-3 col-xs-4 wdth"> -->
<!-- 				<p align="left"><stong>รายได้ต่อปี </stong></p> -->
<!-- 			</div> -->
<!-- 			<div class="col-md-3 col-xs-4 wdth"> -->
<!-- 				<p align="left"><stong>แยกเป็นภาคเกษตร</stong></p> -->
<!-- 			</div> -->
<!-- 			<div class="col-md-3 col-xs-4 wdth"> -->
<!-- 				<p align="left"><stong>นอกภาคเกษตร</stong></p> -->
<!-- 			</div> -->
<!-- 			<div class="col-md-3 col-xs-4 wdth"> -->

<!-- 			</div> -->
<!-- 		</div> -->

	</div>




	<div class="row mar_ned personal-form">

		<div class="col-md-12 col-xs-12 wdth">
		
		<div class="row">

			<div class="col-md-4 col-xs-4 wdth">
				<label class="form-group first-feild">รายได้ต่อปี  </label>
					<input    type="text" class="form-control allownumericwithdecimal" id="year_income" name="year_income" placeholder="บาท"   value="<?php if(isset($user_survey_data[strtoupper('year_income')])){ echo trimleft($user_survey_data[strtoupper('year_income')],'0'); } ?>"  onkeypress="return isDecimal(event)" autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false">
				
			</div>
 			<div class="col-md-4 col-xs-4 wdth">
 				<label class="form-group secondary-feild">ภาคเกษตร </label>
					<input style="width: 172px" type="text" class="form-control allownumericwithdecimal" id="agriculture_income" name="agriculture_income" placeholder="บาท"   value="<?php if(isset($user_survey_data[strtoupper('agriculture_income')])){ echo trimleft($user_survey_data[strtoupper('agriculture_income')],'0'); } ?>"  onkeypress="return isDecimal(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false">
				
 			</div>
			<div class="col-md-4 col-xs-4 wdth">
 				<label class="form-group thrid-feild">นอกภาคเกษตร </label> 
					<input    type="text" class="form-control allownumericwithdecimal" id="out_agriculture_income" name="out_agriculture_income" placeholder="บาท"   value="<?php if(isset($user_survey_data[strtoupper('out_agriculture_income')])){ echo trimleft($user_survey_data[strtoupper('out_agriculture_income')],'0'); } ?>" onkeypress="return isDecimal(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false">
				
			</div>
			<div class="col-md-3 col-xs-4 wdth">

			</div>
		</div>
		
		</div>

	</div>

</div>

</fieldset>



<fieldset>
	<legend class="h_sub_title">2. สังกัด</legend>
	<div class="row mar_ned">
	
	
		<!--    start 0 ROW in สังกัด --------------------------------------> 
		
		<div class="col-md-12 col-xs-9" style="margin-bottom: 16px;">
	        <div class="row" style="float: right;">	        
        		<?php 
            		$survey_code = isset($user_survey_data['SURVEY_CODE']) ? $user_survey_data['SURVEY_CODE']: getSelectedSurveyYear()+543;
            		?>
        
           		<label class="form-group" style="margin-top: 5px;">รหัสแบบสำรวจ</label>
           		<input style="width: 100px" type="text"  class="form-control" value="<?php echo $survey_code ?>" disabled="disabled">
            	
            	
         		<input type="hidden" class="form-control" id="survey_code" name="survey_code" placeholder="" value="<?php echo $survey_code ?>" >
	        </div>
		</div>
		
<!--    END 0 ROW in สังกัด --------------------------------------> 
		
		
<!--    start FIRST ROW in สังกัด --------------------------------------> 
		
		
	    <div class="col-md-12 col-xs-9 ">
	  			<div class="row">
					<div class="col-md-4 col-xs-4 wdth form-group display-right" >
					
						<?php if (!empty($user_survey_data[strtoupper('province_code')])):?>
							
							<label class="form-group required">จังหวัด  </label>
							<?php $all_provinces = getAllProvinces();?>
							<?php foreach ($all_provinces as $province):?>
								<?php if (isset($user_survey_data[strtoupper('province_code')]) && $province->PROVINCE_ID==$user_survey_data[strtoupper('province_code')])
								{
									echo $province->PROVINCE_NAME;
								}
								?>
							<?php endforeach?>
							<input  id="province_code_hidden" type="hidden" value="<?php if (isset($user_survey_data[strtoupper('province_code')])) echo $user_survey_data[strtoupper('province_code')]?>"">
							<input type="hidden" class="form-control" id="province_code" name="province_code" placeholder=""  value="<?php if (isset($user_survey_data[strtoupper('province_code')])) echo $user_survey_data[strtoupper('province_code')]?>" >
						
						<?php else:?>
							
							<?php $all_provinces = getAllProvinces();?>
							<label class="form-group required">จังหวัด </label>
							<input  id="province_code_hidden" type="hidden" value="<?php !empty($user_survey_data[strtoupper('province_code')])?$user_survey_data[strtoupper('province_code')]:""?>">
							<select id="province_code" name="province_code">
								<?php foreach ($all_provinces as $province):?>
									<?php $selected = isset($user_survey_data[strtoupper('province_code')]) && $province->PROVINCE_ID==$user_survey_data[strtoupper('province_code')] ? " selected=\"selected\" " : "";?>
									<option value="<?php echo $province->PROVINCE_ID?>" <?php echo $selected?> ><?php echo $province->PROVINCE_NAME?></option>
								<?php endforeach?>
							</select>
							<script>
							$('#province_code').each(function( index ) {
								$(this).select2({
									  placeholder: "เลือกจังหวัด"
									});
							});
							</script>
							
			        	<?php endif?>
		        	</div>
		        
		        	<?php 
	            		$id= isset($user_survey_data[strtoupper('COOP_ID')]) ? $user_survey_data[strtoupper('COOP_ID')]: "";
	            		$temp = getCoopByID($id);
	            		$coop_name = isset($coop['COOP_NAME_TH'])? $coop['COOP_NAME_TH']: "";
	            	?>
	            	
	            	
	 				
					<div class="col-md-4 col-xs-4 wdth " id="budget_year_div" style="padding-left:0px">
	            	 
		                <label class="form-group required secondary-feild">ปีงบประมาณ</label>
		                <?php if (isset($user_survey_data[strtoupper('budget_year')])) echo $user_survey_data[strtoupper('budget_year')]+543?>
		                
		                <?php if(isset($user_survey_data[strtoupper('budget_year')]) && $user_survey_data[strtoupper('budget_year')]!=''): ?>
			                
			                <input style="width: 100px" maxlength="4" type="<?php if (isset($user_survey_data[strtoupper('budget_year')])){ if($user_survey_data[strtoupper('budget_year')]!=''){   echo 'hidden'; }else{ echo 'text';  } }else{ echo 'text'; } ?>" class="form-control allownumericwithoutdecimal" id="budget_year" name="budget_year" placeholder="" value="<?php if (isset($user_survey_data[strtoupper('budget_year')])) echo $user_survey_data[strtoupper('budget_year')]?>"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false" >
						
						<?php else:?>
							
							<?php $default = getDefaultBudgetYear();
							?>
							<?php $all_years = getAllBudgetYears();?>
							<select id="budget_year" name="budget_year">
								<?php foreach ($all_years as $v):?>
								<option value="<?php echo $v?>"  <?php if ($default==$v) echo "selected=selected" ?> ><?php echo $v+543?></option>
								<?php endforeach?>
							</select>			
							<script>
							$('#budget_year').each(function( index ) {
								$(this).select2({
									  placeholder: "ปีงบประมาณ"
									});
							});
							</script>						
						<?php endif?>
	            	</div> 		 				
	 				
	 				
	 			</div>
	 	
				<!--    END FIST ROW in สังกัด --------------------------------------> 
	 	
	 	
	 			<!--    START SECOND ROW in สังกัด --------------------------------------> 
	 	
	 	
	 			<div class="row">
	    			<div class="col-md-12 col-xs-9 fixed-row">
	    				<div class="row">

		            	<?php 
		            		$id= isset($user_survey_data[strtoupper('COOP_ID')]) ? $user_survey_data[strtoupper('COOP_ID')]: "";           		
		            		$id = !is_numeric($id) ? $coop_id : $id;
		            		$temp = getCoopByID($id);
		            		$coop_name = isset($temp['COOP_NAME_TH'])? $temp['COOP_NAME_TH']: "";
		
		            	?>
	
	            		<?php if (!empty($coop_name)):?>
	            		
	
	            		
	            		<?php else:?>
	            			<div class="col-md-4 col-xs-4 wdth " id="coop_name_div">
	            				<input id="coop_id" type="hidden" name="coop_id" value="" />
	            				<label class="form-group required ">ชื่อสหกรณ์  </label>
				            	<select id="coop_name" name="coop_name" onfocus="$('#org_type1').attr('checked', 'checked');" onclick="$('#org_type1').attr('checked', 'checked');" >
									<option value="<?php if(isset($user_survey_data[strtoupper('farmer_group_name')])){ if(isset($user_survey_data[strtoupper('org_type')])){ if($user_survey_data[strtoupper('org_type')]==1){ echo $user_survey_data[strtoupper('farmer_group_name')]; }} } ?>" selected="selected"><?php if(isset($user_survey_data[strtoupper('farmer_group_name')])){ if(isset($user_survey_data[strtoupper('org_type')])){ if($user_survey_data[strtoupper('org_type')]==1){ echo $coop_name; }} } ?></option>
								</select>
						
								<script>
				 					var province_code;
									$(document).ready(function()
									{
										province_code = $('#province_code').val();
										var province_code_hidden = $('#province_code_hidden').val();
										if(typeof province_code_hidden =='undefined')
										{
											$('#province_code_hidden').val($('#province_code').val());
										}
				
										$('#coop_name').on('change',function(){
											console.log('coop name');
											console.log($(this).val());
											$('#coop_type_name').html('รหัสสหกรณ์');
											$('#coop_id').val($(this).val());
										});
				
										$('#farmer_group_name').on('change',function(){
											console.log('farmer_group_name');
											console.log($(this).val());
											$('#coop_type_name').html('รหัสสหกรณ์');
											$('#coop_id').val($(this).val());
										});
				
										$('#province_code').on('change',function(){
											province_code = $(this).val();
											$('#province_code_hidden').val($(this).val());
										});
									});
									$('#coop_name').select2({
										
							    		ajax: {
							    			placeholder: "เลือกสหกรณ์",
							    		    url: '<?php echo site_url('report2/ajax_coop_all')?>?',
							    		    dataType: 'json',
							    		    data: function (params) {
								    		    console.log(params);
							    		      return {
												//keyword: params.term, // search term
							    		        page: params.page,
							    		        province :province_code
							    		      };
							    		    },
							    		    processResults: function (data, params) {
							    		      // parse the results into the format expected by Select2
							    		      // since we are using custom formatting functions we do not need to
							    		      // alter the remote JSON data, except to indicate that infinite
							    		      // scrolling can be used
							    		      params.page = data.page || 1;
							    		      console.log( data.page);
							    		      console.log(data);
							    		  		
							    		      return {
							    		        results: data.items,
							    		        pagination: {
							    		          more: (params.page * 10) < data.total_count
							    		        }
							    		      };
							    		    },
							    		    cache: true
							    		  },
							    	      /* below part is rendered by jsp so that it has the value from previous form submission; if it is initial form render the below part is not included */
							    	     
							    	      width: '150px',
							    		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
							    		  templateResult: formatRepo, // omitted for brevity, see the source of this page
							    		  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
							    	});
								</script>
						
	           			 	</div>
						<?php endif?>
 
						<script type="text/javascript">
						
							$('#farmer_group_name').select2({
								
					    		ajax: {
					    			placeholder: "เลือกสหกรณ์",
					    		    url: '<?php echo site_url('report2/ajax_coop_all')?>',
					    		    dataType: 'json',
					    		    data: function (params) {
						    		    console.log(params);
					    		      return {
			//			    		        keyword: params.term, // search term
					    		        page: params.page
					    		      };
					    		    },
					    		    processResults: function (data, params) {
					    		      // parse the results into the format expected by Select2
					    		      // since we are using custom formatting functions we do not need to
					    		      // alter the remote JSON data, except to indicate that infinite
					    		      // scrolling can be used
					    		      params.page = data.page || 1;
					    		      console.log( data.page);
					    		      console.log(data);
					    		      return {
					    		        results: data.items,
					    		        pagination: {
					    		          more: (params.page * 10) < data.total_count
					    		        }
					    		      };
					    		    },
					    		    cache: true
					    		  },
					    	      /* below part is rendered by jsp so that it has the value from previous form submission; if it is initial form render the below part is not included */
					    	     
					    	      width: '150px',
					    		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
					    		  templateResult: formatRepo, // omitted for brevity, see the source of this page
					    		  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
					    	});
						</script>
		            	
		            	<div class="col-md-4 col-xs-4 wdth form-group display coop_group" id="coop_group">
							<label class="form-group required">กลุ่มเกษตรกร  </label>
							<select  id="farmer_group_name" name="farmer_group_name">
								<option>---------------</option>
							</select>
	            		</div>
	            
						<div id="coopinfo"  class="col-md-8 col-xs-8 wdth">
							<?php if(empty($coop_name)):?>		        
				        
					 			<div class="col-md-2 col-xs-12 display-right">
						 			<label class="required">
						 				<input type="radio" name="typeCoop" id="typeCoop" checked="checked" onclick="type_Coop(true)" value="1"> สหกรณ์
						 			</label>
					 			</div> 
					 			
					 			<div class="col-md-2 col-xs-12 display-right">
						 			<label class="required">
						 				<input type="radio" name="typeCoop" id="typeCoop"  onclick="type_Coop(false)" value="1"> กลุ่มเกษตรกร
						 			</label>
					 			</div> 
				 			
								<script type="text/javascript">
									function type_Coop(value)
									{
										if(value){
											$('#coop_name_div').removeClass('display');
											$('.coop_group').addClass('display');
											}
										else
										{
											$('.coop_group').removeClass('display');
											$('#coop_name_div').addClass('display');
											$('#farmer_group_name').each(function() {
												$(this).select2({
													  placeholder: "กลุ่มเกษตรกร",
													  ajax: {
											    			placeholder: "เลือกสหกรณ์",
											    		    url: '<?php echo site_url('report2/ajax_coop_group')?>',
											    		    dataType: 'json',
											    		    data: function (params) {
												    		    console.log(params);
											    		      return {
						//						    		        keyword: params.term, // search term
											    		        page: params.page,
											    		        province :province_code
											    		      };
											    		    },
											    		    processResults: function (data, params) {
											    		      // parse the results into the format expected by Select2
											    		      // since we are using custom formatting functions we do not need to
											    		      // alter the remote JSON data, except to indicate that infinite
											    		      // scrolling can be used
											    		      params.page = data.page || 1;
											    		      console.log( data.page);
											    		      console.log(data);
											    		      province_code = $('#province_code_hidden').val();
											    		      return {
											    		        results: data.items,
											    		        pagination: {
											    		          more: (params.page * 10) < data.total_count
											    		        }
											    		      };
											    		    },
											    		    cache: true
											    		  },
											    	      /* below part is rendered by jsp so that it has the value from previous form submission; if it is initial form render the below part is not included */
											    	     
											    	      width: '150px',
											    		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
											    		  templateResult: formatRepo, // omitted for brevity, see the source of this page
											    		  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
													});
											});
											}
									}
								</script>
			 				<?php else :?>
					 			<label class="form-group required">ชื่อสหกรณ์</label>
					 			<?php 
					 			$id= isset($user_survey_data[strtoupper('COOP_ID')]) ? $user_survey_data[strtoupper('COOP_ID')]: "";
					 			$id = !is_numeric($id) ? $coop_id : $id;
					 			$temp = getCoopByID($id);
					 			$coop_name = isset($temp['COOP_NAME_TH'])? $temp['COOP_NAME_TH']: "";
					 			?>
					            		<?php echo $coop_name?>
					            		<input id="coop_id"  type="hidden" name="coop_id" value="<?php echo $id?>" />
					            		<?php ?>
			 			
			 				<?php endif;?>
	 					</div>	            
	            
	            
	            
	            
	             		<div class="col-md-4 col-xs-4 wdth">
	
		            		<?php  
			                		$temp_type = 'text';  
			                		$temp_field = 'JOINING_DATE'; 
			                		$mdate = "";
			                		$mdate_year = "";
			                		if(isset($user_survey_data[$temp_field]))
			                		{  
			                			$temp_type = 'hidden';  
			                			$date = strtotime($user_survey_data[$temp_field]);
			                			$mdate = date("d-m-", $date);
										$mdate_year=date('Y',$date)+543;							
										$temp_type = 'hidden'; 
										
										if (empty($user_survey_data[$temp_field]))
										{
											$temp_type = "text";
										}
			                		} 
			                ?>
	                
			                <?php if(isset($user_survey_data[$temp_field]) && !empty($user_survey_data[$temp_field])):?>
				                <div class="col-md-12 col-xs-12 wdth" style="margin-left: -20px;">
				                <label class="form-group">วันที่เป็นสมาชิก </label>
				                <input style="width: 100px" type="<?php echo $temp_type; ?>" class="form-control" id="joining_date" name="joining_date" placeholder="" value="<?php if (isset($user_survey_data[$temp_field])){
				                    $date = strtotime($user_survey_data[$temp_field]);
				                    $bdate = date("d-m-Y", $date);
				                    echo $bdate; } ?>" >
				
				                    <?php echo $mdate.$mdate_year?>
				                    
			                	</div>
			
			                <?php else:?>
			                
				                <label class="form-group required">วันที่เป็นสมาชิก </label>
				                <input style="width: 100px" type="<?php echo $temp_type; ?>" class="form-control" id="joining_date" name="joining_date" placeholder="" value="<?php if (isset($user_survey_data[$temp_field])){
				                    $date = strtotime($user_survey_data[$temp_field]);
				                    $bdate = date("d-m-Y", $date);
				                    echo $bdate; } ?>" 
				                    
				                    onkeypress="return isDate(event)"
				                    
				                    >
			                
			                <?php endif?>
						</div>
	    			</div>
				</div>
		</div>
	
	</div>
	<!--    END SECOND ROW in สังกัด --------------------------------------> 
	
	
	
	
	<!--    start THIRS ROW in สังกัด --------------------------------------> 
	
	<div class="row mar_ned">
	
	    <div class="row">
	
	<!--         <div class="col-md-3 col-xs-4 wdth"> -->
	<!--             <p align="left"><stong>เลขทะเบียนสมาชิก</stong></p> -->
	<!--         </div> -->
	<!--         <div class="col-md-3 col-xs-4 wdth"> -->
	<!--             <p align="left"><stong>รหัสการศึกษา</stong></p> -->
	<!--         </div> -->
	<!--         <div class="col-md-3 col-xs-4 wdth"> -->
	<!--             <p align="left"><stong>ทะเบียนหุ้น</stong></p> -->
	<!--         </div> -->
	<!--         <div class="col-md-3 col-xs-4 wdth"> -->
	<!--             <p align="left"><stong>จำนวนหุ้น</stong></p> -->
	<!--         </div> -->
	    </div>
	
	
	    <div class="col-md-12 col-xs-9">
	        <div class="row">
	
	            <div class="col-md-4 col-xs-4 wdth" style="margin-top: 7px">
	<?php /*
					<?php if (isset($mahadthai[0]) && isset($mahadthai[0]['IN_D_ID'])) :?>
	            	
	            		<?php echo $mahadthai[0]['IN_D_ID']?>
	            		
	                	<input type="hidden" value="<?php if (isset($mahadthai[0]) && isset($mahadthai[0]['IN_D_ID'])) echo $mahadthai[0]['IN_D_ID']?>" class="form-control" id="registration_number" no="registration_number" placeholder="">
					
					<?php else:?>
	
	                	<input type="text" value="<?php if (isset($mahadthai[0]) && isset($mahadthai[0]['IN_D_ID'])) echo $mahadthai[0]['IN_D_ID']?>" class="form-control" id="registration_number" no="registration_number" placeholder="">
					
					<?php endif?>
	*/ ?>
					<label class="form-group required">เลขทะเบียนสมาชิก</label>
	                <?php  $temp_type = 'text';  if(isset($user_survey_data[strtoupper('registration_number')])){  $temp_type = 'hidden';  echo $user_survey_data[strtoupper('registration_number')]; } ?>
					
	                <input type="<?php echo $temp_type; ?>" class="form-control" id="registration_number" name="registration_number" placeholder="" value="<?php if (isset($user_survey_data[strtoupper('registration_number')])) echo $user_survey_data[strtoupper('registration_number')]?>" style="width: 130px" onkeypress="return isAlphaNumeric(event)">
	
	            </div>
	           
	            <div class="col-md-4 col-xs-4 wdth" style="margin-top: 7px;margin-left: -15px;">
					<label class="form-group required">มูลค่าหุ้นต่อหน่วย</label>
	                <?php  $temp_type = 'text';  $temp_field = 'stock_register'; if(isset($user_survey_data[strtoupper($temp_field)])){  $temp_type = 'hidden';  echo trimleft($user_survey_data[strtoupper($temp_field)],'0'); } ?>
					
	                <input type="<?php echo $temp_type; ?>" class="form-control allownumericwithdecimal" id="stock_register" name="stock_register" placeholder="" value="<?php if (isset($user_survey_data[strtoupper($temp_field)])) echo trimleft($user_survey_data[strtoupper($temp_field)],'0'); ?>" style="width: 140px"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false">
	
	
	            </div>
	            <div class="col-md-4 col-xs-4 wdth" style="margin-top: 7px;padding-left:5px !important">
	            
	                <label class="form-group required">จำนวนหุ้น</label>
	                <?php
	                //echo print_r($user_survey_data);
	                
	                $temp_type = 'number';  $temp_field = 'shares_num'; if(isset($user_survey_data[strtoupper($temp_field)])){  $temp_type = 'hidden';  echo intval($user_survey_data[strtoupper($temp_field)]); } ?>
					
	                <input type="<?php echo $temp_type; ?>" class="form-control allownumericwithoutdecimal" id="shares_num" name="shares_num" placeholder="" value="<?php if (isset($user_survey_data[strtoupper($temp_field)])) echo intval($user_survey_data[strtoupper($temp_field)])?>" style="width: 140px"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false">
	
	
	            </div>
	        </div>
	    </div>
	
	
	</div>
	
	<!--    END THIRD ROW in สังกัด --------------------------------------> 
	

</fieldset>

<fieldset>
	<legend class="h_sub_title">3. รูปแบบธุรกิจ</legend>

	<div class="row mar_ned">

		<div class="col-lg-12">

			<div class="col-md-3 col-xs-4 wdth">
				<p align="left"><stong>ทำธุรกิจกับสหกรณ์/กลุ่มเกษตรกร</stong></p>
			</div>
			<div class="col-md-3 col-xs-4 wdth">
				<p align="left"><stong></stong></p>
			</div>
			<div class="col-md-3 col-xs-4 wdth">
				<p align="left"><stong></stong></p>
			</div>
			<div class="col-md-3 col-xs-4 wdth">
				<p align="left"><stong></stong></p>
			</div>
		</div>
	</div>


	
<?php 
$do_buz = array();
if(isset($user_survey_data[strtoupper('do_buz')]) && !empty($user_survey_data[strtoupper('do_buz')])) {
	$do_buz = unserialize($user_survey_data[strtoupper('do_buz')]);   //print_r($plant_specie);
	if(is_null($do_buz))
		$do_buz = array();
}

?>	
	<div class="row mar_ned">

		<div class="col-lg-12">
			<ul class="list-unstyled">
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[0]" id="do_buz1" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(1, $do_buz) ){  echo ' checked ';    }     } ?> value="1"> กู้เงิน
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[1]" id="do_buz2" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(2, $do_buz) ){  echo ' checked ';    }     } ?> value="2"> ฝากเงิน
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[2]" id="do_buz3" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(3, $do_buz) ){  echo ' checked ';    }     } ?> value="3"> ซื้อสินค้า
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[3]" id="do_buz4" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(4, $do_buz) ){  echo ' checked ';    }     } ?> value="4"> ขายผลผลิต
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[4]" id="do_buz5" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(5, $do_buz) ){  echo ' checked ';    }     } ?> value="5"> แปรรูป
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[5]" id="do_buz6" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(6, $do_buz) ){  echo ' checked ';    }     } ?> value="6"> บริการ
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[6]" id="do_buz7" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(7, $do_buz) ){  echo ' checked ';    }     } ?> value="7"> ซื้อน้ำ
				</label>
			</li>
			<li class="col-md-3 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz[7]" id="do_buz8" onclick="" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(8, $do_buz) ){  echo ' checked ';    }     } ?> value="8"> น้ำมันเชื่อเพลิง/แก๊ส
				</label>
			</li>
			<li class="col-md-7 col-xs-4 wdth">
				<label>
					<script>
						function checkOtherDobuz91(){
							$('#do_buz_other').focus();
							$('#do_buz_other').val('');
						}					
					</script>
					<input type="checkbox" name="do_buz[8]" id="do_buz9"  onclick="checkOtherDobuz91();" <?php if(isset($user_survey_data[strtoupper('do_buz')])){ if (in_array(9, $do_buz) ){  echo ' checked ';    }     }  ?> value="9"> อื่นๆ
			
					<input  onclick="$('#do_buz9').prop('checked', true);" onkeyup="$('#do_buz9').prop('checked', true);"   onkeypress="$('#do_buz9').prop('checked', true);return isAlphaNumeric(event);"  style="margin-left: 6px;"   type="text" class="form-control" id="do_buz_other" name="do_buz_other" placeholder="อื่นๆ"   value="<?php if(isset($user_survey_data[strtoupper('do_buz_other')])){ echo $user_survey_data[strtoupper('do_buz_other')]; } ?>"  >
				</label>
			</li>
			</ul>
		</div>

	</div>




</fieldset>
<fieldset>
	<legend class="h_sub_title">4. ลักษณะการประกอบอาชีพ</legend>


<script type="text/javascript">

$(document).ready(function(){
	$('#translating').each(function( index ) {
		$(this).select2({
			  placeholder: "อาชีพหลัก",
			  width:'200px'
			});
	});
	$('#secondary_career').each(function( index ) {
		$(this).select2({
			  placeholder: "อาชีพรอง",
			  width:'200px'
			});
	});
	
});

</script>

<?php 
$main_career = "";
if(isset($user_survey_data[strtoupper('main_career')]) && $user_survey_data[strtoupper('main_career')]) {
	$main_career = $user_survey_data[strtoupper('main_career')];   //print_r($plant_specie);
	if(is_null($main_career))
		$main_career= array();
}
$secondary_career = "";
if(isset($user_survey_data[strtoupper('secondary_career')]) && $user_survey_data[strtoupper('secondary_career')]) {
	$secondary_career = $user_survey_data[strtoupper('secondary_career')];   //print_r($plant_specie);
	if(is_null($secondary_career))
		$secondary_career= array();
}
$main_career_orther="";
if(isset($user_survey_data[strtoupper('main_career_orther')]) && $user_survey_data[strtoupper('main_career_orther')]) {
	$main_career_orther = $user_survey_data[strtoupper('main_career_orther')];   //print_r($plant_specie);
	if(is_null($main_career_orther))
		$main_career_orther= "";
}
$secondary_career_orther="";
if(isset($user_survey_data[strtoupper('secondary_career_orther')]) && $user_survey_data[strtoupper('secondary_career_orther')]) {
	$secondary_career_orther = $user_survey_data[strtoupper('secondary_career_orther')];   //print_r($plant_specie);
	if(is_null($secondary_career_orther))
		$secondary_career_orther= "";
}

?>	

<div class="row mar_ned personal-form">
		<div class="col-lg-12 pb-10">
			<div class="col-md-4 col-xs-4 wdth">
				<label class="form-group nowrap" style="margin-top: 5px; padding-right: 0;">อาชีพหลัก&nbsp;&nbsp;</label>
				<select id="translating" name="main_career">
					<option <?php if ($main_career==1) echo "selected=selected" ?>  value="1">ประกอบอาชีพเกษตร</option>
					<option <?php if ($main_career==2) echo "selected=selected" ?>value="2">รับเงินเดือนประจำ</option>
					<option <?php if ($main_career==3) echo "selected=selected" ?>value="3">รับจ้างทางการเกษตร</option>
					<option <?php if ($main_career==4) echo "selected=selected" ?>value="4">ประกอบธุรกิจการค้า</option>
					<option <?php if ($main_career==5) echo "selected=selected" ?>value="5">รับจ้างทั่วไป</option>
					<option <?php if ($main_career==6) echo "selected=selected" ?>value="6">อื่น ๆ</option>
				</select>
			</div>
			<div class="col-md-8 col-xs-4 wdth">
				<label class="form-group nowrap" style="margin-top: 5px;">อาชีพรอง</label>
				<select id="secondary_career" name="secondary_career">
					<option <?php if ($secondary_career==1) echo "selected=selected" ?> value="1">ประกอบอาชีพเกษตร</option>
					<option <?php if ($secondary_career==2) echo "selected=selected" ?> value="2">รับเงินเดือนประจำ</option>
					<option <?php if ($secondary_career==3) echo "selected=selected" ?> value="3">รับจ้างทางการเกษตร</option>
					<option <?php if ($secondary_career==4) echo "selected=selected" ?> value="4">ประกอบธุรกิจการค้า</option>
					<option <?php if ($secondary_career==5) echo "selected=selected" ?> value="5">รับจ้างทั่วไป</option>
					<option <?php if ($secondary_career==6) echo "selected=selected" ?> value="6">อื่น ๆ</option>
					<option <?php if ($secondary_career==7) echo "selected=selected" ?> value="7">ไม่มีอาชีพรอง</option>
				</select>
			</div>
		</div>
		<div id="" class="col-md-1 col-xs-1 wdth "></div>
		<div class="col-md-4 col-xs-4 wdth " id="translating_orther">
<!--    	<label class="form-group">อาชีพหลัก</label> -->
		    <input type="text"  name="main_career_orther" style="margin-left: 5px;" class="form-control <?php if ($main_career!=6):?>display<?php endif?>" placeholder="อื่นๆ" value="<?php if(isset($main_career_orther)){echo $main_career_orther;}?>">
		</div>
		<div class="col-md-4 col-xs-4 wdth " id="secondary_career_orther">
<!--  		<label class="form-group">อาชีพรอง</label> -->
		    <input type="text"  name="secondary_career_orther" style="margin-left: -7px;" class="form-control <?php if ($secondary_career!=6):?>display<?php endif?>" placeholder="อื่นๆ" value="<?php if(isset($secondary_career_orther)){echo $secondary_career_orther;}?>">
		</div>
	</div>
	<script type="text/javascript">
	$(function(){
		$('#translating').on('change',function(){
			console.log($(this).val());
			if($(this).val() =='6')
				{
				$('#translating_orther input').removeClass('display');
				}
			else
			{
				$('#translating_orther input').addClass('display');
				}
// 			if()


			});

		$('#secondary_career').on('change',function(){
			console.log($(this).val());
			if($(this).val() =='6')
			{
			$('#secondary_career_orther input').removeClass('display');
			}
			else
			{
				$('#secondary_career_orther input').addClass('display');
				}
		
			});
		});

	</script>
</fieldset>
<fieldset>
	<legend class="h_sub_title">5. ปัญหาเบื้องต้นที่เกษตรประสบ</legend>
	<div class="row mar_ned">

<?php 
$do_buz2 = array();
if(isset($user_survey_data[strtoupper('do_buz2')]) && $user_survey_data[strtoupper('do_buz2')]) {
	$do_buz2 = unserialize($user_survey_data[strtoupper('do_buz2')]);   //print_r($plant_specie);
	if(empty($do_buz2))
		$do_buz2= array();
}
?>	
	
		<div class="row col-lg-12">
			<ul class="list-unstyled">
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[0]" id="do_buz1" <?php if (in_array(1, $do_buz2)) echo "checked=checked"?>  value="1"> ด้านทุน
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[1]" id="do_buz2" <?php if (in_array(2, $do_buz2)) echo "checked=checked"?> value="2"> ด้านแรงงาน
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[2]" id="do_buz3"  <?php if (in_array(3, $do_buz2)) echo "checked=checked"?> value="3"> ด้านปัจจัยและเทคโนโลยีการผลิต
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[3]" id="do_buz4"  <?php if (in_array(4, $do_buz2)) echo "checked=checked"?> value="4"> ด้านการตลาด
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[4]" id="do_buz5" <?php if (in_array(5, $do_buz2)) echo "checked=checked"?> value="5"> องค์ความรู้
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[5]" id="do_buz6" <?php if (in_array(6, $do_buz2)) echo "checked=checked"?> value="6"> โรคระบาด
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[6]" id="do_buz7"  <?php if (in_array(7, $do_buz2)) echo "checked=checked"?> value="7"> ปัจจัยการผลิด
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[7]" id="do_buz8" <?php if (in_array(8, $do_buz2)) echo "checked=checked"?> value="8"> ที่ดินทำกิน
				</label>
			</li>
			<li class="col-md-4 col-xs-4 wdth">
				<label>
					<input type="checkbox" name="do_buz2[8]" id="do_buz9"  <?php if (in_array(9, $do_buz2)) echo "checked=checked"?> value="9"> ด้านภัยพิบัติ
					<!-- <input type="text" name="do_buz_text" id="do_buz4" class="form-control" style="margin-left: 6px;" value=""> -->
				</label>
			</li>
			<li class="col-md-7 col-xs-4 wdth">
				<label>
				
					<script>
						function checkOtherDobuz29(){
							$('#do_buz429').focus();
							$('#do_buz429').val('');
						}					
					</script>				
					<input type="checkbox" onclick="checkOtherDobuz29()" name="do_buz2[9]" id="do_buz10" <?php if (in_array(10, $do_buz2)) echo "checked=checked"?> value="10"> อื่น ๆ
					<input   onclick="$('#do_buz10').prop('checked', true);" onkeyup="$('#do_buz10').prop('checked', true);"   onkeypress="$('#do_buz10').prop('checked', true);return isAlphaNumeric(event);" type="text" name="do_buz_text" id="do_buz429" class="form-control"  style="margin-left: 6px;" value="<?php if(in_array(10, $do_buz2) && isset($user_survey_data[strtoupper('do_buz_text')])) {echo strip_tags($user_survey_data[strtoupper('do_buz_text')]);}?>" >
				</label>
			</li>
			</ul>
		</div>
	</div>
</fieldset>



<?php /*
<button href="#steb2" class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
*/ ?>
<?php //include("_btn_next_step.php"); ?>

  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
<script>

$(document).ready(function() {

	$('#coop_name_div').click(function(){
		$('#org_type1').click();
	});
	$('#province_id').each(function( index ) {
		$(this).select2({
			  placeholder: "เลือกจังหวัด"
			});
	});
	$('#district_id').each(function( index ) {
		$(this).select2({
			  placeholder: "เลือกอำเภอ",
			  width:'120px'
			});
	});				
	$('#sub_district_id').each(function( index ) {
		$(this).select2({
			  placeholder: "เลือกตำบล",
			  width:'120px'
			});
	});
	$('#name_title').each(function( index ) {
		$(this).select2({
			  placeholder: "เลือกคำนำหน้า",
			  width: '50px'
			});
	});

});


                
    $(document).ready(function () { //page load
        $('#province_id').val(<?php $temp_field ="province_id"; if (isset($user_survey_data[strtoupper($temp_field)])) echo $user_survey_data[strtoupper($temp_field)]?>);

        <?php  if (isset($user_survey_data[strtoupper($temp_field)])){  ?>
        var provinceId=<?php echo $user_survey_data[strtoupper($temp_field)]; ?>;$.ajax({
            type:"GET",url:"<?php echo site_url('admin/listjson_local/')?>"+provinceId,data:{
                province:provinceId},success:function(data){
                var a=JSON.parse(data);$('select[name="district_id"]').prop("disabled",true);
                $("#district_id").html(a.response);
                //console.log(a.response);
                $('#district_id').val(<?php $temp_field ="district_id"; if (isset($user_survey_data[strtoupper($temp_field)])) echo $user_survey_data[strtoupper($temp_field)]?>);
                <?php if($mode=="view"){ ?> 			$("#district_id").prop("disabled", true);  <?php } ?>
            }});

<?php }

if (isset($user_survey_data[strtoupper($temp_field)])){  ?>

            var district_id=<?php echo $user_survey_data[strtoupper($temp_field)]; ?>;$.ajax({
            type:"GET",url:"<?php echo site_url('admin/listjson_local2/')?>"+district_id,data:{
                district_id:district_id},success:function(data){
                var a=JSON.parse(data);$('select[name="sub_district_id"]').prop("disabled",true);
                $("#sub_district_id").html(a.response);
                //console.log(a.response);
                $('#sub_district_id').val(<?php $temp_field ="sub_district_id"; if (isset($user_survey_data[strtoupper($temp_field)])) echo $user_survey_data[strtoupper($temp_field)]?>);
                <?php if($mode=="view"){ ?> 			$("#sub_district_id").prop("disabled", true);  <?php } ?>
            }});


        <?php }



        ?>

    });
    $(document).ready(function() {
        $('#multiselect').multiselect({
            buttonWidth: '200px'
        });
    });
    
//     $('#multiselect').each(function( index ) {
// 		$(this).select2({
// 			  placeholder: "เลือกคำนำหน้า"
// 			});
// 	});

</script>
