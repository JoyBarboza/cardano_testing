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
        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Vendor Name</th>
                                    <th>Document</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    if(!empty($getAllVendorCriminalRecord)){
                                        foreach ($getAllVendorCriminalRecord as $key => $value) { 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                     <td><?=$value['vendor_name']?></td>
                                    </td>
                                    <td>
                                        <?php if(!empty($value['name']))
                                           {
                                             $criminal_doc = VENDOR_CRIMINAL.$value['name'];
                                           }
                                        ?>
                                        
                                        <a href="<?=$criminal_doc;?>" target="_blank">view</a>

                                    </td>
                                    <td><?=$value['comment']?></td>
                                    <td>
                                       <?php if($value['admin_approval'] == 1){ ?>
                                            <span class="btn btn-success remove_effect">Accepted By Admin</span>
                                        <?php } elseif ($value['admin_approval'] == 2) { ?>
                                            <span class="btn btn-danger remove_effect">Rejected By Admin</span>
                                        <?php }else{ ?>
                                            <span class="btn btn-warning remove_effect">Pending</span>
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php if($value['admin_approval'] == 1){ ?>
                                            <span class="btn btn-success remove_effect">Accepted By Admin</span>
                                        <?php } elseif ($value['admin_approval'] == 2) { ?>
                                            <span class="btn btn-danger remove_effect">Rejected By Admin</span>
                                        <?php }else{ ?>
                                             <!-- <a href="#"  class="btn btn-primary">Accept</a> -->
                                             <a href="#myModalAccept" data-toggle="modal" value="<?php echo $key['id'] ?>" class="btn btn-primary accept" data-id ="<?php echo $value['id'] ?>" data-vendor_id ="<?php echo $value['vendor_id'] ?>">Accept</a>

                                             <a href="#myModalReject" data-toggle="modal" value="<?php echo $key['id'] ?>" class="btn btn-danger rejected mt-1" data-id ="<?php echo $value['id'] ?>" data-vendor_id ="<?php echo $value['vendor_id'] ?>">Reject</a>
                                             <!-- <a href="#" class="btn btn-danger">Reject</a> -->
                                          <?php } ?>
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

    <!-- Modal for comment the status -->
    <div id="myModalAccept" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Message</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/criminal_record_approved'?>">
                    <div class="modal-body">
                      <input type="hidden" name="criminial_record_id" id="document_id">
                      <input type="hidden" name="vendor_id" id="vendorid">
                      <input type="hidden" name="admin_approval" id="document_status">
                      Are You Sure Want to approved this document?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                      <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for comment the status -->
    <div id="myModalReject" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Message</h4>
                </div>
                <form method="POST" data-parsley-validate action="<?php echo base_url().'admin/criminal_record_approved'?>">
                    <div class="modal-body">
                      <input type="hidden" name="criminial_record_id" id="documentId">
                      <input type="hidden" name="vendor_id" id="vendor_id">
                      <input type="hidden" name="admin_approval" id="documentStatus">
                      <center><strong>Are You Sure Want to Reject this Document? </strong></center>
                    </div>
                    <div class="modal-body" style="padding: 0rem 1rem">
                      <input class="form-control mt-2" id="admin_reason" type="text" placeholder="Comment" name="admin_reason" required data-parsley-required data-parsley-required-message="Please Enter Reason For Rejected">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                      <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">

	$(document).ready(function() {
    $(document).on('click','.accept', function() { 
          var term = $(this).data('id');
          var vendor_id = $(this).data('vendor_id'); 
          
          $('#document_id').val(term);
          $('#vendorid').val(vendor_id);
          $('#document_status').val(1);
    });
    $(document).on('click','.rejected', function() { 
          var term = $(this).data('id');
          var vendor_id = $(this).data('vendor_id'); 
          
          // alert(term);
          $('#documentId').val(term);
          $('#vendor_id').val(vendor_id);
          $('#documentStatus').val(2); 
    });
});

    $(document).ready(function() {
        $('#example').DataTable( {
        });
    });
</script>

   
