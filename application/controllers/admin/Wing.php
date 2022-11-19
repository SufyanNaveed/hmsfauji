<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Wing extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('file');
        $this->config->load("payroll");
        $this->load->model('wing_model');
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');
        $wing = $this->wing_model->get();
        $data["title"]       = "Add wing";
        $data["wing"] = $wing;
        $this->form_validation->set_rules( 'type', 'wing Name', array('required', array('check_exists', array($this->wing_model, 'valid_wing')),));
        if ($this->form_validation->run()) {
            $type          = $this->input->post("type");
            $wingid = $this->input->post("wingid");
            $status        = $this->input->post("status");
            if (empty($wingid)) {
                if (!$this->rbac->hasPrivilege('wing', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('wing', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($wingid)) {
                $data = array('wing' => $type, 'is_active' => 'yes', 'id' => $wingid);
            } else {

                $data = array('wing' => $type, 'is_active' => 'yes');
            }
            $insert_id = $this->wing_model->addwing($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/wing");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/staff/wing", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->wing_model, 'valid_wing')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $type      = $this->input->post("type");
            $data      = array('wing' => $type, 'is_active' => 'yes');
            $insert_id = $this->wing_model->addwing($data);
            $array     = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function edit()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->wing_model, 'valid_wing')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id   = $this->input->post('wingid');
            $type = $this->input->post("type");
            $data = array('wing' => $type, 'is_active' => 'yes', 'id' => $id);
            $this->wing_model->addwing($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    public function wingdelete($id)
    {
        $this->wing_model->deletewing($id);
    }

    public function get_data($id)
    {
        $result = $this->wing_model->get($id);
        echo json_encode($result);
    }

}
