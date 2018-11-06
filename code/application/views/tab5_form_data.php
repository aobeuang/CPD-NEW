<?php $intab_id =5; ?>

<style>
	.input-no-spinner {
    -moz-appearance: textfield;
    }
    .input-no-spinner::-webkit-outer-spin-button,
    .input-no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>


<h4 class="h_sub_title">ข้อมูลด้านหนี้สิน</h4>




<div class="row mar_ned">

    <div class="row fixed-row">

        <div class="col-md-12 col-xs-12 wdth">


            <table class="table table-striped table-condensed fixed-table fixed-input-center"  >
                <?php /*    <table id="tblAddRow" border="1"> */ ?>
                <thead>
                <tr>
                    <th rowspan="2" >ที่</th>
                    <th style="text-align: center;" rowspan="2">เจ้าหนี้</th>
                    <!-- > th style="text-align: center;" rowspan="2">จำนวนเงินเป็นหนี้ (บาท)</th>  -->
                    <th style="text-align: center;" colspan="2" class="text-center">สถานะหนี้ (ทำเครื่องหมาย)</th>

                </tr>

                <tr style="text-align: center;">
                    <th style="text-align: center;">หนี้ปกติ</th>
                    <th style="text-align: center;">หนี้ค้าง/<br>ฟ้องดำเนินคดี</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $list_label = array(); $list_arr_name = array();
                $j = 0;
                $list_label[$j] = 'สหกรณ์/กลุ่มเกษตรกร'; $list_arr_name[$j] = 'coop'; $j++;
                $list_label[$j] = 'ธกส.'; $list_arr_name[$j] = 'baac'; $j++;
                $list_label[$j] = 'ธนาคารอื่น'; $list_arr_name[$j] = 'b_others'; $j++;
                $list_label[$j] = 'กองทุนหมู่บ้าน'; $list_arr_name[$j] = 'housing'; $j++;
                $list_label[$j] = 'พ่อค้าคนกลาง/นายทุน'; $list_arr_name[$j] = 'middle_man'; $j++;
                $list_label[$j] = 'ญาติ/เพื่อนบ้าน'; $list_arr_name[$j] = 'the_neig'; $j++;
                $list_label[$j] = 'อื่นๆ(ระบุ)'; $list_arr_name[$j] = 'others'; $j++;
                ?>


                <?php  $tab5_debt_num = '';
                if(isset($user_survey_data[strtoupper('tab5_debt_num')])) {
                    $tab5_debt_num = unserialize($user_survey_data[strtoupper('tab5_debt_num')]); // print_r($product_sale_comment);
                }  //echo "<pre>"; print_r($tab5_debt_num);
                $tab5_debt_normal = '';

                ?>

                <?php


                for($j=0;$j<count($list_label);$j++){ //echo "<pre>"; print_r($user_survey_data[strtoupper('tab5_debt_normal_'.$list_arr_name[$j])]);echo "</pre>";
                    $no = $j;?>
                    <tr> <td><?php  $no++;echo $no; ?></td><td>

                            <table style="width:100%;"><tr> <td style="border-top:0px;vertical-align:baseline;">  <?php echo $list_label[$j]; ?>

                                        <?php if($list_arr_name[$j]=="the_others"){       ?>
                                    </td><td style="border-top:0px;vertical-align:baseline;">  <input type="number" onkeypress="return isDecimal(event)" class="form-control allownumericwithdecimal"     value="<?php if(isset($user_survey_data[strtoupper('tab5_debt_the_others')])){ echo $user_survey_data[strtoupper('tab5_debt_the_others')]; } ?>" id="tab5_debt_<?php echo $list_arr_name[$j]; ?>" name="tab5_debt_<?php echo $list_arr_name[$j]; ?>" placeholder="">
                                        <?php        }?></td></tr></table>

                        </td>
                        <!-- 
                        <td>     <input type="number" class="form-control input-no-spinner" id="tab5_debt_num[<?php //echo $list_arr_name[$j]; ?>]" name="tab5_debt_num[<?php //echo $list_arr_name[$j]; ?>]"  value="<?php
                            //if(isset($tab5_debt_num[$list_arr_name[$j]])){ echo $tab5_debt_num[$list_arr_name[$j]]; } ?>"  placeholder=""></td>
                             -->
                        <td style="text-align: center;">
                        
                             <input type="text" class="form-control allownumericwithdecimal" onkeypress="return isDecimal(event)" <?php
                        	$val1 = ""; 
                            if(isset($user_survey_data[strtoupper('tab5_debt_normal_'.$list_arr_name[$j])])) {
                            	$val1 = trimleft($user_survey_data[strtoupper('tab5_debt_normal_'.$list_arr_name[$j])],"0");
                            }
                            if ($val1=='N')
                            	$val1 = "";
                            	
                         ?>  name="tab5_debt_normal[<?php echo $list_arr_name[$j]; ?>]" id="tab5_debt_normal[<?php echo $list_arr_name[$j]; ?>]" value="<?php echo $val1?>"></td>
                        <td style="text-align: center;">
                         
                             <input type="text" onkeypress="return isDecimal(event)" class="form-control allownumericwithdecimal"
                                       <?php
                                       $val2 = "";
                                       if(isset($user_survey_data[strtoupper('tab5_debt_abnormal_'.$list_arr_name[$j])])) {
                                       	$val2 = trimleft($user_survey_data[strtoupper('tab5_debt_abnormal_'.$list_arr_name[$j])],'0'); 
                                       }
                                       if ($val2=='N')
	                                      $val2 = "";
                                       ?>

                                       name="tab5_debt_abnormal[<?php echo $list_arr_name[$j]; ?>]" id="tab5_debt_normal[<?php echo $list_arr_name[$j]; ?>]" value="<?php echo $val2?>"></td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>
</div>






<?php include("_btn_next_step.php"); ?>
