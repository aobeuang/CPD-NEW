<?php $intab_id =6; ?>
<h4 class="h_sub_title">ข้อมูลการผลิต</h4>

<label>ส่วนที่ 6 ข้อมูลการผลิต (พืช/สัตว์เลี้ยง ปีปัจจุบัน) (พืชที่ปลูก หรือสัตว์เลี้ยงแล้วในปีนี้ และที่คาดหวังว่าจะปลูกพืชหรือสัตว์เลี้ยงในปีนี้)</label>




<div class="row mar_ned">

    <div class="row">

        <div class="col-md-5 col-xs-4 wdth">
            <p align="left"><stong> 6.1 พืช </stong></p>
        </div>
        <div class="col-md-5 col-xs-4 wdth">
            <p align="left"><stong> </stong></p>
        </div>
        <div class="col-md-2 col-xs-4 wdth">
            <p align="left"><stong> </stong></p>
        </div>
    </div>



    <div class="col-md-12 col-xs-9">
        <div class="row">
            <div class="col-md-3 col-xs-12">
            </div>
        </div>
    </div>

</div>



<div class="row mar_ned">




    <div class="col-md-12 col-xs-9">
        <div class="row">

            <?php $table_id = 61; include("inc_js_table_active_row.php"); ?>

            <th rowspan="2">ชนิด</th>
            <th rowspan="2">พันธุ์</th>
            <th colspan="2" class="text-center">การปลูกพืช</th>
            <th rowspan="2">ผลผลิตที่คาดว่าจะได้ (ตัน)</th>
            <th rowspan="2" > </th>
            </tr>

            <tr>

                <th>ปลูกแล้ว (ไร่)</th>
                <th>คิดว่าจะปลูก (ไร่)</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php  $tab6_a1_type = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('tab6_a1_type')])) {
                $tab6_a1_type = unserialize($user_survey_data[strtoupper('tab6_a1_type')]); // print_r($product_sale_comment);
                $all_row = count($tab6_a1_type);
            }
            $tab6_a1_species = '';
            if(isset($user_survey_data[strtoupper('tab6_a1_species')])) {
                $tab6_a1_species = unserialize($user_survey_data[strtoupper('tab6_a1_species')]); // print_r($product_sale_comment);

            }

            $tab6_a1_doing = '';
            if(isset($user_survey_data[strtoupper('tab6_a1_doing')])) {
                $tab6_a1_doing = unserialize($user_survey_data[strtoupper('tab6_a1_doing')]); // print_r($product_sale_comment);

            }

            $tab6_a1_willdo = '';
            if(isset($user_survey_data[strtoupper('tab6_a1_willdo')])) {
                $tab6_a1_willdo = unserialize($user_survey_data[strtoupper('tab6_a1_willdo')]); // print_r($product_sale_comment);

            }
            $tab6_a1_expected_output = '';
            if(isset($user_survey_data[strtoupper('tab6_a1_expected_output')])) {
                $tab6_a1_expected_output = unserialize($user_survey_data[strtoupper('tab6_a1_expected_output')]); // print_r($product_sale_comment);

            }
            for($i=0;$i<$all_row;$i++){
            ?>
            <tr>
                <td>
                    <input name="ckcDel[]" type="checkbox" />
                </td>

                <td>
                    <input name="tab6_a1_type[]" value="<?php if(isset($tab6_a1_type[$i])){ echo $tab6_a1_type[$i]; } ?>"     />
                </td>
                <td>
                    <input name="tab6_a1_species[]" value="<?php if(isset($tab6_a1_species[$i])){ echo $tab6_a1_species[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a1_doing[]" value="<?php if(isset($tab6_a1_doing[$i])){ echo $tab6_a1_doing[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a1_willdo[]" value="<?php if(isset($tab6_a1_willdo[$i])){ echo $tab6_a1_willdo[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a1_expected_output[]" value="<?php if(isset($tab6_a1_expected_output[$i])){ echo $tab6_a1_expected_output[$i]; } ?>" />
                </td>
                <td class="align-middle"><a href="#" class="delrow nowrap">ลบแถว</a></td>
            </tr>
           <?php } ?>


            </tbody>
            </table>
        </div>


    </div>
