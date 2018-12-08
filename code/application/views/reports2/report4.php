
<style>

		.select2 {
    		max-width: 250px;
		}
		#example_filter{
			display: none;
		}

</style>
<?php 
$this->load->helper('form');
$this->load->helper('survey');


$coop = is_numeric($filter_coop) ? getCoopByID($filter_coop) : array();
										
?>

<div id="main-wrapper" class="report-content">
	<p>Page Code : RE300</p>
	<!-- <div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12"> -->
		
			
			<div class="container-fluid col-md-12 col-xs-12" >
				
				<div class="row" style="text-align:left">
					<h2><span class="glyphicon glyphicon-th-list"></span> รายงานสรุปยอดสถานะสมาชิกสหกรณ์</h2>
				</div>

				<pre id="data_respone"></pre>
				<div id="data_respone1"></div>
				<div id="data_respone2"></div>
				<div id="data_respone3"></div>
				<div id="data_respone4"></div>
				<div class="row" id="action-bar">
					<div class="report-action-bar">

						<form id="trip-luckyForm" class="form-inline">
						
						<input type="hidden" value="yes" name="frompost" />
						<div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12" style="margin-top: 13px;">
							<label for="filter_province">ปี: </label>	
								<select name="filter_year" id="filter_year" >
									<option value="">ทั้งหมด</option>
								<?php  
									$all_survey_years = getAllSurveyYears();
									if (!empty($all_survey_years))
									{
										foreach ($all_survey_years as $k=>$v)
										{
											$selected = "";
											if ($k==$filter_year)
												$selected = "selected=\"selected\"";		
											echo "<option $selected value='$k'>$v</option>";
										}
									}
								?>
								</select>	
																						
	<!-- 						<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;"> -->
	<!-- 						<label for="filter_province">รหัสบัตรประชาชน: </label>	 -->
	<!-- 							<input id="citizen_id" name="citizen_id" class="form-control mr-sm-2" type="search" placeholder="หมายเลขบัตรประชาชน" aria-label="Search" value="<?php //if (isset($citizen_id)) echo $citizen_id?>"> -->					   
	<!-- 						</div>	 -->
							<!-- 
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">
								<input id="coop_id" name="coop_id" class="form-control mr-sm-2" type="search" placeholder="รหัสสหกรณ์" aria-label="Search" value="<?php //if (isset($citizen_id)) echo $citizen_id?>">					   
							</div>
							 -->
							</div>
						</div>
						<div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">
								<label for="filter_district">เขตตรวจราชการ: </label>
								<input type="hidden" id="filter_khet_hidden" value=""/>
								<select id="filter_khet" name="filter_khet">
									<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">				
								<label for="filter_province">จังหวัด: </label>		
								<input type="hidden" id="filter_province_hidden" value=""/>
								<?php $all_provinces = getAllProvinces();?>
								<select id="filter_province" name="filter_province">
									<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>
								</select>
							</div>
						</div>
<!-- 						<div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">
<!-- 								<label for="filter_district">เขต|อำเภอ: </label> -->
<!-- 								<input type="hidden" id="filter_district_hidden" value=""/> -->
<!-- 								<select id="filter_district" name="filter_district"> -->
<!-- 									<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option> -->
<!-- 								</select> -->
<!-- 							</div> -->
<!-- 						</div> -->
<!--						<div class="container-fluid col-md-4 col-xs-12"  style="margin-top: 13px;"> -->
<!-- 							<label for="filter_tambom">เขตพื้นที่: </label> -->
<!-- 							<input type="hidden" id="filter_tambom_hidden" value=""/> -->
<!-- 							<select id="filter_tambom" name="filter_tambom"> -->
<!-- 								<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>	 -->
<!-- 							</select> -->
<!-- 						</div> -->

 						<div class="form-group"> 
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">
								<label for="filter_coop">สหกรณ์: </label>
								<input type="hidden" id="filter_coop_hidden" value=""/>
								<select id="filter_coop" name="filter_coop">
								<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>	
								</select>
							</div>	
						</div>
 						<!--<div class="form-group"> 
						 	<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 6px;">				
								<label for="life_status">สถานะ: </label>
								<select id="filter_life_status" name="filter_life_status">
										<option value="0">ทั้งหมด</option>									
										<option value="1">ปกติ</option>
										<option value="2">ตาย</option>
								</select>
							</div>
						</div>-->
						<!-- <div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 6px;">				
								<label for="life_status">จำนวนสหกรณ์ที่เป็นสมาชิก: </label>
								<select id="filter_more_coop" name="filter_more_coop">	
										<option value="0">ทั้งหมด</option>								
										<option value="1">เป็นสมาชิก 1 สหกรณ์</option>
										<option value="2">เป็นสมาชิก 2  สหกรณ์</option>
										<option value="3">ตั้งแต่ 3 สหกรณ์ขึ้นไป</option>
								</select>
							</div>
						</div> -->
