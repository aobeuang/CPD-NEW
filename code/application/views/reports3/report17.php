



<style>
#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
text:hover
{
	fill: mediumblue/*#219*/;
	cursor: pointer;
}

.table .google-visualization-table-tr-odd, .table .google-visualization-table-tr-even {
    background-color: transparent;
}

.google-visualization-table-td {
text-align: center !important;
}

#table_div.table {
    margin-bottom: 0;
}
#table_div .TotalRow {
    background-color: #e4e9f4;
    text-align: center;
}
#table_div .TotalRow td {
    background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.7) 30%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 100%);
    font-weight : 700;
}
.Textcenterodd {
	vertical-align: middle  !important;
	background-color: transparent !important;
}
.Textcentereven {
	vertical-align: middle  !important;
	background-color: transparent !important;
}
#table_div .position.google-visualization-table-td
{
	text-align: right!important;
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
		<div id="main-wrapper">
		<div id="main-container" class="container-fluid col-md-12 col-xs-12">

			<h2 style="float:  right;"><span class="glyphicon glyphicon-stats"></span> รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด</h2>

			<div id="right-container" class="col-md-12 col-xs-12">


			    	    <div class="row">
					<div class="actions" style="float:right">
			    		<script>
							function downloadExcel()
							{
								window.location.href = "/index.php/report3/exportdatacsvreport";
							}
							function downloadPDF()
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
					<input id="save-pdf"  class="btn btn-default t5" type="button" value="บันทึกเป็น Excel" style="float:  right;" onclick="downloadExcel();" />
					<input id="save-pdff" class="btn btn-default t5" type="button" value="บันทึกเป็น PDF" style="float:  right;margin-right:5px;" onclick="drawPDF();">
			    </div>

				<center><h2  class="report-title-center" style="text-align:center">รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด</h2></center>
				<center><h4>จำนวนสมาชิกของสหกรณ์ <span id="total"></span>   คน</center></h4>

				<div  class="row" id="canvas" style = 'text-align:justify;'>

					<div id="table_div" style="margin: auto; width: 900px; height: 80%;"></div>
					<right><p id="datethai" style="text-align:  right;font-size:  14px;"> </p></right>


				</div>



<!-- 				<div>

					<textarea rows="12" cols="130" style="margin: 0px; width: 1073px; height: 291px;">
					select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
		  from COOP_INFO
		  left join (
		       select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
		       from moiuser.master_data
		       where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  not in (1,11,13)
		       group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
		  ) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
		  ORDER BY COOP_INFO.ORG_ID

		  select sum(a.TOTAL_COOP),COOP_INFO.ORG_NAME
			  from COOP_INFO
			  left join (
			       select  IN_D_COOP ,count(OU_D_ID) as TOTAL_COOP
			       from moiuser.master_data
			       where OU_D_FLAG in (1,2) and OU_D_STATUS_TYPE  in (1,11,13)
			       group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'
			  ) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP GROUP by COOP_INFO.ORG_NAME, COOP_INFO.ORG_ID
			  ORDER BY COOP_INFO.ORG_ID
					</textarea>

				</div> -->

			</div>
		</div>

	</div>

</div>

</div>

<style>
<!--

-->
th
{
	text-align: center;
}
</style>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar',"corechart","table"]});

    //Declare formats
      var formatterEuro = {
          decimalSymbol: ',',
          groupingSymbol: '.',
          negativeColor: 'red',
          negativeParens: true,
          prefix: '\u20AC '
      };

      var StatusTable;

      //remove the google chart styling and add the bootstrap styling
      //Also add the css class Totalrow
      function resetStyling(id) {
          $('#' + id + ' table')
              .removeClass('google-visualization-table-table')
              .addClass('table table-bordered table-condensed table-striped table-hover');
          var parentRow = $('#' + id + ' td.TotalCell').parent();
          parentRow.addClass('TotalRow');
      }

      var listresult;
      var elem = document.getElementById("myBar");
      var width = 10;
      var time = (((10*0.15)/100)+5)*30;
      var id_frame = setInterval(frame, time);
      function frame() {
        if (width >= 98) {
          clearInterval(id_frame);
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

      function drawChart() {

    	  	//console.log(listresult.khet);
			var data_array = [];
			var num = 1;
			//console.log(listresult.length);
			for (let elem in listresult.khet)
			{
				//console.log(elem);

				if(num<79){
					if(listresult.khet[elem]['3'] % 2 === 0  ){
						data_array.push([{v: listresult.khet[elem]['3'],p: {className: 'Textcentereven'}},elem,{v: listresult.khet[elem]['1'],p: {className: 'position'}},{v: listresult.khet[elem]['2'],p: {className: 'position'}}]);
					}else
						data_array.push([{v: listresult.khet[elem]['3'],p: {className: 'Textcenterodd'}},elem,{v: listresult.khet[elem]['1'],p: {className: 'position'}},{v: listresult.khet[elem]['2'],p: {className: 'position'}}]);
				}

				else
					data_array.push([{v: elem,p: {className: 'TotalCell'}},{v: '',p: {className: 'TotalCellDelete'}},listresult.khet[elem]['1'],listresult.khet[elem]['2']]);

				num++;
			}
			//console.log(data_array);
			console.log('tttooo');
			 var data = new google.visualization.DataTable();
// 			 	data.addColumn('string', 'ลำดับ');
			 	data.addColumn('string', 'เขตตรวจราชการ');
		        data.addColumn('string', 'จังหวัด');
		        data.addColumn('number', 'จำนวนสมาชิกปกติ (คน)');
		        data.addColumn('number', 'จำนวนสมาชิกตาย (คน)');
		        data.addRows(data_array);
		        var id = document.getElementById('table_div');
		        var table = new google.visualization.Table(id);



		        //add the listener events
		        google.visualization.events.addListener(table, 'ready', function () {
		            resetStyling('table_div');
		        });

		        google.visualization.events.addOneTimeListener(table, 'ready', function () {
		          var rowLabel = null;
		          var rowIndex;
		          var rowSpan;
		          var rows = id.getElementsByTagName('tr');
		          Array.prototype.forEach.call(rows, function (row, index) {
		            if (rowLabel !== row.cells[0].innerHTML) {
		              rowLabel = row.cells[0].innerHTML;
		              rowIndex = index;
		              if (rowSpan > 1) {
		                rows[index - rowSpan].cells[0].rowSpan = rowSpan;
		              }
		              rowSpan = 1;
		            } else {
		              rowSpan++;
		              row.removeChild(row.cells[0]);
		            }
		          });
		        });
// 		        //sorting event
// 		        google.visualization.events.addListener(StatusTable, 'sort', function (ev) {
// 		            //find the last row
// 		            var parentRow = $('#StatusOverview td.TotalCell').parent();
// 		            //set the TotalRow row to the last row again.
// 		            if (!parentRow.is(':last-child')) {
// 		                parentRow.siblings().last().after(parentRow);
// 		            }

// 		            //reset the styling of the table
// 		            resetStyling('StatusOverview');
// 		        });


		        table.draw(data, {width: '100%', height: '100%'});
		    	clearInterval(id_frame);
		        elem.style.width = 100 + '%';
		        elem.innerHTML = 100  + '%';

		        console.log($('.TotalCell').attr('colspan',"2"));
		        $('.TotalCellDelete').remove();
// 		        $('.TotalCell').attr('colspan',"2");

      }
			function drawPDF()
			{
					//console.log('ooo111');
					//console.log(listresult.khet);
					//console.log('ooo222');
					var data_array = [];
					var num = 1;
					var table_rows = [];
					var temp_pdf_array = [];
					var temp_pdf_array1 = [];
					var temp_pdf_array2 = [];
					table_rows.push([ { alignment:'center', text: 'เขตตรวจราชการ', bold: true, fontSize:14, fillColor: '#CCCCCC' }, { alignment:'center', text: 'จังหวัด', bold: true, fontSize:14, fillColor: '#CCCCCC' }, { alignment:'center', text: 'จำนวนสมาชิกปกติ(คน)', bold: true, fontSize:14 }, { alignment:'center', text: 'จำนวนสมาชิกตาย(คน)', bold: true, fontSize:14, fillColor: '#CCCCCC' } ]);

					//console.log(listresult.length);

					var temp_khet_num = '';
					var count_khet = [];
					var rowspan_value = 1;
					for(let row_elem in listresult.khet)
					{
						if(temp_khet_num!=listresult.khet[row_elem]['3']){
							count_khet[listresult.khet[row_elem]['3']] = 1;
							temp_khet_num = listresult.khet[row_elem]['3'];
						}else{
							count_khet[listresult.khet[row_elem]['3']] = count_khet[listresult.khet[row_elem]['3']]+1;
							listresult.khet[row_elem]['3'] = '';
						}
						if(listresult.khet[row_elem]['3']!='')
						{
							rowspan_value = count_khet[listresult.khet[row_elem]['3']];
						}else{
							rowspan_value = 1;
						}
						table_rows.push([{text:listresult.khet[row_elem]['3'], alignment:'center', rowSpan: rowspan_value, colSpan: 1, fillColor:'#FFFFFF', fontSize: 14},{text:row_elem, alignment:'center', colSpan: 1, rowSpan: 1, fontSize: 14},{text: listresult.khet[row_elem]['1'].toLocaleString(), alignment:'right', colSpan: 1, rowSpan: 1, fontSize: 14},{text: listresult.khet[row_elem]['2'].toLocaleString(),alignment:'right', colSpan: 1, rowSpan: 1, fontSize: 14}]);
					}

					for(let rowspan_elem in table_rows){
						//console.log(table_rows[rowspan_elem]['0']);
						if(table_rows[rowspan_elem]['0']['text']!=0){
							table_rows[rowspan_elem]['0']['rowSpan'] = count_khet[table_rows[rowspan_elem]['0']['text']];
							//table_rows[rowspan_elem]['0']['text'] = '\n\n\n'+table_rows[rowspan_elem]['0']['text'];
						}else{
							//table_rows[rowspan_elem]['0']['rowspan'] = '';
							if(rowspan_elem!=0){
								//table_rows[rowspan_elem].splice(0,1);
								table_rows[rowspan_elem]['0'] = {};
							}
						}
						if( rowspan_elem != 79)
						{
							table_rows[rowspan_elem]['1']['colSpan'] = 1;
							if(rowspan_elem != 0){
								if(count_khet[table_rows[rowspan_elem]['0']['text']]<=3){
									table_rows[rowspan_elem]['0']['text'] = '\n'+table_rows[rowspan_elem]['0']['text'];
								}else if(count_khet[table_rows[rowspan_elem]['0']['text']]==4 || count_khet[table_rows[rowspan_elem]['0']['text']]==5){
									table_rows[rowspan_elem]['0']['text'] = '\n\n'+table_rows[rowspan_elem]['0']['text'];
								}else if(count_khet[table_rows[rowspan_elem]['0']['text']]>=6){
									table_rows[rowspan_elem]['0']['text'] = '\n\n\n'+table_rows[rowspan_elem]['0']['text'];
								}
							}
						}else{


							table_rows['79']['0']['colSpan'] = 2;
							table_rows['79']['0']['text'] = 'ยอดรวม';
							table_rows['79']['0']['bold'] = true;
							table_rows['79']['0']['fillColor'] = '#e4e9f4';
							table_rows['79']['0']['fontSize'] = 14;
							table_rows['79']['0']['verticalAlign'] = 'middle';

							table_rows['79']['1']['colSpan'] = 0;
							table_rows['79']['1']['text'] = 'ยอดรวม';

							table_rows['79']['2']['bold'] = true;
							table_rows['79']['2']['fontSize'] = 14;
							table_rows['79']['2']['fillColor'] = '#e4e9f4';
							table_rows['79']['2']['alignment'] = 'center';

							table_rows['79']['3']['bold'] = true;
							table_rows['79']['3']['fontSize'] = 14;
							table_rows['79']['3']['fillColor'] = '#e4e9f4';
							table_rows['79']['3']['alignment'] = 'center';

						}
					}

					for(let pdf_element in table_rows){
						if(pdf_element>=0&&pdf_element<=27){
							temp_pdf_array.push(table_rows[pdf_element]);
						}else if(pdf_element>=28&&pdf_element<=57){
							temp_pdf_array1.push(table_rows[pdf_element]);
						}else{
							temp_pdf_array2.push(table_rows[pdf_element]);
						}
					}

					table_rows['0']['0']['fillColor'] = '#e4e9f4';
					table_rows['0']['1']['fillColor'] = '#e4e9f4';
					table_rows['0']['2']['fillColor'] = '#e4e9f4';
					table_rows['0']['3']['fillColor'] = '#e4e9f4';
					//table_rows['27']['3']['pageBreak'] = 'after';
					//table_rows['27']['3']['dontBreakRows'] = 'true';

					//temp_pdf_array['27']['3']['pageBreak'] = 'after';
					//temp_pdf_array1['29']['3']['pageBreak'] = 'after';
					//table_rows['28']['0']['pageBreak'] = 'after';
					//table_rows['57']['3']['pageBreak'] = 'after';
					//table_rows['57']['3']['dontBreakRows'] = 'true';
					console.log('ooo333');
					console.log(count_khet);
					//console.log(table_rows);
					//console.log(temp_pdf_array);
					//console.log(temp_pdf_array1);
					//console.log(temp_pdf_array2);
					console.log('ooo444');

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
									header: function(currentPage, pageCount) {
										// you can apply any logic and return any valid pdfmake element

										return { text: 'หน้าที่ '+ currentPage +'/'+ pageCount, alignment: 'right', margin:[20, 20, 40, 20], fontSize: 14 };
									  },
			  						content: [
			  							{
			  								text: 'รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด',
			  								alignment: 'center',
			  								style: 'header',
											fontSize: 20
			  							},
			  							{
			  								text: 'จำนวนสมาชิกของสหกรณ์ '+listresult.list_total.toLocaleString()+' คน',
			  								alignment: 'center',
			  								style: 'header',
											fontSize: 16
			  							},
										{
										  table: {
											 //heights: [12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,12,],
											// headers are automatically repeated if the table spans over multiple pages
											// you can declare how many rows should be treated as headers
											headerRows: 1,
											widths: [ 100, 100, 140, 140 ],

											body: table_rows
										  },
										  layout: {
												fillColor: function (i, node) {
													return (i % 2 === 0) ? '#F5F5F5' : null;
												}
											}
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
				//var docDefinition = { content: "รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด" };

				// download the PDF
				pdfMake.createPdf(docDefinition).download('รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด.pdf');
			}
	  /*
	function drawPDF()
	{
			//console.log(listresult.khet);
			var data_array = [];
			var num = 1;
			//console.log(listresult.length);
			for (let elem in listresult.khet)
			{
				console.log(elem);

				if(num<79){
					if(listresult.khet[elem]['3'] % 2 === 0  ){
						data_array.push([{v: listresult.khet[elem]['3'],p: {className: 'Textcentereven'}},elem,{v: listresult.khet[elem]['1'],p: {className: 'position'}},{v: listresult.khet[elem]['2'],p: {className: 'position'}}]);
					}else
						data_array.push([{v: listresult.khet[elem]['3'],p: {className: 'Textcenterodd'}},elem,{v: listresult.khet[elem]['1'],p: {className: 'position'}},{v: listresult.khet[elem]['2'],p: {className: 'position'}}]);
				}

				else
					data_array.push([{v: elem,p: {className: 'TotalCell'}},{v: '',p: {className: 'TotalCellDelete'}},listresult.khet[elem]['1'],listresult.khet[elem]['2']]);

				num++;
			}

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
								  table: {
									// headers are automatically repeated if the table spans over multiple pages
									// you can declare how many rows should be treated as headers
									headerRows: 1,
									widths: [ '*', 'auto', 100, '*' ],

									body: [
									  [ 'First', 'Second', 'Third', 'The last one' ],
									  [ 'Value 1', 'Value 2', 'Value 3', 'Value 4' ],
									  [ { text: 'Bold value', bold: true }, 'Val 2', 'Val 3', 'Val 4' ]
									]
								  }
								}
							  ]
							};
	  				var docDefinition = {
	  						content: [
	  							{
	  								text: 'รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด',
	  								alignment: 'center',
	  								style: 'header'
	  							},
	  							{
	  								text: 'จำนวนสมาชิกของสหกรณ์ '+listresult.list_total.toLocaleString()+' คน',
	  								alignment: 'center',
	  								style: 'header'
	  							},
								{
								  table: {
									// headers are automatically repeated if the table spans over multiple pages
									// you can declare how many rows should be treated as headers
									headerRows: 1,
									widths: [ '*', 'auto', 100, '*' ],

									body: [
									  [ { alignment:'center', text: 'เขตตรวจราชการ', bold: true, fontSize:14 }, { alignment:'center', text: 'จังหวัด', bold: true, fontSize:14 }, { alignment:'center', text: 'จำนวนสมาชิกปกติ(คน)', bold: true, fontSize:14 }, { alignment:'center', text: 'จำนวนสมาชิกตาย(คน)', bold: true, fontSize:14 } ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ 'Value 1', 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									  [ { alignment:'center', text: '1', bold: true, rowSpan:3,margin: [ 20, 2, 10, 2 ]}, 'Val 2', 'Val 3', 'Val 4' ],
									  [ , 'Value 2', 'Value 3', 'Value 4' ],
									  [ , 'Val 2', 'Val 3', 'Val 4' ],
									]
								  }
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
		//var docDefinition = { content: "รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด" };

		// download the PDF
		pdfMake.createPdf(docDefinition).download('รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด.pdf');
	}

	*/
      $(document).ready(function() {

    		$.ajax({
    			url:"ajexreport17",
    		    type:"GET",
    		    dataType: 'json',
    		    success:function(result){
    				console.log(result);
    				listresult = result;

    				$('#total').html(listresult.list_total.toLocaleString());
    				google.charts.setOnLoadCallback(drawChart);
    			}


    		})
    	});
    </script>