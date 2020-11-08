<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ControllerKunciRSA extends RestController {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelKunciRSA');
    }
    

    public function getKunciRSA_get(){
        $id_pengguna = $this->uri->segment(4);
        
        $datapengguna = array('id_pengguna' => $id_pengguna);

        $kunci = $this->ModelKunciRSA->getKunciRSA($datapengguna);

        $datakuncirsa = array('kunci_rsa' => $kunci);

        $this->set_response(
            $datakuncirsa, 200
        );
    }

}

/* End of file ControllerKunciRSA.php */