<!-- 						<div class="container-fluid col-md-5 col-xs-12"  style="margin-top: 6px;"> -->				
<!-- 							<label for="flag">ตรวจสอบ: </label> -->
<!-- 							<select id="filter_flag" name="filter_flag"> -->
<!-- 									<option value="">ทั้งหมด</option>									 -->
<!-- 									<option value="0">ตรวจสอบไม่พบในฐานข้อมูล</option> -->
<!-- 									<option value="1">ตรวจสอบพบในฐานข้อมูลโดยเลขประจำตัวประชาชน</option> -->
<!-- 									<option value="2">ตรวจสอบพบในฐานข้อมูลโดยชื่อตัวชื่อสกุลและมี 1 คน</option> -->
<!-- 									<option value="3">ตรวจพบในฐานข้อมูลโดยชื่อตัวชื่อสกุลแต่มีมากกว่า 1 คน</option> -->
<!-- 							</select> -->
<!-- 						</div>		 -->
								
								
								
							<div>
								<center>
									<div id="btnchange">
										<button id="search_btn" class="btn btn-outline-purple"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
									</div>
								</center>
							</div>
						
					</form>

					
					</div>
					<!-- <div id="result_view"  class="container-fluid col-md-12 col-xs-12 display" style="margin-top: 13px;">
						<div class="container-fluid col-md-10 col-xs-10" >
							<div><lable style='color:blue'>จำนวนผลการค้นหา  :</lable></div>
						</div>	
						
							
					</div> -->
					<div style="margin: 25px 0 0;">
						<span id="result_view" class="display"><lable style='font-weight: 500;'>จำนวนผลการค้นหา  :</lable></span>
						<span id="search_result"></span>
					</div>
				</div>
				<?php //if ($total_number>0):?>
			    <div class="row">
					<div class="actions" style="float:right">
			    		<script>
							function downloadExcel()
							{

								// $("#pageLoading").fadeIn();
								var province = $('#filter_province_hidden').val();
								var filter_district = $('#filter_district_hidden').val();
								var khet = $('#filter_khet_hidden').val();
								var filter_coop = $('#filter_coop_hidden').val();

								var filter_life_status	= $('#filter_life_status').val();
								var filter_more_coop = $('#filter_more_coop').val();



								if(filter_coop =='0')
								{
									filter_coop='';
								}

								if(province =='0')
								{
									province='';
								}
								if(filter_more_coop =='0')
									{
									filter_more_coop='';
									}

								if(filter_life_status =='0')
								{
									filter_life_status ="";
									}



								
								var url = "/index.php/report2/exportTotalResultNomalOrDieOfCoop?khet="+khet+"&province="+province+"&filter_coop="+filter_coop+"&filter_life_status="+filter_life_status+"&filter_more_coop="+filter_more_coop;
// 								var filter_year = $('#filter_year option:selected').val();
// 								var filter_province = $('#filter_province option:selected').val();
// 								var filter_coop = $('#filter_coop option:selected').val();	
								var win = window.open(url, '_blank');
								// $.ajax({
								// 	url: '/index.php/report2/exportTotalResultNomalOrDieOfCoop',
								// 	data: {
								// 		khet : khet,
								// 		province : province,
								// 		filter_coop : filter_coop,
								// 		filter_life_status : filter_life_status,
								// 		filter_more_coop : filter_more_coop,
								// 	},
								// 	type:"GET",
								// 	success: function () {
								         
								//       }
								// });
								// $("#pageLoading").fadeOut();
							}
			    		</script>
			    		
				    </div>		
			    
			    </div>	
			    <?php //endif?>			
				
			    <div class="row">


					<div id="result_view_table" class="display row report-result">
					
						<div class="container-fluid col-md-12 col-xs-12" style="padding-left:0px;" >
									<!-- <strong>จำนวนผลลัพธ์ทั้งหมด:</strong> <?php //echo $total_number?><br/> -->	
									<?php if ($total_number>0):?>								
										<?php	
										$displaying_page = 10;
										$range = 1;
										
											$total_page = ceil($total_number/$range);
											$start = $current_page*$range;
											$end = ($start+$range)>$total_number? $total_number:$start+$range;	
									
											$first_page = 0;
											$last_page = $first_page+$displaying_page;
											if ($current_page < ($displaying_page/2))
											{
												$first_page = 0;
											}
											if (($current_page+$displaying_page/2) > $total_page)
											{
												$first_page = $total_page-$displaying_page;											
												$last_page = $total_page;
											}									
											if ($total_page<($first_page+$displaying_page))
											{
												$last_page = $first_page+$displaying_page;
											}
											if ($first_page<0) $first_page = 0;
											if ($last_page>$total_page) $last_page = $total_page;
										?>
	
										
										<strong>กำลังแสดงผลรายการ:</strong> <?php echo $start+1?> ถึง <?php echo $end?><br/>	
										
										<?php if($total_page>1):?>
										<ul class="pagination">
											<?php for($i=$first_page;$i<$last_page;$i++):?>
											<?php if ($current_page==$i):?>
												<li class="page-item  active"><a class="page-link" href="#"><?php echo $i+1?></a></li>
											<?php else:?>
												<li class="page-item"><a class="page-link" href="<?php echo site_url('report2/index2')?>?frompost=yes&filter_year=<?php echo $filter_year?>&filter_province=<?php echo $filter_province?>&filter_coop=<?php echo $filter_coop?>&page=<?php echo $i?>&range=<?php echo $range?>"><?php echo $i+1?></a></li>
											<?php endif?>
											<?php endfor;?>
										</ul>
										<?php endif?>
									
									<?php endif?>
									
								</div>
							
							
						<table id="example"  class="stripe">
							<div id="btn-export" class="display" style="float: right;">
					        	<a onclick="downloadExcel();" class="btn btn-save-dl gc-export">
									<img  src="<?php $this->load->helper('properties_helper');
					     	 print_r(getStringSystemProperties("icon-excel", "/assets/default/images/icon-excel.png"))?>">
									<span class="btn-text hidden-xs">บันทึกเป็น EXCEL</span>
								</a>
							</div>
							<thead>
								<tr>
									<th>ชื่อสหกรณ์</th>
									<th>จังหวัด</th>
									<th>เขต|อำเภอ</th>
									<th>จำนวนสมาชิกปกติ</th>
									<th>จำนวนสมาชิกตาย</th>
									<th>จำนวนสมาชิกทั้งหมด</th>
								</tr>
							</thead>
						</table>
						<?php if ($total_number>0 && !empty($surveys)):?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
								
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" ></lable>
								</div>

								
								<div class="container-fluid col-md-12 col-xs-12" style="" >
									
									<ul style="list-style: none;list-style: none;padding-left: 0;margin-top:20px">
									
									<?php foreach ($surveys as $k=>$v):?>
										
										<li style="background-color:#eeeeee;padding-top:8px;padding-bottom:8px;padding-left:16px;width:90%;margin-top: 3px;border-bottom:1px #ddd">
										
										<?php if(!empty($coop)):?>
										
										<?php echo $v['citizen_firstname']?> <?php echo $v['citizen_lastname']?> ( หมายเลขบัตรประชาชน <a href="<?php echo site_url('report2/index1')?>?citizen_id=<?php echo $v['citizen_id']?>"><?php echo $v['citizen_id']?></a>  - <?php if (!empty($v['PROVINCE_NAME'])):?><?php echo $v['PROVINCE_NAME']?>)<?php endif?>
										
										<?php endif?>
										
										</li>
										
										
									<?php endforeach;?>
									
									</ul>
								</div>
							</div>
						</div>
						
						<?php else:?>
						
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<!-- <lable for id="coop_member_id" style="font-color:red">ไม่พบข้อมูล!!</lable> -->
								
								</div>								
							</div>
						</div>
						
						<?php endif?>
	
					</div>
				</div>
			</div>
			

		<!-- </div>
	</div> -->
