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
                     <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($allBannerStatus as $key) { 
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
                              <td>
                                  <?php if($key['status'] == 1) { ?>
                                    <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Hide')"> Show </button>
                                <?php } else { ?>
                                   <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$key['id']?>')" onclick="change_status('<?=$key['id']?>','Show')"> Hide </button>
                                <?php }  ?>
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
 

    
    function change_status(id,value)
    {
        var banner_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this banner status")){
            $.ajax({
                url: '<?php echo site_url("admin/cms/change_banner_status"); ?>',
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
