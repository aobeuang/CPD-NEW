<?php
$this->load->helper('survey');
?>


<div id="report" class="nonmis">

	<div id="main-wrapper">
		<div id="main-container" class="container-fluid col-md-12 col-xs-12">
			<center><h2 style="text-align:center"><span class="glyphicon glyphicon-signal"></span> รายงานสมาชิกที่ทำธุรกิจกับสหกรณ์แยกตามประเภท</h2></center>
			
<!-- 			<div id="left-container" class="col-md-3 col-xs-12"> 
			<ul class="list-group"> 
				<li class="list-group-item "><a href="<?php echo site_url('report1/index1')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลทั่วไป</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index2')?>"><i class="fa fa-caret-right"></i> รายงานพื้นที่ครอบครอง</a></li>
				<li class="list-group-item "><a href="<?php echo site_url('report1/index3')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการผลิตทางการเกษตรในรอบปีที่ผ่านมา</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index4')?>"><i class="fa fa-caret-right"></i> รายงานปัญหาที่พบในการประกอบอาชีพ</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index5')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลหนี้สิน จำนวนลูกหนี้ และยอดหนี้สิน</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index6')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการผลิตปีปัจจุบัน</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index7')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการเลี้ยงโคนม</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index8')?>">รายงานข้อมูลผลไม้</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index9')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลพันธ์ข้าว</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index10')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการใช้ปุ๋ย</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report1/index11')?>"><i class="fa fa-caret-right"></i> รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</a></li>
			</ul>				
			</div> -->
			
			<?php $data = getTotalCoopReport();
			
			
			
			
			$list_type1 = array();
			foreach ($data as $item)
				{
					if(!isset($list_type[$item['ORG_NAME']]))
					{
						$list_type[$item['ORG_NAME']]['1'] =0;
						$list_type[$item['ORG_NAME']]['2'] =0;
						$list_type[$item['ORG_NAME']]['3'] =0;
						$list_type[$item['ORG_NAME']]['4'] =0;
						$list_type[$item['ORG_NAME']]['5'] =0;
						$list_type[$item['ORG_NAME']]['6'] =0;
						$list_type[$item['ORG_NAME']]['7'] =0;
					}
					if($item['COOP_TYPE'] == '1')
					{
						$list_type[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
					if($item['COOP_TYPE'] == '2')
					{
						$list_type[$item['ORG_NAME']]['2']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
					if($item['COOP_TYPE'] == '3')
					{
						$list_type[$item['ORG_NAME']]['3']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
					if($item['COOP_TYPE'] == '4')
					{
						$list_type[$item['ORG_NAME']]['4']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
					if($item['COOP_TYPE'] == '5')
					{
						$list_type[$item['ORG_NAME']]['5']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
					if($item['COOP_TYPE'] == '6')
					{
						$list_type[$item['ORG_NAME']]['6']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
					if($item['COOP_TYPE'] == '7')
					{
						$list_type[$item['ORG_NAME']]['7']= is_numeric($item['TOTAL_COOP'])?intval($item['TOTAL_COOP']):0;
					}
				}
				
// 				ksort($list_type);
			
				$list = json_encode($list_type);
				
	?>
			
			<div id="right-container" class="col-md-12 col-xs-12">
				
				<div class="row" id="action-bar">
					<div class="report-action-bar">

						<form action="" method="GET">
						
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
					        <input type="radio" id="in_coop" name="type_coop" <?php if($type_coop == '0') echo "checked";?>  value="0"/>
					        <label for="in_coop">แยกเป็นภาคการเกษตร</label>
					    </div>
						
						<div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 6px;">
					        <input type="radio" id="out_coop" name="type_coop" <?php if($type_coop == '1') echo "checked";?> value="1"/>
					        <label for="out_coop">แยกเป็นนอกภาคการเกษตร</label>
					    </div>
					    
					    
					    <div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 13px;">
							<label for="filter_district">เขตตรวจราชการ: </label>
							<input type="hidden" id="filter_khet_hidden" value=""/>
							<select id="filter_khet" name="filter_khet">
								<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>
							</select>
						</div>
						
						<div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 13px;">				
							<label for="filter_province">จังหวัด: </label>		
							<input type="hidden" id="filter_province_hidden" value=""/>
							<?php $all_provinces = getAllProvinces();?>
							<select id="filter_province" name="filter_province">
								<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>
							</select>

						</div>
					    
					    
						
						
					
						
												
						<div class="container-fluid col-md-1 col-xs-12" class="search-report-button" >
							<button class="btn btn-outline-purple" ><span class="glyphicon glyphicon-search"></span> ค้นหา</button>		
						</div>
						
						
						
					</form>

					
					</div>
				</div>
				
					<div class="row" id ="save">
					<div class="actions" style="float:right">
			    		<script>
							function downloadExcel()
							{
								window.location = '<?php echo (!empty($export_url))?$export_url:"#"; ?>';
							}
			    		</script>
			    		
		                
		                <input id="save-pdf"  class="btn btn-default t5" type="button" value="Save as PDF" disabled  />
			    	
			    		
				    </div>		
			    
			    	</div>
				
				<div>
					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
SELECT COOP_INFO.ORG_ID,COOP_INFO.ORG_NAME,COOP_INFO.REGISTRY_NO_2,
			COOP_INFO.COOP_TYPE,COOP_INFO.COOP_TYPE_NAME,COOP_INFO.PROVINCE_ID,COOP_INFO.PROVINCE_NAME,a.TOTAL_COOP
FROM COOP_INFO 
LEFT JOIN (
     select  IN_D_COOP ,count(IN_D_COOP) as TOTAL_COOP 
     from moiuser.master_data 
     where moiuser.master_data.NUMBER_OF_COOP in (1,2,3,4,5,6,7,8,9,10)
     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
------------------------------------------------------------------------------------------------------
select sum(TOTAL_COOP),COOP_TYPE,ORG_ID from REPORT3 group by ORG_ID,COOP_TYPE order by org_id
					</textarea>
				
				</div>
				
				
				
				
				<div class="row"> 		
				 	<div id="dual_x_div" style="width: 1200px; height: 8000px;"></div>  
					
				</div>
				
				
			</div>
		</div>
	
	</div>

</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>
google.charts.load('current', {'packages':['bar',"corechart"]});

<?php if ($type_coop == '0') { ?>
	google.charts.setOnLoadCallback(drawType1);
<?php } else if($type_coop == '1') { ?>
	google.charts.setOnLoadCallback(drawType2);
<?php }?>

function drawType1() {

	var data_coop = [['เขตตรวจราชการ', 'สหกรณ์การเกษตร', 'สหกรณ์ประมง', 'สหกรณ์นิคม']];
	
	var list = JSON.parse('<?php print_r($list);?>');
	console.log(list);
	for (var key in list )
	{
		var temp = [];
		temp.push(key+'',list[key][1],list[key][2],list[key][3]);
		data_coop.push(temp);
	}
	
	console.log(data_coop);
	       

	var data = google.visualization.arrayToDataTable(data_coop);
	var view = new google.visualization.DataView(data);
	view.setColumns([0, 1,
			{ calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation" },
          2,{ calc: "stringify",
              sourceColumn: 2,
              type: "string",
              role: "annotation" },3,{ calc: "stringify",
                  sourceColumn: 3,
                  type: "string",
                  role: "annotation" }        ]);
    var options = {
      width: 1000,
      chart: {
        title: 'Nearby galaxies',
        subtitle: 'distance on the left, brightness on the right'
      },
      bars: 'horizontal', // Required for Material Bar Charts.
      bar: {groupWidth: "95%"},
      legend: { position: 'top', maxLines: 3 },
      
      series: {
        0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
        1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
      },
      axes: {
        x: {
          distance: {label: 'parsecs'}, // Bottom x-axis.
          brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
        }
      }
    };
  
 
  
  var chart_div = document.getElementById('dual_x_div');
  var chart = new google.visualization.BarChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
	  google.visualization.events.addListener(chart, 'ready', function () {
		    btnSave.disabled = false;
		  });
	btnSave.addEventListener('click', function () {
		    var doc = new jsPDF();
		    doc.addImage(chart.getImageURI(), 0, 0);		    
		    doc.save('chart.pdf');
		  }, false);
	chart.draw(view,options);  
  
};

function drawType2() {

	var data_coop = [['เขตตรวจราชการ', 'สหกรณ์ออมทรัพย์', 'สหกรณ์ร้านค้า', 'สหกรณ์บริการ','สหกรณ์เครดิตยูเนี่ยน']];
	
	var list = JSON.parse('<?php print_r($list);?>');
	console.log(list);
	for (var key in list )
	{
		var temp = [];
		temp.push(key+'',list[key][4],list[key][5],list[key][6],list[key][7]);
		data_coop.push(temp);
	}
	
	console.log(data_coop);
	       

	var data = google.visualization.arrayToDataTable(data_coop);
	var view = new google.visualization.DataView(data);
	view.setColumns([0, 1,
			{ calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation" },
          2,{ calc: "stringify",
              sourceColumn: 2,
              type: "string",
              role: "annotation" },3,{ calc: "stringify",
                  sourceColumn: 3,
                  type: "string",
                  role: "annotation" },4,{ calc: "stringify",
                      sourceColumn: 3,
                      type: "string",
                      role: "annotation" }       ]);
    var options = {
      width: 1000,
      chart: {
        title: 'Nearby galaxies',
        subtitle: 'distance on the left, brightness on the right'
      },
      bars: 'horizontal', // Required for Material Bar Charts.
      bar: {groupWidth: "95%"},
      legend: { position: 'top', maxLines: 3 },
      
      series: {
        0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
        1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
      },
      axes: {
        x: {
          distance: {label: 'parsecs'}, // Bottom x-axis.
          brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
        }
      }
    };
  
 
  
  var chart_div = document.getElementById('dual_x_div');
  var chart = new google.visualization.BarChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
	  google.visualization.events.addListener(chart, 'ready', function () {
		    btnSave.disabled = false;
		  });
	btnSave.addEventListener('click', function () {
		    var doc = new jsPDF();
		    doc.addImage(chart.getImageURI(), 0, 0);		    
		    doc.save('chart.pdf');
		  }, false);
	chart.draw(view,options);  
  
};




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

$('#filter_type_coop').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกประเภท"
		});
});
$('#filter_khet').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกเขตตรวจราชการ"
		});
});
$('#filter_province').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกจังหวัด"
		});
});

