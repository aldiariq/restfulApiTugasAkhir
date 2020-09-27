<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ControllerPengguna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelPengguna');
        $this->load->model('ModelKunciRSA');
    }

    public function daftarpengguna()
    {
        $emailpengguna = $this->input->post('email');
        $nohppengguna = $this->input->post('nohp');
        $passwordpengguna = md5($this->input->post('password'));

        $datapengguna = array(
            'email_pengguna' => $emailpengguna,
            'nohp_pengguna' => $nohppengguna,
            'password_pengguna' => $passwordpengguna
        );

        if ($this->ModelPengguna->daftarpengguna($datapengguna)) {

            $kunciprivate = $this->input->post('kunciprivate');
            $kuncipublic = $this->input->post('kuncipublic');

            $datapenggunadaftar = $this->ModelPengguna->getpengguna($datapengguna);

            foreach ($datapenggunadaftar as $data) {
                $datakunci = array(
                    'id_pengguna' => $data->id_pengguna,
                    'kunci_private' => $kunciprivate,
                    'kunci_public' => $kuncipublic
                );
            }

            $generatekunci = $this->ModelKunciRSA->generateKunciRSA($datakunci);

            if ($generatekunci) {
                $keterangan = array(
                    'berhasil' => true,
                    'pesan' => 'Berhasil Mendaftarkan Pengguna'
                );

                echo json_encode($keterangan);
            }else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mendaftarkan Pengguna'
                );
    
                echo json_encode($keterangan);
            }
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Mendaftarkan Pengguna'
            );

            echo json_encode($keterangan);
        }
    }

    public function masukpengguna()
    {
        $emailpengguna = $this->input->post('email');
        $passwordpengguna = $this->input->post('password');

        $datapengguna = array(
            'email_pengguna' => $emailpengguna,
            'password_pengguna' => md5($passwordpengguna)
        );

        if ($this->ModelPengguna->masukpengguna($datapengguna)) {
            $keterangan = array(
                'berhasil' => true,
                'pesan' => 'Berhasil Masuk',
                'pengguna' => $this->ModelPengguna->getpengguna($datapengguna)
            );

            echo json_encode($keterangan);
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Masuk'
            );

            echo json_encode($keterangan);
        }
    }

    public function keluarpengguna(){
        $id_pengguna = $this->uri->segment(3);

        $datapengguna = array('id_pengguna' => $id_pengguna);

        if($this->ModelPengguna->keluarpengguna($datapengguna)){
            $keterangan = array(
                'berhasil' => true,
                'pesan' => 'Berhasil Keluar'
            );

            echo json_encode($keterangan);
        }else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Keluar'
            );

            echo json_encode($keterangan);
        }
    }
}

/* End of file ControllerPengguna.php */
