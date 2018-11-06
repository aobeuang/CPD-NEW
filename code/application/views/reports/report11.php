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
			<h2><span class="glyphicon glyphicon-signal"></span> รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</h2>
			
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
				<li class="list-group-item "><a href="<?php echo site_url('report1/index8')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลผลไม้</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index9')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลพันธ์ข้าว</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index10')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการใช้ปุ๋ย</a></li>
				<li class="list-group-item active"><a href="<?php echo site_url('report1/index11')?>">รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</a></li>
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
									<option value="<?php echo $province->PROVINCE_ID?>"><?php echo $province->PROVINCE_NAME?></option>
								<?php endforeach?>
							</select>

						</div>
						
						<div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 6px;">				
							<label for="filter_range_income">ช่วงรายได้: </label>		
							<input type="hidden" id="filter_range_income_hidden" value=""/>	
							<?php $listfilter = array("ทั้งหมด","100,000-300,000","300,000-500,000","500,000 ขึ้นไป");?>
							<select id="filter_range_income" name="filter_range_income">
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
						
						
						<div class="container-fluid col-md-5 col-xs-12"  style="margin-top: 6px;">				
							<label for="filter_plant">ชนิดพืช: </label>		
							<input type="hidden" id="filter_plant_hidden" value=""/>
							<?php $all_plants = getAllPlantTypes();?>
							<?php 
								$plan_name = array();
				
								$i = 1;
								$plan_name[$i] = "ข้าวหอมมะลิ";  $i++;
								$plan_name[$i] = "ข้าวเหนียว"; $i++;
								$plan_name[$i] = "ข้าวจ้าว";  $i++;
								$plan_name[$i] = "มันสำปะหลัง"; $i++;
								$plan_name[$i] = "ปาล์มน้ำมัน"; $i++;
								$plan_name[$i] = "ยางพารา";  $i++;
								$plan_name[$i] = "ลำไย"; $i++;
								$plan_name[$i] = "ทุเรียน";  $i++;
								$plan_name[$i] = "มังคุด";  $i++;
								$plan_name[$i] = "สับปะรด";  $i++;
								$plan_name[$i] = "ถั่วเหลือง";  $i++;
								$plan_name[$i] = "ข้าวโพดเลี้ยงสัตว์"; $i++;
								$plan_name[$i] = "อ้อย";  $i++;
							?>
							<select id="filter_plant" name="filter_plant">
								<option></option>
								<?php foreach ($plan_name as $k=>$plant):
										$selected = "";
										if ($k==1)
											$selected = "selected=\"selected\"";
									?>
									<option <?php echo $selected ?> value="<?php echo $k?>"><?php echo $plant?></option>
								<?php endforeach?>
							</select>

						</div>
					</form>

					
					</div>
				</div>
						
				
				<div id="myProgress" class="display">
					  <div id="myBar">0%</div>
				</div>
				<div class="row">
				

 								 
				
					<br/>
					<div class="panel panel-success">
					    <div class="panel-heading">
					        <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i> รายงานการปลูกพืชทั่วประเทศไทย  <?php echo $filter_year?></h3>
					    </div>
					    <div class="panel-body">
							<div class="row" id="save">
								<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right; margin-right: 20px;" disabled  />
						    </div>
						    <h4><center>พบข้อมูลตามเงื่อนไข <span id="total_chart_div"></span> จำนวน  จากทั้งหมด  <span id="total_all"></span> แถว</center></h4>
						    <div style="display: inline-flex; width:100%" >
						    	<div style="width: 70%;">
							    	<div id="regions_div" style="width: 100%; height: 500px;"></div>
							    </div>
							    <div style="width: 30%;">
						        	<div id="regions_div_table" style="width: 100%; height: 500px;"></div>
						        </div>
						    </div>
					        
					    </div>
					</div>
				
				
					<!-- ส่วนแสดง Grid View -->
					
<!-- 					<div class="panel panel-danger"> -->
<!-- 					    <div class="panel-heading"> -->
<!-- 					        <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i> รายงานการปลูกพืชทั่วประเทศไทย 2561</h3> -->
<!-- 					    </div> -->
<!-- 					    <div class="panel-body"> 
					       <div id="regions_div_table" style="width: 100%; height: 500px;"></div>
