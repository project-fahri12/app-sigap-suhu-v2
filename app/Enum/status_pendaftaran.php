<?php

$table->enum('status_pendaftaran', [
    'draft',              //mengisi awal 
    'pending,',           // sudah finalisasi data
    'pendaftar',          // isi data awal
    'pending',            // upload berkas
    'lulus_verifikasi',   // admin verifikasi berkas
    'tidak_lulus',        // gagal verifikasi
    'diterima',           // diterima final
    'dibatalkan',
    '', 
])->default('pendaftar');



$table->enum('status_berkas', [
    'belum',                // belum isi berkas
    'pending',              // sudah isi / mengunggu verifikasi admin
    'lulus_verifikasi',     // sudah diverifikasi admin
    'batal',                // dibatalkan

])->default('belum');


