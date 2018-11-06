<?php if($mode!="view"){ ?>
<div class="group-button-step">
		<?php
		if($intab_id>1 && $intab_id<7){  ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="$('#st<?php echo $intab_id-1; ?>').click()" data-toggle="tab" title="steb<?php echo $intab_id-1; ?>"   type="button" class="btn btn-secondary pull-left" style="">Previous</button>
        <?php }
        ?>  
 		<?php
 		if($intab_id==7){  ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="$('#st5').click()" data-toggle="tab" title="steb<?php echo $intab_id-1; ?>"   type="button" class="btn btn-secondary  pull-left" style="">Previous</button>
        <?php }
        ?>         
        
        <?php
        if($intab_id+1==8){  ?>
            <button     data-toggle="tab" id="moveOn"    type="submit" class="btn btn-primary pull-right" style="">Save</button>

            <?php
        }else{ ?>
            <button <?php /*href="#steb<?php echo $intab_id+1; ?>" */ ?> onclick="tab_active(<?php echo $intab_id+1; ?>)" data-toggle="tab" title="steb<?php echo $intab_id+1; ?>"   type="button" class="btn btn-primary pull-right" style="">Next</button>
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