
<!-- <link type="text/css" rel="stylesheet" href="/assets/default/css/bootstrap.min.css" /> -->
<!-- <link type="text/css" rel="stylesheet" href="/assets/grocery_crud/themes/bootstrap/css/font-awesome/css/font-awesome.min.css" /> -->

<div id="main-wrapper">
	<div id="main-container" class="container-fluid col-md-12 col-xs-12">
		<center><h2><span class="glyphicon glyphicon-eye-open"></span> ข้อมูลรายละเอียดแบบสำรวจ</h2></center>
		</br>
		<div id="main-container2" class="container-fluid col-md-12 col-xs-12">
			
<?php $count_row = 1;?>
				<?php for ($i=0;$i<sizeof($survey);$i++):?>
				
				<div class="container">
				
					<div class="row">
					<?php 
						$count_collum = $i+3;
						while ($i<=$count_collum):
					?>
						    <?php if (!empty($survey[$i]) && !empty($survey[$i]['value'])):?>
								<?php if(!is_array($survey[$i]['value'])):?>
								  	<div class="col-md-3 col-lg-3 col-sm">
										<label><?php print_r($survey[$i]['label'])?></label>
										<span><?php print_r($survey[$i]['value'])?></span>
						    		</div>
								<?php else: ?>
									<div class="col-md-12 col-lg-12 col-sm">
										<label><?php print_r($survey[$i]['label'])?></label>
										<span><?php print_r(getDataArray($survey[$i]['value']));?></span>
						    		</div>
								<?php endif;?>
						    <?php endif;?>
						<?php 
						$i++;
						endwhile;
						?>
					
					</div>
				</div>
				<?php endfor;?>
		</div>		
		
	</div>

</div>
				
				<?php 
function getDataArray($datas)
{
		print_r('<div class="row">');
		foreach ($datas as $k=>$data)
		{
			print_r('<div class="col-md-3 col-lg-3 col-sm">');
			if(!is_numeric($k))
			{
				echo "<label>"+$k+"</label>";
			}
			print_r($data);
			print_r('</div>');
		}
		
		print_r('</div>');
}
function getKeyValue($value)
{
	if(isset($value) && !is_null($value) && is_array($value))
	{
		foreach ($value as $k=>$v)
		{
			print_r($k);
			if(is_array($v)){
				foreach ($v as $v2){
					print_r($v2);
				}
			}else{
				print_r($v);
			}
		}
	}
}

?>