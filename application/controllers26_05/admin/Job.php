<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Job_model');
        date_default_timezone_set("Asia/Colombo");
        $title='';
        $titleno='';
    }

    public function index() {

        $user_id = $_SESSION['user_id'];
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $cuscode = isset($_GET['ccode'])?$_GET['ccode']:0;
        $regno = isset($_GET['regno'])?$_GET['regno']:0;

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Create Job Card');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/job/index');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
            $this->data['paytype'] = $this->db->select()->from('paytype')->get()->result();
            $this->data['jobcategory'] = $this->db->select()->from('jobcategory')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobcondtion'] = $this->db->select()->from('job_condition')->get()->result();
            $this->data['jobsection'] = $this->db->select()->from('job_section')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            
            $role =$this->db->select('role')->from('users')->where('id', $user_id)->get()->row()->role;

            if($role == '3'){
                $this->data['advisor']= $this->db->select('users.first_name,users.last_name,users.phone,users.id')->from('users')->get()->result();
            }else{
            $this->data['advisor']= $this->db->select('users.first_name,users.last_name,users.phone,users.id')->from('users')->where('id',$user_id)->get()->result();
            }
            
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            $this->data['regno'] = base64_decode($regno);
            $this->data['cuscode'] = base64_decode($cuscode);
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));

            /* Load Template */
            $this->template->admin_render('admin/job/index', $this->data);
        }
    }
    //view all jobs
    public function view_job() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('All Job Cards');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/job/view_job');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobcondtion'] = $this->db->select()->from('job_condition')->get()->result();
            $this->data['jobsection'] = $this->db->select()->from('job_section')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['advisor']= $this->db->select('users.first_name,users.last_name,users.phone')->from('users')->where('role',4)->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));

            /* Load Template */
            $this->template->admin_render('admin/job/view-job', $this->data);
        }
    }

    public function edit_job($jno=null) {
        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Edit Job Card');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Edit Job Card', 'admin/job/edit_job');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            $this->data['paytype'] = $this->db->select()->from('paytype')->get()->result();
            
            $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
            $this->data['jobcategory'] = $this->db->select()->from('jobcategory')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobcondtion'] = $this->db->select()->from('job_condition')->get()->result();
            $this->data['jobsection'] = $this->db->select()->from('job_section')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            $this->data['advisor']= $this->db->select('users.first_name,users.last_name,users.phone,users.id')->from('users')->where('role',4)->get()->result();
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));
           
            $jobNo = base64_decode($jno);
            $this->data['JobNo']  = $jobNo;
            $this->data['JobHed'] = $this->db->select('*')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
            
            $result = $this->db->select('jobcardtype.JobTypeId')->from('jobcardtype')->where('JobCardNo', $jobNo)->get();
            
            $list = array();
            foreach ($result->result() as $row) {
                array_push($list,$row->JobTypeId);
                // $list = $row->JobTypeId;
            }
            $this->data['job_type'] =$list;
            /* Load Template */
            $this->template->admin_render('admin/job/edit-job', $this->data);
        }
    }

    public function view_job_card($jno=null) {
        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            $jno=base64_decode($jno);
            /* Title Page */
            $this->page_title->push('View Job Card');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job_card');
            $this->breadcrumbs->unshift(1, 'Edit Job Card', 'admin/job/view_job_card');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $this->load->helper('url');
            /* Data */
            $location = $this->db->select('JLocation')->from('jobcardhed')->where('JobCardNo',$jno)->get()->row()->JLocation;
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            $this->data['jobStatus'] = $this->db->select()->from('job_status')->get()->result();
            $this->data['salesperson'] = $this->db->select()->from('salespersons')->where('IsTec',1)->where('IsActive',1)->get()->result();
            $this->data['loc'] = $this->db->select()->from('location')->get()->result();
            
            $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobcondtion'] = $this->db->select()->from('job_condition')->get()->result();
            $this->data['jobsection'] = $this->db->select()->from('job_section')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['jobpo'] = $this->db->select('DATE(PO_Date) AS PO_Date,PO_No,PO_NetAmount')->from('purchaseorderhed')->where('JobNo',$jno)->get()->result();
            $this->data['estimate'] = $this->db->select('DATE(EstDate) AS EstDate,EstimateNo,Supplimentry,EstNetAmount')->from('estimatehed')->where('EstJobCardNo',$jno)->get()->result();
            $this->data['job_doc'] = $this->db->select()->from('job_document')->where('job_no',$jno)->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));
            $this->data['JobNo'] = $jno;
            $this->data['jobHed'] = $this->db->select('jobcardhed.*,(jobcardhed.deliveryDate) AS deliveryDate,job_status.status_name,users.first_name, paytype.payType, appoimnetDate')->from('jobcardhed')->join('job_status','job_status.status_id=jobcardhed.IsCompelte')->join('users','jobcardhed.JInvUser=users.id','left')->join('paytype','jobcardhed.JPayType=paytype.payTypeId','left')->where('JobCardNo',$jno)->get()->row();
            $this->data['jobSerAdv'] = $this->db->select('users.first_name, users.last_name, users.phone')->from('jobcardhed')->join('users','jobcardhed.serviceAdvisor=users.id','left')->where('JobCardNo',$jno)->get()->row();
            $this->data['jobDtl'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo',$jno)->get()->result();
            $cusCode =  $this->db->select('JCustomer')->from('jobcardhed')->where('JobCardNo',$jno)->get()->row()->JCustomer;
            $regNo =  $this->db->select('JRegNo')->from('jobcardhed')->where('JobCardNo',$jno)->get()->row()->JRegNo;
            $location =  $this->db->select('JLocation')->from('jobcardhed')->where('JobCardNo',$jno)->get()->row()->JLocation;
            $appoimnetDate =$this->db->select('appoimnetDate')->from('jobcardhed')->where('JobCardNo', $jno)->get()->row()->appoimnetDate;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')
//                ->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')
                ->join('paytype','paytype.payTypeId=customer.payMethod')
                ->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,vehicledetail.Color AS body_color,fuel_type.fuel_type')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('fuel_type','fuel_type.fuel_typeid=vehicledetail.FuelType','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();
            $this->data['error']='';

           $this->data['job_count'] = $this->db->select('count(JobCardNo)  AS noofjobs')->from('jobcardhed')->where('JRegNo', $regNo)->where('JCustomer', $cusCode)->where('IsCancel', 0)->where('appoimnetDate<', $appoimnetDate)->get()->row();
           $this->data['branch']=$this->db->select('branch_address.*,company.CompanyName,company.CompanyName2')->from('branch_address')->join('company', 'company.CompanyID = branch_address.company_id')->where('loc_id',$location)->get()->row();
            $this->data['workers'] = $this->db->select('jobwoker.*,salespersons.RepName,emp_type.EmpType')->from('jobwoker')->join('salespersons','jobwoker.JobWokerId=salespersons.RepID')->join('emp_type','emp_type.EmpTypeNo=salespersons.RepType')->where('jobwoker.JCardNo',$jno)->get()->result();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $jno)->where('editinvoices.EditType', 5)->order_by('UpdateDate','DESC')->get()->result();
                // array('error' => ' ' )
            /* Load Template */
            $this->template->admin_render('admin/job/view-job-card', $this->data);
        }
    }

    public function do_upload(){
        $jobno = $_POST['jobNo'];
        // echo $jobno;die;
        $config['upload_path']          = './upload/job_doc';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $invuser = $_SESSION['user_id'];
        // $filename           =  $jobno."_".uniqid();
    
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            echo print_r($error);die;
                // $this->Job_model->update_max_code('JobNumber');
        }else{
            $data = array('upload_data' => $this->upload->data());
            $invDate =date("Y-m-d H:i:s");
            $doc_name =$this->upload->data('file_name');
            $job_data = array('job_no' => $jobno,'doc_name' => $doc_name,'upload_by' => $invuser,'upload_date' => $invDate );
            $this->db->insert('job_document',$job_data);
            $jobencode = base64_encode($jobno);
            redirect('admin/job/view_job_card/'.$jobencode, 'refresh');
            // die;
        }
    }   

    public function estimate_job() {

        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $sup = isset($_GET['sup'])?$_GET['sup']:0;
        $cuscode = isset($_GET['ccode'])?$_GET['ccode']:0;
        $regno = isset($_GET['regno'])?$_GET['regno']:0;

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Estimate Job');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Estimate Job', 'admin/job/estimate_job');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['worktype'] = $this->db->select('jobtype.*,jobtypeheader.jobhead_name')->from('jobtype')->join('jobtypeheader','jobtypeheader.jobhead_id=jobtype.jobhead')->get()->result();
            // $this->data['parttype'] = $this->db->select()->from('parttype')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobtype'] = $this->db->select()->from('estimate_jobtype')->get()->result();
            $this->data['estimate_type'] = $this->db->select()->from('estimate_type')->get()->result();

            $this->data['parttype'] = $this->db->select('ShortName  AS parttype_code')->from('productquality')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            $this->data['terms'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));
            $this->data['JobNo'] = '';
            $this->data['EstimateNo'] ='';
            $this->data['regNo'] ='';
            $this->data['cusCode'] ='';

            if($type=='inv'){
                $this->data['JobInvoiceNo'] = base64_decode($id);
            }elseif($type=='job'){
                $this->data['JobNo'] = base64_decode($id);
            }elseif($type=='est'){
                $this->data['EstimateNo'] = base64_decode($id);
            }elseif($type=='cus'){
                $this->data['regNo'] = base64_decode($regno);
                $this->data['cusCode'] = base64_decode($cuscode);
            }

            $this->data['supNo'] = $sup;
            /* Load Template */
            $this->template->admin_render('admin/job/estimate-job', $this->data);
        }
    }

     public function updateJobStatus() {

        $jobno = $_POST['jobNo'];
        $date = date("Y-m-d H:i:s");
        $location= $_POST['branch'];
        $isworker = 1;

        if($_POST['jobStatus']==1){
            //start job
            $startdate = $this->db->select('startDate')->from('jobcardhed')->where('JobCardNo', $jobno)->where('IsCancel', 0)->get()->row()->startDate; 
           
            if($startdate==''){
                $data['IsCompelte'] = $_POST['jobStatus'];
                $data['assignTo'] = $_POST['emp'];
                $data['startDate'] = $date;
            }else{
                $data['IsCompelte'] = $_POST['jobStatus'];
            }
            
            $com_id = $this->db->select('location_id')->from('location')->where('location_id', $location)->get()->row()->location_id; 
            //worker data
            $workdata['JCardNo'] = $jobno;
            $workdata['add_date'] = $date;
            $workdata['JobWokerId'] = $_POST['emp'];
            $workdata['AppNo'] = $com_id;
            $isEmp = $this->db->select('JobWokerId')->from('jobwoker')->where('JobWokerId', $_POST['emp'])->where('JCardNo', $jobno)->get()->num_rows();
            if($isEmp==0){
               $isworker= $this->db->insert('jobwoker',$workdata);
            }else{
                $isworker=2;
            }
            

        }elseif($_POST['jobStatus']==2){
            //end job
            $data['IsCompelte'] = $_POST['jobStatus'];
            $data['endDate'] = $date;

        }elseif($_POST['jobStatus']==3){
            //close job
            $data['IsCompelte'] = $_POST['jobStatus'];
            $data['closeDate'] = $date;

        }else{
            $data['IsCompelte'] = $_POST['jobStatus'];
        }
        

        $this->db->trans_start();
        $this->db->update('jobcardhed',$data,array('JobCardNo' => $jobno));
        $this->db->trans_complete();
        $res2= $this->db->trans_status();

        $return = array('JobCardNo' => ($jobno),'work' =>$isworker);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function removeEmployee(){
        $emp =  $_POST['emp'];

        $this->db->trans_start();
        $this->db->delete('jobwoker',array('jworkid' => $emp));
        $this->db->trans_complete();
        $res2= $this->db->trans_status();

        $return = array('JobCardNo' => ($emp));
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function view_estimate2($estNo=null) {
        $estNo='';
        $supNo=0;
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $supNo = isset($_GET['sup'])?$_GET['sup']:0;
        $cuscode = isset($_GET['ccode'])?$_GET['ccode']:0;
        $regno = isset($_GET['regno'])?$_GET['regno']:0;

        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('All Estimates');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Estimates', 'admin/job/view_estimate');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->data['JobNo'] = '';
            $this->data['EstimateNo'] ='';
            $this->data['regNo'] ='';
            $this->data['cusCode'] ='';

            if($type=='inv'){
                $this->data['JobInvoiceNo'] = base64_decode($id);
            }elseif($type=='job'){
                $this->data['JobNo'] = base64_decode($id);
            }elseif($type=='est'){
                $this->data['EstimateNo'] = base64_decode($id);
                $estNo=base64_decode($id);
            }elseif($type=='cus'){
                $this->data['regNo'] = base64_decode($regno);
                $this->data['cusCode'] = base64_decode($cuscode);
            }

            $this->data['supNo'] = $supNo;

            /* Data */
            $location = $this->db->select('EstLocation')->from('estimatehed')->where('EstimateNo',$estNo)->where('Supplimentry', $supNo)->get()->row()->EstLocation;
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['EstimateNo'] = $estNo;
            $this->data['estHed'] = $this->db->select('*')->from('estimatehed')->join('vehicle_company','vehicle_company.VComId=estimatehed.EstInsCompany','left')->where('EstimateNo', $estNo)->where('Supplimentry', $supNo)->get()->row();
            // $this->data['estDtl'] = $this->db->select()->from('estimatedtl')->where('EstimateNo',$estNo)->get()->result();
            $this->data['estDtl'] =$this->Job_model->getEstimateDtlbyid($estNo,$supNo);
            $cusCode =  $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo',$estNo)->where('Supplimentry',$supNo)->get()->row()->EstCustomer;
            $regNo =  $this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo',$estNo)->get()->row()->EstRegNo;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,vehicledetail.Color AS body_color,fuel_type.fuel_type')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('fuel_type','fuel_type.fuel_typeid=vehicledetail.FuelType','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();

            if($supNo>0){
            $this->data['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo-1))->get()->row()->EstLastNo;
        }else{
            $this->data['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo))->get()->row()->EstLastNo;
        }

            /* Load Template */
            $this->template->admin_render('admin/job/view-estimate', $this->data);
        }
    }

    public function view_estimate($estNo=null) {
        $estNo='';
        $supNo=0;
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $supNo = isset($_GET['sup'])?$_GET['sup']:0;
        $cuscode = isset($_GET['ccode'])?$_GET['ccode']:0;
        $regno = isset($_GET['regno'])?$_GET['regno']:0;

        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Estimate View');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Estimates', 'admin/job/view_estimate');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['JobNo'] = '';
            $this->data['EstimateNo'] ='';
            $this->data['regNo'] ='';
            $this->data['cusCode'] ='';
            $this->data['title'] = 'ESTIMATE';
            

            if($type=='inv'){
                $this->data['JobInvoiceNo'] = base64_decode($id);
            }elseif($type=='job'){
                $this->data['JobNo'] = base64_decode($id);
            }elseif($type=='est'){
                $this->data['EstimateNo'] = base64_decode($id);
                $estNo=base64_decode($id);
            }elseif($type=='cus'){
                $this->data['regNo'] = base64_decode($regno);
                $this->data['cusCode'] = base64_decode($cuscode);
            }

            $this->data['supNo'] = $supNo;
            if($supNo>0){
                $this->data['titleno'] = $estNo."-".$supNo;
            }else{
                $this->data['titleno'] = $estNo;
            }
            
            $this->data['balancetxt'] = '';
            $balance=0;
            $this->data['balance'] = "";

            /* Data */
            $location = $this->db->select('EstLocation')->from('estimatehed')->where('EstimateNo',$estNo)->where('Supplimentry', $supNo)->get()->row()->EstLocation;
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            $this->data['parttype'] = $this->db->select('*')->from('productquality')->get()->result();
            

            $this->data['EstimateNo'] = $estNo;
            $this->data['estHed'] = $this->db->select('estimatehed.*,users.first_name,users.last_name')->from('estimatehed')->join('users','users.id=estimatehed.EstUser','left')->where('EstimateNo', $estNo)->where('Supplimentry', $supNo)->get()->row();
            // $this->data['estDtl'] = $this->db->select()->from('estimatedtl')->where('EstimateNo',$estNo)->get()->result();
            $this->data['estDtl'] =$this->Job_model->getEstimateDtlbyid($estNo,$supNo);
            $cusCode =  $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo',$estNo)->where('Supplimentry',$supNo)->get()->row()->EstCustomer;
            $regNo =  $this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo',$estNo)->get()->row()->EstRegNo;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,vehicledetail.Color AS body_color,fuel_type.fuel_type')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('fuel_type','fuel_type.fuel_typeid=vehicledetail.FuelType','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();

            if($supNo>0){
            $this->data['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo-1))->get()->row()->EstLastNo;
        }else{
            $this->data['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo))->get()->row()->EstLastNo;
        }

             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $estNo)->where('editinvoices.EditType', 4)->order_by('UpdateDate','DESC')->get()->result();

             $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 4)->get()->result();


             $this->data['est_doc'] = $this->db->select()->from('est_document')->where('est_no',$estNo)->get()->result();



            /* Load Template */
            $this->template->admin_render('admin/job/view-estimate2', $this->data);
        }
    }

    public function estimate_pdf($estNo=null) {
        $estNo='';
        $supNo=0;
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $supNo = isset($_GET['sup'])?$_GET['sup']:0;
        $cuscode = isset($_GET['ccode'])?$_GET['ccode']:0;
        $regno = isset($_GET['regno'])?$_GET['regno']:0;

        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('All Estimates');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Estimates', 'admin/job/view_estimate');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            $this->data['parttype'] = $this->db->select('*')->from('productquality')->get()->result();

            $this->data['JobNo'] = '';
            $this->data['EstimateNo'] ='';
            $this->data['regNo'] ='';
            $this->data['cusCode'] ='';
            $this->data['title'] = 'ESTIMATE';
            

            if($type=='inv'){
                $this->data['JobInvoiceNo'] = base64_decode($id);
            }elseif($type=='job'){
                $this->data['JobNo'] = base64_decode($id);
            }elseif($type=='est'){
                $this->data['EstimateNo'] = base64_decode($id);
                $estNo=base64_decode($id);
            }elseif($type=='cus'){
                $this->data['regNo'] = base64_decode($regno);
                $this->data['cusCode'] = base64_decode($cuscode);
            }

            $this->data['supNo'] = $supNo;
            if($supNo>0){
                $this->data['titleno'] = $estNo."-".$supNo;
            }else{
                $this->data['titleno'] = $estNo;
            }
            
            $this->data['balancetxt'] = '';
            $balance=0;
            $this->data['balance'] = "";

            /* Data */
            $location = $this->db->select('EstLocation')->from('estimatehed')->where('EstimateNo',$estNo)->where('Supplimentry', $supNo)->get()->row()->EstLocation;
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['EstimateNo'] = $estNo;
            $this->data['estHed'] = $this->db->select('estimatehed.*,users.first_name,users.last_name,vehicle_company.VComName')->from('estimatehed')->join('vehicle_company','vehicle_company.VComId=estimatehed.EstInsCompany','left')->join('users','users.id=estimatehed.EstUser','left')->where('EstimateNo', $estNo)->where('Supplimentry', $supNo)->get()->row();
            // $this->data['estDtl'] = $this->db->select()->from('estimatedtl')->where('EstimateNo',$estNo)->get()->result();
            $this->data['estDtl'] =$this->Job_model->getEstimateDtlbyid($estNo,$supNo);
            $cusCode =  $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo',$estNo)->where('Supplimentry',$supNo)->get()->row()->EstCustomer;
            $regNo =  $this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo',$estNo)->get()->row()->EstRegNo;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,vehicledetail.Color AS body_color,fuel_type.fuel_type')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('fuel_type','fuel_type.fuel_typeid=vehicledetail.FuelType','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();

            if($supNo>0){
                $this->data['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo-1))->get()->row()->EstLastNo;
            }else{
                $this->data['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo))->get()->row()->EstLastNo;
            }
            $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 4)->get()->result();
            /* Load Template */
            $this->load->helper('file');
            $this->load->helper(array('dompdf'));

            // $this->load->view('admin/sales/sales-invoice-pdf', $this->data);
            $html = $this->load->view('admin/job/estimate_pdf', $this->data, true);
            // echo $html;
            pdf_create($html, $this->data['titleno'], TRUE,'a4');die;

            // $this->template->admin_render('admin/job/estimate_pdf', $this->data);
        }
    }



    public function all_estimate() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('All Estimates');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Estimates', 'admin/job/all_estimate');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobcondtion'] = $this->db->select()->from('job_condition')->get()->result();
            $this->data['jobsection'] = $this->db->select()->from('job_section')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));

            /* Load Template */
            $this->template->admin_render('admin/job/all-estimate', $this->data);
        }
    }

    public function cancel_job($jno=null) {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
//        var_dump($jno);die();
            /* Title Page */
            $this->page_title->push('Cancel Job');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Cancel Job', 'admin/job/cancel_job');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
//            $location = $_SESSION['location'];
//            $this->load->model('admin/Job_model');
//            $id3 = array('CompanyID' => $location);
//            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['custype'] = $this->db->select()->from('customer_type')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobcondtion'] = $this->db->select()->from('job_condition')->get()->result();
            $this->data['jobsection'] = $this->db->select()->from('job_section')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));
            $this->data['JobNo'] = base64_decode($jno);
            /* Load Template */
            $this->template->admin_render('admin/job/cancel-job', $this->data);
        }
    }

    public function loadcustomersjson() {
        $query = $_GET['q'];
       
        echo $this->Job_model->loadcustomersjson($query); die;
    }

    public function loadcustomersroutewise() {
        $routeID = $this->input->post('routeID'); 
        $newsalesperson = $this->input->post('newsalesperson');
        $this->load->database();
    
    
        $customers = $this->db->select('customer.CusCode,customer.DisplayName')
        ->from('customer')
        ->where('RouteId', $routeID)
        ->where('HandelBy',$newsalesperson)
        ->get()
        ->result();
    
        echo json_encode($customers); 
        die; 
    }
    

    public function loadjobjson() {
        $query = $_GET['q'];
        $q = $this->db->select('JobCardNo AS id,JobCardNo AS text')->from('jobcardhed')->like('JobCardNo', $query)->order_by('JobCardNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadestimatejson() {
        $query = $_GET['q'];
        $q = $this->db->select('EstimateNo AS id,EstimateNo AS text')->from('estimatehed')->like('EstimateNo', $query)->group_by('EstimateNo')->order_by('EstimateNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadestimatejsonbyjob() {
        $query = $_GET['q'];
        $jobNo = $_GET['jobNo'];
        if($jobNo!=''){
             $q = $this->db->select('EstimateNo AS id,EstimateNo AS text')->from('estimatehed')->like('EstimateNo', $query)->where('EstJobCardNo',$jobNo)->group_by('EstimateNo')->order_by('EstimateNo','DESC')->get()->result();
        }else{
             $q = $this->db->select('EstimateNo AS id,EstimateNo AS text')->from('estimatehed')->like('EstimateNo', $query)->group_by('EstimateNo')->order_by('EstimateNo','DESC')->get()->result();
        }

       
        echo json_encode($q);die;
    }

    public function loadestimatejsonbycustomer() {
        $query = $_GET['q'];
        $cuscode =$_GET['cusCode'];
//        $regno =$_GET['regNo'];
        $q = $this->db->select('EstimateNo AS id,EstimateNo AS text')->from('estimatehed')->where('EstCustomer',$cuscode)->like('EstimateNo', $query)->group_by('EstimateNo')->order_by('EstimateNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadsupplemetnojson() {
        $query = $_GET['q'];
        $estNo = $_GET['estimateNo'];
        if($estNo){
            $q = $this->db->select('Supplimentry AS id,Supplimentry AS text,EstimateNo')->from('estimatehed')->like('Supplimentry', $query)->where('EstimateNo', $estNo)->get()->result();
        }
        echo json_encode($q);die;
    }
    
    public function loadJobDescJson(){
        $query = $_GET['q'];
        $cat = $_GET['jobcat'];
        $q = $this->db->select('JobDescNo AS id,JobDescription AS text')->from('jobdescription')->like('JobDescription', $query)->where('jobcard_category', $cat)->get()->result();
        echo json_encode($q);die;
    }

    public function loadJobDescJsonByType(){
        $query = $_GET['q'];
        $type = $_GET['workType'];
        $q = $this->db->select('JobDescNo AS id,JobDescription AS text,JobCost AS jobCost,isVat,isNbt,nbtRatio')->from('inv_jobdescription')->where('jobtype', $type)->like('JobDescription', $query)->get()->result();
        echo json_encode($q);die;
    }

    public function getJobDataById(){
        $jobNo = $_POST['jobNo'];
        $cusCode = $this->db->select('JCustomer')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JCustomer;
         $regNo =$this->db->select('JRegNo')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JRegNo;
        $appoimnetDate =$this->db->select('appoimnetDate')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->appoimnetDate;
        $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
        $arr['job_data'] = $this->db->select('jobcardhed.*,(jobcardhed.deliveryDate) AS deliveryDate')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
        $arr['job_desc'] = $this->db->select('jobcarddtl.*,jobcategory.job_category')->from('jobcarddtl')->join('jobcategory','jobcarddtl.JobCategory=jobcategory.jobcategory_id','left')->where('JobCardNo', $jobNo)->get()->result();
        $arr['job_type'] = $this->db->select('jobcardtype.JobTypeId')->from('jobcardtype')->where('JobCardNo', $jobNo)->get()->result();
        $arr['job_count'] = $this->db->select('count(JobCardNo)  AS noofjobs')->from('jobcardhed')->where('JRegNo', $regNo)->where('JCustomer', $cusCode)->where('IsCancel', 0)->where('appoimnetDate<', $appoimnetDate)->get()->row();
        echo json_encode($arr);die;
    }

    public function loadvehiclesjson() {
        $query = isset($_GET['q'])?$_GET['q']:'';
        $cuscode = $_GET['cusCode'];
        if($cuscode!=''){
            echo $this->Job_model->loadvehiclesjson($query,$cuscode); die;
        }else{
            echo $this->Job_model->loadvehiclesjsonwithoutcustomer($query); die;
        }        
    }

    public function loadCompanyByCusType() {
        $cat = $_POST['custype'];
       $data=  $this->db->select()->from('vehicle_company')->where('VComCategory', $cat)->get()->result();
            echo json_encode($data);die;
    }

    public function getVehicleDetailsById() {
        $cat = $_REQUEST['id'];
       $data= $this->db->select('*,vehicledetail.Color AS body_color')->from('vehicledetail')->where('vehicledetail.RegNo', $cat)
       ->join('make', 'make.make_id = vehicledetail.Make', 'left')
       ->join('fuel_type', 'fuel_type.fuel_typeid = vehicledetail.FuelType', 'left')
       ->join('model', 'model.model_id = vehicledetail.Model', 'left')
       ->where('vehicledetail.IsActive',1)
       ->get()->row();
        echo json_encode($data);die;
    }

    public function getVehicleDetailsByIdandCus() {
        $cat = $_REQUEST['id'];
        $cus = $_REQUEST['cuscode'];
       $data= $this->db->select('*,vehicledetail.Color AS body_color')->from('vehicledetail')->where('vehicledetail.RegNo', $cat)->where('vehicledetail.CusCode', $cus)
       ->join('make', 'make.make_id = vehicledetail.Make', 'left')
       ->join('fuel_type', 'fuel_type.fuel_typeid = vehicledetail.FuelType', 'left')
       ->join('model', 'model.model_id = vehicledetail.Model', 'left')
       ->get()->row();
        echo json_encode($data);die;
    }

    public function alljobs() {
        $location = $_SESSION['location'];
        $this->load->library('Datatables');
        $this->datatables->select('jobcardhed.*,customer.CusName, job_status.status_name');
        $this->datatables->from('jobcardhed');
        $this->datatables->join('customer','customer.CusCode=jobcardhed.JCustomer', 'left');
        $this->datatables->join('job_status','job_status.status_id=jobcardhed.IsCompelte', 'inner');
        //$this->datatables->where('jobcardhed.JLocation',$location);
        echo $this->datatables->generate();
        die;
    }

    public function allestimates() {
        $location = $_SESSION['location'];
        $this->load->library('Datatables');
        $this->datatables->select('estimatehed.*,customer.CusName,customer.DisplayName');
        $this->datatables->from('estimatehed');
        $this->datatables->join('customer','customer.CusCode=estimatehed.EstCustomer', 'left');
        // $this->datatables->where('estimatehed.EstLocation',$location);
        echo $this->datatables->generate();
        die;
    }

    public function saveJob() {
       
        $location = $_SESSION['location'];
        $EstJobType=0;
        if($_POST['estimateNo']!='' || $_POST['estimateNo']!=0){
            $EstJobType = $this->db->select('EstJobType')->from('estimatehed')->where('EstCustomer', $_POST['cusCode'])->where('EstRegNo', $_POST['regNo'])->where('EstimateNo', $_POST['estimateNo'])->get()->row()->EstJobType;
        }

        if($EstJobType!=''){
            //Insurance
            $data['JobCardNo'] = $this->Job_model->get_max_code('JobNumber'.$location);
        }else{
            //genaral
             $data['JobCardNo'] = $this->Job_model->get_max_code('JobNumber'.$location);
        }
         //remove white spaces
        $regNo = preg_replace('/\s+/', ' ', $_POST['regNo']);

        $data['JCompanyCode'] = $_POST['companyCode'];
        $data['JLocation']    = $location;
        $data['JCustomer']    = $_POST['cusCode'];
//        $data['JRegNo']       = $regNo;
        $data['JCusType']     = $_POST['cusType'];
        $data['JPayType']     = $_POST['payType'];
        $data['JCusCompany']  = isset($_POST['vehicleCompany']) ? $_POST['vehicleCompany']:0;
        $data['JIsInsDoc']    = isset($_POST['insdoc']) ? $_POST['insdoc']:0;
//        $data['OdoIn']        = $_POST['odoIn'];
//        $data['OdoOut']       = $_POST['odoOut'];
//        $data['OdoInUnit']    = $_POST['odoInUnit'];
//        $data['OdoOutUnit']   = $_POST['odoOutUnit'];
        $data['NextService']  = $_POST['nextService'];
        $data['PrevJobNo']    = $_POST['prevJobNum'];
        $data['SparePartJobNo'] = $_POST['sparePartCNo'];
        $data['serviceAdvisor'] = $_POST['advisorName'];
        $data['advisorContact'] = $_POST['advisorPhone'];
        $data['appoimnetDate']  = $_POST['appoDate'];
        $data['deliveryDate']   = $_POST['deliveryDate'];
        $data['JestimateNo']    = $_POST['estimateNo'];
        $data['JJobType']       = $_POST['jobtype'];
        // $data['Jsection'] = $_POST['jobSection'];
        $data['Advance'] = $_POST['advance'];
        $data['JAdvanceNo'] = isset($_POST['advanceno']) ? $_POST['advanceno']:0;
        $data['IsCompelte'] = 0;
        $data['IsCancel'] = 0;
        $data['JInvUser']=$_SESSION['user_id'];

        $jobtypeArr = $_POST['jobSection'];

        
        $jobArr = json_decode($_POST['jobArr']);
        $jobNumArr = json_decode($_POST['jobNumArr']);
        $jobCatArr = json_decode($_POST['jobCatArr']);

        $this->db->trans_start();
        $this->db->insert('jobcardhed',$data);
        for ($j = 0; $j < count($jobtypeArr); $j++) {
            $jobTypeDtl = array(
                'JobCardNo' => $data['JobCardNo'],
                'JobTypeId' => $jobtypeArr[$j]);
            $this->db->insert('jobcardtype',$jobTypeDtl);
        }

        for ($i = 0; $i < count($jobArr); $i++) {
            $jobDtl = array(
                'JobCardNo' => $data['JobCardNo'],
                'JobDescription' => $jobArr[$i],
                'JobDescId' => $jobNumArr[$i],
                'JobCategory' => $jobCatArr[$i]);
            $this->db->insert('jobcarddtl',$jobDtl);
        }

        //link to jobcard and estimate
        if($_POST['estimateNo']!='' || $_POST['estimateNo']!=0){

            $estJobCardNo = $this->db->select('EstJobCardNo')->from('estimatehed')->where('EstCustomer', $_POST['cusCode'])->where('EstRegNo', $_POST['regNo'])->where('EstimateNo', $_POST['estimateNo'])->get()->row()->EstJobCardNo;
            //if jobcard number empty only update jobcard number
            if($estJobCardNo==''){
                $this->db->update('estimatehed',array('EstJobCardNo' => $data['JobCardNo']),array('EstCustomer' => $_POST['cusCode'],'EstRegNo' => $_POST['regNo'],'EstimateNo' => $_POST['estimateNo']));
            }
        }


        $this->Job_model->bincard($data['JobCardNo'],5,'Created');//update bincard
        $this->Job_model->update_max_code('JobNumber'.$location);
        $this->db->trans_complete();
        $res2= $this->db->trans_status();

        $return = array('JobCardNo' => ($data['JobCardNo']));
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function updateJob() {
         //remove white spaces
        $regNo = preg_replace('/\s+/', ' ', $_POST['regNo']);
        $location = $_SESSION['location'];
        $data['JobCardNo'] = $_POST['jobNo'];
        $data['JCustomer'] = $_POST['cusCode'];
        $data['JLocation']    = $location;
        $data['JRegNo'] = $regNo;
        $data['JCusType'] = $_POST['cusType'];
        $data['JCusCompany'] = isset($_POST['vehicleCompany']) ? $_POST['vehicleCompany']:0;
        $data['JPayType']     = $_POST['payType'];
        // $data['JCusCompany']  = isset($_POST['vehicleCompany']) ? $_POST['vehicleCompany']:0;
        $data['JIsInsDoc']  = isset($_POST['insdoc']) ? $_POST['insdoc']:0;
        $data['OdoIn'] = $_POST['odoIn'];
        $data['OdoOut'] = $_POST['odoOut'];
        $data['OdoInUnit'] = $_POST['odoInUnit'];
        $data['OdoOutUnit'] = $_POST['odoOutUnit'];
        $data['NextService'] = $_POST['nextService'];
        $data['PrevJobNo'] = $_POST['prevJobNum'];
        $data['SparePartJobNo'] = $_POST['sparePartCNo'];
        $data['serviceAdvisor'] = $_POST['advisorName'];
        $data['advisorContact'] = $_POST['advisorPhone'];
        $data['appoimnetDate'] = $_POST['appoDate'];
        $data['deliveryDate'] = $_POST['deliveryDate'];
        $data['JestimateNo'] = $_POST['estimateNo'];
        $data['JJobType'] = $_POST['jobtype'];
        // $data['Jsection'] = $_POST['jobSection'];
        $data['Advance'] = $_POST['advance'];
        $data['JAdvanceNo'] = isset($_POST['advanceno']) ? $_POST['advanceno']:0;

        ///////////////////////////////////////////////
        $data1['mileageout'] = $_POST['odoOut'];
        $data1['mileageoutUnit'] = $_POST['odoOutUnit'];
        ///////////////////////////////////////////////
        $jobtypeArr = $_POST['jobSection'];
        // $data['IsCompelte'] = 0;
        // $data['IsCancel'] = 0;

        $jobArr = json_decode($_POST['jobArr']);
        $jobNumArr = json_decode($_POST['jobNumArr']);
        $jobCatArr = json_decode($_POST['jobCatArr']);

        $this->db->trans_start();
        $this->db->update('jobinvoicehed',$data1,array('JobCardNo' => $data['JobCardNo']));
        $this->db->update('jobcardhed',$data,array('JobCardNo' => $data['JobCardNo']));
        $this->db->delete('jobcarddtl',array('JobCardNo' => $data['JobCardNo']));
        $this->db->delete('jobcardtype',array('JobCardNo' => $data['JobCardNo']));

        for ($j = 0; $j < count($jobtypeArr); $j++) {
            $jobTypeDtl = array(
                'JobCardNo' => $data['JobCardNo'],
                'JobTypeId' => $jobtypeArr[$j]);
            $this->db->insert('jobcardtype',$jobTypeDtl);
        }
        
        for ($i = 0; $i < count($jobArr); $i++) {
             $jobDtl = array(
                'JobCardNo' => $data['JobCardNo'],
                'JobDescription' => $jobArr[$i],
                'JobDescId' => $jobNumArr[$i],
                'JobCategory' => $jobCatArr[$i]);
             $this->db->insert('jobcarddtl',$jobDtl);
        }

        //link to jobcard and estimate
        if($_POST['estimateNo']!='' || $_POST['estimateNo']!=0){

        $this->db->update('estimatehed',array('EstJobCardNo' => $data['JobCardNo']),array('EstCustomer' => $_POST['cusCode'],'EstRegNo' => $_POST['regNo'],'EstimateNo' => $_POST['estimateNo']));
        }

        
        $this->Job_model->bincard($_POST['jobNo'],5,'Updated');//update bincard
        // $this->Job_model->update_max_code('Job Number');
        $this->db->trans_complete();
        $res2= $this->db->trans_status();

        $return = array('JobCardNo' => ($data['JobCardNo']));
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function cancelJob() {

        $data['IsCancel'] = 1;

        $this->db->trans_start();
        $this->db->update('jobcardhed',$data,array('JobCardNo' => $_POST['jobNo']));
        $this->Job_model->bincard($_POST['jobNo'],5,'cancelled');//update bincard
        $this->db->trans_complete();
        $res2= $this->db->trans_status();

        $return = array('JobCardNo' => ($_POST['jobNo']));
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= 0;$supCode= '';
         $this->load->model('admin/Grn_model');
        echo $this->Grn_model->loadproductjson($query,$sup,$supCode);
        die;
    }

    //estimate types
    public function saveEstimate() {
        $location = $_SESSION['location'];
        $action = $_POST['action'];
        $data['EstCompanyCode'] = '';
        if($_POST['sup_no']=='' || $_POST['sup_no']==0){$supplimentNo=0;}else{$supplimentNo=$_POST['sup_no'];}
        $data['EstCustomer'] = $_POST['cusCode'];
        $data['EstRegNo'] = $_POST['regNo'];
        $data['EstType'] = $_POST['estimate_type'];
        $data['EstInsCompany'] = $_POST['insCompany'];
        $data['EstLocation'] = $location;
        $data['Supplimentry'] = $supplimentNo;
        $data['EstJobCardNo'] = $_POST['jobNo'];
        $data['EstDate'] = $_POST['date'];
        $data['remark'] = $_POST['remark'];
        $data['EstimateAmount'] = $_POST['estimateAmount'];
        $data['EstJobType'] = $_POST['job_type'];
        $data['IsEdit'] = 0;
        $data['IsSup'] = 0;
        $data['IsCompelte'] = 0;
        $data['IsCancel'] = 0;
        $data['EstNetAmount'] =$_POST['totalNet'];
        $data['EstVatAmount'] =$_POST['totalVat'];
        $data['EstNbtAmount'] =$_POST['totalNbt'];
        $data['EstIsVatTotal'] =$_POST['isTotalVat'];
        $data['EstIsNbtTotal'] =$_POST['isTotalNbt'];
        $data['EstNbtRatioTotal']=$_POST['nbtRatioRate'];
        $data['EstUser']=$_SESSION['user_id'];

        $net_priceArr = json_decode($_POST['net_price']);
        $qtyArr = json_decode($_POST['qty']);
        $sell_priceArr = json_decode($_POST['sell_price']);
        $is_insArr = json_decode($_POST['is_ins']);
        $insuranceArr = json_decode($_POST['insurance']);
        $descArr = json_decode($_POST['desc']);
        $job_idArr = json_decode($_POST['job_id']);
        $job_orderArr = json_decode($_POST['job_order']);
        $work_idArr = json_decode($_POST['work_id']);
        $timestampArr = json_decode($_POST['timestamp']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $totalPriceArr = json_decode($_POST['totalPrice']);
        $partTypeArr = json_decode($_POST['partType']);
        // $costPriceArr = json_decode($_POST['costPrice']);
        $job_type =$_POST['job_type'];
        if($action==1){
            if($supplimentNo==0 || $supplimentNo==''){
                if ($job_type!='') {
                    $data['EstimateNo'] = $this->Job_model->get_max_code('EstimateNumber'.$location);
                }else{
                    $data['EstimateNo'] =$this->Job_model->get_max_code('EstimateNumber'.$location);
                }   

                //get last number
                $estlastNo = 0;
            }else{
                $data['EstimateNo'] = $_POST['estimateNo'];
                $data['IsEdit'] = 1;

                //get last number
                $estlastNo = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $data['EstimateNo'])->where('Supplimentry', ($supplimentNo-1))->get()->row()->EstLastNo;
            }

            $this->db->trans_start();
            $this->db->insert('estimatehed',$data);
            for ($i = 0; $i < count($work_idArr); $i++) {
                 $jobDtl = array(
                    'EstimateNo' => $data['EstimateNo'],
                    'EstJobCardNo' => $data['EstJobCardNo'],
                    'SupplimentryNo' => $supplimentNo,
                    'EstJobOrder' => $job_orderArr[$i],
                    'EstJobType' => $job_idArr[$i],
                    'EstJobId' => $work_idArr[$i],
                    'EstJobDescription' => $descArr[$i],
                    'EstQty' => $qtyArr[$i],
                    'EstPrice' => $sell_priceArr[$i],
                    // 'EstCost' => $costPriceArr[$i],
                    'EstIsInsurance' => $is_insArr[$i],
                    'EstInsurance' => $insuranceArr[$i],
                    'EstIsVat' => $isVatArr[$i],
                    'EstIsNbt' => $isNbtArr[$i],
                    'EstNbtRatio' => $nbtRatioArr[$i],
                    'EstVatAmount' => $proVatArr[$i],
                    'EstNbtAmount' => $proNbtArr[$i],
                    'EstTotalAmount' => $totalPriceArr[$i],
                    'EstDiscount' => 0,
                    'EstNetAmount' => $net_priceArr[$i],
                    'EstPartType' => $partTypeArr[$i],
                    'EstDiscountType' => 0,
                    'EstinvoiceTimestamp' => date("Y-m-d H:i:s")
                    );
                 $this->db->insert('estimatedtl',$jobDtl);
            }
            
            //update lastnumber
            $this->db->update('estimatehed',array('EstLastNo' => ($estlastNo+count($work_idArr))),array('EstimateNo' => $data['EstimateNo'],'Supplimentry' => $supplimentNo));
            
        if($supplimentNo==0 || $supplimentNo==''){
            $this->Job_model->update_max_code('EstimateNumber'.$location);
        }

        $this->Job_model->bincard($data['EstimateNo'],4,'Created');//update bincard
            $this->db->trans_complete();
            $res2= $this->db->trans_status();

    }elseif ($action==2) {
        // print_r($_POST);die;
        $data['EstimateNo'] = $_POST['estimateNo'];
        $this->db->trans_start();
            $this->db->update('estimatehed',$data,array('EstimateNo' => $data['EstimateNo'],'Supplimentry' => $supplimentNo,'EstJobCardNo' => $_POST['jobNo']));

            $estTimestmp = 0;
            $this->db->delete('estimatedtl',array('EstimateNo' => $data['EstimateNo'],'SupplimentryNo' => $supplimentNo,'EstJobCardNo' => $_POST['jobNo']));
            for ($i = 0; $i < count($work_idArr); $i++) {
                if($timestampArr[$i]!=''){
                    $estTimestmp = $timestampArr[$i];
                }else{
                    $estTimestmp = date("Y-m-d H:i:s");
                }
                 $jobDtl = array(
                    'EstimateNo' => $data['EstimateNo'],
                    'EstJobCardNo' => $data['EstJobCardNo'],
                    'SupplimentryNo' => $supplimentNo,
                    'EstJobOrder' => $job_orderArr[$i],
                    'EstJobType' => $job_idArr[$i],
                    'EstJobId' => $work_idArr[$i],
                    'EstJobDescription' => $descArr[$i],
                    'EstQty' => $qtyArr[$i],
                    'EstPrice' => $sell_priceArr[$i],
                    // 'EstCost' => $costPriceArr[$i],
                    'EstIsInsurance' => $is_insArr[$i],
                    'EstInsurance' => $insuranceArr[$i],
                    'EstIsVat' => $isVatArr[$i],
                    'EstIsNbt' => $isNbtArr[$i],
                    'EstNbtRatio' => $nbtRatioArr[$i],
                    'EstVatAmount' => $proVatArr[$i],
                    'EstNbtAmount' => $proNbtArr[$i],
                    'EstTotalAmount' => $net_priceArr[$i],
                    'EstDiscount' => 0,
                    'EstNetAmount' => $net_priceArr[$i],
                    'EstPartType' => $partTypeArr[$i],
                    'EstDiscountType' => 0,
                    'EstinvoiceTimestamp' => $estTimestmp
                    );
                 $this->db->insert('estimatedtl',$jobDtl);
            }

            if($supplimentNo==0 || $supplimentNo==''){
                //get last number
                $estlastNo = 0;
                $this->db->update('estimatehed',array('EstLastNo' => ($estlastNo+count($work_idArr))),array('EstimateNo' => $data['EstimateNo'],'Supplimentry' => $supplimentNo));
            }else{
                //get last number
                $estlastNo = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $data['EstimateNo'])->where('Supplimentry', ($supplimentNo-1))->get()->row()->EstLastNo;

                $this->db->update('estimatehed',array('EstLastNo' => ($estlastNo+count($work_idArr))),array('EstimateNo' => $data['EstimateNo'],'Supplimentry' => $supplimentNo));
            }

             $this->Job_model->bincard($data['EstimateNo'],4,'sup-'.$supplimentNo.' Updated');//update bincard

            $this->db->trans_complete();
            $res2= $this->db->trans_status();
        # code...
    }

        $return = array('EstimateNo' => $data['EstimateNo'],'SupplimentryNo'=>$supplimentNo);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function getEstimateDataById(){
        $estNo = $_POST['estNo'];
        $supNo = $_POST['supNo'];
        $cusCode = $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo',$estNo)->get()->row()->EstCustomer; 
        $regNo =$this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo',$estNo)->get()->row()->EstRegNo;    
        $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
        $arr['est_hed'] = $this->db->select('*')->from('estimatehed')->join('vehicle_company','vehicle_company.VComId=estimatehed.EstInsCompany','left')->where('EstimateNo', $estNo)->where('Supplimentry', $supNo)->get()->row();
        $arr['est_dtl'] = $this->Job_model->getEstimateDtlbyid($estNo,$supNo);
        
        if($supNo>0){
            $arr['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo-1))->get()->row()->EstLastNo;
        }else{
            $arr['estlastNo'] = $this->db->select('EstLastNo')->from('estimatehed')->where('EstimateNo', $estNo)->where('Supplimentry', ($supNo))->get()->row()->EstLastNo;
        }

        echo json_encode($arr);
        die;
    }

    public function getEstimateDataByJobNo(){
        $jobNo = $_POST['jobNo'];
        $isInvoice=0;
        // $estimateNo = $_POST['estimateNo'];
        // $supplemetNo = $_POST['supplemetNo'];
        $isInvoice = $this->db->select('JobCardNo')->from('jobinvoicehed')->where('JobCardNo', $jobNo)->where('IsCancel', 0)->get()->num_rows();
        $cusCode = $this->db->select('JCustomer')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JCustomer;
        $regNo =$this->db->select('JRegNo')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JRegNo;
        $isEstimate = $this->db->select('EstimateNo')->from('estimatehed')->where('EstJobCardNo', $jobNo)->get()->num_rows();
        if($isEstimate>0){
            $estNo =$this->db->select('EstimateNo')->from('estimatehed')->where('EstJobCardNo', $jobNo)->get()->row()->EstimateNo;
            $supNo =$this->db->select_max('Supplimentry')->from('estimatehed')->where('EstJobCardNo', $jobNo)->get()->row()->Supplimentry;
            if(isset($estNo) && isset($supNo)){
                $arr['est_hed'] = $this->db->select()->from('estimatehed')->where('EstimateNo', $estNo)->where('estimatehed.Supplimentry', $supNo)->get()->row();
                $arr['est_dtl'] = $this->db->select('estimatedtl.*,jobtype.jobtype_name,jobtype.jobhead')->from('estimatedtl')->join('jobtype', 'jobtype.jobtype_id = estimatedtl.EstJobType')->where('estimatedtl.EstimateNo', $estNo)->where('estimatedtl.SupplimentryNo', $supNo)->order_by('estimatedtlid')->get()->result();
                $arr['job_est'] = $this->Job_model->getEstimateDtlbyid($estNo,$supNo);
            }else{
                $arr['est_hed'] = $this->db->select()->from('estimatehed')->where('EstimateNo', $estNo)->get()->row();
                $arr['est_dtl'] = $this->db->select('estimatedtl.*,jobtype.jobtype_name')->from('estimatedtl')->join('jobtype', 'jobtype.jobtype_id = estimatedtl.EstJobType')->where('estimatedtl.EstimateNo', $estNo)->order_by('estimatedtlid')->get()->result();
                $arr['job_est'] = $this->Job_model->getEstimateDtlbyid($estNo,$supNo);
            }
            
        }else{
            $arr['est_dtl'] =null;
            $arr['est_hed']=null;
            $arr['job_est'] =null;
        }
        $arr['isInv'] = $isInvoice;
        $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
        $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
        $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
        
        echo json_encode($arr);
        die;
    }

    public function getEstimateDataByEstimateNo(){
        $estimateNo = $_POST['estimateNo'];
        // $estimateNo = $_POST['estimateNo'];
        $supplemetNo = $_POST['supplimentNo'];

         $isInvoice=0;
         $EstJobType =$this->db->select('EstJobType')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstJobType;

         if($EstJobType==1){
                if($estimateNo!='' && $supplemetNo==0){
            
                     $isInvoice = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobEstimateNo', $estimateNo)->where('JobSupplimentry', $supplemetNo)->where('IsCancel', 0)->get()->num_rows();
                     $istempInvoice = $this->db->select('JobInvNo')->from('tempjobinvoicehed')->where('JobEstimateNo', $estimateNo)->where('JobSupplimentry', $supplemetNo)->where('IsCancel', 0)->get()->num_rows();
                    $cusCode = $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstCustomer;
                    $regNo =$this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstRegNo;
                    $isEstimate = $this->db->select('EstimateNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->num_rows();
                    if($isEstimate>0){
                        $jobNo =$this->db->select('EstJobCardNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstJobCardNo;
                        $arr['est_hed'] = $this->db->select()->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row();
                        // $arr['est_dtl'] = $this->db->select('estimatedtl.*,jobtype.jobtype_name')->from('estimatedtl')->join('jobtype', 'jobtype.jobtype_id = estimatedtl.EstJobType')->where('estimatedtl.EstimateNo', $estimateNo)->order_by('estimatedtlid')->get()->result();
                         $arr['est_dtl'] = $this->db->select('estimatedtl.*,jobtype.jobtype_name,jobtype.jobhead')->from('estimatedtl')->join('jobtype', 'jobtype.jobtype_id = estimatedtl.EstJobType')->where('estimatedtl.EstimateNo', $estimateNo)->where('estimatedtl.SupplimentryNo', $supplemetNo)->order_by('estimatedtlid')->get()->result();
                        $arr['job_est'] = $this->Job_model->getEstimateDtlbyid($estimateNo,$supplemetNo);
                    }else{
                        $arr['est_dtl'] =null;
                        $arr['est_hed']=null;
                        $arr['job_est'] =null;
                    }
                     $arr['isInv'] = $isInvoice;
                     $arr['istempInv'] = $istempInvoice;
                    $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
                    $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
                    if($jobNo!=''){
                        $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                        $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
                    }else{
                        $arr['job_data'] =null;
                        $arr['job_desc'] =null;
                    }
                }elseif ($estimateNo!='' && $supplemetNo>0) {

                    $isInvoice = $this->db->select('JobCardNo')->from('jobinvoicehed')->where('JobEstimateNo', $estimateNo)->where('JobSupplimentry', $supplemetNo)->where('IsCancel', 0)->get()->num_rows();
                    $istempInvoice = $this->db->select('JobInvNo')->from('tempjobinvoicehed')->where('JobEstimateNo', $estimateNo)->where('JobSupplimentry', $supplemetNo)->where('IsCancel', 0)->get()->num_rows();
                    $cusCode = $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstCustomer;
                $regNo =$this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstRegNo;
                $isEstimate = $this->db->select('EstimateNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->where('Supplimentry', $supplemetNo)->get()->num_rows();
                if($isEstimate>0){
                    $jobNo =$this->db->select('EstJobCardNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->where('Supplimentry', $supplemetNo)->get()->row()->EstJobCardNo;
                    $arr['est_hed'] = $this->db->select()->from('estimatehed')->where('EstimateNo', $estimateNo)->where('Supplimentry', $supplemetNo)->get()->row();
                    $arr['est_dtl'] = $this->db->select('estimatedtl.*,jobtype.jobtype_name,jobtype.jobhead')->from('estimatedtl')->join('jobtype', 'jobtype.jobtype_id = estimatedtl.EstJobType')->where('estimatedtl.EstimateNo', $estimateNo)->where('estimatedtl.SupplimentryNo', $supplemetNo)->order_by('estimatedtlid')->get()->result();
                    $arr['job_est'] = $this->Job_model->getEstimateDtlbyid($estimateNo,$supplemetNo);
                }else{
                    $arr['est_dtl'] =null;
                    $arr['est_hed']=null;
                    $arr['job_est'] =null;
                }
                 $arr['isInv'] = $isInvoice;
                $arr['istempInv'] = $istempInvoice;
                $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
                $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
                if($jobNo!=''){
                    $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                    $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
                }else{
                    $arr['job_data'] =null;
                    $arr['job_desc'] =null;
                }
                }
         }else{
                //general estimate combine
            $supplemetNo='';
                $isInvoice = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobEstimateNo', $estimateNo)->where('IsCancel', 0)->get()->num_rows();
                $istempInvoice = $this->db->select('JobInvNo')->from('tempjobinvoicehed')->where('JobEstimateNo', $estimateNo)->where('IsCancel', 0)->get()->num_rows();
                    $cusCode = $this->db->select('EstCustomer')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstCustomer;
                    $regNo =$this->db->select('EstRegNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstRegNo;
                    $isEstimate = $this->db->select('EstimateNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->num_rows();
                    if($isEstimate>0){
                        $jobNo =$this->db->select('EstJobCardNo')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->EstJobCardNo;
                        $arr['est_hed'] = $this->db->select()->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row();
                        $arr['est_dtl'] = $this->db->select('estimatedtl.*,jobtype.jobtype_name,jobtype.jobhead')->from('estimatedtl')->join('jobtype', 'jobtype.jobtype_id = estimatedtl.EstJobType')->where('estimatedtl.EstimateNo', $estimateNo)->order_by('estimatedtlid')->get()->result();
                        
                        $arr['job_est'] = $this->Job_model->getEstimateDtlbyid($estimateNo,$supplemetNo);
                    }else{
                        $arr['est_dtl'] =null;
                        $arr['est_hed']=null;
                        $arr['job_est'] =null;
                    }
                     $arr['isInv'] = $isInvoice;
                     $arr['istempInv'] = $istempInvoice;
                    $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
                    $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
                    if($jobNo!=''){
                        $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                        $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
                    }else{
                        $arr['job_data'] =null;
                        $arr['job_desc'] =null;
                    }
         }

        
        echo json_encode($arr);
        die;
    }

    public function getMaxSupNumberByEstimateNo(){
        $estimateNo = $_POST['estimateNo'];
        $sup=0;
        if($estimateNo!='' || $estimateNo!=0){
           $sup =$this->db->select_max('Supplimentry')->from('estimatehed')->where('EstimateNo', $estimateNo)->get()->row()->Supplimentry;
        }
        echo $sup;die;    
    }


    public function est_upload(){

        $cusCode = $_REQUEST['cusCode2'];
        $EstimateNo = $_REQUEST['EstNoPdf'];

        $config['upload_path']          = './upload/est_doc';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 5000;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $invuser = $_SESSION['user_id'];
        // $filename =  $jobno."_".uniqid();
    
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            echo print_r($error);die;
                // $this->Payment_model->update_max_code('JobNumber');
        }else{
            $data = array('upload_data' => $this->upload->data());
            $invDate =date("Y-m-d H:i:s");
            $doc_name =$this->upload->data('file_name');
            $job_data = array('est_no' => $EstimateNo,'doc_name' => $doc_name,'upload_by' => $invuser,'upload_date' => $invDate );
            $this->db->insert('est_document',$job_data);
            // $jobencode = base64_encode($cusCode);
            $this->Job_model->bincard($cusCode,5,'file updated');//update bincard
        
redirect('admin/job/estimate_job/'.Base64_encode($EstimateNo). 'refresh');
            die;
        }

    }
}
