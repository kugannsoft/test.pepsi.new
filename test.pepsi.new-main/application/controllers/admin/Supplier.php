<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Customer_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'admin/customer');
         $this->page_title->push('Supplier');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('supplier/view_supplier', $this->data);
    }

    // public function allsuppliers() {
    //     $this->load->library('Datatables');
    //     $this->datatables->select('*');
    //     $this->datatables->from('supplier');
    //     echo $this->datatables->generate();
    //     die();
    // }

    public function allsuppliers() {
        $this->load->library('Datatables');
        $this->datatables->select('supplier.*,supplieroustanding.SupOustandingAmount');
        $this->datatables->from('supplier');
        $this->datatables->join('supplieroustanding','supplieroustanding.SupCode=supplier.SupCode');
        echo $this->datatables->generate();
        die();
    }

    public function loadmodal_addsupplier() {
        $this->data['title'] = $this->Customer_model->selecttitles();
        $this->data['locations'] = $this->Customer_model->selectlocations();
        $this->load->view('supplier/supplieradd_modal', $this->data);
    }

    public function loadmodal_editsupplier($supplier) {
        $this->data['supplier'] = $this->Customer_model->get_supplier($supplier);
        $this->data['title'] = $this->Customer_model->selecttitles();
        $this->data['locations'] = $this->Customer_model->selectlocations();
        $this->load->view('supplier/supplieredit_modal', $this->data);
    }

    public function view_supplier($id=null) {
        $this->breadcrumbs->unshift(1, lang('menu_addcustomer'), 'admin/supplier');
        $this->page_title->push('View Supplier');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['vdata'] = $this->Customer_model->selectVehicledata($id);
        $this->data['cusdata'] = $this->Customer_model->selectCustomerdata($id);
        $this->data['paytype'] = $this->Customer_model->loadpaytype();
        $this->load->view('customer/supplier', $this->data);
    }

    public function savesupplier() {
        $data['SupName'] = $_POST['supname'];
        $data['SupTitle'] = $_POST['respectSign'];
        $data['ContactPerson'] = $_POST['contactperson'];
        $data['Remark'] = $_POST['remark'];
        $data['Address01'] = $_POST['address1'];
        $data['Address02'] = $_POST['address2'];
        $data['Address03'] = $_POST['address3'];
        $data['MobileNo'] = $_POST['mobile'];
        $data['LanLineNo'] = $_POST['office'];
        $data['Fax'] = $_POST['fax'];
        $data['Email'] = $_POST['email'];
        $data['CreditPeriod'] = $_POST['creditperiod'];
        $data['IsActive'] = isset($_POST['isactive']) ? $_POST['isactive'] : NULL;
        $result = $this->Customer_model->insert_supplier($data);
        echo $result;
        die;
    }

    public function editsupplier($supplier) {
        $data['SupName'] = $_POST['supname'];
        $data['SupTitle'] = $_POST['respectSign'];
        $data['ContactPerson'] = $_POST['contactperson'];
        $data['Remark'] = $_POST['remark'];
        $data['Address01'] = $_POST['address1'];
        $data['Address02'] = $_POST['address2'];
        $data['Address03'] = $_POST['address3'];
        $data['MobileNo'] = $_POST['mobile'];
        $data['LanLineNo'] = $_POST['office'];
        $data['Fax'] = $_POST['fax'];
        $data['Email'] = $_POST['email'];
        $data['CreditPeriod'] = $_POST['creditperiod'];
        $data['IsActive'] = isset($_POST['isactive']) ? $_POST['isactive'] : NULL;
        $result = $this->Customer_model->update_supplier($data,$supplier);
        echo $result;
        die;
    }

}
