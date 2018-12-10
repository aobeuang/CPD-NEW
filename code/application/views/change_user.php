<style type="text/css">

.registration-form .form-icon{
	text-align: center;
    background-color: #5891ff;
    /*border-radius: 50%;*/
    font-size: 40px;
    color: white;
    width: 100px;
    height: 100px;
    margin: auto;
    margin-bottom: 50px;
    line-height: 100px;
}

.registration-form .item{
	/*border-radius: 20px;*/
    margin-bottom: 25px;
    /*padding: 10px 20px;*/
}

.registration-form .create-account{
    /*border-radius: 30px;*/
    padding: 10px 20px;
    font-size: 18px;
    font-weight: bold;
    background-color: #5791ff;
    border: none;
    color: white;
    margin-top: 20px;
}

.registration-form .social-media{
    max-width: 600px;
    background-color: #fff;
    margin: auto;
    padding: 35px 0;
    text-align: center;
    border-bottom-left-radius: 30px;
    border-bottom-right-radius: 30px;
    color: #9fadca;
    border-top: 1px solid #dee9ff;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
}

.registration-form .social-icons{
    margin-top: 30px;
    margin-bottom: 16px;
}

.registration-form .social-icons a{
    font-size: 23px;
    margin: 0 3px;
    color: #5691ff;
    border: 1px solid;
    border-radius: 50%;
    width: 45px;
    display: inline-block;
    height: 45px;
    text-align: center;
    background-color: #fff;
    line-height: 45px;
}

.registration-form .social-icons a:hover{
    text-decoration: none;
    opacity: 0.6;
}
.form-right{
    text-align: right;
    margin-top: 8px;
}
.form-left{
    text-align: left;
    margin-top: 8px;
    font-weight: normal;
}

@media (max-width: 576px) {
    .registration-form form{
        padding: 50px 20px;
    }

    .registration-form .form-icon{
        width: 70px;
        height: 70px;
        font-size: 30px;
        line-height: 70px;
    }
}
</style>
    <div id="main-wrapper">
        <div class="container-fluid col-md-12 col-xs-12">
            <div class="row form-result registration-form">
                <div class="form-result-header" class="col-sm-offset-2 col-sm-8">
                            อัพเดทรหัสผ่านผู้ใช้งานระบบ     <span style="float: right;">Page Code : MNG006</span>           </div>
                <div class="row" style="padding: 25px;">
                    <form method="post" id="add_users" class="col-sm-offset-2 col-sm-8">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-3 form-right">
                                    <label class="control-label" for="name">ชื่อ - นามสกุล</label>
                                </div>
                                <div class="col-sm-9">
                                    <label class="control-label form-left" id="name">-</label>                
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 form-right">
                                	<label class="control-label" for="username">ชื่อผู้ใช้งาน</label>
                                </div>
                                <div class="col-sm-9">
                                    <label class="control-label form-left" id="username">-</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 form-right">
                                    <label class="control-label" for="password">รหัสผ่าน</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control item" id="password" minlength="4" placeholder="รหัสผ่าน">
                                    <p class="text-danger" style="margin-top: -10px;font-size: 11px;">**รหัสผ่านตั้งแต่ 4 ตัวขึ้นไป ต้องเป็น ตัวเลข หรือ ตัวอักษร หรือ สัญลักษณ์ หรือ ผสมกัน**</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 form-right">
                                     <label class="control-label" for="btn-submit"></label>
                                </div>
                                <div class="col-sm-9">
                                    <button type="button" class="btn btn-info" id="btn-submit">อัพเดทรหัสผ่าน</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <?php 
                    // echo print_r($province);

                ?>
            </div>
        </div>
    </div>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script src="/assets/default/js/notify.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
    	//getcallData
        
            $("#pageLoading").fadeIn();

    	$.ajax(
        {
            url:'<?php echo site_url('admin/getUsersID')?>',
            dataType: 'json',
            data:{
            	id: <?php echo end($this->uri->segments); ?>
            },
            success:function(result){

                console.log(result);
                
                if (result.data != null) {
                	$('#username').text(result.data.username);
                	$('#password').val(result.data.passwd);
                	$('#name').text(result.data.name);
                }else{
                	var url = "<?php echo site_url('/'); ?>";    
					$(location).attr('href',url);
                }
                $("#pageLoading").fadeOut();
            }
                
        });

            



        //set Autocomplate
        $('input').attr('autocomplete','off');

        $( "#btn-submit" ).click(function() {
            
            var passwd = $('#password').val();
            var citizen = $('#username').text();
             
            if(checkPasswords(passwd,'#password') == false){
                return false;
            }

            $.ajax({
                method: "POST",
                url: '<?php echo site_url('admin/changeUsersCall')?>',
                data: { 
                        citizen: citizen,
                        passwd: passwd
                },
                success: function(data) {
                    if(data.success == true){
                        // $("#btn-submit").notify(data.message);
                        // $("#btn-submit").notify(data.message, "success");
                        $("#btn-submit").notify(
                          data.message,{
                            position: 'bottom left' ,
                            className:'success'
                        });
                    } else {
                       $("#btn-submit").notify(
                          data.message,{
                            position: 'bottom left' ,
                            className:'error'
                        });
                    }
                }
            });


        });

    function checkPasswords(passwd,ele) {
        if (passwd.length < 4) {
            $(ele).focus();
            $(ele).notify(
              "โปรดระบุรหัสผ่านอย่างน้อย 4 ตัว", 
              { position:"left middle" }
            );
            return false;
        }
    }
        

    });    
</script>


