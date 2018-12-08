
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

<?php  $intab_id =2; ?>
<div class="form-result-header">พื้นที่ครอบครอง</div>
<section>
	<div class="h_sub_title">1.  ที่ดินทำการเกษตร </div>

    <div class="col-md-12">
        <div class="col-md-12">
            <?php $table_id = 242; include("inc_js_table_active_row.php"); ?>
                <th style="text-align: center;vertical-align: middle;" rowspan="2" >ลักษณะที่ดิน</th>
                <th style="text-align: center;vertical-align: middle;" rowspan="2" >ประเภท</th>
                <th style="text-align: center;vertical-align: middle;width: 80px;" rowspan="2" >เลขที่</th>
                <th style="text-align: center;vertical-align: middle;width: 80px;" rowspan="2" >ระวาง</th>
                <th style="text-align: center;vertical-align: middle;" colspan="3" class="text-center">พื่นที่</th>
                <th style="text-align: center;vertical-align: middle;" rowspan="2" >เลขที่บัตรประชาชน</th>
                <th style="text-align: center;vertical-align: middle;" rowspan="2" >ชื่อ</th>
                <th style="text-align: center;vertical-align: middle;" rowspan="2" >นามสกุล</th>
            </tr>
            <tr>
            <th style="text-align: center;width: 80px;" >ไร่</th>
            <th style="text-align: center;width: 80px;" >งาน</th>
            <th style="text-align: center;width: 80px;" >ตร.วา</th>
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
                    <input name="ckcDel[]" type="checkbox" /><span></span>
                </td>
                <td >
                	<select id="own_land_type" name="own_land_type[]" class="form-control">               	
                		<?php foreach ($own_land_type_code as $k=>$v){?>
                			<option <?php if(isset($own_land_type[$ir])){  if($own_land_type[$ir]==$k){ echo ' selected ';  }    }?> value="<?php echo $k?>"><?php echo $v?></option>
                		<?php }  ?>
                	</select>
                </td>
                <td >
                	<select id="land_type" name="own_land_type_type[]" class="form-control">
                		<option <?php if(isset($land_type[$ir])){  if($land_type[$ir]==1){ echo ' selected ';  }    }?>  value="1">โฉนด/น.ส.3 ก./น.ส.3</option>
                		<option <?php if(isset($land_type[$ir])){  if($land_type[$ir]==2){ echo ' selected ';  }    }?>  value="2">สปก.4-01/น.คส.ท.ก./ก.ส.น.</option>
                		<option <?php if(isset($land_type[$ir])){  if($land_type[$ir]==3){ echo ' selected ';  }    }?>  value="3">น.ส.2/น.ส.1/ภบท.5/<option>
                	</select>
                </td>
                <td style="width: 80px;">
                    <input type="number" class="form-control input-no-spinner"  name="own_land_number[]" value="<?php if (isset($own_land_number[$ir])) echo trimleft($own_land_number[$ir], '0');?>"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                <td style="width: 80px;">
                    <input type="text" class="form-control input-no-spinner"  name="own_land_ravang[]" value="<?php if (isset($own_land_ravang[$ir])) echo trimleft($own_land_ravang[$ir], '0')?>"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"   onkeypress="return isAlphaNumeric(event);" />
                </td>
                <td style="width: 80px;">
                    <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner own_land_rai" name="own_land_rai[]" value="<?php if (isset($own_land_rai[$ir])) echo trimleft($own_land_rai[$ir], '0')?>" onkeypress="return isNumber(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                
                <td style="width: 80px;">
                     <input type="number" class="form-control allownumericwithoutdecimal input-no-spinner own_land_ngan" name="own_land_ngan[]" value="<?php if (isset($own_land_ngan[$ir])) echo trimleft($own_land_ngan[$ir], '0')?>" onkeypress="return isNumber(event)"  autocomplete="off" oncopy="return false"  oncut="return false" onpaste="return false"/>
                </td>
                 <td style="width: 80px;">
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
            </tr>
<?php }?>
            </tbody>
            </table>
        </div>

    </div>
