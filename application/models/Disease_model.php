<?php

class Disease_model extends CI_model
{

    public function get($id = null)
    {

        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get("staff_disease");
            return $query->row_array();
        } else {
            $query = $this->db->where("is_active", "yes")->get("staff_disease");

            return $query->result_array();
        }
    }

    public function valid_disease()
    {
        $type = $this->input->post('type');
        $id   = $this->input->post('diseaseid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_disease_exists($type, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_disease_exists($name, $id)
    {
        if ($id != 0) {
            $data  = array('id != ' => $id, 'disease' => $name);
            $query = $this->db->where($data)->get('staff_disease');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->where('disease', $name);
            $query = $this->db->get('staff_disease');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deletedisease($id)
    {
        $this->db->where("id", $id)->delete("staff_disease");
    }

    public function adddisease($data)
    {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("staff_disease", $data);
        } else {
            $this->db->insert("staff_disease", $data);
        }
    }
}
