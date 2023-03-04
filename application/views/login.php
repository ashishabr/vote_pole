<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_admin.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="login-page">
	  <div class="form">
	    <form class="register-form">
	      <input type="text" placeholder="name" name="user_name" id="user_name"/>
	      <input type="password" placeholder="password" name="user_pass" id="user_pass"/>
	      <input type="text" placeholder="email address" name="user_email" id="user_email"/>
	      <button id="reg_btn">create</button>
	      <p class="message msg success_msg" style="color: green;display: none;">Registered Successfully</p>
	      <p class="message msg email_err_msg" style="color: red;display: none;">Please Enter Valid Email Address</p>
	      <p class="message msg email_err_msg_1" style="color: red;display: none;">User with this Email Address already exists</p>
	      <p class="message">Already registered? <a href="#">Sign In</a></p>
	    </form>
	    <form class="login-form">
	      <input type="text" placeholder="user email" name="l_user_email" id="l_user_email"/>
	      <input type="password" placeholder="password" name="l_user_pass" id="l_user_pass"/>
	      <button id="login_btn">login</button>
	      <p class="message msg l_success_msg" style="color: green;display: none;">Login Successfully</p>
	      <p class="message msg l_email_err_msg" style="color: red;display: none;">Please Enter Valid Email Address</p>
	      <p class="message msg l_email_err_msg_1" style="color: red;display: none;">User with this Email Address doesn't exist</p>
	      <p class="message">Not registered? <a href="#">Create an account</a></p>
	    </form>
	  </div>
	</div>
	<!-- <div class="container">
		<h3>User Login</h3>
		<form action="<?=base_url('index.php/login'); ?>" method="post">
		<p style="color: #ff0000" id="error_message"></p>
		<div class="form-group">
			<label for="user_email">Email</label>
			<input class="form-control" type="text" required="" name="user_email" id="user_email"/>
		</div>
		<div class="form-group">
			<label for="user_pass">Password</label>
			<input class="form-control" type="password" required="" name="user_pass" id="user_pass"/>
		</div>
		
		<input class="btn" name="submit" type="submit" value="submit"/>
		
		</form>
		<p style="margin-top: 10px;">Not Registered Yet? <a href="<?= base_url('index.php/register'); ?>">Sign in</a></p>
	</div> -->
	
	<script>
	$('#error_message').hide();
	<?php if($this->session->userdata('error') != ''){ ?>
		$('#error_message').show();
		$('#error_message').html('<?= $this->session->userdata("error"); ?>');
	<?php } ?>
	$(document).on("click","#reg_btn",function(e){
		e.preventDefault();
		$(".msg").hide();
		let user_name = $("#user_name").val();
		let user_pass = $("#user_pass").val();
		let user_email = $("#user_email").val();
		let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/

  		if (!user_email.match(pattern)) {
  			$(".email_err_msg").show();
  			return false;
  		}
		$.ajax({
		    url : "<?=base_url('register/add_user_data'); ?>",
		    type: "POST",
		    data : {'user_name':user_name,
					'user_pass':user_pass,
					'user_email':user_email},
		    success: function(data, textStatus, jqXHR)
		    {
		    	if(data){
		    		$(".success_msg").show();
		    	}else{
		    		$(".email_err_msg_1").show();
		    	}
		    	
		        //data - response from server
		    },
		    error: function (jqXHR, textStatus, errorThrown)
		    {
		 
		    }
		});
	})
	$(document).on("click","#login_btn",function(e){
		e.preventDefault();
		$(".msg").hide();
		let user_pass = $("#l_user_pass").val();
		let user_email = $("#l_user_email").val();
		let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/

  		if (!user_email.match(pattern)) {
  			$(".l_email_err_msg").show();
  			return false;
  		}
		$.ajax({
		    url : "<?= base_url('login/userpass_validation'); ?>",
		    type: "POST",
		    data : {'user_pass':user_pass,
					'user_email':user_email},
		    success: function(data, textStatus, jqXHR)
		    {
		    	if(data){
		    		window.location.href = "<?= base_url('render/index'); ?>";
		    		$(".l_success_msg").show();
		    	}else{
		    		$(".l_email_err_msg_1").show();
		    	}
		    	
		        //data - response from server
		    },
		    error: function (jqXHR, textStatus, errorThrown)
		    {
		 
		    }
		});
	})
	$('.message a').click(function(){
		$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
	});
	</script>
	
</body>
</html>