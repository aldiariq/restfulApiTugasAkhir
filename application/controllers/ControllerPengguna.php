<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ControllerPengguna extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelPengguna');
        $this->load->model('ModelKunciRSA');
    }

    public function daftarpengguna_post()
    {
        $emailpengguna = $this->input->post('email');
        $namapengguna = $this->input->post('nama');
        $passwordpengguna = md5($this->input->post('password'));

        $datapengguna = array(
            'email_pengguna' => $emailpengguna,
            'nama_pengguna' => $namapengguna,
            'password_pengguna' => $passwordpengguna
        );

        if ($this->ModelPengguna->daftarpengguna($datapengguna)) {

            $kunciprivate = $this->input->post('kunciprivate');
            $kuncipublic = $this->input->post('kuncipublic');
            $kuncimodulus = $this->input->post('kuncimodulus');

            $datapenggunadaftar = $this->ModelPengguna->getpengguna($datapengguna);

            foreach ($datapenggunadaftar as $data) {
                $datakunci = array(
                    'id_pengguna' => $data->id_pengguna,
                    'kunci_private' => $kunciprivate,
                    'kunci_public' => $kuncipublic,
                    'kunci_modulus' => $kuncimodulus
                );
            }

            $generatekunci = $this->ModelKunciRSA->generateKunciRSA($datakunci);

            if ($generatekunci) {
                $keterangan = array(
                    'berhasil' => true,
                    'pesan' => 'Berhasil Mendaftarkan Pengguna'
                );

                $this->set_response(
                    $keterangan, 200
                );
            }else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mendaftarkan Pengguna'
                );
    
                $this->set_response(
                    $keterangan, 401
                );
            }
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Mendaftarkan Pengguna'
            );

            $this->set_response(
                $keterangan, 401
            );
        }
    }

    public function masukpengguna_post()
    {
        $emailpengguna = $this->input->post('email');
        $passwordpengguna = $this->input->post('password');

        $datapengguna = array(
            'email_pengguna' => $emailpengguna,
            'password_pengguna' => md5($passwordpengguna)
        );

        if ($this->ModelPengguna->masukpengguna($datapengguna)) {
            foreach ($this->ModelPengguna->getpengguna($datapengguna) as $data) {
                $datatoken = array(
                    'id' => $data->id_pengguna,
                    'email_pengguna' => $data->email_pengguna,
                    'time' => time()
                );
            }

            $tokenpengguna = $this->authorizationtoken->generateToken($datatoken);

            $keterangan = array(
                'berhasil' => true,
                'pesan' => 'Berhasil Masuk',
                'token' => $tokenpengguna,
                'pengguna' => $this->ModelPengguna->getpengguna($datapengguna)
            );

            $this->set_response(
                $keterangan, 200
            );
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Masuk'
            );

            $this->set_response(
                $keterangan, 401
            );
        }
    }

    public function gantipasswordpengguna_post(){
        $id_pengguna = $this->input->post("id_pengguna");

        $datapengguna = array('id_pengguna' => $id_pengguna);

        foreach ($this->ModelPengguna->getpasswordlamapengguna($datapengguna) as $password) {
            $password_lama = md5($this->input->post("password_lama"));
            $password_baru = md5($this->input->post("password_baru"));
            if($password_lama == $password->password_pengguna){
                $datapassword = array('password_pengguna' => $password_baru);

                $gantipassword = $this->ModelPengguna->gantipasswordpengguna($datapengguna, $datapassword);

                if($gantipassword){
                    $keterangan = array(
                        'berhasil' => true,
                        'pesan' => 'Berhasil Mengganti Password'
                    );

                    $this->set_response(
                        $keterangan, 200
                    );
                }else {
                    $keterangan = array(
                        'berhasil' => false,
                        'pesan' => 'Gagal Mengganti Password'
                    );

                    $this->set_response(
                        $keterangan, 401
                    );
                }
            }else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mengganti Password'
                );

                $this->set_response(
                    $keterangan, 401
                );
            }
        }
    }

    public function keluarpengguna_get(){
        $id_pengguna = $this->uri->segment(3);

        $datapengguna = array('id_pengguna' => $id_pengguna);

        if($this->ModelPengguna->keluarpengguna($datapengguna)){
            $keterangan = array(
                'berhasil' => true,
                'pesan' => 'Berhasil Keluar'
            );

            $this->set_response(
                $keterangan, 200
            );
        }else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Keluar'
            );

            $this->set_response(
                $keterangan, 401
            );
        }
    }
}

/* End of file ControllerPengguna.php */
