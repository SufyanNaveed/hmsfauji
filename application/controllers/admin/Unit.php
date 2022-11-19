<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Unit extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('file');
        $this->config->load("payroll");
        $this->load->model('unit_model');
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');
        $unit = $this->unit_model->get();
        $data["title"]       = "Add unit";
        $data["unit"] = $unit;
        $this->form_validation->set_rules( 'type', 'unit Name', array('required', array('check_exists', array($this->unit_model, 'valid_unit')),));
        if ($this->form_validation->run()) {
            $type          = $this->input->post("type");
            $unitid = $this->input->post("unitid");
            $status        = $this->input->post("status");
            if (empty($unitid)) {
                if (!$this->rbac->hasPrivilege('unit', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('unit', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($unitid)) {
                $data = array('unit' => $type, 'is_active' => 'yes', 'id' => $unitid);
            } else {

                $data = array('unit' => $type, 'is_active' => 'yes');
            }
            $insert_id = $this->unit_model->addunit($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/unit");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/staff/unit", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->unit_model, 'valid_unit')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $type      = $this->input->post("type");
            $data      = array('unit' => $type, 'is_active' => 'yes');
            $insert_id = $this->unit_model->addunit($data);
            $array     = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function edit()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->unit_model, 'valid_unit')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id   = $this->input->post('unitid');
            $type = $this->input->post("type");
            $data = array('unit' => $type, 'is_active' => 'yes', 'id' => $id);
            $this->unit_model->addunit($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    public function unitdelete($id)
    {
        $this->unit_model->deleteunit($id);
    }

    public function get_data($id)
    {
        $result = $this->unit_model->get($id);
        echo json_encode($result);
    }

}
