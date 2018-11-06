<?php $this->load->helper('form');?>

<div id="main-wrapper">
	<div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12">
		
			<form id="searchbox" name="searchbox" method="GET" action='<?php echo site_url("survey/search_survey_by_name")?>'>
			
			<div class="container-fluid col-md-12 col-xs-12" >
				
				<h2><span class="glyphicon glyphicon-search"></span> ค้นหาแบบสำรวจ</h2>
				
			    <div class="row">

					<div class="container-fluid col-md-9 col-xs-12" >
						
						<nav class="navbar navbar-light bg-light">
						<h2>ชื่อหรือนามสกุล</h2>
						<div>
							<input id="coop_membername" name="coop_membername" class="form-control mr-sm-2" type="search" placeholder="ชื่อหรือนามสกุล" aria-label="Search" autocomplete="off" oncopy="return false" oncut="return false" onpaste="return false" value="<?php if (isset($coop_membername)) echo $coop_membername?>">					   
							<button class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" style="margin-top:15px">
	          							<span class="glyphicon glyphicon-search"></span> ค้นหา</button>
	          				<input type="hidden" name="step" value="0"/>						
						</div>	
						</nav>
						
						<div class="container-fluid col-md-12 col-xs-12" style="padding-left:0px;" >
									<?php if (!empty($keyword)):?><strong>คำค้นหา</strong> "<?php echo $keyword?>"<br/>
									<strong>จำนวนผลลัพธิ์ทั้งหมด:</strong> <?php echo $total_number?><br/>									
									<?php	
									$displaying_page = 10;
									
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
											<li class="page-item"><a class="page-link" href="<?php echo site_url('survey/search_survey_by_name')?>?coop_membername=<?php echo $keyword?>&page=<?php echo $i?>&range=<?php echo $range?>"><?php echo $i+1?></a></li>
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
										
										<li style="background-color:#eeffee;padding-top:8px;padding-bottom:8px;padding-left:16px;width:90%;margin-top: 3px;">
										<?php $coop = getCoopByID($v['COOP_ID'])?>
										
										<?php if(!empty($coop)):?>
										
											<?php echo $v['citizen_firstname']?> <?php echo $v['citizen_lastname']?>  
											<br/><br/>
											
											<?php if (canViewSurveyByCoop($coop['REGISTRY_NO_2'])):?>
												
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $v['citizen_id']?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&mode=view&org=<?php echo $coop['ORG_ID']?>&step=1"><?php echo $coop['COOP_NAME_TH']?>, <?php echo $coop['PROVINCE_NAME']?></a>
												<br/>
											
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $v['citizen_id']?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&mode=view&org=<?php echo $coop['ORG_ID']?>&step=1">
													<span class="glyphicon glyphicon-eye-open"></span> ดู
												</a>|
	
												<a href="<?php echo site_url("admin/do_survey_1")?>/<?php echo $v['citizen_id']?>/?coop=<?php echo $coop['REGISTRY_NO_2']?>&org=<?php echo $coop['ORG_ID']?>&step=1">
													<span class="glyphicon glyphicon-edit"></span> แก้ไข
													</a>												

											<?php else:?>
	
												<?php //echo $v['citizen_firstname']?> <?php //echo $v['citizen_lastname']?><?php if (!empty($v['PROVINCE_NAME'])):?> (<?php echo $v['PROVINCE_NAME']?>)<?php endif?>
												<a class="nopermission" href="#"><?php echo $coop['COOP_NAME_TH']?>, <?php echo $coop['PROVINCE_NAME']?></a>
												<br/>
													<a class="nopermission" href="#">
														<span class="glyphicon glyphicon-eye-close"></span> ไม่มีสิทธิเข้าถึงข้อมูลสมาชิก <?php echo $coop['ORG_NAME']?>
													</a>
											
											<?php endif ?>
										
										<?php endif?>
										
										</li>
										
										
									<?php endforeach;?>
									
									</ul>
								</div>
							</div>
						</div>
						
						<?php else:?>
						
						<?php if(isset($_GET['coop_membername'])): ?>
						<div class="" style="font-size:20px;" >
						    <div class="row">
						    	<div class="container-fluid col-md-12 col-xs-12" >
								<lable for id="coop_member_id" style="font-color:red">ไม่พบข้อมูลสหกรณ์ที่เป็นสมาชิก!!</lable>
								</div>
							</div>
						</div>
						<?php endif?>
						
						<?php endif?>
	
					</div>
				</div>
			</div>
			
	
			</form>
		</div>
	</div>
</div>
<script language="javascript">

				$(document).ready(function() {
					
					$("#coop_membername").keydown(function (e) {

						console.log(e.key);
						var reg = /^[a-zA-Zก-๗]+$/i;
						var reg_num_thai = /^[๑-๗]+$/i;
						console.log(reg.test(e.key));
						console.log(reg_num_thai.test(e.key));

						if (e.key==" " || e.key=="Enter")
							return true;
						
						if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
						{
							return;
						}else{
							e.preventDefault();
						}

						
					});
				});

				$('#searchbox').submit(function(e){
					var c;
					var test = $('#coop_membername').val();	
					if (test=='')
					{
					 	$('.modal-dialog').css('width','350px');
						var html = '<div class="" style="font-size:20px;"  >';
						html += '<div class="row">';
						html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:center;">';
						html += '<lable for id="coop_member_id" style="font-color:red;">กรุณากรอกชื่อหรือนามสกุล</lable>';
						html += '</div>	';			
						html += '</div>';
						html += '</div>';
						$('.modal-body').html(html);
						$('#myModal').modal({
							  keyboard: true
						});
						return false;	
					}
				});
				
</script>


  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 500px">
    
      <!-- Modal content-->
      <div class="modal-content">
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

