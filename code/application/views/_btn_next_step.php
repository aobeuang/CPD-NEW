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
            <button     data-toggle="tab" id="moveOn"    type="submit" class="btn btn-outline-blue pull-right" >บันทึก</button>

            <?php
        }else{ ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="tab_active(<?php echo $intab_id+1; ?>)" data-toggle="tab" title="step<?php echo $intab_id+1; ?>"   type="button" class="btn btn-outline-blue pull-right" style="">ถัดไป <i class="fa fa-arrow-right"></i></button>
        <?php }
        ?>
</div>

<div id="dialog-confirm" title="Ready?">
    <p>ท่านต้องการส่งฟอร์มใช่หรือไม่ ?</p>
</div>
<script>
    $(function() {
        $("#dialog-confirm").dialog({
            resizable: false,
            height: 190,
            autoOpen: false,
            width: 330,
            modal: true,
            buttons: {
                "Yes": function() {
                    document.getElementById('accountForm').submit();
                },
                No: function() {
                    $(this).dialog("close");
                }
            }
        });

        $('#moveOn').on('click', function(e) {
            $("#dialog-confirm").dialog('open');
        });
    });
</script>
<?php } ?>