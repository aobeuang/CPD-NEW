<?php $intab_id =3; ?>

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
<div class="form-result-header">การปลูกพืชและเลี้ยงสัตว์</div>
<section>
	<div class="h_sub_title">1.  พืช</div>



<div class="row mar_ned">

    <div class="col-md-12">
        <div class="col-md-12" id="box31">

<!--             <thead> -->
            <?php $table_id = 31; include("inc_js_table_active_row.php"); ?>
<!--             <table> -->
<!--  			<tr> -->
<!--                  <th rowspan="5"></th> -->
<!--                  <th colspan="3" class="text-center">ซื้อจากสหกรณ์</th> -->
<!--                  <th colspan="2"> ซื้อจากพ่อค้า </th> -->
<!--             </tr> -->

			<tr>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">ชนิด</th>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">พันธุ์ที่ปลูก</th>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">จำนวนครั้งที่ปลูกต่อปี</th>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">พื้นที่ปลูก (ไร่)</th>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">พื้นที่จะปลูก (ไร่)</th>
	            <th style="text-align: center;vertical-align: middle;" rowspan="2">ผลผลิตที่คาดว่าได้ต่อปี (ตัน)</th>
	            <th style="text-align: center;vertical-align: middle;"  colspan="3" style="text-align:  center;">ขายผลผลิต</th>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">ประมาณรายได้ ขาย ผลิตต่อปี(บาท)</th>
	            <th style="text-align: center;vertical-align: middle;"  rowspan="2">ประมาณรายได้ค่าใช้จ่ายการเกษตร(บาท)</th>
            </tr>
            
            <tr>
                <th style="text-align: center;" >พ่อค้า</th> 
                <th style="text-align: center;" >สหกรณ์</th> 
                <th style="text-align: center;" >อื่นๆ</th>
            </tr>

