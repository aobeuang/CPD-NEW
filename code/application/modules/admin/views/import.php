<div class="container gc-container">
        <div class="success-message hidden"></div>

 		<div class="row">
        	<div class="table-section">
                <div class="table-label">
                    <div class="floatL l5">
                    
                    การนำเข้าข้อมูล
                    
                    </div>                  
                    <div class="floatR r5 minimize-maximize-container minimize-maximize">
                        <i class="fa fa-caret-up"></i>
                    </div>
                    <div class="floatR r5 gc-full-width">
                        <i class="fa fa-expand"></i>                        
                    </div>                      
                    <div class="clear"></div>
                </div>
                
                <div class="table-container">
                
                <table class="table table-bordered grocery-crud-table">
                <td>
				<br/>
                <br/>
						<form accept-charset="utf-8" class="form-horizontal" enctype="multipart/form-data" id="crudForm1" method="post" action="">
								<div class="form-group message_form_group">
                                    <label class="col-sm-3 control-label">
                                        นำเข้าข้อมูลสมาชิก
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="255" value="" name="message" class="form-control" id="field-message">                                    </div>
                                </div>                
                
	                			<div class="form-group">
	                                <div style="display:none" class="report-div error bg-danger" id="report-error"></div>
	                                <div style="display:none" class="report-div success bg-success" id="report-success"></div>
	                            </div>
	                            
								<div class="form-group">
	                                <div class="col-sm-offset-3 col-sm-7">
	                                    <button id="form-button-save" type="submit" class="btn btn-default btn-success b10">
	                                        <i class="fa fa-check"></i>
	                                        นำเข้าข้อมูล</button>
	                                        <button id="cancel-button" type="button" class="btn btn-default cancel-button b10">
	                                        <i class="fa fa-warning"></i>ยกเลิก</button>
	                                </div>
                            	</div>	                            
                       </form>
                       <form accept-charset="utf-8" class="form-horizontal" enctype="multipart/form-data" id="crudForm2" method="post" action="">
						  	
								<div class="form-group message_form_group">
                                    <label class="col-sm-3 control-label">
                                        นำเข้าข้อมูลที่ดิน
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="255" value="" name="message" class="form-control" id="field-message">                                    </div>
                                </div>                

                                <div class="form-group">
	                                <div style="display:none" class="report-div error bg-danger" id="report-error"></div>
	                                <div style="display:none" class="report-div success bg-success" id="report-success"></div>
	                            </div>
                                
                				
								<div class="form-group">
	                                <div class="col-sm-offset-3 col-sm-7">
	                                    <button id="form-button-save" type="submit" class="btn btn-default btn-success b10">
	                                        <i class="fa fa-check"></i>
	                                        นำเข้าข้อมูล</button>
	                                        <button id="cancel-button" type="button" class="btn btn-default cancel-button b10">
	                                        <i class="fa fa-warning"></i>ยกเลิก</button>
	                                </div>
                            	</div>	                            	
                       </form>     	
                            	
                <br/>
                <br/>
                
                </td>
                </table>
                </div>
            </div>
        </div>
</div>    