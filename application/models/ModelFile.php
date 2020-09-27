<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ModelFile extends CI_Model {

    public function uploadfile($datafile)
    {
        $query = $this->db->insert('tb_file', $datafile);

        if($query){
            return true;
        }else {
            return false;
        }
        
    }

    public function deletefile($datafile)
    {
        $query = $this->db->where($datafile);
        $query = $this->db->delete('tb_file');

        if($this->db->affected_rows()){
            return true;
        }else {
            return false;
        }
        
    }

    public function getfile($datapengguna)
    {
        $query = $this->db->get_where('tb_file', $datapengguna);

        return $query->result();
    }

    public function downloadfile($datafile)
    {
        $query = $this->db->get_where('tb_file', $datafile);

        return $query->result();
    }

}

/* End of file ModelFile.php */
