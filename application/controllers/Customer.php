<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->helper('number');
        $this->load->model('admin/Customer_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function addcustomer() {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'admin/customer');
        $this->page_title->push(lang('menu_addcustomer'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('customer/view_addcustomer', $this->data);
    }

    public function customersync() {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'admin/customer');
        $this->page_title->push('Customer Synchronization');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('customer/customersync', $this->data);
    }
    
     public function view_customer($id=null) {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'admin/customer');
        $this->page_title->push('View Customer');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['vdata'] = $this->Customer_model->selectVehicledata($id);
        $this->data['cusdata'] = $this->Customer_model->selectCustomerdata($id);
        $this->data['paytype'] = $this->Customer_model->loadpaytype();
        $this->load->view('customer/view_customer', $this->data);
    }

    public function view_vehicles() {
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/customer/addcustomer');
        $this->breadcrumbs->unshift(1, 'View Vehicles', 'admin/view_vehicles');
        $this->page_title->push('View Vehicles');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('customer/view_vehicles', $this->data);
    }

    public function view_vehicle($id=null) {
        $id=base64_decode($id);
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/customer/addcustomer');
        $this->breadcrumbs->unshift(1, 'Vehicles', 'admin/view_vehicles');
        $this->page_title->push('Vehicle Summary - '.$id);
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['regno'] = $id;
        //veicle details
        $this->data['vehi'] = $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,vehicledetail.EngineNo')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('fuel_type','fuel_type.fuel_typeid=vehicledetail.FuelType','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$id)->get()->row();
        
        $isAnyjob = $this->db->select('JRegNo')->from('jobcardhed')->where('JRegNo',$id)->get()->num_rows();
        if($isAnyjob>0){
            $this->data['lastserv'] = $this->db->select('jobcardhed.*,Max(appoimnetDate) AS Date')->from('jobcardhed')->where('JRegNo',$id)->where('IsCancel',0)->get()->row();
            $this->data['jobs'] = $this->db->select('jobcardhed.*,DATE(jobcardhed.appoimnetDate) AS appoimnetDate ,customer.DisplayName,users.first_name ,users.last_name')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->join('users','users.id=jobcardhed.serviceAdvisor')->where('JRegNo',$id)->where('IsCancel',0)->order_by('appoimnetDate')->get()->result();
        }else{
            $this->data['lastserv'] =null;
            $this->data['jobs'] = null;
        }
        

        //all Services  
        $result=$this->db->select('jobinvoicedtl.*,jobtype.jobtype_name AS Description , jobtypeheader.jobhead_name AS SubDescription')->from('jobinvoicedtl')->join('jobinvoicehed', 'jobinvoicedtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER')->join('jobtype', 'jobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER')->join('jobtypeheader', 'jobtypeheader.jobhead_id = jobtype.jobhead', 'INNER')->where('jobinvoicehed.JRegNo', $id)->order_by('jobtypeheader.jobhead_order', 'ASC')->order_by('jobtype.jobtype_order', 'ASC')->order_by('jobinvoicedtl.JobinvoiceTimestamp','desc')->order_by('jobinvoicedtl.EstLineNo', 'ASC')->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        $this->data['invDtl']=$list; 


        $this->template->admin_render('customer/view_vehicle', $this->data);
    }

    public function loadmodal_customeredit($id) {
        $this->data['title'] = $this->Customer_model->selecttitles();
        $this->data['make'] = $this->Customer_model->selectmake();
        $this->data['model'] = $this->Customer_model->selectmodel();
        $this->data['fuel'] = $this->Customer_model->selectfuel();
        $this->data['color'] = $this->Customer_model->selectcolor();
        $this->data['cusid'] = $id;
        $this->data['vdata'] = $this->Customer_model->selectVehicledata($id);
        $this->data['cusdata'] = $this->Customer_model->selectCustomerdata($id);
        $this->data['paytype'] = $this->Customer_model->loadpaytype();
        $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
        $this->data['emp'] = $this->db->select()->from('salespersons')->get()->result();
        $this->data['cat'] = $this->db->select()->from('customer_category')->get()->result();
        $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->get()->result();
        $this->load->view('customer/customeredit_modal', $this->data);
    }

    public function loadmodal_vehicleadd($id) {
        $this->data['cusCode'] = $id;
        $this->data['make'] = $this->Customer_model->selectmake();
        $this->data['model'] = $this->Customer_model->selectmodel();
        $this->data['fuel'] = $this->Customer_model->selectfuel();
        $this->data['color'] = $this->Customer_model->selectcolor();
        $this->data['paytype'] = $this->Customer_model->loadpaytype();
        $this->load->view('customer/vehicleadd_modal',$this->data);
    }

    public function loadmodal_vehicleedit($id) {
        $this->data['vehicleId'] = $id;
        $this->data['make'] = $this->Customer_model->selectmake();
        $this->data['model'] = $this->Customer_model->selectmodel();
        $this->data['fuel'] = $this->Customer_model->selectfuel();
        $this->data['color'] = $this->Customer_model->selectcolor();
        $this->data['paytype'] = $this->Customer_model->loadpaytype();
        // $this->data['vdata'] = $this->db->select('*')->from('vehicledetail')->where('VehicleId',$id)->get()->result();
        $this->load->view('customer/vehicleedit_modal',$this->data);
    }

    public function loadmodal_customeradd($q=null) {
        $this->data['q'] = $q;
        $this->data['title'] = $this->Customer_model->selecttitles();
        $this->data['make'] = $this->Customer_model->selectmake();
        $this->data['model'] = $this->Customer_model->selectmodel();
        $this->data['fuel'] = $this->Customer_model->selectfuel();
        $this->data['color'] = $this->Customer_model->selectcolor();
        $this->data['paytype'] = $this->Customer_model->loadpaytype();
        $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
        $this->data['emp'] = $this->db->select()->from('salespersons')->get()->result();
        $this->data['cat'] = $this->db->select()->from('customer_category')->get()->result();
        $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->get()->result();
        $this->load->view('customer/customeradd_modal', $this->data);
    }

    public function savecustomer() {
        // print_r($_POST); die;
        // $data['CusCode'] = $_POST['cusCode'];
        $date = date("Y-m-d H:i:s");
        $data['respectSign'] = $_POST['respectSign'];
        $data['DisplayName'] = $_POST['displayName'];
        $data['CusName'] = $_POST['cusName'];
        $data['LastName'] = $_POST['LastName'];
        $data['CusType'] = $_POST['cusType'];
        $data['DisType'] = $_POST['displayType'];
        $data['CusCompany'] = $_POST['companyName'];
        $data['DocNo'] = $_POST['docNo'];
        $data['JoinDate'] = date("Y-m-d h:i:s");
        $data['HandelBy'] = $_POST['salesperson'];
        $data['CusBookNo'] = $_POST['cusNo'];
        $data['CusCategory'] = $_POST['category'];
        $data['Address01'] = $_POST['address'];
        $data['MobileNo'] = $_POST['mobileNo'];
        $data['LanLineNo'] = $_POST['phoneNo'];
        $data['WorkNo'] = $_POST['workPhone'];
        $data['ContactPerson'] = $_POST['contactName'];
        $data['ContactNo'] = $_POST['contactPhone'];
        $data['ComAddress'] = $_POST['companyaddress'];
        $data['Email'] = $_POST['email'];
        $data['CreditLimit'] = $_POST['creditLimit'];
        $data['BalanaceAmount'] = $_POST['balanaceAmount'];
        $data['BalanceDate'] = $_POST['balanceDate'];
        $data['remark'] = $_POST['remark'];

        $data['payMethod'] = $_POST['payMethod'];

        if (isset($_POST['isCredit'])) {
            $data['IsAllowCredit'] = 1;
        } else {
            $data['IsAllowCredit'] = 0;
        }

        if (isset($_POST['Isvehicle'])) {
            $Isvehicle = 1;
        } else {
            $Isvehicle = 0;
        }

        // if (isset($_POST['isActive'])) {
            $data['IsActive'] = 1;
        // } else {
        //     $data['IsActive'] = 0;
        // }

        $cdata['CusTotalInvAmount']=0;
        $cdata['CusOustandingAmount']=$_POST['balanaceAmount'];
        $cdata['CusSettlementAmount']=0;
        $cdata['OpenOustanding']=$_POST['balanaceAmount'];
        $cdata['OustandingDueAmount']=0;

        $vdata['contactName'] = $_POST['contactName'];
        $vdata['ChassisNo'] = $_POST['chassisNo'];
        $vdata['RegNo'] = preg_replace('/\s+/', ' ', $_POST['regNo']);
        $vdata['EngineNo'] = $_POST['engineNo'];
        $vdata['ManufactureYear'] = $_POST['manufactureYear'];
        $vdata['Make'] = $_POST['make'];
        $vdata['Model'] = $_POST['model'];
        $vdata['Color'] = $_POST['codeColor'];
        $vdata['FuelType'] = $_POST['fuel'];

        $cInv['AppNo'] = '1';
        $cInv['Type'] = 4;
        $cInv['InvoiceDate'] = $_POST['balanceDate']; 
        // $cInv['InvoiceNo'] = $openOutCode;
        $cInv['Location'] =$_SESSION['location']; 
        $cInv['NetAmount'] = $_POST['balanaceAmount']; 
        $cInv['CreditAmount'] = $_POST['balanaceAmount'];
        $cInv['SettledAmount'] = 0;
        $cInv['IsCloseInvoice'] = 0; 
        $cInv['IsCancel'] = 0;

        if($Isvehicle ==1 ){
            //check duplicate vehicles
            $isdupvehicle = $this->db->select('model')->from('vehicledetail')->where('RegNo',$_POST['RegNo'])->get()->num_rows();

            //deactivate old vehicles
            if($isdupvehicle>0){
                $this->db->update('vehicledetail',array('IsActive' =>0),array('RegNo' =>$_POST['RegNo']));
            }

            $ismodel = $this->db->select('model')->from('model')->where('makeid',$_POST['make'])->where('model',$_POST['model'])->get()->num_rows();

            if($ismodel==0){
                // save model not exist
                $this->db->insert('model',array('model' =>$_POST['model'],'makeid' =>$_POST['make'],'model_code' =>$_POST['modelcode']));
                $model_id = $this->db->insert_id();
                $vdata['Model'] = $model_id;
            }elseif ($ismodel==1) {
                // get model if exist
                $model_id = $this->db->select('model_id')->from('model')->where('makeid',$_POST['make'])->where('model',$_POST['model'])->get()->row()->model_id;
                $vdata['Model'] = $model_id;
            }
        }
        
      
        $res2 = $this->Customer_model->insert_data('customer', $data, $vdata,$cdata,$cInv,$Isvehicle);
        $return = array(
            'ccode' => $ccode,
            'regno' => $regno
        );

       echo $res2;
        die();
    }

    public function savevehicle() {
         //remove white spaces
        $regNo = preg_replace('/\s+/', ' ', $_POST['regNo']);

        $vdata['CusCode'] = $_POST['cusCode'];
        $vdata['contactName'] = $_POST['contactName'];
        $vdata['ChassisNo'] = $_POST['chassisNo'];
        $vdata['RegNo'] = $regNo;
        $vdata['EngineNo'] = $_POST['engineNo'];
        $vdata['ManufactureYear'] = $_POST['manufactureYear'];
        $vdata['Make'] = $_POST['make'];
        $vdata['Model'] = $_POST['model'];
        $vdata['Color'] = $_POST['codeColor'];
        $vdata['FuelType'] = $_POST['fuel'];

        //check vehicle already exist
        $isVehi = $this->db->select('RegNo')->from('vehicledetail')->where('RegNo', $regNo)->where('CusCode', $_POST['cusCode'])->get()->num_rows();
        if($isVehi<=0){
            if($this->db->insert('vehicledetail', $vdata)) {
                echo 'success';
            }
        }else{
            echo 2;
        }
        die();
    }

    public function editsavecustomer() {
        $userid = $_POST['userid'];
        $data['respectSign'] = $_POST['respectSign'];
        $data['DisplayName'] = $_POST['displayName'];
        $data['CusName'] = $_POST['cusName'];
        $data['LastName'] = $_POST['LastName'];
        $data['CusType'] = $_POST['cusType'];
        $data['DisType'] = $_POST['displayType'];
        $data['CusCompany'] = $_POST['companyName'];
        $data['DocNo'] = $_POST['docNo'];
        $data['JoinDate'] = date("Y-m-d h:i:s");
        $data['HandelBy'] = $_POST['salesperson'];
        $data['CusBookNo'] = $_POST['cusNo'];
        $data['CusCategory'] = $_POST['category'];
        $data['Address01'] = $_POST['address'];
        $data['MobileNo'] = $_POST['mobileNo'];
        $data['LanLineNo'] = $_POST['phoneNo'];
        $data['WorkNo'] = $_POST['workPhone'];
        $data['ContactPerson'] = $_POST['contactName'];
        $data['ContactNo'] = $_POST['contactPhone'];
        $data['ComAddress'] = $_POST['companyaddress'];
        $data['Email'] = $_POST['email'];
        $data['CreditLimit'] = $_POST['creditLimit'];
        $data['BalanaceAmount'] = $_POST['balanaceAmount'];
        $data['BalanceDate'] = $_POST['balanceDate'];
        $data['remark'] = $_POST['remark'];
        $date = $_POST['balanceDate'];

        $data['payMethod'] = $_POST['payMethod'];

        // $cInv['AppNo'] = '1';
        // $cInv['Type'] = 4;
        // $cInv['InvoiceDate'] = $_POST['balanceDate']; 
        // // $cInv['InvoiceNo'] = $openOutCode;
        // $cInv['Location'] =$_SESSION['location']; 
        // $cInv['NetAmount'] = $_POST['balanaceAmount']; 
        // $cInv['CreditAmount'] = $_POST['balanaceAmount'];
        // $cInv['IsCloseInvoice'] = 0; 
        // $cInv['IsCancel'] = 0;

        if (isset($_POST['isCredit'])) {
            $data['IsAllowCredit'] = 1;
        } else {
            $data['IsAllowCredit'] = 0;
        }

        if (isset($_POST['isActive'])) {
            $data['IsActive'] = 1;
        } else {
            $data['IsActive'] = 0;
        }

        $balanaceAmount =  $this->db->select('balanaceAmount')->from('customer')->where('CusCode',$userid)->get()->row()->balanaceAmount;
        $credit =  $this->db->select('CusOustandingAmount')->from('customeroutstanding')->where('CusCode',$userid)->get()->row()->CusOustandingAmount;

        if($balanaceAmount==0){
            $cInv['AppNo'] = '1';
            $cInv['InvoiceDate'] = $date; 
            $cInv['CusCode'] = $userid;
            $cInv['Location'] =$_SESSION['location']; 
            $cInv['NetAmount'] = $_POST['balanaceAmount']; 
            $cInv['CreditAmount'] = $_POST['balanaceAmount'];
            $cInv['SettledAmount'] = 0;
            $cInv['IsCloseInvoice'] = 0; 
            $cInv['IsCancel'] = 0;

            $openOutCode = $this->Customer_model->get_max_code('Customer Open Outstanding');
            $cInv['InvoiceNo'] = $openOutCode;
            $this->db->insert('creditinvoicedetails', $cInv);
            $this->Customer_model->update_max_code('Customer Open Outstanding');
            $this->db->update('customeroutstanding', array('OpenOustanding' => ($_POST['balanaceAmount'])),array('CusCode' => $userid));
            $this->db->update('customeroutstanding', array('CusOustandingAmount' => ($_POST['balanaceAmount']+$credit)),array('CusCode' => $userid));
        }else{
            $cInv['AppNo'] = '1';
            $cInv['InvoiceDate'] = $date; 
            $cInv['CusCode'] = $userid;
            $cInv['Location'] =$_SESSION['location']; 
            $cInv['NetAmount'] = $_POST['balanaceAmount']; 
            $cInv['CreditAmount'] = $_POST['balanaceAmount'];
            // $cInv['SettledAmount'] = 0;
            $cInv['IsCloseInvoice'] = 0; 
            $cInv['IsCancel'] = 0;

            $InvoiceNo =  $this->db->select('InvoiceNo')->from('creditinvoicedetails')->where('CreditAmount',$balanaceAmount)->where('CusCode',$userid)->get()->row()->InvoiceNo;

            // $openOutCode = $this->Customer_model->get_max_code('Customer Open Outstanding');
            $cInv['InvoiceNo'] = $InvoiceNo;
            // $this->db->insert('creditinvoicedetails', $cInv);
            $this->db->update('creditinvoicedetails', $cInv ,array('CusCode' => $userid,'InvoiceNo'=>$InvoiceNo));
            // $this->Customer_model->update_max_code('Customer Open Outstanding');
            $this->db->update('customeroutstanding', array('OpenOustanding' => ($_POST['balanaceAmount'])),array('CusCode' => $userid));
            $this->db->update('customeroutstanding', array('CusOustandingAmount' => ($_POST['balanaceAmount']-$balanaceAmount+$credit)),array('CusCode' => $userid));
        }

        if ($this->Customer_model->update_data('customer', $data, $userid)) {
            echo 'success';
        }                     
        die();
    }
    
    public function editsavevehicle() {
         //remove white spaces
        $regNo = preg_replace('/\s+/', ' ', $_POST['regNo']);
        
        $vehicleId = $_POST['vehicleId'];
        $data['contactName'] = $_POST['contactName'];
        $data['RegNo'] = $regNo;
        $data['ChassisNo'] = $_POST['chassisNo'];
        $data['EngineNo'] = $_POST['engineNo'];
        $data['Make'] = $_POST['make'];
        $data['Model'] = $_POST['model'];
        $data['FuelType'] = isset($_POST['fuel'])?$_POST['fuel']:'';
        $data['Color'] = isset($_POST['codeColor'])?$_POST['codeColor']:'';
        $data['ManufactureYear'] = isset($_POST['manufactureYear'])?$_POST['manufactureYear']:'';

        // get last vehicle no
        $prevRegNo =  $this->db->select('RegNo')->from('vehicledetail')->where('VehicleId',$vehicleId)->get()->row()->RegNo;

        if($prevRegNo==$regNo){
           $res = $this->db->update('vehicledetail', $data,array('VehicleId' => $vehicleId));
        }else{
           $res = $this->db->update('vehicledetail', $data,array('VehicleId' => $vehicleId));
           //update whole system inovices
           //update job invoice
            $isJobInv = $this->db->select()->from('jobinvoicehed')->where('JRegNo', $prevRegNo)->get()->num_rows();
            if($isJobInv>0){
                $this->db->update('jobinvoicehed',array('JRegNo' => $regNo),array('JRegNo' => $prevRegNo));
            }

            //update temp job invoice
            $isTmpJobInv = $this->db->select()->from('tempjobinvoicehed')->where('JRegNo', $prevRegNo)->get()->num_rows();
            if($isTmpJobInv>0){
                $this->db->update('tempjobinvoicehed',array('JRegNo' => $regNo),array('JRegNo' => $prevRegNo));
            }

            //update sales invoice
            $isSalesInv = $this->db->select()->from('salesinvoicehed')->where('SalesVehicle', $prevRegNo)->get()->num_rows();
            if($isSalesInv>0){
                $this->db->update('salesinvoicehed',array('SalesVehicle' => $regNo),array('SalesVehicle' => $prevRegNo));
                // $this->db->update('salesinvoicepaydtl',array('InvCusCode' => $to),array('InvCusCode' => $from));
            }

            //update jobs
            $isJobs = $this->db->select()->from('jobcardhed')->where('JRegNo', $prevRegNo)->get()->num_rows();
            if($isJobs>0){
                $this->db->update('jobcardhed',array('JRegNo' => $regNo),array('JRegNo' => $prevRegNo));
            }

            //update estimate
            $isest = $this->db->select()->from('estimatehed')->where('EstRegNo', $prevRegNo)->get()->num_rows();
            if($isest>0){
                $this->db->update('estimatehed',array('EstRegNo' => $regNo),array('EstRegNo' => $prevRegNo));
            }

        }

        if($res==1){
            echo 'success';
        } else {
            echo 'error';
        }
        die();
    }

    // public function allCustomers2() {
    //     $this->load->library('Datatables');
    //     $this->datatables->select('*');
    //     $this->datatables->from('customer');
    //     echo $this->datatables->generate();
    //     die();
    // }

    public function allCustomers() {
        $this->load->library('Datatables');
        $this->datatables->select('customer.CusCode,customer.IsActive,customer.CusBookNo,customer.MobileNo,customer.CusName,
        customer.LastName,customer.CreditLimit,customeroutstanding.CusOustandingAmount');
        $this->datatables->from('customer');
        $this->datatables->join('customeroutstanding','customeroutstanding.CusCode=customer.CusCode');
        // $this->datatables->unset_column('customeroutstanding.CusCode');
        echo $this->datatables->generate();
        die();
    }

    public function allVehicles() {
        $this->load->library('Datatables');
        $this->datatables->select('vehicledetail.*,model.model,make.make,customer.CusName,customer.MobileNo');
        $this->datatables->from('vehicledetail');
        $this->datatables->join('customer','customer.CusCode=vehicledetail.CusCode', 'left');
        $this->datatables->join('model','model.model_id=vehicledetail.Model', 'left');
        $this->datatables->join('make','make.make_id=model.makeid', 'left');
        echo $this->datatables->generate();
        die();
    }

    public function loadacustomersjson() {
        $query = $_GET['q'];
        echo $this->Customer_model->loadcustomersjson($query); die;
    }

    public function loadtocustomersjson() {
        $query = $_GET['q'];
        $from = $_GET['from'];
        echo $this->Customer_model->loadtocustomersjson($query, $from); die;
    }

    public function loadmodelbymake($q) {
        echo $this->Customer_model->loadmodelbymake($q); die;
    }
    public function selectVehicledata($vno) {
        echo $this->Customer_model->selectVehicledata($vno); die;
    }
    public function selectVehicledatajson() {
        $vno = $_POST['vno'];
        $data['vehicledata'] = $this->db->select()->from('vehicledetail')->where('VehicleId', $vno)->get()->row_array();
        // echo ($data['vehicledata']['Make']); die;
        $data['makedata'] = $this->db->select('model_id,model')->from('model')->where('makeid',$data['vehicledata']['Make'])->get()->result_array();
        echo json_encode($data); die;
    }

    public function check_cusname() {
        if (isset($_REQUEST['fname'])) {
            $q = ($_REQUEST['fname']);
            $isPro = $this->db->select('CusName')->from('customer')->like('CusName', $q)->get()->num_rows();
            if($isPro>0){
                echo 1;
            }else{
                echo 2;
            }
            die;
        }
    }

    public function check_chassi() {
        if (isset($_REQUEST['chassis'])) {
            $q = ($_REQUEST['chassis']);
            $isPro = $this->db->select('ChassisNo')->from('vehicledetail')->where('ChassisNo', $q)->get()->num_rows();
            if($isPro>0){
                echo 1;
            }else{
                echo 2;
            }
            die;
        }
    }

    public function check_regno() {
        if (isset($_REQUEST['regno'])) {
            $q = ($_REQUEST['regno']);
            $isPro = $this->db->select('RegNo')->from('vehicledetail')->where('RegNo', $q)->get()->num_rows();
            if($isPro>0){
                echo 1;
            }else{
                echo 2;
            }
            die;
        }
    }

    public function saveCustomerSync(){
        $from=$_POST['fromcustomer'];
        $to=$_POST['tocustomer'];

        $this->db->trans_start();
        
        //update vehicle
        $isVehi = $this->db->select()->from('vehicledetail')->where('CusCode', $from)->get()->num_rows();
        if($isVehi>0){
            $this->db->update('vehicledetail',array('CusCode' => $to),array('CusCode' => $from));
        }

        //update job invoice
        $isJobInv = $this->db->select()->from('jobinvoicehed')->where('JCustomer', $from)->get()->num_rows();
        if($isJobInv>0){
            $this->db->update('jobinvoicehed',array('JCustomer' => $to),array('JCustomer' => $from));
            $this->db->update('jobinvoicepaydtl',array('InsCompany' => $to),array('InsCompany' => $from));
        }

        //update pos invoice
        $isPosInv = $this->db->select()->from('invoicehed')->where('InvCustomer', $from)->get()->num_rows();
        if($isPosInv>0){
            $this->db->update('invoicehed',array('InvCustomer' => $to),array('InvCustomer' => $from));
            $this->db->update('invoicepaydtl',array('InvCusCode' => $to),array('InvCusCode' => $from));
        }

        //update sales invoice
        $isSalesInv = $this->db->select()->from('salesinvoicehed')->where('SalesCustomer', $from)->get()->num_rows();
        if($isSalesInv>0){
            $this->db->update('salesinvoicehed',array('SalesCustomer' => $to),array('SalesCustomer' => $from));
            // $this->db->update('salesinvoicepaydtl',array('InvCusCode' => $to),array('InvCusCode' => $from));
        }

        //update jobs
        $isJobs = $this->db->select()->from('jobcardhed')->where('JCustomer', $from)->get()->num_rows();
        if($isJobs>0){
            $this->db->update('jobcardhed',array('JCustomer' => $to),array('JCustomer' => $from));
        }

        //update customerpaymenthed
        $ispay = $this->db->select()->from('customerpaymenthed')->where('CusCode', $from)->get()->num_rows();
        if($ispay>0){
            $this->db->update('customerpaymenthed',array('CusCode' => $to),array('CusCode' => $from));
        }

        //update estimate
        $isest = $this->db->select()->from('estimatehed')->where('EstCustomer', $from)->get()->num_rows();
        if($isest>0){
            $this->db->update('estimatehed',array('EstCustomer' => $to),array('EstCustomer' => $from));
        }

        //credit invoice
        $isCredit = $this->db->select()->from('creditinvoicedetails')->where('CusCode', $from)->get()->num_rows();
        if($isCredit>0){
            $this->db->update('creditinvoicedetails',array('CusCode' => $to),array('CusCode' => $from));
        }
        //update oustanding
        $credit = $this->db->select('CusOustandingAmount')->from('customeroutstanding')->where('CusCode', $from)->get()->row()->CusOustandingAmount;
        $invamount = $this->db->select('CusTotalInvAmount')->from('customeroutstanding')->where('CusCode', $from)->get()->row()->CusTotalInvAmount;
        if($credit>0){
            $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$to','$invamount','$credit');");
        }

        $this->db->update('customer',array('IsActive' => 0),array('CusCode' => $from));

        $this->db->trans_complete();
        $res2= $this->db->trans_status();
        echo $res2;die;
    }

    

}
