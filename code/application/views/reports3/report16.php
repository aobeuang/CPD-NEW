<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
<style type="text/css">

#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
</style>

	<script>
	jQuery(function () {
	    // remove the below comment in case you need chnage on document ready
	    // location.href=jQuery("#selectbox").val(); 
	    jQuery("#survey_year").change(function () {
	        location.href = '<?php echo site_url('survey/selectSurveyYear')?>/'+jQuery(this).val();
	    })
	})
	</script>
		
		<div id="main-wrapper" class="display mis">
		<div id="main-container" class="container-fluid col-md-12 col-xs-12 display" >
		
			<h2><span class="glyphicon glyphicon-stats"></span> รายงานจำนวนสมาชิกสหกรณ์ทั้งหมดแบ่งตามจังหวัด</h2>
		
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
				
			    	 <center><h2  class="report-title-center" style="text-align:center">รายงานจำนวนสมาชิกสหกรณ์ทั้งหมดแบ่งตามจังหวัด</h2></center>
					 <center><h4 >จำนวนสมาชิกของสหกรณ์ <span id="total"></span> คน</center></h4>
			  
			   
				
					<div class="row" id="canvas" style = 'text-align:justify;'>  
						<div id="barchart_material" style="width: 100%; height: 5500px;"></div>
					</div>
				
				
<!-- 				 <div> 
					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
					select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
		     from moiuser.master_data
		     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13) 
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		ORDER BY COOP_INFO.ORG_ID
					</textarea>
					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
					select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
		     from moiuser.master_data
		     where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		ORDER BY COOP_INFO.ORG_ID
					</textarea>
					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
					select sum(a.TOTAL_COOP)
		from COOP_INFO
		left join (
		     select  IN_D_COOP ,count(IN_D_PIN) as TOTAL_COOP
		     from moiuser.master_data
		     where  OU_D_FLAG in (1,2)
		     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
					</textarea>
				</div> -->
				
			</div>
		</div>
	
	</div>

</div>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    <script src="/assets/default/vendors/jsPDF-CustomFonts-support-master/dist/jspdf.customfonts.min.js"></script>
    <script src="/assets/default/vendors/jsPDF-CustomFonts-support-master/dist/default_vfs.js"></script>
     
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar',"corechart"]});

      var listresult;
	  var elem = document.getElementById("myBar");   
		var width = 10;
		var time = (((10*0.15)/100)+5)*20;
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
     function drawChart() {   	  	
    	  	
			var data_array = [['จังหวัด', 'ปกติ', 'ตาย']];
			
			for (let elem in listresult.khet)
			{
				data_array.push([elem,listresult.khet[elem]['1'],listresult.khet[elem]['2']]);
			}
			
	        var data = google.visualization.arrayToDataTable(data_array);
	        var view = new google.visualization.DataView(data);
	        view.setColumns([0, 1,
	                         { calc: "stringify",
	                           sourceColumn: 1,
	                           type: "string",
	                           role: "annotation" },
	                           2,
	                           { calc: "stringify",
	                             sourceColumn: 2,
	                             type: "string",
	                             role: "annotation" }
	                         ]);
	        var options = {
	        		chartArea: {width: '60%',height:'90%',top:40},
	        		legend:{textStyle: {fontSize: 17}},
					'hAxis': {'title': 'จำนวนสมาชิกของสหกรณ์'},
					'vAxis':{ 
	        	        textStyle : {
	        	            fontSize: 17 // or the number you want
	        	        }
	        		},
	        		bars: 'horizontal',
	        		 bar: { groupWidth: "90%" } // Required for Material Bar Charts.
	        };

	        var chart_div = document.getElementById('barchart_material');
	        var chart = new google.visualization.BarChart(chart_div);
	      
	        



	  		google.visualization.events.addListener(chart, 'onmouseover', function(e) {
					console.log(e.row);
		  		});
			google.visualization.events.addListener(chart, 'onmouseout', function(e) {
					console.log(e.row);
		  		});
	         

	         
	  		//google.visualization.events.addListener(chart, 'click', function(e) {
	  		  //  var match = e.targetID.match(/vAxis#\d#label#(\d)/);
	  		  //  if (match != null && match.length) {
	  		   //     var rowIndex = parseInt(match[1]);
	  		        // get the value from column 0 in the clicked row
	  		    //    var res = e.targetID.split("#");
				//	var sizearray =(res.length)-1;
				//	if(res[sizearray] != undefined)
				//	{
				//		console.log(res[sizearray]);
						
				//		var url = '<?php echo site_url('report3/index13')?>'+"?khetID="+res[sizearray];
				//		window.open(url);
				//	}
	  		    //}
	  		//});
	  		  
	  		
	  		chart.draw(view,options); 
	  		clearInterval(id);
		        elem.style.width = 100 + '%'; 
		        elem.innerHTML = 100  + '%';
//         var chart = new google.charts.Bar(document.getElementById('barchart_material'));
//         chart.draw(view,options);  
//         chart.draw(view, google.charts.Bar.convertOptions(options));
      }

      $(document).ready(function() {

    
  		$.ajax({
  			url:"ajexreport16",
  		    type:"GET",
  		    dataType: 'json',
  		    success:function(result){
  				console.log(result);
  				listresult = result;
  				$('#total').html(listresult.list_total_type1.toLocaleString());
  				google.charts.setOnLoadCallback(drawChart);
  				
  		        
  			}


  		})
  	 
  	    $('#download').click(function() {       
  	    	html2canvas($("#canvas"), {
  	    		onrendered: function(canvas) {
    				var imgData = canvas.toDataURL('image/png');
    				var imgWidth = 210; 
    				var pageHeight = 295;  
    				var imgHeight = canvas.height * imgWidth / canvas.width;
    				var heightLeft = imgHeight;
    				
    				var doc = new jsPDF('p', 'mm');
    				doc.addFont('THSarabunNew.ttf', 'THSarabunNew', 'normal'); 
    				doc.addFont('THSarabunNew Bold.ttf', 'THSarabunNew', 'bold');    
    								
    	  	    	doc.setFont('THSarabunNew');
    	  	    	var text = 'รายงานจำนวนสมาชิกสหกรณ์ทั้งหมดแบ่งตามจังหวัด';
    	  	    	doc.setFontSize('20');
    	  	    	doc.setFontStyle('bold');
    	  	    	doc.text(text,65,20);
    	  	    	doc.addFont('THSarabunNew.ttf', 'THSarabunNew', 'normal');
    	  	    	doc.setFont('THSarabunNew');
    	  	    	var text = 'จำนวนสมาชิกของสหกรณ์ '+listresult.list_total_type1.toLocaleString()+' คน';
    	  	    	doc.text(text,70,30);

    				var position = 40.9;

    				doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
    				heightLeft -= pageHeight;

    				while (heightLeft >= 0) {
    				  position = heightLeft - imgHeight;
    				  doc.addPage();
    				  doc.addImage(imgData, 'PNG', 0, position+40.9, imgWidth, imgHeight);
    				  heightLeft -= pageHeight;
    				}
    				doc.save('รายงานจำนวนสมาชิกสหกรณ์ทั้งหมดแบ่งตามจังหวัด.pdf');﻿
  	    		}
  	    	});
  	    });
  	});
    </script>