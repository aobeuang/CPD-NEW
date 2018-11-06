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
			<h2><span class="glyphicon glyphicon-signal"></span> รายงานข้อมูลผลไม้</h2>
			
			<?php /*?>
			<div id="left-container" class="col-md-3 col-xs-12">
			<ul class="list-group">
				<li class="list-group-item "><a href="<?php echo site_url('report1/index1')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลทั่วไป</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index2')?>"><i class="fa fa-caret-right"></i> รายงานพื้นที่ครอบครอง</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index3')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการผลิตทางการเกษตรในรอบปีที่ผ่านมา</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index4')?>"><i class="fa fa-caret-right"></i> รายงานปัญหาที่พบในการประกอบอาชีพ</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index5')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลหนี้สิน จำนวนลูกหนี้ และยอดหนี้สิน</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index6')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการผลิตปีปัจจุบัน</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index7')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการเลี้ยงโคนม</a></li>
				<li class="list-group-item active"><a href="<?php echo site_url('report1/index8')?>">รายงานข้อมูลผลไม้</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index9')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลพันธ์ข้าว</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index10')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการใช้ปุ๋ย</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index11')?>"><i class="fa fa-caret-right"></i> รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</a></li>
			</ul>				
			</div>
			*/
?>
			
			<div id="right-container" class="col-md-12 col-xs-12">
				
				<div class="row" id="action-bar">
					<div class="report-action-bar">

						<form id="search-analytic" action="" method="GET">
						
						<input type="hidden" value="yes" name="frompost" />
						
						<div class="container-fluid col-md-3 col-xs-12" style="margin-top: 6px;">
							<label for="filter_year">ปีที่สำรวจ: </label>	
							<select name="filter_year" id="filter_year" >
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
									<?php $selected = $province->PROVINCE_NAME==$filter_province ? " selected=\"selected\" " : "";?>
									<option value="<?php echo $province->PROVINCE_ID?>" <?php echo $selected?> ><?php echo $province->PROVINCE_NAME?></option>
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
							<button class="btn btn-outline-purple" id="btn-search"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>		
						</div>
						
						
						
					</form>

					
					</div>
				</div>
				
							
				
				<div id="myProgress" class="display">
					  <div id="myBar">0%</div>
				</div>
				<div class="row" id ="save">
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right; margin-right: 20px;" disabled  />
			    </div>
				<!-- 	<div id="piechart" style="width: 900px; height: 500px;"></div>  -->
				<h4><center>พบข้อมูลตามเงื่อนไข <span id="total_chart_div"></span> จำนวน  จากทั้งหมด  <span id="total_all"></span> แถว</center></h4>
				<div id="top" style="width: 800px; height: 600px;"></div>
				
				
			</div>
		</div>
	
	</div>

</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script>
google.charts.load('current', {'packages':['bar',"corechart"]});
// google.charts.setOnLoadCallback(drawStuffColumn);
var data_json;
var count = 0;
var  list_type ;
var now = new Date(); 
var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
"ตุลาคม","พฤศจิกายน","ธันวาคม");
var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
$('#datethai').html(datethai);



function drawStuffColumn(count,countall,filter_year,filter_province_hidden,filter_range_income_hidden,filter_status) {
	filter_year = Number(filter_year)+543;
	var data = google.visualization.arrayToDataTable(data_json);
//   var data = new google.visualization.arrayToDataTable([
//     ['Move', 'จำนวน(ตัน)'],
//     ["ทุเรียน", 44],
//     ["มังคุด", 31],
//     ["ลิ้นจี", 12],
//     ["แอปเปิ้ล", 42],
//     ["ส้ม", 52],
//     ["ลำไย", 78]
//   ]);
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
    width: 1000,
    heigh: 500,
    bar: { groupWidth: "80%" }
  };

  var chart_div = document.getElementById('top');
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
						text: 'รายงานข้อมูลผลไม้',
						alignment: 'center',
						style: 'header'
					},
					{
						text: 'ตามเงื่อนไขปี ' +filter_year+ ' จังหวัด' +filter_province_hidden+ ' ช่วงรายได้ '+filter_range_income_hidden,						
						alignment: 'center',
						style: 'header',						
					},					
					{
						text: 'แบ่งข้อมูลตาม'+filter_status+' พบข้อมูล ' +count+ ' จำนวน จากข้อมูลทั้งหมด ' +countall+ ' แถว',						
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,0],
					},	
					
					{
						image: uri,
						alignment: 'center',
						width: 925 * 0.7487922705314,
						height:400,
				       	
						
						
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
		pdfMake.createPdf(docDefinition).download('รายงานข้อมูลผลไม้.pdf');
	  }, false);

  chart.draw(data, {
	    chartArea: {
	      bottom: 24,
	      left: 36,
	      right: 12,
	      top: 48,
	      width: '100%',
	      height: '100%'
	    },
	    height: 600,
	    title: 'ภาษาไทย',
	    width: 600
	  });
  chart.draw(view, options);
  
}

