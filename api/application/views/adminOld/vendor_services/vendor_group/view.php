    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/group');?>"> Group</a></li>
            <li class="breadcrumb-item"><?= $title;?> </li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
              <div class="col-lg-12">
                <form class="row" action="" enctype="multipart/form-data" method="post" data-parsley-validate="">
                  <div class="form-group col-md-6">
                    <label for="vendor_name">Vendor Name</label>
                    <input class="form-control" id="vendor_name" type="text" placeholder="Vendor Name" name="vendor_name" value="<?=$groupDetail->vendor_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="group_name">Group Name</label>
                    <input class="form-control" id="group_name" type="text" placeholder="Group Name" name="group_name" value="<?=$groupDetail->group_name;?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="minimum_people">Minimum Amount of People</label>
                    <input class="form-control" id="minimum_people" type="text" placeholder="Minimum Amount of People" name="minimum_people" value="<?=$groupDetail->minimum_people;?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <?php if($groupDetail->group_method_type == 1){ 
                        $method_type="Discount Amount";
                      }else{
                        $method_type="Price Cut";
                      }
                    ?>
                    <label for="group_method_type">Method</label>
                    <input class="form-control" id="group_method_type" type="text" placeholder="Group Name" name="group_method_type" value="<?=$method_type;?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <?php if($groupDetail->group_method_type == 1){ $type="Discount Amount";?>
                        <label for="group_name">Discount Amount</label>
                    <?php }else{ $type="Price Cut Amount";?>
                        <label for="group_name">Price Cut Amount</label>
                    <?php }?>
                    
                    
                    <input class="form-control" id="price_discount" type="text" placeholder="<? echo $type; ?>" name="price_discount" value="<?=$groupDetail->price_discount;?>" readonly>
                  </div>
                   
    
                </form>
              </div>

               
            </div>

           
          <h3>Service in Package</h3>

            <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" >
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th></th>
                                    <th>Service Name</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                    $i = 1;

                                    $service_id = $groupDetail->service_id;
                                    // $plan_id = $getPlanDetail->id;
                                    $checked_arr = explode(",",$service_id);
                                    foreach ($getAllRegularService as $key => $value) { 
                                        $id = $value['id'];
                                        $status = in_array($id, $checked_arr);
                                        if(empty($status)){
                                             $status = "disabled";
                                        }else{
                                            $status = "checked='disabled'";
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                     <td>
                                         <input type="checkbox" id="html" value="1" name="client[]" <?=$status;?>>
                                     </td>
                                     <td><?php echo $value['service_name']; ?></td>
                                     <td><?php echo $value['durantion']; ?></td>
                                     <td><i class="fa fa-gbp" aria-hidden="true"></i> <?php echo $value['price']; ?></td>
                                </tr>
                                <?php $i++; }  ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;font-size: large;">
                                        <b>Usual Price</b>
                                    </td>
                                    <td>
                                        <i class="fa fa-gbp" aria-hidden="true"></i> <?=$groupDetail->usual_price;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: center;font-size: large;">
                                        <b>Group Price</b>
                                    </td>
                                    <td>
                                        <i class="fa fa-gbp" aria-hidden="true"></i> <?=$groupDetail->price;?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            
          </div>
        </div>
      </div>
    </main>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script type="text/javascript">
    
</script>