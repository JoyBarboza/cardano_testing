<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $title?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/vendor/plan');?>">Vendor Plan</a></li>
            <li class="breadcrumb-item"><?= $title?></li>
        </ul>
    </div>

    <div class="row">
        <div id="msg"></div>
        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" >
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th></th>
                                    <th> Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    $plan_feature_id = $getPlanDetail->feature_id;
                                    $plan_id = $getPlanDetail->id;
                                    $checked_arr = explode(",",$plan_feature_id);
                                    if(!empty($getPlanFeature)){

                                        foreach ($getPlanFeature as $key => $value) { 
                                        	$id = $value['id'];
                                        	$status = in_array($id, $checked_arr);
							        	    if(empty($status)){
							        	         $status = "disabled";
							        	    }else{
							        	        $status = "checked='disabled'";
							        	    }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                     <td>
                                     	 <input type="checkbox" id="html" value="1" name="client[]" <?=$status;?>>
                                     </td>
                                     <td><?=$value['feature_name']?></td>
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

   
