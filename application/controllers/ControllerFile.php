<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ControllerFile extends RestController
{
    //Konstruktor Controller File
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelFile');
    }

    //Method Upload File
    public function uploadfile_post()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_pengguna = $this->input->post('id_pengguna');
            $kunci_file = $this->input->post('kunci_file');

            if (!is_dir('./FilePengguna/' . $id_pengguna)) {
                mkdir('./FilePengguna/' . $id_pengguna, 0777, TRUE);
            }

            $config['upload_path'] = './FilePengguna/' . $id_pengguna;
            $config['allowed_types'] = '*';
            $config['max_size']    = '1000000';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);

            $upload = $this->upload->do_upload('file_enkripsi');
            $upload = $this->upload->data();

            if (!$upload) {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mengupload File'
                );

                $this->set_response(
                    $keterangan,
                    401
                );
            } else {
                $datafile = array(
                    'nama_file' => $upload['file_name'],
                    'id_pengguna' => $id_pengguna,
                    'kunci_file' => $kunci_file
                );

                if ($this->ModelFile->uploadfile($datafile)) {
                    $keterangan = array(
                        'berhasil' => true,
                        'pesan' => 'Berhasil Mengupload File'
                    );

                    $this->set_response(
                        $keterangan,
                        200
                    );
                } else {
                    $keterangan = array(
                        'berhasil' => false,
                        'pesan' => 'Gagal Mengupload File'
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

    public function deletefile_post()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_file = $this->input->post('id_file');
            $nama_file = $this->input->post('nama_file');
            $id_pengguna = $this->input->post('id_pengguna');

            $datafile = array(
                'id_file' => $id_file,
                'nama_file' => $nama_file,
                'id_pengguna' => $id_pengguna
            );

            if ($this->ModelFile->deletefile($datafile)) {
                unlink('./FilePengguna/' . $id_pengguna . '/' . $nama_file);
                $keterangan = array(
                    'berhasil' => true,
                    'pesan' => 'Berhasil Menghapus File'
                );

                $this->set_response(
                    $keterangan,
                    200
                );
            } else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Menghapus File'
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

    public function getfile_get()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_pengguna = $this->uri->segment(4);

            $datapengguna = array('id_pengguna' => $id_pengguna);

            $filepengguna = $this->ModelFile->getfile($datapengguna);

            $datafilepengguna = array('file_pengguna' => $filepengguna);

            $this->set_response(
                $datafilepengguna,
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

    public function downloadfile_get()
    {
        $validasitoken = $this->authorizationtoken->validateToken();

        if (!empty($validasitoken) && $validasitoken['status'] === TRUE) {
            $id_pengguna = $this->uri->segment(4);
            $id_file = $this->uri->segment(5);

            $datafile = array(
                'id_file' => $id_file,
                'id_pengguna' => $id_pengguna
            );

            $downloadfile = $this->ModelFile->downloadfile($datafile);

            $datadownloadfile = array('file_pengguna' => $downloadfile);

            $this->set_response(
                $datadownloadfile,
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

/* End of file ControllerFile.php */