<!-- Read more: https://html.com/tables/rowspan-colspan/#ixzz5JvI82H48 -->
            </thead>
            <tbody>



            <?php
           // echo "<pre>"; print_r($user_survey_data);
            $plant_type = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('plant_type')])) {
                $plant_type = unserialize($user_survey_data[strtoupper('plant_type')]); // print_r($plant_type);
                $all_row = count($plant_type);
            }
            //echo "<pre>"; print_r($plant_type);
            $plant_specie = '';
            if(isset($user_survey_data[strtoupper('plant_specie')])) {
                $plant_specie = unserialize($user_survey_data[strtoupper('plant_specie')]);   //print_r($plant_specie);
            }
            $planting_num_per_year = '';
            if(isset($user_survey_data[strtoupper('planting_num_per_year')])) {
                $planting_num_per_year = unserialize($user_survey_data[strtoupper('planting_num_per_year')]);   //print_r($plant_specie);
            }
            $growing_area = '';
            if(isset($user_survey_data[strtoupper('growing_area')])) {
                $growing_area = unserialize($user_survey_data[strtoupper('growing_area')]);   //print_r($plant_specie);
            }
            $growing_area_will = '';
            if(isset($user_survey_data[strtoupper('growing_area_will')])) {
            	$growing_area_will = unserialize($user_survey_data[strtoupper('growing_area_will')]);   //print_r($plant_specie);
            }
            $product_num_per_year = '';
            if(isset($user_survey_data[strtoupper('product_num_per_year')])) {
                $product_num_per_year = unserialize($user_survey_data[strtoupper('product_num_per_year')]);   //print_r($plant_specie);
            }

            $area_rai = '';
            if(isset($user_survey_data[strtoupper('area_rai')])) {
                $area_rai = unserialize($user_survey_data[strtoupper('area_rai')]);   //print_r($plant_specie);
            }

            $area_ngan = '';
            if(isset($user_survey_data[strtoupper('area_ngan')])) {
                $area_ngan = unserialize($user_survey_data[strtoupper('area_ngan')]);   //print_r($plant_specie);
            }
            $area_squarewa = '';
            if(isset($user_survey_data[strtoupper('area_squarewa')])) {
                $area_squarewa = unserialize($user_survey_data[strtoupper('area_squarewa')]);   //print_r($plant_specie);
            }

            $estimated_sales_revenue_per_year = '';
            if(isset($user_survey_data[strtoupper('estsales_revenueyear')])) {
                $estimated_sales_revenue_per_year = unserialize($user_survey_data[strtoupper('estsales_revenueyear')]);   //print_r($plant_specie);
            }
            $estimate_agri_income_per_year = '';
            if(isset($user_survey_data[strtoupper('estagri_incomeyear')])) {
                $estimate_agri_income_per_year = unserialize($user_survey_data[strtoupper('estagri_incomeyear')]);   //print_r($plant_specie);
            }

            $plant_sell_merchant = '';
            if(isset($user_survey_data[strtoupper('PLANT_SELL_MECHANT')])) {
            	$plant_sell_merchant = unserialize($user_survey_data[strtoupper('PLANT_SELL_MECHANT')]);   //print_r($plant_specie);
            }
            
            $plant_sell_coop = '';
            if(isset($user_survey_data[strtoupper('plant_sell_coop')])) {
            	$plant_sell_coop = unserialize($user_survey_data[strtoupper('plant_sell_coop')]);   //print_r($plant_specie);
            }
            
            $plant_sell_other = '';
            if(isset($user_survey_data[strtoupper('plant_sell_other')])) {
            	$plant_sell_other = unserialize($user_survey_data[strtoupper('plant_sell_other')]);   //print_r($plant_specie);
            }

            for($ir=0;$ir<$all_row;$ir++){
            ?>
            <tr>
                <td class="checkboxcol"> <span></span>
                    <input name="ckcDel[]" type="checkbox"  /><span></span>
                </td>
                <td>
                    <select  name="plant_type[]"  class="plant_type1 form-control" >
                        <option value="">==กรุณาเลือกชนิด==</option>
                        <?php for($i=0;$i<=count($plan_name);$i++){
                            if(isset($plan_name[$i])){ if(trim($plan_name[$i])!=""){?>
                                <option <?php
                                if(isset($plant_type[$ir])){  if($plant_type[$ir]==$plan_code[$i]){ echo ' selected ';  }    }
                                ?>    value="<?php if(isset($plan_code[$i])){  echo $plan_code[$i]; } ?>"><?php echo trim($plan_name[$i]); ?></option>
                            <?php } } } ?>
                    </select>
                    <?php /* <input type="hidden" name="plant_type[]" value="" /> */ ?>
                </td>
                <td>
                    <input type="text" class="form-control input-no-spinner" name="plant_specie[]" value="<?php if(isset($plant_specie[$ir])){ echo $plant_specie[$ir]; } ?>" autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false" onkeypress="return isAlphaNumeric(event);"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="plant_planting_num_per_year[]" value="<?php if(isset($planting_num_per_year[$ir])){ echo trimleft($planting_num_per_year[$ir],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="growing_area[]" value="<?php if(isset($growing_area[$ir])){ echo trimleft($growing_area[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="growing_area_will[]" value="<?php if(isset($growing_area_will[$ir])){ echo trimleft($growing_area_will[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="plant_product_num_per_year[]" value="<?php if(isset($product_num_per_year[$ir])){ echo trimleft($product_num_per_year[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
					<?php $plant_sell_merchant[$ir] = isset( $plant_sell_merchant[$ir]) ?  $plant_sell_merchant[$ir]: 0;
					/*if (empty($plant_sell_merchant[$ir]))
						$plant_sell_merchant[$ir] = "";*/
					?>
					<input onclick="" type="checkbox" class="" name="plant_sell_merchantxxx[]" value="" <?php if(isset($plant_sell_merchant[$ir]) && $plant_sell_merchant[$ir]==1){ echo "checked"; } ?> /><span></span>
                    <input type="hidden" class="runningnumber" id="plant_sell_merchant<?php echo $ir?>" name="plant_sell_merchant[]" value="<?php if(isset($plant_sell_merchant[$ir])){ echo $plant_sell_merchant[$ir]; } ?>" />
                </td>
                <td>                
                	<?php $plant_sell_coop[$ir] = isset( $plant_sell_coop[$ir]) ?  $plant_sell_coop[$ir]: 0;
	                	/*if (empty($plant_sell_coop[$ir]))
	                		$plant_sell_coop[$ir] = "";*/
	                	
                	?>
                	<input onclick="" type="checkbox" class="" name="plant_sell_merchantxxx[]" value="" <?php if(isset($plant_sell_coop[$ir]) && $plant_sell_coop[$ir]==1){ echo "checked"; } ?> /><span></span>
                    <input type="hidden" class="" name="plant_sell_coop[]" value="<?php if(isset($plant_sell_coop[$ir])){ echo $plant_sell_coop[$ir]; } ?>" />
                </td>
                <td>
                	<?php $plant_sell_other[$ir] = isset( $plant_sell_other[$ir]) ?  $plant_sell_other[$ir]: 0;
		                	/*if (empty($plant_sell_other[$ir]))
		                		$plant_sell_other[$ir] = ""*/;
                	?>
                	
                	<input onclick="" type="checkbox" class="" name="plant_sell_merchantxxx[]" value="" <?php if(isset($plant_sell_other[$ir]) && $plant_sell_other[$ir]==1){ echo "checked"; } ?> /><span></span>
                    <input type="hidden" class="" name="plant_sell_other[]" value="<?php if(isset($plant_sell_other[$ir])){ echo $plant_sell_other[$ir]; } ?>" />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="estimate_agri_income_per_year[]" value="<?php if(isset($estimate_agri_income_per_year[$ir])){ echo trimleft($estimate_agri_income_per_year[$ir],'0'); } ?>" placeholder="บาท"  onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="estimated_sales_revenue_per_year[]" value="<?php if(isset($estimated_sales_revenue_per_year[$ir])){ echo trimleft($estimated_sales_revenue_per_year[$ir],'0');; } ?>" placeholder="บาท" onkeypress="return isDecimal(event)" />
                </td>
            </tr>

            <?php } ?>

            </tbody>
            </table>
            
            
            <script>

            $('#box31').on('change','input[type="checkbox"]',function(){
            	if($(this).prop('checked'))
                {
                    $(this).next().val(1);
                } else {
                    $(this).next().val('');
                }
            });

            
            </script>
        </div>

    </div>
</div>
</div>
</section>

<section class="form-inline">
	<div class="h_sub_title">2.  วิธีการขาย</div>


<div class="row mar_ned" style="padding: 0 15px;">



    <?php  $how2sell = ''; //print_r($user_survey_data[strtoupper('how2sell')]);
    if(isset($user_survey_data[strtoupper('how2sell')])) {
        $how2sell = unserialize($user_survey_data[strtoupper('how2sell')]); //  echo "xx"; print_r($w2sell);
    }
    ?>

    <div class="col-md-12 col-xs-9">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="how2sell[0]" id="how2sell1" onclick=""  <?php if(isset($how2sell[0])){ if($how2sell[0]==1){  echo ' checked ';     }   } ?> value="1">  <span>นำไปขายที่ตลาดกลาง</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="how2sell[1]" id="how2sell2" onclick="" <?php if(isset($how2sell[1])){ if($how2sell[1]==1){  echo ' checked ';     }   } ?>    value="1">  <span>พ่อค้ามาซื้อที่ผลิต</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="how2sell[2]" id="how2sell3" onclick=""  <?php if(isset($how2sell[2])){ if($how2sell[2]==1){  echo ' checked ';     }   } ?>   value="1">  <span>ขายผลผลิตล่วงหน้า</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
            		<script>
						function checkOtherow2sell(){
							$('#how2sell3_others_reason').focus();
							$('#how2sell3_others_reason').val('');
						}					
					</script>
                <label class="nowrap">
                    <input type="checkbox"   onclick="checkOtherow2sell();" name="how2sell[3]" id="is_how2sell_others"   <?php if(isset($how2sell[3])){ if($how2sell[3]==1){  echo ' checked ';     }   } ?> value="1"  >   <span>อื่นๆ</span>
                </label>
                <input style="max-width: 195px;" type="text" onclick="$('#is_how2sell_others').prop('checked', true);" onkeyup="$('#is_how2sell_others').prop('checked', true);"   onkeypress="$('#is_how2sell_others').prop('checked', true);return isAlphaNumeric(event);"     value="<?php if(isset($user_survey_data[strtoupper('how2sell_others_reason')])){ echo $user_survey_data[strtoupper('how2sell_others_reason')]; } ?>"  class="form-control" id="how2sell3_others_reason" name="how2sell3_others_reason" placeholder="" >
            </div>
        </div>
    </div>


</div>
</section>
<section class="form-inline">
	<div class="h_sub_title">ปัญหาที่พบในการขาย</div>
	



<div class="row mar_ned" style="padding: 0 15px;">

    <div class="row">

        <div class="col-md-12">
            <p align="left"><stong> ความคิดเห็นในการขายผลผลิตให้กับสหกรณ์</stong></p>

        </div>
    </div>


<?php  $product_sale_comment = array();
if(isset($user_survey_data[strtoupper('product_sale_comment')]) && !empty($user_survey_data[strtoupper('product_sale_comment')])) {
    $product_sale_comment = unserialize($user_survey_data[strtoupper('product_sale_comment')]); // print_r($product_sale_comment);
}
$product_sale_comment = $product_sale_comment==null ? array():$product_sale_comment;
?>
    <div class="col-md-12 col-xs-9">


        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment[]" id="product_sale_comment[]" <?php if(in_array(4,$product_sale_comment)){  echo ' checked ';     }   ?> value="4">   <span>เป็นทางเลือกที่เหมาะสม</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment[]" id="product_sale_comment[]" <?php if(in_array(5,$product_sale_comment)){  echo ' checked ';     }   ?>  value="5">  <span>การชั่วตวง เชื่อถือได้</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment[]" id="product_sale_comment[]" <?php if(in_array(6,$product_sale_comment)){  echo ' checked ';     }   ?> value="6">  <span>รับเงินค่าผลผลิตตามข้อตกลง</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment[]" id="product_sale_comment[]" <?php if(in_array(7,$product_sale_comment)){  echo ' checked ';     }   ?> value="7">   <span>ราคาซื้อ ขาย เป็นธรรม</span>
                </label>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment[]" id="product_sale_comment[]" <?php if(in_array(8,$product_sale_comment)){  echo ' checked ';     }   ?> value="8"> <span>ความสะดวก</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment[]" id="product_sale_comment[]" <?php if(in_array(9,$product_sale_comment)){  echo ' checked ';     }   ?> value="9">  <span>พอใจในการบริการ</span>
                </label>
            </div>
            <div class="col-md-4 col-xs-12">
                <label class="pull-left">
                    <script>
                        function checkSaleComment(){
                            $('#product_sale_comment_other').focus();
                            $('#product_sale_comment_other').val('');
                        }                   
                    </script>
                    <input type="checkbox" onclick="checkSaleComment();" name="product_sale_comment[]" id="product_sale_comment" class="orther" data-target="product_sale_comment_other" <?php if(in_array(10,$product_sale_comment)){  echo ' checked ';     }   ?> value="10">  <span>อื่นๆ</span>
                </label>
                <input onclick="$('#product_sale_comment').prop('checked', true);" onkeyup="$('#product_sale_comment').prop('checked', true);"   onkeypress="$('#product_sale_comment').prop('checked', true);return isAlphaNumeric(event);"    type="text" class="form-control" id="product_sale_comment_other" name="product_sale_comment_other" placeholder="เหตุผลอื่นๆ" style="margin-left: 7px;" <?php //if(!in_array(10,$product_sale_comment)){  echo ' disabled ';     }   ?>  value="<?php if(isset($user_survey_data[strtoupper('product_sale_other')])){ echo $user_survey_data[strtoupper('product_sale_other')]; } ?>"  >
            </div>
        </div>
    </div>
</div>

<div class="row mar_ned" style="padding: 0 15px;">

    <div class="row">
        <div class="col-md-4 col-xs-4 wdth">
            <p align="left"><stong> ความคิดเห็นในการขายผลผลิตให้กับพ่อค้า</stong></p>
        </div>
        <div class="col-md-3 col-xs-4 wdth">
            <p align="left"><stong> </stong></p>
        </div>
    </div>



    <div class="col-md-12 col-xs-9">

        <?php  $product_sale_comment2 = array();
        if(isset($user_survey_data[strtoupper('product_sale_comment2')]) && !empty($user_survey_data[strtoupper('product_sale_comment2')])) {
            $product_sale_comment2 = unserialize($user_survey_data[strtoupper('product_sale_comment2')]); // print_r($product_sale_comment);
        } //echo "<pre>"; print_r($product_sale_comment2);
        $product_sale_comment2 = $product_sale_comment2==null ? array():$product_sale_comment2;
        ?>

        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2[]" <?php if(in_array(4,$product_sale_comment2)){  echo ' checked ';     }   ?>  value="4">   <span>เป็นทางเลือกที่เหมาะสม</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2[]"  <?php if(in_array(5,$product_sale_comment2)){  echo ' checked ';     }   ?>   value="5">  <span>การชั่วตวง เชื่อถือได้</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2[]"  <?php if(in_array(6,$product_sale_comment2)){  echo ' checked ';     }   ?>  value="6">  <span>รับเงินค่าผลผลิตตามข้อตกลง</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2[]"  <?php if(in_array(7,$product_sale_comment2)){  echo ' checked ';     }   ?>     value="7">   <span>ราคาซื้อ ขาย เป็นธรรม</span>
                </label>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2[]"  <?php if(in_array(8,$product_sale_comment2)){  echo ' checked ';     }   ?>   value="8">  <span>ความสะดวก</span>
                </label>
            </div>
            <div class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2[]"  <?php if(in_array(9,$product_sale_comment2)){  echo ' checked ';     }   ?>   value="9">  <span>พอใจในการบริการ</span>
                </label>
            </div> 
            <div class="col-md-4 col-xs-12">
                <label>
                
                    <script>
                        function checkOtherSaleComment2(){
                            $('#product_sale_comment_other2').focus();
                            $('#product_sale_comment_other2').val('');
                        }                   
                    </script>                
                    <input onclick="checkOtherSaleComment2();" type="checkbox" name="product_sale_comment2[]" id="product_sale_comment2"  class="orther" data-target="product_sale_comment_other2" <?php if(in_array(10,$product_sale_comment2)){  echo ' checked ';     }   ?>  value="10">  <span>อื่นๆ</span>
                </label>
                <input onclick="$('#product_sale_comment2').prop('checked', true);" onkeyup="$('#product_sale_comment2').prop('checked', true);"   onkeypress="$('#product_sale_comment2').prop('checked', true);return isAlphaNumeric(event);"   type="text" class="form-control" id="product_sale_comment_other2" name="product_sale_comment_other2" placeholder="เหตุผลอื่นๆ" <?php //if(!in_array(10,$product_sale_comment2)){  echo ' disabled ';     }   ?>  style="margin-left: 7px;"   value="<?php if(isset($user_survey_data[strtoupper('product_sale_other2')])){ echo $user_survey_data[strtoupper('product_sale_other2')]; } ?>"   >
            </div>
        </div>
    </div>
</div>
	
</section>




<section>
	<div class="h_sub_title">3.  สัตว์บก</div>





<div class="row mar_ned"  style="padding: 0 15px;">
    <div class="col-md-12 col-xs-9">
        <div class="row">
            <?php $table_id = 321; include("inc_js_table_active_row.php"); ?>

            <th style="text-align: center;vertical-align: middle;" >ชนิดสัตว์</th>
            <th style="text-align: center;vertical-align: middle;" >จำนวนสัตว์ที่เลี้ยง(ตัว)</th>
            <th style="text-align: center;vertical-align: middle;" >จำนวนสัตว์ที่คาดว่าจะเลี้ยง(ตัว)</th>
            <th style="text-align: center;vertical-align: middle;" >จำนวนสัตว์ที่เลี้ยงไว้ขาย(ตัว)</th>
            <th style="text-align: center;vertical-align: middle;" >รายได้ต่อปี<br/>ก่อนหักค่าใช้จ่าย<br/>(บาท)</th>
            <th style="text-align: center;vertical-align: middle;" >ประมาณ<br/>ค่าใช้จ่ายการเกษตร<br/>(บาท)</th>
            <th style="text-align: center;vertical-align: middle;" >อาหารสัตว์ (กก.)</th>
            <th style="text-align: center;vertical-align: middle;" >เวชภัณท์(กก.)</th>
            <th style="text-align: center;vertical-align: middle;" >อาหารเสริม<br/>(ลิตร/กก.)</th>
            </tr>
            </thead>
            <tbody>


            <?php
            // echo "<pre>"; print_r($user_survey_data);
            $ani_type = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('ani_type')])) {
                $ani_type = unserialize($user_survey_data[strtoupper('ani_type')]); // print_r($plant_type);
                $all_row = count($ani_type);
                $all_row = $all_row==0 ? 1 : $all_row;
            }
            //echo "<pre>"; print_r($plant_type);
            $ani_specie = '';
            if(isset($user_survey_data[strtoupper('ani_specie')])) {
                $ani_specie = unserialize($user_survey_data[strtoupper('ani_specie')]);   //print_r($plant_specie);
            }

            $ani_num_per_year = '';
            if(isset($user_survey_data[strtoupper('ani_num_per_year')])) {
                $ani_num_per_year = unserialize($user_survey_data[strtoupper('ani_num_per_year')]);   //print_r($plant_specie);
            }
            
            $ani_num_will = '';
            if(isset($user_survey_data[strtoupper('ani_num_will')])) {
            	$ani_num_will = unserialize($user_survey_data[strtoupper('ani_num_will')]);   //print_r($plant_specie);
            }
            
            $ani_num_sale = '';
            if(isset($user_survey_data[strtoupper('ani_num_sale')])) {
            	$ani_num_sale = unserialize($user_survey_data[strtoupper('ani_num_sale')]);   //print_r($plant_specie);
            }

            $ani_income = '';
            if(isset($user_survey_data[strtoupper('ani_income')])) {
                $ani_income = unserialize($user_survey_data[strtoupper('ani_income')]);   //print_r($plant_specie);
            }


            $ani_expense_per_year = '';
            if(isset($user_survey_data[strtoupper('ani_expense_per_year')])) {
                $ani_expense_per_year = unserialize($user_survey_data[strtoupper('ani_expense_per_year')]);   //print_r($plant_specie);
            }

            $ani_food = '';
            if(isset($user_survey_data[strtoupper('ani_food')])) {
                $ani_food = unserialize($user_survey_data[strtoupper('ani_food')]);   //print_r($plant_specie);
            }

            $ani_wetchapan = '';
            if(isset($user_survey_data[strtoupper('ani_wetchapan')])) {
                $ani_wetchapan = unserialize($user_survey_data[strtoupper('ani_wetchapan')]);   //print_r($plant_specie);
            }

            for($ir=0;$ir<$all_row;$ir++){ //echo $ani_specie[$ir]."<br/>";
            ?>


            <tr>
                <td class="checkboxcol"> <span></span>
                    <input name="ckcDel[]" type="checkbox" /> <span></span>
                </td>
                <td>
                     <select  name="ani_type[]"  class="form-control animal_type1"  >
                        <option value="">==กรุณาเลือกชนิด==</option>
                        <?php for($i=0;$i<=count($ani_name);$i++){
                            if(isset($ani_name[$i])){ if(trim($ani_name[$i])!=""){?>
                                <option    <?php
                                if(isset($ani_type[$ir])){  if($ani_type[$ir]==$ani_code[$i]){ echo ' selected ';  }    }
                                ?>     value="<?php if(isset($ani_code[$i])){  echo $ani_code[$i]; } ?>"><?php echo trim($ani_name[$i]); ?></option>
                            <?php } } } ?>
                    </select>
                    <?php /*
                    <input name="plant_type[]" value="" />*/ ?>
                </td>
                <?php /*<td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani_specie[]" value="<?php if(isset($ani_specie[$ir])){ echo $ani_specie[$ir]; } ?>" />
                </td> */?>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani_num_per_year[]" value="<?php if(isset($ani_num_per_year[$ir])){ echo trimleft($ani_num_per_year[$ir],'0'); } ?>" onkeypress="return isNumber(event)" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani_num_will[]" value="<?php if(isset($ani_num_per_year[$ir])){ echo trimleft($ani_num_per_year[$ir],'0'); } ?>" onkeypress="return isNumber(event)" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani_num_sale[]" value="<?php if(isset($ani_num_sale[$ir])){ echo trimleft($ani_num_sale[$ir],'0'); } ?>" onkeypress="return isNumber(event)" />
                </td>
                <td>
                    <input  type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani_income[]" value="<?php if(isset($ani_income[$ir])){ echo trimleft($ani_income[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input  type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani_expense_per_year[]" value="<?php if(isset($ani_expense_per_year[$ir])){ echo trimleft($ani_expense_per_year[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input  type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani_food[]" value="<?php if(isset($ani_food[$ir])){ echo trimleft($ani_food[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani_wetchapan[]" value="<?php if(isset($ani_wetchapan[$ir])){ echo trimleft($ani_wetchapan[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani_specie[]" value="<?php if(isset($ani_specie[$ir])){ echo $ani_specie[$ir]; } ?>" />
                </td>
            </tr>

            <?php } ?>
            <?php /*
                <tr>
                    <td>
                        <input name="ckcDel[]" type="checkbox" />
                    </td>
                    <td>
                        <input name="txtName[]" value="" />
                    </td>
                    <td>
                        <input name="txtCity[]" value="" />
                    </td>
                </tr>
 */ ?>
            </tbody>
            </table>
        </div>

    </div>
</div>




</section>
<section>
	<div class="h_sub_title">4.  สัตว์น้ำ</div>

    <div class="row mar_ned"  style="padding: 0 15px;">

        <div class="col-md-12 col-xs-9">
            <div class="row">

            <?php $table_id = 322; include("inc_js_table_active_row.php"); ?>

            <th  style="text-align: center;vertical-align: middle;" >ชนิดสัตว์น้ำ</th>
            <th style="text-align: center;vertical-align: middle;" >จำนวนสัตว์ที่เลี้ยง(ตัว)</th>
            <th style="text-align: center;vertical-align: middle;" >จำนวนสัตว์ที่คาดว่าจะเลี้ยง(ตัว)</th>
            <th style="text-align: center;vertical-align: middle;" >จำนวนสัตว์ที่เลี้ยงไว้ขาย(ตัว)</th>
            <th  style="text-align: center;vertical-align: middle;" >รายได้ต่อปี<br/>ก่อนหักค่าใช้จ่าย<br/>(บาท)</th>
            <th  style="text-align: center;vertical-align: middle;" >ประมาณ<br/>ค่าใช้จ่ายการเกษตร<br/>(บาท)</th>
            <th  style="text-align: center;vertical-align: middle;" >อาหารสัตว์ (กก.)</th>
            <th  style="text-align: center;vertical-align: middle;" >เวชภัณท์(กก.)</th>
            <th   style="text-align: center;vertical-align: middle;" >อาหารเสริม  (ลิตร/กก.)</th>
            </tr>
            </thead>
            <tbody>

            <?php
            // echo "<pre>"; print_r($user_survey_data);
            $ani2_type = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('ani2_type')])) {
                $ani2_type = unserialize($user_survey_data[strtoupper('ani2_type')]); //  print_r($ani2_type);
                $all_row = count($ani2_type);
            }
            //echo "<pre>"; print_r($plant_type);
            $ani2_specie = '';
            if(isset($user_survey_data[strtoupper('ani2_specie')])) {
                $ani2_specie = unserialize($user_survey_data[strtoupper('ani2_specie')]);   //print_r($plant_specie);
            }

            $ani2_numyear = '';
            if(isset($user_survey_data[strtoupper('ani2_numyear')])) {
                $ani2_numyear = unserialize($user_survey_data[strtoupper('ani2_numyear')]);   //print_r($plant_specie);
            }
            $ani2_will = '';
            if(isset($user_survey_data[strtoupper('ani_num_will')])) {
            	$ani2_will = unserialize($user_survey_data[strtoupper('ani2_will')]);   //print_r($plant_specie);
            }
            
            $ani2_sale = '';
            if(isset($user_survey_data[strtoupper('ani_num_sale')])) {
            	$ani2_sale = unserialize($user_survey_data[strtoupper('ani2_sale')]);   //print_r($plant_specie);
            }

            $ani2_incomr= '';
            if(isset($user_survey_data[strtoupper('ani2_income')])) {
                $ani2_income = unserialize($user_survey_data[strtoupper('ani2_income')]);   //print_r($plant_specie);
            }


            $ani2_expense_per_year = '';
            if(isset($user_survey_data[strtoupper('ani2_expense_per_year')])) {
                $ani2_expense_per_year = unserialize($user_survey_data[strtoupper('ani2_expense_per_year')]);   //print_r($plant_specie);
            }

            $ani2_food = '';
            if(isset($user_survey_data[strtoupper('ani2_food')])) {
                $ani2_food = unserialize($user_survey_data[strtoupper('ani2_food')]);   //print_r($plant_specie);
            }

            $ani2_wetchapan = '';
            if(isset($user_survey_data[strtoupper('ani2_wetchapan')])) {
                $ani2_wetchapan = unserialize($user_survey_data[strtoupper('ani2_wetchapan')]);   //print_r($plant_specie);
            }

            for($ir=0;$ir<$all_row;$ir++){
            ?>



            <tr>
                <td class="checkboxcol"> <span></span>
                    <input name="ckcDel[]" type="checkbox" /> <span></span>
                </td>
                <td>
                    <select  name="ani2_type[]"    class="form-control animal_type2"  >
                        <option value="">==กรุณาเลือกชนิด==</option>
                        <?php for($i=0;$i<=count($ani_name2);$i++){
                            if(isset($ani_name2[$i])){ if(trim($ani_name2[$i])!=""){?>
                                <option  <?php
                                if(isset($ani2_type[$ir])){  if($ani2_type[$ir]==$ani_code2[$i]){ echo ' selected ';  }    }
                                ?>   value="<?php if(isset($ani_code2)){ echo $ani_code2[$i];  } ?>"><?php echo trim($ani_name2[$i]); ?></option>
                            <?php } } } ?>
                    </select>
                    <?php /*

                    <input name="plant_type[]" value="" />*/ ?>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani2_numyear[]" value="<?php if(isset($ani2_numyear[$ir])){ echo trimleft($ani2_numyear[$ir],'0'); } ?>" onkeypress="return isNumber(event)" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani2_will[]" value="<?php if(isset($ani2_will[$ir])){ echo trimleft($ani2_will[$ir],'0'); } ?>" onkeypress="return isNumber(event)" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani2_sale[]" value="<?php if(isset($ani2_sale[$ir])){ echo trimleft($ani2_sale[$ir],'0'); } ?>" onkeypress="return isNumber(event)" />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani2_income[]" value="<?php if(isset($ani2_income[$ir])){ echo trimleft($ani2_income[$ir],'0'); } ?>" onkeypress="return isDecimal(event)"  />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani2_expense_per_year[]" value="<?php if(isset($ani2_expense_per_year[$ir])){ echo trimleft($ani2_expense_per_year[$ir],'0'); } ?>" onkeypress="return isDecimal(event)"  />
                </td>
                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani2_food[]" value="<?php if(isset($ani2_food[$ir])){ echo trimleft($ani2_food[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>

                <td>
                    <input type="text" class="form-control allownumericwithdecimal input-no-spinner" name="ani2_wetchapan[]" value="<?php if(isset($ani2_wetchapan[$ir])){ echo trimleft($ani2_wetchapan[$ir],'0'); } ?>" onkeypress="return isDecimal(event)" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="ani2_specie[]" value="<?php if(isset($ani2specie[$ir])){ echo $ani2_specie[$ir]; } ?>" />
                </td>
            </tr>

            <?php } ?>

            <?php /*
                <tr>
                    <td>
                        <input name="ckcDel[]" type="checkbox" />
                    </td>
                    <td>
                        <input name="txtName[]" value="" />
                    </td>
                    <td>
                        <input name="txtCity[]" value="" />
                    </td>
                </tr>
 */ ?>
            </tbody>
            </table>
        </div>

    </div>
</div>

</div>

</section>
<section class="form-inline">
	<div class="h_sub_title">5.  ข้อมูลการใช้ปุ๋ย</div>
	

<div class="row mar_ned"  style="padding: 0 15px;">

    <div class="row">

        <div class="col-md-12 col-xs-12 wdth">

            <?php  $chm1_46_0_0 = '';
            if(isset($user_survey_data[strtoupper('chm1_46_0_0')])) {
                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm1_46_0_0')]); // print_r($product_sale_comment);
            }  //echo "<pre>"; print_r($chm1_46_0_0);
            ?>
            
            <table class="table table-striped table-bordered"  >
                <?php /*    <table id="tblAddRow" border="1"> */ ?>
                <thead>
                <tr>
                    <th rowspan="2" class="text-center" style="vertical-align: middle;">ที่</th>
                    <th rowspan="2" class="text-center" style="vertical-align: middle;">รายการ</th>
                    <th colspan="2" class="text-center">ซื้อจากสหกรณ์</th>
                    <th colspan="2" class="text-center"> ซื้อจากพ่อค้า </th>
                </tr>

                <tr>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">หน่วย(ระบุขนาด)</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">หน่วย(ระบุขนาด)</th>
                </tr>
                </thead>
                <tbody>



                <tr>
                    <td class="text-center">1</td>
                    <td> ปุ๋ยเคมี</td>
                    <td> </td>
                    <td> </td>
                    <td> </td><td> </td>
                </tr>
                <tr><?php  $chm_no = 1; $chm1 = 46; $chm2 = 0; $chm3 = 0; ?>
                    <td class="text-center"></td>

                    <td>1.<?php echo $chm_no; ?> สูตร <?php echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3; ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $chm_no; ?>]"  value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>">
                            
                        <td style="text-align: center;"> กก.</td>
                        </td>
                    <?php } ?>
                </tr>

                <tr> <?php  $chm_no = 2; $chm1 = 15; $chm2 = 15; $chm3 = 15; ?>
                    <td class="text-center"><?php //echo $chm_no; ?></td>

                    <td>1.<?php echo $chm_no; ?> สูตร <?php echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3; ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input  type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $chm_no; ?>]"  value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></td>
                            
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>

                <tr> <?php  $chm_no = 3; $chm1 = 16; $chm2 = 20; $chm3 = 0; ?>
                    <td class="text-center"><?php //echo $chm_no; ?></td>

                    <td>1.<?php echo $chm_no; ?> สูตร <?php echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3; ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $chm_no; ?>]"  value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></td>
                            
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>


                <tr> <?php  $chm_no = 4; $chm1 = 'other'; $chm2 = 'other'; $chm3 = 'other'; ?>
                    <td class="text-center"><?php //echo $chm_no; ?></td>

                    <td>1.<?php echo $chm_no; ?> อื่นๅ <?php /*echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3;*/ ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>[<?php echo $chm_no; ?>]"  value="<?php if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>">
                         </td>
                         
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>

                <tr> <?php  $chm_no = 2; $chm1 = 'intr'; $chm2 = 'intr'; $chm3 = 'intr'; ?>
                    <td class="text-center"><?php  echo $chm_no; ?></td>

                    <td> ปุ๋ยอินทรีย์ <?php /*echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3;*/ ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $chm_no; ?>]"   value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></td>
                            
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>

                <tr>
                    <td class="text-center">3</td>
                    <td>ยาปราบศัตรูพืช</td>
                    <td> </td>
                    <td> </td>
                    <td> </td><td> </td>
                </tr>
                <tr> <?php  $chm_no = 1; $chm1 = 'water'; $chm2 = 'water'; $chm3 = 'water'; ?>
                    <td class="text-center"><?php //echo $chm_no; ?></td>

                    <td>3.<?php echo $chm_no; ?> ชนิดน้ำ <?php /* echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3; */ ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $chm_no; ?>]"   value="<?php if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>">
                            </td>
                            
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>
                <tr> <?php  $chm_no = 2; $chm1 = 'c'; $chm2 = 'c'; $chm3 = 'c'; ?>
                    <td class="text-center"><?php //echo $chm_no; ?></td>

                    <td>3.<?php echo $chm_no; ?> ชนิดเม็ด/ผง<?php /* echo $chm1; ?> - <?php echo $chm2; ?> - <?php echo $chm3; */ ?></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_<?php echo $chm2; ?>_<?php echo $chm3; ?>[<?php echo $chm_no; ?>]"   value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_'.$chm2.'_'.$chm3)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></td>
                            
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td> เมล็ดพันธุ์</td>
                    <td> </td>
                    <td> </td>
                    <td> </td><td> </td>
                </tr>
                <tr> <?php  $chm_no = 1; $chm1 = 'seed'; ?>
                    <td><?php //echo $chm_no; ?></td>

                    <td><div class="pull-left">4.<?php echo $chm_no; ?>&nbsp;&nbsp;</div>
                    <div style="display: block; overflow: hidden;"><input class="form-control input-no-spinner"  type="text" name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_text[<?php echo $j; ?>]" value="<?php if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_text')]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></div></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner" name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>[<?php echo $chm_no; ?>]"  value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></td>
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>
                
                <tr> <?php  $chm_no = 2; $chm1 = 'seed'; ?>
                    <td class="text-center"><?php //echo $chm_no; ?></td>

                    <td><div class="pull-left">4.<?php echo $chm_no; ?>&nbsp;&nbsp;</div>
                    <div style="display: block; overflow: hidden;"><input class="form-control input-no-spinner"  type="text" name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>_text[<?php echo $j; ?>]" value="<?php if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1.'_text')]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></div></td>
                    <?php for($j=1;$j<=2;$j++){ ?>
                        <td> <input type="text" onkeypress="return isDecimal(event)"  class="form-control allownumericwithdecimal input-no-spinner"  name="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>[<?php echo $j; ?>]" id="chm<?php echo $chm_no; ?>_<?php echo $chm1; ?>[<?php echo $chm_no; ?>]"  value="<?php      if(isset($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)])) {
                                $chm1_46_0_0 = unserialize($user_survey_data[strtoupper('chm'.$chm_no.'_'.$chm1)]);
                                echo trimleft($chm1_46_0_0[$j],'0');
                            }   ?>"></td>
                        <td style="text-align: center;"> กก.</td>
                    <?php } ?>
                </tr>

                </tbody>
            </table>



        </div>
    </div>
</div>


</section>




<?php include("_btn_next_step.php"); ?>


