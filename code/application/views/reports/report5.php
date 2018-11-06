<?php
$this->load->helper('survey');
?>
<style>


#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
</style>

<div id="report" class="nonmis">

	<div id="main-wrapper">
		<div id="main-container" class="container-fluid col-md-12 col-xs-12">
			<h2><span class="glyphicon glyphicon-signal"></span> รายงานข้อมูลหนี้สิน จำนวนลูกหนี้ และยอดหนี้สิน</h2>
			
			<?php /*?>
			<div id="left-container" class="col-md-3 col-xs-12">
			<ul class="list-group">
				<li class="list-group-item "><a href="<?php echo site_url('report1/index1')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลทั่วไป</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index2')?>"><i class="fa fa-caret-right"></i> รายงานพื้นที่ครอบครอง</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index3')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการผลิตทางการเกษตรในรอบปีที่ผ่านมา</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index4')?>"><i class="fa fa-caret-right"></i> รายงานปัญหาที่พบในการประกอบอาชีพ</a></li>
				<li class="list-group-item active"><a href="<?php echo site_url('report1/index5')?>">รายงานข้อมูลหนี้สิน จำนวนลูกหนี้ และยอดหนี้สิน</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index6')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการผลิตปีปัจจุบัน</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index7')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการเลี้ยงโคนม</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index8')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลผลไม้</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index9')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลพันธ์ข้าว</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index10')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการใช้ปุ๋ย</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index11')?>"><i class="fa fa-caret-right"></i> รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</a></li>
			</ul>			
			
			</div>
			*/?>
			
			<div id="right-container" class="col-md-12 col-xs-12">
				
				
				<div class="row" id="action-bar">
					<div class="report-action-bar">

						<form id="search-analytic" action="" method="GET">
						
						<input type="hidden" value="yes" name="frompost" />
						
						<div class="container-fluid col-md-3 col-xs-12" style="margin-top: 6px;">
							<label for="filter_year">ปีที่สำรวจ: </label>	
							<select name="filter_year" id="filter_year" >
								<option value="">ทั้งหมด</option>
							<?php  
								$all_survey_years = getAllSurveyYears();
								if (!empty($all_survey_years))
								{
									foreach ($all_survey_years as $k=>$v)
									{
										$selected = "";
										if ($k==$filter_year)
											$selected = "selected=\"selected\"";		
										echo "<option $selected value='$k'>$v</option>";
									}
								}
							?>
							</select>															
						</div>
					
						<div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 6px;">				
							<label for="filter_province">จังหวัด: </label>		
							<input type="hidden" id="filter_province_hidden" value=""/>
							<?php $all_provinces = getAllProvinces();?>
							<select id="filter_province" name="filter_province">
							<option value = "0" >ทั้งหมด </option>
								<?php foreach ($all_provinces as $province):?>
									<?php //$selected = $province->PROVINCE_NAME==$filter_province ? " selected=\"selected\" " : "";?>
									<option value="<?php echo $province->PROVINCE_ID?>" <?php // echo $selected?> ><?php echo $province->PROVINCE_NAME?></option>
								<?php endforeach?>
							</select>

						</div>
						
						<div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 6px;">				
							<label for="filter_range_income">ช่วงรายได้: </label>		
							<input type="hidden" id="filter_range_income_hidden" value=""/>	
							<?php $listfilter = array("ทั้งหมด","100,000-300,000","300,000-500,000","500,000 ขึ้นไป");?>
							<select id="filter_range_income" name="filter_range_income">
									<option></option>
									<?php foreach ($listfilter as $k=>$v):?>
										<?php $selected = "";?>
										<?php if ($k==$filter_range_income){?>
											<?php $selected = "selected=\"selected\"";?>
										<?php }?>													
										<?php echo "<option $selected value='$k'>$v</option>";?>
								<?php endforeach?>	
							</select>
						</div>
						
								
						<div class="container-fluid col-md-1 col-xs-12" class="search-report-button" >
							<button class="btn btn-outline-purple" id="btn-search" ><span class="glyphicon glyphicon-search"></span> ค้นหา</button>		
						</div>
						
						<div class="container-fluid col-md-8 col-xs-12"  style="margin-top: 6px;">				
							<label for="filter_status">แบ่งตามข้อมูล: </label>		
							<input type="hidden" id="filter_status_hidden" value=""/>
							<?php $listfilter_status= array("ประเภทเจ้าหนี้","จำนวนหนี้","ลักษณะหนี้");?>							
								<select id="filter_status" name="filter_status">									
									<?php foreach ($listfilter_status as $k=>$v):?>
										<?php $selected = "";?>
										<?php if ($k==$filter_status){?>
											<?php $selected = "selected=\"selected\"";?>
										<?php }?>													
										<?php echo "<option $selected value='$k'>$v</option>";?>
									<?php endforeach?>
								</select>
						</div>

												
						
						
					</form>

					
					</div>
				</div>
				<div id="myProgress" class="display">
					  <div id="myBar">0%</div>
				</div>	
					<div class="row" id ="save">
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" disabled  />
			    </div>	
				<h4><center>พบข้อมูลตามเงื่อนไข <span id="total"></span> จำนวน จากข้อมูลทั้งหมด <span id="countall"></span> แถว</center></h4>
					<div id="dual_x_div" style="width:400; height:300"></div>
				
				
			</div>
				
				
				
				
				
				
			</div>
			
		</div>
	
	</div>

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>

