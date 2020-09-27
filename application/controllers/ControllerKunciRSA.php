<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerKunciRSA extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelKunciRSA');
    }
    

    public function getKunciRSA(){
        $id_pengguna = $this->uri->segment(4);
        
        $datapengguna = array('id_pengguna' => $id_pengguna);

        $kunci = $this->ModelKunciRSA->getKunciRSA($datapengguna);

        echo json_encode($kunci);
    }

}

/* End of file ControllerKunciRSA.php */
