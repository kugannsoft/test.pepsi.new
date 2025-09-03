<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Customer_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'supplier/view_saleperson');
        $this->data['pagetitle'] = 'Employee';
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('saleperson/view_saleperson', $this->data);
    }

    public function employee() {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'supplier/view_saleperson');
        $this->data['pagetitle'] = 'Employee';
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('saleperson/view_saleperson', $this->data);
    }

    public function allsalespersons() {
        $this->load->library('Datatables');
        $this->datatables->select('*');
        $this->datatables->from('salespersons');
        $this->datatables->join('emp_type','emp_type.EmpTypeNo=salespersons.RepType');
        $this->datatables->join('skill_level','skill_level.skill_id=salespersons.Skill');
        echo $this->datatables->generate();
        die();
    }

    public function loadmodal_addsaleperson() {
        // $this->data['title'] = $this->Customer_model->selecttitles();
        $this->data['skill'] = $this->db->select('*')->from('skill_level')->get()->result();
        $this->data['type'] = $this->db->select('*')->from('emp_type')->get()->result();
        $this->data['locations'] = $this->Customer_model->selectlocations();
        $this->load->view('saleperson/salepersonadd_modal', $this->data);
    }

    public function loadmodal_editsaleperson($supplier) {
        $this->data['saleperson'] = $this->Customer_model->get_saleperson($supplier);
        $this->data['skill'] = $this->db->select('*')->from('skill_level')->get()->result();
        $this->data['type'] = $this->db->select('*')->from('emp_type')->get()->result();
        // $this->data['title'] = $this->Customer_model->selecttitles();
        $this->data['locations'] = $this->Customer_model->selectlocations();
        $this->load->view('saleperson/salepersonedit_modal', $this->data);
    }

   

    public function savesaleperson() {
        $data['RepName'] = $_POST['name'];
        // $data['RepImage'] = $_POST['image'];
        $data['Remark'] = $_POST['remark'];
        $data['EmpNo'] = $_POST['empno'];
        $data['ContactNo'] = $_POST['mobile'];
        $data['RepType'] = $_POST['emp_type'];
        $data['Skill'] = $_POST['skill'];
        $data['LocationCode'] = $_POST['location'];
        $data['Email'] = $_POST['email'];
        $data['IsSalesPerson'] = isset($_POST['issale']) ? $_POST['issale'] : 0;
        $data['IsTec'] = isset($_POST['istec']) ? $_POST['istec'] : 0;
        $data['IsAccount'] = isset($_POST['isacc']) ? $_POST['isacc'] : 0;
        $data['IsActive'] = isset($_POST['isactive']) ? $_POST['isactive'] : 0;
        $result = $this->Customer_model->insert_saleperson($data);
        echo $result;
        die;
    }

    public function editsaleperson($supplier) {
        $data['RepID'] = $_POST['rep_id'];
        $data['RepName'] = $_POST['name'];
         $data['Skill'] = $_POST['skill'];
        // $data['RepImage'] = $_POST['image'];
        $data['Remark'] = $_POST['remark'];
         $data['Skill'] = $_POST['skill'];
        $data['EmpNo'] = $_POST['empno'];
        $data['ContactNo'] = $_POST['mobile'];
        $data['LocationCode'] = $_POST['location'];
        $data['Email'] = $_POST['email'];
       $data['IsSalesPerson'] = isset($_POST['issale']) ? $_POST['issale'] : 0;
        $data['IsTec'] = isset($_POST['istec']) ? $_POST['istec'] : 0;
        $data['IsAccount'] = isset($_POST['isacc']) ? $_POST['isacc'] : 0;
        $data['IsActive'] = isset($_POST['isactive']) ? $_POST['isactive'] : 0;
        $data['RepType'] = $_POST['emp_type'];
        $result = $this->Customer_model->update_saleperson($data,$supplier);
        echo $result;
        die;
    }

    public function loadmodal_routeconfig($supplier) {
        $this->data['routes'] = $this->db->select('*')->from('customer_routes')->get()->result();
        $this->data['employee_id'] = $supplier;
        $this->data['saved_routes'] = $this->db->select('sr.id as id, cr.name as name')
        ->from('employeeroutes sr')
        ->join('customer_routes cr', 'sr.route_id = cr.id')
        ->where('sr.emp_id', $supplier)
        ->get()->result();
        // $response = [  
        //     'data' => $result
        // ];
        // echo json_encode($response);
        //die; 
        $this->load->view('saleperson/salepersonaddroute_modal', $this->data);
    }

    public function save_route() {
        $emp_id = $this->input->post('emp_id');
        $route_id = $this->input->post('route_id');
        
        $this->db->where('emp_id', $emp_id);
        $this->db->where('route_id', $route_id);
        $existing_route = $this->db->get('employeeroutes')->row();
        
        if ($existing_route) {
            $this->session->set_flashdata('error', 'This route is already assigned to the employee.');
            redirect('admin/sales/');
        } else {
            $data = [
                'emp_id' => $emp_id,
                'route_id' => $route_id
            ];
            
            $this->db->insert('employeeroutes', $data);
            $this->session->set_flashdata('success', 'Route assigned successfully.');
            redirect('admin/sales/'); 
        }
    }
    

    public function delete_route($route_id) {
      
        $this->db->where('id', $route_id);
        
        if ($this->db->delete('employeeroutes')) {
            $this->session->set_flashdata('message', 'Route deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete route.');
        }
        redirect('admin/sales/');
    }
    
    public function findroutecustomer() {
        $routeID = $this->input->post('routeID');
    
        $this->load->database();
    
        $this->db->select('c.CusCode, c.CusName');
        $this->db->from('customer c'); 
        $this->db->where('c.RouteId', $routeID);  
        $query = $this->db->get();
    
        $customers = [];
    
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $customers[] = [
                    'CusCode' => $row->CusCode,
                    'CusName' => $row->CusName
                ];
            }
    
            echo json_encode($customers);
        } else {
            echo json_encode([]);
        }
    
        exit();
    }
    
   

}
