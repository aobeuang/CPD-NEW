<?php
$this->load->helper('survey');
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style type="text/css">
/*#dual_x_div {
   	float: left;
    width:50%;
    height:auto;
    text-align:center;
}
#dual_y_div {
    float: left;
    width:50%;
    height:auto;
    text-align:center;
}*/
#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
#report #right-container{
	padding-left :0px!important;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
			<!-- <h2><span class="glyphicon glyphicon-stats"></span> รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร)</h2> -->
			
			<!-- 
			<div id="left-container" class="col-md-3 col-xs-12">
			<ul class="list-group">
				<li class="list-group-item active"><a href="<?php echo site_url('report3/index1')?>">รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร)</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index2')?>"><i class="fa fa-caret-right"></i> รายงานจำนวนสมาชิกสหกรณ์ ภาคเกษตร</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index3')?>"><i class="fa fa-caret-right"></i> รายงานจำนวนสมาชิกสหกรณ์ นอกภาคเกษตร</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index6')?>"><i class="fa fa-caret-right"></i> รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index17')?>"><i class="fa fa-caret-right"></i> รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index12')?>"><i class="fa fa-caret-right"></i> รายงานจำนวนสมาชิกสหกรณ์ ที่เป็นสมาชิก มากกว่า 1 แห่ง</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index5')?>"><i class="fa fa-caret-right"></i> รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index15')?>"><i class="fa fa-caret-right"></i> รายงานสถานภาพสมาชิกสหกรณ์ (โดยนับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index10')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการเลี้ยงสัตว์</a></li>
				<li class="list-group-item"><a href="<?php echo site_url('report3/index11')?>"><i class="fa fa-caret-right"></i> รายงานข้อมูลการทำประมง</a></li>
			</ul>			
			</div> -->			
			
			<div class="report-result">
			
				
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
			   <!-- <div id="myProgress" class="display">
					  <div id="myBar">0%</div>
				</div> -->
				<div style="position: relative;">
					<!-- <input id="save-pdf"  class="btn btn-save-dl  t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" onclick="downloadExcel();" /> -->
					<a onclick="downloadExcel();" id="save-pdf" class="btn btn-save-dl floatR" style="position: absolute;right: 15px;">
						<img  src="<?php $this->load->helper('properties_helper');
		     	 			print_r(getStringSystemProperties("icon-excel", "/assets/default/images/pdf-file-format-symbol-FFFFFF.png"))?>">
						<span class="btn-text hidden-xs">บันทึกเป็น PDF</span>
					</a>
					<h2 class="report-title-center"><center>รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร)</center></h2>
					<h4><center>จำนวนสมาชิกของสหกรณ์  <span id="total"></span> คน</center></h4>
			    </div>	
					
				<div class="row" id="canvas">
			 		<div class="col-md-6"><div class="gchart_wrap"><div class="gchart_div" id="dual_x_div"></div></div></div>
			 		<div class="col-md-6"><div class="gchart_wrap"><div class="gchart_div" id="dual_y_div"></div> </div></div>
				</div>
		 		<p id="datethai" class="text-right r20"> </p>
			
				
				
<!-- 			<div> 
					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
SELECT COOP_INFO.ORG_ID,COOP_INFO.ORG_NAME,COOP_INFO.REGISTRY_NO_2,
			COOP_INFO.COOP_TYPE,COOP_INFO.COOP_TYPE_NAME,COOP_INFO.PROVINCE_ID,COOP_INFO.PROVINCE_NAME,a.TOTAL_COOP
FROM COOP_INFO 
LEFT JOIN (
     select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP 
     from moiuser.master_data 
     where moiuser.master_data.NUMBER_OF_COOP in (1,2,3,4,5,6,7,8,9,10)
     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
------------------------------------------------------------------------------------------------------
select sum(TOTAL_COOP),COOP_TYPE,ORG_ID from REPORT3 group by ORG_ID,COOP_TYPE order by org_id
					</textarea>
				
				</div> -->
			</div>
	</div>

</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>
google.charts.load('current', {'packages':['bar',"corechart"]});
var  listdawr ;
//var imageuri;

var now = new Date(); 
var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
"ตุลาคม","พฤศจิกายน","ธันวาคม");
var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
$('#datethai').html(datethai);