</div>
<div id="test">
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 500px">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header" style="height: 45px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>
      
    </div>
  </div>
  </div>
<style>
<!--

-->
#dt-buttons
{
	float: right;
}
/*#example_length
{
	display:none;
}*/
div.dataTables_wrapper div.dataTables_processing {
   top: 0;
}
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
.display
{
	display:none;
}
table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}
/* #example_length,#example_info,#example_paginate */
/* { */
/* 	display: none!important; */
/* } */
</style>

  
<!--   <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
<!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script> -->
  
  
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <link rel="stylesheet" href="/resources/demos/style.css"> -->
<!--   <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

function registerCoop(){
	$('#filter_coop').select2({
		ajax: {
			placeholder: "เลือกสหกรณ์",
		    url: '<?php echo site_url('report2/ajax_coops')?>',
		    dataType: 'json',
		    delay: 250,
		    data: function (params) {
		      return {
		        keyword: params.term, // search term
		        page: params.page
		      };
		    },
		    processResults: function (data, params) {
		      // parse the results into the format expected by Select2
		      // since we are using custom formatting functions we do not need to
		      // alter the remote JSON data, except to indicate that infinite
		      // scrolling can be used
		      params.page = params.page || 1;
	
		      console.log(data);
		      return {
		        results: data.items,
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
		      };
		    },
		    cache: true
		  },
	      /* below part is rendered by jsp so that it has the value from previous form submission; if it is initial form render the below part is not included */
	      initSelection : function (element, callback) {
		      
		        callback({id:"<?php if (isset($coop['REGISTRY_NO_2'])):?><?php echo $coop['REGISTRY_NO_2']?><?php endif?>",name:"<?php if (isset($coop['COOP_NAME_TH'])):?><?php echo $coop['COOP_NAME_TH']?><?php endif?>","text":"<?php if (isset($coop['COOP_NAME_TH'])):?><?php echo $coop['COOP_NAME_TH']?><?php endif?>"});
	      },
	      width: '100%',
		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		  minimumInputLength: 1,
		  templateResult: formatRepo, // omitted for brevity, see the source of this page
		  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	});
}

