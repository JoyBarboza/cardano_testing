<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assest/admin_assest/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Job Portal</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/parsley.min.js"></script>

    <script src="<?php echo base_url(); ?>assest/admin_assest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assest/admin_assest/toastr.min.css">

    <style type="text/css">
    .parsley-errors-list{
        color: red;
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
  </style>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>
           <!-- <img src="<?php echo base_url(); ?>uploads/logo_1.jpeg" alt="logo" width="100px">  -->
           STEEL PLANT JOBS
        </h1>
      </div>

      <div class="login-box">
        <form class="login-form" action="<?php echo site_url('admin/check_login');?>" method="POST" data-parsley-validate>
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Super Admin</h3>
          <div class="form-group">
            <label class="control-label">Email-Id</label>
            <!-- <input class="form-control" type="text" placeholder="Email" autofocus required> -->
            <input id="login__username" type="text" name="email" class="form-control" placeholder="Email-Id" required data-parsley-required data-parsley-required-message="Please enter Email-Id">
          </div>
          <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('password'); ?></label>
            <!-- <input class="form-control" type="password" placeholder="Password" required> -->
            <input id="login__password" type="password" name="password" class="form-control" placeholder="Password" required data-parsley-required data-parsley-required-message="Enter Password">
          </div>
     <!-- <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="<?php echo site_url('admin/forgot_password')?>" >Forgot Password </a></p> 
            </div>
          </div>  -->
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i><?php echo $this->lang->line('sign_in'); ?></button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url(); ?>/admin_assest/js/plugins/pace.min.js"></script>
    <script type="text/javascript">
        $('.login-content [data-toggle="flip"]').click(function() {
          	$('.login-box').toggleClass('flipped');
          	return false;
        });

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
  </body>
</html>