</div>

</div>







<div class="row mar_ned">

    <div class="row">

        <div class="col-md-5 col-xs-4 wdth">
            <p align="left"><stong> 6.2 สัตว์/ประมง </stong></p>
        </div>
        <div class="col-md-5 col-xs-4 wdth">
            <p align="left"><stong> </stong></p>
        </div>
        <div class="col-md-2 col-xs-4 wdth">
            <p align="left"><stong> </stong></p>
        </div>
    </div>



    <div class="col-md-12 col-xs-9">
        <div class="row">
            <div class="col-md-3 col-xs-12">
            </div>
        </div>
    </div>

</div>


<div class="row mar_ned">




    <div class="col-md-12 col-xs-9">
        <div class="row">

            <?php $table_id = 62; include("inc_js_table_active_row.php"); ?>

            <th rowspan="2">ชนิด</th>
            <th rowspan="2">พันธุ์</th>
            <th colspan="2" class="text-center">การเลี้ยงสัตว์</th>
            <th rowspan="2">มูลค่าสัตว์ที่จะเลี้ยงไว้ขาย (ตัน)</th>
            <th rowspan="2" > </th>
            </tr>

            <tr>

                <th>เลี้ยงแล้ว (ตัว)</th>
                <th>คิดว่าจะเลี้ยง (ตัว)</th>
                <th></th>
            </tr>
            </thead>
            <tbody>


            <?php  $tab6_a2_type = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('tab6_a2_type')])) {
                $tab6_a2_type = unserialize($user_survey_data[strtoupper('tab6_a2_type')]); // print_r($product_sale_comment);
                $all_row = count($tab6_a2_type);
            }

            $tab6_a2_species = '';
            if(isset($user_survey_data[strtoupper('tab6_a2_species')])) {
                $tab6_a2_species = unserialize($user_survey_data[strtoupper('tab6_a2_species')]); // print_r($product_sale_comment);

            }
            $tab6_a2_doing = '';
            if(isset($user_survey_data[strtoupper('tab6_a2_doing')])) {
                $tab6_a2_doing = unserialize($user_survey_data[strtoupper('tab6_a2_doing')]); // print_r($product_sale_comment);
            }

            $tab6_a2_willdo = '';
            if(isset($user_survey_data[strtoupper('tab6_a2_willdo')])) {
                $tab6_a2_willdo = unserialize($user_survey_data[strtoupper('tab6_a2_willdo')]); // print_r($product_sale_comment);
            }
            $tab6_a2_expected_output = '';
            if(isset($user_survey_data[strtoupper('tab6_a2_expected_output')])) {
                $tab6_a2_expected_output = unserialize($user_survey_data[strtoupper('tab6_a2_expected_output')]); // print_r($product_sale_comment);
            }

            for($i=0;$i<$all_row;$i++){
            ?>



            <tr>
                <td>
                    <input name="ckcDel[]" type="checkbox" />
                </td>

                <td>
                    <input name="tab6_a2_type[]" value="<?php if(isset($tab6_a2_type[$i])){ echo $tab6_a2_type[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a2_species[]" value="<?php if(isset($tab6_a2_species[$i])){ echo $tab6_a2_species[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a2_doing[]" value="<?php if(isset($tab6_a2_doing[$i])){ echo $tab6_a2_doing[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a2_willdo[]" value="<?php if(isset($tab6_a2_willdo[$i])){ echo $tab6_a2_willdo[$i]; } ?>" />
                </td>
                <td>
                    <input name="tab6_a2_expected_output[]" value="<?php if(isset($tab6_a2_expected_output[$i])){ echo $tab6_a2_expected_output[$i]; } ?>" />
                </td>
                <td class="align-middle"><a href="#" class="delrow nowrap">ลบแถว</a></td>
            </tr>

            <?php } ?>

            </tbody>
            </table>
        </div>


    </div>
</div>

</div>







<?php include("_btn_next_step.php"); ?>