google.charts.load('current', {'packages':['bar',"corechart"]});
var  list_type ;
var now = new Date(); 
var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
"ตุลาคม","พฤศจิกายน","ธันวาคม");
var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
$('#datethai').html(datethai);

$('#filter_province').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกจังหวัด",
		  width: "140px"
		});
});
$('#filter_year').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกปี"
		});
});
$('#filter_status').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกประเภทข้อมูล",
			  width: "120px"
		});
});
$('#filter_range_income').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกช่วงรายได้"
		});
});

function drawType1(filter_year,filter_province_hidden,filter_range_income_hidden,filter_status) {

	var data_coop = [['เจ้าหนี้', 'หนี้ปกติ','หนี้ค้าง/ฟ้องดำเนินคดี']];
	filter_year = Number(filter_year)+543;
	for(var i=0;i<list_type.list_data['หนี้ปกติ'].length;i++)
	{
		var temp = [];
		temp.push(list_type.list_comment[i],list_type.list_data['หนี้ปกติ'][i].value,list_type.list_data['หนี้ค้าง/ฟ้องดำเนินคดี'][i].value);
		data_coop.push(temp);
	}
	var data = google.visualization.arrayToDataTable(data_coop);
	var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                       2, { calc: "stringify",
                           sourceColumn: 2,
                           type: "string",
                           role: "annotation" }
                     ]);
	var options = {
	        title: 'รายงานจำนวนด้านหนี้สิน',
	        width: 1000,
	       	 height: 500,
       		tooltip: { trigger: 'selection' }	       	
	      };
  var chart_div = document.getElementById('dual_x_div');
  var chart = new google.visualization.ColumnChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
  
  google.visualization.events.addListener(chart, 'ready', function () {
	    btnSave.disabled = false;
	   
	  });
	btnSave.addEventListener('click', function () {
		var uri =  chart.getImageURI();
		
		pdfMake.fonts = {
				Roboto: {
				    normal: 'Roboto-Regular.ttf',
				    bold: 'Roboto-Medium.ttf',
				    italics: 'Roboto-Italic.ttf',
				    bolditalics: 'Roboto-MediumItalic.ttf'
				  },
				  THSarabunNew: {
				    normal: 'THSarabunNew.ttf',
				    bold: 'THSarabunNew Bold.ttf',
				    italics: 'THSarabunNew Italic.ttf',
				    bolditalics: 'THSarabunNew BoldItalic.ttf'
				  }
				}
		if(filter_range_income_hidden == "ทั้งหมด"){
			filter_range_income_hidden = filter_range_income_hidden+"";	
		}else
			filter_range_income_hidden = filter_range_income_hidden+" บาท";	
		var docDefinition = { 
				content: [
					{
						text: 'รายงานข้อมูลหนี้สิน',
						alignment: 'center',
						style: 'header'
					},
					{
						
						text: 'ตามเงื่อนไขปี ' +filter_year+ ' จังหวัด' +filter_province_hidden+ ' ช่วงรายได้ '+filter_range_income_hidden,						
						alignment: 'center',
						style: 'header',						
					},					
					{
						text: 'แบ่งข้อมูลตาม'+filter_status+' พบข้อมูล ' +list_type.total.toLocaleString()+ ' จำนวน จากข้อมูลทั้งหมด ' +list_type.countall.toLocaleString()+ ' แถว',						
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,30],
					},
					
					{
						image: uri,
						alignment: 'center',
						width: 900 * 0.7487922705314,
				       	
						
						
					},
				],
				footer: {
					columns: [
					'',
					{ text: datethai, alignment: 'right',style: 'footer', }
					],margin: [40, 0],
				},
				defaultStyle:{
					font: 'THSarabunNew'	
				},
				styles: {
					header: {
						fontSize: 25,
						bold: true
					},
					footer :{
						fontSize: 15,
						font: 'THSarabunNew'
					}
					
				},
				pageOrientation: 'landscape',
				

		};
		pdfMake.createPdf(docDefinition).download('รายงานข้อมูลหนี้สิน.pdf');
	  }, false);
	
	chart.draw(view, google.charts.Bar.convertOptions(options));  
	
};

