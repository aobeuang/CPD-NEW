<?php
$this->load->helper('survey');
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  margin: auto;
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
#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
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
			<h2><span class="glyphicon glyphicon-stats"></span> รายงานข้อมูลการเลี้ยงสัตว์</h2>
		
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
				
			
				
				<div id="myProgress" class="display">
					  <div id="myBar">0%</div>
				</div>
				
				<div class="row" id ="save">
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" onclick="downloadExcel();" />
				</div>	
				
				
				<center><h2  class="report-title-center" style="text-align:center">รายงานข้อมูลการเลี้ยงสัตว์</h2></center>
				<center><h4>จำนวนข้อมูลทั้งหมด  <span id="total"></span> แถว</center></h4>
				<div class="date" style="text-align:  center;"></div>
				
				<div class="row" id="canvas"> 
				 		<div id="dual_x_div" style="margin: auto;width: 900px;height: 500px;"></div>
						<right><p id="datethai" style="text-align:  right;font-size:  14px;"> </p></right>
					
				</div>
				
<!-- 				<div> 
					<textarea rows="12" cols="130" style="margin: 0px; width: 1000px; height: 150px;">
select  sum(TOT_ANN),TYPE_NAME from TA_MEMBER_AN where TYPE_ANN = 'เลี้ยงสัตว์' GROUP BY TYPE_NAME

select  count(TOT_ANN) from TA_MEMBER_AN where TYPE_ANN = 'เลี้ยงสัตว์' 
					</textarea>
					
				</div> -->
				
			</div>
		</div>
	
	</div>

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script>
google.charts.load('current', {'packages':['bar',"corechart"]});

var elem = document.getElementById("myBar");   
var width = 10;
var time = (((10*0.15)/100)+5)*10;
var id = setInterval(frame, time);
var listresult;

var now = new Date(); 
	var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
	"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
	"ตุลาคม","พฤศจิกายน","ธันวาคม");
	var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
	$('#datethai').html(datethai);
function drawType() {

	var data_coop = [['ประเภทสัตว์', 'จำนวนสัตว์(ตัว)']];
	
	
	for(var i=0;i<listresult.list_animal.length;i++)
	{
		var temp = [];
		temp.push(listresult.list_animal[i].name+'',listresult.list_animal[i].value);
		data_coop.push(temp);
	}
	
	var data = google.visualization.arrayToDataTable(data_coop);
	
	var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     ]);
	var options = {
	        title: 'จำนวนสัตว์เลี้ยงแบ่งตามชนิดต่างๆ ',
	        width: 800,
       	 	height: 500,
       	 bar: {groupWidth: "50%"}
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
		var docDefinition = { 
				content: [
					{
						text: 'รายงานข้อมูลการเลี้ยงสัตว์',
						alignment: 'center',
						style: 'header'
					},
					{
						text: 'จำนวนข้อมูลทั้งหมด '+listresult.total_animal['0']['ROW_ANN']+' แถว',
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,30],
					},
					
					{
						image: uri,
						alignment: 'center',
						width: 800 * 0.7487922705314,
						
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
		pdfMake.createPdf(docDefinition).download('รายงานข้อมูลการเลี้ยงสัตว์.pdf');
	  }, false);
	chart.draw(view,options);  


	clearInterval(id);
    elem.style.width = 100 + '%'; 
    elem.innerHTML = 100  + '%'; 
};
function frame() {
	  if (width >= 98) {
	    clearInterval(id);
	  } else {
	    width++; 
	    elem.style.width = width + '%'; 
	    elem.innerHTML = width * 1  + '%';
	    
	  }
	} 
$(document).ready(function() {
	$.ajax({
		url:"ajexreport10",
	    type:"GET",
	    dataType: 'json',
	    success:function(result){
			listresult = result;
			$('#total').html(listresult.total_animal['0']['ROW_ANN'].toLocaleString());
			google.charts.setOnLoadCallback(drawType);
		}
	}); 
});



</script>


