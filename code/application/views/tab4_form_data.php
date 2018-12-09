<?php $intab_id =4; ?>
<!-- <h4 class="h_sub_title">ปัญหาที่พบ</h4> -->

<!-- <label>ส่วนที่ 4 ปัญหาที่พบในการประกอบอาชีพ</label> -->




<div class="form-result-header">ส่วนปัญหาที่พบ</div>
<section class="form-inline">
<div class="h_sub_title">1  ปัญหาด้านการผลิต</div>

<div class="row mar_ned" style="padding: 0 15px;">

    <div class="col-md-12 col-xs-9">

        <?php
        $tab5_a1 = '';
        if(isset($user_survey_data[strtoupper('tab5_a1')])){
            $tab5_a1 = unserialize($user_survey_data[strtoupper('tab5_a1')]);
        }

        ?>

		<?php 
        $tab5_a1[0] = empty($tab5_a1[0]) ? 0 : intval($tab5_a1[0]);
		?>  
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ที่ดินเพื่อการเกษตร</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a1[]" id="tab5_a1[]" checked="checked" onclick="tab5_a1(false)" <?php if(isset($tab5_a1[0])){ if(intval($tab5_a1[0])==1 || intval($tab5_a1[0])==0){ echo ' checked ';   }  } ?> value="0" > <span><span>ไม่<span>มีปัญหา</span></span></span>
                </label>
            </div>
            <div class="form-group col-md-10 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a1[]" id="tab5_a1[]" onclick="tab5_a1(true)" <?php if(isset($tab5_a1[0])){ if(intval($tab5_a1[0])==2){ echo ' checked ';   }  } ?>  value="2"> <span>ปัญหาคือ</span>
                </label>
                <input type="text" class="form-control" id="tab5_a1_problem"  name="tab5_a1_problem"  <?php if(isset($tab5_a1[0])){ if(intval($tab5_a1[0])==1  || intval($tab5_a1[0])==0){ echo ' disabled ';     } }?>   value="<?php if(isset($user_survey_data[strtoupper('tab5_a1_problem')])){ echo $user_survey_data[strtoupper('tab5_a1_problem')]; } ?>"    placeholder="" onkeypress="return isAlphaNumeric(event);">
            </div>
            <script type="text/javascript">
				function tab5_a1(value){
					if(value)
					{
// 						$('#tab5_a1_problem').prop('checked', false); 
						$("#tab5_a1_problem").prop('disabled', false);
					}else{
						$("#tab5_a1_problem[type=text]").val('');
						$("#tab5_a1_problem").prop('disabled', true);
						}
				}
            </script>
        </div>
        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>

        <?php
        $tab5_a2 = '';
        if(isset($user_survey_data[strtoupper('tab5_a2')])){
            $tab5_a2 = unserialize($user_survey_data[strtoupper('tab5_a2')]);
        }

        ?>
        
        
		<?php 
		$tab5_a2[0] = !isset($tab5_a2[0]) ? 0 : $tab5_a2[0];
		?>         
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> แหล่งน้ำ</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a2[]" id="tab5_a2[]"  checked="checked" onclick="tab5_a2(false)" <?php if(isset($tab5_a2[0])){ if($tab5_a2[0]==1 || $tab5_a2[0]==0){ echo ' checked ';   }  } ?> value="0" > <span><span>ไม่<span>มีปัญหา</span></span></span>
                </label>
            </div>
            <div class="col-md-10 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a2[]" id="tab5_a2[]"  onclick="tab5_a2(true)"  <?php if(isset($tab5_a2[0])){ if($tab5_a2[0]==2){ echo ' checked ';   }  } ?>   value="2"> <span>ปัญหาคือ</span>
                </label>
                <input type="text" class="form-control" id="tab5_a2_problem"  name="tab5_a2_problem"  <?php if(isset($tab5_a2[0])){ if($tab5_a2[0]==1  || $tab5_a2[0]==0){ echo ' disabled ';   }  } ?>  value="<?php if(isset($user_survey_data[strtoupper('tab5_a2_problem')])){ echo $user_survey_data[strtoupper('tab5_a2_problem')]; } ?>"   placeholder="" onkeypress="return isAlphaNumeric(event);">
            </div>
            
            <script type="text/javascript">
				function tab5_a2(value){
					if(value)
					{
						$("#tab5_a2_problem").prop('disabled', false);
						
					}else{
						$('#tab5_a2_problem').val('');
						$("#tab5_a2_problem").prop('disabled', true);
						}
				}
            </script>
        </div>

        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> เมล็ดพันธุ์,ต้นพันธุ์</stong>
                </label>
            </div>
            <?php
            $tab5_a3 = '';
            if(isset($user_survey_data[strtoupper('tab5_a3')])){
                $tab5_a3 = unserialize($user_survey_data[strtoupper('tab5_a3')]);
            } //echo "<pre>"; print_r($tab5_a3);

            ?>

			<?php 
			$tab5_a3[0] = !isset($tab5_a3[0]) ? 0 : $tab5_a3[0];
			?> 

            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a3[0]" id="tab5_a3[0]" checked="checked"  onclick="tab5_a3(false)"<?php if(isset($tab5_a3[0])){ if($tab5_a3[0]==0){  echo ' checked  ';   } } ?> value="0" > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a3[0]" id="tab5_a3[0]"  onclick="tab5_a3(true)" <?php if(isset($tab5_a3[0])){ if($tab5_a3[0]==1){  echo ' checked  ';   } } ?> value="1"> <span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a3">
                    <input type="checkbox" name="tab5_a3[1]" id="tab5_a3[1]" class="tab5_a3"  <?php if(isset($tab5_a3[0])){ if($tab5_a3[0]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a3[1])){ if($tab5_a3[1]==0){  echo ' checked  ';   } } ?>  value="2"> <span>ไม่มีเมล็ดพันธุ์  </span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a3">
                    <input type="checkbox" name="tab5_a3[2]" id="tab5_a3[2]" class="tab5_a3"  <?php if(isset($tab5_a3[0])){ if($tab5_a3[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a3[2])){ if($tab5_a3[2]==3){  echo ' checked  ';   } } ?>  value="3"> <span>ไม่เพียงพอ</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a3">
                    <input type="checkbox" name="tab5_a3[3]" id="tab5_a3[3]" class="tab5_a3" <?php if(isset($tab5_a3[0])){ if($tab5_a3[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a3[3])){ if($tab5_a3[3]==4){  echo ' checked  ';   } } ?>   value="4"> <span>มีราคาแพง</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a3">
                    <input type="checkbox" name="tab5_a3[4]" id="tab5_a3[4]" class="tab5_a3" <?php if(isset($tab5_a3[0])){ if($tab5_a3[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a3[4])){ if($tab5_a3[4]==5){  echo ' checked  ';   } } ?>   value="5"> <span>คุณภาพไม่ได้มาตรฐาน</span>
                </label>
            </div>
            <script type="text/javascript">
                 <?php if($mode!="view"){ ?>$(".tab5_a3").css('display','none'); <?php } ?>
				function tab5_a3(value){
					if(value)
					{
						$(".tab5_a3").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a3").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a3').prop('checked', false); 
						$(".tab5_a3").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a3").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>


        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>


        <?php
        $tab5_a4 = '';
        if(isset($user_survey_data[strtoupper('tab5_a4')])){
            $tab5_a4 = unserialize($user_survey_data[strtoupper('tab5_a4')]);
        } //echo "<pre>"; print_r($tab5_a4); echo "</pre>";

        ?>


		<?php 
		$tab5_a4[0] = !isset($tab5_a4[0]) ? 0 : $tab5_a4[0];
		?>    
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ปุ๋ย,ยา,สารเคมี</stong>
                </label>
            </div>
            <ul class="list-unstyled">
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[0]" id="tab5_a4[0]" checked="checked" onclick="tab5_a4(false)" <?php if(isset($tab5_a4[0])){ if($tab5_a4[0]==0){  echo ' checked  ';   } } ?> value="0"  > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[0]" id="tab5_a4[0]"  onclick="tab5_a4(true)" <?php if(isset($tab5_a4[0])){ if($tab5_a4[0]==1){  echo ' checked  ';   } } ?>  value="1" > <span>มีปัญหา</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label class="tab5_a4" >
                    <input type="checkbox" name="tab5_a4[1]" id="tab5_a4[1]" class="tab5_a4" <?php if(isset($tab5_a4[0])){ if($tab5_a4[0]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[1])){ if($tab5_a4[1]==1){  echo ' checked  ';   } } ?> value="1"> <span>ราคาแพง</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label class="tab5_a4" >
                    <input type="checkbox" name="tab5_a4[2]" id="tab5_a4[2]" class="tab5_a4" <?php if(isset($tab5_a4[0])){ if($tab5_a4[0]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[2])){ if($tab5_a4[2]==1){  echo ' checked  ';   } } ?>  value="1"> <span>ปลอมปน</span>
                </label>
            </li>
            <li class="col-md-4 col-xs-12">
                <label class="pull-left tab5_a4">
                    <input onClick="checkOtherDobuz541()" type="checkbox" name="tab5_a4[3]" id="tab5_a43" class="tab5_a4" <?php if(isset($tab5_a4[0])){ if($tab5_a4[0]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[3])){ if($tab5_a4[3]==1){  echo ' checked  ';   } } ?>   value="1"> <span>อื่นๆ&nbsp;&nbsp;</span>
                </label>
                <input    id="tab5_a4_other"   onclick="$('#tab5_a43').prop('checked', true);" onkeyup="$('#tab5_a43').prop('checked', true);"   onkeypress="$('#tab5_a43').prop('checked', true);return isAlphaNumeric(event);"  type="text" class="form-control tab5_a4 pull-left"  name="tab5_a4[23]"  class="tab5_a4" <?php if(isset($tab5_a4[0])){ if($tab5_a4[0]==0){  echo ' disabled  ';   } } ?> value="<?php if(isset($tab5_a4[23]) && isset($tab5_a4[3])){ if($tab5_a4[3]==1){ echo $tab5_a4[23]; }  }  ?>">
            </li>
            </ul>
            <script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a4").css('display','none'); <?php } ?>
	            function checkOtherDobuz541(){
		            console.log($(this));
					$('#tab5_a4_other').focus();
					$('#tab5_a4_other').val('');
				}
				function tab5_a4(value){
					if(value)
					{
						$(".tab5_a4").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a4").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a4[type=text]').val('');
						$('.tab5_a4').prop('checked', false); 
						$(".tab5_a4").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a4").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>

        <?php
        $tab5_a5 = '';
        if(isset($user_survey_data[strtoupper('tab5_a5')])){
                $tab5_a5 = unserialize($user_survey_data[strtoupper('tab5_a5')]);
        } // echo "<pre>"; print_r($tab5_a4);

        ?>
        
        

		<?php 
		$tab5_a5[0] = !isset($tab5_a5[0]) ? 0 : $tab5_a5[0];
		?>        

        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ความรู้เทคโนโลยี</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a5[0]" id="tab5_a5[]" checked="checked" onclick="tab5_a5(false)" <?php if(isset($tab5_a5[0])){ if($tab5_a5[0]==0){  echo ' checked  ';   } } ?>   value="0"  > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a5[0]" id="tab5_a5[]" onclick="tab5_a5(true)" <?php if(isset($tab5_a5[0])){ if($tab5_a5[0]==1){  echo ' checked  ';   } } ?>   value="1" > <span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a5" >
                    <input type="checkbox" name="tab5_a5[1]" id="tab5_a5[]" class="tab5_a5" <?php if(isset($tab5_a5[0])){ if($tab5_a5[0]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a5[1])){ if($tab5_a5[1]==1){  echo ' checked  ';   } } ?> value="1"> <span>มีน้อย</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label class="tab5_a5" >
                    <input type="checkbox" name="tab5_a5[2]" id="tab5_a5[]" class="tab5_a5" <?php if(isset($tab5_a5[0])){ if($tab5_a5[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a5[2])){ if($tab5_a5[2]==1){  echo ' checked  ';   } } ?> value="1"> <span>ขาดแหล่งความรู้</span>
                </label>
            </div>
			<script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a5").css('display','none'); <?php } ?>
				function tab5_a5(value){
					if(value)
					{
						$(".tab5_a5").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a5").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a5').prop('checked', false); 
						$(".tab5_a5").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a5").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>


        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ความรู้ แนวโน้มความต้องการของตลาด นโยบายการส่งเสริมของภาครัฐ</stong>
                </label>
            </div>

            <?php
            $tab5_a6 = '';
            if(isset($user_survey_data[strtoupper('tab5_a6')])){
                $tab5_a6 = unserialize($user_survey_data[strtoupper('tab5_a6')]);
            } // echo "<pre>"; print_r($tab5_a4);

            ?>
        </div>

        <div class="row">
        

			<?php 
			$tab5_a6[0] = !isset($tab5_a6[0]) ? 0 : $tab5_a6[0];
			?>
			<ul class="list-unstyled">
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a6[0]" id="tab5_a6[]"  checked="checked" onclick="tab5_a6(false)" <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==0){  echo ' checked  ';   } } ?>  value="0"  > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a6[0]" id="tab5_a6[]"  onclick="tab5_a6(true)" <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==1){  echo ' checked  ';   } } ?>   value="1" > <span>มีปัญหา</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label class="tab5_a6" >
                    <input type="checkbox" name="tab5_a6[1]" id="tab5_a6[]" class="tab5_a6" <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a6[1])){ if($tab5_a6[1]==1){  echo ' checked  ';   } } ?>  value="1"> <span>ทราบเล็กน้อย-ไม่เข้าใจ</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label class="tab5_a6">
                    <input type="checkbox" name="tab5_a6[2]" id="tab5_a6[]" class="tab5_a6"  <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a6[2])){ if($tab5_a6[2]==1){  echo ' checked  ';   } } ?>    value="1"> <span>เข้าใจปานกลาง</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label class="tab5_a6">
                    <input type="checkbox" name="tab5_a6[3]" id="tab5_a6[]" class="tab5_a6"    <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a6[3])){ if($tab5_a6[3]==1){  echo ' checked  ';   } } ?>   value="1"> <span>ไม่สนใจติดตาม</span>
                </label>
            </li>
            <li class="col-md-6 col-xs-12">
                <label class="pull-left tab5_a6">
                    <input type="checkbox" name="tab5_a6[4]" id="tab5_a46" class="tab5_a6" onclick="checkOtherDobuz46();"  class="tab5_a46"   <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a6[4])){ if($tab5_a6[4]==1){  echo ' checked  ';   } } ?>  value="1"> <span>อื่นๆ</span>
                </label>
                <input onclick="$('#tab5_a46').prop('checked', true);" onkeyup="$('#tab5_a46').prop('checked', true);"  <?php if(isset($tab5_a6[0])){ if($tab5_a6[0]==0){  echo ' disabled  ';   } } ?>  onkeypress="$('#tab5_a46').prop('checked', true);return isAlphaNumeric(event);"  style="margin-left: 6px;" type="text" class="form-control tab5_a6 pull-left" id="tab5_a6_other"    name="tab5_a6_other"     value="<?php if(isset($user_survey_data[strtoupper('tab5_a6_other')])){ echo $user_survey_data[strtoupper('tab5_a6_other')]; } ?>"     placeholder="">
            </li>
            </ul>
            <script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a6").css('display','none'); <?php } ?>
                function checkOtherDobuz46(){
    				$('#tab5_a6_other').focus();
    				$('#tab5_a6_other').val('');
    			}
				function tab5_a6(value){
					if(value)
					{
						$(".tab5_a6").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a6").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a6[type=text]').val('');
						$('.tab5_a6').prop('checked', false); 
						$(".tab5_a6").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a6").css('display','none'); <?php } ?>
					}
				}
            </script>
