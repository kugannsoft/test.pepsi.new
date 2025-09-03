<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_update extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Report_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function dailyupdatetock() {
        $this->data['summery'] = $this->Report_model->dailyreportupdateuserdata();
        $this->data['user'] = $this->ion_auth->user()->row();
        $this->data['pagetitle'] = 'Daily Update Stock';
        $this->data['breadcrumb'] = '';
        $this->data['result'] = '';

        $this->data['lastupdate'] = $this->Report_model->laststockreportdate();

        $dateb = new DateTime($this->data['lastupdate']);
        $dateb->modify('+1 day');
        $this->data['nextdate'] = $dateb->format('Y-m-d');

        $this->data['date'] = $this->input->post('stockdate');
        if ($this->data['date'] && $this->data['date'] != '') {
            $this->data['result'] = $this->Report_model->dailyreportupdate($this->data['date'], $this->data['user']->first_name);
        }
        $this->template->admin_render('admin/report/dailyupdatereport', $this->data);
    }

}
