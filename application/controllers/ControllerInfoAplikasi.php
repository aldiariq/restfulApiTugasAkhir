<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerInfoAplikasi extends CI_Controller {

    public function index()
    {
        $infoaplikasi = array(
            'namaaplikasi' => 'Aplikasi Penyimpanan Dokumen Online Terenkripsi',
            'pembimbingta' => 'Drs. Megah Mulya, M.T.',
            'pembuataplikasi' => 'M. Aldi Ariqi',
            'infoaplikasi' => 'Aplikasi ini merupakan Aplikasi Penyimpanan Online File Online File Dokumen Terenkripsi yang Dibuat Untuk Penyusunan Skripsi di Jurusan Teknik Informatika Dengan Topik Kriptografi Menggunakan Metode Hybrid Cryptosystem Blowfish dan RSA()'
        );

        echo json_encode($infoaplikasi);
    }

}

/* End of file Controllername.php */