function getlistkhet()
{
	$.ajax(
	{
		url:'/index.php/report2/getlistKhet',
		dataType: 'json',
		success:function(result){
			console.log('getlistkhet');
			console.log(result.items);

			var html ='<option></option>';

			for(var i = 0;i<result.items.length;i++)
				{
// 				if(i==0){
// 					html +='<option selected value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
// 					$("#filter_khet_hidden").val(result.items[i].COL004);
// 					}else 
						if(result.items[i].COL004 >=20){
						html +='<option value="'+result.items[i].COL004+'">'+result.items[i].COL012+'</option>';
						}else{
						html +='<option value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
						}
				}
			$('#filter_khet').html(html);

			getlistProvine();
				
			
			}
			
	});
}
function getlistProvine()
{

	var khet = $('#filter_khet_hidden').val();
	$.ajax({
		url:'/index.php/report2/getlistProvince',
		dataType:'json',
		data:{khet:khet},
		success:function(result){
			console.log("filter_khet_hidden");
			console.log(result.items);
			var html ='<option></option>';
			for(var i=0;i<result.items.length;i++)
			{
// 				if(i==0){
// 					html +='<option  value="'+result.items[i].name+'" selected>'+result.items[i].name+'</option>';

// 					$("#filter_province_hidden").val(result.items[i].name);
// 					}else{
						html +='<option value="'+result.items[i].name+'">'+result.items[i].name+'</option>';
// 						}
				
				
			}
			$('#filter_province').html(html);	

// 			getlistCoop();		
		}

		});
}

$( "#filter_khet" ).change(function() {
	$('#filter_coop').trigger('change.select2');
	$('#filter_province').val('');
	$('#filter_province_hidden').val('');
	
	$('#filter_province').trigger('change.select2');
	$('#filter_coop').val('');
	$('#filter_coop_hidden').val('');
	$('#filter_district').trigger('change.select2');
	$('#filter_district').val('');
	$('#filter_district_hidden').val('');
	$('#filter_tambom').trigger('change.select2');
	$('#filter_tambom').val('');


	
	
	$('#filter_khet_hidden').val($('#filter_khet').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_province')?>/'+$('#filter_province_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	

	getlistProvine();

});

getlistkhet();
</script>


