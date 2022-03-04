

<!-- Essential javascripts for application to work-->
    
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/main.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/parsley.min.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url(); ?>assest/admin_assest/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/plugins/chart.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/plugins/dataTables.bootstrap.min.js"></script>
     <script type="text/javascript">$('#sampleTable').DataTable();</script>
    
<!------------------------ Select picker JS -------------------------------->
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/plugins/select2.min.js"></script> <!-- Select picker JS -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assest/admin_assest/js/custom-file-input.js"></script> <!--  name file inpute -->

<!------------------------ Data table For pdf,export-------------------------------->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    
  </body>
</html>
<script type="text/javascript">
  // $(document).on('ready', function() {
    // $(function() {
    // alert('hi');
    $('.alert-danger').delay(7000).fadeOut();    
    $('.alert').delay(5000).fadeOut(); 
  // }); 

    <?php if($this->session->flashdata('success')){ ?>
        toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    <?php }else if($this->session->flashdata('error')){  ?>
        toastr.error("<?php echo $this->session->flashdata('error'); ?>");
    <?php }else if($this->session->flashdata('warning')){  ?>
        toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
    <?php }else if($this->session->flashdata('info')){  ?>
        toastr.info("<?php echo $this->session->flashdata('info'); ?>");
    <?php } ?>


    function changeLang(lang)
    {
        // alert(lang);
        // var lang = this.value;
        $.ajax({
            url: '<?php echo site_url("LanguageSwitcher/switchLang"); ?>',
            type: "POST",
            data: {
            "lang"     : lang,
            },
            success: function (response) 
            {
                // alert(response);
                // console.log(response);
                if (response == 1) 
                {
                    location.reload();
                } 

            }
        });
    }

     function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>