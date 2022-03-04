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
            <!-- <a class="btn btn-primary icon-btn" href="javascript:void(0);" data-toggle="modal" data-target="#addCategoryModal"><i class="fa fa-plus"></i>Add Category	</a> -->
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <th>Category</th>
                     <!-- <th>Status</th>
                     <th>Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllCategory as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $key['category_name']; ?></td>
                              <!-- <td>
                                  <?php if($key['status'] == 1) { ?>
                                    <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Deactive')"> Active </button>
                                <?php } else { ?>
                                   <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Active')"> Deactive </button>
                                <?php }  ?>
                              </td> -->
                              <!--<?php if (!empty($key['icon'])) { ?>-->
                              <!--   <td><img src="<?php echo base_url().'uploads/category/'.$key['icon']; ?>" height="50px" width="100px"></td>-->
                              <!--<?php }else{ ?>-->
                              <!--   <td><img src="<?php echo base_url().'uploads/placeholder.png'; ?>" height="30px" width="30px"></td>-->
                              <!--<?php }?>-->
                              <!-- <td class="center">
                                  <a class="btn btn-primary edit_category" href="javascript:void(0);" data-category_name="<?php echo $key['category_name']; ?>" data-category_id="<?php echo $key['id']; ?>"><i class="fa fa-pencil"></i></a>
                                  <a  title="Delete" href="<?php echo base_url().'admin/CategoryController/delete_category/'.$key['id'];?>" onclick="return delteCategory()" class="btn btn-danger">
			                           <i class="fa fa-trash" ></i>
			                    </a>
                              </td> -->
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
                  <h4 class="modal-title">Add Category</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/CategoryController/insert_category'?>">
                    <div class="modal-body">
                    </div>
                    <div class="modal-body" style="padding: 0rem 1rem">
                      <input class="form-control mt-2" id="" type="text" placeholder="Category Name" name="category_name" required data-parsley-required data-parsley-required-message="Please Enter Category Name">
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
                  <h4 class="modal-title">Edit Category</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/CategoryController/update_category'?>">
                    <div class="modal-body">
                      <input type="hidden" name="category_id" id="category_id">
                    </div>
                    <!--<div class="modal-body" style="padding: 0rem 1rem"  <input class="form-control mt-2" id="category_name" type="text" placeholder="Category Name" name="category_name" required data-parsley-required data-parsley-required-message="Please Enter Category Name">-->
                    <!--</div>-->
                    
                    <div class="modal-body" style="padding: 0rem 1rem">
                      <input class="form-control mt-2" id="category_name" type="text" placeholder="Category Name" name="category_name" required data-parsley-required data-parsley-required-message="Please Enter Category Name">
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-primary">Update</button
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
    
    function change_status(id,value)
    {
        var category_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this Category")){
            $.ajax({
                url: '<?php echo site_url("admin/CategoryController/status_category"); ?>',
                type: "POST",
                data: {
                    "category_id" : category_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.user_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.user_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
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
        var categoryId = $(this).data('category_id'); 
        var categoryName = $(this).data('category_name'); 
         
        $('#category_id').val(categoryId);
        $('#category_name').val(categoryName);
        $('#editCategoryModal').modal('show');
    });
</script>
   
