<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ModelPengguna extends CI_Model
{

    public function daftarpengguna($datapengguna)
    {
        $query = $this->db->insert('tb_pengguna', $datapengguna);

        $this->db->db_debug = false;

        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public function masukpengguna($datapengguna)
    {
        $query = $this->db->get_where('tb_pengguna', $datapengguna);

        if ($query->num_rows() != 1) {
            return false;
        } else {
            return true;
        }
    }

    public function getpengguna($datapengguna)
    {
        $query = $this->db->select('id_pengguna, email_pengguna, nama_pengguna');
        $query = $this->db->from('tb_pengguna');
        $query = $this->db->where($datapengguna);
        $query = $this->db->get();
        return $query->result();
    }

    public function getpasswordlamapengguna($datapengguna){
        $query = $this->db->select('password_pengguna');
        $query = $this->db->from('tb_pengguna');
        $query = $this->db->where($datapengguna);
        $query = $this->db->get();
        return $query->result();
    }

    public function gantipasswordpengguna($datapengguna, $passwordpengguna){
        $query = $this->db->where($datapengguna);
        $query = $this->db->update('tb_pengguna', $passwordpengguna);

        $this->db->db_debug = false;

        if (!$query) {
            return false;
        } else {
            return true;
        }
    }

    public function keluarpengguna($datapengguna)
    {
        
    }
}

/* End of file ModelPengguna.php */
