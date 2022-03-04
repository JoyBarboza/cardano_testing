<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
      <title>Resume</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>admin_assest/js/parsley.min.js"></script>
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
   <body style="margin:0;">
      <style type="text/css">
         @media only screen and (min-width: 767px){
         .tableFull, .tableHAlf {
         width:320px !important;
         }
         }
      </style>
      <!-- <table style="width: 50%; background: #fff; max-width: 90%; margin: 0 auto; font-size: 14px; color: gray; padding-top: 0rem; box-shadow: 0 0 30px rgba(37,45,51,.1)!important;border-top: 11px solid #00afa9;">
         <tbody>
           <tr style="color: #000;">
             <td>
               <table style="width: 100%; padding: 2rem;">
                 <tr>
                   <td width="" style="width: 100%; text-align:center;">
                     <a href="#" style="text-decoration: none; font-family: sans-serif;">
                       <strong style="font-size: 50px; color: #333;">
                         <img  src="<?php echo base_url(); ?>website_assest/logo.png" alt="logo" width="200px">
                       </strong>
                     </a>              
                   </td>
                 </tr>
               </table>    
             </td>
           </tr>
         </tbody>      
         </table> -->
      <!-- <table style="width: 50%; background: #fff; max-width: 90%; margin: 0 auto; font-size: 14px; color: gray; padding-top: 0rem; box-shadow: 0 0 30px rgba(37,45,51,.1)!important;">
         <tbody>
           <tr style="color: #000;">
             <td> -->
      <style>
         table, th, td {
         border: 1px solid black;
         border-collapse: collapse;
         }
         th, td {
         padding: 5px;
         text-align: left;
         }
         
      </style>
      <div class=" table-responsive " style="margin:10px 30px;border: 2px solid #06a6e6;padding: 10px 20px;width:60%;margin: auto;background: #f7fbff;">
         <!-- id="print_div" -->
         <!-- <center>  <h1 style="font-size: 32px; padding:0px; margin:0px; ">Job Portal</h1></center>-->
            <center>  <h1 style="font-size: 32px; "> RESUME</h1></center><br>
         <form class="" method="post" data-parsley-validate="" action="">
            <div>
              
               <div style="width: 49%;    display: inline-block;">
                  <h2>Name : <?= $resume_data->full_name?></h2>
                  <span>
                  Email Id : <?= $resume_data->email?>
                  </span>
                  <br>
                  <span>
                  Mobile :  <?= $resume_data->phone?>
                  </span>
               </div>
               <div style="width: 50%;    display: inline-block; text-align: right;">
                  <!-- <h1 style="font-size: 32px;"><img  src="<?php echo base_url(); ?>website_assest/logo.png" alt="logo" width="200px"></h1> --><br>
               
                  <span><?= $resume_data->address?></span>
                  <br>
                  <!--<span><?= $resume_data->city?></span>-->
                  <!--<br>  -->
                  <!--<span><?= $resume_data->state?></span>-->
                  <!--<br>  -->
                  <!--<span><?= $resume_data->country?></span>-->
                  <!--<br>  -->
                  <!--<span><?= $resume_data->pincode?></span>-->
               </div>
            </div>
            <style>
            .table tbody tr td{
                padding:0px;
                margin:0px;
                /*font-size: 19px;*/
            }
               .table tbody tr td p{
                   padding:5px 5px;
                margin:0px;
                font-weight: bold;
                color:#000;
               }
                
                
            </style>
            <table class="table table-striped table-bordered" style="margin-top: 10px;text-align: center; width: 100%">
                       <!--  <thead  style="margin-bottom: 10px; ">
                           <tr style="border: 1px solid #dee2e6; text-align: left; align-items: left;">

                              <th colspan="12" style="padding:24px; border: 1px solid #dee2e6;text-align: center;">Name</th>
                              <th  style="padding:24px; border: 1px solid #dee2e6;text-align: center;">Total</th>
                           </tr>
                        </thead> -->
                        <tbody style="">

                          <!--<tr style="margin-top:20px">-->
                          <!--   <td colspan="12" style=" border: 1px solid #dee2e6;">-->
                          <!--  <p style="width: 40%; color: #999;flex: 1;text-align: left;">  Mobile Number</p>-->
                          <!--   </td>-->
                          <!--   <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->phone?></td>-->
                          <!--</tr>-->
                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;  font-weight: bold; text-align: left;">Gender</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->gender?></td>
                          </tr>
                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%;  font-weight: bold; flex: 1;text-align: left;">Education</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->education?></td>
                          </tr>
                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Gender</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->gender?></td>
                          </tr>
                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Experience Month</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->experience_month?></td>
                          </tr>

                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Experience Year</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->experience_year?></td>
                          </tr>
                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Degree Name</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->degree_name?></td>
                          </tr>
                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">University Name</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->university_name?></td>
                          </tr>

                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Current Company</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->current_company?></td>
                          </tr>

                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Last company</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->last_company?></td>
                          </tr>

                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Age</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->age?></td>
                          </tr>

                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Language</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->language?></td>
                          </tr>

                          <tr style="margin-top:20px">
                             <td colspan="12" style=" border: 1px solid #dee2e6;">
                              <p style="width: 40%; flex: 1;text-align: left;">Nationality</p>
                             </td>
                             <td  style="padding: 10px; border: 1px solid #dee2e6;"><?= $resume_data->nationality_name?></td>
                          </tr>
                          
                        </tbody>

                     </table>

            

            <!--<div  style="padding: 20px;margin:20px;margin-bottom:0;display: block;border-top-right-radius: 10px;border-top-left-radius: 10px;">-->

            <!--    <?php foreach($imageData as $v) {  ?>-->
            <!--      <img  src="<?php echo base_url(); ?>uploads/resume/<?php echo $v->image?>" alt="logo" width="50px">-->
            <!--    <?php } ?>-->
            <!--</div>-->
                  
             <h5 style="margin-top:10; padding:0px; font-weight: bold; font-size:18px;">Images- </h5>
            <div class="display:flex; justify-content: center; align-items: center; margin-top:10px; margin-right:10px; "> 
           
           
            
            <!-- <img src="https://anandisha.com/job_portal/uploads/admin/s3.jpg" style="width:100px; height:100px; margin-right:5px"> -->
            
            <?php foreach($imageData as $v) {  ?>
              <img src="<?php echo base_url(); ?>uploads/resume/<?php echo $v->image?>" style="width:100px; height:100px; margin-right:5px">
            <?php } ?>

            </div>
          
         </form>
          <!-- <center style="margin:0px; padding:0px;"> <a href="#" style="margin:0px; padding:0px;"> www.job.com </a></center> -->

      </div>
   </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script type="text/javascript"></script>