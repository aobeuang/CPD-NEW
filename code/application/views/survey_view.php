<?php 
		$this->load->helper('survey');
?>
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
	</br>
	<div class="container">

		<div class="row" style="float:right">
			<?php if(canDelete($citizen_id, $year)):?>
		    <div style="float: right;padding-left: 10px;">
		    <form method="GET" action="<?php echo site_url("survey/delete_survey")?>?coop=<?php echo $survey_array[0]['COOPERATIVE_CODE']?>&step=1&&org=">
		    <input type="hidden" name="citizen_id" value="<?php echo $citizen_id?>">		    
		    <input type="hidden" name="coop" value="<?php echo $survey_array[0]['COOP_ID']?>">
		    <input type="hidden" name="step" value="1">		    
		    <button class="btn btn-danger b10" type="submit" id="save-and-go-back-button">
		          <i class="fa fa-"></i>ลบ</button>
		    </form>
		    </div>
		     <?php endif ?> 
		
			<?php if(canUpdate($citizen_id, $year)):?>
			<div style="float: right;padding-left: 10px;">
			<form method="GET" action="<?php echo site_url("admin/do_survey_1")?>/<?php echo urlencode($citizen_id)?>/?coop=<?php echo $survey_array[0]['COOPERATIVE_CODE']?>&step=1&&org=">
		    	<input type="hidden" name="coop" value="<?php echo $survey_array[0]['COOP_ID']?>">
		    	<input type="hidden" name="step" value="1">		 
		    	<input type="hidden" name="citizen_id" value="<?php echo $citizen_id?>">   		    
		    	<button class="btn btn-info b10" type="submit" id="save-and-go-back-button" >
		          <i class="fa fa-"></i>แก้ไข</button>
		    </form>
		    </div>
		    <?php endif?>
		    
		
			<?php /* ?>
			<button class="btn btn-info b10" type="submit" id="save-and-go-back-button" style="float: right">
		          <i class="fa fa-"></i>ดาวโหลด PDF</button>		
				<br>
			*/	?>
		</div>
	</div>
				
				<?php 
				$output['survey'] = $survey;
				
				$this->load->view("survey_detail.php",$output);
				
				
				?>
				


<script type="text/javascript">

var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};
$('#save-and-go-back-button').click(function () {   

	window.location.href = "/index.php/Survey/exportSurveyToPDF/?citizen_id="+<?php echo $citizen_id?>+"&coop="+<?php echo $coop?>+"&year="+<?php echo $year?>;


	
//     doc.fromHTML($('#main-container2').html(), 15, 15, {
//         'width': 170,
//             'elementHandlers': specialElementHandlers
//     });
//     doc.save('sample-file.pdf');
});
<!--

//-->
</script>