function formatRepo (serie) {
	if (serie.loading) return serie.name;
    var markup = '<div class="clearfix">' +
    '<div clas="col-sm-10">' +
    '<div class="clearfix">' +
    '<div class="col-xs-12">' + serie.name + '</div>' +
    '</div>';
    markup += '</div></div>';
    return markup;
}

function formatRepoSelection (serie) {
// 	console.log(serie);
	return serie.name;
}

$('#filter_tambom').each(function( index ) {
	$(this).select2({
		  placeholder: "เขตพื้นที่"
		});
	});
	
// $('#filter_district').each(function( index ){
// 	$(this).select2({
// 		placeholder: "เลือกอำเภอ|เขต"
// 		});
// 	$(this).attr('disabled',true);
// });

$('#filter_province').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกจังหวัด"
		});
	$(this).attr('disabled',true);
});

$('#filter_year').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกปี"
		});
	$(this).attr('disabled',true);
});

$('#filter_life_status').each(function( index ) {
	$(this).select2({
		  placeholder: "สถานะ",
		  width:'100px'
		});
	
});

$('#filter_flag').each(function( index ) {
	$(this).select2({
		  placeholder: "ตรวจสอบ"
		});
});
$('#filter_coop').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกสหกรณ์"
		});
	$(this).attr('disabled',true);
	
});
$('#filter_khet').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกเขตตรวจราชการ"
		});
	$(this).attr('disabled',true);
});

