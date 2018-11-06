
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
<!-- <fieldset> -->
<!-- 	<legend class="h_sub_title">1.  พื้นที่ครอบครองทั้งสิ้น</legend> -->

<!-- <div class="row mar_ned"> -->


<!--     <div class="col-md-12 col-xs-9"> -->
<!--         <div class="row"> -->

<!--             <div class="col-md-4 col-xs-4 wdth"> -->
<!-- 				<label>ไร่</label> 
                <input type="number" class="form-control" id="land_holding_rai" name="land_holding_rai" placeholder="ไร่" value="<?php //$temp_field = 'land_holding_rai'; if(isset($user_survey_data[strtoupper($temp_field)])){ echo $user_survey_data[strtoupper($temp_field)]; } ?>">
<!--             </div> -->
<!--             <div class="col-md-4 col-xs-4 wdth"> -->
<!--             <label>งาน</label> 
                <input type="number" class="form-control" id="land_holding_ngan" name="land_holding_ngan" placeholder="งาน" value="<?php //$temp_field = 'land_holding_ngan'; if(isset($user_survey_data[strtoupper($temp_field)])){ echo $user_survey_data[strtoupper($temp_field)]; } ?>">
-->
            <script>
//                 var t = false

//                 $('#land_holding_ngan').focus(function () {
//                     var $this = $(this)

//                     t = setInterval(

//                         function () {
//                             if (($this.val() < 0 || $this.val() >= 4) ) {
//                                 if ($this.val() < 1) {
//                                     $this.val(0)
//                                 }

//                                 if ($this.val() >= 4) {
//                                     $this.val(3)
//                                 }

//                             }
//                         }, 50)
//                 })

//                 $('#land_holding_ngan').blur(function () {
//                     if (t != false) {
//                         window.clearInterval(t)
//                         t = false;
//                     }
//                 })


//                 var f = false



            </script>
<!--             </div> -->
<!--             <div class="col-md-4 col-xs-4 wdth"> -->
<!--             <label>ตารางวา</label>
                <input type="number" class="form-control" id="land_holding_squarewa" name="land_holding_squarewa" placeholder="ตารางวา" value="<?php //$temp_field = 'land_holding_squarewa'; if(isset($user_survey_data[strtoupper($temp_field)])){ echo $user_survey_data[strtoupper($temp_field)]; } ?>">
<!--             </div> -->
            <script>
//                 $('#land_holding_squarewa').focus(function () {
//                     var $this = $(this)

//                     f = setInterval(

//                         function () {
//                             if (($this.val() < 0 || $this.val() >= 100)) {
//                                 if ($this.val() < 0) {
//                                     $this.val(0)
//                                 }

//                                 if ($this.val() >= 100) {
//                                     $this.val(99)
//                                 }

//                             }
//                         }, 50)
//                 })

//                 $('#land_holding_squarewa').blur(function () {
//                     if (f != false) {
//                         window.clearInterval(f)
//                         f = false;
//                     }
//                 })
            </script>
<!--         </div> -->
<!--     </div> -->


<!-- </div> -->
<!-- </fieldset> -->

<?php  $intab_id =2; ?>
<!-- <h4 class="h_sub_title"></h4> -->

<!-- <fieldset> -->
<!-- 	<legend class="h_sub_title">1.  ที่ตั้งแปลง/ฟาร์ม</legend> -->

<!-- 	<div class="row mar_ned"> -->

<!-- 		<div class="row"> -->

<!-- 			<div class="col-md-4 col-xs-4 wdth"> -->
<!-- 				<p align="left"><stong></stong></p> -->
<!-- 			</div> -->
<!-- 			<div class="col-md-4 col-xs-4 wdth"> -->
<!-- 				<p align="left"><stong></stong></p> -->
<!-- 			</div> -->
<!-- 			<div class="col-md-4 col-xs-4 wdth"> -->
<!-- 				<p align="left"><stong></stong></p> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 	</div> -->
	
