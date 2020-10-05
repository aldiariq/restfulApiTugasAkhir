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
        $namapengguna = $this->input->post('nama');
        $nohppengguna = $this->input->post('nohp');
        $passwordpengguna = md5($this->input->post('password'));
        

        $datapengguna = array(
            'email_pengguna' => $emailpengguna,
            'nama_pengguna' => $namapengguna,
            'nohp_pengguna' => $nohppengguna,
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

    public function gantipasswordpengguna(){
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

                    echo json_encode($keterangan);
                }else {
                    $keterangan = array(
                        'berhasil' => false,
                        'pesan' => 'Gagal Mengganti Password'
                    );

                    echo json_encode($keterangan);
                }
            }else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mengganti Password'
                );

                echo json_encode($keterangan);
            }
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
