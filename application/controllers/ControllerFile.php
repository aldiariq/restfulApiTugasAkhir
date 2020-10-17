<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ControllerFile extends CI_Controller
{
    //Konstruktor Controller File
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelFile');
    }

    //Method Upload File
    public function uploadfile()
    {
        $id_pengguna = $this->input->post('id_pengguna');
        $kunci_file = $this->input->post('kunci_file');

        $config['upload_path'] = './FilePengguna/';
        $config['allowed_types'] = '*';
        $config['max_size']    = '1000000';
        $config['max_width']  = '10000';
        $config['max_height']  = '10000';

        $this->load->library('upload', $config);

        $upload = $this->upload->do_upload('file_enkripsi');
        $upload = $this->upload->data();

        if (!$upload) {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Mengupload File'
            );

            echo json_encode($keterangan);
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
    
                echo json_encode($keterangan);   
            }else {
                $keterangan = array(
                    'berhasil' => false,
                    'pesan' => 'Gagal Mengupload File'
                );
    
                echo json_encode($keterangan);   
            }
        }
    }

    public function deletefile(){
        $id_file = $this->uri->segment(4);

        $datafile = array('id_file' => $id_file);

        if($this->ModelFile->deletefile($datafile)){
            $keterangan = array(
                'berhasil' => true,
                'pesan' => 'Berhasil Menghapus File'
            );

            echo json_encode($keterangan);
        }else {
            $keterangan = array(
                'berhasil' => false,
                'pesan' => 'Gagal Menghapus File'
            );

            echo json_encode($keterangan);
        }
    }

    public function getfile()
    {        
        $id_pengguna = $this->uri->segment(4);

        $datapengguna = array('id_pengguna' => $id_pengguna);

        $filepengguna = $this->ModelFile->getfile($datapengguna);

        $datafilepengguna = array('file_pengguna' => $filepengguna);

        echo json_encode($datafilepengguna);
    }

    public function downloadfile()
    {

        $id_pengguna = $this->uri->segment(4);
        $id_file = $this->uri->segment(5);

        $datafile = array(
            'id_file' => $id_file,
            'id_pengguna' => $id_pengguna
        );

        $downloadfile = $this->ModelFile->downloadfile($datafile);

        $datadownloadfile = array('file_pengguna' => $downloadfile);

        echo json_encode($datadownloadfile);
    }
}

/* End of file ControllerFile.php */