<!--     <div class="col-md-12 col-xs-9"> -->
<!--         <div class="row"> 



            <?php //$table_id = 241; include("inc_js_table_active_row.php"); ?>

            <th style="text-align: center;">หมู่ที่</th>
            <th style="text-align: center;">ตรอก/ซอย</th>
            <th style="text-align: center;">ตำบล/แขวง</th>
            <th style="text-align: center;">จังหวัด</th>
            <th style="text-align: center;">การถือครอง</th>
<!-- 			<th></th> -->
<!--             </tr> -->
<!--             </thead> -->
<!--             <tbody> -->
 <?php
//             // echo "<pre>"; print_r($user_survey_data);
//             $ani_specie = '';
//             $all_row = 1;
//             if(isset($user_survey_data[strtoupper('ani_specie')])) {
//                 $ani_specie = unserialize($user_survey_data[strtoupper('ani_specie')]); // print_r($plant_type);
//                 $all_row = count($plant_type);
//             }
//             //echo "<pre>"; print_r($plant_type);
//             $ani_specie = '';
//             if(isset($user_survey_data[strtoupper('ani_specie')])) {
//                 $ani_specie = unserialize($user_survey_data[strtoupper('ani_specie')]);   //print_r($plant_specie);
//             }

//             $ani_num_per_year = '';
//             if(isset($user_survey_data[strtoupper('ani_num_per_year')])) {
//                 $ani_num_per_year = unserialize($user_survey_data[strtoupper('ani_num_per_year')]);   //print_r($plant_specie);
//             }

//             $ani_growing_area = '';
//             if(isset($user_survey_data[strtoupper('ani_growing_area')])) {
//                 $ani_growing_area = unserialize($user_survey_data[strtoupper('ani_growing_area')]);   //print_r($plant_specie);
//             }


//             $ani_product_num_per_year = '';
//             if(isset($user_survey_data[strtoupper('ani_product_numyear')])) {
//                 $ani_product_num_per_year = unserialize($user_survey_data[strtoupper('ani_product_numyear')]);   //print_r($plant_specie);
//             }

//             $ani_area_rai = '';
//             if(isset($user_survey_data[strtoupper('ani_area_rai')])) {
//                 $ani_area_rai = unserialize($user_survey_data[strtoupper('ani_area_rai')]);   //print_r($plant_specie);
//             }

//             $ani_area_rai = '';
//             if(isset($user_survey_data[strtoupper('ani_area_rai')])) {
//                 $ani_area_rai = unserialize($user_survey_data[strtoupper('ani_area_rai')]);   //print_r($plant_specie);
//             }

//             for($ir=0;$ir<$all_row;$ir++){ //echo $ani_specie[$ir]."<br/>";
//             ?>


<!--             <tr> -->
           
<!--                 <td> -->
<!--                     <input name="ckcDel[]" type="checkbox" /> -->
<!--                 </td> -->
                
<!--                 <td> -->
<!--                     <input  type="number" class="input-no-spinner" name="ani_area_rai[]" value="" /> -->
<!--                 </td> -->
<!--                 <td> -->
<!--                     <input type="number" class="input-no-spinner" name="ani_specie[]" value="" /> -->
<!--                 </td> -->
<!--                 <td> -->
<!--                     <input type="number" class="input-no-spinner" name="ani_specie[]" value="" /> -->
<!--                 </td> -->
<!--                 <td> -->
<!--                     <input type="number" class="input-no-spinner" name="ani_num_per_year[]" value="" /> -->
<!--                 </td> -->
                
<!--                 <td> -->
<!--                     <select id="multiselect" class="form-control"> -->
<!-- 						<option value=""> ครัวเรือน</option> -->
<!-- 					    <optgroup  label="เช่า">  -->
<!-- 							<option>มีสัญญา</option> -->
<!-- 							<option>ไม่มีสัญญา</option> -->
<!-- 						</optgroup > -->
<!-- 					    <option value=> อื่นๆ</option> -->
<!--                     </select> -->
<!--                 </td> -->
                
<!--                 <td><a href="#" class="delrow">ลบแถว</a></td> -->
<!--             </tr> -->
 <?php //}?>
<!--             </tbody> -->
<!--             </table> -->
<!--         </div> -->

