<?php

namespace Database\Seeders;

use App\Models\GelombangPPDB;
use App\Models\InformasiKontak;
use App\Models\OrangTua;
use App\Models\Pendaftar; // Pastikan model Wali di-import
use App\Models\Pondok;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Models\Wali;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ------------------------------
        // 1. Data Pondok
        // ------------------------------
        $listPondok = [
            ['kode' => 'PDK-01', 'nama' => 'Pondok Subulul Huda Induk', 'jenis' => 'Salafiyah', 'pengasuh' => 'KH. Ahmad Dahlan'],
            ['kode' => 'PDK-02', 'nama' => 'Pondok Al-Aminah', 'jenis' => 'Modern', 'pengasuh' => 'Nyai Hj. Siti Aminah'],
            ['kode' => 'PDK-03', 'nama' => 'Pondok Al-Mardiyah', 'jenis' => 'Tahfidz', 'pengasuh' => 'Ustadz H. Abdullah'],
        ];

        $pondokIds = [];
        foreach ($listPondok as $p) {
            $createdPondok = Pondok::create([
                'kode_pondok' => $p['kode'],
                'nama_pondok' => $p['nama'],
                'jenis' => $p['jenis'],
                'pengasuh' => $p['pengasuh'],
                'is_aktif' => true,
            ]);
            $pondokIds[] = $createdPondok->id;
        }

        // ------------------------------
        // 2. Data Sekolah + Gelombang
        // ------------------------------
        // Keterangan 'wajib' sesuai enum database Anda
        $smp = Sekolah::create(['kode_sekolah' => 'SMP-01', 'nama_sekolah' => 'SMP IT Suhu', 'jenjang' => 'SMP', 'keterangan' => 'wajib', 'is_aktif' => true]);
        $smk = Sekolah::create(['kode_sekolah' => 'SMK-01', 'nama_sekolah' => 'SMK BP Suhu', 'jenjang' => 'SMK', 'keterangan' => 'wajib', 'is_aktif' => true]);

        $tahunAjaran = TahunAjaran::create(['nama' => '2024/2025', 'tahun_mulai' => 2024, 'tahun_selesai' => 2025, 'is_aktif' => true]);

        // Total 320 pendaftar. Kuota diset 162 + 161 = 323 (Sisa 3 slot)
        $gelSMP = GelombangPPDB::create([
            'sekolah_id' => $smp->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'nama_gelombang' => 'Gelombang 1 SMP',
            'tanggal_buka' => '2024-01-01',
            'tanggal_tutup' => '2024-12-31',
            'kuota' => 162,
            'is_aktif' => true,
        ]);

        $gelSMK = GelombangPPDB::create([
            'sekolah_id' => $smk->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'nama_gelombang' => 'Gelombang 1 SMK',
            'tanggal_buka' => '2024-01-01',
            'tanggal_tutup' => '2024-12-31',
            'kuota' => 161,
            'is_aktif' => true,
        ]);

        // ------------------------------
        // 3. Super Admin
        // ------------------------------
        User::create([
            'email' => 'superadmin@yayasankembangsawit.com',
            'name' => 'Admin Utama',
            'password' => Hash::make('12121212'),
            'role' => 'super-admin',
            'is_aktif' => true,
        ]);

        // ------------------------------
        // 4. Generate Data Pendaftar Modern
        // ------------------------------
        $totalPendaftar = 50;
        $this->command->info("Membuat {$totalPendaftar} data santri lengkap...");

        // Array Nama Modern
        $modernL = ['Arkan', 'Kenzo', 'Gavin', 'Zayan', 'Keanu', 'Rafa', 'Azka', 'Abidzar', 'Rayyan', 'Kenzie', 'Baim', 'Fathan', 'Albirru', 'Shakeel'];
        $modernP = ['Aqeela', 'Zahra', 'Mikayla', 'Keysha', 'Nadine', 'Clarissa', 'Shafira', 'Zaskia', 'Talita', 'Aisyah', 'Nayla', 'Zyana', 'Shanum'];
        $lastNames = ['Pratama', 'Saputra', 'Hidayat', 'Putra', 'Santoso', 'Aulia', 'Ramadhan', 'Nugroho', 'Firdaus', 'Kurniawan', 'Wijaya', 'Iskandar'];

        for ($i = 1; $i <= $totalPendaftar; $i++) {
            // Ganjil = SMP, Genap = SMK
            $isSMP = $i % 2 != 0;
            $selectedSekolahId = $isSMP ? $smp->id : $smk->id;
            $selectedGelId = $isSMP ? $gelSMP->id : $gelSMK->id;
            $prefix = $isSMP ? 'SMP' : 'SMK';

            // Generate Nama Modern
            $jenisKelamin = $faker->randomElement(['L', 'P']);
            $firstName = ($jenisKelamin == 'L') ? $faker->randomElement($modernL) : $faker->randomElement($modernP);
            // Tambahkan variasi nama tengah/belakang agar tidak duplikat
            $namaLengkap = $firstName.' '.$faker->randomElement($lastNames).' '.$faker->firstName;

            // Kode & Email
            $kodePendaftaran = $prefix.date('Y').str_pad($i, 4, '0', STR_PAD_LEFT);
            $emailPribadi = strtolower(str_replace(' ', '', $firstName)).$i.'@gmail.com';
            $this->command->info("membuat Data santri ke-{$i} ");

            // A. Create Pendaftar (Lengkap)
            $pendaftar = Pendaftar::create([
                'tahun_ajaran_id' => $tahunAjaran->id,
                'sekolah_id' => $selectedSekolahId,
                'pondok_id' => $faker->randomElement($pondokIds),
                'gelombang_ppdb_id' => $selectedGelId,
                'kode_pendaftaran' => $kodePendaftaran,
                'nama_lengkap' => $namaLengkap,
                'nik' => $faker->unique()->numerify('35#############'),
                'nisn' => $faker->unique()->numerify('00########'),
                'nomor_kk' => $faker->numerify('35#############'),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2012-12-31'),
                'jenis_kelamin' => $jenisKelamin,
                'anak_ke' => $faker->numberBetween(1, 4),
                'jumlah_saudara' => $faker->numberBetween(1, 5),
                'domisili_santri' => 'Mukim',
                'alamat_lengkap' => $faker->streetAddress,
                'rt' => $faker->numerify('0#'),
                'rw' => $faker->numerify('0#'),
                'provinsi' => 'Jawa Timur',
                'kabupaten' => $faker->city,
                'kecamatan' => 'Kec. '.$faker->citySuffix,
                'desa' => 'Ds. '.$faker->streetName,
                'kode_pos' => $faker->postcode,
                'sekolah_asal' => ($isSMP ? 'SD ' : 'SMP ').$faker->company, // Sekolah asal random
                'npsn_sekolah' => $faker->numerify('20######'),
                'status_sekolah' => $faker->randomElement(['Negeri', 'Swasta']),
                'status_pendaftaran' => 'terverifikasi',
            ]);

            // B. Create Orang Tua (Lengkap)
            OrangTua::create([
                'pendaftaran_id' => $pendaftar->id,
                // Ayah
                'nama_ayah' => $faker->name('male'),
                'nik_ayah' => $faker->numerify('35#############'),
                'pendidikan_terakhir_ayah' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2']),
                'status_ayah' => 'Hidup',
                'pekerjaan_ayah' => $faker->jobTitle,
                'penghasilan_ayah' => $faker->randomElement(['2.000.000', '4.500.000', '1.500.000', '10.000.000']),
                // Ibu
                'nama_ibu' => $faker->name('female'),
                'nik_ibu' => $faker->numerify('35#############'),
                'pendidikan_terakhir_ibu' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1']),
                'status_ibu' => 'Hidup',
                'pekerjaan_ibu' => $faker->randomElement(['IRT', 'Pedagang', 'Guru', 'Karyawan']),
                'penghasilan_ibu' => $faker->randomElement(['0', '1.000.000', '3.000.000']),
            ]);

            // C. Create Wali (Ditambahkan: hanya dibuat untuk setiap kelipatan 3 agar variatif)
            if ($i % 3 == 0) {
                Wali::create([
                    'pendaftar_id' => $pendaftar->id,
                    'nama_wali' => $faker->name,
                    'nik_wali' => $faker->numerify('35#############'),
                    'hubungan' => $faker->randomElement(['Paman', 'Kakek', 'Kakak']),
                    'pendidikan_terakhir' => $faker->randomElement(['SMA', 'S1']),
                    'pekerjaan_wali' => $faker->jobTitle,
                    'penghasilan_wali' => '3.500.000',
                    'alamat_lengkap' => $faker->address,
                ]);
            }

            // D. Create Kontak
            InformasiKontak::create([
                'pendaftar_id' => $pendaftar->id,
                'no_hp_ayah' => $faker->phoneNumber,
                'no_wa' => $faker->phoneNumber,
                'email' => $emailPribadi,
            ]);

            // E. Create User Login
            User::create([
                'name' => $pendaftar->nama_lengkap,
                'email' => $emailPribadi,
                'password' => Hash::make($kodePendaftaran),
                'role' => 'pendaftar',
                'pendaftar_id' => $pendaftar->id,
                'sekolah_id' => null,
                'pondok_id' => null,
                'is_aktif' => true,
            ]);
            $this->command->info("Data santri ke-{$i} berhasil dibuat: {$namaLengkap}");
        }

        $this->command->info("SUKSES! {$totalPendaftar} data lengkap (Pendaftar, Ortu, Wali, User) berhasil dibuat.");
    }
}
