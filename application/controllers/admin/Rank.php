<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Rank extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('file');
        $this->config->load("payroll");
        $this->load->model('rank_model');
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'setup');
        $this->session->set_userdata('sub_menu', 'hr/index');
        $rank = $this->rank_model->get();
        $data["title"]       = "Add rank";
        $data["rank"] = $rank;
        $this->form_validation->set_rules( 'type', 'rank Name', array('required', array('check_exists', array($this->rank_model, 'valid_rank')),));
        if ($this->form_validation->run()) {
            $type          = $this->input->post("type");
            $rankid = $this->input->post("rankid");
            $status        = $this->input->post("status");
            if (empty($rankid)) {
                if (!$this->rbac->hasPrivilege('rank', 'can_add')) {
                    access_denied();
                }
            } else {
                if (!$this->rbac->hasPrivilege('rank', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($rankid)) {
                $data = array('rank' => $type, 'is_active' => 'yes', 'id' => $rankid);
            } else {

                $data = array('rank' => $type, 'is_active' => 'yes');
            }
            $insert_id = $this->rank_model->addrank($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/rank");
        } else {
            $this->load->view("layout/header");
            $this->load->view("admin/staff/rank", $data);
            $this->load->view("layout/footer");
        }
    }

    public function add()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->rank_model, 'valid_rank')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $type      = $this->input->post("type");
            $data      = array('rank' => $type, 'is_active' => 'yes');
            $insert_id = $this->rank_model->addrank($data);
            $array     = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function edit()
    {
        $this->form_validation->set_rules(
            'type', $this->lang->line('name'), array('required',
                array('check_exists', array($this->rank_model, 'valid_rank')),
            )
        );
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name' => form_error('type'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $id   = $this->input->post('rankid');
            $type = $this->input->post("type");
            $data = array('rank' => $type, 'is_active' => 'yes', 'id' => $id);
            $this->rank_model->addrank($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }
        echo json_encode($array);
    }

    public function rankdelete($id)
    {
        $this->rank_model->deleterank($id);
    }

    public function get_data($id)
    {
        $result = $this->rank_model->get($id);
        echo json_encode($result);
    }

}
