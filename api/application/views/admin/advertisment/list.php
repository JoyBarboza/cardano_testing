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
         
        <!--  <div class="col-md-12" style="text-align: right">-->
        <!--    <a class="btn btn-primary icon-btn" href="javascript:void(0);" data-toggle="modal" data-target="#addCategoryModal"><i class="fa fa-plus"></i>Add Category	</a>-->
        <!--</div> -->
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
                     <th>Validity</th>
                     <th>Data Access</th>
                     <th>Description</th>
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllAdvertisment as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $key['name']; ?></td>
                              <td>
                                  <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $key['price']; ?>
                              </td>
                              <td><?php echo $key['validity']; ?></td>
                              <td><?php echo $key['data_access']; ?></td>
                              <td><?php echo $key['description']; ?></td>
                              <td>
                                  <?php if($key['ads_status'] == 1) { ?>
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

                                  <a title="Edit" class="btn btn-primary edit_category" href="javascript:void(0);" data-ads_name="<?php echo $key['name']; ?>" data-price="<?php echo $key['price']; ?>" data-description="<?php echo $key['description']; ?>" data-ads_id="<?php echo $key['id']; ?>"  data-data_access="<?php echo $key['data_access']; ?>"  data-validity="<?php echo $v[0]; ?>"><i class="fa fa-pencil"></i></a>
                       <!--          <a  title="Delete" href="<?php echo base_url().'admin/delete_category/'.base64_encode($key['id']);?>" onclick="return delteCategory()" class="btn btn-danger"><i class="fa fa-trash" ></i></a>-->
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
    
    <!--<div id="addCategoryModal" class="modal fade" role="dialog">-->
    <!--    <div class="modal-dialog">-->
    <!--        <div class="modal-content">-->
    <!--            <div class="modal-header">-->
    <!--              <h4 class="modal-title">Add Category</h4>-->
    <!--            </div>-->
    <!--            <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/insert_category'?>" enctype="multipart/form-data">-->
    <!--                <div class="modal-body" style="padding: 0rem 1rem">-->
    <!--                  <div class="form-group col-12">-->
    <!--                   <input class="form-control" id="categoryname" type="text" placeholder="Category Name" name="category_name" required data-parsley-required data-parsley-required-message="Enter Category Name">-->
    <!--                  </div>-->

    <!--                  <div class="form-group col-12">-->
    <!--                   <input class="form-control" id="othercategoryname" type="text" placeholder="Other Category Name" name="other_category_name" required data-parsley-required data-parsley-required-message="Enter Other Category Name">-->
    <!--                  </div>-->

    <!--                 <div class="form-group col-12">-->
    <!--                      <label for="name">Select Image</label>-->
                          
    <!--                       <img width="100" id="img_add" name="slider_img">-->

    <!--                        <input type='file' name="image" id="imgadd" class="upload" required data-parsley-required data-parsley-required-message="Select Image"/>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--                <div class="modal-footer">-->
    <!--                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
    <!--                  <button type="submit" class="btn btn-primary">Add</button>-->
    <!--                </div>-->
    <!--            </form>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
<!--Edit Category Modal  -->    
    <div id="editCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Advertisment</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/update_advertisment'?>" enctype="multipart/form-data">
                    <div class="modal-body">
                      <input type="hidden" name="ads_id" id="ads_id">
                    </div>

                    <div class="modal-body" style="padding: 0rem 1rem">
                      <div class="form-group col-12">
                       <input class="form-control" id="ads_name" type="text" placeholder="Package Name" name="ads_name" required data-parsley-required data-parsley-required-message="Enter Package Name">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="price" type="text" placeholder="Price" name="price" required data-parsley-required data-parsley-required-message="Enter price">
                      </div>
                      
                      <div class="form-group col-12">
                       <input class="form-control" id="description" type="text" placeholder="Description" name="description" required data-parsley-required data-parsley-required-message="Enter description">
                      </div>
                      
                      <div class="form-group col-12">
                       <input class="form-control" id="data_access" type="text" placeholder="Data Access" name="data_access" required data-parsley-required data-parsley-required-message="Enter Data Access">
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
   function delteCategory(){
        var result = confirm("Are sure delete this Category?");
        if(result == true){
            return true;
        } 
        else{
            return false;
        }
    }

    //add image preview
    function read(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_add').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgadd").change(function(){
        read(this);
    }); 

     //edit image preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_tag').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function(){
        readURL(this);
    }); 
    
    function change_status(id,value)
    {
        var ads_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this advertisment")){
            $.ajax({
                url: '<?php echo site_url("admin/status_advertisment"); ?>',
                type: "POST",
                data: {
                    "ads_id" : ads_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.ads_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.ads_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
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
        var ads_id = $(this).data('ads_id'); 
        var ads_name = $(this).data('ads_name'); 
        var price = $(this).data('price'); 
        var description = $(this).data('description'); 
        var data_access = $(this).data('data_access'); 
        var validity = $(this).data('validity'); 

        $('#ads_id').val(ads_id);
        $('#ads_name').val(ads_name);
        $('#price').val(price);
        $('#description').val(description);
        $('#data_access').val(data_access);
        $('#validity').val(validity);

        $('#editCategoryModal').modal('show');
    });
</script>
   