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
		<div id="main-container" class="container-fluid col-md-12 col-xs-12 display">
		
			<h2><span class="glyphicon glyphicon-stats"></span> รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</h2>
			
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

				</div>
				
				<div class="row" id ="save">
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" onclick="downloadExcel();" />
			    </div>	
				
				
				<div class="row" id="canvas"> 	
						<center><h2  class="report-title-center" style="text-align:center">รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)</h2></center>
						<center><h4>จำนวนสมาชิกของสหกรณ์ <span id="total"></span> คน</center></h4>
			
				 		<div id="piechart" style="margin: auto;width: 800px;height: 400px;"></div>

					<right><p id="datethai" style="text-align:  right;font-size:  14px;"> </p></right>
					

				</div>
				
<!-- 				<div> 
					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
			select count(OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and OU_D_STATUS_TYPE  in (1,11,13) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			
			select count(DISTINCT OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and OU_D_STATUS_TYPE  not in (1,11,13) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			
			select count(DISTINCT OU_D_ID) as num  from moiuser.master_data where OU_D_FLAG in(1,2) and NUMBER_OF_COOP is not null  and DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'  and LENGTH (moiuser.master_data .IN_D_COOP) = 13";
			
					</textarea>

					
				</div> -->
				
			</div>
		</div>
	
	</div>

</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
     
      var listresult;
		
  		var now = new Date(); 
  		var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
  		"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
  		"ตุลาคม","พฤศจิกายน","ธันวาคม");
  		var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
  		$('#datethai').html(datethai);
      function drawChart() {

    	var temp_data =   [['Task', 'Hours per Day']];
	

    	for(var i=0;i<listresult.result.length;i++)
		{
			temp_data.push([listresult.result[i]['lable'],listresult.result[i]['count']]);
		}
        var data = google.visualization.arrayToDataTable(temp_data);

        var options = {
          title: 'แสดงผลเปรียบเทียบ ปกติ-ตาย',
        	  width: 925,
 	       	 height: 350,
 	    	tooltip: { trigger: 'selection' }
        };

        var chart_div = document.getElementById('piechart');
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
      						text: 'รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง)',
      						alignment: 'center',
      						style: 'header'
      					},
      					{
      						text: 'จำนวนสมาชิกของสหกรณ์ '+listresult.list_total_type1.toLocaleString()+' คน',
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
      							font: 'THSarabunNew'
      						}
      						
      					},
      				pageOrientation: 'landscape',

      		};
      		pdfMake.createPdf(docDefinition).download('รายงานสถานภาพสมาชิกสหกรณ์ (ไม่นับสมาชิกสหกรณ์ที่สังกัดสหกรณ์มากกว่า 1 แห่ง).pdf');
      	  }, false);
     
	  	chart.draw(data,options);  
	  	clearInterval(id);
	        elem.style.width = 100 + '%'; 
	        elem.innerHTML = 100  + '%';
	  	
      }
      $(document).ready(function() {
        $("#pageLoading").fadeIn();
  		$.ajax({
  			url:"ajexreport5",
  		    type:"GET",
  		    dataType: 'json',
  		    success:function(result){
  				
  		    	listresult = result;
  		    	
  		    	$('#total').html(listresult.list_total_type1.toLocaleString());
  				google.charts.setOnLoadCallback(drawChart);
  				$("#pageLoading").fadeOut();
  		        
  			}


  		})  
  	});
      
    </script>