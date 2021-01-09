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

    public function generateKunciRSA_post(){
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $idpengguna = $this->input->post('idpengguna');
            $kuncipublic = $this->input->post('kuncipublic');
            $kuncimodulus = $this->input->post('kuncimodulus');

            $datakunci = array(
                'id_pengguna' => $idpengguna,
                'kunci_public' => $kuncipublic,
                'kunci_modulus' => $kuncimodulus
            );

            $generatekunci = $this->ModelKunciRSA->generateKunciRSA($datakunci);

            if ($generatekunci) {
                $keterangan = array(
                    'berhasil' => true,
                    'pesan' => 'Berhasil Menyimpan Kunci'
                );

                $this->set_response(
                    $keterangan,
                    200
                );
            } else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Menyimpan Kunci'
                );

                $this->set_response(
                    $keterangan,
                    401
                );
            }
        }else {
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
