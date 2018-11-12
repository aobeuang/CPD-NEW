<?php
$this->set_css($this->default_theme_path.'/bootstrap/css/bootstrap/bootstrap.min.css');
$this->set_css($this->default_theme_path.'/bootstrap/css/font-awesome/css/font-awesome.min.css');
$this->set_css($this->default_theme_path.'/bootstrap/css/common.css');
$this->set_css($this->default_theme_path.'/bootstrap/css/general.css');
$this->set_css($this->default_theme_path.'/bootstrap/css/add-edit-form.css');

if ($this->config->environment == 'production') {
    $this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
    $this->set_js_lib($this->default_theme_path.'/bootstrap/build/js/global-libs.min.js');
} else {
    $this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
    $this->set_js_lib($this->default_theme_path.'/bootstrap/js/jquery-plugins/jquery.form.js');
    $this->set_js_lib($this->default_theme_path.'/bootstrap/js/common/cache-library.js');
    $this->set_js_lib($this->default_theme_path.'/bootstrap/js/common/common.js');
}

include(__DIR__ . '/common_javascript_vars.php');
?>


<div class="crud-form" data-unique-hash="<?php echo $unique_hash; ?>">
    <div id="main-wrapper">
        <div class="container-fluid col-md-12 col-xs-12" >
            <div class="row form-result">
            	<!--  <p>Page Code : ACC002</p> -->
            	<div class="form-result-header">ข้อมูลบัญชีผู้ใช้</div>
                <!-- <div class="table-label">
                    <div class="floatL l5">
                        
                    </div>
                    <div class="floatR r5 minimize-maximize-container minimize-maximize">
                        <i class="fa fa-caret-up"></i>
                    </div>
                    <div class="floatR r5 gc-full-width">
                        <i class="fa fa-expand"></i>
                    </div>
                    <div class="clear"></div>
                </div> -->
                <div class="">
                    <?php echo form_open( $update_url, 'method="post" id="crudForm"  enctype="multipart/form-data" class="form-horizontal"'); ?>

					<?php $province = null;?>
					<?php $agency = null;?>
					
                    <?php foreach($fields as $field) { ?>
                    	<?php if($field->field_name == 'auth_level'){
                    		
                    		if($ci->session->userdata('auth_role') == "central_normal")
                    			$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนกลางระดับจัดการ';
                    		if($ci->session->userdata('auth_role') == "central_manager")
                    			$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนกลางระดับบริหาร';
                    		if($ci->session->userdata('auth_role') == "notcentral_normal")
                    			$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนภูมิภาคระดับจัดการ';
                    		if($ci->session->userdata('auth_role') == "notcentral_manager")
                    			$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนภูมิภาคระดับบริหาร';
                    		if($ci->session->userdata('auth_role') == "admin_normal")
                    			$input_fields[$field->field_name]->input = 'ผู้ดูแลระบบระดับจัดการ';                    	
                    		if($ci->session->userdata('auth_role') == "admin")
                    			$input_fields[$field->field_name]->input = 'ผู้ดูแลระบบระดับบริหาร';
                    	}
                    	?>
                    	 
                    	<?php if ($field->field_name!="passwd"  && $field->field_name!="banned"
                    			&& $field->field_name!="last_login" && $field->field_name!="created_by"
                    			&& $field->field_name!="modified_by"  && $field->field_name!="user_id"  && $field->field_name!="AGENCY" 
                    			&& $field->field_name!="province" && $field->field_name!="ORG_ID"
                    			):?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo $input_fields[$field->field_name]->display_as?>:
                            </label>
                            <div class="col-sm-9 read-row">
                                <?php echo $input_fields[$field->field_name]->input; ?>
                            </div>
                        </div>
                        <?php endif;?>
                        
                        
                        <?php if ($field->field_name=="province"){
                        	$province = $field;
                        }
                    	?>
                        <?php if ($field->field_name=="AGENCY"){
                        	$agency = $field;
                        }
                    	?>
                        <?php if ($field->field_name=="ORG_ID"){
                            $org_id = $field;
                        }
                        ?>
                        
                    <?php }?>
                    
	                   <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo $input_fields[$org_id->field_name]->display_as?>:
                            </label>
                            <div class="col-sm-9 read-row">
                                <?php 
                                // echo $input_fields[$province->field_name]->input; 
                                $s = $input_fields[$org_id->field_name]->input;
                                     $t = trim($s,'<div id="field-ORG_ID" class="readonly_label"></div>');
                                    $text = getOrgByID($t);
                                    // echo$text->PROVINCE_NAME;
                                echo $text['org_name'];
                                ?>


                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo $input_fields[$province->field_name]->display_as?>:
                            </label>
                            <div class="col-sm-9 read-row">
                                <?php 
                                // echo $input_fields[$province->field_name]->input; 
                                $s = $input_fields[$province->field_name]->input;
                                     $t = trim($s,'<div id="field-province" class="readonly_label"></div>');
                                    $text = getProvinceByID($t);
                                    echo$text->PROVINCE_NAME;
                                ?>


                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo $input_fields[$agency->field_name]->display_as?>:
                            </label>
                            <div class="col-sm-9 read-row">
                                <?php echo $input_fields[$agency->field_name]->input; ?>
                            </div>
                        </div>                    
                    

                    <?php if(!empty($hidden_fields)){?>
                        <!-- Start of hidden inputs -->
                        <?php
                        foreach($hidden_fields as $hidden_field){
                            echo $hidden_field->input;
                        }
                        ?>
                        <!-- End of hidden inputs -->
                    <?php } ?>
                    <?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
                    <div id='report-error' class='report-div error'></div>
                    <div id='report-success' class='report-div success'></div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7" style="display:none">
                            <?php 	if(!$this->unset_back_to_list) { ?>
                                
                                    <a class="btn btn-default" href="<?php echo site_url("mystuffs/home/myedit") ?>"><i class="fa fa-pencil"></i> <?php echo $this->l('list_edit'); ?></a>


                                </button>
                            <?php } ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var validation_url = '<?php echo $validation_url?>';
    var list_url = '<?php echo $list_url?>';

    var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
    var message_update_error = "<?php echo $this->l('update_error')?>";
</script>