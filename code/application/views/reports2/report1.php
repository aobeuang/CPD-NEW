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
	<p>Page Code : RE100</p>
	<div class="">
		<div class="row" style="text-align:left">
		
		
			<h2 style="text-align:left"><span class="glyphicon glyphicon-th-list"></span> รายงานข้อมูลรายบุคคล</h2>
			
		</div>
		<pre id="data_respone"></pre>
        <div class="row" id="action-bar">
            <div class="report-action-bar ">

                <div class="col-md-5 col-xs-12" >
                    <div id="searchbox" name="searchbox" class="row form-inline searchbox">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="citizen_id">ค้นหาข้อมูลสมาชิกด้วยหมายเลขบัตรประชาชน</label>
                            <div class="input-group input-btn-right">
                                <input type="number" id="citizen_id" name="citizen_id"
                                       class="form-control mx-sm-3 search-input"
                                       style="width: 160px"
                                       placeholder="หมายเลขบัตรประชาชน" aria-label="Search" value="<?php if (isset($citizen_id)) echo $citizen_id?>">
                                <div class="input-group-btn">
                                    <button class="btn btn-w-input close-icon" type="reset" onclick="resetForm(this);" style="display:none;"><span class="glyphicon glyphicon-remove"></button>
                                    <button class="btn btn-w-input" id="save-and-go-back-button" onclick="searchCitizenID(this);"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-xs-12" >
                    <!-- ค้นหาด้วยชื่อ นามสกุล -->
                    <div id="searchbox-name" name="searchbox" class="row form-inline searchbox">
                        <div class="form-group bd-left" style="margin-bottom: 0;padding-left: 15px;">
                            <label for="coop_membername">ค้นหาข้อมูลสมาชิกด้วยชื่อ-นามสกุล</label>
                            <div class="input-group">
                                <input id="coop_membername" name="coop_membername"
                                       class="form-control"
                                       style="width: 145px"
                                       type="text" min="3"  placeholder="ชื่อ" aria-label="Search" value="<?php echo !empty($_GET['coop_membername'])? $_GET['coop_membername']:""?>">
                                <div class="input-group-btn">
                                    <button class="btn btn-w-input close-icon" type="reset" onclick="resetForm(this);" style="display:none;"><span class="glyphicon glyphicon-remove"></button>
                                </div>
                            </div>
                            <div class="input-group input-btn-right">
                                <input id="coop_membersurname" name="coop_membersurname"
                                       style="width: 145px"
                                       class="form-control" type="text" min="3"  placeholder="นามสกุล" aria-label="Search" value="<?php echo !empty($_GET['coop_membername'])? $_GET['coop_membername']:""?>">
                                <div class="input-group-btn">
                                    <button class="btn btn-w-input close-icon" type="reset" onclick="resetForm(this);" style="display:none;"><span class="glyphicon glyphicon-remove"></button>
                                    <button class="btn btn-w-input" id="save-and-go-back-button" onclick="searchName(this);"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

			<!-- ปิดฟอร์ม ค้นหาด้วยชื่อ นามสกุล -->
		</div>	


		<!-- new design -->
		<div id="result_view_table" class="display row report-result" style="margin-left: -15px; margin-right: -15px;">
