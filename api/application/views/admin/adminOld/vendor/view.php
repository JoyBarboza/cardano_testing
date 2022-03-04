<style type="text/css">
   .info {
   text-align: center;
   padding-top: 11%;
   padding-bottom: 5%;
   }
</style>
<main class="app-content">
   <div class="app-title">
        <div>
            <h1><?= $title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/vendor');?>"> Vendor</a></li>
            <li class="breadcrumb-item"><?= $title;?> </li>
        </ul>
   </div>
    <div class="row user">
        <div class="col-md-3">
            <div class="p-0">
                <div class="info">
                    <?php if(!empty($getVendorDetail->profile_image))
                        {
                         $vendor_img = USER_IMG.$getVendorDetail->profile_image;
                       }else{
                         $vendor_img =  COMMON_IMG;
                       }                     ?>
                    <img class="user-img" src="<?php echo $vendor_img; ?>" style="max-width: 100px;">
                    <h4><?= $getVendorDetail->name;?></h4>
                </div>
            </div>
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#user-profile" data-toggle="tab">Profile Detail</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#vendor-CRD" data-toggle="tab">Criminal Record Document</a>
                    </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" href="#vendor-specialize" data-toggle="tab">Specilaize Detail</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#vendor-portfolio" data-toggle="tab">Portfolio</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/vendor/regular_service/'.base64_encode($getVendorDetail->id));?>">Regular Service</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/vendor/package/'.base64_encode($getVendorDetail->id));?>">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/vendor/subscription/'.base64_encode($getVendorDetail->id));?>">Subscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/vendor/group/'.base64_encode($getVendorDetail->id));?>">Group</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/vendor/offer_loyalty/'.base64_encode($getVendorDetail->id));?>">Offers/Loyalty</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="user-profile">
                    <div class="timeline-post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3>Basic information : </h3>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <fieldset disabled="">
                                                   <label class="control-label" for="disabledInput">Name</label>
                                                   <input class="form-control" id="disabledInput" type="text" value="<?= $getVendorDetail->name;?>" placeholder="Name" disabled="">
                                                </fieldset>
                                            </div>
                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">DOB</label>
                                                   <input class="form-control" id="readOnlyInput" type="text" value="<?= $getVendorDetail->dob;?>" placeholder="DOB" readonly="">
                                                </fieldset>
                                            </div>

                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">Plan Name</label>
                                                   <input class="form-control" id="readOnlyInput" type="text" value="<?= $getVendorDetail->plan_name;?>" placeholder="Plan Name" readonly="">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">Email</label>
                                                   <input class="form-control" id="readOnlyInput" type="text" value="<?= $getVendorDetail->email;?>" placeholder="Email" readonly="">
                                                </fieldset>
                                            </div>

                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">Language Knows</label>
                                                   <?php
                                                         if(!empty($getVendorDetail->language_id))
                                                        {
                                                            $language_id = $getVendorDetail->language_id;
                                                            
                                                            $checked_arr = explode(",",$language_id);
                                                            
                                                            $language = $this->AdminModel->getLanguage($language_id);
                                                            // print_r($language);
                                                           
                                                            $comma_string = array();
                                                            foreach ($language as $k)
                                                              {
                                                                 $comma_string[] = $k['language_name'];
                                                              }
                                                              $comma_separated = implode(",", $comma_string);
                                                        }
                                                         else{
                                                             $comma_separated = "No Language added";
                                                         }
                                            
                                                    ?>
                                                   <input class="form-control" id="readOnlyInput" type="text" value="<?= $comma_separated;?>" placeholder="Email" readonly="">
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            <div class="tab-pane fade" id="vendor-CRD">         
                <div class="timeline-post">
                    <h3>Criminal Record Document : </h3>
                    <div class="row">
                         <?php if(!empty($getCriminalRecord->name)){
                                        $criminal_doc = VENDOR_CRIMINAL.$getCriminalRecord->name;
                                    ?>
                        
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <fieldset>
                                        <embed src="<?=$criminal_doc;?>" type="application/pdf" width="500" height="375" target="_blank">
                                       
                                    </fieldset>
                                    
                                    
                                </div>       
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <center>
                                        <fieldset>
                                            <a href="<?=$criminal_doc;?>" target="_blank" style="width:120px; font-size: large;">view</a>
                                        </fieldset>
                                    </center>
                                </div>       
                            </div>
                        <?php } else {?>
                            <div class="col-lg-8">
                            <div class="form-group">
                                <fieldset>
                                  <label class="control-label" for="readOnlyInput">Not uploaded</label>
                                </fieldset>
                            </div>       
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
                
                
                <div class="tab-pane" id="vendor-specialize">
                    <div class="timeline-post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3>Specilaize : </h3>
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="tile">
                                                <div class="row">
                                                    <?php 
                                                        foreach($vendorSpecializeList as $value) {
                                                            $status = $value['vendor_checked_specialize'];
                                                            
                                                            // print_r($status);
                                                            if($status == 0){
                							        	         $status = "disabled";
                							        	    }else{
                							        	        $status = "checked='disabled'";
                							        	    }
                                                    ?>
                                                        <div class="form-group">
                                                            <fieldset disabled="">
                                                               <input type="checkbox" id="html" value="1" name="vendor_checked_specialize[]" <?=$status;?>>
                                                               <?php echo $value['specialize_name']; ?>
                                                               &nbsp;&nbsp;
                                                            </fieldset>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="vendor-portfolio">
                    <div class="timeline-post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3>Specilaize : </h3>
                                     <div class="row">
                                            <div class="form-group col-md-12">
                                              <div class="row">
                                                  <?php
                                                      for ($j=0;$j < count($imageData); $j++) { 
                                                        
                                                         if(!empty($imageData[$j]['image_name']))
                                                  {
                                                     $vendor_portfolio = VENDOR_PORTFOLIO_IMG.$imageData[$j]['image_name'];
                                                  }else{
                                                   $vendor_portfolio =  COMMON_IMG;
                                                 }
                                                      ?>
                                                      <div class="col-sm-2 product-image"><img id="preview" src="<?php echo $vendor_portfolio; ?>" alt="your image" width="150px" height="120px"/>
                                                      </div>
                                                      &nbsp;
                                                  <?php }
                                                  ?>
                                                  <div id="image_preview" width="150px" height="120px"></div>
                                              </div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               
            </div>
        </div>
    </div>
</main>