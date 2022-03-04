<main class="app-content">
      <div class="app-title">
        <div>
          <h1>
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
                            <label for="exampleSelect1"> User Name</label>
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
        
        <div class="col-md-12">
            <div class="tile">
                <div class="row">
                     <?php if (!empty(base64_decode($this->uri->segment(3)))){?>
                         <input type="hidden" name="user_id" class="user_id" value="echo <?php base64_decode($this->uri->segment(3))?>"> 
                     <?php } else {?>
                        <input type="hidden" name="user_id" class="user_id" value="0"> 
                     <?php }?>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category</label>
                            <select class="form-control" id="category_id" onchange="getSubCategory(this.value);">
                                <option value="">Select Category</option>
                                <?php 
                                    if(!empty($getAllCategory))
                                    {
                                        foreach ($getAllCategory as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sub Category</label>
                            <select class="form-control" id="sub_category_id" onchange="getSubSubCategory(this.value);">
                                <option value="">Select Sub Category</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sub Sub Category</label>
                            <select class="form-control" id="sub_sub_category_id">
                                <option value="">Select Sub Sub Category</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Search by Address</label>
                            <input type="text" name="search" id="search" placeholder="Search by Address" class="form-control">
                        </div>
                    </div>
                    
                     <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Search by Total Experience</label>
                            <input type="number" name="experience" id="experience" placeholder="Search by Total Experience" class="form-control" min="1">
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Qualification</label>
                            <select class="form-control" id="qulalifcation">
                                <option value="">Select Qualification</option>
                                <?php 
                                    if(!empty($getAllDegree))
                                    {
                                        foreach ($getAllDegree as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="tile-footer" style="border-top: none;margin-top: 7px;">
                        <button onclick="filterData();" class="btn btn-primary">Filter</button>
                        
                         <?php if (!empty(base64_decode($this->uri->segment(3)))){
                         
                            $user_id = $this->uri->segment(3)
                         ?>
                             <a href="<?php echo base_url('admin/resume/'); ?><?php echo $user_id;?>" class="btn btn-danger">Refresh</a>
                         <?php } else {?>
                            <a href="<?php echo base_url('admin/resume'); ?>" class="btn btn-danger">Refresh</a>
                         <?php }?>
                    </div>
                </div>
            </div>
            
        </div>
      </div>
      <div class="row">
        </div> 
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="example">
                  <thead>
                    <tr>
                     <th>S.No</th>
                     <th>Category Name</th>
                     <th>Sub Category Name</th>
                     <th>Sub Sub Category Name</th>
                     <th>Employee Name</th>
                     <th>Recuriter Name</th>
                     <th>Job Title</th>
                     <th>Organization Name</th>
                     <th>Total Experience</th>
                     <th>Qualification Name</th>
                     <th>Resume</th>
                     <th>Status</th>
                      <th>Action</th> 
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                         // print_r($tableData);exit;
                        $i = 1;
                        foreach ($getAllResumeList as $key) { 
                             ?>
                           <tr>
                              <td><?php echo $i; ?></td>
                              
                              <td><?php echo $key['categories_name']; ?></td>
                              <td><?php echo $key['subcategories_name']; ?></td>
                              <td><?php echo $key['subsubcategories_name']; ?></td>
                              <!--<td><?php echo $key['u_name']; ?></td>-->
                              <td><?php echo $key['full_name']; ?></td>
                              <td><?php echo $key['r_name']; ?></td>
                              <td><?php echo $key['subsubcategories_name']; ?></td>
                              <td><?php echo $key['organization_name']; ?></td>
                              <td><?php echo $key['total_experience']; ?></td>
                              <td>
                                  <?php 
                                        echo $key['degreename']; 
                                        $qualification = $this->CommonModel->userResumeQualification( $key['user_id']);
                                        if(!empty($qualification)){
                                            $comma_string = array();
                                            foreach($qualification as $v){
                                                 if($v['degree_type'] == '0'){
                                                    $comma_string[] =  $v['d_degree_name'];    
                                                }else if(!empty($v['degree_type'])){
                                                    $comma_string[] =  $v['d_degree_name'];    
                                               }else{
                                                    $comma_string[] = $v['q_degree_name'];
                                                }
                                            }
                                            
                                             $comma_separated = implode(",", $comma_string);
                                              echo $comma_separated;
                                            
                                        }
                                  ?>
                              
                              </td>
                              <td>
                                  <?php if(!empty($key['resume_pdf'])){?>
                                   <a href="<?php echo base_url().'uploads/resume_pdf/'.$key['resume_pdf'];?>" target="_blank">Download PDF</a>
                                  <?php }else{
                                    echo 'No pdf';
                                  }?>
                               
                              </td>
                              <td>
                                <?php if($key['job_status'] == 1){ ?>
                                     <span class="btn btn-success remove_effect">Accepted by recuriter</span>
                                  <?php } elseif ($key['job_status'] == 2) { ?>
                                     <span class="btn btn-danger remove_effect">Rejected by recuriter</span>
                                  <?php }else{ ?>
                                     <span class="btn btn-primary remove_effect">Pending</span>
                                  <?php } ?>
                                
                              </td>
                              <td>
                                  <!--<a href ="<?php echo base_url().'admin/resume_detail/'.$key['id'];?>">View</a> -->
                                  
                                   <a href ="<?php echo base_url().'admin/resume_detail/'.base64_encode($key['id']);?>">View</a> 
                              </td>
                             <!--  <td class="center">
                                <?php if(!empty($key['img'])) { ?>
                                 <a  title="View PDF" href="<?php echo base_url().'uploads/resume_pdf/'.$key['img'];?>" class="btn btn-primary" target="_blank">PDF</a>
                                <?php } ?>

                              </td> -->

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
    function getSubCategory(category_id){
        $.ajax({
            url: '<?php echo site_url("admin/ResumeController/getSubCategory"); ?>',
            type: "POST",
            data: {
                "category_id" : category_id
            },
            success: function (response) 
            {
                // console.log(response);
                
                 var html = '<option value="">Select Sub Category</option>';
                 
                if (response == '0') {
                     
                    html += '<option value="0">No Sub Category Found</option>'
                      
                    $('#sub_category_id').html(html);
                    $('#errmsg_category').html("Please add category");
                    $('#category_id').val(null).trigger('change');
                } else {
                    var obj = JSON.parse(response);
                    // console.log(obj.length);
                   
                    for(var i=0; i<obj.length; i++){
                        html += '<option value="'+obj[i]['id']+'" onchange="getSubSubCategory(this.value);">'+obj[i]['name']+'</option>'
                    }
                    $('#sub_category_id').html(html);
                }
            }
        });
    }
    
    function getSubSubCategory(sub_category_id){
        $.ajax({
            url: '<?php echo site_url("admin/ResumeController/getSubSubCategory"); ?>',
            type: "POST",
            data: {
                "sub_category_id" : sub_category_id
            },
            success: function (response) 
            {
                // console.log(response);
                
                 var html = '<option value="">Select Sub Sub Category</option>';
                 
                if (response == '0') {
                     
                    html += '<option value="0">No Sub Sub Category Found</option>'
                      
                    $('#sub_sub_category_id').html(html);
                    // $('#errmsg_category').html("Please add category");
                    // $('#category_id').val(null).trigger('change');
                } else {
                    var obj = JSON.parse(response);
                    // console.log(obj.length);
                   
                    for(var i=0; i<obj.length; i++){
                        html += '<option value="'+obj[i]['id']+'">'+obj[i]['name']+'</option>'
                    }
                    $('#sub_sub_category_id').html(html);
                }
            }
        });
    }
    
     function filterData(){
        var category_id = document.getElementById('category_id').value; 
        var sub_category_id = document.getElementById('sub_category_id').value; 
        var sub_sub_category_id = document.getElementById('sub_sub_category_id').value; 
        var search = document.getElementById('search').value; 
        var experience = document.getElementById('experience').value; 
        var qulalifcation = document.getElementById('qulalifcation').value; 
        var user_id = $('.user_id').val();
        
        var buildSearchData =     {
            "category_id"     		: category_id,
            "sub_category_id"       : sub_category_id,
            "sub_sub_category_id"   : sub_sub_category_id,
            "search"                : search,
            "user_id"               : user_id,
            "experience"            : experience,
            "qulalifcation"         : qulalifcation,
        };
        
        table = $('#example').DataTable({ 
            // "scrollY"       : "350px",
            // "scrollCollapse": true,
            "dom"			: 'lBfrtip',
            "buttons"		: [
            					{
				                    'extend': 'pdfHtml5',
				                    'orientation': 'landscape',
				                    'pageSize': 'LEGAL',
				                    'columns': ':visible',
				                    'exportOptions': {                    
				                        'columns': [0,1,3,4,5,6,7,8]                
				                    },
				 
				                },
				                // 'excel',
				                {
				                    'extend': 'excel',
				                    'orientation': 'landscape',
				                    'pageSize': 'LEGAL',
				                    'columns': ':visible',
				                     'exportOptions': {                    
				                        'columns': [0,1,3,4,5,6,7,8]                
				                    },
				                 },
				                 // 'print',
				                {
				                    'extend': 'print',
				                    'orientation': 'landscape',
				                    'pageSize': 'LEGAL',
				                    'columns': ':visible',
				                     'exportOptions': {                    
				                        'columns': [0,1,3,4,5,6,7,8]                
				                    },
				                 },
            				],
            "ajax"          :  {
               "url"        : '<?php echo site_url("admin/ResumeController/filterResume"); ?>',
               "type"       : 'POST',
               "data"       : buildSearchData
           },
            "bDestroy": true 
        } );
         
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
                            columns: [0,1,3,4,5,6,7,8]                
                        },
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,3,4,5,6,7,8]                
                        },
                     },
                    {
                        extend: 'print',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        columns: ':visible',
                         exportOptions: {                    
                            columns: [0,1,3,4,5,6,7,8]                
                        },
                     },
                ],
        });
    });
</script>
   