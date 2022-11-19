<?php

class Wing_model extends CI_model
{

    public function get($id = null)
    {

        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get("staff_wing");
            return $query->row_array();
        } else {
            $query = $this->db->where("is_active", "yes")->get("staff_wing");

            return $query->result_array();
        }
    }

    public function valid_wing()
    {
        $type = $this->input->post('type');
        $id   = $this->input->post('wingid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_wing_exists($type, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_wing_exists($name, $id)
    {
        if ($id != 0) {
            $data  = array('id != ' => $id, 'wing' => $name);
            $query = $this->db->where($data)->get('staff_wing');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->where('wing', $name);
            $query = $this->db->get('staff_wing');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deletewing($id)
    {
        $this->db->where("id", $id)->delete("staff_wing");
    }

    public function addwing($data)
    {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("staff_wing", $data);
        } else {
            $this->db->insert("staff_wing", $data);
        }
    }
}
