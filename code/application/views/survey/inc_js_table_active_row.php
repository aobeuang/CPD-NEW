<?php ?>
<script type="text/javascript">
    $(window).load(function(){

// Add button Delete in row
        $('tbody tr')
            .find('td')
            //.append('<input type="button" value="Delete" class="del"/>')
            .parent() //traversing to 'tr' Element
        // .append('<td><a href="#" class="delrow">ลบแถว</a></td>');

// For select all checkbox in table
        $('#checkedAll<?php echo $table_id; ?>').click(function (e) {
            //e.preventDefault();
            $(this).closest('#tblAddRow<?php echo $table_id; ?>').find('td input:checkbox').prop('checked', this.checked);
        });

// Add row the table
        $('#btnAddRow<?php echo $table_id; ?>').on('click', function() {
            var lastRow = $('#tblAddRow<?php echo $table_id; ?> tbody tr:last').html();
            //alert(lastRow);
            $('#tblAddRow<?php echo $table_id; ?> tbody').append('<tr>' + lastRow + '</tr>');
            $('#tblAddRow<?php echo $table_id; ?> tbody tr:last input').val('');
        });

// Delete last row in the table
        $('#btnDelLastRow<?php echo $table_id; ?>').on('click', function() {
            var lenRow = $('#tblAddRow<?php echo $table_id; ?> tbody tr').length;
            //alert(lenRow);
            if (lenRow == 1 || lenRow <= 1) {
                alert("ท่านไม่สามารถลบทั้งหมดได้คะ อย่างน้อยต้องเหลือไว้หนึ่งแถวข้อมูล!");
            } else {
                $('#tblAddRow<?php echo $table_id; ?> tbody tr:last').remove();
            }
        });

// Delete row on click in the table
        $('#tblAddRow<?php echo $table_id; ?>').on('click', 'tr a', function(e) {
            var lenRow = $('#tblAddRow<?php echo $table_id; ?> tbody tr').length;
            e.preventDefault();
            if (lenRow == 1 || lenRow <= 1) {
                alert("ท่านไม่สามารถลบทั้งหมดได้คะ อย่างน้อยต้องเหลือไว้หนึ่งแถวข้อมูล!");
            } else {
                $(this).parents('tr').remove();
            }
        });

// Delete selected checkbox in the table
        $('#btnDelCheckRow<?php echo $table_id; ?>').click(function() {
            var lenRow		= $('#tblAddRow<?php echo $table_id; ?> tbody tr').length;
            var lenChecked	= $("#tblAddRow<?php echo $table_id; ?> input[type='checkbox']:checked").length;
            var row	= $("#tblAddRow<?php echo $table_id; ?> tbody input[type='checkbox']:checked").parent().parent();
            //alert(lenRow + ' - ' + lenChecked);
            if (lenRow == 1 || lenRow <= 1 || lenChecked >= lenRow) {
                alert("ท่านไม่สามารถลบทั้งหมดได้คะ อย่างน้อยต้องเหลือไว้หนึ่งแถวข้อมูล!");
            } else {
                row.remove();
            }
        });


    });

</script>

<?php if($mode!="view"){ ?>
<!--  
<button id="btnAddRow<?php //echo $table_id; ?>" type="button">
<!--     เพิ่มข้อมูล -->
<!-- </button> -->

<!--  
<button id="btnDelLastRow<?php //echo $table_id; ?>" type="button">
<!--     ลบข้อมูลแถวสุดท้าย -->
<!-- </button> -->
<!--  
<button id="btnDelCheckRow<?php //echo $table_id; ?>" type="button">
<!--     ลบแถวข้อมูลที่เลือก -->
<!-- </button> -->
<?php } ?>

<div style="overflow-x: scroll; weight:600px;" >
    <table id="tblAddRow<?php echo $table_id; ?>"    class="table table-striped table-condensed"  >
        <thead>
        <tr>
            <th rowspan="3"><input type="checkbox" id="checkedAll<?php echo $table_id; ?>"/></th>