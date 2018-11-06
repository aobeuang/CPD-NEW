<?php $intab_id =7; ?>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;    
}

	.input-no-spinner {
    -moz-appearance: textfield;
    }
    .input-no-spinner::-webkit-outer-spin-button,
    .input-no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<h2 class="tab-title">ข้อมูลการเลี้ยงโคนม</h2>


<div class="row mar_ned fixed-row">




    <div class="col-md-12 col-xs-9">
        <div class="row">

            <?php $table_id = 711; include("inc_js_table_active_row.php"); ?>

            <th  style="text-align: center;" rowspan="2">เบอร์ถัง</th>
            <th  style="text-align: center;" rowspan="2">ลูกโค  0-1  เดือน(ตัว)</th>
            <th  style="text-align: center;" rowspan="2">ลูกโค  1เดือน-1ปี(ตัว)</th>
            <th  style="text-align: center;" rowspan="2">โคสาว  1ปี-2ปี  (ตัว)</th>
            <th  style="text-align: center;" rowspan="2">โคสาว  2ปี-ไม่ท้อง<br/>(ตัว)</th>
            <th  style="text-align: center;" rowspan="2">โคสาว   ท้อง  (ตัว)</th>

            <th  style="text-align: center;" colspan="3" class="text-center">แม่โคเตรียมรีดนม</th>
            <th  style="text-align: center;" colspan="3" class="text-center">แม่โคราย</th>
            </tr>

            <tr>

                <th style="text-align: center;" >ท้อง (ตัว)</th>
                <th style="text-align: center;" >ไม่ท้อง (ตัว)</th>
                <th style="text-align: center;" >รวม (ตัว)</th>
                <th style="text-align: center;" >ท้อง (ตัว)</th>
                <th style="text-align: center;" >ไม่ท้อง (ตัว)</th>
                <th style="text-align: center;" >รวม (ตัว)</th>
               
            </tr>
            </thead>
            <tbody>

            <?php  $tab7_a1_bucket_no = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('tab7_a1_bucket_no')])) {
                $tab7_a1_bucket_no = unserialize($user_survey_data[strtoupper('tab7_a1_bucket_no')]); // print_r($product_sale_comment);
                $all_row = count($tab7_a1_bucket_no);
               	$all_row = $all_row==0 ? 1: $all_row;               
            }
            $tab7_a1_cows1 = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cows1')])) {
                $tab7_a1_cows1 = unserialize($user_survey_data[strtoupper('tab7_a1_cows1')]); // print_r($product_sale_comment);
            }

            $tab7_a1_cows2 = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cows2')])) {
                $tab7_a1_cows2 = unserialize($user_survey_data[strtoupper('tab7_a1_cows2')]); // print_r($product_sale_comment);
            }

            $tab7_a1_cows3 = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cows3')])) {
                $tab7_a1_cows3 = unserialize($user_survey_data[strtoupper('tab7_a1_cows3')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cows4 = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cows4')])) {
                $tab7_a1_cows4 = unserialize($user_survey_data[strtoupper('tab7_a1_cows4')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cows5 = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cows5')])) {
                $tab7_a1_cows5 = unserialize($user_survey_data[strtoupper('tab7_a1_cows5')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cowsmilk_pregnant = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cowsmilk_pregnant')])) {
                $tab7_a1_cowsmilk_pregnant = unserialize($user_survey_data[strtoupper('tab7_a1_cowsmilk_pregnant')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cowsmilk_notpregnant = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cowsmilk_notpregnant')])) {
                $tab7_a1_cowsmilk_notpregnant = unserialize($user_survey_data[strtoupper('tab7_a1_cowsmilk_notpregnant')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cowsmilk_all = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cowsmilk_all')])) {
                $tab7_a1_cowsmilk_all = unserialize($user_survey_data[strtoupper('tab7_a1_cowsmilk_all')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cowslay_pregnant = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cowslay_pregnant')])) {
                $tab7_a1_cowslay_pregnant = unserialize($user_survey_data[strtoupper('tab7_a1_cowslay_pregnant')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cowslay_notpregnant = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cowslay_notpregnant')])) {
                $tab7_a1_cowslay_notpregnant = unserialize($user_survey_data[strtoupper('tab7_a1_cowslay_notpregnant')]); // print_r($product_sale_comment);
            }
            $tab7_a1_cowslay_all = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cowslay_all')])) {
                $tab7_a1_cowslay_all = unserialize($user_survey_data[strtoupper('tab7_a1_cowslay_all')]); // print_r($product_sale_comment);
            }

            $tab7_a1_cows_total = '';
            if(isset($user_survey_data[strtoupper('tab7_a1_cows_total')])) {
                $tab7_a1_cows_total = unserialize($user_survey_data[strtoupper('tab7_a1_cows_total')]); // print_r($product_sale_comment);
            }

            

            for($i=0;$i<$all_row;$i++){
            ?>


            <tr>
                <td class="checkboxcol">
                    <input name="ckcDel[]" type="checkbox" />
                </td>

                <td>
                    <input type="number" class="form-control input-no-spinner" name="tab7_a1_bucket_no[]" onkeypress="return isAlphaNumeric(event)"  value="<?php if(isset($tab7_a1_bucket_no[$i])){ echo trimleft($tab7_a1_bucket_no[$i],'0'); } ?>" autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cows1[]" value="<?php if(isset($tab7_a1_cows1[$i])){ echo trimleft($tab7_a1_cows1[$i],'0');} ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner"  name="tab7_a1_cows2[]" value="<?php if(isset($tab7_a1_cows2[$i])){ echo trimleft($tab7_a1_cows2[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cows3[]" value="<?php if(isset($tab7_a1_cows3[$i])){ echo trimleft($tab7_a1_cows3[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cows4[]" value="<?php if(isset($tab7_a1_cows4[$i])){ echo trimleft($tab7_a1_cows4[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cows5[]" value="<?php if(isset($tab7_a1_cows5[$i])){ echo trimleft($tab7_a1_cows5[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cowsmilk_pregnant[]" value="<?php if(isset($tab7_a1_cowsmilk_pregnant[$i])){ echo trimleft($tab7_a1_cowsmilk_pregnant[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cowsmilk_notpregnant[]" value="<?php if(isset($tab7_a1_cowsmilk_notpregnant[$i])){ echo trimleft($tab7_a1_cowsmilk_notpregnant[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cowsmilk_all[]" value="<?php if(isset($tab7_a1_cowsmilk_all[$i])){ echo trimleft($tab7_a1_cowsmilk_all[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cowslay_pregnant[]" value="<?php if(isset($tab7_a1_cowslay_pregnant[$i])){ echo trimleft($tab7_a1_cowslay_pregnant[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cowslay_notpregnant[]" value="<?php if(isset($tab7_a1_cowslay_notpregnant[$i])){ echo trimleft($tab7_a1_cowslay_notpregnant[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner" name="tab7_a1_cowslay_all[]" value="<?php if(isset($tab7_a1_cowslay_all[$i])){ echo trimleft($tab7_a1_cowslay_all[$i],'0'); } ?>" onkeypress="return isNumber(event)"/>
                </td>
            </tr>

<?php } ?>
            </tbody>
            </table>
        </div>

			
    </div>
</div>
	<center>
	<a class="btn btn-outline-purple my-2 my-sm-0" type="submit" id="save-and-go-back-button" href="<?php echo site_url("survey/search_survey_by_id")?>?step=0&citizen_id=<?php echo $user_survey_data['citizen_id']?>"><span class="glyphicon"></span> ย้อนกลับ</a>
	</center>          		
	
</div>





<?php //include("_btn_next_step.php"); ?>
