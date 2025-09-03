<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Sms_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function bulk_sms() {
        $this->breadcrumbs->unshift(1, 'SMS', 'admin/sms');
        $this->breadcrumbs->unshift(1, 'Bulk Sms', 'admin/sms/bulk_sms');
        $this->page_title->push(('Bulk Sms'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Sms_model->loadroot();
        $this->data['products'] = $this->Sms_model->loadproduct();
        $location = $_SESSION['location'];
        $this->load->model('admin/Job_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/sms/bulk-sms', $this->data);
        } else {
            $this->template->admin_render('admin/sms/bulk-sms', $this->data);
        }
    }

    public function salesbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/sms');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/sms/salesbydate');
        $this->page_title->push(('Sale by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Sms_model->loadroot();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/sms/salesbydate', $this->data);
        } else {
            $this->template->admin_render('admin/sms/salesbydate2', $this->data);
        }
    }

    public function customerjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Sms_model->searchcustomer($q);
            echo json_encode($result);
            die;
        }
    }

    public function loadjobdelivery() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Sms_model->jobdelivery($startdate, $enddate, $route,$isall,$customer);
       echo json_encode($result);
       die;
        
    }

    public function loadcustomercredit() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $customer_ar   = isset($_POST['customer_ar']) ? json_decode($_POST['customer_ar']) : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Sms_model->activecustomers($startdate, $enddate, $route,$isall,$customer,$customer_ar );
    
        echo json_encode($result);
        die;
        
    }

    public function sendbulksms(){

        $msg =$_POST['msg'];
        $recipt =$_POST['mobiles'];

        $user = "94753778021";
        $password = "9267";
        $text = urlencode($msg);
        $to = $recipt;

      
         
        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text&eco=Y";

        $ret = file($url);
         
        $res= explode(":",$ret[0]);

        
         
        if (trim($res[0])=="OK")
        {
        echo "Message Sent - ID : ".$res[1];
        }
        else
        {
        echo "Sent Failed - Error : ".$res[1];
        }

        die;
    }

     public function checkCreditBalance(){

        $user = "94753778021";
        $password = "9267";
         
        $baseurl ="http://www.textit.biz/creditchk/index.php";
        $url = "$baseurl/?id=$user&pw=$password";
        
        $ret = file($url);

        echo ($ret[0]);die;
        
    }

}
