<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Anggota;
use App\Http\Resources\AnggotaResource;

class AnggotaController extends Controller
{


    public function index()
    {
        return $this->successResponse(
            AnggotaResource::collection(Anggota::all())
        );
    }

    public function store(Request $request)
    {
      $anggota = Anggota::create([
        'nama'          => $request->input('nama'),
        'jenis_kelamin' => $request->input('jenis_kelamin'),
        'id_orang_tua'  => $request->input('id_orang_tua'),
        'tingkat'       => $request->input('tingkat'),
      ]);

      return $this->successResponse(new AnggotaResource($anggota), true);
    }

    public function show(Anggota $id)
    {
        return $this->successResponse(new AnggotaResource($id));
    }

    public function update(Request $request, Anggota $id)
    {
        $id->update($request->all());

        return new AnggotaResource($id);
    }
    
    public function destroy(Anggota $id)
    {
        $id->delete();

        return $this->deleteResponse();
    }
}
