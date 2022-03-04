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

      <div class=" table-responsive " style="margin:10px 30px;border: 2px solid #06a6e6;padding: 10px 20px;width:80%;margin: auto;background: #f7fbff;">

         <!-- id="print_div" -->

         <!-- <center>  <h1 style="font-size: 32px; padding:0px; margin:0px; ">Job Portal</h1></center>-->

            <center>  <h1 style="font-size: 32px; font-family: sans-serif;"> RESUME</h1> </center><br>

         <form class="usr_rsm_pdf" method="post" data-parsley-validate="" action="">
            
                <div class="form-group col-md-6">

                  <label for="name" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Employee Name :</label>

                  <label for="name" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->full_name;?></label>

                </div>

                  <div class="form-group col-md-6">

                    <label for="email" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;"
>Mobile Number :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->phone;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="email" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Alternate Mobile Number :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->alternate_mobile_number;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="email" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Email Id :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->email;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="email" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Gender :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->gender;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="email"  style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Date of Birth :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->age;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="name" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Category Name :</label>

                    <label for="name" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->categories_name;?></label>

                  </div> 

                  <div class="form-group col-md-6">

                    <label for="name" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Sub Categories Name :</label>

                    <label for="name" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->subcategories_name;?></label>

                  </div> 

                  <div class="form-group col-md-6">

                    <label for="name" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Sub Sub Categories Name :</label>

                    <label for="name" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->subsubcategories_name;?></label>

                  </div> 

                  <div class="form-group col-md-6">

                    <label for="name" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Total Experience (In years) :</label>

                    <label for="name" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->total_experience;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="name" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Job Title :</label>

                    <label for="name" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->degree_name;?></label>

                  </div> 

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Language</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->language;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Nationality :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->nationality_name;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="email" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Other Certificate (If any) :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->certificate;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="email" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Computer Skill :</label>

                    <label for="email" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->computer_skill;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Address :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->address;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">City :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->city;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">State :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->state;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Country :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->country;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Pincode :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->pincode;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Current Company/Last Company :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->current_company;?></label>
                    
                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Last Salary/Current Salary :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->current_salary;?></label>

                  </div>

                  <div class="form-group col-md-6">

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; font-weight: 600; width: 250px; margin-bottom: 8px; display: inline-block;">Expected Salary :</label>

                    <label for="mobile_number" style="font-family: sans-serif; font-size: 16px; margin-bottom: 8px; display: inline-block;"><?= $getResumeDetail->expected_salary;?></label>

                  </div>

                  <?php if(!empty($getuserQualification)) { ?>  

                  <h1 style="font-family: sans-serif; margin-top: 45px;">Qualification</h1>

                   <table class="table table-hover table-bordered" style="font-family: sans-serif; width: 100%;" id="example">

                      <thead>

                        <tr>

                         <th>S.No</th>

                         <th>Type</th>

                         <th>Name</th>

                         <th>City</th>

                         <th>Passout Year</th>

                         <th>Marks/CGPA</th>

                         <th>Board/University</th>

                        </tr>

                      </thead>

                      <tbody>

                          <?php

                            $i = 1;

                            foreach ($getuserQualification as $q) {  

                            // print_r($q);

                            ?>

                               <tr>

                                  <td><?php echo $i; ?></td>

                                  <td>

                                      <?php  

                                           if($q['degree_type'] == '0'){

                                                 echo 'Degree';    

                                            }else if(!empty($q['degree_type'])){

                                                if($q['degree_type'] == '1'){

                                                    echo 'Master';

                                                }elseif($q['degree_type'] == '2'){

                                                    echo 'ITI';

                                                }elseif($q['degree_type'] == '3'){

                                                    echo 'Diploma';

                                                }else{

                                                    echo '10th/12th';

                                                }

                                            }else{

                                                echo '10th/12th';

                                            }

                                      

                                      ?>

                                  </td>

                                  <td>

                                      <?php 

                                         if($q['degree_type'] == '0'){

                                            echo  $q['d_degree_name'];    

                                        }else if(!empty($q['degree_type'])){

                                            echo  $q['d_degree_name'];    

                                       }else{

                                            echo $q['q_degree_name'];

                                        } 

                                      ?>

                                  </td>

                                  <td><?php echo $q['city']; ?></td>

                                  <td><?php echo $q['passout']; ?></td>

                                  <td><?php echo $q['marks']; ?></td>

                                  <td><?php echo $q['board']; ?></td>

                               </tr>

                         <?php $i++; } ?>

                      </tbody>

                    </table>

                <?php } ?>  

                

              

                  <?php if(!empty($getuserExperience)) { ?>  

                  <h1 style="font-family: sans-serif; margin-top: 25px;">Experience</h1>

                   <table class="table table-hover table-bordered" style="font-family: sans-serif; width: 100%;" id="example">

                      <thead>

                        <tr>

                         <th>S.No</th>

                         <th>Company Name</th>

                         <th>Job Title</th>

                         <th>Experience</th>

                         <th>From Year</th>

                         <th>To Year</th>

                        </tr>

                      </thead>

                      <tbody>

                          <?php

                            $i = 1;

                            foreach ($getuserExperience as $key) {  ?>

                               <tr>

                                  <td><?php echo $i; ?></td>

                                  

                                  <td><?php echo $key->company_name; ?></td>

                                  <td><?php echo $key->job_title; ?></td>

                                  <td><?php echo $key->experience; ?></td>

                                  <td><?php echo $key->from_year; ?></td>

                                  <td><?php echo $key->to_year; ?></td>

                               </tr>

                         <?php $i++; } ?>

                      </tbody>

                    </table>

                <?php } ?>  

                </form>

          



      </div>

   </body>

</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script type="text/javascript"></script>