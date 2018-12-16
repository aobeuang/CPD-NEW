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
		<span>Page Code : MIS103</span>
		<div class="report-result">

            <?php
            if (isset($_SESSION['showSQL'])) {
                echo "<pre>
                         /* จำนวนสมาชิกสหกรณ์ นอกภาคเกษตรแบ่งตามประเภท  */
                          <span id='sql1'></span>
                        </pre>".
                    "<pre>
                         
                         /* จำนวนสมาชิกของสหกรณ์ */
                          <span id='sql2'></span>
                        </pre>"

                ;
            }
            ?>
			
			<!-- <h2><span class="glyphicon glyphicon-stats"></span> รายงานจำนวนสมาชิกสหกรณ์ ภาคเกษตร</h2> -->
			
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
				
				<!-- <div class="row" id ="save">
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" onclick="downloadExcel();" />
			    </div>	 -->
			    <div style="position: relative;">
			    <a onclick="downloadExcel();" id="save-pdf" class="btn btn-save-dl floatR" style="position: absolute;right: 15px;">
					<img  src="<?php $this->load->helper('properties_helper');
	     	 			print_r(getStringSystemProperties("icon-excel", "/assets/default/images/pdf-file-format-symbol-FFFFFF.png"))?>">
					<span class="btn-text hidden-xs">บันทึกเป็น PDF</span>
				</a>
				
			   	<h2  class="report-title-center" style="text-align:center"><center>รายงานจำนวนสมาชิกสหกรณ์ นอกภาคเกษตร</center></h2>
				<h4><center>จำนวนสมาชิกของสหกรณ์   <span id="total"></span> คน</center></h4>
				</div>
				<div class="row" id="canvas"> 
				 		<div class="col-md-offset-2 col-md-8"><div class="gchart_wrap"><div class="gchart_div" id="dual_x_div"></div></div></div>
				 		<div class="col-md-2"></div>
				</div>
				<p id="datethai" class="text-right r20"> </p>
				
<!-- 				<div> 
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

var listresult;
var elem = document.getElementById("myBar");   
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
} 
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

function drawType1() {

	var data_coop = [['ประเภท', 'จำนวนสมาชิก']];
	
	for(var i=0;i<listresult.list_in_out.length;i++)
	{
		
		var temp = [];
		temp.push(listresult.list_in_out[i].name+'',listresult.list_in_out[i].value);
		data_coop.push(temp);
	}


	var data = google.visualization.arrayToDataTable(data_coop);

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
		var docDefinition = { 
				content: [
					{
						text: 'รายงานจำนวนสมาชิกสหกรณ์ นอกภาคการเกษตร',
						alignment: 'center',
						style: 'header'
					},
					{
						text: 'จำนวนสมาชิกของสหกรณ์ '+listresult.list_total.toLocaleString()+' คน',
						alignment: 'center',
						style: 'header',
						margin : [0,0,0,30],	
					},
					
					{
						image: uri,	
						alignment: 'center',
						width: 950 * 0.7487922705314,					
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
						font: 'THSarabunNew',
						
					}
					
				},
				 pageOrientation: 'landscape',
				

		};
		pdfMake.createPdf(docDefinition).download('รายงานจำนวนสมาชิกสหกรณ์ นอกภาคการเกษตร.pdf');
	  }, false);
	
	chart.draw(data,options);
};

$(document).ready(function() {
	$('#pageLoading').fadeIn();
	$.ajax({
		url:"ajexreport3",
	    type:"GET",
	    dataType: 'json',
	    success:function(result){
			console.log(result);
			listresult = result;
			
			$('#total').html(listresult.list_total.toLocaleString());
			google.charts.setOnLoadCallback(drawType1);
			
	        $('#pageLoading').fadeOut();


            <?php if (isset($_SESSION['showSQL'])) { ?>
            if (result.sql1) {
                $("#sql1").html(result.sql1);
                $("#sql2").html(result.sql2);
                $("#sql3").html(result.sql3);
            }
            <?php } ?>

		},
		error: function(err){
			$('#pageLoading').fadeOut();
		}


	})  
});

</script>