$('#filter_more_coop').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกจำนวนสหกรณ์ที่เป็นสมาชิก"
		});
	$(this).attr('disabled',true);
});

$( "#filter_khet" ).change(function() {
	$('#filter_coop').trigger('change.select2');
	$('#filter_province').trigger('change.select2');
	$('#filter_province').val('');
	$('#filter_province_hidden').val('');
	
	$('#filter_coop').val('');
	$('#filter_coop_hidden').val('');
	
	$('#filter_province').attr('disabled',true);
	$('#filter_coop').attr('disabled',true);
	$('#filter_khet_hidden').val($('#filter_khet').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_province')?>/'+$('#filter_province_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
	$('#filter_more_coop').attr('disabled',false);
	getlistProvine();
	getCoop();

});

$( "#filter_province" ).change(function() {
	$('#filter_coop').trigger('change.select2');
	$('#filter_coop_hidden').val('');
	
	$('#filter_coop').attr('disabled',true);
	$('#filter_province_hidden').val($('#filter_province').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_province')?>/'+$('#filter_province_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
	if(typeof xhr != 'undefined')
		xhr.abort();
	
	getCoop();
	

});

$('#filter_district').change(function() {
	$('#filter_district_hidden').val($('#filter_district').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_district')?>/'+$('#filter_district_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
	getCoop();
});

$('#filter_coop').change(function() {
	$('#filter_coop_hidden').val($('#filter_coop').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_coop')?>/'+$('#filter_coop_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
	
// 	getCoop();
});




getlistkhet();
//getdataViewTable();



var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_province')?>/<?php echo $filter_province?>';
$.get( urlAjaxSetProvinceFilter, function( data ) {});


function getlistProvine()
{

	$('#filter_district').attr('disabled',true);
	var khet = $('#filter_khet_hidden').val();

	$.ajax({
		url:'<?php echo site_url('report2/getlistProvince')?>',
		dataType:'json',		
		data:{khet:khet},
		success:function (result) {

				var html ='';
				if(result.items.length >1)
				var html ='<option value="0">ทั้งหมด</option>';
				
				for(var i=0;i<result.items.length;i++)
				{
					html +='<option value="'+result.items[i].id+'">'+result.items[i].name+'</option>';
					if(result.items.length ==1)
					{
						$('#filter_province_hidden').val(result.items[i].id);
					}
					
				}
				console.log("html province");
				console.log(html);
				$('#filter_province').html(html);
				$('#filter_province').attr('disabled',false);
	
				if(result.items.length ==1)
				{
					
					if(typeof xhr != 'undefined')
						xhr.abort();
					
					getCoop();
				}
			}

	});
}





function getDistrict()
{
	var province = $('#filter_province_hidden').val();
	$.ajax({
		url: '<?php echo site_url('report2/ajax_District')?>',
	    dataType: 'json',
	    data:{province:province},
	    success: function (result) {
		    console.log("ajax_District");
		    console.log(result.items);
		    var html ='<option value="0">ทั้งหมด</option>';
			for(i=0;i<result.items.length;i++)
			{
// 				if(i==0){
// 					html +='<option value="'+result.items[i].id+'"selected>'+result.items[i].name+'</option>';
// 					$("#filter_district_hidden").val(result.items[i].id);
// 					}else{
						html +='<option value="'+result.items[i].id+'">'+result.items[i].name+'</option>';
// 						}
			}
			
			$('#filter_district').html(html);
			$('#filter_district').attr('disabled',false);
			getCoop();
	      }
		 
	});
}
var xhr;
function getCoop()
{
	$('#filter_district_hidden').val($('#filter_district').val());
	var province = $('#filter_province_hidden').val();
	var filter_district = $('#filter_district_hidden').val();
	var filter_khet = $('#filter_khet_hidden').val();
	
	xhr = $.ajax({
		url: '<?php echo site_url('report2/ajax_coop')?>',
	    dataType: 'json',
	    data:{province:province,filter_district:filter_district,filter_khet:filter_khet},
	    success: function (result) {
	    	console.log("ajax_coop");
		    console.log(result.items);
		    var html ='<option value="0">ทั้งหมด</option>	';
			for(i=0;i<result.items.length;i++)
			{

// 				if(i==0){
// 					html +='<option selected value="'+result.items[i].id+'">'+result.items[i].name+'</option>';
// 					$("#filter_coop_hidden").val(result.items[i].id);
// 					}else{
						html +='<option value="'+result.items[i].id+'">'+result.items[i].name+'</option>';
// 						}
			}
			
			$('#filter_coop').html(html);
			$('#filter_coop').attr('disabled',false);
// 			getlistProvine();
// 			getCoop();
			$('#filter_more_coop').attr('disabled',false);
	      }
	});
}


function getlistkhet()
{
	
	$.ajax(
	{
		url:'/index.php/report2/getlistKhet',
		dataType: 'json',
		success:function(result){
			console.log('getlistkhet');
			console.log(result.items);

			var html ='';

			if (result.check) {
				html +='<option selected value="0">ทั้งหมด</option>';
				$("#filter_khet_hidden").val('0');
			}

			for(var i = 0;i<result.items.length;i++)
				{
				if(i==0){
					if(result.items[result.items.length-1].COL004 == 99){
						html +='<option value="'+result.items[result.items.length-1].COL004+'">'+result.items[result.items.length-1].COL003+'</option>';
					}
					if (result.items) {
							html +='<option value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
							$("#filter_khet_hidden").val('0');
					}else{
						html +='<option selected value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
						$("#filter_khet_hidden").val(result.items[i].COL004);
					}
				}else if(result.items[i].COL004 < 20){
						html +='<option value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
				}
			}
			$('#filter_khet').html(html);
			$('#filter_khet').attr('disabled',false);
			getlistProvine();
			getCoop();
			$('#filter_life_status').attr('disabled',false);
			$('#filter_more_coop').attr('disabled',false);
			}
			
	});
}


function getdataViewTable(filter_life_status, filter_year,citizen_id,province,filter_district,khet,filter_more_coop,filter_coop)
{
	$("#pageLoading").fadeIn();
	var query=true;
	$.ajax({
		url:"getTotalResultNomalOrDieOfCoop",
	    type:"GET",
	    dataType: 'json',
	    data:{
	    	 filter_year:filter_year,
	    	  province:province,
	    	  filter_khet:khet,
	    	  query:query,
	    	  filter_more_coop:filter_more_coop,
	    	  start:0,
	    	  length:-1,
	    	  filter_coop:filter_coop,
	    	  filter_life_status:filter_life_status,
	    	  filter_life_status:filter_life_status,
	       },
	       success:function(result){
	    	   console.log(result);
	    	   $('#data_respone').html(result.query);
	    	   $('#search_result').html(result.numrow);
	       }
    	
		});
	$('#example').DataTable().destroy();
	$.fn.dataTable.ext.errMode = 'throw';

    var table =$('#example').DataTable({
    	 pageResize: true,
		 "bServerSide": true,
		 "autoWidth": false,
		drawCallback: function( settings ) {
		 	console.log('callback')
	        $("#pageLoading").fadeOut();
	    },
		initComplete : function() {
		        $('#search_btn').prop('disabled', false);
		        $('#pageLoading').fadeOut();	
		},
		"columns": [
			{ "width": "auto" },
			{ "width": "auto" },
			{ "width": "auto" },
			{ "width": "auto","className": "text-right" },
			{ "width": "auto","className": "text-right" },
			{ "width": "auto","className": "text-right" }
		],
		"language": {
			"emptyTable":     "ไม่พบข้อมูลที่ค้นหา",
			"info":           "จำนวน _START_ ถึง _END_ ของจำนวนทั้งหมด    _TOTAL_ สหกรณ์",
			"infoEmpty":      "แสดงจำนวน  0 ถึง  0 ของจำนวนทั้งหมด  0 คน",
			"lengthMenu":     "แสดงจำนวน  _MENU_ ",
			"search":         "ค้นหา : ",
			"loadingRecords": "",
			"paginate": {
			"next":       ">",
			"previous":   "<"
			}
		},
		'columnDefs': [
			{
		    	"targets": 3, // your case first column
		    	"className": "text-right",
		    	"width": "4%"
			}
		],
		"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		"ordering": false,
		ajax : {
			url:"getTotalResultNomalOrDieOfCoop",
			type:"GET",
			data:{
					citizen_id:citizen_id,
				    province:province,
				    filter_khet:khet,
				    filter_more_coop:filter_more_coop,
			    	filter_coop:filter_coop,
			    	filter_life_status:filter_life_status
				}
	    },
	   	error: function(){
	   		$("#pageLoading").fadeOut();
	   		/*$('#error-box').html('มีข้อผิดพลาดเกิดขึ้น ไม่สามารถดึงข้อมูลได้').show();
	   		$('html,body').animate({
		        scrollTop: $('#error-box').offset().top - 100
		    }, 'slow');
			setInterval(function(){
		        $('#error-box').fadeOut();
		    }, 5000);*/
		    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
		    $("#message-modal").modal();
		    $('#filter-search').prop('disabled', false);
	   	} 
	});
    table.on( 'preDraw', function () {
 		 $("#pageLoading").fadeIn();
		 console.log('preDraw')
		if(typeof table != 'undefined')
			table.settings()[0].jqXHR.abort();
	});
    
}


var width = 0;
$(document).ready(function() {
	$('#trip-luckyForm').submit(function(e){
		var filter_life_status	= $('#filter_life_status').val();
		var filter_count_coop	= $('#filter_count_coop').val();
		var filter_year 		= $('#filter_year').val();
		var citizen_id 			= $('#citizen_id').val();
		var filter_flag 		= $('#filter_flag').val();
		
		var filter_more_coop = $('#filter_more_coop').val();
		var province = $('#filter_province_hidden').val();
		var filter_district = $('#filter_district_hidden').val();
		var khet = $('#filter_khet_hidden').val();
		var filter_coop= $('#filter_coop_hidden').val();


		if(filter_coop =='0')
		{
			filter_coop='';
		}

		if(province =='0')
		{
			province='';
		}
		if(filter_more_coop =='0')
			{
			filter_more_coop='';
			}

		if(filter_life_status =='0')
		{
			filter_life_status ="";
			}



		
		if(khet !=''){
			$('#result_view').removeClass('display');
			$('#result_view_table').removeClass('display');
			$('#search_btn').prop('disabled', true);
			getdataViewTable(filter_life_status, filter_year,citizen_id,province,filter_district,khet,filter_more_coop,filter_coop);
			$('#btn-export').removeClass('display');
		}else{
			
				var html = '<div class="" style="font-size:20px;"  >';
				html += '<div class="row">';
				html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:  center;">';
				html += '<lable for id="coop_member_id" style="font-color:red">กรุณาเลือกเงื่อนไขสำหรับการค้นหา</lable>';
				html += '</div>	';			
				html += '</div>';
				html += '</div>';
				$('.modal-body').html(html);
				$('#myModal').modal({backdrop: 'static', keyboard: false}) ;
			}
			return false;
		});
	
});
</script>