<!-- 					    </div> -->
<!-- 					</div>		 -->
				
				
				
				
				</div>
				
				
			</div>
		</div>
	
	</div>

</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
					
					<script type="text/javascript">
					  google.charts.load('current', {'packages': ['geochart','table']});
					    function drawRegionsMap(count,countall,status,filter_year,filter_province_name,filter_range_income_name,filter_plant_name,key,dataTable) {
					    	filter_year = Number(filter_year)+543;
					        var data = new google.visualization.arrayToDataTable(data_json);
							var options;

							
							if(status){
								options = {
					            region: 'TH',
					            resolution: 'provinces',
// 					            displayMode: 'markers',
								colorAxis: {colors: ['#FFFFFF', '#FFFFFF','#FFFFFF','#FFFFFF', '#FFFFFF', '#FFFFFF']}
					        	};
							}else{
								options = {
					            region: 'TH',
					            resolution: 'provinces',
					            // displayMode: 'markers',
					            colorAxis: {colors: ['#FFFFFF', 'yellow','#9ACD32','#eefdec', '#008000', '#006400']}
								};
							}

							var data_table = new google.visualization.DataTable();
							data_table.addColumn('string', key[0]);
							data_table.addColumn('number', key[1]);
// 					        data.addRows(data_json);
// 					        var list_text_pdf = [[key,key,key]];
					        var list_text_pdf =[];
					        
					        
					        for (let elem in dataTable)
					        {
// 					        	if(dataTable[elem] !=0){
								
					        		data_table.addRows([[elem,{v:dataTable[elem],}]]);
// 					        	}
					        }
					        
					        var count = 0;
					        var temp_data=[];
					        for(let elem in dataTable)
					        {

					        	
					        	
					        	
					        	if (count%7==0 && count !=0)
					        	{
						        	list_text_pdf.push(temp_data);
						        	temp_data =[];
					        		
					        	}
					        	temp_data.push(elem+' - '+dataTable[elem]);
					        	count++;
					        }
					        if(temp_data.length !=7 && temp_data.length !=0)
					        {
					        	console.log(temp_data);
					        	var length = 7-temp_data.length;
					        	
					        	
					        	for(var i = 0; i<length;i++)
					        	{
					        		temp_data.push('');
					        	}
					        	list_text_pdf.push(temp_data);
					        }
					        
					        
					        
					        
					        
					        
					       console.log(list_text_pdf);
					        var table = new google.visualization.Table(document.getElementById('regions_div_table'));

					        table.draw(data_table, {showRowNumber: true, width: '100%', height: '100%'});
							
							
					        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
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
			    				if(filter_range_income_name == "ทั้งหมด"){
			    					filter_range_income_name = filter_range_income_name+"";	
			    				}else
			    					filter_range_income_name = filter_range_income_name+" บาท";	
					    		var docDefinition = { 
					    				content: [
					    					{
					    						text: 'รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด',
					    						alignment: 'center',
					    						style: 'header'
					    					},
					    					{
					    						text: 'ตามเงื่อนไขปี ' +filter_year+ ' จังหวัด' +filter_province_name+ ' ช่วงรายได้ '+filter_range_income_name,						
					    						alignment: 'center',
					    						style: 'header',						
					    					},					
					    					{
					    						text: 'แบ่งข้อมูลตาม'+filter_plant_name+' พบข้อมูล ' +count+ ' จำนวน จากข้อมูลทั้งหมด ' +countall+ ' แถว',						
					    						alignment: 'center',
					    						style: 'header',
					    						margin : [0,0,0,20],
					    					},	
					    					{
					    						image: uri,
					    						alignment: 'center',
			    								width: 600 * 0.7487922705314,
			    								margin : [0,0,0,20],
					    					},
					    					{
					    						style: 'tableExample',
					    						alignment: 'center',
			    								headerRows: 1,
			    								margin : [20,0,0,20],
			    								table: {
			    									body:list_text_pdf
			    								}
					    					},
// 					    					{
// 					    						alignment: 'center',
// 					    						columns: [
// 					    							{
// 					    								image: uri,
// 							    						alignment: 'center',
// 					    								width: 600 * 0.7487922705314,
// 					    							},
// 					    							{
// 					    								style: 'tableExample',
// 					    								headerRows: 1,
// 					    								table: {
// 					    									body:list_text_pdf
// 					    								}
// 					    							}
// 					    							]
					    						
					    						
					    						
// 					    					},
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
					    						fontSize: 20,
					    						bold: true
					    					},
					    					footer :{
					    						fontSize: 15,
					    						font: 'THSarabunNew'
					    					}
					    					
					    				},
					    					
					    				

					    		};
					    		pdfMake.createPdf(docDefinition).download('รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด.pdf');

							
					    		
					    	  },false);

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
					    	  
					        chart.draw(data, options);
					    }
					     
						
						var btn_name;
						var count = 0;
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
						$('#filter_plant').each(function( index ) {
							$(this).select2({
								  placeholder: "เลือกชนิดพืช"
								});
						});
						$('#filter_range_income').each(function( index ) {
							$(this).select2({
								  placeholder: "เลือกช่วงรายได้"
								});
						});
						
						
						var data_json=[];
						$(function ()
						{
							$('#search-analytic').submit(function ()
									{
										var filter_year = $('#filter_year').val(); 
										var filter_province_hidden =	$('#filter_province').val();
										var filter_range_income_hidden = $('#filter_range_income').val();
										var filter_plant =	$('#filter_plant').val();
										
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
										if(typeof filter_plant == 'undefined')
										{
											filter_plant = "";
										}
									
										console.log(filter_year);
						// 				call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden);
										call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden,filter_plant);
						
										return false;
								});
						});
						load_default();
						function load_default()
						{
							var filter_year = $('#filter_year').val(); 
							var filter_province_hidden =	$('#filter_province').val();
							var filter_plant =	$('#filter_plant').val();
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
							if(typeof filter_plant == 'undefined' ||  filter_plant=='0')
							{
								filter_plant = "";
							}
						
							call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden,filter_plant);
						}
						function call_ajax(filter_year,filter_province_hidden,filter_range_income_hidden,filter_plant)
						{
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
								url:'<?php echo site_url('ReportAnalytic/count_plant_all') ?>',
										dataType:'json',
										type:'GET',		
										data:{filter_year:filter_year,filter_province_hidden:filter_province_hidden,filter_range_income_hidden:filter_range_income_hidden,filter_plant:filter_plant},
										success:function (result) {
											count = result.count;
											data_json =  [result.key];
											for (let elem in result.data)
						    				{
						    					data_json.push([elem+'',result.data[elem]]);
						    				}
											var status = result.validate;

											var old_element = document.getElementById("save-pdf");
											var new_element = old_element.cloneNode(true);
											old_element.parentNode.replaceChild(new_element, old_element);
						
											var filter_province_name = $('#filter_province option:selected').text();
											var filter_range_income_name = $('#filter_range_income option:selected').text();
											var filter_plant_name = $('#filter_plant option:selected').text();
											
											 $('#regions_div').html('');
											 
											
						
										 	if(result.count !== 0){	
												 google.charts.setOnLoadCallback(function(){drawRegionsMap(result.count,result.countall,status,filter_year,filter_province_name,filter_range_income_name,filter_plant_name,result.key,result.data)});
// 													console.log(result.key[1]);
// 												 google.charts.setOnLoadCallback(function(){drawTable(result.key,result.data)});
											}else{
												$('#regions_div').empty();
												$('#regions_div_table').empty();
												$('#save-pdf').prop('disabled', true);
											}
						// 					google.charts.setOnLoadCallback(drawRegionsMap);
						
											
											$('#total_chart_div').html(result.count);
											$('#total_all').html(result.countall);
											clearInterval(id);
									        elem.style.width = 100 + '%'; 
									        elem.innerHTML = 100  + '%';	
									        $('#btn-search').prop('disabled', false);
										}
								});
						}




</script>


