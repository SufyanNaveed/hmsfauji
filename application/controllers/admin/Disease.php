<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Disease extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('file');
        $this->config->load("payroll");
        $this->load->model('disease_model');
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');
        $disease = $this->disease_model->get();
        $data["title"]       = "Add disease";
        $data["disease"] = $disease;
        $this->form_validation->set_rules( 'type', 'disease Name', array('required', array('check_exists', array($this->disease_model, 'valid_disease')),));
        if ($this->form_validation->run()) {
            $type          = $this->input->post("type");
            $diseaseid = $this->input->post("diseaseid");
            $status        = $this->input->post("status");
            if (empty($diseaseid)) {
                if (!$this->rbac->hasPrivilege('disease', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('disease', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($diseaseid)) {
                $data = array('disease' => $type, 'is_active' => 'yes', 'id' => $diseaseid);
            } else {

                $data = array('disease' => $type, 'is_active' => 'yes');
            }
            $insert_id = $this->disease_model->adddisease($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/disease");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/staff/disease", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->disease_model, 'valid_disease')),
            )
        );

        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
        $type      = $this->input->post("type");
            $data      = array('disease' => $type, 'is_active' => 'yes');
            $insert_id = $this->disease_model->adddisease($data);
            $array     = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function edit()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->disease_model, 'valid_disease')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id   = $this->input->post('diseaseid');
            $type = $this->input->post("type");
            $data = array('disease' => $type, 'is_active' => 'yes', 'id' => $id);
            $this->disease_model->adddisease($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    public function diseasedelete($id)
    {
        $this->disease_model->deletedisease($id);
    }

    public function get_data($id)
    {
        $result = $this->disease_model->get($id);
        echo json_encode($result);
    }

}
