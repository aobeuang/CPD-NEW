<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Login Form View
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2016, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

?>

<script>

$(document).ready(function() {
    $("#login_string").keydown(function (e) {
    	var reg = /^[0-9]+$/i;
		if(reg.test(e.key))
		{
			if($(this).val().length >=13)
			{
				e.preventDefault();
			}
			return;
		}else{

			if (e.key=='Enter')
			{
				$('#searhbox_citizen_id button').click();
				e.preventDefault();
			}

			/*if(e.key ==  '.' || e.shiftKey || (  e.key !=  '0' && e.key !=  '1'  && e.key !=  '2'  && e.key !=  '3'
				 && e.key !=  '4'  && e.key !=  '5'  && e.key !=  '6'  && e.key !=  '7'
					 && e.key !=  '8'  && e.key !=  '9'   ) && e.keyCode!=8 ){
				e.preventDefault();
			}*/

			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
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



</script>



<script src="/assets/grocery_crud/themes/bootstrap/js/jquery-plugins/bootstrap-growl.min.js"></script>

<div class="login-bg-img">
	<div class="login-form-box">
		<div class="login-form-header"><img class="img-responsive" src="<?php $this->load->helper('properties_helper');
 	 print_r(getStringSystemProperties("logo", "/assets/default/images/logo.png"))?>"></div>
<?php

if( ! isset( $on_hold_message ) )
{
	if( isset( $login_error_mesg ) )
	{
		echo '
			<div class="login-error-box">
				<span>
					ชื่อบัญชีผู้ใช้หรือรหัสผ่านผิด กรุณากรอกข้อมูลอีกครั้ง
				</span>
			</div>
		';
	}
	if( $this->input->get('logout') )
	{

	?>

		<script>
			$.growl('คุณเพิ่งออกจากระบบ', {
				type: 'success',
				delay: 10000,
				animate: {
				    enter: 'animated bounceInDown',
				    exit: 'animated bounceOutUp'
				}
			});
		</script>

	<?php
	}
		 // echo $login_url;die();
		echo form_open( $login_url, ['class' => 'std-form'] );
	?> 
            <div class="body bg-gray">
                <div class="form-group username_form_group">
			    	<label class="control-label">ชื่อบัญชีผู้ใช้</label>
			    	<div class="">
			       	<input type="number" style="" name="login_string"  class="form-control" id="login_string" autocomplete="off" maxlength="255" />
			   		</div>
				</div>
                <div class="form-group passwd_form_group">
			      	<label class="control-label">รหัสผ่าน</label>
			        <div class="">
			          	<input style="" type="password" name="login_pass" id="login_pass" class="form_input password form-control" <?php
						if( config_item('max_chars_for_password') > 0 )
							echo 'maxlength="' . config_item('max_chars_for_password') . '"';
					?> autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" />
			      	</div>
				</div>
				<?php
					if( config_item('allow_remember_me') )
					{
				?>

						<div class="form-group allow_remember_me_group">
					      	<!-- <div class=""><input type="checkbox" id="remember_me" name="remember_me" value="yes" /> <label for="remember_me"><small>จดจำฉันไว้</small></label></div> -->
					      	<label><input type="checkbox" id="remember_me" name="remember_me" value="yes"><span><small>จดจำฉันไว้</small></span></label>
						</div>
				<?php
					}
				?>

            </div>
            <div class="footer text-center">                                                               
                <input class="btn btn-outline-pink b10" type="submit" name="submit" value="เข้าสู่ระบบ" />  
            </div>
        </form>
<?php

}
else
{
	// EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
	echo '
		<div style="border:1px solid red;">
			<p>
				Excessive Login Attempts
			</p>
			<p>
				You have exceeded the maximum number of failed login<br />
				attempts that this website will allow.
			<p>
			<p>
				Your access to login and account recovery has been blocked for ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes.
			</p>
		</div>
	';
}

?>
	</div>
</div>
       

<script type="text/javascript">
$(document).ready(function() {
	// $( ".std-form" ).submit(function() {
	//   alert('sadsad');
	// });

	var errorBox = $('.login-error-box');
	if(errorBox){
		$('#login_string').focus(function() {
		  	errorBox.fadeOut();
		});
	}
});
</script>
