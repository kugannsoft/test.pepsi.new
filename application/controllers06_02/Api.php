<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth'));
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
        echo 'asasd';
    }

    public function getSubDepByDep() {

//        $dep = $_POST['dep'];
        echo "kushan";
//            $this->data['subdepartment'] = $this->master_model->getSubDepByDep('subdepartment',$dep);
//            echo json_encode($this->data);
//        echo ($dep);
    }

}
