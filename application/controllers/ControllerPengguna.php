<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ControllerPengguna extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelPengguna');
        $this->load->model('ModelKonfirmasipendaftaran');
        $this->load->model('ModelKunciRSA');
        $this->load->model('ModelFile');
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

            $datapengguna = array(
                'email_pengguna' => $emailpengguna
            );

            $kodeunik = random_string('alnum', 32);

            foreach ($this->ModelPengguna->getpengguna($datapengguna) as $data) {
                $datakonfirmasi = array(
                    'email_konfirmasi_pendaftaran' => $emailpengguna,
                    'kodeunik_konfirmasi_pendaftaran' => $kodeunik,
                    'id_pengguna' => $data->id_pengguna
                );
            }

            if ($this->ModelKonfirmasipendaftaran->tambahkonfirmasi($datakonfirmasi)) {
                $this->load->config('email');
                $from = $this->config->item('smtp_user');
                $to = $emailpengguna;

                $this->email->set_newline("\r\n");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject('Konfirmasi Email');
                $this->email->message('Klik Link Berikut Untuk Aktivasi Akun <a href="' . base_url() . "api/aktivasipengguna/" . $kodeunik . '">AKTIVASI</a>');
                $this->email->set_mailtype('html');
                $this->email->send();

                $keterangan = array(
                    'berhasil' => true,
                    'pesan' => 'Berhasil Mendaftarkan User',
                );

                $this->set_response(
                    $keterangan,
                    200
                );
            } else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mendaftarkan User'
                );

                $this->set_response(
                    $keterangan,
                    401
                );
            }
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Mendaftarkan Pengguna'
            );

            $this->set_response(
                $keterangan,
                401
            );
        }
    }

    public function masukpengguna_post()
    {
        $emailpengguna = $this->input->post('email');
        $passwordpengguna = $this->input->post('password');

        $datapengguna = array(
            'email_pengguna' => $emailpengguna,
            'password_pengguna' => md5($passwordpengguna),
            'status_pengguna' => 'AKTIF'
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
                $keterangan,
                200
            );
        } else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Masuk'
            );

            $this->set_response(
                $keterangan,
                401
            );
        }
    }

    public function gantipasswordpengguna_post()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_pengguna = $this->input->post("id_pengguna");

            $datapengguna = array('id_pengguna' => $id_pengguna);

            foreach ($this->ModelPengguna->getpasswordlamapengguna($datapengguna) as $password) {
                $password_lama = md5($this->input->post("password_lama"));
                $password_baru = md5($this->input->post("password_baru"));
                if ($password_lama == $password->password_pengguna) {
                    $datapassword = array('password_pengguna' => $password_baru);

                    $gantipassword = $this->ModelPengguna->gantipasswordpengguna($datapengguna, $datapassword);

                    if ($gantipassword) {
                        $keterangan = array(
                            'berhasil' => true,
                            'pesan' => 'Berhasil Mengganti Password'
                        );

                        $this->set_response(
                            $keterangan,
                            200
                        );
                    } else {
                        $keterangan = array(
                            'berhasil' => false,
                            'pesan' => 'Gagal Mengganti Password'
                        );

                        $this->set_response(
                            $keterangan,
                            401
                        );
                    }
                } else {
                    $keterangan = array(
                        'berhasil' => false,
                        'pesan' => 'Gagal Mengganti Password'
                    );

                    $this->set_response(
                        $keterangan,
                        401
                    );
                }
            }
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

    public function aktivasipengguna_get()
    {
        $kodeunik = $this->uri->segment(3);

        $whereaktivasi = array(
            'kodeunik_konfirmasi_pendaftaran' => $kodeunik,
        );

        $dataaktivasi = $this->ModelKonfirmasipendaftaran->cekkonfirmasi($whereaktivasi);

        foreach ($dataaktivasi as $data) {
            $whereuser = array(
                'id_pengguna' => $data->id_pengguna,
                'email_pengguna' => $data->email_konfirmasi_pendaftaran
            );

            $datauser = array('status_pengguna' => 'AKTIF');

            if ($this->ModelPengguna->aktivasipengguna($whereuser, $datauser)) {
                $this->ModelKonfirmasipendaftaran->hapuskonfirmasi($whereaktivasi);

                $this->load->view('aktivasipengguna/berhasil');
            } else {
                $this->load->view('aktivasipengguna/gagal');
            }
        }

        $this->load->view('aktivasipengguna/gagal');
    }

    public function keluarpengguna_get()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_pengguna = $this->uri->segment(3);

            $datapengguna = array('id_pengguna' => $id_pengguna);

            if (is_dir('./FilePengguna/' . $id_pengguna)) {
                $directory = new RecursiveDirectoryIterator('./FilePengguna/' . $id_pengguna,  FilesystemIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
                foreach ($files as $file) {
                    if (is_dir($file)) {
                        rmdir($file);
                    } else {
                        unlink($file);
                    }
                }

                rmdir('./FilePengguna/' . $id_pengguna);
            }

            if ($this->ModelKunciRSA->keluarpengguna($datapengguna) && $this->ModelFile->keluarpengguna($datapengguna)) {
                $keterangan = array(
                    'berhasil' => true,
                    'pesan' => 'Berhasil Keluar'
                );

                $this->set_response(
                    $keterangan,
                    200
                );
            } else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Keluar'
                );

                $this->set_response(
                    $keterangan,
                    401
                );
            }
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

/* End of file ControllerPengguna.php */
