
<style>

		.select2 {
    		max-width: 250px;
		}
		
		.filter_creator .select2 {
    		min-width: 200px;
		}

		
</style>

<?php 
$this->load->helper('form');
$this->load->helper('survey');
$this->load->helper('user');


					
?>

<div id="main-wrapper">
	<p>Page Code : RE300</p>
	<div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12">
		
			
			<div class="container-fluid col-md-12 col-xs-12" >
				
				<div class="row" style="text-align:right">
				
					<h2><span class="glyphicon glyphicon-th-list"></span> รายงานข้อมูลแบบสอบถามตามผู้บันทึก</h2>
				
				</div>

				
				<div class="row" id="action-bar">
					<div class="report-action-bar">

						<form action="" method="GET">
						
						<input type="hidden" value="yes" name="frompost" />
						
						<div class="container-fluid col-md-3 col-xs-12" style="margin-top: 13px;">
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
					
						<div class="filter_creator container-fluid col-md-4 col-xs-12"  style="margin-top: 13px;">				
							<label for="filter_creator">ผู้บันทึก: </label>	
							<?php $all_users = getCacheUsers();?>
							<select id="filter_creator" name="filter_creator">
								<option value=""></option>
								<?php foreach ($all_users as $user):?>
									<?php $selected = $user->user_id==$filter_creator ? " selected=\"selected\" " : "";?>
									<option value="<?php echo $user->user_id?>" <?php echo $selected?> ><?php echo $user->name?></option>
								<?php endforeach?>
							</select>

						</div>
				
						<div class="container-fluid col-md-1 col-xs-12" style="margin-top: 13px;">
							<button class="btn btn-outline-purple" ><span class="glyphicon glyphicon-search"></span> ค้นหา</button>		
						</div>
						
					</form>

					
					</div>
				</div>

				<?php if ($total_number>0):?>
			    <div class="row">
					<div class="actions" style="float:right">
			    		<script>
							function downloadExcel()
							{

								var filter_year = $('#filter_year option:selected').val();
								var filter_creator = $('#filter_creator option:selected').val();
							
								window.location.href = '/index.php/report2/index3?exportdata=true&filter_creator='+filter_creator+'&filter_year='+filter_year;

							
// 								 $.ajax({
// 									url:"/index.php/report2/index3",
// 									type:"GET",
// 									data: {filter_year: filter_year, filter_creator: filter_creator,exportdata:"true",frompost:"yes"},
// 									success: function (result) {
// 								         console.log(result);
// 								      }
// 								});
							}
			    		</script>
			    		<a onclick="downloadExcel();" class="btn btn-default t5 gc-export" data-url="">
                                        <i class="fa fa-cloud-download floatL t3"></i>
                                        <span class="hidden-xs floatL l5">ส่งออก</span>
                                        <div class="clear"></div>
                                 </a>
				    </div>		
			    
			    </div>	
			    <?php endif?>			
				
			    <div class="row">


					<div class="container-fluid col-md-12 col-xs-12" >
					
						<div class="container-fluid col-md-12 col-xs-12" style="padding-left:0px;" >
									<strong>จำนวนผลลัพธ์ทั้งหมด:</strong> <?php echo $total_number?><br/>	
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
												<li class="page-item"><a class="page-link" href="<?php echo site_url('report2/index3')?>?frompost=yes&filter_year=<?php echo $filter_year?>&filter_creator=<?php echo $filter_creator?>&page=<?php echo $i?>&range=<?php echo $range?>"><?php echo $i+1?></a></li>
											<?php endif?>
											<?php endfor;?>
										</ul>
										<?php endif?>
									
									<?php endif?>
									
								</div>						
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
										
										<?php echo $v['citizen_firstname']?> <?php echo $v['citizen_lastname']?> ( หมายเลขบัตรประชาชน <a href="<?php echo site_url('report2/index1')?>?citizen_id=<?php echo $v['citizen_id']?>"><?php echo $v['citizen_id']?></a>  - <?php if (!empty($v['COOP_ID'])):?>หมายเลขสหกรณ์ <?php echo $v['COOP_ID']?>)<?php endif?>
										
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
								<lable for id="coop_member_id" style="font-color:red">ไม่พบข้อมูล!!</lable>
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


<script>
$('#filter_creator').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกผู้บันทึก"
		});
});
$('#filter_year').each(function( index ) {
	$(this).select2({
		  placeholder: "เลือกปี"
		});
});

</script>

