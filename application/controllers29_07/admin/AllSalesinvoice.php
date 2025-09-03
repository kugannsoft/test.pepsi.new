<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AllSalesinvoice extends Admin_Controller {
	public function __construct() {
        parent::__construct();
        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Job_model');
        date_default_timezone_set("Asia/Colombo");

        $this->load->library('Datatables');

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
            /* Title Page */
            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'View Job Invoice';
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/Job/index');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->template->admin_render('admin/sales/all-sales-invoice', $this->data);
    }

    public function loadallinvoices() {
         $location = $_SESSION['location'];
        
        $this->datatables->select('jobinvoicehed.*,customer.CusName,customer.DisplayName');
        $this->datatables->from('jobinvoicehed')->join('customer','customer.CusCode=jobinvoicehed.JCustomer');
        echo $this->datatables->generate();
        die();
    }

    public function all_temp_invoices() {
            /* Title Page */
            $this->page_title->push('Temparary Invoices');
            $this->data['pagetitle'] = 'View Temparary Invoice';
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/Job/index');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->template->admin_render('admin/sales/all-temp-invoice', $this->data);
    }

    public function loadalltempinvoices() {
         $location = $_SESSION['location'];
        $this->datatables->select('tempjobinvoicehed.*,customer.CusName,customer.DisplayName');
        $this->datatables->from('tempjobinvoicehed')->join('customer','customer.CusCode=tempjobinvoicehed.JCustomer');
        echo $this->datatables->generate();
        die();
    }

}