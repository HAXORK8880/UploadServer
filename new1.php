<?php 

class Dashboard1 extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in1();


		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_users');
		$this->load->model('model_user_panel');
		$this->load->model('model_user_shop');
		
		$this->load->model('model_charge');
		$this->load->model('model_deliveryArea');
		
		$this->data['userid'] = $this->session->userdata('uid');
		$this->data['email'] = $this->session->userdata('frontuseremail');
		$this->data['name'] = $this->session->userdata('frontusername');
	}

	public function index()
	{

		
        
		$this->render_template2('home/dashboard/dashboard', $this->data);
	}
	
	
	public function paymentMethod()
	{

		
        
		$this->render_template2('home/dashboard/payments/paymentsmethod', $this->data);
	}
	
	public function track()
	{

		
        
		$this->render_template2('home/dashboard/percel/track', $this->data);
	}
	public function createPercel()
	{
        $this->data['page_title'] = 'Create Percel';
		$this->render_template1('home/createpercel', $this->data);
	}
	
	
	
	public function fetchPercelCountDataById($id)
	{
		

		$data['pending'] = $this->model_user_panel->fetchPercelpendingCountById($id);
		$data['picked'] = $this->model_user_panel->fetchPercelpickedCountById($id);
		$data['inhouse'] = $this->model_user_panel->fetchPercelinhouseCountById($id);
		$data['delivery'] = $this->model_user_panel->fetchPerceldeliveryCountById($id);
		$data['completed'] = $this->model_user_panel->fetchPercelcompletedCountById($id);
		$data['returned'] = $this->model_user_panel->fetchPercelreturnedCountById($id);
        
		$pay = $this->model_user_panel->getTotalPay($id);
		$paid = $this->model_user_panel->getTotalpaid($id);
		
		$deliverychrg = $this->model_user_panel->getTotalReturnedDelivrychrgMarcnt($id);
			
			$codchrg = $this->model_user_panel->getTotalReturnedCodchrgMarcnt($id);
			
			$rerutnchrage = $deliverychrg["SUM(`delivery_charge`)"] + $codchrg["SUM(`cod_charge`)"];
			if($rerutnchrage == ""){
				
				$rerutnchrage = 0;
				
			}
		
		
		$due = $pay['SUM(`total_payable`)'] -  $paid['SUM(`paid_amount`)'] - $rerutnchrage;
		
        $data['pay'] = $pay['SUM(`total_payable`)'];
		$data['paid'] = $paid['SUM(`paid_amount`)'];
		
		
			
		$data['returnedchrg'] = $rerutnchrage;	
        $data['due'] = $due;		
		
		if($data['pay'] == ""){
			
			$data['pay'] = 0;
		}
		if($data['paid'] == ""){
			
			$data['paid'] = 0;
		}
		
		//$data['due'] = $pay1['SUM(`total_payable`)'] - $paid1['SUM(`pay_amount`)'];
      

		echo json_encode($data);
	}
	
	
	
	public function fetchPercelCountDataByIdDate()
	{
		
         $from  = $this->input->post('from');
		 $to  = $this->input->post('to');
		
		
		
		
	    $id = $this->session->userdata('uid');
		$data['pending'] = $this->model_user_panel->fetchPercelpendingCountById1($id,$from,$to);
		$data['picked'] = $this->model_user_panel->fetchPercelpickedCountById1($id,$from,$to);
		$data['inhouse'] = $this->model_user_panel->fetchPercelinhouseCountById1($id,$from,$to);
		
		$data['delivery'] = $this->model_user_panel->fetchPerceldeliveryCountById1($id,$from,$to);
		$data['completed'] = $this->model_user_panel->fetchPercelcompletedCountById1($id,$from,$to);
		$data['returned'] = $this->model_user_panel->fetchPercelreturnedCountById1($id,$from,$to);
		?>
		
		 <div class="row">
          <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="pending1"><?php echo $data['pending'];?></h3>

                <p>Order Pending </p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="picked1"><?php echo $data['picked'];?></h3>

                <p>In pickup </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  
		  
		  <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="inhouse1"><?php echo $data['inhouse'];?></h3>

                <p>Inhouse </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  
		  
		  <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="delivery1"><?php echo $data['delivery'];?></h3>

                <p>Delivery Processing </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  
		  <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="completed1"><?php echo $data['completed'];?></h3>

                <p>Delivery Complited </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  
		  
		  <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="returned1"><?php echo $data['returned'];?></h3>

                <p>Returned </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
		  
		  
		  
		  
		  
		  
		  
          
          <!-- ./col -->
        </div>
		
		<?php

		
	}
	
	public function fetchPercelData()
	{
		$result = array('data' => array());

		$data = $this->model_user_panel->getPercelData();

		foreach ($data as $key => $value) {
			// button
			$buttons = '';

			
				$buttons = '<b style="color:green;"> ....</b>';
			

			
			$shopname1 = $this->model_user_shop->getShopData1($value['shopname']);
			$marchant = $this->model_users->getUserDataforUser($value['user_id']);
			
			
			
			$paymentsinfo = "cash collection =".$value['cash_collection_amount'].",Delivery charge = ".$value['delivery_charge'].", Cod Charge =".$value['cod_charge'].", <b style='background-color:#dbdbdb;'> Total payable =".$value['total_payable']."</b>";	
			
            
			$cusinfo = $value['customername'].",<br/>".$value['cus_phone'].",<br/>".$value['cus_address'].",<br/>".$value['delivery_area'].",<br/>".$value['weight']."Gram";
			
			if($value['order_status'] == 1){
				
				$status = '<span class="label label-primary">Order Confirmed</span>';
				
			}
			else if ($value['order_status'] == 2){
				
				$status = '<span class="label label-success">pickup completed</span>';
			}
			else if ($value['order_status'] == 0){
				
				$status = '<span class="label label-warning">Pending</span>';
				
			}
			else if ($value['order_status'] == -1){
				
				$status = '<span class="label label-warning">Order Cencelled</span>';
			}
			else if ($value['order_status'] == 3){
				
				$status = '<span class="label label-primary">Delivery Proceessing</span>';
				
			}
			else if ($value['order_status'] == 4){
				
				$status = '<span class="label label-success">Delivery Completed</span>';
				
			}
			else if ($value['order_status'] == 5){
				
				$status = '<span class="label label-warning">Product returned</span>';
				
			}
			
            $date = $value['order_date'];
			
			
			if($value['delivery_type'] == 100){
				
				$dtype = "<b style='background-color:#88eae6;'> One day Delivery </b>";
				
			}
			else if ($value['delivery_type'] == 200){
				
				$dtype = "<b > Regular Delivery </b>";
			}
			
			
			
			$result['data'][$key] = array(
			    $date,
				$marchant['username'],
				$cusinfo,
				$value['tracking_id'],
				$shopname1['shopname'],
				
				$paymentsinfo,
				$dtype,
				$value['instruction'],
				
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	public function createPercelSubmit()
	{
		// if(!in_array('createCategory', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('shop', 'shop', 'trim|required');
		

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		$userid = $this->session->userdata('uid');
		
		$tractid = "tx2020-".time();
		
		$orderdate = date("Y-m-d");
         
		 $parea = $this->input->post('pickuparea');
		
		$branch_id = $this->model_deliveryArea->fetchbranchbyarea($parea);
		
		
        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'shopname' => $this->input->post('shop'),
        		'customername' => $this->input->post('name'),
				'cus_phone' => $this->input->post('phone'),	
				'cus_address' => $this->input->post('address'),	
				'marchant_inv_id' => $this->input->post('invoice'),	
				'weight' => $this->input->post('weight'),	
				'cash_collection_amount' => $this->input->post('cashamount'),	
				'sell_price' => $this->input->post('sellprice'),	
				'delivery_area' => $this->input->post('pickuparea'),
				'district' => $this->input->post('district'),
				'instruction' => $this->input->post('instruction'),	
				'area_status' => $this->input->post('location'),	
				'delivery_charge' => $this->input->post('delivery_charge'),	
				'cod_charge' => $this->input->post('cod_charge'),	
				'total_payable' => $this->input->post('total'),
				'order_status' => '0',
				'user_id' => $userid,
				'tracking_id' => $tractid,
				'order_date' => $orderdate,
				'branch_id' => $branch_id['branch_id'],
				'delivery_type' => $this->input->post('dtype'),
				
				
				
        	);

        	$create = $this->model_user_panel->createpercel($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}
	
	
	
	
	
	public function createpaymentinfo()
	{
		// if(!in_array('createCategory', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$response = array();

		$this->form_validation->set_rules('type', 'shop', 'trim|required');
		
		

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		
		$uid =  $this->session->userdata('uid');

        if ($this->form_validation->run() == TRUE) {
        	
			$t = $this->input->post('type');
			
			if($t == 1 ){
				
				$data = array(
        		'user_id' => $uid,
        		'type' => $this->input->post('type'),
				'bkash_number' => $this->input->post('bkash'),	
					
				
				
        	    );
				
			}
			
			else if($t == 2 ){
				
				$data = array(
        		'user_id' => $uid,
        		'type' => $this->input->post('type'),
				'bank_name' => $this->input->post('bank'),	
				'branch_name' => $this->input->post('branch'),	
				'account_name' => $this->input->post('accountname'),	
				'account_type' => $this->input->post('account_type'),	
				'account_number' => $this->input->post('account_number'),	
				
				
        	    );
				
			}
			
			$check = $this->model_user_panel->checkpaymentmethod($uid);
			
			if($check > 0 ){
				
				$response['success'] = false;
				$response['messages'] = 'Already added this payment method';
				
				
			}else {
				
							$create = $this->model_user_panel->createpaymentinfo($data);
						if($create == true) {
							$response['success'] = true;
							$response['messages'] = 'Succesfully created';
						}
						else {
							$response['success'] = false;
							$response['messages'] = 'Error in the database while creating the brand information';			
						}
				
			}

        	
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}
	
	
	
	
	
	
	
	
	
	public function trackresult()
	{
		
		
		
		$trackid = $this->input->post('trackid');
        $check = $this->model_user_panel->trackresult($trackid);
		
		if(isset($check)){
		$n =  $check["order_status"];
		
		?>
		
		 <div class="container">
    <article class="card">
        <header class="card-header"> My Orders / Tracking </header>
        <div class="card-body">
            <h4>Order ID: <?php echo "161030".$check["id"]; ?></h4>
            <article class="card">
                <div class="card-body row">
                    <div class="col-md-3"> <strong>Estimated Delivery time:</strong> <br><?php echo $check["order_date"]; ?> </div>
                    <div class="col-md-3"> <strong>Shipping BY:</strong> <br> WORLDEX, | <i class="fa fa-phone"></i> +1598675986 </div>
                    <div class="col-md-3"> <strong>Status:</strong> <br> 

                    <?php
					
					if($n==1){
						
						echo "Order is Confirmed";
					}
					else if($n==2){
						
						echo "Picked up by courier ";
					}
					else if($n==3){
						
						echo "Delivery On the Way ";
					}
					else if($n==4){
						
						echo "<b style='color:green;'> Delivery Completed </b>";
					}
					
					?>

					</div>
                    <div class="col-md-3"> <strong>Tracking #:</strong> <br> <?php echo $trackid; ?></div>
                </div>
            </article>
            <div class="track">
                <div class="step <?php if($n >= 1 ){ echo 'active';} ?> "> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
				
                <div class="step <?php if($n >= 2 ){ echo 'active';} ?>"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
				
                <div class="step <?php if($n >= 2 ){ echo 'active';} ?>"> <span class="icon"> <i class="fa fa-gift"></i> </span> <span class="text"> Packaging Proccessing </span> </div>
				
				
				<div class="step <?php if($n >= 3 ){ echo 'active';} ?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Delivery On the way </span> </div>
				
				<div class="step <?php if($n >= 4 ){ echo 'active';} ?>"> <span class="icon">  <i class="fa fa-check"></i> </span> <span class="text"> Delivery Completed </span> </div>
				
                
            </div>
            <hr>
           
            
        </div>
    </article>
</div> 
		
		<?php
		
		}
		
		else {
			
			echo "<center><h2 style='color:red;'> Invalid Tracking Id </h2> </center>";
			
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function trackresult1()
	{
		
		
		
		$trackid = $this->input->post('trackid');
        $check = $this->model_user_panel->trackresult($trackid);
		
		if(isset($check)){
		$n =  $check["order_status"];
		
		?>
		
		 <div class="container">
    <article class="card">
        <header class="card-header"> My Orders / Tracking </header>
        <div class="card-body">
            <h4>Order ID: <?php echo "161030".$check["id"]; ?></h4>
            <article class="card">
                <div class="card-body row">
                    <div class="col-md-3"> <strong>Estimated Delivery time:</strong> <br><?php echo $check["order_date"]; ?> </div>
                    <div class="col-md-3"> <strong>Shipping BY:</strong> <br> WORLDEX, | <i class="fa fa-phone"></i> +1598675986 </div>
                    <div class="col-md-3"> <strong>Status:</strong> <br> 

                    <?php
					
					if($n==1){
						
						echo "Order is Confirmed";
					}
					else if($n==2){
						
						echo "Picked up by courier ";
					}
					else if($n==3){
						
						echo "Delivery On the Way ";
					}
					else if($n==4){
						
						echo "<b style='color:green;'> Delivery Completed </b>";
					}
					
					?>

					</div>
                    <div class="col-md-3"> <strong>Tracking #:</strong> <br> <?php echo $trackid; ?></div>
                </div>
            </article>
            <div class="track">
                <div class="step <?php if($n >= 1 ){ echo 'active';} ?> "> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
				
                <div class="step <?php if($n >= 2 ){ echo 'active';} ?>"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
				
                <div class="step <?php if($n >= 2 ){ echo 'active';} ?>"> <span class="icon"> <i class="fa fa-gift"></i> </span> <span class="text"> Packaging Proccessing </span> </div>
				
				
				<div class="step <?php if($n >= 3 ){ echo 'active';} ?>"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> Delivery On the way </span> </div>
				
				<div class="step <?php if($n >= 4 ){ echo 'active';} ?>"> <span class="icon">  <i class="fa fa-check"></i> </span> <span class="text"> Delivery Completed </span> </div>
				
                
            </div>
            <hr>
           
            
        </div>
    </article>
</div> 
		
		<?php
		
		}
		
		else {
			
			echo "<center><h2 style='color:red;'> Invalid Tracking Id </h2> </center>";
			
		}
	}
	
	
	
	
	
	
	public function percels()
	{
        $this->data['page_title'] = 'All Percel';
		
		$this->data['allcharge'] = $this->model_charge->fetchData();
		
		$this->data['district'] = $this->model_deliveryArea->fetchDistrictData();
		
		$this->data['allusershop'] = $this->model_user_shop->getShopData();
		$this->render_template2('home/dashboard/percel/index', $this->data);
	}
	
	
	
	public function payments()
	{
        $this->data['page_title'] = 'All Percel';
		
		$this->data['allusershop'] = $this->model_user_shop->getShopData();
		$this->render_template2('home/dashboard/payments/payments', $this->data);
	}
	
	
	
	public function paymentinfo()
	{
		
		$result = array('data' => array());

		$data = $this->model_user_panel->fetchpaymentmethod();

		foreach ($data as $key => $value) {
			// button
			
			

			
		
			
				$buttons = '...';
			

		
			if ($value["type"] == 1){
				
				$method = "Bkash Number: ".$value["bkash_number"];
			}
			else if ($value["type"] == 2){
				
				$method = "Bank Name: ".$value['bank_name']."<br/>Branch Name: ".$value['branch_name']."<br/>Account Name: ".$value['account_name']."<br/>Account Name: ".$value['account_type']."<br/>Account Number :".$value['account_number'];
				
			}
           
			
			$result['data'][$key] = array(
			    
				
				$method,
				
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	
	
	
	
	
	
	
	public function fetchFinalPaymentData()
	{
		$result = array('data' => array());
		
		$uid = $this->session->userdata('uid');

		$data = $this->model_user_panel->fetchFinalPaymentDataUser($uid);

		foreach ($data as $key => $value) {
			// button
			

			
		
				$buttons = '<button type="button" class="btn btn-default" onclick="detailsFunc('.$uid.')" data-toggle="modal" data-target=".bd-example-modal-lg">Payment Details<i class="fa fa-eye"></i></button>';
			
             $data1 = $this->model_user_panel->fetchFinalPaymentData1($value['user_id']);
			
				
			
			
              $shopname1 = $this->model_user_shop->getShopData1($value['shopname']);
			
			
			
			$marchant = $this->model_users->getUserDataforUser($value['user_id']);
				
			
            $total = $this->model_user_panel->getTotalPay($value['user_id']);
			
			$paid = $this->model_user_panel->getTotalpaid($value['user_id']);
			
			
			if($paid['SUM(`paid_amount`)'] == ""){
				
				$paid['SUM(`paid_amount`)'] = 0;
			}
			
			
			$due =$total['SUM(`total_payable`)'] - $paid['SUM(`paid_amount`)'];
			
			
			$status = ($due == 0) ? '<span class="label label-success">Payment Completed</span>' : '<span class="label label-warning">payment In Due</span>';
			
			
			
			
			
			
            $date = date("Y-m-d");
			$paymentstatus = "unpaid";
			$result['data'][$key] = array(
			    $date,
				$marchant['username'],
				
				
				$shopname1['shopname'],
				
				
				$total['SUM(`total_payable`)']." Taka, <br/>Marchant Bkash Number: ".$shopname1['pickup_phone'],
				$paid['SUM(`paid_amount`)']." Taka",
				$due." Taka",
				
				
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}
	
	
	
	
	
	public function showpaymentinfo($id)
	{
		
		
		if($id == 1){ ?>
			
			<div class="form-group">
										   <label>Your Bkash Number </label>
											<input type="number" name="bkash" class="form-control" />
										
										</div>
			
		<?php }
		else if($id == 2){ ?>
			
			<div class="form-group">
										   <label>Bank Name </label>
											<select id="bank" class="form-control" name="bank">
											<option >select a bank</option>
											  <option value="Islami Bank Bangladesh Limited">Islami Bank Bangladesh Limited</option>
											  <option value="Dutch Bangla Bank Limited">Dutch Bangla Bank Limited</option>
											  
											  <option value="Brac Bank">Brac Bank</option>
											 
											</select>
										
										</div>
										
										
										<div class="form-group">
										   <label>Branch Name </label>
											<input type="text" name="branch" class="form-control" />
										
										</div>
										
										
										<div class="form-group">
										   <label>Account Name </label>
											<input type="text" name="accountname" class="form-control" />
										
										</div>
										
										<div class="form-group">
										   <label>Account Type </label>
											<select id="account_type" class="form-control" name="account_type">
											<option >select an option</option>
											  <option value="Personal">Personal</option>
											  <option value="SME">SME</option>
											  
											  <option value="Business">Business</option>
											 
											</select>
										
										</div>
										
										<div class="form-group">
										   <label>Account Number </label>
											<input type="text" name="account_number" class="form-control" />
										
										</div>
										
										
		<?php }
		

		
	}
	
	
	
	
	
	public function fetchFinalPaymentDetailsData($id)
	{
		$result = array('data' => array());

		$data = $this->model_user_panel->fetchFinalPaymentDetailsData($id);
		
		$paid = $this->model_user_panel->getTotalPay($id);
		$pay = $this->model_user_panel->getTotalpaid($id);
		$due = $paid['SUM(`total_payable`)'] -  $pay['SUM(`paid_amount`)'];
        
		if($paid['SUM(`total_payable`)'] == ""){
			
			$paid['SUM(`total_payable`)'] = 0;
			
		}
		
		if($pay['SUM(`paid_amount`)'] == ""){
			
			$pay['SUM(`paid_amount`)'] = 0;
			
		}
		 
			 ?>
			 
			 <div class="row">
          <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $paid['SUM(`total_payable`)'];?></h3>

                <p>Total Due to Pay</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url('products/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3 ><?php echo $pay['SUM(`paid_amount`)'];?></h3>

                <p>Total Paid </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('orders/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  
		  
		  <div class="col-lg-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3 ><?php echo $due;?></h3>

                <p>Total Due </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('orders/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
		
		<hr/>
			
			<div class="box-body">
              <table id="manageTabled1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  
                 
				  
				  
				  <th>Payment Date</th>
				 
				  
				  <th>Paid Amount</th>
				  
				  <th>Transaction Info</th>
				  
				  
				  
				  <th>payment Status</th>
                 
                  <th>Action</th>
                 
                </tr>
                </thead>
                <tbody>
				
				
				

               
			
			<?php
			
		foreach ($data as $key => $value) {	
            
			
			$tnx = $value['tnx_id'];
			if($tnx != "" ){
				
				$val = explode(",",$tnx);
				$tnx_nmbr = $val[0];
				$marchant_nmbr = $val[1];
				$office_nmbr = $val[2];
				
				$tnx_info = "Tnx-id: ".$tnx_nmbr.",<br/>office number:".$marchant_nmbr.",<br/> Marchant bkash number: ".$office_nmbr;
				
			}
			else {
				
				$tnx_info = "none";
			}
			
			
				?>
			
			<tr>
			
			
			
			<td> <?php echo $value['payment_date'];?></td>
			<td><?php echo $value['paid_amount'];?> </td>
			<td><?php echo $tnx_info;?> </td>
			
			<td>details </td>
			
			<td>details </td>
			
			</tr>
			
			
			<?php
              //$shopname1 = $this->model_user_shop->getShopData1($value['shopname']);
			
			
			
			//$marchant = $this->model_users->getUserDataforUser($id);
				
			
		} ?>

         </tbody>
              </table>
            </div>

   <?php		

		
	}
	
	
}