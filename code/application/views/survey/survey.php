<style>
 input[type=number]::-webkit-inner-spin-button,  
 input[type=number]::-webkit-outer-spin-button {  
     -webkit-appearance: none!important; 
     -moz-appearance: none!important; 
     appearance: none!important; 
     margin: 0!important;  
 }
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
 
 .display
{
	display:none;
}
</style>


<?php $this->load->helper('form');?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> -->
<div id="main-wrapper" >
	<!-- <p>Page Code : CPD001</p> -->
	<div class="">
		<div style="text-align:left;display: inline-block;width: 100%;margin-bottom: 10px;">
		
		
			<h2 style="text-align:left"><span class="glyphicon glyphicon-th-list"></span> ค้นหาแบบสำรวจ</h2>
			
			<a href="<?php echo site_url('survey/add_survey')?>" class="floatR"><i class="glyphicon glyphicon-plus"></i>  เพิ่มแบบสำรวจโดยกรอกข้อมูลสมาชิกเอง</a>
		</div>
		<pre id="data_respone"></pre>
		<div class="report-action-bar report-search">
			<div class="col-md-6 col-xs-12" >
				<div id="searchbox" name="searchbox" class="row form-inline searchbox">
					<div class="form-group" style="margin-bottom: 0;">
					    <label for="citizen_id">ค้นหาแบบสำรวจด้วยหมายเลขบัตรประชาชน</label>
					    <div class="input-group input-btn-right">
						  	<input type="number" id="citizen_id" name="citizen_id" class="form-control mx-sm-3 search-input" placeholder="หมายเลขบัตรประชาชน" aria-label="Search" value="<?php if (isset($citizen_id)) echo $citizen_id?>">
							<div class="input-group-btn">
								<button class="btn btn-w-input close-icon" type="reset" onclick="resetForm(this);" style="display:none;"><span class="glyphicon glyphicon-remove"></button>
								<button class="btn btn-w-input" id="save-and-go-back-button" onclick="searchCitizenID(this);"><span class="glyphicon glyphicon-search"></span></button>
							</div>
						</div>
				  	</div>	
				</div>
			</div>
			<div class="col-md-6 col-xs-12" >
				<!-- ค้นหาด้วยชื่อ นามสกุล -->
				<div id="searchbox-name" name="searchbox" class="row form-inline searchbox">
					<div class="form-group bd-left" style="margin-bottom: 0;padding-left: 15px;">
					    <label for="coop_membername">ค้นหาแบบสำรวจด้วยชื่อ-นามสกุล</label>
			    		<div class="input-group input-btn-right">
					  		<input id="coop_membername" name="coop_membername" class="form-control" type="text" min="3"  placeholder="ชื่อ-นามสกุล" aria-label="Search" value="<?php echo !empty($_GET['coop_membername'])? $_GET['coop_membername']:""?>">
					  		<div class="input-group-btn">
					  			<button class="btn btn-w-input close-icon" type="reset" onclick="resetForm(this);" style="display:none;"><span class="glyphicon glyphicon-remove"></button>
					    		<button class="btn btn-w-input" id="save-and-go-back-button" onclick="searchName(this);"><span class="glyphicon glyphicon-search"></span></button>
					  		</div>
						</div>
				  	</div>	
				</div>
			</div>
			<!-- ปิดฟอร์ม ค้นหาด้วยชื่อ นามสกุล -->
		</div>	


		<!-- new design -->
		<div id="result_view_table" class="display row report-result">
			<div class="container-fluid col-md-12 col-xs-12 " >
				<table id="example"  class="stripe" style="margin-top:0;">
					<thead>
						<tr>
							<th>ลำดับ</th>
							<th>ชื่อ</th>
							<th>สกุล</th>
							<th>หน่วยงาน</th>
							<th>เขตพื้นที่</th>
							<th></th>
						</tr>
					</thead>
				</table>
				<table id="example2"  class="stripe" style="margin-top:0;">
					<thead>
						<tr>
							<th>ลำดับ</th>
							<th>ชื่อ</th>
							<th>สกุล</th>
							<th>สังกัดสหกรณ์</th>
							<th>จังหวัด</th>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>		
