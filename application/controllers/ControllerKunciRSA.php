<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ControllerKunciRSA extends RestController
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelKunciRSA');
    }


    public function getKunciRSA_get()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_pengguna = $this->uri->segment(4);

            $datapengguna = array('id_pengguna' => $id_pengguna);

            $kunci = $this->ModelKunciRSA->getKunciRSA($datapengguna);

            $datakuncirsa = array('kunci_rsa' => $kunci);

            $this->set_response(
                $datakuncirsa,
                200
            );
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Token Tidak Valid'
            );

            $this->set_response(
                $keterangan,
                401
            );
        }
    }
}

/* End of file ControllerKunciRSA.php */