<!--             <div class="col-md-3 col-xs-12">
                <input type="text" class="form-control" id="tab5_a6_other"        name="tab5_a6_other"     value="<?php //if(isset($user_survey_data[strtoupper('tab5_a6_other')])){ echo $user_survey_data[strtoupper('tab5_a6_other')]; } ?>"     placeholder="">
<!--             </div> -->
        </div>

    </div>
</div>


</section>
<section  class="form-inline">
<div class="h_sub_title">2  ข้อมูลด้านการตลาดอื่นๆ</div>


<div class="row mar_ned" style="padding: 0 15px;">

 <div class="col-md-12 col-xs-9">

		<?php 
		$tab5_a4[4] = !isset($tab5_a4[4]) ? 0 : $tab5_a4[4];
		?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ตลาดรับซื้อ</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[4]" id="tab5_a4[4]"  checked="checked" onclick="tab5_a7(false)"  <?php if(isset($tab5_a4[4])){ if($tab5_a4[4]==0){  echo ' checked  ';   } } ?>  value="0"  > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[4]" id="tab5_a4[4]"  onclick="tab5_a7(true)"   <?php if(isset($tab5_a4[4])){ if($tab5_a4[4]==1){  echo ' checked  ';   } } ?>  value="1"  > <span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label  class="tab5_a7">
                    <input type="checkbox" name="tab5_a4[5]" id="tab5_a4[5]" class="tab5_a7"  <?php if(isset($tab5_a4[4])){ if($tab5_a4[4]!=1){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[5])){ if($tab5_a4[5]==1){  echo ' checked  ';   } } ?>   value="1"> <span>ไม่มีตลาดแน่นอน</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label  class="tab5_a7">
                    <input type="checkbox" name="tab5_a4[6]" id="tab5_a4[6]" class="tab5_a7" <?php if(isset($tab5_a4[4])){ if($tab5_a4[4]!=1){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[6])){ if($tab5_a4[6]==1){  echo ' checked  ';   } } ?>    value="1"> <span>มีตลาดไม่พอใจราคาขาย</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label class="pull-left tab5_a7">
                    <input type="checkbox" onclick="checkOtherDobuz42()" name="tab5_a4[7]" id="tab5_a47" class="tab5_a7"  <?php if(isset($tab5_a4[4])){ if($tab5_a4[4]!=1){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[7])){ if($tab5_a4[7]==1){  echo ' checked  ';   } } ?>    value="1"> <span>อื่นๆ</span>
                </label>
                <input style="width: 135px;margin-left: 6px;" type="text" class="form-control tab5_a7 pull-left"  name="tab5_a4[24]"  id="tab5_a47_other" onclick="$('#tab5_a47').prop('checked', true);" onkeyup="$('#tab5_a47').prop('checked', true);"   onkeypress="$('#tab5_a47').prop('checked', true);return isAlphaNumeric(event);"     <?php if(isset($tab5_a4[4])){ if($tab5_a4[4]!=1){  echo ' disabled  ';   } } ?> value="<?php if(isset($tab5_a4[24])){ echo $tab5_a4[24];  } ?> "            placeholder="">
            </div>
        </div>
        <br>
		<script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a7").css('display','none'); <?php } ?>
        		function checkOtherDobuz42(){
        			$('#tab5_a47_other').focus();
        			$('#tab5_a47_other').val('');
        		}
				function tab5_a7(value){
					if(value)
					{
						$(".tab5_a7").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a7").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a7[type=text]').val('');
						$('.tab5_a7').prop('checked', false); 
						$(".tab5_a7").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a7").css('display','none'); <?php } ?>
					}
				}
            </script>


		<?php 
		$tab5_a4[8] = !isset($tab5_a4[8]) ? 0 : $tab5_a4[8];
		?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> สถานที่เก็บผลผลิต</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[8]" id="tab5_a4[8]" checked="checked" onclick="tab5_a8(false)" <?php if(isset($tab5_a4[8])){ if($tab5_a4[8]==0){  echo ' checked  ';   } } ?>  value="0" > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[8]" id="tab5_a4[8]" onclick="tab5_a8(true)" <?php if(isset($tab5_a4[8])){ if($tab5_a4[8]==1){  echo ' checked  ';   } } ?>  value="1" > <span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a8">
                    <input type="checkbox" name="tab5_a4[9]" id="tab5_a4[9]" class="tab5_a8" <?php if(isset($tab5_a4[8])){ if($tab5_a4[8]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[9])){ if($tab5_a4[9]==1 && $tab5_a4[8]==1){  echo ' checked  ';   } } ?>   value="1"> <span>มี</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a8">
                    <input type="checkbox" name="tab5_a4[10]" id="tab5_a4[10]" class="tab5_a8" <?php if(isset($tab5_a4[8])){ if($tab5_a4[8]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a4[10])){ if($tab5_a4[10]==1 && $tab5_a4[8]==1){  echo ' checked  ';   } } ?>  value="1"> <span>มีไม่พอ</span>
                </label>
            </div>
            <div class="col-md-1 col-xs-12">
                <label class="tab5_a8">
                    <input type="checkbox" name="tab5_a4[11]" id="tab5_a4[11]" class="tab5_a8" <?php if(isset($tab5_a4[8])){ if($tab5_a4[8]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a4[11])){ if($tab5_a4[11]==1 && $tab5_a4[8]==1){  echo ' checked  ';   } } ?>    value="1"> <span>ไม่มี</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label class="tab5_a8">
                    <input type="checkbox" name="tab5_a4[12]" id="tab5_a4[12]" class="tab5_a8" <?php if(isset($tab5_a4[8])){ if($tab5_a4[8]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a4[12])){ if($tab5_a4[12]==1 && $tab5_a4[8]==1){  echo ' checked  ';   } } ?>  value="1"> <span>ไม่จำเป็นต้องมีที่เก็บ</span>
                </label>
            </div>
            <script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a8").css('display','none'); <?php } ?>
				function tab5_a8(value){
					if(value)
					{
						$(".tab5_a8").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a8").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a8').prop('checked', false); 
						$(".tab5_a8").prop('disabled', true);
                       <?php if($mode!="view"){ ?>$(".tab5_a8").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>

        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>


		<?php 
		$tab5_a4[13] = !isset($tab5_a4[13]) ? 0 : $tab5_a4[13];
		?>

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ข้อมูลด้านการตลาด</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[13]" id="tab5_a4[0]"  checked="checked" onclick="tab5_a9(false)" <?php if(isset($tab5_a4[13])){ if($tab5_a4[13]==1){  echo ' checked  ';   } } ?>     value="0"  > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[13]" id="tab5_a4[13]"   onclick="tab5_a9(true)"<?php if(isset($tab5_a4[13])){ if($tab5_a4[13]==1){  echo ' checked  ';   } } ?>     value="1" ><span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a9">
                    <input type="checkbox" name="tab5_a4[14]" id="tab5_a4[14]" class="tab5_a9" <?php if(isset($tab5_a4[13])){ if($tab5_a4[13]==0){  echo ' disabled  ';   } } ?>  <?php if(isset($tab5_a4[13])){ if($tab5_a4[13]==1){  echo ' checked  ';   } } ?>     value="1" > <span>ไม่ทราบ</span>
                </label>
            </div>
            <div class="col-md-6 col-xs-12">
                <label class="pull-left tab5_a9">
                    <input type="checkbox" onclick="checkOtherDobuz422()" name="tab5_a4[15]" id="tab5_a415" class="tab5_a9" <?php if(isset($tab5_a4[13])){ if($tab5_a4[13]==0){  echo ' disabled  ';   } } ?> <?php if(isset($tab5_a4[14])){ if($tab5_a4[14]==1){  echo ' checked  ';   } } ?>  value="1"> <span>ทราบจากแหล่งใด ระบุ</span>
                </label>
                <input id="tab5_a4_other3" type="text" class="form-control tab5_a4_other3 tab5_a9 pull-left"  name="tab5_a4[22]" onclick="$('#tab5_a415').prop('checked', true);" onkeyup="$('#tab5_a415').prop('checked', true);"   onkeypress="$('#tab5_a415').prop('checked', true);return isAlphaNumeric(event);"  <?php if(isset($tab5_a4[13])){ if($tab5_a4[13]==0){  echo ' disabled  ';   } } ?> value="<?php if(isset($tab5_a4[22])){  echo $tab5_a4[22]; } ?> "   placeholder="" style="width: 200px;margin-left: 6px;">
            </div>
            
            <script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a9").css('display','none'); <?php } ?>
	            function checkOtherDobuz422(){
					$('#tab5_a4_other3').focus();
					$('#tab5_a4_other3').val('');
				}
				function tab5_a9(value){
					if(value)
					{
						$(".tab5_a9").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a9").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a9[type=text]').val('');
						$('.tab5_a9').prop('checked', false); 
						$(".tab5_a9").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a9").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>



        <div class="row">
            <div class="col-md-12 col-xs-12">
                <br/>
            </div>
        </div>


        <div class="row">
		<?php 
		$tab5_a4[16] = !isset($tab5_a4[16]) ? 0 : $tab5_a4[16];
		?>
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ความต้องการข้อมูลทางด้านการตลาด</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[16]" id="tab5_a4[16]" checked="checked" onclick="tab5_a10(false)"  <?php if(isset($tab5_a4[16])){ if($tab5_a4[16]==1){  echo ' checked  ';   } } ?>    value="0"  > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[16]" id="tab5_a4[16]"  onclick="tab5_a10(true)"  <?php if(isset($tab5_a4[16])){ if($tab5_a4[16]==1){  echo ' checked  ';   } } ?>    value="1" > <span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a10">
                    <input type="checkbox" name="tab5_a4[17]" id="tab5_a4[17]" class="tab5_a10"  <?php if(isset($tab5_a4[16])){ if($tab5_a4[16]==0){  echo ' disabled  ';   } } ?>   <?php if(isset($tab5_a4[17])){ if($tab5_a4[17]==1){  echo ' checked  ';   } } ?>   value="1"> <span>ต้องการมี</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a10">
                    <input type="checkbox" name="tab5_a4[18]" id="tab5_a4[18]" class="tab5_a10" <?php if(isset($tab5_a4[16])){ if($tab5_a4[16]==0){  echo ' disabled  ';   } } ?>   <?php if(isset($tab5_a4[18])){ if($tab5_a4[18]==1){  echo ' checked  ';   } } ?>  value="1"> <span>ไม่ต้องการมี</span>
                </label>
            </div>
            <script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a10").css('display','none'); <?php } ?>
				function tab5_a10(value){
					if(value)
					{
						$(".tab5_a10").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a10").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a10').prop('checked', false); 
						$(".tab5_a10").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a10").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>

        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>

		<?php 
		$tab5_a4[19] = !isset($tab5_a4[19]) ? 0 : $tab5_a4[19];
		?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ราคาที่ได้</stong>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[19]" id="tab5_a4[19]"  checked="checked" onclick="tab5_a11(false)" <?php if(isset($tab5_a4[19])){ if($tab5_a4[19]==1){  echo ' checked  ';   } } ?>     value="0" > <span>ไม่<span>มีปัญหา</span></span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="tab5_a4[19]" id="tab5_a4[19]"  onclick="tab5_a11(true)" <?php if(isset($tab5_a4[19])){ if($tab5_a4[19]==1){  echo ' checked  ';   } } ?>     value="1" > <span>มีปัญหา</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a11">
                    <input type="checkbox" name="tab5_a4[20]" id="tab5_a4[20]" class="tab5_a11" <?php if(isset($tab5_a4[19])){ if($tab5_a4[19]==0){  echo ' disabled  ';   } } ?>    <?php if(isset($tab5_a4[20])){ if($tab5_a4[20]==1){  echo ' checked  ';   } } ?>    value="1"> <span>ราคาต่ำ</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label class="tab5_a11">
                    <input type="checkbox" name="tab5_a4[21]" id="tab5_a4[21]" class="tab5_a11" <?php if(isset($tab5_a4[19])){ if($tab5_a4[19]==0){  echo ' disabled  ';   } } ?>   <?php if(isset($tab5_a4[21])){ if($tab5_a4[21]==1){  echo ' checked  ';   } } ?>  value="1"> <span>เหมาะสม</span>
                </label>
            </div>
 		<script type="text/javascript">
                <?php if($mode!="view"){ ?>$(".tab5_a11").css('display','none'); <?php } ?>
				function tab5_a11(value){
					if(value)
					{
						$(".tab5_a11").prop('disabled', false);
                        <?php if($mode!="view"){ ?>$(".tab5_a11").css('display','block'); <?php } ?>
					}else{
						$('.tab5_a11').prop('checked', false); 
						$(".tab5_a11").prop('disabled', true);
                        <?php if($mode!="view"){ ?>$(".tab5_a11").css('display','none'); <?php } ?>
					}
				}
            </script>
        </div>



        <div class="row">
            <div class="col-md-2 col-xs-12">
                <br/>
            </div>
        </div>


        <?php
        $tab4_b6 = '';
        if(isset($user_survey_data[strtoupper('tab4_b6')])){
            $tab4_b6 = unserialize($user_survey_data[strtoupper('tab4_b6')]);
        } // echo "<pre>"; print_r($tab5_a4);

        ?>
		<?php 
		$tab4_b6[0] = !isset($tab4_b6[0]) ? 0 : $tab4_b6[0];
		?>        
        
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <stong> ช่องทางข้อมูลด้านการตลาดพืชผลเกษตรได้รับจากแหล่งใดสะดวกที่สุด</stong>
                </label>
            </div>
			<ul class="list-unstyled">
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[0]" id="tab4_b6[]"   <?php if(isset($tab4_b6[0])){ if($tab4_b6[0]==1){  echo ' checked  ';   } } ?> value="1"> <span>เกษตรตำบล</span>
                </label>
            </li>

            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[1]" id="tab4_b6[]"   <?php if(isset($tab4_b6[1])){ if($tab4_b6[1]==1){  echo ' checked  ';   } } ?> value="1"> <span>กำนันผู้ใหญ่บ้าน</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[2]" id="tab4_b6[]"  <?php if(isset($tab4_b6[2])){ if($tab4_b6[2]==1){  echo ' checked  ';   } } ?> value="1"> <span>วิทยุชุมชน</span>
                </label>
            </li>

            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[3]" id="tab4_b6[]"   <?php if(isset($tab4_b6[3])){ if($tab4_b6[3]==1){  echo ' checked  ';   } } ?>  value="1"> <span>องค์กรบริหารส่วนตำบล</span>
                </label>
            </li>


            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[4]" id="tab4_b6[]"   <?php if(isset($tab4_b6[4])){ if($tab4_b6[4]==1){  echo ' checked  ';   } } ?>  value="1"> <span>สถานีวิทยุ</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[5]" id="tab4_b6[]"  <?php if(isset($tab4_b6[5])){ if($tab4_b6[5]==1){  echo ' checked  ';   } } ?>  value="1"> <span>โทรทัศน์</span>
                </label>
            </li>
            <li class="col-md-2 col-xs-12">
                <label>
                    <input type="checkbox" name="tab4_b6[6]" id="tab4_b6[]"  <?php if(isset($tab4_b6[6])){ if($tab4_b6[6]==1){  echo ' checked  ';   } } ?> value="1"> <span>สหกรณ์</span>
                </label>
            </li>
            <li class="col-md-4">
                <label class="pull-left">
                    <input type="checkbox" onclick="checkOtherDobuz43()" name="tab4_b6[7]" id="tab4_b67"  <?php if(isset($tab4_b6[7])){ if($tab4_b6[7]==1){  echo ' checked  ';   } } ?> value="1"> <span>อื่นๆ&nbsp;&nbsp;</span>
                </label>
                <input type="text" class="form-control pull-left" id="tab4_b6_other" name="tab4_b6_other"  onclick="$('#tab4_b67').prop('checked', true);" onkeyup="$('#tab4_b67').prop('checked', true);"   onkeypress="$('#tab4_b67').prop('checked', true);return isAlphaNumeric(event);" value="<?php if(isset($user_survey_data[strtoupper('tab4_b6_other')])){ echo $user_survey_data[strtoupper('tab4_b6_other')]; } ?>" placeholder="">
            </li>
          </ul>

        </div>
        <script type="text/javascript">
	        function checkOtherDobuz43(){
				$('#tab4_b6_other').focus();
				$('#tab4_b6_other').val('');
			}
        </script>
    </div>
</div>


</section>


<?php include("_btn_next_step.php"); ?>

