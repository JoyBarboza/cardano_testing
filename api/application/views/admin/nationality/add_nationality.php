<main class="app-content">
    <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/nationality');?>"> Nationality</a></li>
          <li class="breadcrumb-item"><?= $title;?></li>
        </ul>
      </div>
   <div class="row">
      <div class="col-md-12">
         <div class="tile">
            <div class="row">
               <div class="col-lg-12">
                  <form class="row" action="<?php echo site_url('admin/add_nationality');?>" method="post"  enctype="multipart/form-data" data-parsley-validate="">
                    
                     <div class="col-md-12 mt-3">
                        <div class="product-item-box mb-3 add_input_item">
                           <div class="row">
                                  <div class="col-md-5 col-sm-12">
                                     <div class="form-group ">
                                        <label>Add Nationality</label>
                                        <input class="form-control" id="name_1" type="text" placeholder="Nationality" name="name[]" required data-parsley-required data-parsley-required-message="Enter Nationality">
                                         <!-- onkeyUp="checkCategory(this.value,1)" -->
                                        <span id="errmsg_category_1" style="color: red"></span>
                                     </div>
                                  </div>

                                   <div class="col-md-5 col-sm-12">
                                     <div class="form-group ">
                                        <label>Add Nationality in other language</label>
                                        <input class="form-control" id="name_1" type="text" placeholder="Nationality in other language" name="other_language_name[]" required data-parsley-required data-parsley-required-message="Enter Nationality in other language">
                                         <!-- onkeyUp="checkCategory(this.value,1)" -->
                                        <span id="errmsg_category_1" style="color: red"></span>
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
                        <button class="btn btn-primary" type="submit" >Add Items</button>
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
                      <div class="col-md-5 col-sm-12">
                         <div class="form-group ">
                             <input class="form-control" id="name_1" type="text" placeholder="Nationality" name="name[]" required data-parsley-required data-parsley-required-message="Enter Nationality">
                             <span id="errmsg_category_`+yy+`" style="color: red"></span>
                         </div>
                      </div>
                      <div class="col-md-5 col-sm-12">
                                     <div class="form-group ">
                                        <input class="form-control" id="name_1" type="text" placeholder="Nationality in other language" name="other_language_name[]" required data-parsley-required data-parsley-required-message="Enter Nationality in other language">
                                         <!-- onkeyUp="checkCategory(this.value,1)" -->
                                        <span id="errmsg_category_1" style="color: red"></span>
                                     </div>
                                  </div>
                
                    <div class="col-sm-2 add-btn">
                          <button class="btn btn-danger w-100 remove_field" type="submit"> <i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Delete</button>
                    </div>
                </div>



            `); //add input box
            
            // $('#productId_'+yy).select2();

            // $('#productId').select2("refresh");


        });


        $(wrapper1).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); y--;
        })
    });

    function checkCategory(category_name,yy)
    {
       var brand_id = $('#brand_id').val();

        if(category_name == ''){
            $('#errmsg_category_'+yy).html('');
        }else{

            $.ajax({
                url: '<?php echo site_url("service_provider/CategoryController/check_Catedory"); ?>',
                type: "POST",
                data: {
                    "brand_id" : brand_id,
                    "category_name" : category_name,
                },
                success: function (response) 
                {
                    console.log(response);
                    var obj = JSON.parse(response);

                    if (response == '0') {
                        $('#errmsg_category_'+yy).html('');
                    } else {
                        $('#errmsg_category_'+yy).html('Category Name already exits');
                        $('#category_name_'+yy).val('');
                    }
                }
            });
        }

    }
</script>