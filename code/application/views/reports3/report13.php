<meta name="viewport" content="width=device-width, initial-scale=1">	
	
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
	

	
	<script>
	jQuery(function () {
	    // remove the below comment in case you need chnage on document ready
	    // location.href=jQuery("#selectbox").val(); 
	    jQuery("#survey_year").change(function () {
	        location.href = '<?php echo site_url('survey/selectSurveyYear')?>/'+jQuery(this).val();
	    })
	})
	</script>
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
		<?php
                $current_url = $_GET['khetID'];
                    if ($current_url == 99): ?>	
                        <span>Page Code : MIS299</span>
                    <?php elseif ($current_url == 1): ?>
                        <span>Page Code : MIS201</span>
                        <?php elseif ($current_url == 2): ?>
                        <span>Page Code : MIS202</span>
                        <?php elseif ($current_url == 3): ?>
                        <span>Page Code : MIS203</span>
                        <?php elseif ($current_url == 4): ?>
                        <span>Page Code : MIS204</span>
                        <?php elseif ($current_url == 5): ?>
                        <span>Page Code : MIS205</span>
                        <?php elseif ($current_url == 6): ?>
                        <span>Page Code : MIS206</span>
                        <?php elseif ($current_url == 7): ?>
                        <span>Page Code : MIS207</span>
                        <?php elseif ($current_url == 8): ?>
                        <span>Page Code : MIS208</span>
                        <?php elseif ($current_url == 9): ?>
                        <span>Page Code : MIS209</span>
                        <?php elseif ($current_url == 10): ?>
                        <span>Page Code : MIS210</span>
                        <?php elseif ($current_url == 11): ?>
                        <span>Page Code : MIS211</span>
                        <?php elseif ($current_url == 12): ?>
                        <span>Page Code : MIS212</span>
                        <?php elseif ($current_url == 13): ?>
                        <span>Page Code : MIS213</span>
                        <?php elseif ($current_url == 14): ?>
                        <span>Page Code : MIS214</span>
                        <?php elseif ($current_url == 15): ?>
                        <span>Page Code : MIS215</span>
                        <?php elseif ($current_url == 16): ?>
                        <span>Page Code : MIS216</span>
                        <?php elseif ($current_url == 17): ?>
                        <span>Page Code : MIS217</span>
                        <?php elseif ($current_url == 18): ?>
                        <span>Page Code : MIS218</span>
                <?php endif;?>
		<div class="report-result">
			
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
					
				   	<h2 class="report-title-center" id="title-chart" style="text-align:center"><center>รายงานจำนวนสมาชิกสหกรณ์ตามจังหวัดเขตพื้นที่ตรวจราชการที่</center></h2>
					<h4><center>จำนวนสมาชิกของสหกรณ์   <span id="total"></span> คน</center></h4>
				</div>
				<div class="loader" id ="loader"></div>
				<div class="row" id="canvas"> 
				 	<div id="barchart_material" style="width: 100%; height: 600px;"></div>
				</div>
				<p id="datethai" class="text-right r20"> </p>
			</div>	
	</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script type="text/javascript">
    
	google.charts.load('current', {'packages':['bar',"corechart"]});
	var listresult;
	var total;
	var name;
	var chartheight ="80%";
  	var now = new Date(); 
	var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
	"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
	"ตุลาคม","พฤศจิกายน","ธันวาคม");
	var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
	var options = {
		height: '600px',
		chartArea: {width: '70%',height:'60%',top:100},
		bars: 'horizontal',
		colors: ['#4CAF50','#D30F0F'],
		series: {
			0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
			1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
		},
		bar: { groupWidth: "90%" },
		fontName:'Kanit',
	   	titleTextStyle: {
	   	 	color: '#455A64',
		    fontSize: 16
	   	},
	   	hAxis: {
	   		title: 'จำนวนสมาชิกของสหกรณ์',
			textStyle: {
				fontSize: 14,

			},
			titleTextStyle: {
				fontSize: 16,
				italic: false,
			}
		},
		vAxis: {
			textStyle: {
				fontSize: 14
			}
		},
		legend: { 
			position: 'top',
			alignment: 'center',
			textStyle: {
				fontSize: 14
			}
		},
		annotations: {
		    textStyle: {
		      fontSize: 12,
		      /*color: '#455A64',*/
		    }
	  	},
	  	tooltip: { 
	  		isHtml: true,
	  		textStyle: { 
	  			fontSize: 14 
	  		} 
	  	},
	};
	$('#datethai').html(datethai);
      function drawChart() {
    	  	var data_json = listresult;
			var data_array = [['เขตตรวจราชการ', 'ปกติ', 'ตาย']];
// 			console.log(data_json);
			for (let elem in data_json)
			{
				data_array.push([elem,data_json[elem]['1'],data_json[elem]['2']]);
			}
// 			console.log( data_array);
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

	        var chart_div = document.getElementById('barchart_material');
	        var chart = new google.visualization.BarChart(chart_div);
	        var btnSave = document.getElementById('save-pdf');
	  	  	google.visualization.events.addListener(chart, 'ready', function () {
	  	  	 var element = document.getElementById("loader");
	 	    	element.classList.remove("loader");
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
	  			pageOrientation: 'landscape',
	  				content: [
	  					{
	  						text: name+'',
	  						alignment: 'center',
	  						style: 'header'
	  					},
	  					{
	  						text: 'จำนวนสมาชิกของสหกรณ์ '+total+' คน',
	  						alignment: 'center',
	  						style: 'header',
	  						margin : [0,0,0,30],
	  					},
	  					
	  					{
	  						image: uri,
	  						alignment: 'center',
	  						width: 925 * 0.7487922705314,
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
								fontSize: 22,
								bold: true
							},
							footer :{
								fontSize: 15,
								font: 'THSarabunNew',
								
							}
							
						},
	  				
	  				

	  		};
	  		pdfMake.createPdf(docDefinition).download(name+'.pdf');
	  	  }, false);
	  	
	  	chart.draw(view,options);  
//         var chart = new google.charts.Bar(document.getElementById('barchart_material'));
//         chart.draw(view,options);  
//         chart.draw(view, google.charts.Bar.convertOptions(options));
      }
     
     
     function removetagdisplay ()
     {
     	var element = document.getElementById("loader");
     	var text = document.getElementById("main-container");
     	var button = document.getElementById("download");
     	
     	text.classList.remove("display");
     	button.classList.remove("display");
       	element.classList.remove("loader");
     }
     
     $(document).ready(function() {
    		var khetID = '<?php print_r($khetID)?>';
    		$('#pageLoading').fadeIn();
    		$.ajax({
    			url:"ajexreport13",
    		    type:"GET",
    		    data:{khetID:khetID},
    		    dataType: 'json',
    		    success:function(result){
        		    console.log(result);
    		    	chartheight = result.chart_heigth;
    				listresult = result.result;
    				total = result.list_total_type1;
    				name = result.khet_name;
    				 console.log(listresult);
    				$('#title-chart').html(result.khet_name+'');
    				$('#total').html(result.list_total_type1);
    				console.log(listresult);
					//$('#barchart_material').css('height',result.div_heigth);
    				google.charts.setOnLoadCallback(drawChart);
    		        $('#pageLoading').fadeOut();
    		        //options.chartArea.height = result.chart_heigth;
    			},
				error: function(err){
					$('#pageLoading').fadeOut();
				}

    		})  
    	});

      
    </script>