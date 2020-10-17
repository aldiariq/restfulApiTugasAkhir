<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerInfoAplikasi extends CI_Controller {

    public function index()
    {
        $infoaplikasi = array(
            'namaaplikasi' => 'Aplikasi Penyimpanan Dokumen Online Terenkripsi',
            'namapembimbingta' => 'Drs. Megah Mulya, M.T.',
            'namamahasiswa' => 'M. Aldi Ariqi',
            'deskripsiaplikasi' => 'Aplikasi ini merupakan aplikasi penyimpanan file dokumen online terenkripsi yang dibuat untuk penyusunan tugas akhir di Jurusan Teknik Informatika dengan Topik Kriptografi Menggunakan Metode Hybrid Cryptosystem Blowfish dan RSA(Rivest Shamir Adleman)'
        );

        echo json_encode($infoaplikasi);
    }

}

/* End of file Controllername.php */
