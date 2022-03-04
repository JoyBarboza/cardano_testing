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

      <?php if (!empty(base64_decode($this->uri->segment(3)))){?>
           <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="col-lg-12">
                    <form class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"> Recuriter Name</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getUserData->name?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"> Mobile Number</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getUserData->mobile_number?>" placeholder="Name" disabled="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"> Email Id</label>
                            <input class="form-control" id="disabledInput" type="text" value="<?= $getUserData->email?>" placeholder="Name" disabled="">
                        </div>
                    </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <?php }?>
      <div class="row">
         <div id="msg"></div>
         
         
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <th>Recuriter Name</th>
                     <th>Job Title</th>
                     <th>Organization Name</th>
                     <th>Salary</th>
                     <th>Status</th>
                     <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllPostedJob as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              
                              <td><?php echo $key['recuriter_name']; ?></td>
                              <td><?php echo $key['want_to_hire']; ?></td>
                              <td><?php echo $key['organization_name']; ?></td>
                              <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $key['salary_from']; ?> - <?php echo $key['salary_to']; ?></td>
                              <td>
                                <?php if($key['recreuter_job_status'] == 1){?>
                                   <span class="btn btn-success">Add more</span>
                                <?php }else { ?>
                                   <span class="btn btn-success">Confirm</span>

                                <?php } ?>
                                
                              </td>
                              <td class="center">

                                <a class="btn btn-primary" title="View" href="<?php echo base_url().'admin/view_post_job/'.base64_encode($key['id']);?>"><i class="fa fa-eye"></i></a>
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
</script>
   