function drawType2(filter_year,filter_province_hidden,filter_range_income_hidden,filter_status) {

	var data_coop = [['ประเภท', 'จำนวนสมาชิก']];

	filter_year = Number(filter_year)+543;
	for(var i=0;i<list_type.total_debt.length;i++)
	{
		
		var temp = [];
		temp.push(list_type.total_debt[i].name+'',list_type.total_debt[i].value);
		data_coop.push(temp);
	}


	
	var data = google.visualization.arrayToDataTable(data_coop);
	var view = new google.visualization.DataView(data);
    
	var options = {
	        title: 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภทต่างๆ',
	        width: 1000,
       	 height: 350,
       	tooltip: { trigger: 'selection' }	
       	
	      };
  var chart_div = document.getElementById('dual_x_div');
  var chart = new google.visualization.PieChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
  
  google.visualization.events.addListener(chart, 'ready', function () {
	    btnSave.disabled = false;
	   
	  });
	btnSave.addEventListener('click', function () {
		var uri =  chart.getImageURI();
		
		pdfMake.fonts = {
				Roboto: {
				    normal: 'Roboto-Regular.ttf',
				    bold: 'Roboto-Medium.ttf',
				    italics: 'Roboto-Italic.ttf',
				    bolditalics: 'Roboto-MediumItalic.ttf'
				  },
				  THSarabunNew: {
				    normal: 'THSarabunNew.ttf',
				    bold: 'THSarabunNew Bold.ttf',
				    italics: 'THSarabunNew Italic.ttf',
				    bolditalics: 'THSarabunNew BoldItalic.ttf'
				  }
				}
		if(filter_range_income_hidden == "ทั้งหมด"){
			filter_range_income_hidden = filter_range_income_hidden+"";	
		}else
			filter_range_income_hidden = filter_range_income_hidden+" บาท";	
		var docDefinition = { 
				content: [
					{
						text: 'รายงานข้อมูลหนี้สิน',
						alignment: 'center',
						style: 'header'
					},
					{
						
						text: 'ตามเงื่อนไขปี ' +filter_year+ ' จังหวัด' +filter_province_hidden+ ' ช่วงรายได้ '+filter_range_income_hidden,						
						alignment: 'center',
						style: 'header',						
					},					
					{
						text: 'แบ่งข้อมูลตาม'+filter_status+' พบข้อมูล ' +list_type.total.toLocaleString()+ ' จำนวน จากข้อมูลทั้งหมด ' +list_type.countall.toLocaleString()+ ' แถว',						
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,30],
					},
					
					{
						image: uri,
						alignment: 'center',
						width: 925 * 0.7487922705314,
				       	
						
						
					},
				],
				footer: {
					columns: [
					'',
					{ text: datethai, alignment: 'right',style: 'footer', }
					],margin: [40, 0],
				},
				defaultStyle:{
					font: 'THSarabunNew'	
				},
				styles: {
					header: {
						fontSize: 25,
						bold: true
					},
					footer :{
						fontSize: 15,
						font: 'THSarabunNew'
					}
					
				},
				pageOrientation: 'landscape',
				

		};
		pdfMake.createPdf(docDefinition).download('รายงานข้อมูลหนี้สิน.pdf');
	  }, false);
	
	chart.draw(data,options);  
	
};

