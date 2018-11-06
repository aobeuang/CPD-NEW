
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>


<div>
	<?php echo $output; ?>
</div>

<script>
$("#field-passwd").attr("placeholder", "รหัสผ่านจำเป็นต้องมี A-Z อย่างน้อย 1 ตัวอักษร").blur();


// $('#field-ORG_ID').attr('disabled',true);
$( document ).ready(function() {
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
				
			}
			$('#field-ORG_ID').html(html);
			$('#field-ORG_ID').attr('disabled',false);

			}
			
	});
});


$( "#field-province" ).change(function() {
	$('#field-ORG_ID').html('');
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
				
			}
			$('#field-ORG_ID').html(html);
			$('#field-ORG_ID').attr('disabled',false);

			}
			
	});
});

</script>
