<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Invoice</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 <script type="text/javascript" src="<?php echo base_url(); ?>admin_assest/js/parsley.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<style type="text/css">
	    .parsley-errors-list{
	        color: red;
	        list-style-type: none;
	        padding: 0;
	        margin: 0;
	    }
    </style>
</head>

<body style="margin:0; background-color: #f4f4f4">
	<style type="text/css">
		
            @media only screen and (min-width: 767px){
                .tableFull, .tableHAlf {
                	width:320px !important;
                }
            }
	</style>
	<!-- <table style="width: 50%; background: #fff; max-width: 90%; margin: 0 auto; font-size: 14px; color: gray; padding-top: 0rem; box-shadow: 0 0 30px rgba(37,45,51,.1)!important;border-top: 11px solid #00afa9;">
		<tbody>
			<tr style="color: #000;">
				<td>
					<table style="width: 100%; padding: 2rem;">
						<tr>
							<td width="" style="width: 100%; text-align:center;">
								<a href="#" style="text-decoration: none; font-family: sans-serif;">
									<strong style="font-size: 50px; color: #333;">
										<img  src="<?php echo base_url(); ?>website_assest/logo.png" alt="logo" width="200px">
									</strong>
								</a>							
							</td>
						</tr>
					</table>		
				</td>
			</tr>
		</tbody>			
	</table> -->

	<!-- <table style="width: 50%; background: #fff; max-width: 90%; margin: 0 auto; font-size: 14px; color: gray; padding-top: 0rem; box-shadow: 0 0 30px rgba(37,45,51,.1)!important;">
		<tbody>
			<tr style="color: #000;">
				<td> -->
					<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>

	<!-- <table style="width: 100%; padding: 2rem;width: 50%; background: #fff;max-width: 90%; margin: 0 auto; border: 1px solid">
		<thead style="margin-bottom: 10px; ">
            <tr>
                <th>Plan Description</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        	<tr>
        		<td>5 Year plan	</td>
        		<td>Rs 45000</td>
        	</tr>
        	<tr>
        		<td>GST 18 %</td>
        		<td></td>
        	</tr>
        	<tr>
        		<td>Total</td>
        		<td></td>
        	</tr>
        </tbody>
	</table>	 -->

	<div class=" table-responsive " style="margin:10px 30px;border: 2px solid #06a6e6;padding: 20px;width: 70%;margin: auto;background: #f7fbff;">
                  <!-- id="print_div" -->
                  <form class="" method="post" data-parsley-validate="" action="">
                     <div>
                        <div style="width: 49%;    display: inline-block;">
                           <h2>Name :</h2>

                           <span>
                              Email Id :  
                           </span>
                           <br>
                           <span>
                              Mobile :  
                           </span>
                        </div>
                        <div style="width: 50%;    display: inline-block; text-align: right;">
                           <!-- <h1 style="font-size: 32px;"><img  src="<?php echo base_url(); ?>website_assest/logo.png" alt="logo" width="200px"></h1> -->
                           <h1 style="font-size: 32px;">Job Portal</h1>
                           <span>R-Vedant Group</span>
                           <br>
                           <span>GSTIN - 23FNQPP3703P1ZD</span>
                           <br>  
                           <span>+919522754974</span>
                        </div>
                     </div>
                     
                     <table class="table table-striped table-bordered" style="margin-top: 10px;text-align: center; width: 100%">
                        <thead  style="margin-bottom: 10px; ">
                           <tr style="border: 1px solid #dee2e6; text-align: left; align-items: left;">

                              <th colspan="12" style="padding:24px; border: 1px solid #dee2e6;text-align: center;">Name</th>
                              <th  style="padding:24px; border: 1px solid #dee2e6;text-align: center;">Total</th>
                           </tr>
                        </thead>
                        <tbody style="">

                          <tr style="margin-top:20px">
                             <td colspan="12" style="padding:24px; border: 1px solid #dee2e6;">
                              

                             </td>
                             <td  style="padding:24px; border: 1px solid #dee2e6;"></td>
                          </tr>

                            <tr style="margin-top:20px">
                             <td colspan="12" style="padding:24px; border: 1px solid #dee2e6;">GST in 18%</td>
                             <td  style="padding:24px; border: 1px solid #dee2e6;"></td>
                          </tr>
                          
                        
                        </tbody>

                     </table>

                  
                    
                    <br>    

                     <div style="display: inline-block; margin-top: 20px; width:100%;">
                        <div style="width: 100%;padding: 3px 0; text-align: left;">
                           <label  style="display: inline-block;font-weight: 600; font-size: 16px;">Agent Code</label>
                          
                           <label></label>
                        </div>

                          <div style="width: 100%;padding: 3px 0; text-align: left;">
                           <label  style="display: inline-block;font-weight: 600; font-size: 16px;">Mobile Number</label>
                           <label></label>
                           <!-- <input style="/*width: 100%;*/height: 30px;padding-left: 5px ;border:none !important;font-size: 16px;text-align: right;" class="form-control" type="text"  name="no_installment" id="no_installment" value="" readonly> -->
                        </div>
                     </div>
                  
                     <div  style="text-align: center; border: 1px solid #999;padding: 6px; margin: 8px 0; ">
                     	THIS IS SYSTEM GENERATED INVOICE, T&C APPLICABLE
                        <!-- TAX INVOICE -->
                     </div> 

                     <div style=" width: 100%">
                        <div style="width: 100%;padding: 3px 3px; text-align: center;">
                           <label  style="display: inline-block;font-weight: 600; font-size: 16px;text-align: center">Address</label>
                           <p>
                           		R-Vedant Group, Near Yash Balaji, 
								Sanjeet Road Mandsaur 458001
                           </p>
                        </div>
                     </div>
                     <!-- <div style="text-align: center;margin-top: 10px">
                        <h4>THANK YOU FOR YOUR BUSINESS WITH US</h4>
                     </div> -->
                  </form>
               </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
