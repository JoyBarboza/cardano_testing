<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?=$title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><?=$title;?></li>
        </ul>
    </div>

    <div class="row">
        <div id="msg"></div>
            
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User Type</th>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    if(!empty($allContactUsList)){
                                        foreach ($allContactUsList as $key => $value) { 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                    	<?php 
	                                    	if($value['user_type'] == 1){
	                                    		echo "Employee"; 
	                                    	}elseif ($value ->user_type == 2) {
	                                    		echo "Recuratare"; 
	                                    	}
                                    	?>
                                    </td>
                                    <td><?php echo $value['full_name']; ?></td>
                                    <td><?php echo $value['email']; ?></td>
                                    <td><?php echo $value['message']; ?></td>
                                    
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
                            columns: [0,1,2,3,4]                
                        },
     
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,2,3,4]                
                        },
                     },
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,2,3,4]                
                        },
                     },

                ],
        });
    });
</script>
 <!-- Page specific javascripts-->
    <!-- Data table plugin-->
   
