    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/offer_loyalty');?>"> Offers/Loyalty</a></li>
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
                    <input class="form-control" id="vendor_name" type="text" placeholder="Vendor Name" name="vendor_name" value="<?=$offerLoyaltyDetail->vendor_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="group_name">Offer Name</label>
                    <input class="form-control" id="name_offer" type="text" placeholder="Offer Name" name="name_offer" value="<?=$offerLoyaltyDetail->name_offer;?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="amout_discount">Amount of Discount</label>
                    <input class="form-control" id="amout_discount" type="text" placeholder="Amount of Discount" name="amout_discount" value="<?=$offerLoyaltyDetail->amout_discount;?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <?php if($offerLoyaltyDetail->type== 1){ 
                        $type="Offer";
                      }else{
                        $type="Loyalty";
                      }
                    ?>
                    <label for="group_method_type">Type</label>
                    <input class="form-control" id="group_method_type" type="text" placeholder="Type" name="type" value="<?=$type;?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="offer_period">Offer Period</label>
                    <input class="form-control" id="offer_period" type="text" placeholder="Offer Period" name="offer_period" value="<?=$offerLoyaltyDetail->offer_period;?>" readonly>
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

                                    $service_id = $offerLoyaltyDetail->service_id;
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
                                        <i class="fa fa-gbp" aria-hidden="true"></i> <?=$offerLoyaltyDetail->usual_price;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: center;font-size: large;">
                                        <b><?=$type;?> Price</b>
                                    </td>
                                    <td>
                                        <i class="fa fa-gbp" aria-hidden="true"></i> <?=$offerLoyaltyDetail->price;?>
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