<!--     </div> -->
<!-- </div> -->
<!-- </fieldset> -->
<fieldset>
	<legend class="h_sub_title">1.  ที่ดินทำการเกษตร </legend>

    <div class="col-md-12 col-xs-9">
        <div class="row">



            <?php $table_id = 242; include("inc_js_table_active_row.php"); ?>
				<th style="text-align: center;" rowspan="2" >ลักษณะที่ดิน</th>
               <th style="text-align: center;" rowspan="2" >ประเภท</th>
               <th style="text-align: center;" rowspan="2" >เลขที่</th>
               <th style="text-align: center;" rowspan="2" >ระวาง</th>
               <th style="text-align: center;" colspan="3" class="text-center">พื่นที่</th>
               <th style="text-align: center;" rowspan="2" >เลขที่บัตรประชาชน</th>
               <th style="text-align: center;" rowspan="2" >ชื่อ</th>
               <th style="text-align: center;" rowspan="2" >นามสกุล</th>
               <th rowspan="2" ></th>
            </tr>
            <tr>
            <th style="text-align: center;" >ไร่</th>
            <th style="text-align: center;" >งาน</th>
            <th style="text-align: center;" >ตร.วา</th>
            </tr>
            </thead>
            <tbody>
<?php
            // echo "<pre>"; print_r($user_survey_data);
			$own_land_type_code = array();
			$own_land_type_code['1'] = "ที่ดินของตัวเอง"; 
			$own_land_type_code['2'] = "ที่ดินเช่า";
            $own_land_type = '';
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('own_land_type')])) {
                $own_land_type = unserialize($user_survey_data[strtoupper('own_land_type')]); // print_r($plant_type);
                if(is_null($own_land_type))
                	$own_land_type= 0;
                $all_row = count($own_land_type);
            }
            $all_row = $all_row==0 ? 1: $all_row;
            
            
            //echo "<pre>"; print_r($plant_type);
            $land_type = '';
            if(isset($user_survey_data[strtoupper('own_land_type_type')])) {
                $land_type = unserialize($user_survey_data[strtoupper('own_land_type_type')]);   //print_r($plant_specie);
                if(is_null($land_type))
                	$land_type= array();
            }

            $own_land_number = '';
            if(isset($user_survey_data[strtoupper('own_land_number')])) {
                $own_land_number = unserialize($user_survey_data[strtoupper('own_land_number')]);   //print_r($plant_specie);
                if(is_null($own_land_number))
                	$own_land_number= array();
            }

            $own_land_ravang = '';
            if(isset($user_survey_data[strtoupper('own_land_ravang')])) {
                $own_land_ravang = unserialize($user_survey_data[strtoupper('own_land_ravang')]);   //print_r($plant_specie);
                if(is_null($own_land_ravang))
                	$own_land_ravang= array();
            }


            $own_land_rai = '';
            if(isset($user_survey_data[strtoupper('own_land_rai')])) {
                $own_land_rai = unserialize($user_survey_data[strtoupper('own_land_rai')]);   //print_r($plant_specie);
                if(is_null($own_land_rai))
                	$own_land_rai= array();
            }

            $own_land_ngan = '';
            if(isset($user_survey_data[strtoupper('own_land_ngan')])) {
                $own_land_ngan = unserialize($user_survey_data[strtoupper('own_land_ngan')]);   //print_r($plant_specie);
                if(is_null($own_land_ngan))
                	$own_land_ngan= array();
            }

            $own_land_squarewa = '';
            if(isset($user_survey_data[strtoupper('own_land_squarewa')])) {
                $own_land_squarewa = unserialize($user_survey_data[strtoupper('own_land_squarewa')]);   //print_r($plant_specie);
                if(is_null($own_land_squarewa))
                	$own_land_squarewa= array();
            }
            
            $own_land_pin = '';
            if(isset($user_survey_data[strtoupper('own_land_pin')])) {
            	$own_land_pin = unserialize($user_survey_data[strtoupper('own_land_pin')]);   //print_r($plant_specie);
            	if(is_null($own_land_pin))
            		$own_land_pin= array();
            }
            
            $own_land_pname = '';
            if(isset($user_survey_data[strtoupper('own_land_pname')])) {
            	$own_land_pname = unserialize($user_survey_data[strtoupper('own_land_pname')]);   //print_r($plant_specie);
            	if(is_null($own_land_pname))
            		$own_land_pname= array();
            }
            
            $own_land_sname = '';
            if(isset($user_survey_data[strtoupper('own_land_sname')])) {
            	$own_land_sname = unserialize($user_survey_data[strtoupper('own_land_sname')]);   //print_r($plant_specie);
            	if(is_null($own_land_sname))
            		$own_land_sname= array();
            }
            

            for($ir=0;$ir<$all_row;$ir++){ //echo $ani_specie[$ir]."<br/>";
            ?>


            <tr>
           
                <td class="checkboxcol">
                    <input name="ckcDel[]" type="checkbox" />
                </td>
                <td >
                	<select id="own_land_type" name="own_land_type[]">               	
                		<?php foreach ($own_land_type_code as $k=>$v){?>
                			<option <?php if(isset($own_land_type[$ir])){  if($own_land_type[$ir]==$k){ echo ' selected ';  }    }?> value="<?php echo $k?>"><?php echo $v?></option>
                		<?php }  ?>
                	</select>
                </td>
                <td >
                	<select id="land_type" name="own_land_type_type[]">
                		<option <?php if(isset($land_type[$ir])){  if($land_type[$ir]==1){ echo ' selected ';  }    }?>  value="1">โฉนด/น.ส.3 ก./น.ส.3</option>
                		<option <?php if(isset($land_type[$ir])){  if($land_type[$ir]==2){ echo ' selected ';  }    }?>  value="2">สปก.4-01/น.คส.ท.ก./ก.ส.น.</option>
                		<option <?php if(isset($land_type[$ir])){  if($land_type[$ir]==3){ echo ' selected ';  }    }?>  value="3">น.ส.2/น.ส.1/ภบท.5/<option>
                	</select>
                </td>
                <td>
                    <input type="number" class="form-control input-no-spinner"  name="own_land_number[]" value="<?php if (isset($own_land_number[$ir])) echo trimleft($own_land_number[$ir], '0');?>"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                <td>
                    <input type="text" class="form-control input-no-spinner"  name="own_land_ravang[]" value="<?php if (isset($own_land_ravang[$ir])) echo trimleft($own_land_ravang[$ir], '0')?>"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"   onkeypress="return isAlphaNumeric(event);" />
                </td>
                <td>
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner own_land_rai" name="own_land_rai[]" value="<?php if (isset($own_land_rai[$ir])) echo trimleft($own_land_rai[$ir], '0')?>" onkeypress="return isNumber(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                
                <td>
                     <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner own_land_ngan" name="own_land_ngan[]" value="<?php if (isset($own_land_ngan[$ir])) echo trimleft($own_land_ngan[$ir], '0')?>" onkeypress="return isNumber(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                 <td>
                     <input type="number" class="form-control allownumericwithdecimal input-no-spinner own_land_squarewa" name="own_land_squarewa[]" value="<?php if (isset($own_land_squarewa[$ir])) echo trimleft($own_land_squarewa[$ir], '0')?>" onkeypress="return isNumber(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                <td>
                     <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner own_land_pin" maxlength="13"  min="0" max="9999999999999" name="own_land_pin[]" value="<?php if (isset($own_land_pin[$ir])) echo $own_land_pin[$ir]?>" onkeypress="return isPinNumber(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                  <td>
                     <input type="text" class="form-control input-no-spinner first_name_land" name="own_land_pname[]"  value="<?php if (isset($own_land_pname[$ir])) echo $own_land_pname[$ir]?>" onkeypress="return isAlpha(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                <td>
                     <input type="text" class="form-control input-no-spinner last_name_land" name="own_land_sname[]"  value="<?php if (isset($own_land_sname[$ir])) echo $own_land_sname[$ir]?>" onkeypress="return isAlpha(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                <td class="align-middle"><a href="#" class="delrow nowrap">ลบแถว</a></td>
            </tr>
<?php }?>
            </tbody>
            </table>
        </div>

    </div>
</div>
</fieldset>
<!-- 
<fieldset>
	<legend class="h_sub_title">3.  พื้นที่ทำการเกษร (เช่า)</legend>

	<div class="row mar_ned">

		<div class="row">

			<div class="col-md-12 col-xs-4 wdth">
				<p align="left"><stong></stong></p>
			</div>
		</div>
	</div>
	
    <div class="col-md-12 col-xs-9">
        <div class="row">



            <?php //$table_id = 243; include("inc_js_table_active_row.php"); ?>

             <th style="text-align: center;" rowspan="2" >ประเภท</th>
               <th style="text-align: center;" rowspan="2" >เลขที่</th>
               <th style="text-align: center;" rowspan="2" >ระวาง</th>
               <th style="text-align: center;" colspan="3" class="text-center">พื่นที่</th>
               <th style="text-align: center;" rowspan="2" >เลขที่บัตรประชาชน</th>
               <th style="text-align: center;" rowspan="2" >ชื่อ</th>
               <th style="text-align: center;" rowspan="2" >นามสกุล</th>
               <th rowspan="2" ></th>
            </tr>
            <tr>
            <th style="text-align: center;" >ไร่</th>
            <th style="text-align: center;" >งาน</th>
            <th style="text-align: center;" >ตร.วา</th>
            </tr>
            </thead>
            <tbody>
<?php
            // echo "<pre>"; print_r($user_survey_data);
//             $ani_specie = '';
//             $all_row = 1;
//             if(isset($user_survey_data[strtoupper('ani_specie')])) {
//                 $ani_specie = unserialize($user_survey_data[strtoupper('ani_specie')]); // print_r($plant_type);
//                 $all_row = count($plant_type);
//             }
//             //echo "<pre>"; print_r($plant_type);
//             $ani_specie = '';
//             if(isset($user_survey_data[strtoupper('ani_specie')])) {
//                 $ani_specie = unserialize($user_survey_data[strtoupper('ani_specie')]);   //print_r($plant_specie);
//             }

//             $ani_num_per_year = '';
//             if(isset($user_survey_data[strtoupper('ani_num_per_year')])) {
//                 $ani_num_per_year = unserialize($user_survey_data[strtoupper('ani_num_per_year')]);   //print_r($plant_specie);
//             }

//             $ani_growing_area = '';
//             if(isset($user_survey_data[strtoupper('ani_growing_area')])) {
//                 $ani_growing_area = unserialize($user_survey_data[strtoupper('ani_growing_area')]);   //print_r($plant_specie);
//             }


//             $ani_product_num_per_year = '';
//             if(isset($user_survey_data[strtoupper('ani_product_numyear')])) {
//                 $ani_product_num_per_year = unserialize($user_survey_data[strtoupper('ani_product_numyear')]);   //print_r($plant_specie);
//             }

//             $ani_area_rai = '';
//             if(isset($user_survey_data[strtoupper('ani_area_rai')])) {
//                 $ani_area_rai = unserialize($user_survey_data[strtoupper('ani_area_rai')]);   //print_r($plant_specie);
//             }

//             $ani_area_rai = '';
//             if(isset($user_survey_data[strtoupper('ani_area_rai')])) {
//                 $ani_area_rai = unserialize($user_survey_data[strtoupper('ani_area_rai')]);   //print_r($plant_specie);
//             }

           // for($ir=0;$ir<$all_row;$ir++){ //echo $ani_specie[$ir]."<br/>";
            ?>


            <tr>
           
                <td>
                    <input name="ckcDel[]" type="checkbox" />
                </td>
                
                <td >
                	<select id="hire_land_type[]">
                		<option>โฉนด/น.ส.3 ก./น.ส.3</option>
                		<option>สปก.4-01/น.คส.ท.ก./ก.ส.น.</option>
                		<option>น.ส.2/น.ส.1/ภบท.5/<option>
                	</select>
                </td>
                <td>
                    <input type="number" class="input-no-spinner" name="hire_land_number[]" value="" />
                </td>
                <td>
                    <input type="text" class="input-no-spinner" name="hire_land_ravang[]" value="" />
                </td>
                <td>
                    <input type="number" class="input-no-spinner hire_land_rai" name="hire_land_rai[]" value="" />
                </td>
                
                <td>
                     <input type="number" class="input-no-spinner hire_land_ngan" name="hire_land_ngan[]" value="" />
                </td>
                 <td>
                     <input type="number" class="input-no-spinner hire_land_squarewa" name="hire_land_squarewa[]" value="" />
                </td>
                <td>
                     <input type="number" class="input-no-spinner hire_land_pin" name="hire_land_pin[]" value="" />
                </td>
                  <td>
                     <input type="number" class="input-no-spinner" name="hire_land_pname[]" value="" />
                </td>
                <td>
                     <input type="number" class="input-no-spinner" name="hire_land_sname[]" value="" />
                </td>
                <td><a href="#" class="delrow">ลบแถว</a></td>
            </tr>
<?php //}?>
            </tbody>
            </table>
            
        </div>
	</div>
</div>
	

</fieldset>
 -->
 
 
 
 
 
<fieldset>
<legend class="h_sub_title">2.  แหล่งน้ำ</legend>

	
            <?php $table_id = 244; //include("inc_js_table_active_row_checkbox.php"); ?>


<?php /*
            <th style="text-align: center;" rowspan="3">แหล่งน้ำเพื่อการเกษตร</th>           
			<th style="text-align: center;" colspan="3">แหล่งน้ำตนเอง</th>
			<th style="text-align: center;" colspan="4">แหล่งน้ำสาธารณะ</th>
			<th rowspan="2" ></th>
			
            </tr>
            <tr>
            	<th style="text-align: center;">บ่อน้ำตื้น</th>
            	<th style="text-align: center;">บ่อบาดาล</th>
            	<th style="text-align: center;">สระน้ำ</th>
            	
            	<th style="text-align: center;">บ่อบาดาล</th>
            	<th style="text-align: center;">หนอง/สระ</th>
            	<th style="text-align: center;">คลองชลประทาน</th>
            	<th style="text-align: center;">แม่น้ำ</th>
            </tr>
            </thead>
            <tbody>
            */?>
            
<?php
            $all_row = 1;
            if(isset($user_survey_data[strtoupper('water')])) {
                $water = unserialize($user_survey_data[strtoupper('water')]); // print_r($plant_type);
                if(is_null($water))
                	$water =array();
                $all_row = count($water);
                $all_row = $all_row==0 ? 1: $all_row;
            }

            $water_shallow_well_own = '';
            if(isset($user_survey_data[strtoupper('water_shallow_well_own')])) {
                $water_shallow_well_own = unserialize($user_survey_data[strtoupper('water_shallow_well_own')]);   //print_r($plant_specie);
                if(is_null($water_shallow_well_own))
                	$water_shallow_well_own = array();
            }

            $water_groundwater_wells_own = '';
            if(isset($user_survey_data[strtoupper('water_groundwater_wells_own')])) {
                $water_groundwater_wells_own = unserialize($user_survey_data[strtoupper('water_groundwater_wells_own')]);   //print_r($plant_specie);
                if(is_null($water_groundwater_wells_own))
                	$water_groundwater_wells_own = array();
            }


            $water_ponds_own = '';
            if(isset($user_survey_data[strtoupper('water_ponds_own')])) {
                $water_ponds_own = unserialize($user_survey_data[strtoupper('water_ponds_own')]);   //print_r($plant_specie);
                if(is_null($water_ponds_own))
                	$water_ponds_own = array();
            }

            $water_groundwater_wells_public = '';
            if(isset($user_survey_data[strtoupper('water_groundwater_wells_public')])) {
                $water_groundwater_wells_public = unserialize($user_survey_data[strtoupper('water_groundwater_wells_public')]);   //print_r($plant_specie);
                if(is_null($water_groundwater_wells_public))
                	$water_groundwater_wells_public = array();
            }

            $water_swamp_public = '';
            if(isset($user_survey_data[strtoupper('water_swamp_public')])) {
                $water_swamp_public = unserialize($user_survey_data[strtoupper('water_swamp_public')]);   //print_r($plant_specie);
                if(is_null($water_swamp_public))
                	$water_swamp_public = array();
            }
            
            $water_Irrigation_canal_public = '';
            if(isset($user_survey_data[strtoupper('water_Irrigation_canal_public')])) {
            	$water_Irrigation_canal_public = unserialize($user_survey_data[strtoupper('water_Irrigation_canal_public')]);   //print_r($plant_specie);
            	if(is_null($water_Irrigation_canal_public))
            		$water_Irrigation_canal_public = array();
            }
            

            $water_river_public = '';
            if(isset($user_survey_data[strtoupper('water_river_public')])) {
            	$water_river_public = unserialize($user_survey_data[strtoupper('water_river_public')]);   //print_r($plant_specie);
            	if(is_null($water_river_public))
            		$water_river_public = array();
            }            

            $ir = 0; //echo $ani_specie[$ir]."<br/>";
            $water[$ir] = isset($water[$ir]) ? $water[$ir] : 0;
            
            ?>
            
	<div class="row">
            <div class="col-md-12 col-xs-12">
                <label>
                    <strong>มีแหล่งน้ำที่ใช้ในการเกษตร</strong>
                </label>
            </div>
            
            <input type="hidden" name="water[]" id="water" value="<?php echo $water[$ir]?>" />
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="water_option"  id="water-radio" onclick="waterSwitch(false)" <?php if (isset($water) && $water[$ir]==0) echo "checked"?> value="0" > ไม่มี
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="water_option" id="water-radio" onclick="waterSwitch(true)" <?php if (isset($water) && $water[$ir]==1) echo "checked"?> alue="1" > มี
                </label>
            </div>
            
           <div class="col-md-12 col-xs-12" style="margin-bottom:-10px;">
              	&#160;
           </div>
            <ul class="list-unstyled">
            <li class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" id="water_shallow_well_own" name="water_shallow_well_own[]"  class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?> <?php if (isset($water_shallow_well_own[$ir]) && $water_shallow_well_own[$ir]==true) echo "checked=checked"?>     value="1"> บ่อน้ำตื้นของตนเอง
                </label>
            </li>
            <li class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" id="water_groundwater_wells_own" name="water_groundwater_wells_own[]"  class="water" <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_groundwater_wells_own[$ir]) && $water_groundwater_wells_own[$ir]==true) echo "checked=checked"?>  value="2"> บ่อบาดาลของตนเอง
                </label>
            </li>            
            <li class="col-md-6 col-xs-12">
                <label>
                    <input type="checkbox" id="water_ponds_own" name="water_ponds_own[]"  class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_ponds_own[$ir]) && $water_ponds_own[$ir]==true) echo "checked=checked"?>    value="3"> สระน้ำของตนเอง
                </label>
            </li>       
            <li class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" id="water_groundwater_wells_public" name="water_groundwater_wells_public[]"  class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?> <?php if (isset($water_groundwater_wells_public[$ir]) && $water_groundwater_wells_public[$ir]==true) echo "checked=checked"?>     value="4"> บ่อบาดาลสาธารณะ
                </label>
            </li>    
            <li class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" id="water_swamp_public" name="water_swamp_public[]"  class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>   <?php if (isset($water_swamp_public[$ir]) && $water_swamp_public[$ir]==true) echo "checked=checked"?>    value="5"> หนอง/สระสาธารณะ
                </label>
            </li>            
            <li class="col-md-6 col-xs-12">
                <label>
                    <input type="checkbox" id="water_Irrigation_canal_public" name="water_Irrigation_canal_public[]" class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_Irrigation_canal_public[$ir]) && $water_Irrigation_canal_public[$ir]==true) echo "checked=checked"?>    value="6"> คลองชลประทานสาธารณะ
                </label>
            </li>         
            <li class="col-md-3 col-xs-12">
                <label>
                    <input type="checkbox" id="water_river_public" name="water_river_public[]" class="water"   <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_river_public[$ir]) && $water_river_public[$ir]==true) echo "checked=checked"?>   value="7"> แม่น้ำสาธารณะ
                </label>
            </li> 
           	</ul>
                                    
            <script type="text/javascript">
				function waterSwitch(value){
					if(value)
					{
						$(".water").prop('disabled', false);
						$("#water").val('1');
					}else{
						$('.water').prop('checked', false); 
						$(".water").prop('disabled', true);
						$("#water").val('0');
					}
				}
            </script>
    </div>


</fieldset>




<?php include("_btn_next_step.php"); ?>
