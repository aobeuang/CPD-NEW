<?php
$this->load->helper('survey');
?>

<style type="text/css">
#dual_x_div {
    float:left;
    width:1100px;
    height:650px;
    
    text-align:center;
}


#report #right-container{
	padding-left :0px!important;
}
</style>
<div id="report" class="mis">

	
	
	<script>
	jQuery(function () {
	    // remove the below comment in case you need chnage on document ready
	    // location.href=jQuery("#selectbox").val(); 
	    jQuery("#survey_year").change(function () {
	        location.href = '<?php echo site_url('survey/selectSurveyYear')?>/'+jQuery(this).val();
	    })
	})
	</script>
	<div id="main-wrapper">
		<div id="main-container" class="container-fluid col-md-12 col-xs-12">
			
			
			<?php $data = getTotalCoopReport_Test();
			$list_type_no_dead = array();
			$list_type_dead = array();
			$list_total_type1 = 0;
			$list_total_type2 = 0;
			$list_total = array();
			$total_no_dead_type1 = 0;
			$total_no_dead_type2 = 0;
			$total_no_dead_type3 = 0;
			$total_no_dead_type4 = 0;
			$total_no_dead_type5 = 0;
			$total_no_dead_type6 = 0;
			$total_no_dead_type7 = 0;
			
			$total_dead_type1 = 0;
			$total_dead_type2 = 0;
			$total_dead_type3 = 0;
			$total_dead_type4 = 0;
			$total_dead_type5 = 0;
			$total_dead_type6 = 0;
			$total_dead_type7 = 0;
			$list_type_in_out = array();
		
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
						$list_type_no_dead[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['1'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type1 = $total_no_dead_type1 + $list_type_no_dead[$item['ORG_NAME']]['1'];
						$total_dead_type1 = $total_dead_type1 + $list_type_dead[$item['ORG_NAME']]['1'];
						
						
					}
					if($item['COOP_TYPE'] == '2')
					{
						$list_type_no_dead[$item['ORG_NAME']]['2'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['2'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type2 = $total_no_dead_type2+ $list_type_no_dead[$item['ORG_NAME']]['2'];
						$total_dead_type2 = $total_dead_type2 + $list_type_dead[$item['ORG_NAME']]['2'];
					}
					if($item['COOP_TYPE'] == '3')
					{
						$list_type_no_dead[$item['ORG_NAME']]['3'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['3'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type3 = $total_no_dead_type3+ $list_type_no_dead[$item['ORG_NAME']]['3'];
						$total_dead_type3 = $total_dead_type3+ $list_type_dead[$item['ORG_NAME']]['3'];
					}
					if($item['COOP_TYPE'] == '4')
					{
						$list_type_no_dead[$item['ORG_NAME']]['4'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['4'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type4 = $total_no_dead_type4 + $list_type_no_dead[$item['ORG_NAME']]['4'];
						$total_dead_type4 = $total_dead_type4 + $list_type_dead[$item['ORG_NAME']]['4'];
					}
					if($item['COOP_TYPE'] == '5')
					{
						$list_type_no_dead[$item['ORG_NAME']]['5'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['5'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type5 = $total_no_dead_type5+ $list_type_no_dead[$item['ORG_NAME']]['5'];
						$total_dead_type5 = $total_dead_type5 + $list_type_dead[$item['ORG_NAME']]['5'];
					}
					if($item['COOP_TYPE'] == '6')
					{
						$list_type_no_dead[$item['ORG_NAME']]['6'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['6'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type6= $total_no_dead_type6 + $list_type_no_dead[$item['ORG_NAME']]['6'];
						$total_dead_type6 = $total_dead_type6 + $list_type_dead[$item['ORG_NAME']]['6'];
					}
					if($item['COOP_TYPE'] == '7')
					{
						$list_type_no_dead[$item['ORG_NAME']]['7'] = is_numeric($item['TOTAL_COOP_NOT_DEAD'])?intval($item['TOTAL_COOP_NOT_DEAD']):0;
						$list_type_dead[$item['ORG_NAME']]['7'] = is_numeric($item['TOTAL_COOP_DEAD'])?intval($item['TOTAL_COOP_DEAD']):0;
						$total_no_dead_type7 = $total_no_dead_type7 + $list_type_no_dead[$item['ORG_NAME']]['7'];
						$total_dead_type7 = $total_dead_type7 + $list_type_dead[$item['ORG_NAME']]['7'];
					}
				}
				
				
				
				$list_type_in_out['สหกรณ์การเกษตร']['ALIVE'] = $total_no_dead_type1;
				$list_type_in_out['สหกรณ์ประมง']['ALIVE']= $total_no_dead_type2;
				$list_type_in_out['สหกรณ์นิคม']['ALIVE']= $total_no_dead_type3;
				$list_type_in_out['สหกรณ์ออมทรัพย์']['ALIVE']= $total_no_dead_type4;
				$list_type_in_out['สหกรณ์ร้านค้า']['ALIVE']= $total_no_dead_type5;
				$list_type_in_out['สหกรณ์บริการ']['ALIVE']= $total_no_dead_type6;
				$list_type_in_out['สหกรณ์เครดิตยูเนี่ยน']['ALIVE']= $total_no_dead_type7;
				
				$list_type_in_out['สหกรณ์การเกษตร']['DEAD'] = $total_dead_type1;
				$list_type_in_out['สหกรณ์ประมง']['DEAD']= $total_dead_type2;
				$list_type_in_out['สหกรณ์นิคม']['DEAD']= $total_dead_type3;
				$list_type_in_out['สหกรณ์ออมทรัพย์']['DEAD']= $total_dead_type4;
				$list_type_in_out['สหกรณ์ร้านค้า']['DEAD']= $total_dead_type5;
				$list_type_in_out['สหกรณ์บริการ']['DEAD']= $total_dead_type6;
				$list_type_in_out['สหกรณ์เครดิตยูเนี่ยน']['DEAD']= $total_dead_type7;
				
				
				
				

				$list_in_out = json_encode($list_type_in_out);
				$total = 0;
				
			?>
			<h2><span class="glyphicon glyphicon-stats"></span> รายงานจำนวนสถานะภาพสมาชิกสหกรณ์ (ในภาค-นอกภาคการเกษตร)</h2>
			
			<div class="row" id ="save">
				<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" onclick="downloadExcel();" />
		    </div>				
			
			<div id="right-container" class="col-md-12 col-xs-12">
				<div class="row">
					<div class="actions" style="float:right">
			    		<script>
							function downloadExcel()
							{
								window.location = '<?php echo (!empty($export_url))?$export_url:"#"; ?>';
							}
			    		</script>
			    		
				    </div>	
			    </div>
				
				<div class="row"> 
						<center><h2  class="report-title-center" style="text-align:center">รายงานจำนวนสถานะภาพสมาชิกสหกรณ์ (ในภาค-นอกภาคการเกษตร)</h2></center>	
						<center><h4>จำนวนสมาชิกของสหกรณ์ <?php echo number_format($total);?> คน</center></h4>
				 		<div id="dual_x_div"></div>				 		
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
			</div>
		</div>
	
	</div>

</div>

<center><h4>รายการแสดงผลไฟล์ PHP</center></h4>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>
google.charts.load('current', {'packages':['bar',"corechart"]});

google.charts.setOnLoadCallback(drawType1);


function drawType1() {

	var data_coop = [['ประเภท', 'จำนวนสมาชิกปกติ','จำนวนสมาชิกตาย']];
	
	var list = JSON.parse('<?php print_r($list_in_out);?>');
// 	console.log(list[key]['ALIVE']);
	for (var key in list )
	{
		var temp = [];
		temp.push(key+'',list[key]['ALIVE'],list[key]['DEAD']);
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
                       2
                       ,{ calc: "stringify",
                           sourceColumn: 2,
                           type: "string",
                           role: "annotation" }
                     ]);
	var options = {
	        title: 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท',
	        
	        width: 1100,
       	 	height: 575,
	      };
  var chart_div = document.getElementById('dual_x_div');
  var chart = new google.visualization.ColumnChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
	  google.visualization.events.addListener(chart, 'ready', function () {
		    btnSave.disabled = false;
		  });
	btnSave.addEventListener('click', function () {
		 var doc = new jsPDF({orientation: 'landscape'});
		    doc.addImage(chart.getImageURI(), 0, 0);		    
		    doc.save('chart.pdf');
		  }, false);
	chart.draw(view,options);  
};


</script>