<!--		<div id="result_view_table" class="row report-result bordertest" style="margin-left: -15px; margin-right: -15px;">-->
			<div class="container-fluid col-md-12 col-xs-12 " >
				<!-- <div class="container-fluid col-md-12 col-xs-12" style="padding-left:0px;" > -->
							<!-- <strong>จำนวนผลลัพธ์ทั้งหมด:</strong> <?php //echo $total_number?><br/> -->	
							<!-- <?php if ($total_number>0):?>								
								<?php	
								$displaying_page = 10;
								$range = 1;
								
									$total_page = ceil($total_number/$range);
									$start = $current_page*$range;
									$end = ($start+$range)>$total_number? $total_number:$start+$range;	
							
									$first_page = 0;
									$last_page = $first_page+$displaying_page;
									if ($current_page < ($displaying_page/2))
									{
										$first_page = 0;
									}
									if (($current_page+$displaying_page/2) > $total_page)
									{
										$first_page = $total_page-$displaying_page;											
										$last_page = $total_page;
									}									
									if ($total_page<($first_page+$displaying_page))
									{
										$last_page = $first_page+$displaying_page;
									}
									if ($first_page<0) $first_page = 0;
									if ($last_page>$total_page) $last_page = $total_page;
								?>
								<?php if($total_page>1):?>
								<ul class="pagination">
									<?php for($i=$first_page;$i<$last_page;$i++):?>
									<?php if ($current_page==$i):?>
										<li class="page-item  active"><a class="page-link" href="#"><?php echo $i+1?></a></li>
									<?php else:?>
										<li class="page-item"><a class="page-link" href="<?php echo site_url('report2/index1')?>?frompost=yes&citizen_id=<?php echo $citizen_id?>&page=<?php echo $i?>&range=<?php echo $range?>"><?php echo $i+1?></a></li>
									<?php endif?>
									<?php endfor;?>
								</ul>
								<?php endif?>
							
							<?php endif?>
							
						</div> -->
					
					
				<table id="example"  class="stripe" style="margin-top:0;">
					<thead>
						<tr>
							<th>ลำดับ</th>
                            <th>คำนำหน้า</th>
							<th>ชื่อ</th>
							<th>สกุล</th>
							<th>หมายเลขบัตรประชาชน</th>
							<th>สังกัดสหกรณ์</th>
							<th>จังหวัด</th>
							<th></th>
						</tr>
					</thead>
				</table>
				<table id="example2"  class="stripe" style="margin-top:0;">
					<thead>
						<tr>
							<th>ลำดับ</th>
							<th>คำนำหน้า</th>
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
        $("#coop_membersurname").keydown(function (e) {
            if($(this).val().length <= 0){
                $("#coop_membersurname").parent().find('.close-icon').css('display','none');
                $("#coop_membersurname").parent().find('#save-and-go-back-button').css('display','block');
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
                    $("#coop_membersurname").parent().find('.close-icon').css('display','block');
                    $("#coop_membersurname").parent().find('#save-and-go-back-button').css('display','none');
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
        var surname  = $("#coop_membersurname").val();
		$("#pageLoading").fadeIn();
		if(name.length == 0 && surname.length == 0){
			$("#pageLoading").fadeOut();

			// $('#error-box').html('กรุณากรอก ชื่อ หรือ นามสกุล').show();
			// setInterval(function(){
		    //     $('#error-box').fadeOut();
		    // }, 3000);

            $("#msg-modal-txt").html('กรุณากรอก ชื่อ หรือ นามสกุล');
            $("#message-modal").modal();
            return false;



            return false;
		}else if(name.length < 3 && surname.length < 3){
			$("#pageLoading").fadeOut();
			// $('#error-box').html('กรุณากรอก ชื่อ หรือ นามสกุล อย่างน้อย 3 ตัวอักษร').show();
			// setInterval(function(){
		    //     $('#error-box').fadeOut();
		    // }, 3000);

            $("#msg-modal-txt").html('กรุณากรอก ชื่อ หรือ นามสกุล อย่างน้อย 3 ตัวอักษร');
            $("#message-modal").modal();
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
		$("#pageLoading").fadeIn();
		var query=true;
		$.ajax({
			url:"<?php echo site_url('report2/getMemberByCitizenIDOrgID')?>",
		    type:"GET",
		    dataType: 'json',
		    data:{
		    	citizen_id:citizen_id,
		    	org_id:org_id,
		    	query:query,
		    	check:true,
		    },
	       	success:function(result){
	    	   //$('#data_respone').html(result.items.query);
	    	   // console.log(result.items);
	    	   $("#pageLoading").fadeOut();
	    	   	if(result.items != null){
	    	   		if(result.items == 'nopermission'){
				    	/*$('#error-box').html('ไม่มีสิทธิ์เข้าถึงข้อมูล').show();
						setInterval(function(){
					        $('#error-box').fadeOut();
					    }, 6000);*/
					    $("#msg-modal-txt").html('ไม่สามารถเข้าดูข้อมูลได้');
			    		$("#message-modal").modal();
	    	   		}else{
	    	   			var road = '';
	    	   			var lane = '';
	    	   			if(result.items[0].road != ''){
	    	   				road = result.items[0].road;
	    	   			}
	    	   			if(result.items[0].lane){
	    	   				lane = result.items[0].lane;
	    	   			}
			    		$('#mem_name').text(result.items[0].name + '  '+ result.items[0].surname);
						$('#mem_citizen_id').text(result.items[0].citizen_id);
						var address = result.items[0].hno+' '+lane+' '+road+' '+result.items[0].subd+' '+result.items[0].district +' '+ result.items[0].province_name;
						$('#mem_addr').text(address);
						var coop_list = '';
						for(var i = 0;i<result.items.length;i++){
					   		coop_list = coop_list+result.items[i].coop_name +'<br>';
					   	}
						$('#mem_coop_name').html(coop_list);
						$('#mem_province_name').text(result.items[0].in_province_name);
						$("#myModal").modal();
					}
	    	   	}else{
	    	   		/*$('#error-box').html(result).show();
					setInterval(function(){
				        $('#error-box').fadeOut();
				    }, 6000);*/
				    $("#msg-modal-txt").html('ไม่พบข้อมูลที่ค้นหา');
			    	$("#message-modal").modal();
	    	   	}
	    	    
		    },
		    error:function(){
		    	$("#pageLoading").fadeOut();
		    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
				setInterval(function(){
			        $('#error-box').fadeOut();
			    }, 5000);*/
			    $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้าหาไม่สำเร็จ');


			    $("#message-modal").modal();
		    }
		});
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
                error: function(jqXHR, textStatus, errorThrown) {
			    	$("#pageLoading").fadeOut();
			    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
					setInterval(function(){
				        $('#error-box').fadeOut();
				    }, 5000);*/
				    // $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');

                    if (jqXHR.responseText == 'notfound') {
                        $("#msg-modal-txt").html('ไม่พบข้อมูลหมายเลขบัตรประชาชนที่ต้องการค้นหา');
                    }
                    else {
                        $("#msg-modal-txt").html('พบข้อผิดพลาด : ' + jqXHR.responseText);
                    }
                    $('#example').css('display','none');
                    $('#example').DataTable().destroy();
			    	$("#message-modal").modal();
			    }  
		 	 }
		 	 // ,
		    // error:function(){
		    // 	$("#pageLoading").fadeOut();
		    // 	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
			// 	setInterval(function(){
			//         $('#error-box').fadeOut();
			//     }, 5000);*/
			//     $("#msg-modal-txt").html('มีบางอย่างผิดพลาด ค้นหาไม่สำเร็จ');
			//     $("#message-modal").modal();
		    // }
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
				console.log('getUserListByName initComplete');
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
		    'columnDefs': [
                {
                    "targets": 0, // your case first column
                    "className": "text-left",
                    "width": "5%"
                },
                {
                  "targets": 1, // your case first column
                  "className": "text-left",
                  "width": "5%"
             },
	    	{
	    	      "targets": 2, // your case first column
	    	      "className": "text-left",
	    	      "width": "20%"
	    	 },
	    	 {
	    	      "targets": 3, // your case first column
	    	      "className": "text-left",
	    	      "width": "20%"
	    	 },
	    	 {
	    	      "targets": 4, // your case first column
	    	      "className": "text-left",
	    	      "width": "35%"
	    	 },
	    	 {
	    	      "targets": 5, // your case first column
	    	      "className": "text-left",
	    	      "width": "15%"
	    	 },
	    	 {
	    	      "targets": 6, // your case first column
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
			    	coop_membername:$('#coop_membername').val(),
                    coop_membersurname:$('#coop_membersurname').val()
			    },
                error: function(jqXHR, textStatus, errorThrown) {
			    	$("#pageLoading").fadeOut();
			    	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
					setInterval(function(){
				        $('#error-box').fadeOut();
				    }, 5000);*/
			    	if (jqXHR.responseText == 'notfound') {
                        $("#msg-modal-txt").html('ไม่พบข้อมูลชื่อหรือนามสกุลที่ต้องการค้นหา');
                    }
			    	else {
                        $("#msg-modal-txt").html('พบข้อผิดพลาด : ' + jqXHR.responseText);
                    }

                    $('#example2').css('display','none');
                    $('#example2').DataTable().destroy();
			    	$("#message-modal").modal();
			    }
		 	},
		    // error:function(){
            // error: function(jqXHR, textStatus, errorThrown) {
		    // 	$("#pageLoading").fadeOut();
		    // 	/*$('#error-box').html('ไม่พบข้อมูลที่ค้นหา').show();
			// 	setInterval(function(){
			//         $('#error-box').fadeOut();
			//     }, 5000);*/
			//     // $("#msg-modal-txt").html('พบข้อผิดพลาด ค้นหาไม่สำเร็จ : ' + jqXHR.responseText);
            //
            //     if (jqXHR.responseText == 'notfound') {
            //         $("#msg-modal-txt").html('ไม่พบข้อมูลชื่อหรือนามสกุลที่ต้องการค้นหา');
            //     }
            //     else {
            //         $("#msg-modal-txt").html('พบข้อผิดพลาด : ' + jqXHR.responseText);
            //     }
            //
            //     $("#message-modal").modal();
		    // }
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