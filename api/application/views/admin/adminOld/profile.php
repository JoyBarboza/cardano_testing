<main class="app-content">
   <div class="app-title">
      <div>
         <h1>  <?php echo $title; ?></h1>
         <!-- <p>Bootstrap default form components</p> -->
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
      </ul>
   </div>
   
   <div class="row">
      <div class="col-md-12">
         <div class="tile">
            <form class="row" action="<?php echo site_url('admin/update_profile');?>" enctype="multipart/form-data" method="post" data-parsley-validate="">
               <div class="col-lg-6">
                  <div class="row" >
                     <div class="form-group col-md-12 col-sm-12">
                        <label><?php echo $this->lang->line('name'); ?> </label>
                        <input class="form-control" type="text" placeholder="<?php echo $this->lang->line('name'); ?>" value="<?php echo $getAdminData->name; ?>" name="name" required data-parsley-required data-parsley-required-message="<?php echo $this->lang->line('enter_name'); ?>">
                     </div>

                     <div class="form-group col-md-12 col-sm-12">
                        <label><?php echo $this->lang->line('email_id'); ?></label>
                        <input class="form-control" type="text" value="<?php echo $getAdminData->email; ?>" name="email" placeholder="<?php echo $this->lang->line('email_id'); ?>" required data-parsley-required data-parsley-required-message="<?php echo $this->lang->line('enter_email_id'); ?>">
                     </div>
                     
                     <div class="form-group col-md-12 col-sm-12">
                        <label>Mobile Number</label>
                        <input class="form-control phoneno" type="text" placeholder="Mobile Number" value="<?php echo $getAdminData->mobile_number; ?>" name="mobile_number"  required data-parsley-required data-parsley-required-message="<?php echo $this->lang->line('enter_mobile_number'); ?> " data-parsley-type="number" data-parsley-required-message="<?php echo $this->lang->line('number_only'); ?> "  data-id="mobile_number" data-parsley-minlength="10" data-parsley-maxlength="10"  data-parsley-maxlength-message="Maximum length should be 10" data-parsley-minlength-message="Maximum length should be 10">

                         <span id="errmsg_phoneno" style="color: red"></span>
                     </div>
                  </div>
               </div>
                
                
                <div class="col-lg-6">
                  <div class="row" >
                    <div class="form-group col-md-8 col-sm-12 m-auto ">
                        <div class="profile_img_run">
                           <div class="file-upload">
                               <div class="image-upload-wrap">
                                    <?php if(!empty($getAdminData->profile_image))
                                        {
                                          $admin_img = ADMIN_IMG.$getAdminData->profile_image;
                                        }else{
                                          $admin_img =  COMMON_IMG;
                                        }
                                      ?>
                                    
                                    <input class="file-upload-input form-control" id="image" type='file' onchange="readURL(this);" accept="image/*" aria-describedby="fileHelp"name="image"/>
                                    <div class="drag-text p-2">
                                      <img id="admin_img" name="image" class="mb-3" src="<?php echo $admin_img; ?>" alt="your image" width="100px" height="100px" />
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <img class="file-upload-image" src="#" alt="your image" />
                                </div>
                                <button class="btn btn-primary w-75 text-light d-block m-auto" type="button" onclick="$('.file-upload-input').trigger( 'click' )">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                       <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                    </svg>
                                    Choose a file&hellip; 
                                </button>
                            </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                    
                <div class="col-lg-12">
                    <button class="btn btn-primary" type="submit" ><?php echo $this->lang->line('update_profile'); ?></button>
                </div>
            </form>
         </div>
      </div>
   </div>
   <div class="row title-content">
      <div class="col-md-12">
         <div class="tile">
            <div class="row">
               <div class="col-lg-12">
                  <h3 class="tile-title"><?php echo $this->lang->line('change_password'); ?></h3>
                  <form class="row" action="<?php echo site_url('admin/change_password');?>" enctype="multipart/form-data" method="post" data-parsley-validate="">
                     <div class="form-group col-md-6 col-sm-12">
                        <label><?php echo $this->lang->line('old_password'); ?></label>
                        <input class="form-control" type="password" name="old_password" placeholder="<?php echo $this->lang->line('old_password'); ?>"required data-parsley-required-message="<?php echo $this->lang->line('enter_old_password'); ?>" id="old_password" maxlength="8" data-parsley-minlength="8" data-parsley-maxlength="8" data-parsley-minlength-message="Password length should be 8 length" data-parsley-maxlength-message="Password length should be 8 length">
                     </div>
                     <div class="form-group col-md-6 col-sm-12">
                        <label><?php echo $this->lang->line('new_password'); ?></label>
                        <input class="form-control" type="password" name="new_password" placeholder="<?php echo $this->lang->line('new_password'); ?>" required data-parsley-required-message="<?php echo $this->lang->line('enter_new_password'); ?> " id="new_password" maxlength="8" data-parsley-minlength="8" data-parsley-maxlength="8" data-parsley-minlength-message="Password length should be 8 length" data-parsley-maxlength-message="Password length should be 8 length">
                     </div>
                     <div class="form-group col-md-6 col-sm-12">
                        <label><?php echo $this->lang->line('confirm_password'); ?></label>
                        <input class="form-control" type="password" name="confirm_password" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" required data-parsley-required-message="<?php echo $this->lang->line('enter_confirm_password'); ?>" data-parsley-equalto="#new_password" data-parsley-equalto-message="<?php echo $this->lang->line('new_confirm_password_shoul_be_same'); ?>" id="confirm_password">
                     </div>
                     <div class="col-sm-12 mt-2">
                        <button class="btn btn-primary" type="submit"><?php echo $this->lang->line('update_password'); ?> </button>
                     </div>

                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>



<script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#admin_img').attr('src', e.target.result);
          $('.image-upload-wrap').hide();
    
          $('.file-upload-image').attr('src', e.target.result);
          $('.file-upload-content').show();
    
          $('.image-title').html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        removeUpload();
      }
      $("#imgInp").change(function(){
        readURL(this);
      });
    }

$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
  });
  $('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
</script>