<?php

use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anggota = new Anggota;
        $anggota->nama = 'Budi';
        $anggota->jenis_kelamin = 'L';
        $anggota->id_orang_tua = null;
        $anggota->tingkat = 0;
        $anggota->save();

        $anggota1 = new Anggota;
        $anggota1->nama = 'Dedi';
        $anggota1->jenis_kelamin = 'L';
        $anggota1->id_orang_tua = 1;
        $anggota1->tingkat = 1;
        $anggota1->save();

        $anggota2 = new Anggota;
        $anggota2->nama = 'Farah';
        $anggota2->jenis_kelamin = 'P';
        $anggota2->id_orang_tua = 2;
        $anggota2->tingkat = 2;
        $anggota2->save();
    }
}
