    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/booking');?>"> Booking</a></li>
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
                    <label for="user_name">User Name</label>
                    <input class="form-control" id="user_name" type="text" placeholder="User Name" name="user_name" value="<?=$getBookingDetail->user_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="vendor_name">Vendor Name</label>
                    <input class="form-control" id="vendor_name" type="text" placeholder="Vendor Name" name="vendor_name" value="<?=$getBookingDetail->vendor_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="order_number">Order Number</label>
                    <input class="form-control" id="order_number" type="text" placeholder="Order Number" name="order_number" value="<?=$getBookingDetail->order_number;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="service_name">Service Name</label>
                    <input class="form-control" id="service_name" type="text" placeholder="Service Name" name="service_name" value="<?=$getBookingDetail->service_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="booking_date">Booking Date</label>
                    <input class="form-control" id="booking_date" type="text" placeholder="Booking Date" name="booking_date" value="<?=$getBookingDetail->booking_date;?>" readonly>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="appointmen_time">Booking Time</label>
                    <input class="form-control" id="appointmen_time" type="text" placeholder="Booking Time" name="appointmen_time" value="<?=$getBookingDetail->appointmen_time;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="duration_hour">Duration Hour</label>
                    <input class="form-control" id="duration_hour" type="text" placeholder="Duration Hour" name="duration_hour" value="<?=$getBookingDetail->duration_hour;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="no_person">Number of Person</label>
                    <input class="form-control" id="no_person" type="text" placeholder="Number of Person" name="no_person" value="<?=$getBookingDetail->no_person;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="total_service_fees">Total Serice Fees</label>
                    <input class="form-control" id="total_service_fees" type="text" placeholder="Total Serice Fees" name="total_service_fees" value="<?=$getBookingDetail->total_service_fees;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="travel_fees">Travel Fees</label>
                    <input class="form-control" id="travel_fees" type="text" placeholder="Travel Fees" name="travel_fees" value="<?=$getBookingDetail->travel_fees;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="total_booking_amount">Total Booking Amount</label>
                    <input class="form-control" id="total_booking_amount" type="text" placeholder="Vendor Name" name="total_booking_amount" value="<?=$getBookingDetail->total_booking_amount;?>" readonly>
                  </div>

                    <?php 
                      if($getBookingDetail->booking_status == 0){ 
                        $booking_status = 'Pending';
                      } elseif ($getBookingDetail->booking_status == 1) {
                        $booking_status = 'Vendor Accepted';
                      } elseif ($getBookingDetail->booking_status == 2) {
                        $booking_status =  'User Rejected';
                      } elseif ($getBookingDetail->booking_status == 3) {
                        $booking_status = 'User Cancel Booking';
                      } elseif ($getBookingDetail->booking_status == 4) { 
                        $booking_status = 'User Rebooking';
                      } elseif ($getBookingDetail->booking_status == 5) {
                        $booking_status = 'Completed';
                      }
                    ?>
                  <div class="form-group col-md-6">
                    <label for="booking_status">Booking Status</label>
                    <input class="form-control" id="booking_status" type="text" placeholder="Booking Status" name="booking_status" value="<?=$booking_status;?>" readonly>
                  </div>

                  

                </form>
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