var options = {
    title: 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท',
    width: '100%',
   	height: '100%',
   	fontName:'Kanit',
   	titleTextStyle: {
   	 	color: '#455A64',
	    fontSize: 16
   	},
   	chartArea: {
      	width: '90%',
      	height: '70%'
    },
    slices: {
		0: { color: '#6588C4' },
		1: { color: '#D5702C' },
		2: { color: '#56978c' },
		3: { color: '#FFBF00' },
		4: { color: '#7B749B' },
		5: { color: '#a971a7' },
		6: { color: '#70AB46' },
		7: { color: '#35507F' },
		8: { color: '#FFAEDB' },
		9: { color: '#A3A3A3' },
	},
	tooltip: { 
		isHtml: true, 
		trigger: 'selection' 
	},
};
var chart1,chart2;
function drawType1() {

	var data_coop = [['ประเภท', 'จำนวนสมาชิก']];

	console.log(listdawr.list);

	for(var i=0;i<listdawr.list.length;i++)
	{
		
		var temp = [];
		temp.push(listdawr.list[i].name+'',listdawr.list[i].value);
		data_coop.push(temp);
	}

	
// 	console.log(list);
// 	for (var key in listdawr.list )
// 	{
// // 		
// 		var temp = [];
// 		temp.push(key+'',list[key]);
// 		data_coop.push(temp);
// 	}
	
  var data = google.visualization.arrayToDataTable(data_coop);
	
  var chart_div = document.getElementById('dual_x_div');
  chart1 = new google.visualization.PieChart(chart_div);
  var btnSave = document.getElementById('save-pdf');
  
  google.visualization.events.addListener(chart1, 'ready', function () {
	    btnSave.disabled = false;
	   
	  });
	btnSave.addEventListener('click', function () {
		var uri =  chart1.getImageURI();
		var imageuri =  chart2.getImageURI();
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
		var docDefinition = { 
				content: [
					{
						text: 'รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร)',
						alignment: 'center',
						style: 'header'
					},
					{
						text: 'จำนวนสมาชิกของสหกรณ์ '+listdawr.total.toLocaleString()+' คน',
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,30],
					},
					
					{
						image: uri,
						alignment: 'center',
						width: 440 * 0.7487922705314,
						
						
					},
					
					{
						image: imageuri,
						alignment: 'center',
						width: 440 * 0.7487922705314,
				       	 
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
				
				

		};
		pdfMake.createPdf(docDefinition).download('รายงานจำนวนสมาชิกสหกรณ์ (ภาคเกษตร-นอกภาคเกษตร).pdf');
	  }, false);
	
	chart1.draw(data,options);  
	
};



function drawType2() {
  try{
  	var data_coop = [['ประเภท', 'จำนวนสมาชิก']];
	
	console.log(listdawr.type);

	for(var i=0;i<listdawr.type.length;i++)
	{
		
		var temp = [];
		temp.push(listdawr.type[i].name+'',listdawr.type[i].value);
		data_coop.push(temp);
	}
	// console.log(data_coop);
	

	var data = google.visualization.arrayToDataTable(data_coop);
	
	options.title = 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท';
    
	var chart_div = document.getElementById('dual_y_div');
	chart2 = new google.visualization.PieChart(chart_div);

	chart2.draw(data,options); 
  }catch(err) {
  		console.log(err);
  }
	
};


$(document).ready(function() {
	/*var elem = document.getElementById("myBar");   
	var width = 10;
	var time = (((10*0.15)/100)+5)*10;
	var id = setInterval(frame, time);
	function frame() {
	  if (width >= 98) {
	    clearInterval(id);
	  } else {
	    width++; 
	    elem.style.width = width + '%'; 
	    elem.innerHTML = width * 1  + '%';
	    
	  }
	} */
	$('#pageLoading').fadeIn();
	$.ajax({
		url:"ajexreport1",
	    type:"GET",
	    dataType: 'json',
	    success:function(result){
			
			listdawr = result;
			$('#total').html(listdawr.total.toLocaleString());
			google.charts.setOnLoadCallback(drawType1);
 			google.charts.setOnLoadCallback(drawType2);
			/*clearInterval(id);
	        elem.style.width = 100 + '%'; 
	        elem.innerHTML = 100  + '%';*/
	        $('#pageLoading').fadeOut();
		},
		error: function(err){
			$('#pageLoading').fadeOut();
		}


	})  
});


</script>


