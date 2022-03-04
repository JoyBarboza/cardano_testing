    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><? echo $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/post_job');?>"> Job Post List</a></li>
          <li class="breadcrumb-item"><? echo $title;?> </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
            <div id="msg"></div>
              <div class="col-lg-12">
                <form class="row" action="<?php echo site_url('admin/user/insert');?>" enctype="multipart/form-data" method="post" data-parsley-validate="">
                   
                  <div class="form-group col-md-6">
                    <label for="name">Recuirter Name</label>
                    <input class="form-control" id="name" type="text" placeholder="Full Name" name="name" required data-parsley-required data-parsley-required-message="Enter Full Name" value="<?= $getPostedJobDetail->recuriter_name;?>" readonly>
                  </div>
                  
                <div class="form-group col-md-6">
                    <!--<label for="name">Want to hire</label>-->
                    <label for="name">Job Title</label>
                    <input class="form-control" id="want_to_hire" type="text" placeholder="Job Title" name="want_to_hire" value="<?= $getPostedJobDetail->want_to_hire;?>" readonly>
                  </div> 

                   <div class="form-group col-md-6">
                    <label for="name">Contact Person Name</label>
                    <input class="form-control" id="contact_person_name" type="text" placeholder="Contact Person Name" name="contact_person_name" value="<?= $getPostedJobDetail->contact_person_name;?>" readonly>
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="name">Contact Person Number</label>
                    <input class="form-control" id="contact_number" type="text" placeholder="Contact Person Number" name="contact_number" value="<?= $getPostedJobDetail->contact_number;?>" readonly>
                  </div> 
                  
                  <div class="form-group col-md-6">
                    <label for="name">Email Id</label>
                    <input class="form-control" id="last_company_name" type="text" placeholder="Email Id" name="last_company_name" value="<?= $getPostedJobDetail->last_company_name;?>" readonly>
                  </div>

                 


                   <div class="form-group col-md-6">
                    <label for="mobile_number">Education</label>
                    <input class="form-control" id="education" type="text" placeholder="Education" name="education" value="<?= $getPostedJobDetail->education;?>" readonly>
                  </div>

                   <div class="form-group col-md-6">
                    <label for="name">Number of staff</label>
                    <input class="form-control" id="no_of_staff" type="text" placeholder="Number of staff" name="no_of_staff" value="<?= $getPostedJobDetail->no_of_staff;?>" readonly>
                  </div> 

                 

                  <div class="form-group col-md-6">
                    <label for="name">Degree Name</label>
                    <input class="form-control" id="degree_name" type="text" placeholder="Degree Name" name="degree_name" value="<?= $getPostedJobDetail->degree_name;?>" readonly>
                  </div> 
                  
                  
                    <div class="form-group col-md-6">
                    <label for="name">GST Number</label>
                    <input class="form-control" id="gst_number" type="text" placeholder="GST Number" name="gst_number" value="<?= $getPostedJobDetail->gst_number;?>" readonly>
                  </div> 
                  
                  
                   <div class="form-group col-md-6">
                    <label for="name">Category Name</label>
                    <input class="form-control" id="categories_name" type="text" placeholder="Category Name" name="categories_name" value="<?= $getPostedJobDetail->categories_name;?>" readonly>
                  </div> 

                  
                    
                    <div class="form-group col-md-6">
                    <label for="name">Sub Category Name</label>
                    <input class="form-control" id="subcategories_name" type="text" placeholder="Sub Category Name" name="subcategories_name"value="<?= $getPostedJobDetail->subcategories_name;?>" readonly>
                  </div> 
                
                <div class="form-group col-md-6">
                    <label for="name">Sub Sub Category Name</label>
                    <input class="form-control" id="subcategories_name" type="text" placeholder="Sub Sub Category Name" name="sub_subcategory_name" value="<?= $getPostedJobDetail->sub_subcategory_name;?>" readonly>
                  </div> 
                  <div class="form-group col-md-6">
                    <label for="name">Experience</label>
                    <input class="form-control" id="experience" type="text" placeholder="Experience" name="experience" value="<?= $getPostedJobDetail->experience;?>" readonly>
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="name">Salary</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Salary" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getPostedJobDetail->salary_from;?> - <?= $getPostedJobDetail->salary_to;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 


                  <div class="form-group col-md-6">
                    <label for="name">Address</label>
                    <textarea class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" readonly><?= $getPostedJobDetail->address;?></textarea>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="name">City</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getPostedJobDetail->city;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 


                  <div class="form-group col-md-6">
                    <label for="name">state</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getPostedJobDetail->state;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 

                  <div class="form-group col-md-6">
                    <label for="name">Country</label>
                    <input class="form-control" id="agent_referral_code" type="text" placeholder="Agent Referral Code" name="agent_referral_code" required data-parsley-required data-parsley-required-message="Enter Agent Referral Code" onkeyUp="checkVendorAgentReferralCode(this.value)"value="<?= $getPostedJobDetail->country;?>" readonly>
                        <span id="errmsg_vendor_agentReferralCoder" style="color: red"></span>
                  </div> 

                    <div class="form-group col-md-6">
                    <label for="name">Description</label>
                    <textarea class="form-control" id="descripition" type="text" placeholder="Description" name="descripition" readonly><?= $getPostedJobDetail->descripition;?></textarea>
                  </div> 



                  

                 

                  
                  
                </form>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </main>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    

</script>
