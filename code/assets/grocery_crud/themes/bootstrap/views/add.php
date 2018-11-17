<style>
	#field-username, #field-passwd, #field-email, #field-name {
		width: 50%;
	}
</style>
<script>

$(document).ready(function() {
    $("#field-username").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }

        var pin = $("#field-username").val();
        if (pin.length>12)
        {
        	e.preventDefault();
        }
    });
});

</script>


<?php
    $this->set_css($this->default_theme_path.'/bootstrap/css/bootstrap/bootstrap.min.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/font-awesome/css/font-awesome.min.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/common.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/general.css');
    $this->set_css($this->default_theme_path.'/bootstrap/css/add-edit-form.css');

    if ($this->config->environment == 'production') {
        $this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
        $this->set_js_lib($this->default_theme_path.'/bootstrap/build/js/global-libs.min.js');
        $this->set_js_config($this->default_theme_path.'/bootstrap/js/form/add.min.js');
    } else {
        $this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
        $this->set_js_lib($this->default_theme_path.'/bootstrap/js/jquery-plugins/jquery.form.min.js');
        $this->set_js_lib($this->default_theme_path.'/bootstrap/js/common/common.min.js');
        $this->set_js_config($this->default_theme_path.'/bootstrap/js/form/add.js');
    }


include(__DIR__ . '/common_javascript_vars.php');
?>
<div class="crud-form" data-unique-hash="<?php echo $unique_hash; ?>">
    <div id="main-wrapper">
        <div class="container-fluid col-md-12 col-xs-12" >
            <div class="row form-result">
                <div class="form-result-header">
                    <?php echo $this->l('form_add'); ?><?php echo $subject?>
                </div>
                <div class="">
                        <?php echo form_open( $insert_url, 'method="post" id="crudForm"  enctype="multipart/form-data" class="form-horizontal"'); ?>

                            <?php foreach($fields as $field) { ?>
                                <div class="form-group <?php echo $field->field_name; ?>_form_group">
                                    <label class="col-sm-3 control-label">
                                        <?php echo $input_fields[$field->field_name]->display_as; ?><?php echo ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : ""; ?>
                                    </label>
                                    <div class="col-sm-9">
                                        <?php echo $input_fields[$field->field_name]->input?>
                                        	<?php if($field->field_name == "passwd"):?>                                        		
                                        		<p class="text-danger" style="margin: 10px 0 0px;font-size: 11px;">**รหัสผ่านต้องประกอบด้วยอักษรตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว ตัวอักษร ตัวเลข และสัญลักษณ์ผสมกันในรูปแบบใดก็ได้**</p>   
                                            <?php elseif($field->field_name == "username"): ?>
                                                <p class="text-danger" style="margin: 10px 0 0px;font-size: 11px;">**โปรดระบุเป็นหมายเลขบัตรประชาชน**</p>
                                            <?php endif;?>
                                    </div>
                                </div>
                            <?php }?>
                            <!-- Start of hidden inputs -->
                            <?php
                            foreach ($hidden_fields as $hidden_field) {
                                echo $hidden_field->input;
                            }
                            ?>
                            <!-- End of hidden inputs -->
                            <?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>

                            <div class='small-loading hidden' id='FormLoading'><?php echo $this->l('form_insert_loading'); ?></div>

                            <div class="form-group">
                                <div id='report-error' class='report-div error bg-danger' style="display:none"></div>
                                <div id='report-success' class='report-div success bg-success' style="display:none"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-7">
                                    <button class="btn btn-outline-green b10" type="submit" id="form-button-save">
                                        <?php echo $this->l('form_save'); ?>
                                    </button>
                                    <?php 	if(!$this->unset_back_to_list) { ?>
                                        <!-- <button class="btn btn-info b10" type="button" id="save-and-go-back-button">
                                            <i class="fa fa-rotate-left"></i>
                                            <?php echo $this->l('form_save_and_go_back'); ?>
                                        </button> -->
                                        <button class="btn btn-outline-red cancel-button b10" type="button" id="cancel-button">
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

	var message_alert_add_form = "<?php echo $this->l('alert_add_form')?>";
	var message_insert_error = "<?php echo $this->l('insert_error')?>";



    $('#field-ORG_ID').html('');
$('#field-ORG_ID').attr('disabled',true);

$( "#field-province" ).change(function() {
    $.ajax(
    {
        url:'<?php echo site_url('admin/getListOrg')?>',
        dataType: 'json',
        data:{province:$("#field-province").val()},
        success:function(result){

            console.log(result);

            var html ='';   
            for(var i = 0;i<result.items.length;i++)
                {

                    html +='<option selected value="'+result.items[i].org_org_id+'">'+result.items[i].org_name+'</option>';
                    html2 =result.items[i].org_name;
                
            }
            $('#field-ORG_ID').html(html);
            $('#field-org_name').html(html2);
            $('#field-ORG_ID').attr('disabled',false);

            }
            
    });
});
</script>