<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

        /* COMMON :: ADMIN & PUBLIC */
        /* Load */
        $this->load->database();
        $this->load->config('common/dp_config');
        $this->load->config('common/dp_language');
        $this->load->library(array('form_validation', 'ion_auth', 'template', 'common/mobile_detect'));
        $this->load->helper(array('array', 'language', 'url'));
        $this->load->model('common/prefs_model');

        /* Data */
        $this->data['lang']           = element($this->config->item('language'), $this->config->item('language_abbr'));
        $this->data['charset']        = $this->config->item('charset');
        $this->data['frameworks_dir'] = $this->config->item('frameworks_dir');
        $this->data['plugins_dir']    = $this->config->item('plugins_dir');
        $this->data['avatar_dir']     = $this->config->item('avatar_dir');

        /* Any mobile device (phones or tablets) */
        if ($this->mobile_detect->isMobile())
        {
            $this->data['mobile'] = TRUE;

            if ($this->mobile_detect->isiOS()){
                $this->data['ios']     = TRUE;
                $this->data['android'] = FALSE;
            }
            else if ($this->mobile_detect->isAndroidOS())
            {
                $this->data['ios']     = FALSE;
                $this->data['android'] = TRUE;
            }
            else
            {
                $this->data['ios']     = FALSE;
                $this->data['android'] = FALSE;
            }

            if ($this->mobile_detect->getBrowsers('IE')){
                $this->data['mobile_ie'] = TRUE;
            }
            else
            {
                $this->data['mobile_ie'] = FALSE;
            }
        }
        else
        {
            $this->data['mobile']    = FALSE;
            $this->data['ios']       = FALSE;
            $this->data['android']   = FALSE;
            $this->data['mobile_ie'] = FALSE;
        }
	}
}


class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ( ! $this->ion_auth->logged_in() )
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Load */
            $this->load->config('admin/dp_config');
            $this->load->library('admin/page_title');
            $this->load->library('admin/breadcrumbs');
            $this->load->model('admin/core_model');
            $this->load->helper('menu');
            $this->lang->load(array('admin/main_header', 'admin/main_sidebar', 'admin/footer', 'admin/actions'));

            /* Load library function  */
            $this->breadcrumbs->unshift(0, $this->lang->line('menu_dashboard'), 'admin/dashboard');

            /* Data */
            $this->data['title']       = $this->config->item('title');
            $this->data['title_lg']    = $this->config->item('title_lg');
            $this->data['title_mini']  = $this->config->item('title_mini');
            $this->data['admin_prefs'] = $this->prefs_model->admin_prefs();
            $this->data['active_trans'] = $this->prefs_model->getActiveTranserOutByto();
            $this->data['trans_noti'] = $this->prefs_model->getCountActiveTranserOut();
            
            $this->data['active_part_request'] = $this->prefs_model->getActivePartRequest();
            $this->data['part_noti'] = $this->prefs_model->getActivePartRequestCount();
            $this->data['active_part_issue'] = $this->prefs_model->getActivePartIssuedRequest();
            $this->data['part_issue_noti'] = $this->prefs_model->getActivePartIssuedRequestCount();
            $this->data['user_login']  = $this->prefs_model->user_info_login($this->ion_auth->user()->row()->id);

            if ($this->router->fetch_class() == 'dashboard')
            {
                $this->data['dashboard_alert_file_install'] = $this->core_model->get_file_install();
                $this->data['header_alert_file_install']    = NULL;
            }
            else
            {
                $this->data['dashboard_alert_file_install'] = NULL;
                $this->data['header_alert_file_install']    = NULL; /* << A MODIFIER !!! */
            }

            //check user permission
            $this->load->helper('url');

            $con = $this->router->fetch_class();
            $fun = $this->router->fetch_method();
            // $this->load->model('admin/Permission_model');
            // get block class
            $block_class = $this->prefs_model->getBlockClassByUser1($con, $_SESSION['user_id']);
            //get block functions
            $block_function = $this->prefs_model->getBlockFunctionByClassAndUser1($con, $_SESSION['user_id']);
            $this->data['bclass']       = $this->prefs_model->getBlockClassByUser1($con, $_SESSION['user_id']);
            $this->data['block_function']       = $this->prefs_model->getBlockFunctionByUser1($_SESSION['user_id']);
            $this->data['block_class']       = $this->prefs_model->getAllBlockClassByUser1($_SESSION['user_id']);
            

            // print_r($block_function);die;
// $this->data['block_function']       = 'gfgf';

//            if( !empty($block_class) && in_array($con, $block_class) ){
//                // $this->load->library('user_agent');
//                // redirect($this->agent->referrer());
//                redirect('admin/dashboard/no_access', 'refresh');
//            }else{
//                if(!empty($block_function) && in_array($fun, $block_function) ){
//                    // $this->load->library('user_agent');
//                    // redirect($this->agent->referrer());
//                    redirect('admin/dashboard/no_access', 'refresh');
//                }else{
//
//                }
//            }
            
            /*Start By Asanka 2020-09-08 - This functions for permission VIEW, ADD, EDIT or DELETE  */

            $this->data['blockView'] = $this->prefs_model->getBlockForView($_SESSION['role']);
            $this->data['blockAdd'] = $this->prefs_model->getBlockForAdd($_SESSION['role']);
            $this->data['blockEdit'] = $this->prefs_model->getBlockForEdit($_SESSION['role']);
            $this->data['blockDelete'] = $this->prefs_model->getBlockForDelete($_SESSION['role']);

            /*End By Asanka*/            
        }
    }
}


class Public_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->data['admin_link'] = TRUE;
        }
        else
        {
            $this->data['admin_link'] = FALSE;
        }

        if ($this->ion_auth->logged_in())
        {
            $this->data['logout_link'] = TRUE;
        }
        else
        {
            $this->data['logout_link'] = FALSE;
        }
	}
}
