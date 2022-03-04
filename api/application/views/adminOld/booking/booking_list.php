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
            <a class="btn btn-primary icon-btn" href="<?php echo site_url('admin/user_add');?>"><i class="fa fa-plus"></i>Add User  </a>
        </div>   -->
        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Order Number</th>
                                    <th>User Name</th>
                                    <th>Vendor Name</th>
                                    <th>Service Name</th>                                    
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    if(!empty($getAllBooking)){
                                        foreach ($getAllBooking as $key => $value) { 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                     <td><?=$value['order_number']?></td>
                                     <td><?=$value['user_name']?></td>
                                     <td><?=$value['vendor_name']?></td>
                                     <td><?=$value['service_name']?></td>
                                     <td>
                                         <?php if($value['booking_status'] == 0){ ?>
                                            <span class="btn btn-info remove_effect">Pending</span>
                                        <?php } elseif ($value['booking_status'] == 1) { ?>
                                            <span class="btn btn-success remove_effect">Vendor Accepted</span>
                                        <?php } elseif ($value['booking_status'] == 2) { ?>
                                            <span class="btn btn-danger remove_effect">Vendor Rejected</span>
                                        <?php } elseif ($value['booking_status'] == 3) { ?>
                                            <span class="btn btn-danger remove_effect">User Cancel Booking</span>
                                        <?php } elseif ($value['booking_status'] == 4) { ?>
                                            <span class="btn btn-info remove_effect">User Rebooking</span>
                                        <?php } elseif ($value['booking_status'] == 5) { ?>
                                            <span class="btn btn-success remove_effect">Completed</span>
                                        <?php } ?>
                                       
                                     </td>

                                    <td>
                                        <a  title="View" href="<?php echo base_url().'admin/booking_view/'.base64_encode($value['booking_id']);?>" class="btn btn-primary edit_add"><i class="fa fa-eye"></i></a>

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

  function deleteUser(){
        var result = confirm("Are sure delete this User ?");
        if(result == true){
            return true;
        } 
        else{
            return false;
        }
    }  

    function change_status(id,value)
    {
        var user_id = id;
            // alert(user_id);
        if(confirm("Are you sure want "+value+" this User")){
            $.ajax({
                url: '<?php echo site_url("admin/user/status"); ?>',
                type: "POST",
                data: {
                    "user_id" : user_id
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
                            columns: [0,1,3,4,5]                
                        },
     
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,3,4,5]                
                        },
                     },
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,3,4,5]                
                        },
                     },
                ],
        });
    });
</script>

   