</div>
<style>
#example_filter{
	display: none;
}
table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none!important;
}
</style>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script language="javascript">
	function checkID(id)
	{
		var sum;
	    if(id.length != 13) return false;
	    for(i=0, sum=0; i < 12; i++)
	    sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
	    return false; return true;
	}
	function checkPinID(){
		var c;
		var test = $('#citizen_id').val();
	 	if(!checkID(test))
	 	{
		 		$('.modal-dialog').css('width','350px');
			var html = '<div class="" style="font-size:20px;"  >';
			html += '<div class="row">';
			html += '<div class="container-fluid col-md-12 col-xs-12" style="text-align:center;">';
			html += '<lable for id="coop_member_id" style="font-color:red;">เลขบัตรประชาชนไม่ถูกต้อง</lable>';
			html += '</div>	';			
			html += '</div>';
			html += '</div>';
			$('.modal-body').html(html);
			$('#myModal').modal({
				  keyboard: true
			})
			
	 		return false;
	 	}
		else
		{
			return true;
		}
	}
	$(document).ready(function() {
		$("#coop_membername").keydown(function (e) {
			if($(this).val().length <= 0){
				$("#coop_membername").parent().find('.close-icon').css('display','none');
				$("#coop_membername").parent().find('#save-and-go-back-button').css('display','block');
			}
			if (event.keyCode == 13) {
		      	searchName(this);
		    }
			var reg = /^[a-zA-Zก-๗]+$/i;
			var reg_num_thai = /^[๑-๗]+$/i;
			if (e.key==" ")
				return true;
			
			if(reg.test(e.key) && !reg_num_thai.test(e.key) && e.key !='฿')
			{
				if($(this).val().length > 0){
					$("#coop_membername").parent().find('.close-icon').css('display','block');
					$("#coop_membername").parent().find('#save-and-go-back-button').css('display','none');
				}
				return;
			}else{
				e.preventDefault();
			}
			
		});
		$("#citizen_id").keydown(function (e) {
			if($(this).val().length <= 0){
				$('#citizen_id').parent().find('.close-icon').css('display','none');
				$('#citizen_id').parent().find('#save-and-go-back-button').css('display','block');
			}
			if (event.keyCode == 13) {
		      	searchCitizenID(this);
		    }
			var reg = /^[0-9]+$/i;
			if(reg.test(e.key))
			{
				if($(this).val().length >=13)
				{
					e.preventDefault();
				}
				if($(this).val().length > 0){
					$('#citizen_id').parent().find('.close-icon').css('display','block');
					$('#citizen_id').parent().find('#save-and-go-back-button').css('display','none');
				}
				return;
			}else{
				/*if(e.key ==  '.' || e.shiftKey || (  e.key !=  '0' && e.key !=  '1'  && e.key !=  '2'  && e.key !=  '3' 
					 && e.key !=  '4'  && e.key !=  '5'  && e.key !=  '6'  && e.key !=  '7' 
						 && e.key !=  '8'  && e.key !=  '9'   ) && e.keyCode!=8 ){
					e.preventDefault();
				}*/
				
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 190]) !== -1 ||
						// Allow: Ctrl/cmd+A
					(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+C
					(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+V
					(e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+X
					(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
					// let it happen, don't do anything
					return;
				}
				e.preventDefault();
			}
		});
		
		
	});
	function searchName(eleform){
		var name  = $("#coop_membername").val();
		$("#pageLoading").fadeIn();
		if(name.length == 0){
			$("#pageLoading").fadeOut();
			$('#error-box').html('กรุณากรอก ชื่อ หรือ นามสกุล').show();
			setInterval(function(){
		        $('#error-box').fadeOut();
		    }, 3000);
			return false;	
		}else if(name.length < 3){
			$("#pageLoading").fadeOut();
			$('#error-box').html('กรุณากรอก ชื่อ หรือ นามสกุล อย่างน้อย 3 ตัวอักษร').show();
			setInterval(function(){
		        $('#error-box').fadeOut();
		    }, 3000);
			return false;	
		}else{
			getUserListByName();
		}
	}
	function searchCitizenID(eleform){
		$("#pageLoading").fadeIn();
		var c;
		var test = $('#citizen_id').val();
		var search_name = $('#searhbox').val();			
		if (test=='')
		{
			$("#pageLoading").fadeOut();
			/*$('#error-box').html('กรุณากรอกเลขบัตรประชาชน').show();
			setInterval(function(){
		        $('#error-box').fadeOut();
		    }, 3000);*/
		    $("#msg-modal-txt").html('กรุณากรอกเลขบัตรประชาชน');
			$("#message-modal").modal();
			return false;													
		}
		
		//console.log(test);
	 	if(!checkID(test)){
	 		$("#pageLoading").fadeOut();
			/*$('#error-box').html('เลขบัตรประชาชนไม่ถูกต้อง').show();
			setInterval(function(){
		        $('#error-box').fadeOut();
		    }, 3000);*/
		    $("#msg-modal-txt").html('เลขบัตรประชาชนไม่ถูกต้อง');
			$("#message-modal").modal();
	 		return false;
	 	}
		else
		{
			//eleform.form.submit();
			getUserListByID($('#citizen_id').val());
		}
	}
	function onloadData()
	{
		console.log(obj);
		$('#example').DataTable().destroy();
		$.fn.dataTable.ext.errMode = 'throw';
		
		var t = $('#example').DataTable({
			"autoWidth": false,
			"columns": [
				{ "width": "auto" },
				{ "width": "auto" },
				{ "width": "auto" },
				{ "width": "auto" },
				{ "width": "auto" },
				{ "width": "auto" },
				{ "width": "auto" }
			],
			"language": {
				"emptyTable":     "ไม่พบข้อมูลที่ค้นหา",
				"info":           "จำนวน _START_ ถึง _END_ ของจำนวนทั้งหมด    _TOTAL_ รายการ",
				"infoEmpty":      "แสดงจำนวน  0 ถึง  0 ของจำนวนทั้งหมด  0 รายการ",
				"lengthMenu":     "แสดงจำนวน  _MENU_ ",
				"search":         "ค้นหา : ",
				"loadingRecords": "",
				"paginate": {
				"next":       ">",
				"previous":   "<"
				}
			},
			"ordering": false,
		});
		for(var i=0;i<obj.length;i++)
		{
			var citizen_id = obj[i]['citizen_id'];
			// console.log(citizen_id);
			t.row.add(
					[
						citizen_id,
						obj[i]['citizen_firstname'],
						obj[i]['citizen_lastname'],
						'<a class="btn btn-primary" href="'+url+'?citizen_id='+citizen_id+'" role="button"><span class="glyphicon glyphicon-eye-open"></span> ดู</a>'
					]
			).draw( false );
			//console.log(obj[i]);
		}
		
	}
	
	function getUserDetail(citizen_id,org_id){
		window.location ="/index.php/survey/add_survey?citizen_id="+citizen_id;
	}

	function getUserListByID(citizen_id)
	{
		$("#pageLoading").fadeIn();
		$('#result_view_table').removeClass('display');
		$('#example2_wrapper').css('display','none');
		$('#example2').css('display','none');
		$('#example_wrapper').css('display','block');
		$('#example').css('display','table');
		$('#example').DataTable().destroy();
		$.fn.dataTable.ext.errMode = 'throw';
		$("#pageLoading").fadeIn();
	    var table =$('#example').DataTable({
	        pageResize: true,
	    	"destroy": true,
			"bServerSide": false,
		    initComplete : function() {
				$('#pageLoading').fadeOut();
		    },
		    "autoWidth": false,
		    "columns": [
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" }
		    ],
		   	"ordering": false,
		   	"language": {
	        "emptyTable":     "ไม่พบข้อมูลที่ค้นหา",
	        "info":           "จำนวน _START_ ถึง _END_ ของจำนวนทั้งหมด    _TOTAL_ รายการ",
	        "infoEmpty":      "แสดงจำนวน  0 ถึง  0 ของจำนวนทั้งหมด  0 รายการ",
	        "lengthMenu":     "แสดงจำนวน  _MENU_ ",
	        "search":         "ค้นหา : ",
	        "paginate": {
            	"next":       ">",
	            "previous":   "<"
	        	}
		    },
		    "searching": false,
		    "paging": false, 
		    "info": false,
		   	"ajax" : {
			    url:"<?php echo site_url('report2/getMemberByCitizenID')?>",
			    type:"GET",
			    data:{
			    	citizen_id:citizen_id
			    },
			    error:function(){
			    	$("#pageLoading").fadeOut();
			    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
					setInterval(function(){
				        $('#error-box').fadeOut();
				    }, 5000);*/
				    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
			    	$("#message-modal").modal();
			    }  
		 	},
		    error:function(){
		    	$("#pageLoading").fadeOut();
		    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
				setInterval(function(){
			        $('#error-box').fadeOut();
			    }, 5000);*/
			    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
			    $("#message-modal").modal();
		    }  
		});
		table.on( 'preDraw', function () {
			 if(typeof table != 'undefined')
				table.settings()[0].jqXHR.abort();
		});
		 
		$('#myInput').on( 'keyup', function () {
			table.search( this.value ).draw();
		});
			
	}
	function getUserListByName()
	{
		$("#pageLoading").fadeIn();
		$('#result_view_table').removeClass('display');
		var query=true;
		$('#example_wrapper').css('display','none');
		$('#example').css('display','none');
		$('#example2_wrapper').css('display','block');
		$('#example2').css('display','table');
		$('#example2').DataTable().destroy();
		$.fn.dataTable.ext.errMode = 'throw';
		$("#pageLoading").fadeIn();
	    var table =$('#example2').DataTable({
	        pageResize: true,
	    	"destroy": true,
			"bServerSide": true,
			"drawCallback": function( settings ) {
		        $("#pageLoading").fadeOut();
		    },
		    initComplete : function() {
				$('#pageLoading').fadeOut();
		    },
		    "autoWidth": false,
		    "columns": [
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" },
		        { "width": "auto" }
		    ],
		    'columnDefs': [
	    	{
	    	      "targets": 0, // your case first column
	    	      "className": "text-left",
	    	      "width": "5%"
	    	 },
	    	{
	    	      "targets": 1, // your case first column
	    	      "className": "text-left",
	    	      "width": "20%"
	    	 },
	    	 {
	    	      "targets": 2, // your case first column
	    	      "className": "text-left",
	    	      "width": "20%"
	    	 },
	    	 {
	    	      "targets": 3, // your case first column
	    	      "className": "text-left",
	    	      "width": "35%"
	    	 },
	    	 {
	    	      "targets": 4, // your case first column
	    	      "className": "text-left",
	    	      "width": "15%"
	    	 },
	    	 {
	    	      "targets": 5, // your case first column
	    	      "className": "text-right",
	    	      "width": "20%"
	    	 }
    	 ],
		   	"ordering": false,
		   	"language": {
	        "emptyTable":     "ไม่พบข้อมูลที่ค้นหา",
	        "info":           "จำนวน _START_ ถึง _END_ ของจำนวนทั้งหมด    _TOTAL_ รายการ",
	        "infoEmpty":      "แสดงจำนวน  0 ถึง  0 ของจำนวนทั้งหมด  0 รายการ",
	        "infoFiltered":   " ",
	        "lengthMenu":     "แสดงจำนวน  _MENU_ ",
	        "search":         "ค้นหา : ",
	        "paginate": {
            	"next":       ">",
	            "previous":   "<"
	        	}
		    },
		    "searching": false,
		    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
		   	"ajax" : {
			    url:"<?php echo site_url('report2/getUserListByName')?>",
			    type:"GET",
			    data:{
			    	coop_membername:$('#coop_membername').val()
			    },
			    error:function(){
			    	$("#pageLoading").fadeOut();
			    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
					setInterval(function(){
				        $('#error-box').fadeOut();
				    }, 5000);*/
				    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
			    	$("#message-modal").modal();
			    }  
		 	},
		    error:function(){
		    	$("#pageLoading").fadeOut();
		    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
				setInterval(function(){
			        $('#error-box').fadeOut();
			    }, 5000);*/
			    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
			    $("#message-modal").modal();
		    }  
		});
		table.on( 'preDraw', function () {
			$("#pageLoading").fadeIn();
			if(typeof table != 'undefined')
				table.settings()[0].jqXHR.abort();
		});
		 
		$('#myInput').on( 'keyup', function () {
			table.search( this.value ).draw();
		});
			
	}
	function resetForm(ele){
		$(ele).hide();
		$(ele).parent().find('#save-and-go-back-button').css('display','block');
		$(ele).parent().parent().find('input').val('');
	}
</script>

<!-- <?php if(!empty($search_name)):?>
<script>
	var url = '<?php echo site_url('report2/index1')?>';
	var obj = JSON.parse('<?php print_r(json_encode($surveys));?>');
	console.log(obj);
	onloadData();
</script>
<?php endif;?> -->
			
			
			
<div class="modal fade cpd-modal-info" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <div class="modal-header">
	    	<span class="modal-title" id="ModalTitle" style="display: inline-block;">รายงานข้อมูลรายบุคคล</span>
	      	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="line-height: 0.6;font-size: 38px;">
	          <span aria-hidden="true">×</span>
	        </button>
	    </div>
	    <div class="modal-body">
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>ชื่อสมาชิก:</strong></div>
	    		<div class="col-sm-9" id="mem_name"></div>
	    	</div>
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>หมายเลขบัตรประชาชน:</strong></div>
	    		<div class="col-sm-9" id="mem_citizen_id"></div>
	    	</div>
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>ที่อยู่:</strong></div>
	    		<div class="col-sm-9" id="mem_addr"></div>
	    	</div>
	    	<div class="row b10">
	    		<div class="col-sm-3 text-right"><strong>สังกัดสหกรณ์:</strong></div>
	    		<div class="col-sm-9" id="mem_coop_name"></div>
	    	</div>
	    	<div class="row b10">
		    	<div class="col-sm-3 text-right"><strong>จังหวัด:</strong></div>
		    	<div class="col-sm-9" id="mem_province_name"></div>
		    </div>
	    </div>
	  </div>
	</div>
</div>