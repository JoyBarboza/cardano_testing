<!-- <link rel="stylesheet" href="<?php echo base_url();?>ckeditor/samples/sample.css"> -->
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><?= $title;?></h1>
          <!-- <p>Bootstrap default form components</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><?= $title;?></li>
          <!-- <li class="breadcrumb-item"><a href="#">Form Components</a></li> -->
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
              <div class="col-lg-12">
                
                <form class="form-horizontal" action="<?php echo site_url('admin/cms/update_cms');?>" enctype="multipart/form-data" method="post">
                  
                  <input type="hidden" name="id" value="<?php echo $data->id; ?>">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>

                    <input type="text" required="" id="" class="form-control" name="title" value="<?= $data->title;?>" placeholder="Enter Title" readonly="">

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Content</label>
                    
                    <textarea id="editor1" class="ckeditor" name="description" required data-parsley-required data-parsley-required-message="Enter Description"><?php if (!empty($data->description)) { echo $data->description; } ?></textarea>

                  </div>
                    <div class="tile-footer">
                      <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<!-- /. PAGE WRAPPER  -->
</div>
<script src="<?php echo base_url() ;?>assest/admin_assest/ckeditor/ckeditor.js">  </script>
<script type="text/javascript">

    CKEDITOR.replace('editor1');
     // CKEDITOR.replace('ar_editor');

      CKEDITOR.on('instanceReady', function () {
        $('#editor1').attr('required', '');
        $.each(CKEDITOR.instances, function (instance) {
            CKEDITOR.instances[instance].on("change", function (e) {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                    $('form').parsley().validate();
                }
            });
        });
    });

</script>