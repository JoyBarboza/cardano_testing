<main class="app-content">
    <div class="app-title">
        <div>
          <h1><?php echo $title;?></h1>
          <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <a href="<?php echo site_url('admin/user');?>">
                    <div class="info">
                        <h4>User</h4>
                        <p><b><?= $user->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <a href="<?php echo site_url('admin/vendor');?>">
                    <div class="info">
                        <h4>Vendor</h4>
                        <p><b><?= $vendor->total?></b></p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <a href="<?php echo site_url('admin/regular_service');?>">
                    <div class="info">
                        <h4>Vendor Regular Service</h4>
                        <p><b><?= $vendor_regular_service->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <a href="<?php echo site_url('admin/package');?>">
                    <div class="info">
                        <h4>Vendor Packages</h4>
                        <p><b><?= $vendor_packages->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <a href="<?php echo site_url('admin/subscription');?>">
                    <div class="info">
                        <h4>Vendor Subscription</h4>
                        <p><b><?= $vendor_subscription->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <a href="<?php echo site_url('admin/group');?>">
                    <div class="info">
                        <h4>Vendor Group</h4>
                        <p><b><?= $vendor_group->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <a href="<?php echo site_url('admin/offer_loyalty');?>">
                    <div class="info">
                        <h4>Vendor Offer/Loyalty</h4>
                        <p><b><?= $vendor_offers_loyalty->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <a href="<?php echo site_url('admin/booking');?>">
                    <div class="info">
                        <h4>Booking</h4>
                        <p><b><?= $booking->total?></b></p>
                    </div>
                </a>
            </div>
        </div>

        
    </div>

</main>
    