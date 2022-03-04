 <main class="app-content">
     <div class="app-title">
        <div>
          <h1><? echo $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('subadmin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><? echo $title;?> </li>
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
                            <th>Sender Type</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Message</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach ($notification_list as $key) { ?>
                           <tr>
                               <!-- 1=recuriter to employee,2=recuriter to admin,3=employee to recuriter,4=employee to admin,5=admin to employee,6=admin to recuriter -->
                                <td><?php echo $i; ?></td>
                                <td>
                                    <?php 
                                        if($key['msg_for'] == 2){
                                            echo "Recuriter to Admin";   
                                        }else if($key['msg_for'] == 4 ){
                                            echo "Employee to Admin";   
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        echo $key['user_name']; 
                                    ?>
                                </td>
                                <td><?php echo $key['title']; ?></td>
                                <td><?php echo $key['message']; ?></td>
                                <!-- <td></td> -->
                                
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
  $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            
        });
    });
  
   function delteFunction(val){
        if (confirm('Are you sure you want to delete this Sub Category?')) {
            $.ajax({
                url: '<?php echo site_url("admin/SubCategory/delete_sub_category"); ?>',
                type: "POST",
                data: {
                    "sub_category_id" : val
                },
                success: function (response) {
                    if (response == '1') {
                        setTimeout(function(){ 
                            $('#msg').html('<div class="alert alert-success"><strong>Sub Category!</strong> delete successful.</div>');
                        }, 3000);
                    } else {
                        setTimeout(function(){ 
                            $('#msg').html('<div class="alert alert-danger"><strong>Sub Category!</strong> Not delete.</div>'); 
                        }, 3000);   
                    }
                    location.reload();
                }
            });
        }
    }
</script>
 <!-- Page specific javascripts-->
    <!-- Data table plugin-->
   
