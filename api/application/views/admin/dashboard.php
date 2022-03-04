<main class="app-content">
    <div class="app-title">
        <div>
          <h1><?php echo $title;?></h1>
          <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <a href="<?php echo site_url('admin/employee');?>">
                    <div class="info">
                        <h4>Employee</h4>
                        <p><b><?= $employee->total?></b></p>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <a href="<?php echo site_url('admin/recuratare');?>">
                    <div class="info">
                        <h4>Recruiter</h4>
                        <p><b><?= $recuriter->total?></b></p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <a href="<?php echo site_url('admin/post_job');?>">
                    <div class="info">
                        <h4>Posted Job</h4>
                        <p><b><?= $jobpost->total?></b></p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <a href="<?php echo site_url('admin/resume');?>">
                    <div class="info">
                        <h4>Resume</h4>
                        <p><b><?= $resume->total?></b></p>
                    </div>
                </a>
            </div>
        </div>

        
    </div>

</main>
    