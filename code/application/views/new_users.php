<style type="text/css">
	body{
    background-color: #dee9ff;
}

.registration-form{
	/*padding: 50px 0;*/
}

.registration-form form{
    background-color: #fff;
    max-width: 900px;
    margin: auto;
    padding: 50px 70px;
    /*border-top-left-radius: 30px;*/
    /*border-top-right-radius: 30px;*/
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
}

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
    <div class="registration-form">
    	<div class="form-result-header" style="background-color: #c1c1c1;max-width: 900px;margin: auto;">
                    เพิ่มผู้ใช้งานระบบ                </div>
        <form method="post" id="add_users">
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="username">ชื่อผู้ใช้งาน</label>
            	<div class="col-sm-9">
	                <input type="text" class="form-control item" id="username" maxlength="13" placeholder="ชื่อผู้ใช้งาน" autocomplete="false">                    
	                <p class="text-danger" style="margin-top: -10px;font-size: 11px;">**โปรดระบุเป็นหมายเลขบัตรประชาชน**</p>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="password">รหัสผ่าน</label>
            	<div class="col-sm-9">
                <input type="password" class="form-control item" id="password" minlength="4" placeholder="รหัสผ่าน">
                <p class="text-danger" style="margin-top: -10px;font-size: 11px;">**รหัสผ่านตั้งแต่ 4 ตัวขึ้นไป ต้องเป็น ตัวเลข หรือ ตัวอักษร หรือ สัญลักษณ์ หรือ ผสมกัน**</p>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="name">ชื่อ - นามสกุล</label>
            	<div class="col-sm-9">
	                <input type="text" class="form-control item" id="name" placeholder="ชื่อ - นามสกุล" autocomplete="false">
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="email">อีเมล</label>
            	<div class="col-sm-9">
                <input type="text" class="form-control item" id="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="auth_level">บทบาท</label>
            	<div class="col-sm-9">
            		<select id="auth_level" name="auth_level" class="form-control item" data-placeholder="เลือก บทบาท">
                        <option value="" disabled selected hidden>เลือกบทบาท</option>
                        <option value="5">ผู้ใช้งานส่วนภูมิภาคระดับจัดการ</option>
                        <option value="6">ผู้ใช้งานส่วนภูมิภาคระดับบริหาร</option>
                        <option value="1">ผู้ใช้งานส่วนกลางระดับจัดการ</option>
                        <option value="2">ผู้ใช้งานส่วนกลางระดับบริหาร</option>                        
                        <option value="8">ผู้ดูแลระบบระดับจัดการ</option>
                        <option value="9">ผู้ดูแลระบบระดับบริหาร</option>      
                    </select>
                </div>
            </div>            
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="agency">สังกัดหน่วยงาน</label>
            	<div class="col-sm-9">
            		<select id="agency" name="agency" class="form-control item" data-placeholder="เลือกสังกัดหน่วยงาน">
                        <option value="" disabled selected hidden>เลือกสังกัดหน่วยงาน</option>
                        <?php
                            foreach ($agency as $key => $value) {
                        ?>
                            <option value="<?= $key?>"><?= $value?></option>
                        <?php 
                            }
                        ?> 
                    </select>
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="province">จังหวัด</label>
            	<div class="col-sm-9">
            		<select id="province" name="province" class="form-control item" data-placeholder="เลือก จังหวัด">
                        <option value="" disabled selected hidden>เลือกจังหวัด</option>
                    <?php
                        foreach ($province as $key => $value) {
                    ?>
                        <option value="<?= $key?>"><?= $value?></option>
                    <?php 
                        }
                    ?>      
                    </select>
                    <input type="hidden" name="province_name" id="province_name" value="">
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="org_id">เขตพื้นที่</label>
            	<div class="col-sm-9">
            		<select id="org_id" name="org_id" class="form-control item" data-placeholder="เลือก เขตพื้นที่"><option value="" disabled selected hidden></option></select>
                    <input type="hidden" name="org_name" id="org_name" value="">
                </div>
            </div>
            <div class="form-group">
            	<label class="control-label col-sm-3 form-right" for="banned">อนุญาตให้ใช้</label>
            	<div class="col-sm-9">
            		<select id="banned" name="banned" class="form-control item" data-placeholder="เลือก อนุญาตให้ใช้"><option value="2">ใช้งานได้</option><option value="1">ไม่ให้ใช้</option></select>
                </div>
            </div>
            
            <div class="form-group text-center">
            	<button type="button" class="btn btn-info" id="btn-submit">เพิ่มผู้ใช้งานระบบ</button>
            	<button type="reset" class="btn btn-danger" id="btn-reset">คืนค่า</button>
                <button class="btn btn-default cancel-button" type="button" onclick="window.location = '/index.php/admin/users_management'"><i class="fa fa-arrow-left"></i>&nbsp;กลับ </button>
            </div>

        </form>

        <?php 
            // echo print_r($province);

        ?>
    </div>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script src="/assets/default/js/notify.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        //set Autocomplate
        $('input').attr('autocomplete','off');
        $('#org_id').attr('disabled',true);

        $( "#btn-reset" ).click(function() {
          $('#org_id').html('');
            $('#org_id').attr('disabled',true);

        });
        
        $('#province').change(function() {
        $('#org_id').html('');
            $.ajax(
            {
                url:'<?php echo site_url('admin/getListOrg')?>',
                dataType: 'json',
                data:{province:$("#province").val()},
                success:function(result){

                    console.log(result);

                    var html ='';   
                    for(var i = 0;i<result.items.length;i++)
                        {

                            html +='<option selected value="'+result.items[i].org_org_id+'">'+result.items[i].org_name+'</option>';
                            html2 = result.items[i].org_name;
                            
                        
                    }
                    $('#org_id').html(html);
                    // $('#org_name').html(html2);
                    $('#province_name').val($("#province option:selected").text());
                    $('#org_name').val($("#org_id option:selected").text());
                    $('#org_id').attr('disabled',false);

                    }
                    
            });
        });

        $( "#btn-submit" ).click(function() {

            var citizen = $('#username').val();
            var passwd = $('#password').val();
            var email = $('#email').val();
            var name = $('#name').val();
            var auth = $('#auth_level').val();
            var agency = $('#agency').val();
            var province = $('#province').val();
            var province_name = $('#province_name').val();
            var org_id = $('#org_id').val();
            var org_name = $('#org_name').val();
            var banned = $('#banned').val();

            
            if(checkCitizen(citizen,'#username') == false){
                return false;
            }else if(checkPasswords(passwd,'#password') == false){
                return false;
            }else if(checkName(name,'#name') == false){
                return false;
            }else if(checkEmail(email,'#email')== false){
                return false;
            }else if(checkAuth(auth,'#auth_level') == false){
                return false;
            }else if(checkAgency(agency,'#agency') == false){
                return false;
            }else if(checkProvince(province,'#province')== false){
                return false;
            }

            $.ajax({
                method: "POST",
                url: '<?php echo site_url('admin/addUsersCall')?>',
                data: { citizen: citizen,
                        passwd: passwd,
                        name: name,
                        email: email,
                        auth_level: auth,
                        agency: agency,
                        province: province,
                        province_name: province_name,
                        org_id: org_id,
                        org_name: org_name,
                        banned: banned
                },
                success: function(data) {
                    if(data.success == true){
                        // $("#btn-submit").notify(data.message);
                        // $("#btn-submit").notify(data.message, "success");
                        $("#btn-submit").notify(
                          data.message,{
                            position: 'left middle' ,
                            className:'success'
                        });
                    } else {
                       $("#btn-submit").notify(
                          data.message,{
                            position: 'left middle' ,
                            className:'error'
                        });
                    }
                }
            });


        });

    function checkProvince(name,ele) {
        if($.trim(name) == '') {
            $(ele).focus();
            $(ele).notify(
              "โปรดเลือกจังหวัด", 
              { position:"left middle" }
            );
            
            return false;
        }
    }

    function checkAuth(name,ele) {
        if($.trim(name) == '') {
            $(ele).focus();
            $(ele).notify(
              "โปรดเลือกบทบาทผู้ใช้งาน", 
              { position:"left middle" }
            );
            return false;
        }
    }

    function checkAgency(name,ele) {
        if($.trim(name) == '') {
            $(ele).focus();
            $(ele).notify(
              "โปรดเลือกสังกัดหน่วยงาน", 
              { position:"left middle" }
            );
            return false;
        }
    }

    function checkName(name,ele) {
        if($.trim(name) == '') {
            $(ele).focus();
            $(ele).notify(
              "โปรดระบุชื่อ - นามสกุล", 
              { position:"left middle" }
            );
            return false;
        }
    }

    function checkEmail(email,ele) {
        

        if (!validateEmail(email)) {
            $(ele).focus();
            $(ele).notify(
              "โปรดระบุอีเมลให้ถูกต้อง", 
              { position:"left middle" }
            );
            return false;
        }

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            if (email != '-') {
                return re.test(email);
            }else{
                return true;
            }
            
        }
    }
    

    function checkPasswords(passwd,ele) {
        if (passwd.length < 4) {
            $(ele).focus();
            $(ele).notify(
              "ระบุรหัสผ่านไม่ถูกต้อง", 
              { position:"left middle" }
            );
            return false;
        }
    }

    function checkCitizen(citizen,ele) {
        if($.trim(citizen) == '') {
            $(ele).focus();
            $(ele).notify(
              "โปรดระบุหมายเลขบัตรประชาชน", 
              { position:"left middle" }
            );
            return false;
        }


        if(!$.isNumeric(citizen)) {
            $(ele).focus();
            $(ele).notify(
              "โปรดระบุเฉพาะตัวเลขเท่านั้น", 
              { position:"left middle" }
            );
            return false;
        }


        if (citizen.length != 13) {
            $(ele).focus();
            $(ele).notify(
              "โปรดระบุหมายเลขบัตรประชาชน 13 หลัก", 
              { position:"left middle" }
            );
            return false;
        }
    }

        

    });    
</script>


