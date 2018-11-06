<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/css/jquery_plugins/jquery.ui.datetime.css" />
<script src="/assets/grocery_crud/js/jquery_plugins/ui/i18n/datepicker/jquery.ui.datepicker-th.js"></script>
<link type="text/css" rel="stylesheet" href="/assets/grocery_crud/css/jquery_plugins/jquery-ui-timepicker-addon.css" />

<link rel="stylesheet" href="/assets/default/css/jquery-ui.css">
<script src="/assets/default/js/jquery-ui.js"></script>

<link rel="stylesheet" href="/assets/default/css/select2/select2.min.css">
<script src="/assets/default/js/select2/select2.full.min.js"></script>
    
<?php 
     
	$this->load->helper('url');
?>

<style>
    	.behclick-panel  .list-group {
    		margin-bottom: 0px;
		}
		.behclick-panel .list-group-item:first-child {
			border-top-left-radius:0px;
			border-top-right-radius:0px;
		}
		.behclick-panel .list-group-item {
			border-right:0px;
			border-left:0px;
		}
		.behclick-panel .list-group-item:last-child{
			border-bottom-right-radius:0px;
			border-bottom-left-radius:0px;
		}
		.behclick-panel .list-group-item {
			padding: 5px;
		}
		.behclick-panel .panel-heading {
			/* 				padding: 10px 15px;
                            border-bottom: 1px solid transparent; */
			border-top-right-radius: 0px;
			border-top-left-radius: 0px;
			border-bottom: 1px solid darkslategrey;
		}
		.behclick-panel .panel-heading:last-child{
			/* border-bottom: 0px; */
		}
		.behclick-panel {
			border-radius: 0px;
			border-right: 0px;
			border-left: 0px;
			border-bottom: 0px;
			box-shadow: 0 0px 0px rgba(0, 0, 0, 0);
			border-radius: 4px;
		}
		.behclick-panel .radio, .checkbox {
			margin: 0px;
			padding-left: 10px;
		}
		.behclick-panel .panel-title > a, .panel-title > small, .panel-title > .small, .panel-title > small > a, .panel-title > .small > a {
			outline: none;
		}
		.behclick-panel .panel-body > .panel-heading{
			padding:10px 10px;
		}
		.behclick-panel .panel-body {
			padding: 0px;
		}
		 /* unvisited link */
		.behclick-panel a:link {
		    text-decoration:none;
		}

		/* visited link */
		.behclick-panel a:visited {
		    text-decoration:none;
		}

		/* mouse over link */
		.behclick-panel a:hover {
		    text-decoration:none;
		}

		.panel-primary > .panel-heading
		{
			background-color: #aaa;
		}
		.panel-heading
		{
			padding: 5px 20px;
		}
		
		.panel-primary {
    		border-color: #aaa;
		}
		
		.filterable .filters input[disabled] {
		    background-color: transparent;
		    border: none;
		    cursor: auto;
		    box-shadow: none;
		    padding: 0;
		    height: auto;
		}
		.filterable .filters input[disabled]::-webkit-input-placeholder {
		    color: #333;
		}
		.filterable .filters input[disabled]::-moz-placeholder {
		    color: #333;
		}
		.filterable .filters input[disabled]:-ms-input-placeholder {
		    color: #333;
		}		
		
</style>


