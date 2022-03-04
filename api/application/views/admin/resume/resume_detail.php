    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><? echo $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <?php if($this->uri->segment(2) == 'user_resume_detail') {?>
                <li class="breadcrumb-item"><a href="<?php echo site_url('admin/user_resume_list');?>"> User Resume List</a></li>
           <?php }else{?>
                <li class="breadcrumb-item"><a href="<?php echo site_url('admin/resume');?>"> Applied Job List</a></li>
           <?php }?>
          <li class="breadcrumb-item"><? echo $title;?> </li>
        </ul>
      </div>
      
      <div class="row">
         <div id="msg"></div>
         
          <div class="col-md-12" style="text-align: right">
               <?php if($this->uri->segment(2) == 'user_resume_detail') {?>
               <a class="btn btn-primary icon-btn" target="_blank" href="<?php echo base_url().'admin/ResumeController/user_generate_pdf/';?><?= base64_encode($getResumeDetail->id);?>">Generate Pdf	</a> 
                <?php }else{?>
             <a class="btn btn-primary icon-btn" target="_blank" href="<?php echo base_url().'admin/ResumeController/generate_pdf/';?><?= base64_encode($getResumeDetail->id);?>">Generate Pdf	</a> 
            <?php }?>
            <!--<a class="btn btn-primary icon-btn" href="javascript:void(0);" data-toggle="modal" data-target="#addPromodeModal"><i class="fa fa-plus"></i>Generate Pdf</a>-->
        </div> 
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
            <div id="msg"></div>
              <div class="col-lg-12">
                <form class="row" action="<?php echo site_url('admin/user/insert');?>" enctype="multipart/form-data" method="post" data-parsley-validate="">
                   
                  <div class="form-group col-md-6">
                    <label for="name">Employee Name</label>
                    <input class="form-control" id="name" type="text" placeholder="Full Name" name="name" required data-parsley-required data-parsley-required-message="Enter Full Name" value="<?= $getResumeDetail->full_name;?>" readonly>
                  </div>
                  
                   <?php if($this->uri->segment(2) != 'user_resume_detail') {?>
                  
                      <div class="form-group col-md-6">
                        <label for="email">Recuriter Name</label>
                        <input class="form-control" id="email" type="text" placeholder="Email-Id" name="email"  value="<?= $getResumeDetail->r_name;?>" readonly>
                        <span id="errmsg_user_email" style="color: red"></span>
                      </div>
                    
                     <?php } ?>
                    <div class="form-group col-md-6">
                    <label for="email">Mobile Number</label>
                    <input class="form-control" id="phone" type="text" placeholder="Mobile Number" name="phone" value="<?= $getResumeDetail->phone;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="email">Alternate Mobile Number</label>
                    <input class="form-control" id="alternate_mobile_number" type="text" placeholder="Alternate Mobile Numberv" name="alternate_mobile_number" value="<?= $getResumeDetail->alternate_mobile_number;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="email">Email Id</label>
                    <input class="form-control" id="email" type="text" placeholder="Email Id" name="email" value="<?= $getResumeDetail->email;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="email">Gender</label>
                    <input class="form-control" id="gender" type="text" placeholder="Gender" name="gender" value="<?= $getResumeDetail->gender;?>" readonly>
                  </div>
                  
                  
                  <div class="form-group col-md-6">
                    <label for="email">Date of Birth</label>
                    <input class="form-control" id="age" type="text" placeholder="Date of Birth" name="age" value="<?= $getResumeDetail->age;?>" readonly>
                  </div>
                  
                  
                   <div class="form-group col-md-6">
                    <label for="name">Category Name</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getResumeDetail->categories_name;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="name">Sub Categories Name</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getResumeDetail->subcategories_name;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="name">Sub Sub Categories Name</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getResumeDetail->subsubcategories_name;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 