function drawType4(filter_year,filter_province_hidden,filter_range_income_hidden,filter_status) {

	var data_coop = [['รายการ', 'หนี้ปกติ','หนี้เสีย']];
	filter_year = Number(filter_year)+543;
	for(var i=0;i<list_type.list_data['หนี้ปกติ'].length;i++)
	{
		var temp = [];
		temp.push(list_type.list_comment[i],list_type.list_data['หนี้ปกติ'][i].value,list_type.list_data['หนี้เสีย'][i].value);
		data_coop.push(temp);
	}
	var data = google.visualization.arrayToDataTable(data_coop);
	var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                       2, { calc: "stringify",
                           sourceColumn: 2,
                           type: "string",
                           role: "annotation" }
                     ]);
	var options = {
	        title: 'จำนวนสมาชิกแบ่งตามช่วงหนี้สิน',
	        width: 1000,
	       	 height: 500,
       		tooltip: { trigger: 'selection' }	       	
	      };
  var chart_div = document.getElementById('dual_x_div');
  var chart = new google.visualization.ColumnChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
  
  google.visualization.events.addListener(chart, 'ready', function () {
	    btnSave.disabled = false;
	   
	  });
	btnSave.addEventListener('click', function () {
		var uri =  chart.getImageURI();
		
		pdfMake.fonts = {
				Roboto: {
				    normal: 'Roboto-Regular.ttf',
				    bold: 'Roboto-Medium.ttf',
				    italics: 'Roboto-Italic.ttf',
				    bolditalics: 'Roboto-MediumItalic.ttf'
				  },
				  THSarabunNew: {
				    normal: 'THSarabunNew.ttf',
				    bold: 'THSarabunNew Bold.ttf',
				    italics: 'THSarabunNew Italic.ttf',
				    bolditalics: 'THSarabunNew BoldItalic.ttf'
				  }
				}
		if(filter_range_income_hidden == "ทั้งหมด"){
			filter_range_income_hidden = filter_range_income_hidden+"";	
		}else
			filter_range_income_hidden = filter_range_income_hidden+" บาท";	
		var docDefinition = { 
				content: [
					{
						text: 'รายงานข้อมูลหนี้สิน',
						alignment: 'center',
						style: 'header'
					},
					{
						
						text: 'ตามเงื่อนไขปี ' +filter_year+ ' จังหวัด' +filter_province_hidden+ ' ช่วงรายได้ '+filter_range_income_hidden,						
						alignment: 'center',
						style: 'header',						
					},					
					{
						text: 'แบ่งข้อมูลตาม'+filter_status+' พบข้อมูล ' +list_type.total.toLocaleString()+ ' จำนวน จากข้อมูลทั้งหมด ' +list_type.countall.toLocaleString()+ ' แถว',						
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,30],
					},
					
					{
						image: uri,
						alignment: 'center',
						width: 900 * 0.7487922705314,
					},
				],
				footer: {
					columns: [
					'',
					{ text: datethai, alignment: 'right',style: 'footer', }
					],margin: [40, 0],
				},
				defaultStyle:{
					font: 'THSarabunNew'	
				},
				styles: {
					header: {
						fontSize: 25,
						bold: true
					},
					footer :{
						fontSize: 15,
						font: 'THSarabunNew'
					}
					
				},
				pageOrientation: 'landscape',
				

		};
		pdfMake.createPdf(docDefinition).download('จำนวนสมาชิกแบ่งตามช่วงหนี้สิน.pdf');
	  }, false);
	
	chart.draw(view, google.charts.Bar.convertOptions(options));  
	
};

