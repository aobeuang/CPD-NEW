<?php if($mode!="view"){ ?>
<div class="col-md-12" style="padding: 30px 15px;">
		<?php
		if($intab_id>1 && $intab_id<7){  ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="$('#st<?php echo $intab_id-1; ?>').click()" data-toggle="tab" title="step<?php echo $intab_id-1; ?>"   type="button" class="btn btn-outline-purple pull-left" style=""><i class="fa fa-arrow-left"></i> ก่อนหน้า</button>
        <?php }
        ?>  
 		<?php
 		if($intab_id==7){  ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="$('#st5').click()" data-toggle="tab" title="step<?php echo $intab_id-1; ?>"   type="button" class="btn btn-outline-purple  pull-left" style=""><i class="fa fa-arrow-left"></i> ก่อนหน้า</button>
        <?php }
        ?>         
        
        <?php
        if($intab_id+1==8){  ?>
            <button     data-toggle="tab" id="moveOn" onclick="confirmSurvey();"    type="submit" class="btn btn-outline-blue pull-right" >บันทึก</button>

            <?php
        }else{ ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="tab_active(<?php echo $intab_id+1; ?>)" data-toggle="tab" title="step<?php echo $intab_id+1; ?>"   type="button" class="btn btn-outline-blue pull-right" style="">ถัดไป <i class="fa fa-arrow-right"></i></button>
        <?php }
        ?>
</div>
<script>
        function confirmSurvey() {
            bootbox.confirm({
                message: "ท่านต้องการส่งบันทึกข้อมูลใช่หรือไม่?",
                size: 'small',
                buttons: {
                    confirm: {
                        label: 'บันทึก',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'ยกเลิก',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        document.getElementById('accountForm').submit();
                    }
                }
            });
        }

</script>
<?php } ?>