</div>
</section>

 
<section>
<div class="h_sub_title">2.  แหล่งน้ำ</div>

	
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
            
	<div class="col-md-12">
            <div class="col-md-12">
                <label>
                    <strong>มีแหล่งน้ำที่ใช้ในการเกษตร</strong>
                </label>
            </div>
            
            <input type="hidden" name="water[]" id="water" value="<?php echo $water[$ir]?>" />
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="water_option"  id="water-radio" onclick="waterSwitch(false)" <?php if (isset($water) && $water[$ir]==0) echo "checked"?> value="0" > <span>ไม่มี</span>
                </label>
            </div>
            <div class="col-md-2 col-xs-12">
                <label>
                    <input type="radio" name="water_option" id="water-radio" onclick="waterSwitch(true)" <?php if (isset($water) && $water[$ir]==1) echo "checked"?> alue="1" > <span>มี</span>
                </label>
            </div>
            
           <div class="col-md-12 col-xs-12" style="margin-bottom:-10px;">
              	&#160;
           </div>
            <ul class="list-unstyled">
            <li class="col-md-3 col-xs-12">
                <label class="water">
                    <input type="checkbox" id="water_shallow_well_own" name="water_shallow_well_own[]" class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?> <?php if (isset($water_shallow_well_own[$ir]) && $water_shallow_well_own[$ir]==true) echo "checked=checked"?>     value="1"> <span>บ่อน้ำตื้นของตนเอง</span>
                </label>
            </li>
            <li class="col-md-3 col-xs-12">
                <label class="water">
                    <input type="checkbox" id="water_groundwater_wells_own" name="water_groundwater_wells_own[]" class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_groundwater_wells_own[$ir]) && $water_groundwater_wells_own[$ir]==true) echo "checked=checked"?>  value="2"> <span>บ่อบาดาลของตนเอง</span>
                </label>
            </li>            
            <li class="col-md-3 col-xs-12">
                <label class="water">
                    <input type="checkbox" id="water_ponds_own" name="water_ponds_own[]" class="water" <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_ponds_own[$ir]) && $water_ponds_own[$ir]==true) echo "checked=checked"?>    value="3"> <span>สระน้ำของตนเอง</span>
                </label>
            </li>       
            <li class="col-md-3 col-xs-12">
                <label class="water">
                    <input type="checkbox" id="water_groundwater_wells_public" name="water_groundwater_wells_public[]" class="water" <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?> <?php if (isset($water_groundwater_wells_public[$ir]) && $water_groundwater_wells_public[$ir]==true) echo "checked=checked"?>     value="4"> <span>บ่อบาดาลสาธารณะ</span>
                </label>
            </li>    
            <li class="col-md-3 col-xs-12">
                <label class="water">
                    <input type="checkbox" id="water_swamp_public" name="water_swamp_public[]" class="water" <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>   <?php if (isset($water_swamp_public[$ir]) && $water_swamp_public[$ir]==true) echo "checked=checked"?>    value="5"> <span>หนอง/สระสาธารณะ</span>
                </label>
            </li>            
            <li class="col-md-3 col-xs-12">
                <label class="water">
                    <input type="checkbox" id="water_Irrigation_canal_public" name="water_Irrigation_canal_public[]" class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_Irrigation_canal_public[$ir]) && $water_Irrigation_canal_public[$ir]==true) echo "checked=checked"?>    value="6"> <span>คลองชลประทานสาธารณะ</span>
                </label>
            </li>         
            <li class="col-md-3 col-xs-12">
                <label class="water" >
                    <input type="checkbox" id="water_river_public" name="water_river_public[]" class="water"  <?php if(isset($water[$ir])){ if($water[$ir]==0){  echo ' disabled  ';   } } ?>  <?php if (isset($water_river_public[$ir]) && $water_river_public[$ir]==true) echo "checked=checked"?>   value="7"> <span>แม่น้ำสาธารณะ</span>
                </label>
            </li> 
           	</ul>
                                    
            <script type="text/javascript">
                $(".water").css('display','none');
				function waterSwitch(value){
					if(value)
					{
						$(".water").prop('disabled', false);
						$("#water").val('1');
                        $(".water").css('display','block');
					}else{
						$('.water').prop('checked', false); 
						$(".water").prop('disabled', true);
						$("#water").val('0');
                        $(".water").css('display','none');
					}
				}
            </script>
    </div>


</section>




<?php include("_btn_next_step.php"); ?>