<div id="main-wrapper">
	<div id="main-container" class="container col-md-12 col-xs-12">
		<h1>ค้นหา</h1>
	</div>
	
	<form action="" method="get">
		 
	<div id="search-filter-left-container" class="container col-md-12 col-xs-12">
		<div class="container-fluid col-xs-12 col-sm-3 col-md-3" >
		    <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div id="accordion" class="panel panel-primary behclick-panel">
						<div class="panel-heading">
							<h3 class="panel-title">กรองการค้นหา</h3>
						</div>
						<div class="panel-body" >

				
							<div class="panel-heading " >
								<h4 class="panel-title">
									<div>
									 <input type="text" name="keyword" value="<?php echo $keyword?>" style="width:70%" placeholder="คำค้นหา"/>
									 <button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" style="margin-top:15px">
	          							<span class="glyphicon glyphicon-search"></span> ค้นหา</button>
									</div>
								</h4>
							</div>
													
							<div class="panel-heading " >
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse0a">
										<i class="indicator fa fa-caret-down" aria-hidden="true"></i> เวิร์คโฟล์ว
									</a>
								</h4>
							</div>
							
							<div id="collapse0a" class="panel-collapse collapse in ">
								<ul class="list-group">
									<!-- li class="list-group-item">
										<div class="checkbox">
											<label>
												<input type="radio" name="filter_workflow" value="all" <?php if ($filter_workflow=="all") echo "checked=\"checked\""?>>
												ทั้งหมด
											</label>
										</div>
									</li-->
									
									<?php if (!empty($current_workflows)):?>
									<?php foreach ($current_workflows as $workflow):?>
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input type="radio" name="filter_workflow" value="<?php echo $workflow['name']?>" <?php if ($filter_workflow==$workflow['name']) echo "checked=\"checked\""?>>
												<?php echo $workflow['name']?>
											</label>

											<select name="filter_workflow_status[<?php echo $workflow['name']?>]" class="workflow_status">
												<?php $wf = trim($workflow['name']);$wf = strtolower($wf);?>
												<option value="all" <?php if ($wf==$filter_workflow) echo "selected=\"selected\""?>>ทุกสถานะงาน</option> 
												<?php if (isset($current_workflow_status[$wf])):?>
													<?php foreach ($current_workflow_status[$wf] as $k=>$v):?>
													<option value="<?php echo $k?>" 
														<?php if ($wf==$filter_workflow && isset($filter_workflow_status[$wf]) && $filter_workflow_status[$wf]==$k) echo "selected=\"selected\""?>>
														<?php echo $k?>
													</option>
													<?php endforeach?>
												<?php endif?>
											</select>
											
										</div>
									</li>
									<?php endforeach;?>
									<?php endif?>									
								</ul>
							</div>							
							
							
							
						
							<div class="panel-heading " >
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse0">
										<i class="indicator fa fa-caret-down" aria-hidden="true"></i> ผู้ได้รับมอบหมาย
									</a>
								</h4>
							</div>
							
						
							
							
							
							
							<div id="collapse0" class="panel-collapse collapse in" >
								<ul class="list-group">
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input type="radio" name="filter_assign_to" value="all" <?php if ($filter_assign_to=="all") echo "checked=\"checked\""?>>
												ทั้งหมด
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox">
											<label>
												<input type="radio" name="filter_assign_to" value="me" <?php if ($filter_assign_to=="me") echo "checked=\"checked\""?>>
												งานของฉัน
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input id="filter_assign_to_other" type="radio" name="filter_assign_to" value="other" <?php if ($filter_assign_to=="other") echo "checked=\"checked\""?>>
												งานของผู้ใช้ท่านอื่น
											</label>
										</div>
										<div style="padding-top:10px">
											<select id="filter_assign_to_other_users" name="filter_assign_to_user">
											  <option value="<?php echo $filter_assign_to_user?>" selected="selected"><?php echo $filter_assign_to_user?></option>
											</select>										
										</div>
									</li>									
								</ul>
							</div>

							
		
							<div class="panel-heading " >
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse1">
										<i class="indicator fa fa-caret-down" aria-hidden="true"></i> ความเร่งด่วน
									</a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse in" >
								<ul class="list-group">
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_priority" value="all" <?php if ($filter_priority=="all") echo "checked=\"checked\""?>>
												ทั้งหมด
											</label>
										</div>
									</li>									
									<li class="list-group-item">
										<div class="checkbox">
											<label>
												<input type="radio" name="filter_priority" value="0" <?php if ($filter_priority=="0") echo "checked=\"checked\""?>>
												<?php echo getPriorityName(0)?>
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input type="radio" name="filter_priority" value="1" <?php if ($filter_priority=="1") echo "checked=\"checked\""?>>
												<?php echo getPriorityName(1)?>
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_priority" value="2" <?php if ($filter_priority=="2") echo "checked=\"checked\""?>>
												<?php echo getPriorityName(2)?>
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_priority" value="3" <?php if ($filter_priority=="3") echo "checked=\"checked\""?>>
												<?php echo getPriorityName(3)?>
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_priority" value="4" <?php if ($filter_priority=="4") echo "checked=\"checked\""?>>
												<?php echo getPriorityName(4)?>
											</label>
										</div>
									</li>
								</ul>
							</div>
							<div class="panel-heading" >
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse3"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> ใกล้ช่วงเวลาเตือน</a>
								</h4>
							</div>
							<div id="collapse3" class="panel-collapse collapse in">
								<ul class="list-group">
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_notification_date" value="all" <?php if ($filter_notification_date=="all") echo "checked=\"checked\""?>>
												ทั้งหมด
											</label>
										</div>
									</li>										
								
									<li class="list-group-item">
										<div class="checkbox">
											<label>
												<input type="radio" name="filter_notification_date" value="1month" <?php if ($filter_notification_date=="1month") echo "checked=\"checked\""?>>
												ภายในหนึ่งเดือน
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input type="radio" name="filter_notification_date" value="2month" <?php if ($filter_notification_date=="2month") echo "checked=\"checked\""?>>
												ภายในสองเดือน
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_notification_date" value="range" <?php if ($filter_notification_date=="range") echo "checked=\"checked\""?>>
												ตามช่วงเวลา
											</label>
										</div>
										<div style="padding-top:10px">
											<input class="datepicker" style="" type="text" name="filter_notification_date_start" placeholder="วันเริ่มต้น" value="<?php echo $filter_notification_date_start?>"/>
											<input class="datepicker" style="" type="text" name="filter_notification_date_end" placeholder="วันสุดท้าย" value="<?php echo $filter_notification_date_end?>"/>
										</div>
									</li>
								</ul>
							</div>

							<div class="panel-heading" >
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse32"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> วันที่สร้าง</a>
								</h4>
							</div>
							<div id="collapse32" class="panel-collapse collapse in">
								<ul class="list-group">
									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_created_date" value="all" <?php if ($filter_created_date=="all") echo "checked=\"checked\""?>>
												ทั้งหมด
											</label>
										</div>
									</li>										

									<li class="list-group-item">
										<div class="checkbox"  >
											<label>
												<input type="radio" name="filter_created_date" value="range" <?php if ($filter_created_date=="range") echo "checked=\"checked\""?>>
												ตามช่วงเวลา
											</label>
										</div>
										<div style="padding-top:10px">
											<input class="datepicker" style="" type="text" name="filter_created_date_start" placeholder="วันเริ่มต้น" value="<?php echo $filter_created_date_start?>"/>
											<input class="datepicker" style="" type="text" name="filter_created_date_end" placeholder="วันสุดท้าย" value="<?php echo $filter_created_date_end?>"/>
										</div>
									</li>
								</ul>
							</div>
							
							
							<div class="panel-heading" >
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse01"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> งานที่ถูกมอบหมายโดย</a>
								</h4>
							</div>							
							
							<div id="collapse01" class="panel-collapse collapse in">
								<ul class="list-group">
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input type="radio" name="filter_assign_by" value="all" <?php if ($filter_assign_by=="all") echo "checked=\"checked\""?>>
												ทั้งหมด
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox">
											<label>
												<input type="radio" name="filter_assign_by" value="me" <?php if ($filter_assign_by=="me") echo "checked=\"checked\""?>>
												ฉัน
											</label>
										</div>
									</li>
									<li class="list-group-item">
										<div class="checkbox" >
											<label>
												<input type="radio" name="filter_assign_by" value="other" <?php if ($filter_assign_by=="other") echo "checked=\"checked\""?>>
												ผู้ใช้ท่านอื่น
											</label>
										</div>
										<div style="padding-top:10px">
											<select id="filter_assign_by_other_users" name="filter_assign_by_user">
											  <option value="<?php echo $filter_assign_by_user?>" selected="selected"><?php echo $filter_assign_by_user?></option>
											</select>										
										</div>
									</li>										
								</ul>
							</div>
							
							
															
						</div>
					</div>
				</div>
			</div>
		</div>	 
	 
	 
	 
		<!-- div class="container col-xs-12 col-sm-9 col-md-9">
		    <div class="row">    
		        <div class="col-xs-12 col-xs-offset-0">
				    <div class="input-group">
		                <div class="input-group-btn search-panel">
		                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		                    	<span id="search_concept">กรองโดย</span> <span class="caret"></span>
		                    </button>
		                    <ul class="dropdown-menu" role="menu">
		                      <li><a href="#contains">มีอยู่ใน</a></li>
		                      <li class="divider"></li>
		                      <li><a href="#all">ทุกอย่าง</a></li>
		                    </ul>
		                </div>
		                <input type="hidden" name="search_param" value="all" id="search_param">         
		                <input style="height:36px!important" type="text" class="form-control" name="keyword" placeholder="คำค้นหา...">
		                <span class="input-group-btn">
		                    <button class="btn btn-default" type="button"><span class="fa fa-search" style="color:#000;"></span></button>
		                </span>
		            </div>
		        </div>
			</div>
		</div-->	 
	 

	 
	 	<?php if (isset($search_result_need_filter) && $search_result_need_filter=='yes'):?>
	 		<div class="container col-xs-12 col-sm-9 col-md-9" style="margin-top:20px">
			    <div class="row">
			    	<div style="margin-left:100px">กรุณาเลือกการกรองข้อมูล<div>
			    </div>
			</div>
	 	
	 	<?php else:?>
	 	
		 	<?php if (empty($search_results)):?>	 
				<div class="container col-xs-12 col-sm-9 col-md-9" style="margin-top:20px">
				    <div class="row">
		 			<div style="margin-left:100px">ไม่พบข้อมูลกรุณาลองใหม่</div>
		 			</div>
		 		</div>
		 	<?php else:?>
		 	

				<?php 
					$query = isset($_SERVER['QUERY_STRING'])? $_SERVER['QUERY_STRING']:'';
					parse_str($query, $get_array);
					unset($get_array['range']);
					unset($get_array['page']);
 					$query = http_build_query($get_array);
 					$url = site_url()."/search/task_index?".$query."&page=";
 					$export_url = site_url()."/search/task_index?".$query."&export=true";
				?>		 	
		 	
		 	
			 	<div class="container col-xs-12 col-sm-9 col-md-9" style="margin-top:20px">
				    <div class="row">
				    	<div>
				    		<div style="float:left;padding-left:20px;font-size:20px">
						    	ผลการค้นหา
						    </div>
					    	<div style="float:right">
					    		<script>
									function downloadExcel()
									{
										window.location = '<?php echo $export_url?>';
									}
					    		</script>
					    		<a onclick="downloadExcel();" class="btn btn-default t5 gc-export" data-url="http://jaymart.ntksoftware.com/index.php/admin/workflow_management/export">
                                        <i class="fa fa-cloud-download floatL t3"></i>
                                        <span class="hidden-xs floatL l5">ส่งออก</span>
                                        <div class="clear"></div>
                                 </a>
					    		
				    		</div>
				    	</div>
				    	
				    </div>
				</div>

				<?php if ($max_number_pages>0):?>
				<div class="container col-xs-12 col-sm-12 col-md-9 offset-md-3 offset-md-3" >
					<div class="row">
					
					<div style="float:left;padding-left:20px">
				    	จำนวนผลลัพธ์ทั้งหมด <?php echo $numer_of_results?>
				    	แสดงผลจาก <?php echo $from?> ถึง <?php echo $to?>
				    </div>
					
					<!-- ul class ="pagination" style="float:right;margin: 5px 0;">
						<?php if ($page>0):?>
					   		<li><a href="<?php echo $url.$page_no_from?>">&laquo;</a></li>
					   <?php endif?>
						<?php for ($i=$page_no_from; $i<$page_no_to;$i++):?>
					   <li class="<?php if ($page==$i) echo "active"?>" ><a href = "<?php echo $url.$i?>"><?php $j=$i+1; echo $j?></a></li>
					   <?php endfor?>
					   <?php if (($max_number_pages-1)>$page):?>
					   		<li><a href="<?php echo $url.$page_no_to?>">&raquo;</a></li>
					   <?php endif?>
					</ul-->
					</div>
				</div>	 	
				<?php endif?> 					
				
				<div class="container col-xs-12 col-sm-9 col-md-9" style="margin-top:20px">
				    <div class="row">
				        <div class="panel panel-primary filterable ">
				            <div class="panel-heading">
				                <h3 class="panel-title">งาน</h3>
				            </div>
				            <table class="table">
				                <thead>
				                    <tr class="filters">
				                        <th><input type="text" class="form-control" placeholder="Case#" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="เวิร์คโฟล์ว" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="สถานะงาน" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="ผู้ได้รับมอบหมาย" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="ความเร่งด่วน" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="วันที่มอบหมาย" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="วันที่สร้าง" disabled></th>
				                        <th><input type="text" class="form-control" placeholder="ดำเนินการ" disabled></th>
				                        
				                   	</tr>
				                </thead>
				                <tbody>
				                	<?php foreach ($search_results as $result):?>
				                    <tr>
				                        <td><a href="<?php echo getTaskUrl($result[TABLE_TASK_COLUMN_CASE_WITHOUT_TAG])?>"><?php echo $result[TABLE_TASK_COLUMN_CASE_WITHOUT_TAG]?></a></td>
				                        <td><?php echo $result[TABLE_TASK_COLUMN_WORKFLOW_NAME]?></td>
				                        <td><?php echo $result[TABLE_TASK_COLUMN_CURRENT_STATUS_NAME]?></td>
				                        <td><?php echo $result[TABLE_TASK_COLUMN_ASSIGNEE_NAME]?></td>
				                        <td><?php echo getPriorityName($result[TABLE_TASK_COLUMN_PRIORITY])?></td>
				                        <td><?php echo $result[TABLE_TASK_COLUMN_ASSIGN_DATE]?></td>
				                        <td><?php echo $result[TABLE_TASK_COLUMN_ASSIGN_DATE]?></td>
				                        <td><a href="<?php echo getTaskUrl($result[TABLE_TASK_COLUMN_CASE_WITHOUT_TAG])?>"><span class="fa fa-search" style="color:#000;"></span></a></td>				                        
				                    </tr>
				                    <?php endforeach;?>
				                </tbody>
				            </table>
				        </div>
				    </div>
				</div>	
				
				<?php if ($max_number_pages>0):?>
				<div class="container col-xs-12 col-sm-12 col-md-9 offset-md-3 offset-md-3" >
					<div class="row">
					<ul class ="pagination" style="float:right">
						<?php if ($page>0):?>
					   		<li><a href="<?php echo $url.$page_no_from?>">&laquo;</a></li>
					   <?php endif?>
						<?php for ($i=$page_no_from; $i<$page_no_to;$i++):?>
					   <li class="<?php if ($page==$i) echo "active"?>"><a href = "<?php echo $url.$i?>"><?php $j=$i+1; echo $j?></a></li>
					   <?php endfor?>
					   <?php if (($max_number_pages-1)>$page):?>
					   		<?php $page_no_to = $max_number_pages-1;?>
					   		<li><a href="<?php echo $url.$page_no_to?>">&raquo;</a></li>
					   <?php endif?>
					</ul>
					</div>
				</div>	 	
				<?php endif?> 	
	 		<?php endif?>	 	
	 	<?php endif?>
	 
	 </div>
	</form>
