<?php
class AdminModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->library( 'Utility' );
	}
    
    public function adminData($data)
    {
    	// print_r($data);die;
   
        $this->db->select("*")->from('admin')->where(array(
                            'password' 		 	=> md5($data['password']),
                            'orginal_password' 	=> $data['password'],
                            'email' 			=> $data['email'],
                        ));
                        
		 // $where = '(email="'.$data['email_mobile'].'" or mobile_number = "'.$data['email_mobile'].'")';
		 
          // return  $this->db->where($where)->get()->row();
          return  $this->db->get()->row();
    }
	
	 public function getAllVenodr()
    {
        $this->db->select("user.id,user.user_type,user.plan_id,user.language_id,user.name,user.user_name,user.email,user.password,user.actual_password,user.dob,user.profile_image,user.referal_code,user.mobile_number,user.status,vendor_plan.plan_name")
            ->from('user')
            ->join('vendor_plan','vendor_plan.id = user.plan_id','left')
            ->where(array("user.user_type" => '2'))
            ->order_by("user.id", "desc");
        return $this->db->get()->result_array();
    }
    
    public function vendorDetail($vendor_id)
    {
        $this->db->select("user.id,user.user_type,user.plan_id,user.language_id,user.name,user.user_name,user.email,user.password,user.actual_password,user.dob,user.profile_image,user.referal_code,user.mobile_number,user.status,vendor_plan.plan_name")
            ->from('user')
            ->join('vendor_plan','vendor_plan.id = user.plan_id','left')
            ->where(array("user.user_type" => '2'))
            ->where(array("user.id" => $vendor_id));
            // ->order_by("user.id", "desc");
        return $this->db->get()->row();
    }
    public function vendorSpecializeList($vendor_id)
    {
        $this->db->select("vendor_specialize.id,vendor_specialize.vendor_id,vendor_specialize.specialized_id,vendor_specialize.vendor_checked_specialize,vendor_specialize.status,specialize.name as specialize_name")
            ->from('vendor_specialize')
            ->join('specialize','specialize.id = vendor_specialize.specialized_id','left')
            ->where(array("vendor_specialize.vendor_id" =>$vendor_id))
            ->order_by("vendor_specialize.id", "desc");
        return $this->db->get()->result_array();
    }
    
    public function getAllVenodrCriminalRecordList()
    {
         $this->db->select("vendor_criminal_record.id,vendor_criminal_record.vendor_id,vendor_criminal_record.name,vendor_criminal_record.admin_approval,vendor_criminal_record.comment,user.name as vendor_name")
            ->from('vendor_criminal_record')
            ->join('user','user.id = vendor_criminal_record.vendor_id','left')
            ->order_by("vendor_criminal_record.id", "desc");
        
        return $this->db->get()->result_array();
        
    }
    
    public function getPlanFeature($type)
    {
        $query = 'SELECT * FROM vendor_plan_feature where (plan_id = 0 OR plan_id = '.$type.')';

        $query = $this->db->query($query);

		return $query->result_array();
    }
    
    public function notification($to_id){
	    $this->db->select("notification.id as notification_id,notification.from_id,notification.to_id,notification.title,notification.message,notification.msg_for,notification.is_read,notification.created_at,notification.updated_at,user.name as user_name")
	        ->from(' notification')
	        ->join('user','user.id = notification.from_id','left')
		->where(array("notification.to_id" => $to_id))
		->order_by("notification.id", "desc");
		
		$where = '(notification.msg_for="3" or notification.msg_for = "4")';
        
       return $this->db->where($where)->get()->result_array();

	   // return $this->db->get()->result_array();
	}
	
	public function countNotification($to_id)
	{
	   // Select count(*) as total from notificatio where user_type = 1
	    
	    $this->db->select("count(*) as total")
	        ->from(' notification')
		->where(array("notification.to_id" => $to_id))
		->where(array("notification.is_read" =>0));
		
		$where = '(notification.msg_for="3" or notification.msg_for = "4")';
        
       return $this->db->where($where)->get()->row_array();
	}
	
	public function getLanguage($language_id)
    {
        $query = 'SELECT * FROM language where id in('.$language_id.')';
        $query = $this->db->query($query);

        return $query->result_array();
    }
    
    public function vendorRegularService($vendor_id)
    {
        $this->db->select("vendor_regular_service.id,vendor_regular_service.vendor_id,vendor_regular_service.service_name,vendor_regular_service.description,vendor_regular_service.category_id,vendor_regular_service.price,vendor_regular_service.durantion,vendor_regular_service.available_status,user.name as vendor_name,category.category_name")
            ->from('vendor_regular_service')
            ->join('category','category.id = vendor_regular_service.category_id','left')
            ->join('user','user.id = vendor_regular_service.vendor_id','left');
        if($vendor_id != 0)
        {
            $this->db->where(array("vendor_regular_service.vendor_id" => $vendor_id));
        }
        
         $this->db->order_by("vendor_regular_service.id", "desc");
         
        return $this->db->get()->result_array();
    }
    
    public function VendorRegularServiceDetail($regular_service_id)
    {
        $this->db->select("vendor_regular_service.id,vendor_regular_service.vendor_id,vendor_regular_service.service_name,vendor_regular_service.description,vendor_regular_service.category_id,vendor_regular_service.price,vendor_regular_service.service_charge,vendor_regular_service.durantion,vendor_regular_service.available_status,user.name as vendor_name,category.category_name")
            ->from('vendor_regular_service')
            ->join('category','category.id = vendor_regular_service.category_id','left')
            ->join('user','user.id = vendor_regular_service.vendor_id','left')
            ->where(array("vendor_regular_service.id" => $regular_service_id));
         
        return $this->db->get()->row();
    }
    
    public function VendorPackage($vendor_id)
    {
        $this->db->select("vendor_packages.id,vendor_packages.vendor_id,vendor_packages.package_name,vendor_packages.description,vendor_packages.usual_price,vendor_packages.price,vendor_packages.service_id,vendor_packages.available_status,user.name as vendor_name")
            ->from('vendor_packages')
            ->join('user','user.id = vendor_packages.vendor_id','left');
        if($vendor_id != 0)
        {
            $this->db->where(array("vendor_packages.vendor_id" => $vendor_id));
        }
        $this->db->order_by("vendor_packages.id", "desc");
         
        return $this->db->get()->result_array();
    }
    
    public function VendorPackageDetail($package_id)
    {
        $this->db->select("vendor_packages.id,vendor_packages.vendor_id,vendor_packages.package_name,vendor_packages.description,vendor_packages.usual_price,vendor_packages.price,vendor_packages.service_id,vendor_packages.available_status,vendor_packages.description,user.name as vendor_name")
            ->from('vendor_packages')
            ->join('user','user.id = vendor_packages.vendor_id','left')
            ->where(array("vendor_packages.id" => $package_id));
         
        return $this->db->get()->row();
    }

    public function VendorSubscription($vendor_id)
    {
        $this->db->select("vendor_subscription.id,vendor_subscription.vendor_id,vendor_subscription.subcription_name,vendor_subscription.description,vendor_subscription.usual_price,vendor_subscription.price,vendor_subscription.period_subcription,vendor_subscription.number_appointment_subcription,vendor_subscription.hour_each_appointment,vendor_subscription.service_id,vendor_subscription.available_status,user.name as vendor_name")
            ->from('vendor_subscription')
            ->join('user','user.id = vendor_subscription.vendor_id','left');
        if($vendor_id != 0)
        {
            $this->db->where(array("vendor_subscription.vendor_id" => $vendor_id));
        }
        
         $this->db->order_by("vendor_subscription.id", "desc");
         
        return $this->db->get()->result_array();
    }

    public function VendorSubscriptionDetail($subscription_id)
    {
        $this->db->select("vendor_subscription.id,vendor_subscription.vendor_id,vendor_subscription.subcription_name,vendor_subscription.description,vendor_subscription.usual_price,vendor_subscription.price,vendor_subscription.period_subcription,vendor_subscription.number_appointment_subcription,vendor_subscription.hour_each_appointment,vendor_subscription.service_id,vendor_subscription.available_status,user.name as vendor_name")
            ->from('vendor_subscription')
            ->join('user','user.id = vendor_subscription.vendor_id','left')
            ->where(array("vendor_subscription.id" => $subscription_id));
         
        return $this->db->get()->row();
    }
    
    public function VendorGroup($vendor_id)
    {
        $this->db->select("vendor_group.id,vendor_group.vendor_id,vendor_group.group_name,vendor_group.minimum_people,vendor_group.usual_price,vendor_group.price,vendor_group.group_method_type,vendor_group.price_discount,vendor_group.service_id,vendor_group.available_status,user.name as vendor_name")
            ->from('vendor_group')
            ->join('user','user.id = vendor_group.vendor_id','left');
        if($vendor_id != 0)
        {
            $this->db->where(array("vendor_group.vendor_id" => $vendor_id));
        }
        
         $this->db->order_by("vendor_group.id", "desc");
         
        return $this->db->get()->result_array();
    }
    
    public function VendorGroupDetail($group_id)
    {
        $this->db->select("vendor_group.id,vendor_group.vendor_id,vendor_group.group_name,vendor_group.minimum_people,vendor_group.usual_price,vendor_group.price,vendor_group.group_method_type,vendor_group.price_discount,vendor_group.service_id,vendor_group.available_status,user.name as vendor_name")
            ->from('vendor_group')
            ->join('user','user.id = vendor_group.vendor_id','left')
            ->where(array("vendor_group.id" => $group_id));
         
        return $this->db->get()->row();
    }
    
    
    public function VendorOfferLoyalty($vendor_id)
    {
        $this->db->select("vendor_offers_loyalty.id,vendor_offers_loyalty.vendor_id,type,vendor_offers_loyalty.name_offer,vendor_offers_loyalty.amout_discount,vendor_offers_loyalty.offer_period,vendor_offers_loyalty.offer_period_start,vendor_offers_loyalty.offer_period_end,vendor_offers_loyalty.customer_type,vendor_offers_loyalty.usual_price,vendor_offers_loyalty.price,vendor_offers_loyalty.service_id,vendor_offers_loyalty.available_status,user.name as vendor_name")
            ->from('vendor_offers_loyalty')
            ->join('user','user.id = vendor_offers_loyalty.vendor_id','left');
        if($vendor_id != 0)
        {
            $this->db->where(array("vendor_offers_loyalty.vendor_id" => $vendor_id));
        }
        
         $this->db->order_by("vendor_offers_loyalty.id", "desc");
         
        return $this->db->get()->result_array();
    }
    
    public function VendorOfferLoyaltyDetail($offersLoyalty_id)
    {
        $this->db->select("vendor_offers_loyalty.id,vendor_offers_loyalty.vendor_id,type,vendor_offers_loyalty.name_offer,vendor_offers_loyalty.amout_discount,vendor_offers_loyalty.offer_period,vendor_offers_loyalty.offer_period_start,vendor_offers_loyalty.offer_period_end,vendor_offers_loyalty.customer_type,vendor_offers_loyalty.usual_price,vendor_offers_loyalty.price,vendor_offers_loyalty.service_id,vendor_offers_loyalty.available_status,user.name as vendor_name")
            ->from('vendor_offers_loyalty')
            ->join('user','user.id = vendor_offers_loyalty.vendor_id','left')
            ->where(array("vendor_offers_loyalty.id" => $offersLoyalty_id));
         
        return $this->db->get()->row();
    }
    
    public function AllBooking()
    {
        $this->db->select("booking.id as booking_id,booking.user_id,booking.vendor_id,booking.order_number,booking.service_id,booking.address,booking.booking_date,booking.appointmen_time,booking.duration_hour,booking.no_person,booking.total_service_fees,booking.travel_fees,booking.total_booking_amount,booking.booking_status,vendor_regular_service.service_name,vendor_regular_service.category_id,category.category_name,v1.name as vendor_name,u1.name as user_name")
            ->from('booking')
            ->join('user u1','booking.user_id = u1.id','left')
            ->join('user v1','booking.vendor_id = v1.id','left')
            ->join('vendor_regular_service','vendor_regular_service.id = booking.service_id','left')
            ->join('category','category.id = vendor_regular_service.category_id','left')
            ->order_by("booking.id", "desc");
         
        return $this->db->get()->result_array();
    }

    public function bookingDetail($booking_id)
    {
        $this->db->select("booking.id as booking_id,booking.user_id,booking.vendor_id,booking.order_number,booking.service_id,booking.address,booking.booking_date,booking.appointmen_time,booking.duration_hour,booking.no_person,booking.total_service_fees,booking.travel_fees,booking.total_booking_amount,booking.booking_status,vendor_regular_service.service_name,vendor_regular_service.category_id,category.category_name,v1.name as vendor_name,u1.name as user_name,user_payment.type as payment_type,payment.payment_id,payment.pay_amount,payment.transaction_id,payment.status as payment_status,user_payment.card_number,user_payment.card_holder_name,user_payment.valid_date,user_payment.cvv,user_payment.email")
            ->from('booking')
            ->join('user u1','booking.user_id = u1.id','left')
            ->join('user v1','booking.vendor_id = v1.id','left')
            ->join('vendor_regular_service','vendor_regular_service.id = booking.service_id','left')
            ->join('payment','payment.booking_id = booking.service_id','left')
            ->join('user_payment','user_payment.id = payment.payment_id','left')
            ->join('category','category.id = vendor_regular_service.category_id','left')
            ->where(array("booking.id" => $booking_id));
         
        return $this->db->get()->row();
    }
    

}

