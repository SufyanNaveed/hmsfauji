<?php

class Rank_model extends CI_model
{

    public function get($id = null)
    {

        if (!empty($id)) {
            $query = $this->db->where("id", $id)->get("staff_rank");
            return $query->row_array();
        } else {
            $query = $this->db->where("is_active", "yes")->get("staff_rank");

            return $query->result_array();
        }
    }

    public function valid_rank()
    {
        $type = $this->input->post('type');
        $id   = $this->input->post('rankid');
        if (!isset($id)) {
            $id = 0;
        }
        if ($this->check_rank_exists($type, $id)) {
            $this->form_validation->set_message('check_exists', 'Record already exists');
            return false;
        } else {
            return true;
        }
    }

    public function check_rank_exists($name, $id)
    {
        if ($id != 0) {
            $data  = array('id != ' => $id, 'rank' => $name);
            $query = $this->db->where($data)->get('staff_rank');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->where('rank', $name);
            $query = $this->db->get('staff_rank');
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleterank($id)
    {
        $this->db->where("id", $id)->delete("staff_rank");
    }

    public function addrank($data)
    {
        if (isset($data["id"])) {
            $this->db->where("id", $data["id"])->update("staff_rank", $data);
        } else {
            $this->db->insert("staff_rank", $data);
        }
    }
}
