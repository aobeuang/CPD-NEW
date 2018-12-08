<style type="text/css">
.fileUpload {
    position: relative;
    overflow: hidden;
    float: left;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.flieName {    
    float: left;
    display: inline-block;
    width: 60%;
    margin-left: 10px;
}

</style>
<div class="container box">

<?php 


$attributes = array('id' => 'import_csv');
?>
<p>Page Code : MNG007</p>
<div class="row">

<div class="col-sm-6">

<?php echo form_open_multipart('csv_import/import',$attributes);?>

<form method="post" id="import_csv" enctype="multipart/form-data">
   <div class="form-group">
    <label id="status-respone">นำเข้าข้อมูลผู้ใช้งาน</label>
    
   </div>
   <div class="form-group col-sm-8">
      <div class="fileUpload btn btn-primary">
          <span>เลือกไฟล์ข้อมูล</span>
          <input type="file" name="csv_import_file" id="csv_import_file" class="upload" required accept=".csv" />
      </div>
      <input id="import_file" class="form-control flieName" placeholder="" disabled="disabled" />
   </div>
   <div class="col-sm-4">
    <div class="form-group">
    <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">นำเข้าข้อมูล</button>
    </div>
   </div>
   
  </form>
</div>
<div class="col-sm-6">
  <?php $attributes = array('id' => 'update_csv'); ?>
  <?php echo form_open_multipart('csv_import/update_data',$attributes);?>

<form method="post" id="update_csv" enctype="multipart/form-data">
   <div class="form-group">
    <label id="status-respone">ปรับปรุงข้อมูลสิทธิ์ผู้ใช้งาน</label>
    
   </div>
   <div class="form-group col-sm-8">
    <div class="fileUpload btn btn-primary">
          <span>เลือกไฟล์ข้อมูล</span>
          <input type="file" name="csv_update_file" id="csv_update_file" class="upload" required accept=".csv" />
      </div>
      <input id="update_file" class="form-control flieName" placeholder="" disabled="disabled" />
   </div>
   <div class="col-sm-4">
    <div class="form-group">
    <button type="submit" name="import_csv" class="btn btn-warning" id="update_csv_btn">อัพเดทข้อมูล</button>
      </div>
   </div>
   
  </form>
  </div>
</div>

 <script>
$(document).ready(function(){
  $('#survey-code').hide();
   $('#import_csv').on('submit', function(event){
    event.preventDefault();
    $.ajax({
     url:"<?php echo site_url('csv_import/import'); ?>",
     method:"POST", 
     data:new FormData(this),
     contentType:false,
     cache:false,
     processData:false,
     beforeSend:function(){
      $('#import_csv_btn').html('กำลังดำเนินการ...');
     },
     success:function(data)
     {

      $('#import_csv')[0].reset();
      $('#import_csv_btn').attr('disabled', false);
      $('#import_csv_btn').html('Import Done');
      $('#status-respone').html('ดำเนินการสำเร็จ');

    

     },
     error:function(data)
     {

      $('#import_csv')[0].reset();
      $('#import_csv_btn').attr('disabled', false);
      $('#import_csv_btn').html('Import Error');
      $('#status-respone').html('ไม่สามารถดำเนินการได้ กรุณาลองใหม่');

    

     }
    })
   });


   $('#update_csv').on('submit', function(event){
    event.preventDefault();
    $.ajax({
     url:"<?php echo site_url('csv_import/update_data'); ?>",
     method:"POST", 
     data:new FormData(this),
     contentType:false,
     cache:false,
     processData:false,
     beforeSend:function(){
      $('#update_csv_btn').html('กำลังดำเนินการ...');
     },
     success:function(data)
     {

      $('#update_csv')[0].reset();
      $('#update_csv_btn').attr('disabled', false);
      $('#update_csv_btn').html('Import Done');
      $('#status-respone').html('ดำเนินการสำเร็จ');

    

     },
     error:function(data)
     {

      $('#update_csv')[0].reset();
      $('#update_csv_btn').attr('disabled', false);
      $('#update_csv_btn').html('Update Error');
      $('#status-respone').html('ไม่สามารถดำเนินการได้ กรุณาลองใหม่');

    

     }
    })
   });

   document.getElementById("csv_import_file").onchange = function () {
      document.getElementById("import_file").value = this.files[0].name;
   };

   document.getElementById("csv_update_file").onchange = function () {
      document.getElementById("update_file").value = this.files[0].name;
   };


 
});
</script>