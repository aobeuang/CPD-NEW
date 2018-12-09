<script src="/assets/default/js/angular.min.js"></script>
<script src="https://code.angularjs.org/1.7.5/angular-sanitize.min.js"></script>
<!--<script src="/assets/default/js/angular-select2.min.js"></script>-->
<script src="/assets/default/js/ui.select2.js"></script>



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

<div id="main-wrapper" class="report-content" ng-app="report4new">
	<p>Page Code : RE300NEW</p>

			
			<div class="container-fluid col-md-12 col-xs-12" ng-controller="report4newController">
				
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
							</div>
						</div>
						<div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">
								<label for="filter_district">เขตตรวจราชการ: </label>
								<input type="hidden" id="filter_khet_hidden" value=""/>
<!--								<select id="filter_khet" name="filter_khet">-->
<!--									<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>-->
<!--								</select>-->

<!--                                <select2 ng-model="values.query" options="queryOptions"></select2>-->

                                <select id="filter_khetCode" ng-model="khetCode" name="khetCode" ng-change="changeKhet()" style="width: 220px">
                                    <option value="">ทั้งหมด</option>
                                    <option ng-repeat="row in resultKhet track by $index" value="{{row.KHET_CODE}}">{{row.KHET_NAME}}</option>
                                </select>

							</div>
						</div>
						<div class="form-group">
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">				
								<label for="filter_province">จังหวัด: </label>		
								<input type="hidden" id="filter_province_hidden" value=""/>
								<?php $all_provinces = getAllProvinces();?>
<!--								<select id="filter_province" name="filter_province">-->
<!--									<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>-->
<!--								</select>-->
<!--                                {{ resultProvince}}-->
                                <select id="filter_provinceId" ng-model="provinceId" name="provinceId" ng-change="changeProvince()" style="width: 220px">
                                    <option value="">ทั้งหมด</option>
                                    <option ng-repeat="row in resultProvince track by $index" value="{{row.PROVINCE_ID}}">{{row.PROVINCE_NAME}}</option>
                                </select>
							</div>
						</div>


 						<div class="form-group"> 
							<div class="container-fluid col-md-12 col-xs-12"  style="margin-top: 13px;">
								<label for="filter_coop">สหกรณ์: </label>
								<input type="hidden" id="filter_coop_hidden" value=""/>
<!--								<select id="filter_coop" name="filter_coop">-->
<!--								<option value="">อยู่ระหว่างการหาข้อมูลเพิ่มเติม</option>	-->
<!--								</select>-->

                                <select id="filter_coop" ng-model="coopId" name="coopId" style="width: 250px">
                                    <option value="">ทั้งหมด</option>
                                    <option ng-repeat="row in resultCoop track by $index" value="{{row.COOP_ID}}">{{row.COOP_NAME_TH}}</option>
                                </select>
							</div>	
						</div>

								
								
								
							<div>
								<center>
									<div id="btnchange">
										<button id="search_btn"
                                                ng-click="doFilterAvailableMember()"
                                                class="btn btn-outline-purple"><span class="glyphicon glyphicon-search"></span> ค้นหา</button>
									</div>
								</center>
							</div>
						
					</form>

					
					</div>

					<div style="margin: 25px 0 0;">
						<span id="result_view" class="display"><lable style='font-weight: 500;'>จำนวนผลการค้นหา  :</lable></span>
						<span id="search_result"></span>
					</div>
				</div>
				<?php //if ($total_number>0):?>
			    <div class="row">
					<div class="actions" style="float:right">
			    		<script>

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


//getdataViewTable();




</script>

<script type="text/javascript">

    var report4new= angular.module('report4new', ['ngSanitize', 'ui.select2']);


    report4new.controller('report4newController', function MyController($scope) {


        $('#filter_khetCode').select2();
        $('#filter_provinceId').select2();
        $('#filter_coop').select2();


        $scope.queryAuthKhet = function() {

            $scope.resultKhet = {};

            $('#pageLoading').fadeIn();
            $.ajax({
                url:"queryAuthKhet",
                type:"GET",
                dataType: 'json',
                success:function(result){

                    // $scope.resultListYearly = result;
                    $scope.resultKhet = result;
                    if (result.length == 1) {
                        $scope.khetCode = result[0].KHET_CODE;
                        $scope.queryAuthProvince($scope.khetCode);
                    }
                    else {

                        $scope.queryAuthProvince(null);
                    }


                    $('#pageLoading').fadeOut();
                    $scope.$apply();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... ' + errorThrown);

                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);

                    $('#pageLoading').fadeOut();
                }
            })
        };

        $scope.queryAuthProvince = function(khetCode) {
            console.log('queryAuthProvince>' + khetCode)

            $scope.resultProvince = {};

            $('#pageLoading').fadeIn();
            $.ajax({
                url:"queryAuthProvince",
                type:"GET",
                dataType: 'json',
                data : {
                    "khetCode" : khetCode
                },
                success:function(result){

                    // $scope.resultListYearly = result;
                    $scope.resultProvince = result;

                    if (result.length == 1) {
                        $scope.provinceId = result[0].PROVINCE_ID;
                        $scope.queryAuthCoop($scope.khetCode, $scope.provinceId);
                    }
                    else {

                        $scope.queryAuthCoop(null, null);
                    }



                    $('#pageLoading').fadeOut();
                    $scope.$apply();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... ' + errorThrown);

                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);

                    $('#pageLoading').fadeOut();
                }
            })
        };

        $scope.queryAuthCoop = function(khetCode, provinceId) {
            console.log('queryAuthProvince>' + khetCode)

            $scope.resultCoop = {};

            $('#pageLoading').fadeIn();
            $.ajax({
                url:"queryAuthCoop",
                type:"GET",
                dataType: 'json',
                data : {
                    "khetCode" : khetCode,
                    "provinceId" : provinceId
                },
                success:function(result){

                    // $scope.resultListYearly = result;
                    $scope.resultCoop = result;



                    $('#pageLoading').fadeOut();
                    $scope.$apply();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... ' + errorThrown);

                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);

                    $('#pageLoading').fadeOut();
                }
            })
        };

        $scope.changeKhet = function() {
            $scope.queryAuthProvince($scope.khetCode);
        }

        $scope.changeProvince = function() {
            $scope.queryAuthCoop($scope.khetCode, $scope.provinceId);
        }

        $scope.doFilterAvailableMember = function() {
            console.log('queryAuthProvince>' + khetCode)

            $scope.resultCoop = {};

            $('#pageLoading').fadeIn();
            $.ajax({
                url:"queryAuthCoop",
                type:"GET",
                dataType: 'json',
                data : {
                    "khetCode" : khetCode,
                    "provinceId" : provinceId
                },
                success:function(result){

                    // $scope.resultListYearly = result;
                    $scope.resultCoop = result;



                    $('#pageLoading').fadeOut();
                    $scope.$apply();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... ' + errorThrown);

                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);

                    $('#pageLoading').fadeOut();
                }
            })
        };

        $scope.queryAuthKhet();
        // $scope.queryAuthProvince(null);


        $scope.resultList = {};


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





    });
</script>