<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() ) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users'] = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups'] = $this->dashboard_model->get_count_record('groups');

            /* Load Template */
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
    }

    public function no_access() {
        if (!$this->ion_auth->logged_in() ) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users'] = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups'] = $this->dashboard_model->get_count_record('groups');

            /* Load Template */
            $this->template->admin_render('admin/dashboard/500', $this->data);
        }
    }

}
