<?php
class ApiModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->library( 'Utility' );
	}
	
	
	public function vendor_specialize($vendor_id)
	{
	    $this->db->select("vendor_specialize.id as vendor_specialize_id,vendor_specialize.vendor_id,vendor_specialize.specialized_id,vendor_specialize.vendor_checked_specialize,vendor_specialize.status,specialize.id,specialize.name as specialize_name")
            ->from('vendor_specialize')
            ->join('specialize','specialize.id = vendor_specialize.specialized_id','left')
            ->join('user','user.id = vendor_specialize.vendor_id','left')
           ->where(array("vendor_specialize.vendor_id" => $vendor_id))
            ->order_by("vendor_specialize.id", "desc");
         
        return $this->db->get()->result_array();
	}
	
	public function VendorSpecialize($specializeVendorId)
    {
        $this->db->select("vendor_specialize.id,vendor_specialize.vendor_id,vendor_specialize.specialized_id,vendor_specialize.vendor_checked_specialize,vendor_specialize.status,specialize.name as specialize_name")
            ->from('vendor_specialize')
            ->join('specialize','specialize.id = vendor_specialize.specialized_id','left')
            ->where(array("vendor_specialize.id" =>$specializeVendorId));

        return $this->db->get()->row();
    }
	
	public function VendorServicePackageDetail($service_id)
	{
	       $query = 'SELECT vendor_regular_service.id,vendor_regular_service.vendor_id,vendor_regular_service.service_name,vendor_regular_service.description,vendor_regular_service.category_id,vendor_regular_service.price,vendor_regular_service.service_charge,vendor_regular_service.durantion,vendor_regular_service.available_status FROM vendor_regular_service LEFT JOIN category ON category.id = vendor_regular_service.category_id where vendor_regular_service.id in('.$service_id.')';
	       	
	       	$query = $this->db->query($query);

		 return $query->result_array();

	}
	
}
    