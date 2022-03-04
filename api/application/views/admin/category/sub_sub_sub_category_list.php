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
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->subcategories_name?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Sub Category Name in other language</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->subcategories_other_name?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Sub Sub Category</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getSubCateogryData->name?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Sub Sub Category Name in other language</label>
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
                      <th>Sub SubCategory Name</th>
                   <?php }?>
                    
                     <th>Sub Sub Sub Category Name</th>
                     <th>Sub Sub Sub Category Name in other language</th>
                     <th>Image</th>
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        $i = 1;
                        foreach ($getAllSubSubSubCategory as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                            <?php if (empty(base64_decode($this->uri->segment(3)))){?>
                              <td><?php echo $key['categories_name']; ?></td>
                              <td><?php echo $key['subcategories_name']; ?></td>
                              <td><?php echo $key['subsubcategories_name']; ?></td>
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
                                  <a title="Edit" class="btn btn-primary edit_subsubcategory" href="javascript:void(0);" data-categories_name="<?php echo $key['categories_name']; ?>" data-subcategories_name="<?php echo $key['subcategories_name']; ?>" data-subsubcategories_name="<?php echo $key['subsubcategories_name']; ?>"  data-sub_subcategory_id="<?php echo $key['sub_subcategory_id']; ?>" data-subsubsubcategory_name="<?php echo $key['name']; ?>" data-other_subsubsubcategory_name="<?php echo $key['other_language_name']; ?>" 
                                   data-image="<?php echo $key['image']; ?>" data-subsubsubcategory_id="<?php echo $key['id']; ?>"><i class="fa fa-pencil"></i></a>
                                 <a  title="Delete" href="<?php echo base_url().'admin/delteSubSubSubCategory/'.base64_encode($key['id']);?>" onclick="return delteSubSubSubCategory()" class="btn btn-danger"><i class="fa fa-trash" ></i></a>

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
                  <h4 class="modal-title">Add Sub Sub Sub Category</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/insert_subsubsubcategory'?>" enctype="multipart/form-data">
                    <div class="modal-body" style="padding: 0rem 1rem">

                      <div class="form-group col-12">
                            <!-- <label for="name">Category Name</label> -->
                             <select class="form-control" data-live-search="true" name="category_id" id="" required data-parsley-required data-parsley-required-message="Select Category" onchange="getSubCategory(this.value);">
                              <option value="">Select Category Name</option>
                           <?php foreach ($getAllCategory as $key) {  ?>
                           <option data-tokens="<?php echo $key['id']; ?>" value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
                           <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-12">
                         <select class="form-control" id="sub_cateogry_id" data-live-search="true" name="sub_cateogry_id" required data-parsley-required data-parsley-required-message="Select Sub Category" onchange="getSubSubCategory(this.value);">
                          <!-- <option value=""></option> -->
                      </select>
                      </div>

                      <div class="form-group col-12">
                         <select class="form-control" id="sub_sub_cateogry_id" data-live-search="true" name="sub_sub_cateogry_id" required data-parsley-required data-parsley-required-message="Select Sub Sub Category">
                          <!-- <option value=""></option> -->
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
                  <h4 class="modal-title">Edit Sub Sub Sub Category</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/update_subsubsubcategory'?>" enctype="multipart/form-data">
                    <div class="modal-body" style="padding: 0rem 1rem">
                       <input type="hidden" name="subsubsubcategory_id" id="subsubsubcategory_id" value="">

                       <div class="form-group col-12">
                       <input class="form-control" id="categoriesname" type="text" placeholder="Sub Category Name" name="categoriesname" required data-parsley-required data-parsley-required-message="Enter Subcategory Name" readonly="">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="subcategoriesname" type="text" placeholder="Sub Category Other Language Name" name="subcategoriesname" required data-parsley-required data-parsley-required-message="Enter Subcategory Name in other language" readonly="">
                      </div>
                     
                      <div class="form-group col-12">
                       <input class="form-control" id="subsubcategoriesname" type="text" placeholder="Sub Category Name" name="subsubcategoriesname" required data-parsley-required data-parsley-required-message="Enter Subcategory Name" readonly="">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="subsubsubcategory_name" type="text" placeholder="Sub Sub Sub category Name" name="name" required data-parsley-required data-parsley-required-message="Enter Sub Sub Sub category Name in other language">
                      </div>
                      <div class="form-group col-12">
                       <input class="form-control" id="othersubsubsubcategory_name" type="text" placeholder="Sub Sub Sub category Other Language Name" name="other_language_name" required data-parsley-required data-parsley-required-message="Enter Sub Sub Sub category Name in other language">
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
   function delteSubSubSubCategory(){
        var result = confirm("Are sure delete this Sub Sub Sub Category?");
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
        var subsubsubcategory_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this Sub Sub Sub Category")){
            $.ajax({
                url: '<?php echo site_url("admin/status_subsubsubcategory"); ?>',
                type: "POST",
                data: {
                    "subsubsubcategory_id" : subsubsubcategory_id
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

  function getSubCategory(category_id)
    {
        $.ajax({
            url: '<?php echo site_url("admin/SubSubSubCategoryController/getSubCategory"); ?>',
            type: "POST",
            data: {
                "category_id" : category_id
            },
            success: function (response) 
            {
                // console.log(response);
                if (response == '0') {
                    $('#sub_cateogry_id').html('<option value="0">No Sub Cateogry</option>');
                } else {
                    var obj = JSON.parse(response);
                    // console.log(obj.length);
                    var html = '<option>Sub Cateogry</option>';
                    for(var i=0; i<obj.length; i++){
                        // html += '<option  data-tokens="'+obj[i]['category_id']+'" value="'+obj[i]['category_id']+'">'+obj[i]['category_name']+'</option>'

                        var value = obj[i]['id'];
                        // html += '<option  data-tokens="'+obj[i]['id']+'" value="'+value+'">'+obj[i]['name']+'</option>'
                        html += '<option  data-tokens="'+obj[i]['id']+'" value="'+value+'">'+obj[i]['name']+'</option>'
                    }
                    console.log(html);
                    $('#sub_cateogry_id').html(html);
                }
            }
        });
    }

     function getSubSubCategory(subcategory_id)
    {
        $.ajax({
            url: '<?php echo site_url("admin/SubSubSubCategoryController/getSubSubCategory"); ?>',
            type: "POST",
            data: {
                "subcategory_id" : subcategory_id
            },
            success: function (response) 
            {
                console.log(response);
                if (response == '0') {
                    $('#sub_sub_cateogry_id').html('<option value="0">No Sub Sub Cateogry</option>');
                } else {
                    var obj = JSON.parse(response);
                    // console.log(obj.length);
                    var html = '<option>Sub Sub Cateogry</option>';
                    for(var i=0; i<obj.length; i++){
                        // html += '<option  data-tokens="'+obj[i]['category_id']+'" value="'+obj[i]['category_id']+'">'+obj[i]['category_name']+'</option>'

                        var value = obj[i]['id'];
                        // html += '<option  data-tokens="'+obj[i]['id']+'" value="'+value+'">'+obj[i]['name']+'</option>'
                        html += '<option  data-tokens="'+obj[i]['id']+'" value="'+value+'">'+obj[i]['name']+'</option>'
                    }
                    console.log(html);
                    $('#sub_sub_cateogry_id').html(html);
                }
            }
        });
    }

    $(document).on('click','.edit_subsubcategory', function() { 

        var categories_name = $(this).data('categories_name'); 
        var subcategories_name = $(this).data('subcategories_name'); 
        var subsubcategories_name = $(this).data('subsubcategories_name'); 
        var sub_subcategory_id = $(this).data('sub_subcategory_id'); 
        var subsubsubcategory_name = $(this).data('subsubsubcategory_name'); 
        var other_subsubsubcategory_name = $(this).data('other_subsubsubcategory_name'); 
        var subsubsubcategory_id = $(this).data('subsubsubcategory_id'); 

        var img = $(this).data('image'); 
         
         var base_url = "<?= base_url('uploads/category/') ?>";

        // var base_url = <?php echo base_url();?>;
         var image = base_url+img;

         $('#categoriesname').val(categories_name);
         $('#subcategoriesname').val(subcategories_name);
        $('#subsubcategoriesname').val(subsubcategories_name);
        // $('#sub_subcategory_id').val(sub_subcategory_id);
        $('#subsubsubcategory_name').val(subsubsubcategory_name);
        $('#othersubsubsubcategory_name').val(other_subsubsubcategory_name);
        $('#subsubsubcategory_id').val(subsubsubcategory_id);

        

        $('#img_tag').attr("src",image);

        $('#editSubCategoryModal').modal('show');
    });
</script>
   


                              
                              
                             <!--  subsubsubcategory_id
categoriesname
subcategoriesname
subsubcategoriesname
subsubsubcategory_name
othersubsubsubcategory_name -->
                              