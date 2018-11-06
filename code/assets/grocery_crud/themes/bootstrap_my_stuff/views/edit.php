<?php
    $this->set_css($this->default_theme_path.'/bootstrap/css/bootstrap/bootstrap.min.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/font-awesome/css/font-awesome.min.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/common.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/general.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/add-edit-form.css');

    if ($this->config->environment == 'production') {
        $this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
        $this->set_js_lib($this->default_theme_path.'/bootstrap/build/js/global-libs.min.js');
        $this->set_js_config($this->default_theme_path.'/bootstrap/js/form/edit.min.js');
    } else {
        $this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
        $this->set_js_lib($this->default_theme_path.'/bootstrap/js/jquery-plugins/jquery.form.min.js');
        $this->set_js_lib($this->default_theme_path.'/bootstrap/js/common/common.min.js');
        $this->set_js_config($this->default_theme_path.'/bootstrap/js/form/edit.js');
    }

include(__DIR__ . '/common_javascript_vars.php');
?>
<div class="crud-form" data-unique-hash="<?php echo $unique_hash; ?>">
    <div id="main-wrapper">
        <div class="container-fluid col-md-12 col-xs-12" >
            <div class="row form-result">
                <div class="form-result-header">
            	 <!-- <p>Page Code : ACC003</p> -->
                	เปลี่ยนรหัสผ่าน
                </div>
                <!-- <div class="table-label">
                    <div class="floatL l5">
                        <?php echo $this->l('form_edit'); ?> <?php echo $subject?>
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

                            
                           
                            <?php foreach($fields as $field) { ?>
                             <?php if ($field->field_name!="auth_level"  
                    			):?>
                                <div class="form-group <?php echo $field->field_name; ?>_form_group">
                                    <label class="col-sm-3 control-label">
                                        <?php echo $input_fields[$field->field_name]->display_as?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""?>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-6">
                                        <?php echo $input_fields[$field->field_name]->input; ?>
                                        
                                        <?php if($field->field_name == "passwd"):?>                                        		
                                        		<p class="text-danger" style="margin: 10px 0 0px;font-size: 11px;">*รหัสผ่านต้องประกอบด้วยอักษรตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว ตัวอักษร ตัวเลข และสัญลักษณ์ผสมกันในรูปแบบใดก็ได้</p>                                     	
                                        	<?php endif;?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                            <?php }?>
                            
							
							
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
                            <div class="form-group">
                                <div id='report-error' class='report-div error bg-danger' style="display:none"></div>
                                <div id='report-success' class='report-div success bg-success' style="display:none"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-7">
                                	<button class="btn  btn-outline-green b10" type="submit" id="form-button-save">
                                        <?php echo $this->l('form_update_changes'); ?>
                                    </button>
                                    <button class="btn btn-outline-red cancel-button b10" type="button" id="cancel-button">
                                            <?php echo $this->l('form_cancel'); ?>
                                    </button>
                                    <!-- <?php 	if(!$this->unset_back_to_list) { ?>
                                        <button class="btn btn-info b10" type="button" id="save-and-go-back-button">
                                            <i class="fa fa-rotate-left"></i>
                                            <?php echo $this->l('form_update_changes'); ?>
                                        </button>  
                                                      
                                    <?php } ?> -->
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