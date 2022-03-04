<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Thank You Message</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body style="margin:0; background-color: #f4f4f4">
	<style type="text/css">
		
            @media only screen and (min-width: 767px){
                .tableFull, .tableHAlf {
                	width:320px !important;
                }
            }
	</style>
	<table style="width: 50%; background: #fff; max-width: 90%; margin: 0 auto; font-size: 14px; color: gray; padding-top: 0rem; box-shadow: 0 0 30px rgba(37,45,51,.1)!important;">
		<tbody>
			<tr style="color: #000;">
				<td>
					<table style="width: 100%; padding: 2rem;">
						<tr>
							<td width="" style="width: 100%; text-align:center;">
								<a href="" style="text-decoration: none; font-family: sans-serif;">
									<strong style="font-size: 50px; color: #333;">
										<!-- <img src="http://192.168.1.68:8000/image/logo_black.png" > -->
										<!--<img src="<?php echo base_url().'uploads/dj_logo.png'?>" alt="logo" width="200px">-->
										STEEL PLANT JOBS
									</strong>
								</a>
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="font-family: sans-serif; width: 100%; padding: 0 2rem; color: #000; font-size: 16PX; text-align: left;">
					<p style="color: #666; font-size: 18px; text-align: left;">Hello, 
						<span style="color: #333;"><?php echo $name;?></span>
					</p>
					<P style="color: #666; font-size: 15px;">
						Thank you . Your password has been changed.Now You can login now
					</p>
					
		 			<p style="color: rgb(85, 85, 85); margin-bottom: 1px; font-size: 15px; margin-top: 29px;"><b> Best Regards,</b></p>

		 			<p style="font-weight: bold; color: rgb(0, 0, 0); font-size: 16px; margin-bottom: 0px; margin-top: 8px;">STEEL PLANT JOBS</p>

					<p style="font-size: 14px;"><b>Email:</b>info@jobportal.com</p>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>

<script src="<?php echo base_url(); ?>/admin_assest/js/jquery-3.3.1.min.js"></script>
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
</script>