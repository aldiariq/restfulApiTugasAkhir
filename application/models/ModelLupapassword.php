<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelLupapassword extends CI_Model {

    public function tambahlupapassword($datalupapassword)
    {
        $query = $this->db->insert('tb_lupa_password', $datalupapassword);

        $this->db->db_debug = false;

        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public function ceklupapassword($wherelupapassword)
    {
        $query = $this->db->get_where('tb_lupa_password', $wherelupapassword);

        return $query->result();
    }

    public function hapuslupapassword($wherelupapassword)
    {
        $query = $this->db->where($wherelupapassword);
        $query = $this->db->delete('tb_lupa_password');

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file ModelKonfirmasipendaftaran.php */
