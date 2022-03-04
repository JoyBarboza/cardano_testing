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
            <!-- <a class="btn btn-primary icon-btn" href="<?php echo base_url('admin/add_university');?>"><i class="fa fa-plus"></i>Add University	</a> -->

            <a class="btn btn-primary icon-btn" href="javascript:void(0);" data-toggle="modal" data-target="#addPromodeModal"><i class="fa fa-plus"></i>Add Banner</a>
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <th>User Type</th>
                     <th>Slider Image</th>
                     <!-- <th>University Name in other language</th> -->
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllBanner as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td>
                                <?php 

                                    if($key['user_type'] == 1){
                                      echo "Employee"; 
                                    }else{
                                      echo "Recruiter"; 
                                    }
                                ?>
                                
                              </td>
                              <td><img src="<?php echo base_url().'uploads/banner/'.$key['image']; ?>" width="150px" height="150px"></td>
                              <!-- <td><?php echo $key['other_language_name']; ?></td> -->
                              <td>
                                  <?php if($key['status'] == 1) { ?>
                                    <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Deactive')"> Active </button>
                                <?php } else { ?>
                                   <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Active')"> Deactive </button>
                                <?php }  ?>
                              </td>
                              <td class="center">
                                 
                                  <a class="btn btn-primary edit_category" title="edit" href="javascript:void(0);" data-id="<?php echo $key['id']; ?>" data-image="<?php echo $key['image']; ?>" data-user_type="<?php echo $key['user_type']; ?>"><i class="fa fa-pencil"></i></a>


                                 <a  title="Delete" href="<?php echo base_url().'admin/delete_banner/'.base64_encode($key['id']);?>" onclick="return delteUniversity()" class="btn btn-danger"><i class="fa fa-trash" ></i></a>
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
    
    <div id="addPromodeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Banner</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/insert_banner'?>"  enctype="multipart/form-data">
                    <div class="modal-body">
                    </div>
                    <div class="form-group col-12">
                            <!-- <label for="name">Category Name</label> -->
                             <select class="form-control" data-live-search="true" name="user_type" id="" required data-parsley-required data-parsley-required-message="Select User Type">
                              <option value="">Select User Type</option>
                           <option data-tokens="1" value="1" >Employee</option>
                           <option data-tokens="2" value="2" >Recruiter</option>
                        </select>
                      </div>
                    <div class="modal-body" style="padding: 0rem 1rem">
                       <div class="form-group col-12">
                            <label for="promo_code_desc">Image</label>
                            <br>
                            <img width="100" id="img_add" name="img">
                            <br>
                            <input type='file' name="doc_img" id="imgadd" class="upload" />
                            <br>
                            <span id="errmsg_file_type" style="color: red"></span>
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
                  <h4 class="modal-title">Edit Banner</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/update_banner'?>" enctype="multipart/form-data">
                    <div class="modal-body">
                      <input type="hidden" name="banner_id" id="banner_id">
                    </div>
                    <div class="form-group col-12">
                            <!-- <label for="name">Category Name</label> -->
                             <select class="form-control" data-live-search="true" name="user_type" id="user_type" required data-parsley-required data-parsley-required-message="Select User Type">
                              <option value="">Select User Type</option>
                           <option data-tokens="1" value="1" >Employee</option>
                           <option data-tokens="2" value="2" >Recruiter</option>
                        </select>
                      </div>

                     <div class="form-group col-12">
                            <label for="promo_code_desc">Image</label>
                            <br>
                            <img width="100" id="img_tag" name="img">
                            <br>
                            <input type='file' name="doc_img" id="imgInp" class="upload" />
                            <br>
                            <span id="errmsg_file_type" style="color: red"></span>
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
   function delteUniversity(){
        var result = confirm("Are sure delete this Banner?");
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
        var banner_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this banner")){
            $.ajax({
                url: '<?php echo site_url("admin/status_banner"); ?>',
                type: "POST",
                data: {
                    "banner_id" : banner_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.banner_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.banner_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
                    }
                    location.reload();
                }
            });
        }
    }


    $(document).ready(function() {
        $('#example').DataTable( 
        // {
        //     dom: 'Bfrtip',
        //     buttons: [
        //             {
        //                 extend: 'pdfHtml5',
        //                 orientation: 'landscape',
        //                 pageSize: 'LEGAL',
        //                 columns: ':visible',
        //                 exportOptions: {                    
        //                     columns: [0,1]                
        //                 },
     
        //             },
        //             {
        //                 extend: 'excel',
        //                 orientation: 'landscape',
        //                 pageSize: 'LEGAL',
        //                 columns: ':visible',
        //                  exportOptions: {                    
        //                     columns: [0,1]                
        //                 },
        //              },
        //             {
        //                 extend: 'print',
        //                 orientation: 'landscape',
        //                 pageSize: 'LEGAL',
        //                 columns: ':visible',
        //                  exportOptions: {                    
        //                     columns: [0,1]                
        //                 },
        //              },

        //         ],
        // }
        );
    });
    


    // -------------Add Image Preview------------------------------
   // function read(input) {
   //      if (input.files && input.files[0]) {
   //          var reader = new FileReader();
   //          reader.onload = function (e) {
   //              $('#img_add').attr('src', e.target.result);
   //          }
   //          reader.readAsDataURL(input.files[0]);
   //      }
   //  }
   //  $("#imgadd").change(function(){
   //      read(this);
   //  }); 
    //---------------Check Image Type ------------------
    var fileNode = document.querySelector('#imgadd');
        fileNode.addEventListener('change', function( event ) 
        {
            // alert('hi');
            var reader = new FileReader();

            reader.onload = function() {
                $('#img_add').attr('src', e.target.result);
            }

            reader.readAsDataURL(event.target.files[0]);

            var form = new FormData();
            var xhr  = new XMLHttpRequest();
            var file = this.files[0];

            if ( ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'].indexOf(file.type) == -1 ) {
                 toastr.error("<?php echo $this->lang->line('file_type_not_allow'); ?>");
                $('#errmsg_file_type').html('<?php echo $this->lang->line('file_type_allow'); ?>');
                $('#imgadd').prop('required',true);
                 return false;
            }
            $('#errmsg_file_type').html('');
             $('#imgadd').prop('required',false);
        });



    $(document).on('click','.edit_category', function() { 
        var id = $(this).data('id'); 
        var user_type = $(this).data('user_type'); 
        
        var base_url = "<?php echo site_url('uploads/banner/');?>";

        var brandImage = $(this).data('image'); 
        var banner_img = base_url + brandImage;
         
        $('#banner_id').val(id);
        $('#user_type').val(user_type);
        // $('#brand_name').val(brandName);
        $('#img_tag').prop('src',banner_img);
        $('#editCategoryModal').modal('show');
    });
</script>
