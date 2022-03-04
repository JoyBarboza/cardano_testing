<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $title?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><?= $title?></li>
        </ul>
    </div>

    <div class="row">
        <div id="msg"></div>
        <!-- <div class="col-md-12" style="text-align: right">
            <a class="btn btn-primary icon-btn" href="<?php echo site_url('admin/user_add');?>"><i class="fa fa-plus"></i>Add User	</a>
        </div>   -->
        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th> Name</th>
                                    <!-- <th> Profile Image</th> -->
                                    <th>Email-Id</th>
                                    <th>Mobile Number</th>
                                    <!-- <th>Date of Birth</th> -->
                                    <!-- <th>Language Know</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    if(!empty($getAllEmployee)){
                                        foreach ($getAllEmployee as $key => $value) { 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                     <td>

                                        <?php 
                                            if(!empty($value['name'])){
                                                echo $value['name'];
                                            }else{
                                                echo "Not added";
                                            }
                                        ?>
                                     </td>
                                     <td><?=$value['email']?></td>
                                     <td><?=$value['mobile_number']?></td>
                                     <!-- <td><?=$value['dob']?></td> -->
                                     <!-- <td> </td> -->
                                    <td>
                                        <?php if($value['status'] == 1) { ?>
                                            <button title="Change Status" class="btn-success  btn btn-sm" value="('<?=$value['id']?>')" onclick="change_status('<?=$value['id']?>','Deactive')"> Active </button>
                                        <?php } else { ?>
                                           <button  title="Change Status" type="button" id="button" class="btn-info btn btn-sm " value="('<?=$value['id']?>')" onclick="change_status('<?=$value['id']?>','Active')"> Deactive </button>
                                        <?php }  ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" title="Sub Category" href="<?php echo base_url().'admin/resume/'.base64_encode($value['id']);?>">Resume Posted</a>

                                        <a  title="Delete" href="<?php echo base_url().'admin/employee_delete/'.base64_encode($value['id']);?>" onclick="return deleteEmployee()" class="btn btn-danger">
					                           <i class="fa fa-trash" ></i>
					                    </a>

                                    </td>
                                </tr>
                                <?php $i++; } }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">

	function deleteEmployee(){
        var result = confirm("Are sure delete this employee ?");
        if(result == true){
            return true;
        } 
        else{
            return false;
        }
    }  

    function change_status(id,value)
    {
        var employee_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this employee")){
            $.ajax({
                url: '<?php echo site_url("admin/employee/status"); ?>',
                type: "POST",
                data: {
                    "employee_id" : employee_id
                },
                success: function(response) { 
                    var data = response;
                    // console.log(data);
                    if(data.status == 1)
                    {
                        $('#change_status_'+data.employee_id).removeClass("btn-info").addClass('btn-success').text('Active')
                    }
                    else 
                    {

                        $('#change_status_'+data.employee_id).removeClass("btn-success").addClass('btn-info').text('Deactive')
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
                            columns: [0,1,3,4,5,6]                
                        },
     
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,3,4,5,6]                
                        },
                     },
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,3,4,5,6]                
                        },
                     },
                ],
        });
    });
</script>

   
