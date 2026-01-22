<?php

$table->enum('status_pendaftaran', [
    'pendaftar',              // isi data awal
    'pending',            // upload berkas
    'lulus_verifikasi',   // admin verifikasi berkas
    'tidak_lulus',        // gagal verifikasi
    'diterima',            // diterima final
    'dibatalkan',
    '', 
])->default('pendaftar');
