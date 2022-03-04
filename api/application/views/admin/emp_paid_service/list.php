 <main class="app-content">
      <div class="app-title">
        <div>
          <h1>
            <!-- <i class="fa fa-th-list"></i> -->
             <?= $title;?>
          </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><?= $title;?></li>
        </ul>
      </div>
      <div class="row">
         <div id="msg"></div>
         
          <div class="col-md-12" style="text-align: right">
            <a class="btn btn-primary icon-btn" href="javascript:void(0);" data-toggle="modal" data-target="#addCategoryModal"><i class="fa fa-plus"></i>Add Paid Service	</a>
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <th>Name</th>
                     <th>Price</th>
                     <th>GST</th>
                     <th>Description</th>
                     <th>Validity</th>
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllPackage as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $key['name']; ?></td>
                              <td><?php echo $key['price']; ?></td>
                              <td><?php echo $key['gst']; ?></td>
                              <td><?php echo $key['data_access']; ?></td>
                              <td><?php echo $key['validity']; ?></td>
                              <td>
                                  <?php if($key['package_status'] == 1) { ?>
                                    <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Deactive')"> Active </button>
                                <?php } else { ?>
                                   <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Active')"> Deactive </button>
                                <?php }  ?>
                              </td>
                              <td class="center">
                                   <?php 
                                       $validity =  $key['validity'];
                                       $v = explode(" ",$validity);
                                   ?>

                                  <a title="Edit" class="btn btn-primary edit_category" href="javascript:void(0);" data-package_name="<?php echo $key['name']; ?>" data-price="<?php echo $key['price']; ?>" data-gst="<?php echo $key['gst']; ?>" data-package_id="<?php echo $key['id']; ?>"  data-data_access="<?php echo $key['data_access']; ?>"  data-validity="<?php echo $v[0]; ?>"><i class="fa fa-pencil"></i></a>
                                 <a  title="Delete" href="<?php echo base_url().'admin/delete_paid_service/'.base64_encode($key['id']);?>" onclick="return delteServicePaid()" class="btn btn-danger"><i class="fa fa-trash" ></i></a>
			                    <!--</a>-->
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
    
    <div id="addCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Paid Service</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/add_paid_service'?>" enctype="multipart/form-data">
                    <div class="modal-body" style="padding: 0rem 1rem">
                      <div class="form-group col-12">
                       <input class="form-control" id="" type="text" placeholder="Service Name" name="package_name" required data-parsley-required data-parsley-required-message="Enter Service Name">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="" type="text" placeholder="Price" name="price" required data-parsley-required data-parsley-required-message="Enter price">
                      </div>
                      
                      <div class="form-group col-12">
                       <input class="form-control" id="" type="text" placeholder="GST" name="gst" required data-parsley-required data-parsley-required-message="Enter GST" readonly value="GST">
                      </div>
                      
                      <div class="form-group col-12">
                       <!-- <input class="form-control" id="data_access" type="text" placeholder="Data Access" name="data_access" required data-parsley-required data-parsley-required-message="Enter Data Access" data-parsley-type="number" data-parsley-required-message="Only number allows"  min="1" > -->
                       <textarea class="form-control" id="" type="text"  name="data_access" required data-parsley-required data-parsley-required-message="Enter description"></textarea>
                      </div>
                      
                      <div class="form-group col-12">
                       <input class="form-control" id="" type="text" placeholder="Validity" name="validity" required data-parsley-required data-parsley-required-message="Enter Validity" data-parsley-type="number" data-parsley-required-message="Only number allows"  min="1" >
                      </div>

                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--Edit Category Modal  -->    
    <div id="editCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Package</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/update_paid_service'?>" enctype="multipart/form-data">
                    <div class="modal-body">
                      <input type="hidden" name="service_id" id="package_id">
                    </div>

                    <div class="modal-body" style="padding: 0rem 1rem">
                      <div class="form-group col-12">
                       <input class="form-control" id="package_name" type="text" placeholder="Service Name" name="package_name" required data-parsley-required data-parsley-required-message="Enter Service Name">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="price" type="text" placeholder="Price" name="price" required data-parsley-required data-parsley-required-message="Enter price">
                      </div>
                      
                      <!-- <div class="form-group col-12">
                       <input class="form-control" id="gst" type="text" placeholder="GST" name="gst" required data-parsley-required data-parsley-required-message="Enter GST" readonly>
                      </div> -->
                      
                      <div class="form-group col-12">
                       <!-- <input class="form-control" id="data_access" type="text" placeholder="Data Access" name="data_access" required data-parsley-required data-parsley-required-message="Enter Data Access" data-parsley-type="number" data-parsley-required-message="Only number allows"  min="1" > -->
                       <textarea class="form-control" id="data_access" type="text"  name="data_access" required data-parsley-required data-parsley-required-message="Enter description"></textarea>
                      </div>
                      
                      <div class="form-group col-12">
                       <input class="form-control" id="validity" type="text" placeholder="Validity" name="validity" required data-parsley-required data-parsley-required-message="Enter Validity" data-parsley-type="number" data-parsley-required-message="Only number allows"  min="1" >
                      </div>

                  </div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    </main>
<script type="text/javascript">
     function delteServicePaid(){
        var result = confirm("Are sure delete this paid service?");
        if(result == true){
            return true;
        } 
        else{
            return false;
        }
    }
  
    function change_status(id,value)
    {
        var service_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this service")){
            $.ajax({
                url: '<?php echo site_url("admin/status_paid_service"); ?>',
                type: "POST",
                data: {
                    "service_id" : service_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.service_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.service_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
                    }
                    location.reload();
                }
            });
        }
    }


    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                        exportOptions: {                    
                            columns: [0,1]                
                        },
     
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1]                
                        },
                     },
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1]                
                        },
                     },

                ],
        });
    });
    
    
    
    
    
    
    
    
    $(document).on('click','.edit_category', function() { 
        var package_id = $(this).data('package_id'); 
        var package_name = $(this).data('package_name'); 
        var price = $(this).data('price'); 
        var gst = $(this).data('gst'); 
        var data_access = $(this).data('data_access'); 
        var validity = $(this).data('validity'); 

        $('#package_id').val(package_id);
        $('#package_name').val(package_name);
        $('#price').val(price);
        $('#gst').val(gst);
        $('#data_access').val(data_access);
        $('#validity').val(validity);

        $('#editCategoryModal').modal('show');
    });
</script>
   