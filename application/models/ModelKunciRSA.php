<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class ModelKunciRSA extends CI_Model {

    public function generateKunciRSA($datakunci)
    {
        $query = $this->db->insert('tb_kunci_rsa', $datakunci);

        if($query){
            return true;
        }else {
            return false;
        }
    }

    public function getKunciRSA($datapengguna){
        $query = $this->db->get_where('tb_kunci_rsa', $datapengguna);

        return $query->result();
    }

    public function keluarpengguna($datapengguna){
        $query = $this->db->where($datapengguna);
        $query = $this->db->delete('tb_kunci_rsa');
        
        if ($query) {
            return true;
        } else {
            return false;
        }
        
    }

}

/* End of file ModelKunciRSA.php */
