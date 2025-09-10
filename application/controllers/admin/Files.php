<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_files'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_files'), 'admin/files');
    }

    public function backup() {
        // Load the DB utility class
        $this->load->dbutil();
        $prefs = array(
                'tables'        => array(),   // Array of tables to backup.
                'ignore'        => array(),                     // List of tables to omit from the backup
                'format'        => 'zip',                       // gzip, zip, txt
                'filename'      => '',              // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
                'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
                'newline'       => "\n"                         // Newline character used in backup file
        );
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('admin/files/mybackup.zip', $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('mybackup.zip', $backup);
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['error'] = NULL;

            /* Load Template */
            $this->template->admin_render('admin/files/index', $this->data);
        }
    }

    public function do_upload() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Conf */
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2048;
            $config['max_width'] = 1024;
            $config['max_height'] = 1024;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(2, lang('menu_files'), 'admin/files');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            if (!$this->upload->do_upload('userfile')) {
                /* Data */
                $this->data['error'] = $this->upload->display_errors();

                /* Load Template */
                $this->template->admin_render('admin/files/index', $this->data);
            } else {
                /* Data */
                $this->data['upload_data'] = $this->upload->data();

                /* Load Template */
                $this->template->admin_render('admin/files/upload', $this->data);
            }
        }
    }

}
