<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/master_model');
        $this->load->model('admin/Customer_model');
        date_default_timezone_set("Asia/Colombo");
//        $this->lang->load('admin/master');

        /* Breadcrumbs :: Common */
        
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_master'), 'admin/master');
            $this->page_title->push(lang('menu_master'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users'] = $this->master_model->get_count_record('users');
            $this->data['count_groups'] = $this->master_model->get_count_record('groups');
           
            /* Load Template */
            $this->template->admin_render('admin/master/index', $this->data);
        }
    }
    
    public function category() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/category');
            $this->page_title->push(('Categories'));
            $this->data['pagetitle'] = $this->page_title->show();
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            /* Data */
            $this->data['department'] = $this->master_model->get_data('department');
            $this->data['count_users'] = $this->master_model->get_count_record('users');
            $this->data['count_groups'] = $this->master_model->get_count_record('groups');
            /* Load Template */
            $this->template->admin_render('admin/master/category', $this->data);
        }
    }
 
    public function vcategory() {
        $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/category');
            $this->page_title->push(('Categories'));
            $this->data['pagetitle'] = $this->page_title->show();
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->data['make'] = $this->db->select()->from('make')->get()->result();
            $this->template->admin_render('admin/master/vcategory',$this->data);
    }

    public function vservice() {
        $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/category');
            $this->page_title->push('Vehicle Services');
            $this->data['pagetitle'] = $this->page_title->show();
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->data['make'] = $this->db->select()->from('make')->get()->result();
            $this->template->admin_render('admin/master/vservice',$this->data);
    }
    
    public function trans_type() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/cash-float-type');

            $this->page_title->push(('Cash Float Type'));

            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
 
            /* Data */
            $this->data['transType'] = $this->master_model->get_data('transactiontypes')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/cash-float-type', $this->data);
        }
    }
    
    public function loadmodal_addTransType() {
        
        $this->load->view('admin/master/addcashfloat_modal', $this->data);
    }

    public function loadmodal_editproduct() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('TransactionCode',$id)->get('transactiontypes')->row();
        $this->load->view('admin/master/editcashfloat_modal', $this->data);
    }

    public function jobcard_description() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/jobcard-description');
            $this->page_title->push(('Job Card Descriptions'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->db->select('jobdescription.*,jobcategory.job_category')->from('jobdescription')->join('jobcategory', 'jobcategory.jobcategory_id = jobdescription.jobcard_category')
       ->get()->result();
            
           
            /* Load Template */
            $this->template->admin_render('admin/master/jobcard-description', $this->data);
        }
    }
    
    public function loadmodal_addjobcard_description() {
         $this->data['jobcardcategory'] = $this->master_model->get_data('jobcategory')->result();
        $this->load->view('admin/master/addjobcard_description', $this->data);
    }

    public function loadmodal_editjobcard_description() {
        $id = $_REQUEST['id'];
        $this->data['jobcategory'] = $this->master_model->get_data('jobcategory')->result();

        $this->data['trans'] = $this->db->select('*')->where('jobdescription.JobDescNo',$id)->get('jobdescription')->row();


        $this->load->view('admin/master/editjobcard_description', $this->data);
    }

    public function jobinv_description() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/jobinv_description');
            $this->page_title->push(('Work Type Descriptions'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */

            $this->data['transType'] = $this->db->select('inv_jobdescription.*,jobtype.jobtype_name')->from('inv_jobdescription')->join('jobtype', 'jobtype.jobtype_id = inv_jobdescription.jobtype')
       ->get()->result();
            $this->data['jobtype'] = $this->master_model->get_data('jobtype')->row();
           
            /* Load Template */
            $this->template->admin_render('admin/master/jobinv_description', $this->data);
        }
    }
    
    public function loadmodal_addjobinv_description() {
         $this->data['jobtype'] = $this->master_model->get_data('jobtype')->result();
        $this->load->view('admin/master/addjobinv_description', $this->data);
    }

    public function loadmodal_editjobinv_description() {
        $id = $_REQUEST['id'];
         $this->data['jobtype'] = $this->master_model->get_data('jobtype')->result();
        // $this->data['trans'] = $this->db->select('*')->where('JobDescNo',$id)->get('inv_jobdescription')->row();
         $this->data['trans'] =$this->db->select('inv_jobdescription.*,jobtype.jobtype_name')->from('inv_jobdescription')->join('jobtype', 'jobtype.jobtype_id = inv_jobdescription.jobtype')->where('inv_jobdescription.JobDescNo',$id)
       ->get()->row();
        $this->load->view('admin/master/editjobinv_description', $this->data);
    }

    public function view_inscompany() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/view_inscompany');
            $this->page_title->push(('Third Party Companies'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */

            $this->data['transType'] = $this->db->select('vehicle_company.*,customer_type.CusType')->from('vehicle_company')->join('customer_type', 'customer_type.CusTypeId = vehicle_company.VComCategory')
       ->get()->result();
            $this->data['jobtype'] = $this->master_model->get_data('customer_type')->row();
           
            /* Load Template */
            $this->template->admin_render('admin/master/view-inscompany', $this->data);
        }
    }
    
    public function loadmodal_add_inscompany() {
         $this->data['jobtype'] = $this->master_model->get_data('customer_type')->result();
        $this->load->view('admin/master/add-inscompany', $this->data);
    }

    public function loadmodal_edit_inscompany() {
        $id = $_REQUEST['id'];
         $this->data['jobtype'] = $this->master_model->get_data('customer_type')->result();
        // $this->data['trans'] = $this->db->select('*')->where('JobDescNo',$id)->get('inv_jobdescription')->row();
         $this->data['trans'] =$this->db->select('vehicle_company.*,customer_type.CusType')->from('vehicle_company')->join('customer_type', 'customer_type.CusTypeId = vehicle_company.VComCategory')->where('vehicle_company.VComId',$id)
       ->get()->row();
        $this->load->view('admin/master/edit-inscompany', $this->data);
    }

    public function job_type() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/job_type');
            $this->page_title->push(('Work Types'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('jobtype')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/job_type', $this->data);
        }
    }

    public function loadmodal_addjob_type() {

        $this->data['transHead'] = $this->master_model->get_data('jobtypeheader')->result();
        $this->load->view('admin/master/addjob_type', $this->data);
    }

    public function loadmodal_editjob_type() {
        $id = $_REQUEST['id'];

        $this->data['transHead'] = $this->master_model->get_data('jobtypeheader')->result();
        $this->data['trans'] = $this->db->select('*')->where('jobtype_id',$id)->get('jobtype')->row();
        $this->load->view('admin/master/editjob_type', $this->data);
    }

    public function job_section() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/job_section');
            $this->page_title->push(('Job Sections'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('job_section')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/job_section', $this->data);
        }
    }

    public function loadmodal_addjob_section() {
        $this->load->view('admin/master/addjob_section', $this->data);
    }

    public function loadmodal_editjob_section() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('JobSecNo',$id)->get('job_section')->row();
        $this->load->view('admin/master/editjob_section', $this->data);
    }

    public function emp_type() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/job_section');
            $this->page_title->push(('Employee Type'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('emp_type')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/emp-type', $this->data);
        }
    }



    public function loadmodal_addemp_type() {
        $this->load->view('admin/master/add-emp-type', $this->data);
    }

    public function loadmodal_editemp_type() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('EmpTypeNo',$id)->get('emp_type')->row();
        $this->load->view('admin/master/edit-emp-type', $this->data);
    }

    public function getModelMyMake() {
        $makeid = $_POST['dep'];
        $data['result'] = $this->db->select()->from('model')->where(array('makeid' => $makeid))->get()->result();
        echo json_encode($data); die;
    }
    
    public function getSubDepByDep() {
        
           $dep = $_POST['dep'];
            $this->data['subdepartment'] = $this->master_model->getSubDepByDep('subdepartment',$dep);
            echo json_encode($this->data['subdepartment']);
            die;
    }
    
    public function getCatByDep() {
           $dep = $_POST['dep'];
           $subDep = $_POST['subDep'];
            $this->data['category'] = $this->master_model->getCatByDep('category',$dep,$subDep);
            echo json_encode($this->data['category']);
            die;
    }
    
     public function getSubCatByDep() {
           $dep = $_POST['dep'];
           $subDep = $_POST['subDep'];
           $cat = $_POST['cat'];
            $this->data['subcategory'] = $this->master_model->getSubCatByDep('subcategory',$dep,$subDep,$cat);
            echo json_encode($this->data['subcategory']);
            die;
    }
    public function addMake() {
        $data['make'] = $_POST['department'];
        $data['result'] = $this->db->insert('make', $data);
        $data['make_id'] = $this->db->insert_id();
        if($data['result']) {
            echo json_encode($data);
        }
        die;
    }

    public function addFuel() {
        $data['fuel_type'] = $_POST['department'];
        $data['result'] = $this->db->insert('fuel_type', $data);
        $data['fuel_id'] = $this->db->insert_id();
        if($data['result']) {
            echo json_encode($data);
        }
        die;
    }

    public function addModel() {
        $data['makeid'] = $_POST['department1'];
        if($data['makeid'] == '') {
            echo json_encode(array('result'=> 'error')); die;
        }
        $data['model'] = $_POST['subdepartment'];
        $data['model_code'] =  isset($_POST['model_code'])?$_POST['model_code']:NULL;;
        
        $data['result'] = $this->db->insert('model', $data);
        $data['id'] = $this->db->insert_id();
        if($data['result']) {
            echo json_encode($data);
        }
        die;
    }

    public function editMake() {
        $level = $_POST['level'];
        $data['value'] = $_POST['edesc'];
        if($level == 1) {
            $id = $_POST['edepartment'];
            $data['result'] = $this->db->update('make',array('make'=>$data['value']), array('make_id' => $id));
        } else if($level == 2) {
            $id = $_POST['esubdepartment'];
            $data['result'] = $this->db->update('model',array('model'=>$data['value']), array('model_id' => $id));
        }
        $data['level'] = $level;
        $data['id'] = $id;
        if($data['result']) {
            echo json_encode($data);
        }
        die;
    }
    
    public function addDep() {
        $res = $this->master_model->get_max_depcode('department');
        foreach ($res->result() as $row)
        {
                $code= $row->DepCode+1;
        }
        
        $data = array(
            'Description' => $this->input->post('department'),
            'DepCode' => $code
        );
        $res2 = $this->master_model->insert_data('department',$data);
        $data['fb']=$res2;
         echo json_encode($data);
         die;
    }
    
    public function addSubDep() {
        $res = $this->master_model->get_max_subdepcode('subdepartment');
        foreach ($res->result() as $row)
        {
                $code= $row->SubDepCode+1;
        }
        $data = array(
            'Description' => $this->input->post('subdepartment'),
            'DepCode' => $this->input->post('department1'),
            'SubDepCode'=> $code
        );
        $res2 = $this->master_model->insert_data('subdepartment',$data);
        $data['fb']=$res2;
         echo json_encode($data);
         die;
    }
    
    public function addCat() {
        $res = $this->master_model->get_max_catcode('category');
        foreach ($res->result() as $row)
        {
                $code= $row->CategoryCode+1;
        }
        $data = array(
            'Description' => $this->input->post('category'),
            'DepCode' => $this->input->post('department2'),
            'SubDepCode' => $this->input->post('subdepartment1'),
            'CategoryCode'=> $code
        );
        $res2 = $this->master_model->insert_data('category',$data);
        $data['fb']=$res2;
         echo json_encode($data);
         die;
    }
    
    public function addSubCat() {
        $res = $this->master_model->get_max_subcatcode('subcategory');
        foreach ($res->result() as $row)
        {
                $code= $row->SubCategoryCode+1;
        }
        $data = array(
            'Description' => $this->input->post('subcategory'),
            'DepCode' => $this->input->post('department3'),
            'SubDepCode' => $this->input->post('subdepartment2'),
            'CategoryCode' => $this->input->post('category1'),
            'SubCategoryCode'=> $code
        );
        $res2 = $this->master_model->insert_data('subcategory',$data);
        $data['fb']=$res2;
         echo json_encode($data);
         die;
    }
    
    public function editDep() {
        $level = $this->input->post('level');
        $table = '';
        switch ($level) {
            case 1:
                $table = 'department';
                $data = array('Description' => $this->input->post('edesc'));
                $id = array(
                    'DepCode' => $this->input->post('edepartment')
                );
                $code = $this->input->post('edepartment');
                break;
            case 2:
                $table = 'subdepartment';
                $data = array('Description' => $this->input->post('edesc'));
                $id = array('DepCode' => $this->input->post('edepartment'),
                    'SubDepCode' => $this->input->post('esubdepartment'));
                $code = $this->input->post('esubdepartment');
                break;
            case 3:
                $table = 'category';
                $data = array('Description' => $this->input->post('edesc'));
                $id = array('DepCode' => $this->input->post('edepartment'),
                    'SubDepCode' => $this->input->post('esubdepartment'),
                    'CategoryCode' => $this->input->post('ecategory')
                );
                $code = $this->input->post('ecategory');
                break;
            case 4:
                $table = 'subcategory';
                $data = array('Description' => $this->input->post('edesc'));
                $id = array('DepCode' => $this->input->post('edepartment'),
                    'SubDepCode' => $this->input->post('esubdepartment'),
                    'CategoryCode' => $this->input->post('ecategory'),
                    'SubCategoryCode' => $this->input->post('esubcategory')
                );
                $code = $this->input->post('esubcategory');
                break;

            default:
                break;
        }
        
        $res2 = $this->master_model->update_data($table,$data,$id);
        $data['fb']=$res2;
        $data['level']=$level;
         $data['code']=$code;
         echo json_encode($data);
         die;
    }
    
    public function deleteDep() {
        $level = $this->input->post('level');
        $table = '';
        switch ($level) {
            case 1:
                $table = 'department';
                $id = array(
                    'DepCode' => $this->input->post('edepartment')
                );
                break;
            case 2:
                $table = 'subdepartment';
                $id = array('SubDepCode' => $this->input->post('esubdepartment'));
                break;
            case 3:
                $table = 'category';
                $id = array('CategoryCode' => $this->input->post('ecategory')
                );
                break;
            case 4:
                $table = 'subcategory';
                $id = array('SubCategoryCode' => $this->input->post('esubcategory')
                );
                break;
        }
        
        $res2 = $this->master_model->deleteCategory($table,$id,$level);
        $data['fb']=$res2;
        $data['level']=$level;
         echo json_encode($data);
         die;
    }
    
    public function addTransType() {
         $transactionCode =$this->db->select_max('TransactionCode')->get('transactiontypes')->row()->TransactionCode;
         $name =$_POST['name'];
         $remark =$_POST['remark'];
         $expense =$_POST['cash_type'];      
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'TransactionCode' => ($transactionCode+1),
            'TransactionName' => $name,
            'IsExpenses' => $expense,
            'Remark' => $remark,
            'IsActive'=> $act
        );
         $this->db->trans_start();
         $this->db->insert('transactiontypes',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['TransactionCode']=($transactionCode+1);
        $data['Description']=$name;
        echo json_encode($data);
        die();
    }
    
    public function editTransType() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $remark =$_POST['remark'];
         $expense =$_POST['cash_type'];      
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'TransactionCode' => ($transactionCode),
            'TransactionName' => $name,
            'IsExpenses' => $expense,
            'Remark' => $remark,
            'IsActive'=> $act
        );
        $this->db->trans_start();
        $this->db->update('transactiontypes',$data2,array('TransactionCode' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['TransactionCode']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteTransType() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('transactiontypes',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function addJobCardDescription() {
         $transactionCode =$this->db->select_max('JobDescNo')->get('jobdescription')->row()->JobDescNo;
         $name =$_POST['name'];
         $jobcardcategory =$_POST['jobCardCategory'];
         
         $data2 = array(
            'JobDescNo' => ($transactionCode+1),
            'JobDescription' => $name,
            'jobcard_category' => $jobcardcategory 
        );
         $this->db->trans_start();
         $this->db->insert('jobdescription',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode+1);
        $data['JobDescription']=$name;
        $data['jobcard_category']=$jobcardcategory;
        echo json_encode($data);
        die();
    }
    
    public function editJobCardDescription() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $jobcardcategory = $_POST['jobCardCategory'];
         
         $data2 = array(
            'JobDescNo' => ($transactionCode),
            'JobDescription' => $name,
            'jobcard_category' => $jobcardcategory 
        );
        $this->db->trans_start();
        $this->db->update('jobdescription',$data2,array('JobDescNo' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteJobCardDescription() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('jobdescription',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function addJobInvDescription() {
         $transactionCode =$this->db->select_max('JobDescNo')->get('inv_jobdescription')->row()->JobDescNo;
         $name =$_POST['name'];
         $remark =$_POST['remark'];
         $expense =$_POST['cash_type'];
         $isVat =isset($_POST['isVat']) ? 1 : 0;  
         $isNbt =isset($_POST['isNbt']) ? 1 : 0;
         $nbtRatio =isset($_POST['nbtRatio']) ? $_POST['nbtRatio'] : 1;      
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'JobDescription' => $name,
            'jobtype' => $expense,
            'JobCost' => $remark,
            'isVat' => $isVat,
            'isNbt' => $isNbt,
            'nbtRatio' => $nbtRatio
        );
         $this->db->trans_start();
         $this->db->insert('inv_jobdescription',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode+1);
        $data['JobDescription']=$name;
        echo json_encode($data);
        die();
    }
    
    public function editJobInvDescription() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $remark =$_POST['remark'];
         $expense =$_POST['cash_type']; 
         $isVat =isset($_POST['isVat']) ? 1 : 0;  
         $isNbt =isset($_POST['isNbt']) ? 1 : 0;
         $nbtRatio =isset($_POST['nbtRatio']) ? $_POST['nbtRatio'] : 1;     
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'JobDescription' => $name,
            'jobtype' => $expense,
            'JobCost' => $remark,
            'isVat' => $isVat,
            'isNbt' => $isNbt,
            'nbtRatio' => $nbtRatio
        );
        $this->db->trans_start();
        $this->db->update('inv_jobdescription',$data2,array('JobDescNo' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteJobInvDescription() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('inv_jobdescription',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function addJobType() {
         $transactionCode =$this->db->select_max('jobtype_id')->get('jobtype')->row()->jobtype_id;
         $name =$_POST['name'];
         $head =$_POST['jobCategory'];
         $remark =$_POST['remark'];
         $expense =$_POST['cash_type'];  
         $isVat =isset($_POST['isVat']) ? 1 : 0;  
         $isNbt =isset($_POST['isNbt']) ? 1 : 0;
         $nbtRatio =isset($_POST['nbtRatio']) ? $_POST['nbtRatio'] : 1;

         $data2 = array(
            'jobtype_name' => $name,
            'jobtype_code' => $expense,
            'jobhead' => $head,
            'jobtype_order' => $remark,
            'isVat' => $isVat,
            'isNbt' => $isNbt,
            'nbtRatio' => $nbtRatio
        );
         $this->db->trans_start();
         $this->db->insert('jobtype',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['TransactionCode']=($transactionCode+1);
        echo json_encode($data);
        die();
    }

    public function editJobType() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $head =$_POST['jobCategory'];
         $remark =$_POST['remark'];
         $expense =$_POST['cash_type'];    
         $isVat =isset($_POST['isVat']) ? 1 : 0;
         $isNbt =isset($_POST['isNbt']) ? 1 : 0;
         $nbtRatio =isset($_POST['nbtRatio']) ? $_POST['nbtRatio'] : 1;
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'jobtype_name' => $name,
            'jobtype_code' => $expense,
            'jobhead' => $head,
            'jobtype_order' => $remark,
            'isVat' => $isVat,
            'isNbt' => $isNbt,
            'nbtRatio' => $nbtRatio
        );
        $this->db->trans_start();
        $this->db->update('jobtype',$data2,array('jobtype_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['TransactionCode']=($transactionCode);
        echo json_encode($data);
        die();
    }

    public function addJobSection() {
         $transactionCode =$this->db->select_max('JobSecNo')->get('job_section')->row()->JobSecNo;
         $name =$_POST['name'];
         
         $data2 = array(
            'JobSecNo' => ($transactionCode+1),
            'JobSection' => $name
        );
         $this->db->trans_start();
         $this->db->insert('job_section',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobSecNo']=($transactionCode+1);
        $data['JobSection']=$name;
        echo json_encode($data);
        die();
    }
    
    public function editJobSection() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         
         $data2 = array(
            'JobSecNo' => ($transactionCode),
            'JobSection' => $name
        );
        $this->db->trans_start();
        $this->db->update('job_section',$data2,array('JobSecNo' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobSecNo']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteJobSection() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('job_section',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function addInsCompany() {
         $transactionCode =$this->db->select_max('VComId')->get('vehicle_company')->row()->VComId;
         $name =$_POST['name'];
         $expense =$_POST['cash_type'];      
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'VComName' => $name,
            'VComCategory' => $expense
        );
         $this->db->trans_start();
         $this->db->insert('vehicle_company',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode+1);
        $data['JobDescription']=$name;
        echo json_encode($data);
        die();
    }
    
    public function editInsCompany() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $expense =$_POST['cash_type'];      
         if(isset($_POST['isAct'])){$act =1;}else{$act=0;}
         
         $data2 = array(
            'VComName' => $name,
            'VComCategory' => $expense
        );
        $this->db->trans_start();
        $this->db->update('vehicle_company',$data2,array('VComId' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteInsCompany() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('vehicle_company',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }



    ///////////////////////////////////////////////////////////////////////////////
    public function jobcard_category() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/jobcard-category');
            $this->page_title->push(('Job Card Category'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('jobcategory')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/jobcard-category', $this->data);
        }
    }

     public function loadmodal_addjobcard_category() {
        
        $this->load->view('admin/master/addjobcard_category', $this->data);
    }

    public function loadmodal_editjobcard_category() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('jobcategory_id',$id)->get('jobcategory')->row();
        $this->load->view('admin/master/editjobcard_category', $this->data);
    }

    public function addJobCardCategory() {
         $transactionCode =$this->db->select_max('jobcategory_id')->get('jobcategory')->row()->jobcategory_id;
         $name =$_POST['name'];
         
         $data2 = array(
            'jobcategory_id' => ($transactionCode+1),
            'job_category' => $name
        );
         $this->db->trans_start();
         $this->db->insert('jobcategory',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['jobcategory_id']=($transactionCode+1);
        $data['job_category']=$name;
        echo json_encode($data);
        die();
    }

    public function editJobCardCategory() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         
         $data2 = array(
            'jobcategory_id' => ($transactionCode),
            'job_category' => $name
        );
        $this->db->trans_start();
        $this->db->update('jobcategory',$data2,array('jobcategory_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['jobcategory_id']=($transactionCode);
        echo json_encode($data);
        die();
    }

    public function addEmpType() {
         $transactionCode =$this->db->select_max('EmpTypeNo')->get('emp_type')->row()->EmpTypeNo;
         $name =$_POST['name'];
         
         $data2 = array(
            'EmpTypeNo' => ($transactionCode+1),
            'EmpType' => $name
        );
         $this->db->trans_start();
         $this->db->insert('emp_type',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['EmpTypeNo']=($transactionCode+1);
        $data['EmpType']=$name;
        echo json_encode($data);
        die();
    }

    public function editEmpType() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         
         $data2 = array(
            'EmpTypeNo' => ($transactionCode),
            'EmpType' => $name
        );
        $this->db->trans_start();
        $this->db->update('emp_type',$data2,array('EmpTypeNo' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['EmpTypeNo']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteEmpType() {
        $id =$_POST['id'];
        $res2 = $this->db->delete('emp_type',array('EmpTypeNo' =>$id));
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function store_rack() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/store_rack');
            $this->page_title->push(('Store Rack'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->db->select('*')->from('rack')->join('location','location_id=rack_loc')->get()->result();
            /* Load Template */
            $this->template->admin_render('admin/master/store-rack', $this->data);
        }
    }

     public function loadmodal_addstore_rack() {    
        
        $this->data['location'] = $this->master_model->get_data('location')->result();
        $this->load->view('admin/master/addrack', $this->data);
    }

    public function loadmodal_editstore_rack() {
        $id = $_REQUEST['id'];

        $this->data['location'] = $this->master_model->get_data('location')->result();
        $this->data['trans'] = $this->db->select('*')->from('rack')->join('location','location_id=rack_loc')->where('rack_id',$id)->get()->row();
        $this->load->view('admin/master/editrack', $this->data);
    }

    public function addRack() {
        $transactionCode =$this->db->select_max('rack_id')->get('rack')->row()->rack_id;
        $name =$_POST['name'];
        $location = $_POST['location'];
         
        $data2 = array(
            'rack_id' => ($transactionCode+1),
            'rack_no' => $name,
            'rack_loc' => $location
        );
        $this->db->trans_start();
        $this->db->insert('rack',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['rack_id']=($transactionCode+1);
        $data['rack_no']=$name;
        echo json_encode($data);
        die();
    }

    public function editRack() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $location = $_POST['location'];

         $data2 = array(
            'rack_id' => ($transactionCode),
            'rack_no' => $name,
            'rack_loc' => $location
        );
        $this->db->trans_start();
        $this->db->update('rack',$data2,array('rack_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['rack_id']=($transactionCode);
        echo json_encode($data);
        die();
    }

    public function store_location() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/jobcard-description');
            $this->page_title->push(('Store Location'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->db->select('store_location.*,rack.rack_no')->from('store_location')->join('rack', 'rack.rack_id = store_location.store_rack')
       ->get()->result();
            
           
            /* Load Template */
            $this->template->admin_render('admin/master/store_location', $this->data);
        }
    }
    
    public function loadmodal_addstore_location() {
         $this->data['jobcardcategory'] = $this->master_model->get_data('rack')->result();
        $this->load->view('admin/master/addstore_location', $this->data);
    }

    public function loadmodal_editstore_location() {
        $id = $_REQUEST['id'];
        $this->data['jobcategory'] = $this->master_model->get_data('rack')->result();
        $this->data['trans'] = $this->db->select('*')->where('store_location.store_id',$id)->get('store_location')->row();

        $this->load->view('admin/master/editstore_location', $this->data);
    }

    public function addBinNo() {
        $transactionCode =$this->db->select_max('store_id')->get('store_location')->row()->store_id;
        $name =$_POST['name'];
        $jobcardcategory =$_POST['jobCardCategory'];
         
        $data2 = array(
            'store_id' => ($transactionCode+1),
            'bin_no' => $name,
            'store_rack' => $jobcardcategory 
        );
        $this->db->trans_start();
        $this->db->insert('store_location',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['store_id']=($transactionCode+1);
        $data['bin_no']=$name;
        $data['store_rack']=$jobcardcategory;
        echo json_encode($data);
        die();
    }
    
    public function editBinNo() {
        $transactionCode =$_POST['id'];
        $name =$_POST['name'];
        $jobcardcategory = $_POST['jobCardCategory'];
         
        $data2 = array(
            'store_id' => ($transactionCode),
            'bin_no' => $name,
            'store_rack' => $jobcardcategory 
        );
        $this->db->trans_start();
        $this->db->update('store_location',$data2,array('store_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['store_id']=($transactionCode);
        echo json_encode($data);
        die();
    }

    //////// Product Brand //////////

      public function product_brand() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/product_brand');
            $this->page_title->push(('Product Brand'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['productBrand'] = $this->master_model->get_data('productbrand')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/product_brand', $this->data);
        }
    }

     public function loadmodal_addproduct_brand() {
        $this->load->view('admin/master/addproduct_brand', $this->data);
    }

      public function addProductBrand() {
         $transactionCode =$this->db->select_max('BrandID')->get('productbrand')->row()->BrandID;
         $name =$_POST['name'];
         
         $data2 = array(
            'BrandID' => ($transactionCode+1),
            'BrandName' => $name
        );
         $this->db->trans_start();
         $this->db->insert('productbrand',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['BrandID']=($transactionCode+1);
        $data['BrandName']=$name;
        echo json_encode($data);
        die();
    }

      public function loadmodal_editprocuct_brand() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('BrandID',$id)->get('productbrand')->row();
        $this->load->view('admin/master/editprocuct_brand', $this->data);
    }

    public function editProductBrand() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         
         $data2 = array(
            'BrandID' => ($transactionCode),
            'BrandName' => $name
        );
        $this->db->trans_start();
        $this->db->update('productbrand',$data2,array('BrandID' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['BrandID']=($transactionCode);
        echo json_encode($data);
        die();
    }



       //////// Bank Account //////////

      public function bank_account() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/bank_accounts');
            $this->page_title->push(('Bank Account'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
           $this->data['bankAccount'] = $this->db->select('bank_account.*,bank.BankName')->from('bank_account')->join('bank', 'bank_account.acc_bank = bank.BankCode')
       ->get()->result();

           
            /* Load Template */
            $this->template->admin_render('admin/master/bank_accounts', $this->data);
        }
    }

    public function loadmodal_addbank_account() {
         $this->data['bankdetails'] = $this->master_model->get_data('bank')->result();
         $this->load->view('admin/master/addbank_account', $this->data);
    }

    public function addBankAccount() {
         $transactionCode =$this->db->select_max('acc_id')->get('bank_account')->row()->acc_id;
         $bank =$_POST['bank'];
         $accname =$_POST['accname'];
         $accno =$_POST['accno'];
         $status =isset($_POST['bankActive']) ? 1 : 0;  

         
         $data2 = array(
            'acc_id' => ($transactionCode+1),
            'acc_bank' => $bank,
            'acc_name' => $accname,
            'acc_no' => $accno,
            'acc_active' => $status
        );
         $this->db->trans_start();
         $this->db->insert('bank_account',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['acc_id']=($transactionCode+1);
        $data['acc_bank']=$bank;
        $data['acc_name']=$accname;
        $data['acc_no']=$accno;
        $data['acc_active']=$status;
        echo json_encode($data);
        die();
    }

  public function loadmodal_editbank_account() {
        $this->data['bankdetails'] = $this->master_model->get_data('bank')->result();
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('acc_id',$id)->get('bank_account')->row();
        $this->load->view('admin/master/editbank_account', $this->data);
    }
 

public function editBankAccount() {
        $transactionCode =$_POST['id'];
        $bank =$_POST['bank'];
        $accname =$_POST['accname'];
        $accno =$_POST['accno'];
        $status =isset($_POST['bankActive']) ? 1 : 0;
         
         $data2 = array(
            'acc_id' => ($transactionCode),
            'acc_bank' => $bank,
            'acc_name' => $accname,
            'acc_no' => $accno,
            'acc_active' => $status
        );
        $this->db->trans_start();
        $this->db->update('bank_account',$data2,array('acc_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['acc_id']=($transactionCode);
        $data['acc_bank']=$bank;
        $data['acc_name']=$accname;
        $data['acc_no']=$accno;
        $data['acc_active']=$status;
        echo json_encode($data);
        die();
    }
     
 //////// Product Quality //////////

      public function product_quality() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/product_quality');
            $this->page_title->push(('Product Quality'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['productquality'] = $this->master_model->get_data('productquality')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/product_quality', $this->data);
        }
    }


    public function loadmodal_addproduct_quality() {
         $this->load->view('admin/master/addproduct_quality', $this->data);
    }

       public function addProductQuality() {
         $transactionCode =$this->db->select_max('QualityID')->get('productquality')->row()->QualityID;
         $name =$_POST['qualityName'];
         $shortname =$_POST['shortName'];
         
         $data2 = array(
            'QualityID' => ($transactionCode+1),
            'QualityName' => $name,
            'ShortName' => $shortname
        );
         $this->db->trans_start();
         $this->db->insert('productquality',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['QualityID']=($transactionCode+1);
        $data['QualityName']=$name;
        $data['ShortName']=$shortname;

        echo json_encode($data);
        die();
    }


    public function loadmodal_editproduct_quality() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('QualityID',$id)->get('productquality')->row();
        $this->load->view('admin/master/editproduct_quality', $this->data);
    }


     public function editProductQuality(){
        $transactionCode =$_POST['id'];
        $name =$_POST['qualityName'];
        $shortname =$_POST['shortName'];
         
        $data2 = array(
            'QualityID' => ($transactionCode),
            'QualityName' => $name,
            'ShortName' => $shortname
        );
        $this->db->trans_start();
        $this->db->update('productquality',$data2,array('QualityID' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['QualityID']=($transactionCode);
        echo json_encode($data);
        die();
    }


    ////////////////////////////////////////
    public function job_type_header() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/job_type_header');
            $this->page_title->push(('Work Types header'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('jobtypeheader')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/master/job_type_header', $this->data);
        }
    }

    public function loadmodal_addjob_type_header() {
        $this->load->view('admin/master/addjob_type_header', $this->data);
    }

    public function loadmodal_editjob_type_header() {
        $id = $_REQUEST['id'];

        $this->data['transHead'] = $this->master_model->get_data('jobtypeheader')->result();
        $this->data['trans'] = $this->db->select('*')->where('jobhead_id',$id)->get('jobtypeheader')->row();
        $this->load->view('admin/master/editjob_type_header', $this->data);
    }

        public function addJobTypeHeader() {
         $jobheadId =$this->db->select_max('jobhead_id')->get('jobtypeheader')->row()->jobhead_id;
         $name =$_POST['name'];
         $order =$_POST['order'];

         $data2 = array(
            'jobhead_name' => $name,
            'jobhead_order' => $order
        );
         $this->db->trans_start();
         $this->db->insert('jobtypeheader',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['jobhead_id']=($jobheadId+1);
        echo json_encode($data);
        die();
    }

     public function editJobTypeHeader() {
         $jobheadId =$_POST['id'];
          $name =$_POST['name'];
         $order =$_POST['order'];
         
         
         $data2 = array(
            'jobhead_name' => $name,
            'jobhead_order' => $order
        );
        $this->db->trans_start();
        $this->db->update('jobtypeheader',$data2,array('jobhead_id' =>$jobheadId));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['jobhead_id']=($jobheadId);
        echo json_encode($data);
        die();
    }


    ///////////////////////////////////////////////

    public function invoice_condition() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/invoice_condition');
            $this->page_title->push(('Invoice Condition'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->db->select('invoice_condition.*,inv_type.invtype')->from('invoice_condition')->join('inv_type', 'invoice_condition.InvType = inv_type.invtype_id')->get()->result();

           
            /* Load Template */
            $this->template->admin_render('admin/master/invoice_condition', $this->data);
        }
    }

    public function loadmodal_addinvoice_condition() {
         $this->data['inv_type'] = $this->master_model->get_data('inv_type')->result();
         $this->load->view('admin/master/addinvoice_condition', $this->data);
    }

       public function addInvoiceCondition() {
         $InvRemarkId =$this->db->select_max('InvRemarkId')->get('invoice_condition')->row()->InvRemarkId;
         $InvType =$_POST['InvType'];
         $InvCondition =$_POST['InvCondition'];

         $data2 = array(
            'InvType' => $InvType,
            'InvCondition' => $InvCondition
        );
        $this->db->trans_start();
        $this->db->insert('invoice_condition',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['InvRemarkId']=($InvRemarkId+1);
        echo json_encode($data);
        die();
    }


    public function loadmodal_editinvoice_condition() {
        $this->data['inv_type'] = $this->master_model->get_data('inv_type')->result();
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('InvRemarkId',$id)->get('invoice_condition')->row();
        $this->load->view('admin/master/editinvoice_condition', $this->data);
    }
 

    public function editInvoiceCondition() {
        $InvRemarkId =$_POST['id'];
        $InvType =$_POST['InvType'];
        $InvCondition =$_POST['InvCondition'];
         
         $data2 = array(
            'InvRemarkId' => ($InvRemarkId),
            'InvType' => $InvType,
            'InvCondition' => $InvCondition
        );
        $this->db->trans_start();
        $this->db->update('invoice_condition',$data2,array('InvRemarkId' =>$InvRemarkId));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['InvRemarkId']=($InvRemarkId);
        $data['InvType']=$InvType;
        $data['InvCondition']=$InvCondition;
        echo json_encode($data);
        die();
    }

        public function deleteInvCon() {
        $inv = $this->input->post('inv');
   

        $table = '';
        
                $table = 'invoice_condition';
              
        
        $res2 = $this->master_model->deleteInvCon($table,$inv);
        $data['fb']=$res2;
        $data['inv']=$inv;
         echo json_encode($data);
         die;
    }

    ////////////////////////////////////////////////////////////////

        public function mercedes_model_codes() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/mercedes_model_codes');
            $this->page_title->push(('Mercedes Model codes'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('model')->result();

            /* Load Template */
            $this->template->admin_render('admin/master/mercedes_model_codes', $this->data);
        }
    }

    public function loadmodal_addmercedes_model_codes() {
         $this->load->view('admin/master/addmercedes_model_codes', $this->data);
    }

       public function addMercedesModelcodes() {
         $model_id =$this->db->select_max('model_id')->get('model')->row()->InvRemarkId;
         $makeid =$_POST['makeid'];
         $model_code =$_POST['model_code'];
         $model =$_POST['model_name'];

         $data2 = array(
            'makeid' => $makeid,
            'model_code' => $model_code,
            'model' => $model
        );
        $this->db->trans_start();
        $this->db->insert('model',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['model_id']=($model_id+1);
        echo json_encode($data);
        die();
    }

    public function loadmodal_editmercedes_model_codes() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('model_id',$id)->get('model')->row();
        $this->load->view('admin/master/editmercedes_model_codes', $this->data);
    }
 

    public function editMercedesModelcodes() {
        $model_id =$_POST['id'];
        $makeid =$_POST['makeid'];
        $model_code =$_POST['model_code'];
        $model =$_POST['model_name'];
         
         $data2 = array(
            'model_id' => ($model_id),
            'makeid' => $makeid,
            'model_code' => $model_code,
            'model' => $model
        );
        $this->db->trans_start();
        $this->db->update('model',$data2,array('model_id' =>$model_id));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['model_id']=($model_id);
        $data['makeid']=$makeid;
        $data['model_code']=$model_code;
        $data['model']=$model;
        echo json_encode($data);
        die();
    }

    public function getModelByName(){
        $chassis = $_POST['chassi'];
        $model =0;
        $isAva = $this->db->select('*')->from('model')->where('model_code',$chassis)->get()->num_rows();

        if($isAva>0){
          $model =  $this->db->select('model')->from('model')->where('model_code',$chassis)->get()->row()->model;
          echo $model;
        }else{
            echo 0;
        }
        die;
    }

    public function getModelByCode(){
        $chassis = $_POST['chassi'];
        $model =0;
        $isAva = $this->db->select('*')->from('model')->where('model_code',$chassis)->get()->num_rows();

        if($isAva>0){
          $model =  $this->db->select('model_id')->from('model')->where('model_code',$chassis)->get()->row()->model_id;
          echo $model;
        }else{
            echo 0;
        }
        die;
    }


////////////////////////////////////////////////////////////
       public function company_details() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/company_details');
            $this->page_title->push(('Company Details'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->master_model->get_data('company')->result();

            /* Load Template */
            $this->template->admin_render('admin/master/company_details', $this->data);
        }
    }

    public function loadmodal_addcompany_details() {
         $this->load->view('admin/master/addcompany_details', $this->data);
    }


    public function addcompany_details() {
         $CompanyID =$this->db->select_max('CompanyID')->get('company')->row()->CompanyID;
         $CompanyName =$_POST['CompanyName'];
         $CompanyName2 =$_POST['CompanyName2'];
         $RegNo =$_POST['RegNo'];
         $AddressLine01 =$_POST['AddressLine01'];
         $AddressLine02 =$_POST['AddressLine02'];
         $AddressLine03 =$_POST['AddressLine03'];
         $MobileNo =$_POST['MobileNo'];
         $LanLineNo =$_POST['LanLineNo'];
         $Fax =$_POST['Fax'];
        if(isset($_POST['IsActive'])){$act =1;}else{$act=0;}
         $Email01 =$_POST['Email01'];
         $Email02 =$_POST['Email02'];
         $SAdvisorName =$_POST['SAdvisorName'];
         $SAdvisorContact =$_POST['SAdvisorContact'];
         $VAT =$_POST['VAT'];
         $NBT =$_POST['NBT'];
         $NBT_Ratio =$_POST['NBT_Ratio'];

         $data2 = array(
            'CompanyName' => $CompanyName,
            'CompanyName2' => $CompanyName2,
            'RegNo' => $RegNo,
            'AddressLine01' => $AddressLine01,
            'AddressLine02' => $AddressLine02,
            'AddressLine03' => $AddressLine03,
            'MobileNo' => $MobileNo,
            'LanLineNo' => $LanLineNo,
            'Fax' => $Fax,
            'Email01' => $Email01,
            'Email02' => $Email02,
            'IsActive' => $act,
            'SAdvisorName' => $SAdvisorName,
            'SAdvisorContact' => $SAdvisorContact,
            'VAT' => $VAT,
            'NBT' => $NBT,
            'NBT_Ratio' => $NBT_Ratio


        );
        $this->db->trans_start();
        $this->db->insert('company',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['CompanyID']=($CompanyID+1);
        echo json_encode($data);
        die();
    }

    public function loadmodal_edicompany_details() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('CompanyID',$id)->get('company')->row();
        $this->load->view('admin/master/editcompany_details', $this->data);
    }

      public function editcompany_details() {
         $CompanyID =$_POST['id'];
         $CompanyName =$_POST['CompanyName'];
         $CompanyName2 =$_POST['CompanyName2'];
         $RegNo =$_POST['RegNo'];
         $AddressLine01 =$_POST['AddressLine01'];
         $AddressLine02 =$_POST['AddressLine02'];
         $AddressLine03 =$_POST['AddressLine03'];
         $MobileNo =$_POST['MobileNo'];
         $LanLineNo =$_POST['LanLineNo'];
         $Fax =$_POST['Fax'];
        if(isset($_POST['IsActive'])){$act =1;}else{$act=0;}
         $Email01 =$_POST['Email01'];
         $Email02 =$_POST['Email02'];
         $SAdvisorName =$_POST['SAdvisorName'];
         $SAdvisorContact =$_POST['SAdvisorContact'];
         $VAT =$_POST['VAT'];
         $NBT =$_POST['NBT'];
         $NBT_Ratio =$_POST['NBT_Ratio'];
         
         $data2 = array(
            'CompanyName' => $CompanyName,
            'CompanyName2' => $CompanyName2,
            'RegNo' => $RegNo,
            'AddressLine01' => $AddressLine01,
            'AddressLine02' => $AddressLine02,
            'AddressLine03' => $AddressLine03,
            'MobileNo' => $MobileNo,
            'LanLineNo' => $LanLineNo,
            'Fax' => $Fax,
            'Email01' => $Email01,
            'Email02' => $Email02,
            'IsActive' => $act,
            'SAdvisorName' => $SAdvisorName,
            'SAdvisorContact' => $SAdvisorContact,
            'VAT' => $VAT,
            'NBT' => $NBT,
            'NBT_Ratio' => $NBT_Ratio
        );
        $this->db->trans_start();
        $this->db->update('company',$data2,array('CompanyID' =>$CompanyID));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['CompanyID']=($CompanyID);
        $data['CompanyName']=$CompanyName;
        $data['CompanyName2']=$CompanyName2;
        $data['RegNo']=$RegNo;
        $data['AddressLine01']=$AddressLine01;
        $data['AddressLine02']=$AddressLine02;
        $data['AddressLine03']=$AddressLine03;
        $data['MobileNo']=$MobileNo;
        $data['LanLineNo']=$LanLineNo;
        $data['Fax']=$Fax;
        $data['Email01']=$Email01;
        $data['Email02']=$Email02;
        $data['IsActive']=$IsActive;
        $data['SAdvisorName']=$SAdvisorName;
        $data['SAdvisorContact']=$SAdvisorContact;
        $data['VAT']=$VAT;
        $data['NBT']=$NBT;
        $data['NBT_Ratio']=$NBT_Ratio;
        echo json_encode($data);
        die();
    }

    public function manageInterest() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/manageInterest');
            $this->page_title->push(('Manage Interest'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['interestManage'] = $this->db->select('item_interest.*, account_type.Description')
                ->from('item_interest')
                ->join('account_type', 'account_type.DepNo = item_interest.ItemType')
                ->get()->result();


            /* Load Template */
            $this->template->admin_render('admin/master/manage_interest', $this->data);
        }
    }

    public function loadmodal_add_manage_interest() {
        $this->data['getCusAccountTypes'] = $this->Customer_model->customerAccountType();
        $this->load->view('admin/master/manage_interst_add', $this->data);
    }

    public function addInterest() {
        $rate =$_POST['rate'];
        $term =$_POST['interestterm'];
        $category =$_POST['category'];

        $data2 = array(
            'Interest' => $rate,
            'IntTerm' => $term,
            'ItemType' => $category
        );
        $this->db->trans_start();
        $this->db->insert('item_interest',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        echo json_encode($data);
        die();
    }

    public function loadmodal_edit_manage_interest() {
        $id = $_REQUEST['id'];
        $this->data['getCusAccountTypes'] = $this->Customer_model->customerAccountType();
        $this->data['trans'] = $this->db->select('*')->where('item_interest.IntId',$id)->get('item_interest')->row();

        $this->load->view('admin/master/manage_interst_edit', $this->data);
    }

    public function editInterest() {
        $rate =$_POST['rate'];
        $term =$_POST['interestterm'];
        $category =$_POST['category'];
        $IntId =$_POST['id'];

        $data2 = array(
            'Interest' => $rate,
            'IntTerm' => $term,
            'ItemType' => $category
        );
        $this->db->trans_start();
        $this->db->update('item_interest',$data2,array('IntId' =>$IntId));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        echo json_encode($data);
        die();
    }

    public function holiday() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/holiday');
            $this->page_title->push(('Manage Holiday Schedule'));
            $this->data['pagetitle'] = $this->page_title->show();

            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->data['holiday'] = $this->db->select('*')
                ->from('holiday_schedule')
                ->get()->result();
            $this->template->admin_render('admin/master/holiday', $this->data);
        }
    }

    public function loadmodal_add_holiday()
    {
        $this->load->view('admin/master/holiday_add', $this->data);
    }

    public function addHoliday() {
        $name =$_POST['name'];
        $date =$_POST['date'];
        $remark =$_POST['remark'];

        $data2 = array(
            'name' => $name,
            'date' => $date,
            'remark' => $remark
        );
        $this->db->trans_start();
        $this->db->insert('holiday_schedule',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        echo json_encode($data);
        die();
    }

    public function loadmodal_edit_holiday() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('holiday_schedule.id',$id)->get('holiday_schedule')->row();

        $this->load->view('admin/master/holiday_edit', $this->data);
    }

    public function editHoliday() {
        $name =$_POST['name'];
        $date =$_POST['date'];
        $remark =$_POST['remark'];
        $id =$_POST['id'];

        $data2 = array(
            'name' => $name,
            'date' => $date,
            'remark' => $remark
        );
        $this->db->trans_start();
        $this->db->update('holiday_schedule',$data2,array('id' =>$id));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        echo json_encode($data);
        die();
    }

    public function extraCharges() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/extraCharges');
            $this->page_title->push(('Manage Extra Charges'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['extraCharges'] = $this->db->select('item_charges.*, account_type.Description,charges_type.charge_type')
                ->from('item_charges')
                ->join('account_type', 'account_type.DepNo = item_charges.ItemType')
                ->join('charges_type', 'charges_type.charge_id = item_charges.ChargeType')
                ->get()->result();


            /* Load Template */
            $this->template->admin_render('admin/master/extra_charges', $this->data);
        }
    }

    public function loadmodal_add_ExtraCharges() {
        $this->data['getCusAccountTypes'] = $this->Customer_model->customerAccountType();
        $this->data['getExtraChargesTypes'] = $this->Customer_model->getExtraChargesTypes();
        $this->load->view('admin/master/extra_charges_add', $this->data);
    }

    public function addExtraCharges() {
        $amount =$_POST['amount'];
        $chargeType =$_POST['chargeType'];
        $category =$_POST['category'];

        $data2 = array(
            'ChargeAmount' => $amount,
            'ChargeType' => $chargeType,
            'ItemType' => $category
        );
        $this->db->trans_start();
        $this->db->insert('item_charges',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        echo json_encode($data);
        die();
    }

    public function loadmodal_edit_ExtraCharges() {
        $id = $_REQUEST['id'];
        $this->data['getCusAccountTypes'] = $this->Customer_model->customerAccountType();
        $this->data['getExtraChargesTypes'] = $this->Customer_model->getExtraChargesTypes();
        $this->data['trans'] = $this->db->select('*')->where('item_charges.ChargeId',$id)->get('item_charges')->row();

        $this->load->view('admin/master/extra_charges_edit', $this->data);
    }

    public function editExtraCharges() {
        $amount =$_POST['amount'];
        $chargeType =$_POST['chargeType'];
        $category =$_POST['category'];
        $id =$_POST['id'];

        $data2 = array(
            'ChargeAmount' => $amount,
            'ChargeType' => $chargeType,
            'ItemType' => $category
        );
        $this->db->trans_start();
        $this->db->update('item_charges',$data2,array('ChargeId' =>$id));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        echo json_encode($data);
        die();
    }

    
    // customer routes function
    public function customer_routes() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            // Redirect to login page if the user is not logged in or not an admin
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/customer_routes');
            $this->page_title->push(('Customer Routes'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            // Fetch data related to customer routes from the model
            $this->data['customerRoutes'] = $this->master_model->get_data('customer_routes')->result();

            /* Load Template */
            // Load the 'customer_routes' view and pass the data
            $this->template->admin_render('admin/master/customer_routes', $this->data);
        }
    }

    public function loadmodal_customer_routes() {
        $this->load->view('admin/master/add-customer-routes', $this->data);
    }

    public function loadmodal_editcustomer_routes() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('id',$id)->get('customer_routes')->row();
        $this->load->view('admin/master/edit_customer_routes', $this->data);
    }

    public function addCustomerRoute() {
        $transactionCode =$this->db->select_max('id')->get('customer_routes')->row()->id;
        $name = strtoupper($this->input->post('name'));
        
        $data2 = array(
           'id' => ($transactionCode+1),
           'name' => $name
       );
        $this->db->trans_start();
        $this->db->insert('customer_routes',$data2);
       $this->db->trans_complete();
       $res2 = $this->db->trans_status();
       $data['fb']=$res2;
       $data['id']=($transactionCode+1);
       $data['name']=$name;
       echo json_encode($data);
       die();
    }

    public function editCustomerRoute() {
        $transactionCode =$_POST['id'];
        $name =strtoupper($this->input->post('name'));
        
        $data2 = array(
           'id' => ($transactionCode),
           'name' => $name
       );
       $this->db->trans_start();
       $this->db->update('customer_routes',$data2,array('id' =>$transactionCode));
       $this->db->trans_complete();
       $res2 = $this->db->trans_status();
       $data['fb']=$res2;
       $data['id']=($transactionCode);
       echo json_encode($data);
       die();
   }
}


