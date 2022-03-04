<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reset Your Password</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 <script type="text/javascript" src="<?php echo base_url(); ?>assest/parsley.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<style type="text/css">
	    .parsley-errors-list{
	        color: red;
	        list-style-type: none;
	        padding: 0;
	        margin: 0;
	    }
    </style>
</head>

<body style="margin:0; background-color: #f4f4f4">
	<style type="text/css">
		
            @media only screen and (min-width: 767px){
                .tableFull, .tableHAlf {
                	width:320px !important;
                }
            }
	</style>
	<table style="width: 50%; background: #fff; max-width: 90%; margin: 0 auto; font-size: 14px; color: gray; padding-top: 0rem; box-shadow: 0 0 30px rgba(37,45,51,.1)!important;border-top: 11px solid #00afa9;">
		<tbody>
		<tr style="color: #000;">
			<td>
				<table style="width: 100%; padding: 2rem;">
					<tr>
						<td width="" style="width: 100%; text-align:center;">
							<a href="#" style="text-decoration: none; font-family: sans-serif;">
								<strong style="font-size: 50px; color: #333;">
								  STEEL PLANT JOBS
									<!--<img src="<?php echo base_url().'uploads/dj_logo.png'?>" alt="logo" width="200px">-->
								</strong>
							</a>							
						</td>
					</tr>
				</table>		
			</td>
		</tr>	
		<tr style="color: #000;">
			<td style="text-align: center; background: rgb(109, 102, 102) none repeat scroll 0% 0%; color: rgb(255, 255, 255); font-size: 22px; font-family: sans-serif;">
				<p>Reset Your Password</p>
			</td>
		</tr>
	<tr>
		<td style="font-family: sans-serif; width: 100%; padding: 0 2rem; color: #000; font-size: 16PX; text-align: left;">

			<p style="color: #666; font-size: 18px; text-align: left;">Hello, 
				<span style="color: #333;"><?=$name?></span>
			</p>

			<form style="margin: 50px 0;" method="post" action="<?=base_url();?>auth/verify_resetpassword?id=<?=base64_encode($id)?>" data-parsley-validate>
				<input type="Password" placeholder="New Password" name="npwd" class="form-control p_input" id="npwd" placeholder="New Password" data-parsley-required data-parsley-required-message="Please Enter New Password" style="display: block;height:32px;padding-left: 15px;border-radius: 50px;box-shadow: none;border: 1px solid #ccc;outline: none;width: 60%;margin: 0 auto 20px;" data-parsley-minlength="6" data-parsley-minlength-message="Password must be least 6 characters">
				<span id="validate-status1"></span>

				<input type="Password" placeholder="Confirm New Password"  name="cpwd" class="form-control p_input" id="cpwd" placeholder="Confirm Password" data-parsley-required data-parsley-required-message="Please Enter Confirm New Password" data-parsley-equalto="#npwd" data-parsley-equalto-message="Password and Confirm password must be same" style="display: block;height:32px;padding-left: 15px;border-radius: 50px;box-shadow: none;border: 1px solid #ccc;outline: none;width: 60%;margin: 0 auto 20px;" data-parsley-minlength="6" data-parsley-minlength-message="Password must be least 6 characters">

				<p id="validate-status"></p>

				<input id="forget_password" type="submit" value="submit" style="width: 63%;display: block;height: 40px;text-transform: uppercase;margin: 0 auto;border-radius: 50px;border: 2px solid #00afa9;background: transparent;outline: none;text-align: center;color: #333;font-weight: 600;cursor: pointer;">

			</form>

 
 			<p style="color: rgb(85, 85, 85); margin-bottom: 1px; font-size: 15px; margin-top: 29px;"><b> Best Regards,</b></p>

 			<p style="font-weight: bold; color: rgb(0, 0, 0); font-size: 16px; margin-bottom: 0px; margin-top: 8px;">STEEL PLANT JOBS</p>

			<p style="font-size: 14px;"><b>Email:</b>info@jobpotal.com</p>
</td>
	</tr>

	</tbody>			
	</table>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    
    $('.alert-danger').delay(7000).fadeOut();    
    $('.alert').delay(5000).fadeOut(); 


    <?php if($this->session->flashdata('success')){ ?>
        toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    <?php }else if($this->session->flashdata('error')){  ?>
        toastr.error("<?php echo $this->session->flashdata('error'); ?>");
    <?php }else if($this->session->flashdata('warning')){  ?>
        toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
    <?php }else if($this->session->flashdata('info')){  ?>
        toastr.info("<?php echo $this->session->flashdata('info'); ?>");
    <?php } ?>
    
	// $( document ).ready(function() {

	// 	$("#cpwd").keyup(validate);
	// });

	// function validate() {      
	// 	var password1 = $("#npwd").val();      
	// 	var password2 = $("#cpwd").val();        
	// 	if(password1 == password2) {            
	// 		$("#validate-status").css('color','green');            
	// 		$("#validate-status").text("valid");                   
	// 		$('#forget_password').prop('disabled', false);         
	// 	}        
	// 	else {            
	// 		$('#forget_password').prop('disabled', true);             
	// 		$("#validate-status").css('color','red');            
	// 		$("#validate-status").text("Confirm Password does not match");          
	// 	}     
	// }
	
	// function checkRegex(pas)  
	// {
	// 	// alert('hi');
	// 	// var decimal=  ^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()\\-_=+{}|?>.<,:;~’]{8,15}$;
	// 	var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
	// 	if(pas.match(decimal))     
	// 	{       
	// 		$("#validate-status1").css('color','green');      
	// 		$("#validate-status1").text("");             
	// 		$("#forget_password").prop("disabled",false);           
	// 	}
	// 	else  
	// 	{       
	// 		$("#validate-status1").css('color','red');      
	// 		$("#validate-status1").text("Wrong Password ! Password must be contain atleast 1 Uppercase letter, 1 lowercase letter,1 number,1 special character ,Eg. Abc@123");       
	// 		$("#forget_password").prop("disabled",true);        
	// 	}
	// }
</script>
