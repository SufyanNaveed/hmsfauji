<?php

class Unit_model extends CI_model
{

    public function get($id = null)
    {

        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get("staff_unit");
            return $query->row_array();
        } else {
            $query = $this->db->where("is_active", "yes")->get("staff_unit");

            return $query->result_array();
        }
    }

    public function valid_unit()
    {
        $type = $this->input->post('type');
        $id   = $this->input->post('unitid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_unit_exists($type, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_unit_exists($name, $id)
    {
        if ($id != 0) {
            $data  = array('id != ' => $id, 'unit' => $name);
            $query = $this->db->where($data)->get('staff_unit');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->where('unit', $name);
            $query = $this->db->get('staff_unit');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteunit($id)
    {
        $this->db->where("id", $id)->delete("staff_unit");
    }

    public function addunit($data)
    {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("staff_unit", $data);
        } else {
            $this->db->insert("staff_unit", $data);
        }
    }
}