$(function ()
		{
	$('#search-analytic').submit(function ()
		{
			var filter_year = $('#filter_year').val(); 
			var filter_province_hidden =	$('#filter_province').val();
			var filter_range_income_hidden = $('#filter_range_income').val();
			
			if(typeof filter_year == 'undefined')
			{
				filter_year = "";
			}
			if(typeof filter_province_hidden == 'undefined')
			{
				filter_province_hidden = "";
			}
			if(typeof filter_range_income_hidden == 'undefined')
			{
				filter_range_income_hidden = "";
			}
		
			
			call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden);
	
			return false;
		});
		
	});
		load_default();
		function load_default()
		{
			var filter_year = $('#filter_year').val(); 
			var filter_province_hidden =	$('#filter_province').val();
			var filter_range_income_hidden = $('#filter_range_income').val();
			
			if(typeof filter_year == 'undefined')
			{
				filter_year = "";
			}
			if(typeof filter_province_hidden == 'undefined' || filter_province_hidden  == "0")
			{
				filter_province_hidden = "";
			}
			if(typeof filter_range_income_hidden == 'undefined')
			{
				filter_range_income_hidden = "";
			}
		
			
			call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden);
		}
			
function call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden)
{
var filter_status	= $('#filter_status').val();
	
	if(filter_status == 0){
		filter = 'count_debt';
	}
	if(filter_status == 1){
		filter = 'count_debt_normal_abnormal';
	}
	if(filter_status == 2){
		filter = 'count_debt';		
	}
	var elem = document.getElementById("myBar");   
	var width = 10;
	var time = (((10*0.15)/100)+5)*10;
	var id = setInterval(frame, time);
	$('#btn-search').prop('disabled', true);
	function frame() {
	  if (width >= 98) {
	    clearInterval(id);
	  } else {
	    width++; 
	    elem.style.width = width + '%'; 
	    elem.innerHTML = width * 1  + '%';
	    
	  }
	} 

	$.ajax({

				url:"/index.php/ReportAnalytic/"+filter,
				dataType:'json',
				type:'GET',		
				data:{filter_year:filter_year,filter_province_hidden:filter_province_hidden,filter_range_income_hidden:filter_range_income_hidden},
				success:function (result) {	
									
					list_type = result;
					var filter_province_name = $('#filter_province option:selected').text();
					var filter_range_income_name = $('#filter_range_income option:selected').text();
					var filter_status_name = $('#filter_status option:selected').text();	
					
					if(filter_status == 0){
						var old_element = document.getElementById("save-pdf");
						var new_element = old_element.cloneNode(true);
						old_element.parentNode.replaceChild(new_element, old_element);
						
						if(list_type.total !== 0){	
							google.charts.setOnLoadCallback(function(){drawType1(filter_year,filter_province_name,filter_range_income_name,filter_status_name)});					
							
						}else{
							$('#dual_x_div').empty();
							$('#save-pdf').prop('disabled', true);
						}
					}
					else if(filter_status == 2){
						var old_element = document.getElementById("save-pdf");
						var new_element = old_element.cloneNode(true);
						old_element.parentNode.replaceChild(new_element, old_element);
						
						if(list_type.total !== 0){	
							google.charts.setOnLoadCallback(function(){drawType2(filter_year,filter_province_name,filter_range_income_name,filter_status_name)});					
							
						}else{
							$('#dual_x_div').empty();
							$('#save-pdf').prop('disabled', true);
						}
					}
					else if(filter_status == 1){
						var old_element = document.getElementById("save-pdf");
						var new_element = old_element.cloneNode(true);
						old_element.parentNode.replaceChild(new_element, old_element);
						
						if(list_type.total !== 0){	
							google.charts.setOnLoadCallback(function(){drawType4(filter_year,filter_province_name,filter_range_income_name,filter_status_name)});					
							
						}else{
							$('#dual_x_div').empty();
							$('#save-pdf').prop('disabled', true);
						}
					}		
					$('#total').html(list_type.total.toLocaleString());
					$('#countall').html(list_type.countall.toLocaleString());
					clearInterval(id);
			        elem.style.width = 100 + '%'; 
			        elem.innerHTML = 100  + '%';
			        $('#btn-search').prop('disabled', false);
				}
		});
}


</script>


