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
                <div class="form-result-header">
                    <?php echo $this->l('list_view'); ?><?php echo $subject?>
                    <?php
                $current_url = $_SERVER['REQUEST_URI'];
                    if (strpos($current_url, "/admin/users_management/read/")==TRUE): ?>
                        <span style="float: right;">Page Code : MNG004</span>
                    <?php elseif (strpos($current_url, "/mystuffs/home/read/222")==TRUE): ?>
                        <span style="float: right;">Page Code : MNG004</span>
                <?php endif;?>

                </div>
                <!-- <div class="table-label">
                    <div class="floatL l5">
                        <?php echo $this->l('list_view'); ?> <?php echo $subject?>
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo $input_fields[$field->field_name]->display_as?>:
                            </label>
                            <div class="col-sm-9 read-row">
                          <?php
                          if($field->field_name == 'auth_level') {
                          	if(strpos($input_fields[$field->field_name]->input, "9")!==FALSE)
                          		$input_fields[$field->field_name]->input = 'ผู้ดูแลระบบระดับบริหาร';
                          	if(strpos($input_fields[$field->field_name]->input, "8")!==FALSE)
                          		$input_fields[$field->field_name]->input = 'ผู้ดูแลระบบระดับจัดการ';
                          	if(strpos($input_fields[$field->field_name]->input, "6")!==FALSE)
                          		$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนภูมิภาคระดับบริหาร';
                          	if(strpos($input_fields[$field->field_name]->input, "5")!==FALSE)
                          		$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนภูมิภาคระดับจัดการ';
                          	if(strpos($input_fields[$field->field_name]->input, "2")!==FALSE)
                          		$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนกลางระดับบริหาร';
                          	if(strpos($input_fields[$field->field_name]->input, "1")!==FALSE)
                          		$input_fields[$field->field_name]->input = 'ผู้ใช้งานส่วนกลางระดับจัดการ';
                          }

                          if($field->field_name == 'created_at') {
                            $val = $input_fields[$field->field_name]->input;
                            $t = trim($val,'<div id="field-created_at" class="readonly_label"></div>');                            
                            $strYear = date("Y",strtotime($t))+543;
                            $strMonth= date("m",strtotime($t));
                            $strDay= date("d",strtotime($t));
                            $strHour= date("H",strtotime($t));
                            $strMinute= date("i",strtotime($t));
                            $strSeconds= date("s",strtotime($t));
                            echo "$strDay-$strMonth-$strYear $strHour:$strMinute:$strSeconds";
                            // echo print_r($input_fields[$field->field_name]->input);die();
                            }
                          ?>
                          <?php if ($field->field_name=="province"){
                            $s = $input_fields[$field->field_name]->input;
                                     $t = trim($s,'<div id="field-province" class="readonly_label"></div>');
                                    $text = getProvinceByID($t);
                                    echo$text->PROVINCE_NAME;
                            }
                            ?>
                          <?php if ( $field->field_name != 'created_at' && $field->field_name != 'province' ) { ?>
                            <?php echo $input_fields[$field->field_name]->input; ?>
                            <?php }?>
                                
                            </div>
                        </div>

                        



                    <?php }?>
                    
                    
  							<?php if (!$is_ajax && strpos($update_url,"workflow_management/read")!==false):?>
                            	<?php 
                            		$temp = explode("/",$update_url);
                            		if (count($temp)==8 && is_numeric($temp[7]))
                            		{
										echo "<iframe height=\"500px\" width=\"100%\" src=\"".base_url()."/admin/work_flow_management/".$temp[7]."\"></iframe>";                            			
                            		}
                            	?>
                            	
                            <?php endif?>
                                                
                    

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

                    
			        <?php if ($this->iframe_url!=null):?>
			        	<?php $temp = $this->getStateInfo();?>
			        	<iframe src="<?php echo $this->iframe_url.$temp->primary_key?>" width="100%" height="500px"/>
			        
			        <?php endif?>                    
                    
                    
                    
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-7">
                            <?php 	if(!$this->unset_back_to_list) { ?>
                                <button class="btn btn-default cancel-button" type="button" onclick="window.location = '<?php echo $list_url; ?>'" >
                                    <i class="fa fa-arrow-left"></i>
                                    <?php echo $this->l('form_back_to_list'); ?>
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