</div>

<script lang="javascript">
	jQuery('.datepicker').datepicker({ dateFormat: 'yy/mm/dd' });

	jQuery('#filter_assign_to_other_users').select2({

			ajax: {
			    url: "<?php echo site_url()?>/search/ajax_user",
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

			      return {
			        results: data.items,
			        pagination: {
			          more: (params.page * 30) < data.total_count
			        }
			      };
			    },
			    cache: true
			  },
		      width: '100%',
			  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			  minimumInputLength: 1,
			  templateResult: formatRepo, // omitted for brevity, see the source of this page
			  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	});



	jQuery("#select2-filter_assign_to_other_users-container").text("<?php echo $filter_assign_to_user?>");
	jQuery("#select2-filter_assign_to_other_users-container").attr("title","<?php echo $filter_assign_to_user?>");

	jQuery('#filter_assign_by_other_users').select2({

		ajax: {
		    url: "<?php echo site_url()?>/search/ajax_user",
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
		      
		        callback({id:"<?php echo $filter_assign_by_user?>",name:"<?php echo $filter_assign_by_user?>","text":"<?php echo $filter_assign_by_user?>"});
	      },
	      width: '100%',
		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		  minimumInputLength: 1,
		  templateResult: formatRepo, // omitted for brevity, see the source of this page
		  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });

	jQuery("#select2-filter_assign_by_other_users-container").text("<?php echo $filter_assign_by_user?>");
	jQuery("#select2-filter_assign_by_other_users-container").attr("title","<?php echo $filter_assign_by_user?>");


	jQuery('.workflow_status').each(function( index ) {
		jQuery(this).select2({
			  placeholder: "เลือกสถานะ"
			});
	});
	
	function formatRepo (serie) {
		if (serie.loading) return serie.username;
        var markup = '<div class="clearfix">' +
        '<div clas="col-sm-10">' +
        '<div class="clearfix">' +
        '<div class="col-xs-12">' + serie.username + '</div>' +
        '</div>';
        markup += '</div></div>';
        return markup;
  }

  function formatRepoSelection (serie) {
    return serie.username;
  }

  
	
</script>