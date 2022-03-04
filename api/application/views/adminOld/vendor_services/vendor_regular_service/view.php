    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/regular_service');?>"> Regular Service</a></li>
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
                    <input class="form-control" id="vendor_name" type="text" placeholder="Vendor Name" name="vendor_name" value="<?=$regularServiceDetail->vendor_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="service_name">Service Name</label>
                    <input class="form-control" id="service_name" type="text" placeholder="Service Name" name="service_name" value="<?=$regularServiceDetail->service_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="category_name">Category Name</label>
                    <input class="form-control" id="category_name" type="text" placeholder="Category Name" name="category_name" value="<?=$regularServiceDetail->category_name;?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="price">Price</label>
                    <input class="form-control" id="price" type="text" placeholder="Price" name="price" value="<?=$regularServiceDetail->price;?>" readonly>
                  </div>
        
                 <div class="form-group col-md-6">
                    <label for="durantion">Duration</label>
                    <input class="form-control" id="durantion" type="text" placeholder="Duration" name="durantion" value="<?=$regularServiceDetail->durantion;?>" readonly>

                  </div>
                   <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description" placeholder="Description" readonly><?=$regularServiceDetail->description;?></textarea>
                    </div>
                    
                    
                   
                    <!--<div class="col-sm-12">-->
                    <!--    <button class="btn btn-primary" type="submit">Submit</button>-->
                    <!--</div>-->
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