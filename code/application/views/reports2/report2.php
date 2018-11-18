
<?php 
$this->load->helper('form');
$this->load->helper('survey');


$coop = is_numeric($filter_coop) ? getCoopByID($filter_coop) : array();
										
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<div class="report-content" id="report">

<div id="main-wrapper">
	<!-- <p>Page Code : CPD002</p> -->	
	<div class="container-fluid col-md-12 col-xs-12" >
		
		<div class="row" style="text-align:left">
		
		
			<h2 style="text-align:left"><span class="glyphicon glyphicon-th-list"></span> รายงานข้อมูลสมาชิกในสหกรณ์</h2>
			
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
				<div class="form-group">
				<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 6px;">				
					<label for="life_status">สถานะสมาชิก : </label>
					<select id="filter_life_status" name="filter_life_status">
							<option value="0" selected="selected">ทั้งหมด</option>									
							<option value="1">ปกติ</option>
							<option value="2">ตาย</option>
					</select>
				</div>
				
				</div>
				<div class="form-group">
					<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 6px;">				
						<label for="life_status">จำนวนสหกรณ์ที่เป็นสมาชิก: </label>
						<select id="filter_more_coop" name="filter_more_coop">	
								<option value="0" selected="selected">ทั้งหมด</option>								
								<option value="1">เป็นสมาชิก 1 สหกรณ์</option>
								<option value="2">เป็นสมาชิก 2  สหกรณ์</option>
								<option value="3">ตั้งแต่ 3 สหกรณ์ขึ้นไป</option>
						</select>
					</div>
				</div>
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
						
						
						
					<div class="floatR">
						<center>
							<button class="btn btn-outline-purple" id="filter-search"><span class="glyphicon glyphicon-search"></span>  ค้นหา</button>		
						</center>
					</div>
				
			</form>

			
			</nav>
			
		</div>
		
		<!-- <div id="myProgress" class="display" style="margin-bottom: 45px;margin-top: 10px;">
			  <div id="myBar">0%</div>
		</div> -->

		
       <!--  <div class="" style="margin-top:-10px; margin-bottom:30px;">
			<div id="result_view" class="container-fluid display" style="margin-top: 13px;">
				<div class="container-fluid col-md-10 col-xs-10" >
							
							<div><lable style=''>จำนวนผลการค้นหา  :</lable></div>
				</div>	
				
					
			</div>
			<div class="container-fluid " style="margin-top: 13px;">
				<div class="container-fluid col-md-12 col-xs-12" >
							<div id="search_result"></div>
				</div>	
			</div>                
        
        </div> -->
		
		<div style="margin: 25px 0 0;">
			<span id="result_view" class="display"><lable id='label_search' style='font-weight: 500;'></lable></span>
			<span id="search_result"></span>
		</div>
		<?php //if ($total_number>0):?>
	    <div class="row">
			<div class="actions" style="float:right">
	    		<script>
					function downloadExcel()
					{
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

						
						var url = "/index.php/report2/exportdatacsv?khet="+khet+"&province="+province+"&filter_coop="+filter_coop+"&filter_life_status="+filter_life_status+"&filter_more_coop="+filter_more_coop;
						var win = window.open(url, '_blank');
						//window.location.href = "/index.php/report2/exportdatacsv?khet="+khet+"&province="+province+"&filter_district="+filter_district+"&filter_coop="+filter_coop+"&filter_life_status="+filter_life_status;
// 								var filter_year = $('#filter_year option:selected').val();
// 								var filter_province = $('#filter_province option:selected').val();
// 								var filter_coop = $('#filter_coop option:selected').val();								
// 								 $.ajax({
// 									url:"/index.php/report2/exportdatacsv",
// 									type:"GET",
// 									success: function () {
						         
// 								      }
// 								});
					}
	    		</script>
	    		
		    </div>		
	    
	    </div>	
	    <?php //endif?>			
		
	    <div id="result_view_table" class="display row report-result">


			<div class="container-fluid col-md-12 col-xs-12 " >
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
					<!-- <div id="save"> -->
				        <div id="btn-export" class="display" style="float: right;">
				        	<a onclick="downloadExcel();" class="btn btn-save-dl gc-export">
								<img  src="<?php $this->load->helper('properties_helper');
				     	 print_r(getStringSystemProperties("icon-excel", "/assets/default/images/icon-excel.png"))?>">
								<span class="btn-text hidden-xs">บันทึกเป็น EXCEL</span>
							</a>
						</div>
			        <!-- </div> -->
					<thead>
						<tr>
							<th>เลขบัตรประชาชน</th>
							<th>คำนำหน้า</th>
							<th>ชื่อ</th>
							<th>นามสกุล</th>
							<th>สถานะสมาชิก</th>
							<th>จังหวัด</th>
							<th>ชื่อ สหกรณ์</th>
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
.text-center 
{
	text-align: center;
}

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
		  width: '100px'
		});
	$('#filter_life_status').attr('disabled',true);
	
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
	$('#filter_coop').attr('disabled',true);
	
});
$('#filter_khet').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกเขตตรวจราชการ"
		});
	$('#filter_khet').attr('disabled',true);
});

