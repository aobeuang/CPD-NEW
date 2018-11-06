<?php
$this->load->helper('survey');
?>

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
			<h2><span class="glyphicon glyphicon-stats"></span> รายงานการปลูกพืชทั่วประเทศไทย 10 ชนิด</h2>
			
			<div class="row" id ="save">
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;" onclick="downloadExcel();" />
			</div>	
				
			
			<?php 
			?>
			<center><h4>จำนวนข้อมูลทั้งหมด   แถว</center></h4>
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
				 		<div id="regions_div" style="margin: auto;width: 800px;height: 700px;"></div>
				 		<div class="date" style="text-align:  right;margin-right: 250px;margin-bottom: 50px;"></div>
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


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages: ["geochart"]});
    google.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
            ['Country', 'Popularity'],
            ['กรุงเทพมหานคร', 200],
            ['นนทบุรี', 300],
            ['เชียงใหม่', 400],
            ['ตรัง', 500],
            ['จันทบุรี', 600],
            ['ขอนแก่น', 700]
        ]);

        var options = {
            region: 'TH',
            resolution: 'provinces',
            //displayMode: 'markers',
            colorAxis: {colors: ['white', 'yellow','#9ACD32','#eefdec', '#008000', '#006400']}
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        var btnSave = document.getElementById('save-pdf');
        
        google.visualization.events.addListener(chart, 'ready', function () {
    	    btnSave.disabled = false;
    	  });
    	  
        btnSave.addEventListener('click', function () {
    	    var doc = new jsPDF();
    	    doc.addImage(chart.getImageURI(), 0, 0);
    	    doc.save('chart.pdf');
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
    	  
        chart.draw(data, options);
    }
		
</script>


