<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SetPermission extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/SetPermission_model');
        date_default_timezone_set("Asia/Colombo");

//        $this->load->library('Datatables');

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index()
    {
        /* Title Page */
        $this->page_title->push('Role Permission');
        $this->data['pagetitle'] = 'Add Permission';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Role Permission', 'admin/SetPermission/index');
        $this->breadcrumbs->unshift(1, 'Add Role Permission', 'admin/SetPermission/index');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['role'] = $this->db->select('*')->from('role')->get()->result();
        $this->data['module'] = $this->db->select('*')->from('system_module')->get()->result();


        $result = $this->db->select('system_permission_define.*, system_module.moduleName AS Description')
            ->from('system_permission_define')
            ->join('system_module', 'system_module.id = system_permission_define.module_id', 'INNER')
            ->order_by('system_module.id', 'ASC')
            ->order_by('system_permission_define.id', 'ASC')
            ->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }

        $this->data['per_data']=$list;

        $this->template->admin_render('admin/permission/set_permission', $this->data);
    }
    public function loadPermission(){
        $roleid=$_POST['roleid'];
        $data['permission_data']=$this->db->select()->from('system_permission_set')->where('role_id', $roleid)->get()->result();
        //var_dump($data['permission_data'][0]['per_code']);
        echo json_encode($data);
        die();
        
    }

    public function savePermission()
    {
        $roleId = $_POST['user'];

        foreach ($_POST['class'] as $first_value_1 => $tmpArray_1) {   

                    $module=$_POST['module'][$first_value_1];
                    //view
                    if (isset($_POST['chk_view'][$first_value_1])) {
                        $view=$_POST['chk_view'][$first_value_1];
                    }
                    else{
                        $view=0;
                    }

                    //add
                    if (isset($_POST['chk_add'][$first_value_1])) {
                        $add=$_POST['chk_add'][$first_value_1];
                    }
                    else{
                        $add=0;
                    }

                    //edit
                    if (isset($_POST['chk_edit'][$first_value_1])) {
                        $edit=$_POST['chk_edit'][$first_value_1];
                    }
                    else{
                        $edit=0;
                    }
                    
                    //delete
                    if (isset($_POST['chk_delete'][$first_value_1])) {
                        $delete=$_POST['chk_delete'][$first_value_1];
                    }else{
                        $delete=0;
                    }
                  
                    $checkpermission = $this->SetPermission_model->where_permssion($roleId, $first_value_1);

                    $insertData = array(
                        'role_id' => $roleId,
                        'per_class' => $tmpArray_1,
                        'per_code' => $first_value_1,
                        'module_id'=>$module,
                        'is_view' => $view,
                        'is_add' => $add,
                        'is_edit' => $edit,
                        'is_delete' => $delete
                    );

                    $deleteData = array(
                        'role_id' => $roleId,
                        'per_code' => $first_value_1
                    );

                    if ($checkpermission == null) {

                        $insertd=$this->SetPermission_model->insert_data('system_permission_set', $insertData);
                        

                    } else {
                        $data = array(
                        'is_view' => $view,
                        'is_add' => $add,
                        'is_edit' => $edit,
                        'is_delete' => $delete
                    );
                        $this->db->where('role_id', $roleId);
                        $this->db->where('per_code', $first_value_1);
                        $updated=$this->db->update('system_permission_set', $data);
                        
                    }             
        }
        if (isset($insertd)) {
            if ($insertd==true) {
            echo "1";
         }
        }
        if (isset($updated)) {
           if ($updated==true) {
            echo "2";
            }
        }

        
        die();
    }
    public function CheckPermissionview()
    {
        //user
        $user= $this->ion_auth->user()->row();
        $userrole=$user->role;
        $per_code='SM12';
        $query=$this->SetPermission_model->CheckPermissionview($userrole,$per_code);
        
    }
    
     public function role()
    {
        /* Title Page */
        $this->page_title->push('Role Permission');
        $this->data['pagetitle'] = 'Add role';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Role Permission', 'admin/SetPermission/index');
        $this->breadcrumbs->unshift(1, 'Add Role', 'admin/SetPermission/index');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['role'] = $this->db->select('*')->from('role')->get()->result();

        $this->template->admin_render('admin/permission/role', $this->data);

    }

    public function roleCreate()
    {
//var_dump($_POST);die();
        $insertData = array(
            'role' => $_POST['role'],
            'role_description' => $_POST['description'],
        );
        $this->SetPermission_model->insert_data('role', $insertData);
    }

    public function roleEdit()
    {
        $id = $_POST['id'];
        $checkJob = $this->SetPermission_model->editRoles($id);
        $data = json_encode($checkJob);
        header('Content-Type: application/json');
        echo $data;
    }
}