$('#filter_more_coop').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกจำนวนสหกรณ์ที่เป็นสมาชิก"
		});
	$('#filter_more_coop').attr('disabled',true);
});

$( "#filter_khet" ).change(function() {
	$('#filter_coop').trigger('change.select2');
	$('#filter_province').val('');
	$('#filter_province_hidden').val('');
	
	$('#filter_coop').trigger('change.select2');
	$('#filter_coop').val('');
	$('#filter_tambom').trigger('change.select2');
	$('#filter_tambom').val('');

	$('#filter_district').trigger('change.select2');
	$('#filter_district').val('');

	$('#filter_coop_hidden').val('');


	$('#filter_province').attr('disabled',true);
	$('#filter_coop').attr('disabled',true);
	$('#filter_khet_hidden').val($('#filter_khet').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_province')?>/'+$('#filter_province_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
	// console.log("test");
	getlistProvine();
	getCoop();
	$('#filter_life_status').attr('disabled',false);
	$('#filter_more_coop').attr('disabled',false);

});

$( "#filter_province" ).change(function() {
	$('#filter_coop').trigger('change.select2');
	$('#filter_coop').val('');
	$('#filter_tambom').trigger('change.select2');
	$('#filter_tambom').val('');

	$('#filter_district').trigger('change.select2');
	$('#filter_district').val('');

	$('#filter_coop_hidden').val('');
	
	$('#filter_district').attr('disabled',true);
	$('#filter_coop').attr('disabled',true);
	
	$('#filter_province_hidden').val($('#filter_province').val());
	var urlAjaxSetProvinceFilter = '<?php echo site_url('report2/ajax_set_filter_province')?>/'+$('#filter_province_hidden').val();
	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
// 	console.log(xhr);
	if(typeof xhr != 'undefined')
		xhr.abort();
	
	getCoop();
	

});

// $('#filter_district').change(function() {
// 	$('#filter_district_hidden').val($('#filter_district').val());
//	var urlAjaxSetProvinceFilter = '<?php //echo site_url('report2/ajax_set_filter_district')?>/'+$('#filter_district_hidden').val();
// 	$.get( urlAjaxSetProvinceFilter, function( data ) {});	
// 	getCoop();
// });

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
				// console.log("html province");
				// console.log(html);
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
		    var html ='<option></option>';
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
// 	    	console.log("ajax_coop");
// 		    console.log(result.items);
		    var html ='<option value="0">ทั้งหมด</option>';
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
			// console.log('getlistkhet');
			// console.log(result.items);

			var html ='';

			for(var i = 0;i<result.items.length;i++)
				{
				if(i==0){
					html +='<option selected value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
					$("#filter_khet_hidden").val(result.items[i].COL004);
					}else 
						if(result.items[i].COL004 >=20){
						html +='<option value="'+result.items[i].COL004+'">'+result.items[i].COL003+'</option>';
						}else{
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


function getdataViewTable(filter_life_status, filter_year,citizen_id,province,filter_district,khet,filter_count_coop,filter_more_coop,filter_coop)
{

	var query=true;
	search_result = $.ajax({
		url:"ajax_filter_report2",
	    type:"GET",
	    dataType: 'json',
	    data:{
	    	filter_life_status:filter_life_status,
	    	 filter_year:filter_year,
	    	  citizen_id:citizen_id,
	    	  province:province,
	    	  filter_district:filter_district,
	    	  filter_khet:khet,
	    	  filter_count_coop:filter_count_coop,
	    	  query:query,
	    	  filter_more_coop:filter_more_coop,
	    	  start:0,length:-1,
	    	  filter_coop:filter_coop
	       },
	       success:function(result){
	    	  // $('#data_respone').html(result.items.query);
	    	   //$('#search_result').html(result.items.numrow);

		       }
    	
		});
	//$('#myProgress').removeClass('display');
	$('#example').DataTable().destroy();
	$.fn.dataTable.ext.errMode = 'throw';

	/*var elem = document.getElementById("myBar");   
    
    var time = (((10*0.15)/100)+5)*10;
    var id;

	if(width==0 || width==98){
		id =setInterval(frame, time);
		}

    
    function frame() {
      if (width >= 98) {
        clearInterval(id);
      } else {
        width++; 
        elem.style.width = width + '%'; 
        elem.innerHTML = width * 1  + '%';
        
      }
    }*/


	$("#pageLoading").fadeIn();
    table =$('#example').DataTable({	

        pageResize: true,
    	"destroy": true,
		"bServerSide": true,
		"drawCallback": function( settings ) {
	        $("#pageLoading").fadeOut();
	        // console.log(settings.json.numtotal);
	        $('#label_search').html('จำนวนการค้นหา '+settings.json.numtotal);
	    },
	    initComplete : function() {
		    var test = $('.dataTables_filter').find('#search');
		   	// console.log(test);
	        var input = $('.dataTables_filter input').unbind(),
	            self = this.api(),
	            $searchButton = $('<button id="search">')
	                       .text('ค้นหา')
	                       .click(function() {
	                          self.search(input.val()).draw();
	                       })
	                       ,
	            $clearButton = $('<button>')
	                       .text('ล้างข้อมูล')
	                       .click(function() {
	                          input.val('');
	                          $searchButton.click(); 
	                       }) 
	        //$('.dataTables_filter').append($searchButton);
			$('.dataTables_filter input').on('keyup', function(e) {
				if(e.keyCode == 13) {
					 self.search($('.dataTables_filter input').val()).draw();
				}
			});
			$('#pageLoading').fadeOut();
	        $('#filter-search').prop('disabled', false);
	    },
	    "autoWidth": false,
	    "columns": [
	        { "width": "auto" },
	        { "width": "auto" },
	        { "width": "auto" },
	        { "width": "auto" },
	        { "width": "auto" },
	        { "width": "auto" },
	        { "width": "auto" }
	    ],
	   	"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
	   	"ordering": false,
	   	"language": {
	        "emptyTable":     "ไม่พบข้อมูลที่ค้นหา",
	        "info":           "จำนวน _START_ ถึง _END_ ของจำนวนทั้งหมด    _TOTAL_ คน",
	        "infoEmpty":      "แสดงจำนวน  0 ถึง  0 ของจำนวนทั้งหมด  0 คน",
	        "lengthMenu":     "แสดงจำนวน  _MENU_ ",
	        "search":         "ค้นหา : ",
	        "paginate": {
	            "next":       ">",
	            "previous":   "<"
	        }
	    },
	    'columnDefs': [
	    	{
	    	      "targets": 4, // your case first column
	    	      "className": "text-center",
	    	      "width": "4%"
	    	 }
	    ],
		"ajax" : {
			url:"ajax_filter_report2",
			type:"GET",
			data:{
				filter_life_status:filter_life_status,
			 	filter_year:filter_year,
			  	citizen_id:citizen_id,
				province:province,
				filter_district:filter_district,
				filter_khet:khet,
				filter_count_coop:filter_count_coop,
				filter_more_coop:filter_more_coop,
				filter_coop:filter_coop,
		   	},
		   	error: function(){
		   		$("#pageLoading").fadeOut();
		   		$('#error-box').html('มีข้อผิดพลาดเกิดขึ้น ไม่สามารถดึงข้อมูลได้').show();
		   		$('html,body').animate({
			        scrollTop: $('#error-box').offset().top - 100
			    }, 'slow');
				setInterval(function(){
			        $('#error-box').fadeOut();
			    }, 5000);
			    $('#filter-search').prop('disabled', false);
		   	}

		}  
	});


    var $btnExport = $('#btn-export');
    $btnExport.clone().appendTo('#example_filter').removeClass('display');;
//     console.log(table.settings()[0].jqXHR);
	table.on( 'preDraw', function () {
 		 $("#pageLoading").fadeIn();
// 		 console.log(table.settings());
// 		 console.log(table.settings()[0].oPreviousSearch.sSearch);

// 		if(table.settings()[0].oPreviousSearch.sSearch == "")
// 			{
// // 			table.clear().draw();
// 			table.settings().destroy();
// 			}


		 
	if(typeof table != 'undefined')
		table.settings()[0].jqXHR.abort();
	});
	$('#myInput').on( 'keyup', function () {
		table.search( this.value ).draw();
	});
		
}



function getUserDetail(citizen_id){
	$("#pageLoading").fadeIn();
	var query=true;
	$.ajax({
		url:"<?php echo site_url('report2/getMemberByCitizenID')?>",
	    type:"GET",
	    dataType: 'json',
	    data:{
	    	citizen_id:citizen_id,
	    	query:query,
	    	check:true,
	    },
       	success:function(result){
    	   //$('#data_respone').html(result.items.query);
    	   // console.log(result.items);
    	   $("#pageLoading").fadeOut();
    	   	if(result.items != null){
    	   		if(result.items == 'nopermission'){
			    	/*$('#error-box').html('ไม่มีสิทธิ์เข้าถึงข้อมูล').show();
					setInterval(function(){
				        $('#error-box').fadeOut();
				    }, 6000);*/
				    $("#msg-modal-txt").html('ไม่สามารถเข้าดูข้อมูลได้');
		    		$("#message-modal").modal();
    	   		}else{
    	   			var road = '';
    	   			var lane = '';
    	   			if(result.items[0].road){
    	   				road = result.items[0].road;
    	   			}
    	   			if(result.items[0].lane){
    	   				lane = result.items[0].lane;
    	   			}
		    		$('#mem_name').text(result.items[0].name + '  '+ result.items[0].surname);
					$('#mem_citizen_id').text(result.items[0].citizen_id);
					var address = result.items[0].hno+' '+lane+' '+road+' '+result.items[0].subd+' '+result.items[0].district;
					$('#mem_addr').text(address + ' ' + result.items[0].province_name);
					var coop_list = '';
					for(var i = 0;i<result.items.length;i++){
				   		coop_list = coop_list+result.items[i].coop_name +'<br>';
				   	}
					$('#mem_coop_name').html(coop_list);
					$('#mem_province_name').text(result.items[0].province_name);
					$("#myModal").modal();
				}
    	   	}else{
    	   		/*$('#error-box').html(result).show();
				setInterval(function(){
			        $('#error-box').fadeOut();
			    }, 6000);*/
			    $("#msg-modal-txt").html('ไม่พบข้อมูลที่ค้นหา');
		    	$("#message-modal").modal();
    	   	}
    	    
	    },
	    error:function(){
	    	$("#pageLoading").fadeOut();
	    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
			setInterval(function(){
		        $('#error-box').fadeOut();
		    }, 5000);*/
		    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
		    $("#message-modal").modal();
	    }
	});
}
// var table = $('#example').DataTable();
var table;
var search_result;
var width = 0;
$(document).ready(function() {
	$('#trip-luckyForm').submit(function(e){
		var filter_count_coop	= $('#filter_count_coop').val();
		var filter_year 		= $('#filter_year').val();
		var citizen_id 			= $('#citizen_id').val();
		var filter_flag 		= $('#filter_flag').val();

		var filter_life_status	= $('#filter_life_status').val();
		var filter_more_coop = $('#filter_more_coop').val();
		var province = $('#filter_province_hidden').val();
		var filter_district = $('#filter_district_hidden').val();
		var khet = $('#filter_khet_hidden').val();
		var filter_coop= $('#filter_coop_hidden').val();
		// console.log(khet);

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
			width = 0;
			$('#result_view').removeClass('display');
			$('#result_view_table').removeClass('display');
			
			if(typeof xhr != 'undefined')
				xhr.abort();
			if(typeof table != 'undefined')
			console.log(table.settings()[0].jqXHR.abort());

			if(typeof search_result != 'undefined')
				search_result.abort();

			
			$('#filter-search').prop('disabled', true);		
			getdataViewTable(filter_life_status, filter_year,citizen_id,province,filter_district,khet,filter_count_coop,filter_more_coop,filter_coop);
			
			}else{
				/*var html = '<div class="" style="font-size:20px;"  >';
				html += '<div class="row">';
				html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:  center;">';
				html += '<lable for id="coop_member_id" style="font-color:red">กรุณาเลือกเงื่อนไขสำหรับการค้นหา</lable>';
				html += '</div>	';			
				html += '</div>';
				html += '</div>';
				$('.modal-body').html(html);
				$('#myModal').modal({backdrop: 'static', keyboard: false}) ;*/
				$('#error-box').html('กรุณาเลือกเงื่อนไขสำหรับการค้นหา').show();
				setInterval(function(){
			        $('#error-box').fadeOut();
			    }, 3000);
			}
		
			return false;
		});


	
});
</script>

<div class="modal fade cpd-modal-info" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <div class="modal-header">
	    	<span class="modal-title" id="ModalTitle" style="display: inline-block;">รายงานข้อมูลรายบุคคล</span>
	      	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="line-height: 0.6;font-size: 38px;">
	          <span aria-hidden="true">×</span>
	        </button>
	    </div>
	    <div class="modal-body">
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>ชื่อสมาชิก:</strong></div>
	    		<div class="col-sm-9" id="mem_name"></div>
	    	</div>
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>หมายเลขบัตรประชาชน:</strong></div>
	    		<div class="col-sm-9" id="mem_citizen_id"></div>
	    	</div>
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>ที่อยู่:</strong></div>
	    		<div class="col-sm-9" id="mem_addr"></div>
	    	</div>
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>สังกัดสหกรณ์:</strong></div>
	    		<div class="col-sm-9" id="mem_coop_name"></div>
	    	</div>
	    	<!-- <div class="row b10">
		    	<div class="col-sm-3 text-right"><strong>จังหวัด:</strong></div>
		    	<div class="col-sm-9" id="mem_province_name"></div>
		    </div> -->
	    </div>
	  </div>
	</div>
</div>
