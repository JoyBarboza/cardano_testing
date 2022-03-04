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
            <a class="btn btn-primary icon-btn" href="<?php echo base_url('admin/add_nationality');?>"><i class="fa fa-plus"></i>Add Nationality	</a>
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <th>Nationality Name</th>
                     <th>Nationality Name in other language</th>
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllNationality as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $key['name']; ?></td>
                              <td><?php echo $key['other_language_name']; ?></td>
                              <td>
                                  <?php if($key['is_active'] == 1) { ?>
                                    <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Deactive')"> Active </button>
                                <?php } else { ?>
                                   <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Active')"> Deactive </button>
                                <?php }  ?>
                              </td>
                              <td class="center">
                                  <a class="btn btn-primary edit_category" title="edit" href="javascript:void(0);" data-name="<?php echo $key['name']; ?>" data-other_name="<?php echo $key['other_language_name']; ?>" data-nationality_id="<?php echo $key['id']; ?>"><i class="fa fa-pencil"></i></a>


                                 <a  title="Delete" href="<?php echo base_url().'admin/delete_nationality/'.base64_encode($key['id']);?>" onclick="return delteNationality()" class="btn btn-danger"><i class="fa fa-trash" ></i></a>
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
    


    


<!--Edit Category Modal  -->    
    <div id="editCategoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Nationality</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/update_nationality'?>" enctype="multipart/form-data">
                    <div class="modal-body">
                      <input type="hidden" name="nationality_id" id="nationality_id">
                    </div>

                    <div class="modal-body" style="padding: 0rem 1rem">
                      <div class="form-group col-12">
                       <input class="form-control" id="name" type="text" placeholder="Nationality Name" name="name" required data-parsley-required data-parsley-required-message="Enter Nationality Name">
                      </div>

                      <div class="form-group col-12">
                       <input class="form-control" id="other_name" type="text" placeholder="Other Nationality Name" name="other_name" required data-parsley-required data-parsley-required-message="Enter Other Nationality Name">
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
   function delteNationality(){
        var result = confirm("Are sure delete this Nationality?");
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
        var nationality_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this Nationality")){
            $.ajax({
                url: '<?php echo site_url("admin/status_nationality"); ?>',
                type: "POST",
                data: {
                    "nationality_id" : nationality_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.nationality_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.nationality_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
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
        var nationality_id = $(this).data('nationality_id'); 
        var name = $(this).data('name'); 
        var other_name = $(this).data('other_name'); 
       


        $('#nationality_id').val(nationality_id);
        $('#name').val(name);
        $('#other_name').val(other_name);
        $('#editCategoryModal').modal('show');
    });
</script>
   