$('#filter_province').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกจังหวัด",
		  width: "140px"
		});
});
$('#filter_year').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกปี",
		  width:'100px'
		});
});

$('#filter_range_income').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกช่วงรายได้"
		});
});

$(function ()
{

	$('#search-analytic').submit(function ()
	{
		var filter_year = $('#filter_year').val(); 
		var filter_province_hidden =	$('#filter_province').val();
		var filter_range_income_hidden = $('#filter_range_income').val();
		
		if(typeof filter_year == 'undefined' ||  filter_year=='0')
		{
			filter_year = "";
		}
		if(typeof filter_province_hidden == 'undefined' ||  filter_province_hidden=='0')
		{
			filter_province_hidden = "";
		}
		if(typeof filter_range_income_hidden == 'undefined' ||  filter_range_income_hidden=='0')
		{
			filter_range_income_hidden = "";
		}
	
		id = setInterval(frame, time);
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
		call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden);

		return false;
	});
	
});

var elem = document.getElementById("myBar");   
var width = 10;
var time = (((10*0.15)/100)+5)*10;
var id;

	load_default();
	function load_default()
	{
		var filter_year = $('#filter_year').val(); 
		var filter_province_hidden =	$('#filter_province').val();
		var filter_range_income_hidden = $('#filter_range_income').val();
		
		if(typeof filter_year == 'undefined'  ||  filter_year=='0')
		{
			filter_year = "";
		}
		if(typeof filter_province_hidden == 'undefined'  ||  filter_province_hidden=='0')
		{
			filter_province_hidden = "";
		}
		if(typeof filter_range_income_hidden == 'undefined' ||  filter_range_income_hidden=='0')
		{
			filter_range_income_hidden = "";
		}
	
		id = setInterval(frame, time);
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
		call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden);
	}

	function call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden)
	{
		$.ajax({
			url:'<?php echo site_url('ReportAnalytic/count_fruit') ?>',
					dataType:'json',
					type:'GET',		
					data:{filter_year:filter_year,filter_province_hidden:filter_province_hidden,filter_range_income_hidden:filter_range_income_hidden},
					success:function (result) {
// 						console.log(result);
// 						data_json = result.data;

						count = result.count;
 						data_json =  [['lable','ปลูกแล้ว','จะปลูก']];
						for (let elem in result.data)
	    				{
	    					console.log(elem);
	    					data_json.push([elem+'',result.data[elem]['ปลูกแล้ว'],result.data[elem]['จะปลูก']]);
	    				}

						var old_element = document.getElementById("save-pdf");
						var new_element = old_element.cloneNode(true);
						old_element.parentNode.replaceChild(new_element, old_element);
						var filter_province_name = $('#filter_province option:selected').text();
						var filter_range_income_name = $('#filter_range_income option:selected').text();
						var filter_status_name = $('#filter_status option:selected').text();	
						if(result.count !== 0){	
							google.charts.setOnLoadCallback(function(){drawStuffColumn(result.count,result.countall,filter_year,filter_province_name,filter_range_income_name,filter_status_name)});		
							
						}else{
							$('#top').empty();
							$('#save-pdf').prop('disabled', true);
						}
						
						
// 						google.charts.setOnLoadCallback(drawStuffColumn);

						clearInterval(id);
				        elem.style.width = 100 + '%'; 
				        elem.innerHTML = 100  + '%';
				        $('#btn-search').prop('disabled', false);

						
						$('#total_chart_div').html(result.count);
						$('#total_all').html(result.countall);
					}
			});
	}

</script>


