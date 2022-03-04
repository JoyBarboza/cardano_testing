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
      <?php if (!empty(base64_decode($this->uri->segment(3)))){?>
           <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="col-lg-12">
                    <form class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"> Category</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->categories_name?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"> Category Name in other language</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->categories_other_name?>" placeholder="Name" disabled="">
                        </div>


                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Sub Category</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->name?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Sub Category Name in other language</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->other_language_name?>" placeholder="Name" disabled="">
                        </div>
                    </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <?php }?>
      <div class="row">
         <div id="msg"></div>
         
          <div class="col-md-12" style="text-align: right">
            <a class="btn btn-primary icon-btn" href="javascript:void(0);" data-toggle="modal" data-target="#addSubSubCategoryModal"><i class="fa fa-plus"></i>Add Sub Sub Category	</a>
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <?php if (empty(base64_decode($this->uri->segment(3)))){?>
                     <th>Category Name</th>
                     <th>Sub Category Name</th>
                   <?php }?>
                     <th>Sub SubCategory Name</th>
                     <th>Sub SubCategory Name in other language</th>
                     <th>Image</th>
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllSubSubCategory as $key) { 

                          // print_r($key->name);die;
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                            <?php if (empty(base64_decode($this->uri->segment(3)))){?>
                              <td><?php echo $key['categories_name']; ?></td>
                              <td><?php echo $key['subcategories_name']; ?></td>
                            <?php }?>
                              <td><?php echo $key['name']; ?></td>
                              <td><?php echo $key['other_language_name']; ?></td>
                              </td> 
                              <?php if (!empty($key['image'])) { ?>
                                 <td><img src="<?php echo base_url().'uploads/category/'.$key['image']; ?>" height="50px" width="100px"></td>
                              <?php }else{ ?>
                                 <td><img src="<?php echo base_url().'uploads/placeholder.png'; ?>" height="30px" width="30px"></td>
                              <?php }?>
                              <td>
                                  <?php if($key['is_active'] == 1) { ?>
                                    <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Deactive')"> Active </button>
                                <?php } else { ?>
                                   <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Active')"> Deactive </button>
                                <?php }  ?>
                              </td>
                              <td class="center">
                                  <a class="btn btn-primary" title="Sub Sub Sub Category" href="<?php echo base_url().'admin/subsubsubcategory/'.base64_encode($key['id']);?>">Sub Sub Sub Category</a>
                                  <a title="Edit" class="btn btn-primary edit_subsubcategory" href="javascript:void(0);" data-subcategory_id="<?php echo $key['subcategory_id']; ?>" data-subsubcategory_name="<?php echo $key['name']; ?>" data-other_subsubcategory_name="<?php echo $key['other_language_name']; ?>" 
                                   data-image="<?php echo $key['image']; ?>" data-subsubcategory_id="<?php echo $key['id']; ?>"><i class="fa fa-pencil"></i></a>
                                 <a  title="Delete" href="<?php echo base_url().'admin/delteSubSubCategory/'.base64_encode($key['id']);?>" onclick="return delteSubSubCategory()" class="btn btn-danger"><i class="fa fa-trash" ></i></a>

			                    </a>
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
    
    <div id="addSubSubCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Sub Sub Category</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/insert_subsubcategory'?>" enctype="multipart/form-data">
                    <div class="modal-body" style="padding: 0rem 1rem">

                      <div class="form-group col-12">
                            <!-- <label for="name">Category Name</label> -->
                             <select class="form-control" data-live-search="true" name="subcategory_id" id="" required data-parsley-required data-parsley-required-message="Select Category">
                              <option value="">Select Sub Category Name</option>
                           <?php foreach ($allSubCateogry as $key) {  ?>
                           <option data-tokens="<?php echo $key->id; ?>" value="<?php echo $key->id; ?>" ><?php echo $key->name; ?></option>
                           <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="" type="text" placeholder="Sub Category Name" name="name" required data-parsley-required data-parsley-required-message="Enter Subcategory Name">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="" type="text" placeholder="Sub Category Other Language Name" name="other_language_name" required data-parsley-required data-parsley-required-message="Enter Subcategory Name in other language">
                      </div>

                     <div class="form-group col-12">
                          <label for="name">Select Image</label>
                          
                           <img width="100" id="img_add" name="slider_img">

                            <input type='file' name="image" id="imgadd" class="upload" required data-parsley-required data-parsley-required-message="Select Image"/>
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
    <div id="editSubCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Sub Sub Category</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/update_subsubcategory'?>" enctype="multipart/form-data">
                    <div class="modal-body" style="padding: 0rem 1rem">
                       <input type="hidden" name="subsubcategory_id" id="subsubcategory_id" value="">

                      <div class="form-group col-12">
                            <!-- <label for="name">Category Name</label> -->
                             <select class="form-control" data-live-search="true" name="subcategory_id" id="subcategory_id" required data-parsley-required data-parsley-required-message="Select Category">
                              <option value="">Select Sub Category Name</option>
                           <?php foreach ($allSubCateogry as $key) {  ?>
                           <option data-tokens="<?php echo $key->id; ?>" value="<?php echo $key->id; ?>" ><?php echo $key->name; ?></option>
                           <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="subsubcategory_name" type="text" placeholder="Sub Category Name" name="name" required data-parsley-required data-parsley-required-message="Enter Subcategory Name">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="other_subsubcategory_name" type="text" placeholder="Sub Category Other Language Name" name="other_language_name" required data-parsley-required data-parsley-required-message="Enter Subcategory Name in other language">
                      </div>
                     <div class="form-group col-12">
                          <label for="name">Select Image</label>
                          
                             <img width="100" id="img_tag" name="image">
                      <input type='file' name="image" id="imgInp" class="upload" />
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
   function delteSubSubCategory(){
        var result = confirm("Are sure delete this Sub Sub Category?");
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
        var subsubcategory_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this Sub Sub Category")){
            $.ajax({
                url: '<?php echo site_url("admin/status_subsubcategory"); ?>',
                type: "POST",
                data: {
                    "subsubcategory_id" : subsubcategory_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.subsubcategory_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.subsubcategory_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
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
    
    $(document).on('click','.edit_subsubcategory', function() { 

        var subcategory_id = $(this).data('subcategory_id'); 
        var subsubcategory_name = $(this).data('subsubcategory_name'); 
        var other_subsubcategory_name = $(this).data('other_subsubcategory_name'); 
        var subsubcategory_id = $(this).data('subsubcategory_id'); 

        var img = $(this).data('image'); 
         
         var base_url = "<?= base_url('uploads/category/') ?>";

        // var base_url = <?php echo base_url();?>;
         var image = base_url+img;

         $('#subsubcategory_id').val(subsubcategory_id);
         $('#subcategory_id').val(subcategory_id);
        $('#subsubcategory_name').val(subsubcategory_name);
        $('#other_subsubcategory_name').val(other_subsubcategory_name);

        

        $('#img_tag').attr("src",image);

        $('#editSubCategoryModal').modal('show');
    });
</script>
   


                              
                              
                              