<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = array(
  'mailtype'  => 'html',
  'charset'   => 'utf-8',
  'protocol'  => 'smtp',
  'smtp_host' => 'smtp.gmail.com',
  'smtp_user' => 'ariqirestapi@gmail.com',  // Email gmail
  'smtp_pass'   => '2020CoronaMenyerang',  // Password gmail
  'smtp_crypto' => 'ssl',
  'smtp_port'   => 465,
  'crlf'    => "\r\n",
  'newline' => "\r\n"
);

// $config = Array(
//     'protocol' => 'smtp',
//     'smtp_host' => 'smtp.mailtrap.io',
//     'smtp_port' => 2525,
//     'smtp_user' => '36c69255b40286',
//     'smtp_pass' => '2b80a994f93c76',
//     'crlf' => "\r\n",
//     'newline' => "\r\n"
//   );