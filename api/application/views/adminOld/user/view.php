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
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/user');?>"> User</a></li>
            <li class="breadcrumb-item"><?= $title;?> </li>
        </ul>
   </div>
    <div class="row user">
        <div class="col-md-3">
            <div class="p-0">
                <div class="info">
                    <?php if(!empty($getUserDetail->profile_image))
                        {
                         $user_img = USER_IMG.$getUserDetail->profile_image;
                       }else{
                         $user_img =  COMMON_IMG;
                       }                     ?>
                    <img class="user-img" src="<?php echo $user_img; ?>" style="max-width: 100px;">
                    <h4><?= $getUserDetail->name;?></h4>
                    <!-- <p>{{ $user_data->city }}, {{ $user_data->country }}</p> -->
                </div>
            </div>
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#user-profile" data-toggle="tab">Profile Detail</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#user-address" data-toggle="tab">Address List</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="#user-payment" data-toggle="tab">Payment List</a>
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
                                                   <input class="form-control" id="disabledInput" type="text" value="<?= $getUserDetail->name;?>" placeholder="Name" disabled="">
                                                </fieldset>
                                            </div>
                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">DOB</label>
                                                   <input class="form-control" id="readOnlyInput" type="text" value="<?= $getUserDetail->dob;?>" placeholder="DOB" readonly="">
                                                </fieldset>
                                            </div>

                                            <!-- <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">Address</label>
                                                   <textarea class="form-control" id="readOnlyInput" placeholder="Address" readonly="" > {{ $user_data->address }} </textarea>
                                                </fieldset>
                                             </div> -->
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">Email</label>
                                                   <input class="form-control" id="readOnlyInput" type="text" value="<?= $getUserDetail->email;?>" placeholder="Email" readonly="">
                                                </fieldset>
                                            </div>
                                            <div class="form-group">
                                                <fieldset>
                                                   <label class="control-label" for="readOnlyInput">Language Knows</label>
                                                   <?php
                                                         if(!empty($getUserDetail->language_id))
                                                        {
                                                            $language_id = $getUserDetail->language_id;
                                                            
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

                <div class="tab-pane" id="user-address">
                    <div class="timeline-post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3>User Address : </h3>
                                    <div class="row">
                                        <?php $i = 0; foreach($getUserAddress as $k) {?>
                                            <div class="col-lg-6">
                                                <h5>Address <?php echo ++$i;?></h5> 
                                                <p>Address Name : <?= $k['address_name'];?> </p>
                                                <p>Location : <?= $k['user_location'];?> </p>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="user-payment">
                    <div class="timeline-post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3>User Payment Detail : </h3>
                                    <div class="row">
                                        <?php $i = 0; foreach($getUserPayment as $k) {?>
                                            <div class="col-lg-6">
                                                <h5>Payment Method <?php echo ++$i;?></h5> 

                                                <?php 
                                                    if($k['type'] == 1)
                                                    {
                                                        $type = 'Credit/Debit Card';
                                                    }else if($k['type'] == 2)
                                                    {
                                                        $type = 'Google Pay';
                                                    }else if($k['type'] == 3)
                                                    {
                                                        $type = 'Apple Pay';
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <fieldset disabled="">
                                                       <label class="control-label" for="disabledInput">Type</label>
                                                       <input class="form-control" id="disabledInput" type="text" value="<?= $type;?>" placeholder="Name" disabled="">
                                                    </fieldset>
                                                </div>
                                                <?php if($k['type'] == 1){ ?>
                                                    <input id='account' type="hidden" value='<?= $k['card_number'];?>'/>
                                                    <div class="form-group">
                                                        <fieldset disabled="">
                                                           <label class="control-label" for="disabledInput">Card Holder Name</label>
                                                           <input class="form-control" id="disabledInput" type="text" value="<?= $k['card_holder_name'];?>" placeholder="Name" disabled="">
                                                        </fieldset>
                                                    </div>
                                                    <div class="form-group">
                                                        <fieldset disabled="">
                                                           <label class="control-label" for="disabledInput">Card Number</label>
                                                           <input class="form-control" id="account_changed">
                                                        </fieldset>
                                                    </div>
                                                <?php }else{ ?>
                                                    <!-- <p>Email : <?= $k['email'];?></p> -->
                                                    <div class="form-group">
                                                        <fieldset disabled="">
                                                           <label class="control-label" for="disabledInput">Email</label>
                                                           <input class="form-control" id="" type="text"  value="<?= $k['email'];?>" placeholder="Card Number" disabled="">
                                                        </fieldset>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="tab-pane" id="user-address">
                    <div class="timeline-post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3>User Address : </h3>
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Qty</th>
                                                        <th>Ref. Booking ID</th>
                                                        <th>Note</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>#</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                </tbody>
                                           </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</main>