<?php if($this->uri->segment(2) != 'user_resume_detail') {?>
                   <div class="form-group col-md-6">
                    <label for="name">Organization Name</label>
                    <input class="form-control" id="organization_name" type="text" placeholder="Organization Name" name="agent_referral_code" value="<?= $getResumeDetail->organization_name;?>" readonly>
                  </div> 
<?php } ?>
                  <div class="form-group col-md-6">
                    <label for="name">Total Experience (In years)</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Total Experience" value="<?= $getResumeDetail->total_experience;?>" readonly>              </div> 

                  <!--<div class="form-group col-md-6">-->
                  <!--  <label for="name">Degree Name</label>-->
                  <!--  <input class="form-control" id="agent_referral_code" type="text" placeholder="Degree Name" value="<?= $getResumeDetail->degreename;?>" readonly>-->
                  <!--</div> -->
                
                
                    <div class="form-group col-md-6">
                    <label for="name">Job Title</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Degree Name" value="<?= $getResumeDetail->degree_name;?>" readonly>
                  </div> 
                  

                  <!-- <div class="form-group col-md-6">-->
                  <!--  <label for="mobile_number">Education</label>-->
                  <!--  <input class="form-control" id="mobile_number" type="text" placeholder="Education" value="<?= $getResumeDetail->education;?>" readonly>-->
                  <!--</div>-->
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">Language</label>
                    <input class="form-control" id="mobile_number" type="text" placeholder="Languager" value="<?= $getResumeDetail->language;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">Nationality</label>
                    <input class="form-control" id="mobile_number" type="text" placeholder="Nationality" value="<?= $getResumeDetail->nationality_name;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="email">Other Certificate (If any)</label>
                    <input class="form-control" id="certificate" type="text" placeholder="Other Certificate (If any)" name="certificate" value="<?= $getResumeDetail->certificate;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="email">Computer Skill</label>
                    <input class="form-control" id="computer_skill" type="text" placeholder="Computer Skill" name="computer_skill" value="<?= $getResumeDetail->computer_skill;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">Address</label>
                   <textarea  class="form-control" readonly><?= $getResumeDetail->address;?></textarea>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">City</label>
                    <input class="form-control" id="city" type="text" placeholder="City" name="mobile_number" value="<?= $getResumeDetail->city;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">State</label>
                    <input class="form-control" id="state" type="text" placeholder="State" value="<?= $getResumeDetail->state;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">Country</label>
                    <input class="form-control" id="country" type="text" placeholder="Country"  value="<?= $getResumeDetail->country;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">Pincode</label>
                    <input class="form-control" id="pincode" type="text" placeholder="Pincode"  value="<?= $getResumeDetail->pincode;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="mobile_number">Current Company/Last Company</label>
                    <input class="form-control" id="current_company" type="text" placeholder="Current Company"  value="<?= $getResumeDetail->current_company;?>" readonly>
                  </div>
                  
                   <div class="form-group col-md-6">
                    <label for="mobile_number">Last Salary/Current Salary</label>
                    <input class="form-control" id="current_salary" type="text" placeholder="Last Salary/Current Salary"  value="<?= $getResumeDetail->current_salary;?>" readonly>
                  </div>
                  
                   <div class="form-group col-md-6">
                    <label for="mobile_number">Expected Salary</label>
                    <input class="form-control" id="expected_salary" type="text" placeholder="Expected Salary"  value="<?= $getResumeDetail->expected_salary;?>" readonly>
                  </div>
                  
                  <!--<div class="form-group col-md-6">-->
                  <!--  <label for="mobile_number">Last Company</label>-->
                  <!--  <input class="form-control" id="last_company" type="text" placeholder="Last Company" name="last_company"  value="<?= $getResumeDetail->last_company;?>" readonly>-->
                  <!--</div>-->
                  
                   <div class="form-group col-md-6">
                    <label for="mobile_number">Resume</label>
                     <br>
                        <?php if(!empty($getResumeDetail->resume_pdf)){?>
                       
                       <a href="<?php echo base_url().'uploads/resume_pdf/'.$getResumeDetail->resume_pdf;?>" target="_blank">Download PDF</a>
                      <?php }else{
                        echo 'No pdf';
                      }?>
                  </div>
                  
                   <div class="form-group col-md-6">
                    <label for="mobile_number">Video</label>
                    <br>
                    <?php if(!empty($getResumeDetail->video)){?>
                        <video width="320" height="240" controls>
                          <source src="<?php echo base_url().'uploads/videos/'.$getResumeDetail->video;?>" type="video/mp4">
                          <source src="<?php echo base_url().'uploads/videos/'.$getResumeDetail->video;?>" type="video/ogg">
                        Your browser does not support the video tag.
                        </video>
                    <?php }else{
                        echo 'No Video';
                      }?>
                  </div>
                  
                </form>
              </div>
              
               <?php if(!empty($getuserQualification)) { ?>  
                  <h1>Qualification</h1>
                   <table class="table table-hover table-bordered" id="example">
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
                  <h1>Experience</h1>
                   <table class="table table-hover table-bordered" id="example">
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
            </div>
            
          </div>
        </div>
      </div>
    </main>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    

</script>
