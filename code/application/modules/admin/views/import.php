<div class="container box">
  <h3 align="center">How to Import CSV Data into Mysql using Codeigniter</h3>
  <br />
<?php 

$attributes = array('id' => 'import_csv');
?>


<?php echo form_open_multipart('csv_import/import',$attributes);?>

<?php echo form_upload('files'); ?>

<button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>


 <script>
$(document).ready(function(){


 $('#import_csv').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo site_url('admin/importFile'); ?>",
   method:"POST",
   data:new FormData(this),
   contentType:false,
   cache:false,
   processData:false,
   beforeSend:function(){
    $('#import_csv_btn').html('Importing...');
   },
   success:function(data)
   {
    $('#import_csv')[0].reset();
    $('#import_csv_btn').attr('disabled', false);
    $('#import_csv_btn').html('Import Done');
    load_data();
   }
  })
 });
 
});
</script>