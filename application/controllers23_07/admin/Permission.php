<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends Admin_Controller {
	public function __construct() {
        parent::__construct();
        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Permission_model');
        date_default_timezone_set("Asia/Colombo");

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function permission_class() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/master/jobcard-category');
            $this->page_title->push(('Class'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->Permission_model->get_data('class')->result();
           
            /* Load Template */
            $this->template->admin_render('admin/permission/class', $this->data);
        }
    }

     public function loadmodal_addclass() {
        $this->load->view('admin/permission/addclass', $this->data);
    }

    public function loadmodal_editclass() {
        $id = $_REQUEST['id'];
        $this->data['trans'] = $this->db->select('*')->where('class_id',$id)->get('class')->row();
        $this->load->view('admin/permission/editclass', $this->data);
    }

    public function addClass() {
         $transactionCode =$this->db->select_max('class_id')->get('class')->row()->class_id;
         $name =$_POST['name'];
         
         $data2 = array(
            'class_id' => ($transactionCode+1),
            'class_name' => $name
        );
         $this->db->trans_start();
         $this->db->insert('class',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['class_id']=($transactionCode+1);
        $data['class_name']=$name;
        echo json_encode($data);
        die();
    }

    public function editClass() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         
         $data2 = array(
            'class_id' => ($transactionCode),
            'class_name' => $name
        );
        $this->db->trans_start();
        $this->db->update('class',$data2,array('class_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['class_id']=($transactionCode);
        echo json_encode($data);
        die();
    }

    public function class_function() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/permission/class_function');
            $this->page_title->push(('Class Function'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->db->select('class_function.*,class.class_name')->from('class_function')->join('class', 'class.class_name = class_function.class_no')->get()->result();
            
           
            /* Load Template */
            $this->template->admin_render('admin/permission/class_function', $this->data);
        }
    }
    
    public function loadmodal_addclass_function() {
         $this->data['class'] = $this->Permission_model->get_data('class')->result();
        $this->load->view('admin/permission/addclass_function', $this->data);
    }

    public function loadmodal_editclass_function() {
        $id = $_REQUEST['id'];
        $this->data['class'] = $this->Permission_model->get_data('class')->result();

        $this->data['function'] = $this->db->select('*')->where('function_id',$id)->get('class_function')->row();


        $this->load->view('admin/permission/editclass_function', $this->data);
    }

     public function addClassFunction() {
         $transactionCode =$this->db->select_max('function_id')->get('class_function')->row()->function_id;
         $name =$_POST['name'];
         $jobcardcategory =$_POST['class'];
         
         $data2 = array(
            'function_id' => ($transactionCode+1),
            'function_name' => $name,
            'class_no' => $jobcardcategory 
        );
         $this->db->trans_start();
         $this->db->insert('class_function',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['JobDescNo']=($transactionCode+1);
        $data['JobDescription']=$name;
        $data['jobcard_category']=$jobcardcategory;
        echo json_encode($data);
        die();
    }
    
    public function editClassFunction() {
         $transactionCode =$_POST['id'];
         $name =$_POST['name'];
         $jobcardcategory = $_POST['class'];
         
         $data2 = array(
            'function_id' => ($transactionCode),
            'function_name' => $name,
            'class_no' => $jobcardcategory 
        );
        $this->db->trans_start();
        $this->db->update('class_function',$data2,array('function_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['function_id']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteClassFunction() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('class_function',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function user_permission() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_category'), 'admin/permission/class_function');
            $this->page_title->push(('User permission'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['transType'] = $this->db->select('permission.*,class.class_name,role.*')->from('permission')->join('class', 'class.class_name = permission.permission_class')->join('role', 'role.role_id = permission.per_user')->get()->result();

            /* Load Template */
            $this->template->admin_render('admin/permission/user_permission', $this->data);
        }
    }
    
    public function loadmodal_adduser_permission() {
        $this->data['class'] = $this->Permission_model->get_data('class')->result();
        $this->data['users'] = $this->db->select('*')->from('users')->where('active',1)->get()->result();
        $this->data['role'] = $this->db->select('*')->from('role')->get()->result();
        $this->load->view('admin/permission/adduser_permission', $this->data);
    }

    public function loadmodal_edituser_permission() {
        $id = $_REQUEST['id'];
        $this->data['class'] = $this->Permission_model->get_data('class')->result();
        $this->data['users'] = $this->db->select('*')->from('users')->where('active',1)->get()->result();
        $this->data['role'] = $this->db->select('*')->from('role')->get()->result();
        $this->data['per'] = $this->db->select('*')->where('permission_id',$id)->get('permission')->row();


        $this->load->view('admin/permission/edituser_permission', $this->data);
    }

     public function addUserPermission() {
         $transactionCode =$this->db->select_max('permission_id')->get('permission')->row()->permission_id;
         $name =($_POST['name']);
         $class =$_POST['class'];
         $user =$_POST['user'];
         $isAllClass =isset($_POST['isAllClass']) ? 1 : 0;  
        
         $data2 = array(
            'permission_id' => ($transactionCode+1),
            'permission_name' => $name,
            'permission_class' => $class,
            'permission_function' => $name,
            'per_user' => $user ,
            'isClass' => $isAllClass 
        );
         $this->db->trans_start();
         $this->db->insert('permission',$data2);
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['permission_id']=($transactionCode+1);
        $data['JobDescription']=$name;
        $data['jobcard_category']=$class;
        echo json_encode($data);
        die();
    }
    
    public function editUserPermission() {
         $transactionCode =$_POST['id'];
        $name =($_POST['name']);
         $class =$_POST['class'];
         $user =$_POST['user'];
         $isAllClass =isset($_POST['isAllClass']) ? 1 : 0;
         
         $data2 = array(
            'permission_id' => ($transactionCode),
            'permission_name' => $name,
            'permission_class' => $class,
            'permission_function' => $name,
            'per_user' => $user ,
            'isClass' => $isAllClass 
        );
        $this->db->trans_start();
        $this->db->update('permission',$data2,array('permission_id' =>$transactionCode));
        $this->db->trans_complete();
        $res2 = $this->db->trans_status();
        $data['fb']=$res2;
        $data['permission_id']=($transactionCode);
        echo json_encode($data);
        die();
    }
    
    public function deleteUserPermission() {
        $id =$_POST['id'];
        $res2 = $this->master_model->deleteTransType('permission',$id);
        $data['fb']=$res2;
        echo json_encode($data);
        die;
    }

    public function getFunctionsByClass() {
        
           $class = $_POST['class'];
            $this->data['function'] =$this->db->select('*')->where('class_no',$class)->get('class_function')->result(); 
            echo json_encode($this->data['function']);
            die;
    }
}