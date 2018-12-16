
	<style>
<!--

-->
text:hover
{
	cursor: pointer;
	fill:rgb(0,0,0)!important;
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
		<span>Page Code : MIS200</span>
		<div class="report-result">

            <?php
            if (isset($_SESSION['showSQL'])) {
            echo "<pre>
                 /* จำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ OU_D_STATUS_TYPE NOT IN (1, 11, 13) */
                  <span id='sql1'></span>
                </pre>".
            "<pre>
                 
                 /* จำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ OU_D_STATUS_TYPE IN (1, 11, 13) */
                  <span id='sql2'></span>
                </pre>"
            .
            "<pre>
                 
                 /* จำนวนสมาชิกของสหกรณ์ */
                  <span id='sql3'></span>
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
				
			   	<h2  class="report-title-center" style="text-align:center"><center>รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ</center></h2>
				<h4><center>จำนวนสมาชิกของสหกรณ์   <span id="total"></span> คน</center></h4>
				</div>
				<div class="row" id="canvas"> 
				 	<div id="barchart_material" style="width: 100%; height: 1500px;"></div>
				</div>
				<p id="datethai" class="text-right r20"> </p>
			</div>	
	</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'bar']});
      
      var listresult;
  	/*var elem = document.getElementById("myBar");   
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
	}*/
	var now = new Date(); 
	var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
	"เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
	"ตุลาคม","พฤศจิกายน","ธันวาคม");
	var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);
	$('#datethai').html(datethai);

    var options = {
		chartArea: {width: '60%',height:'85%',top:100},
		bars: 'horizontal',
		colors: ['#4CAF50','#D30F0F'],
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
		     /* color: '#455A64',*/
		    }
	  	},
	  	tooltip: { 
	  		isHtml: true,
	  		textStyle: { 
	  			fontSize: 11
	  		} 
	  	},
	};
    function drawChart() {
    	  	
			var data_array = [['เขตตรวจราชการ', 'ปกติ', 'ตาย']];
			console.log(listresult);
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

	        var chart_div = document.getElementById('barchart_material');
	        var chart = new google.visualization.BarChart(chart_div);
	        //var chart = new google.charts.Bar(document.getElementById('chart_div'));
	  		/*google.visualization.events.addListener(chart, 'onmouseover', function(e) {
					console.log(e.row);
		  		});
			google.visualization.events.addListener(chart, 'onmouseout', function(e) {
					console.log(e.row);
		  		});*/
	         
	         
	  		google.visualization.events.addListener(chart, 'click', function(e) {
	  		    var match = e.targetID.match(/vAxis#\d#label#(\d)/);
	  		    if (match != null && match.length) {
	  		        var rowIndex = parseInt(match[1]);
	  		        // get the value from column 0 in the clicked row
	  		        var res = e.targetID.split("#");
					var sizearray =(res.length)-1;
					if(res[sizearray] != undefined)
					{
						console.log(res[sizearray]);
						console.log(match);
						var select_khet_id = listresult.list_id_khet[res[sizearray]]
						console.log(select_khet_id);
						var url = '<?php echo site_url('report3/index13')?>'+"?khetID="+select_khet_id;
						window.open(url);
					}
	  		    }
	  		});
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
	  								text: 'รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ',
	  								alignment: 'center',
	  								style: 'header'
	  							},
	  							{
	  								text: 'จำนวนสมาชิกของสหกรณ์ '+listresult.list_total_type1.toLocaleString()+' คน',
	  								alignment: 'center',
	  								style: 'header'
	  							},
	  							
	  							{
	  								image: uri,
	  								width: 700 * 0.7487922705314,
	  								height: 680,
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
	  				pdfMake.createPdf(docDefinition).download('รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แบ่งตามเขตตรวจราชการ.pdf');
	  			  }, false);
	  		
	  		chart.draw(view,options); 
	  		/*clearInterval(id);
	        elem.style.width = 100 + '%'; 
	        elem.innerHTML = 100  + '%';*/
			var id_elecment = 0;
	  		$('text').each(function()
					{
						if($(this).attr('fill') == "#222222" && $(this).attr('text-anchor') =="end")
						{
							$(this).attr('data-id',id_elecment);
							$(this).css('fill','blue');
							$(this).css('text-decoration','underline');
							console.log($(this).attr('data-id'));
							id_elecment++;
						}
					});
//         var chart = new google.charts.Bar(document.getElementById('barchart_material'));
//         chart.draw(view,options);  
//         chart.draw(view, google.charts.Bar.convertOptions(options));
      }

      $(document).ready(function() {
    	 	$('#pageLoading').fadeIn();
    		$.ajax({
    			url:"ajexreport6",
    		    type:"GET",
    		    dataType: 'json',
    		    success:function(result){
    				console.log(result);
    				listresult = result;
					$('#total').html(result.list_total_type1.toLocaleString());
    				google.charts.setOnLoadCallback(drawChart);
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