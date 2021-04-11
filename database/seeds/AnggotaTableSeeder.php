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
        $anggota1 = new Anggota;
        $anggota1->nama = 'Budi';
        $anggota1->jenis_kelamin = 'L';
        $anggota1->id_orang_tua = null;
        $anggota1->save();

        $anggota2 = new Anggota;
        $anggota2->nama = 'Dedi';
        $anggota2->jenis_kelamin = 'L';
        $anggota2->id_orang_tua = 1;
        $anggota2->save();

        $anggota3 = new Anggota;
        $anggota3->nama = 'Dodi';
        $anggota3->jenis_kelamin = 'L';
        $anggota3->id_orang_tua = 1;
        $anggota3->save();

        $anggota4 = new Anggota;
        $anggota4->nama = 'Dede';
        $anggota4->jenis_kelamin = 'L';
        $anggota4->id_orang_tua = 1;
        $anggota4->save();

        $anggota5 = new Anggota;
        $anggota5->nama = 'Dewi';
        $anggota5->jenis_kelamin = 'P';
        $anggota5->id_orang_tua = 1;
        $anggota5->save();

        $anggota6 = new Anggota;
        $anggota6->nama = 'Feri';
        $anggota6->jenis_kelamin = 'L';
        $anggota6->id_orang_tua = 2;
        $anggota6->save();

        $anggota7 = new Anggota;
        $anggota7->nama = 'Farah';
        $anggota7->jenis_kelamin = 'P';
        $anggota7->id_orang_tua = 2;
        $anggota7->save();

        $anggota8 = new Anggota;
        $anggota8->nama = 'Gugus';
        $anggota8->jenis_kelamin = 'L';
        $anggota8->id_orang_tua = 3;
        $anggota8->save();

        $anggota9 = new Anggota;
        $anggota9->nama = 'Gandi';
        $anggota9->jenis_kelamin = 'L';
        $anggota9->id_orang_tua = 3;
        $anggota9->save();

        $anggota10 = new Anggota;
        $anggota10->nama = 'Hani';
        $anggota10->jenis_kelamin = 'P';
        $anggota10->id_orang_tua = 4;
        $anggota10->save();

        $anggota11 = new Anggota;
        $anggota11->nama = 'Hana';
        $anggota11->jenis_kelamin = 'P';
        $anggota11->id_orang_tua = 4;
        $anggota11->save();
    }
}
