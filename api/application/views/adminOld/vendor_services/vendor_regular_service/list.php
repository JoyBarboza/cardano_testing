 <main class="app-content">
      <div class="app-title">
        <div>
          <h1>
             <h1><?= $title;?></h1>
          </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <?php if (!empty(base64_decode($this->uri->segment(3)))){?>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/vendor_view/'.base64_encode($getVendorDetail->id));?>">Vendor view</a></li>
          <?php }?>
          <li class="breadcrumb-item"><?= $title;?> </li>
        </ul>
      </div>

        <?php if (!empty(base64_decode($this->uri->segment(3)))){?>
           <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="col-lg-12">
                    <form class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"> Name</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getVendorDetail->name;?>" placeholder="Name" disabled="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_name">DOB</label>
                            <input class="form-control" id="readOnlyInput" type="text" value="<?= $getVendorDetail->dob;?>" placeholder="DOB" readonly="">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="price">Email</label>
                            <input class="form-control" id="readOnlyInput" type="text" value="<?= $getVendorDetail->email;?>" placeholder="Email" readonly="">
                        </div>
                    </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <?php }?>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <?php if (empty(base64_decode($this->uri->segment(3)))){?>
                                <th>Vendor Name</th>
                            <?php }?>
                            <th>Category Name</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Available Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach ($getAllRegularService as $key => $value) { ?>
                           <tr>
                                <td><?php echo $i; ?></td>
                                <?php if (empty(base64_decode($this->uri->segment(3)))){?>
                                    <td><?php echo $value['vendor_name']; ?></td>
                                <?php }?>
                                <td><?php echo $value['category_name']; ?></td>
                                <td><?php echo $value['service_name']; ?></td>
                                <td>
                                    <i class="fa fa-gbp" aria-hidden="true"></i> <?php echo $value['price']; ?>
                                </td>
                                <td><?php echo $value['durantion']; ?></td>
                                <td>
                                    <?php if($value['available_status'] == 1){ ?>
                                        <span class="btn btn-success remove_effect">Available</span>
                                    <?php } elseif ($value['available_status'] == 0) { ?>
                                        <span class="btn btn-warning remove_effect">Not Available</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a  title="View" href="<?php echo base_url().'admin/regular_service_view/'.base64_encode($value['id']);?>" class="btn btn-primary edit_add"><i class="fa fa-eye"></i></a>
                                </td>
                                      
                           </tr>
                    <?php $i++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            // buttons: [
            //     'excel', 'pdf', 'print'
            // ],
            buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                        exportOptions: {                    
                            columns: [0,1, 2,3,4,5]                
                        },
     
                    },
                    // 'excel',
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1, 2,3,4,5]                
                        },
                     },
                     // 'print',
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1, 2,3,4,5]                
                        },
                     },

                ],
            
        });
    });
</script>
 <!-- Page specific javascripts-->
    <!-- Data table plugin-->
   
