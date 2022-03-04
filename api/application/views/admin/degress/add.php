<main class="app-content">
    <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/degree');?>"> Degree</a></li>
          <li class="breadcrumb-item"><?= $title;?></li>
        </ul>
      </div>
   <div class="row">
      <div class="col-md-12">
         <div class="tile">
            <div class="row">
               <div class="col-lg-12">
                  <form class="row" action="<?php echo site_url('admin/add_degree');?>" method="post"  enctype="multipart/form-data" data-parsley-validate="">
                    
                     <div class="col-md-12 mt-3">
                        <div class="product-item-box mb-3 add_input_item">
                           <div class="row">
                                  <div class="col-md-2">
                                     <div class="form-group ">
                                        <label>Select Type degree</label>
                                        <select class="form-control" data-live-search="true" name="type[]" id="type_1" required data-parsley-required data-parsley-required-message="Select Type">
                                         <option value="">Select  Type</option>
                                         <option data-tokens="0" value="0" >Degree</option>
                                         <option data-tokens="0" value="1" >Master</option>
                                         <option data-tokens="0" value="2" >ITI</option>
                                         <option data-tokens="0" value="3" >Diploma</option>
                                      </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label>Add Degree</label>
                                        <input class="form-control" id="degree_name_1" type="text" placeholder="Degree" name="name[]" required data-parsley-required data-parsley-required-message="Enter Degree" onblur="checkUniversity(this.value,1)">
                                         <!-- onkeyUp="checkCategory(this.value,1)" -->
                                        <span id="errmsg_degree_1" style="color: red"></span>
                                     </div>
                                  </div>

                                   <div class="col-md-4">
                                     <div class="form-group ">
                                        <label>Add Degree in other language</label>
                                        <input class="form-control" id="name_1" type="text" placeholder="Degree in other language" name="other_language_name[]" required data-parsley-required data-parsley-required-message="Enter Degree in other language">
                                         <!-- onkeyUp="checkCategory(this.value,1)" -->
                                        <!-- <span id="errmsg_category_1" style="color: red"></span> -->
                                     </div>
                                  </div>
                                <div class="col-sm-2 add-btn">
                                     <label>Action</label>

                                     <input type="button" class="item_add btn btn-primary w-100" value="Add">
                                   <!-- <button class="btn btn-primary w-100 item_add" type="submit"> <i class="fa fa-plus fa-3x" aria-hidden="true"></i> &nbsp; Add</button> -->
                                </div>
                            </div>
                        </div>
                     </div>
                      <div class="col-sm-12 mt-3">
                        <button class="btn btn-primary" type="submit" >Add </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>


<script type="text/javascript">
    $( document ).ready(function() {
         $('#brand_id').select2();
        //Add more Image
        var wrapper1         = $(".add_input_item"); //Fields wrapper
        var add_button1      = $(".item_add"); //Add button ID
        
        var y = 1; //initlal text box count
        var yy = 1;
        $(add_button1).click(function(e){ //on add input button click
            e.preventDefault();
            y++; //text box increment
            yy= yy+1; 
            
            $(wrapper1).append(`
               <div class="row ">
                      <div class="col-md-2">
                         <div class="form-group ">
                            <select class="form-control" data-live-search="true" name="type[]" id="type_`+yy+`" required data-parsley-required data-parsley-required-message="Select Type">
                             <option value="">Select  Type</option>
                             <option data-tokens="0" value="0" >Degree</option>
                             <option data-tokens="0" value="1" >Master</option>
                             <option data-tokens="0" value="2" >ITI</option>
                             <option data-tokens="0" value="3" >Diploma</option>
                          </select>
                         </div>
                      </div>
                      <div class="col-md-4">
                         <div class="form-group ">
                             <input class="form-control" id="degree_name_`+yy+`" type="text" placeholder="Degree" name="name[]" required data-parsley-required data-parsley-required-message="Enter Degree"  onblur="checkUniversity(this.value,`+yy+`)">
                             <span id="errmsg_degree_`+yy+`" style="color: red"></span>
                         </div>
                      </div>    
                      <div class="col-md-4">
                                     <div class="form-group ">
                                        <input class="form-control" id="name_1" type="text" placeholder="Degree in other language" name="other_language_name[]" required data-parsley-required data-parsley-required-message="Enter Degree in other language">
                                         <!-- onkeyUp="checkCategory(this.value,1)" -->
                                        <span id="errmsg_category_1" style="color: red"></span>
                                     </div>
                                  </div>
                
                    <div class="col-sm-2 add-btn">
                          <button class="btn btn-danger w-100 remove_field" type="submit"> <i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete</button>
                    </div>
                </div>
            `); //add input box

        });

        $("#type_".yy).select2();

        $(wrapper1).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); y--;
        })
    });

    function checkUniversity(university_name,yy)
    {
        // alert(1);
        var degree_name = $('#degree_name_'+yy).val();
        var type        = $('#type_'+yy).val();
        
        if(university_name == ''){
            $('#errmsg_degree_'+yy).html('');
        }else{

            $.ajax({
                url: '<?php echo site_url("admin/DegreeController/checkDegree"); ?>',
                type: "POST",
                data: {
                    "degree_name"  : degree_name,
                    "type"          : type,
                },
                success: function (response) 
                {
                    console.log(response);

                    if (response == '0') {
                        $('#errmsg_degree_'+yy).html('');
                    } else {
                        $('#errmsg_degree_'+yy).html('Degree Name already Exits');
                        $('#degree_name_'+yy).val('');
                        // $('#model_category_'+yy).val('');
                    }
                }
            });
        }
      }
</script>

