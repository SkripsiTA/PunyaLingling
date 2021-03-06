<?php

namespace App\Http\Controllers\Web\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NomorSurat;
use App\Models\DetailNomorSurat;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class NomorSuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $nomorsurat = NomorSurat::where('desa_adat_id', Auth::user()->desa_adat_id)->paginate(10);

        return view('admin.masterdata.surat.nomor-surat',compact('nomorsurat'));
    }

    public function create()
    {
        return view('admin.masterdata.surat.add-nomor-surat');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $nomorsurat = new NomorSurat;
        // $nomorsurat->kode_nomor_surat = $request->kode_nomor_surat;
        // $nomorsurat->keterangan = $request->keterangan;
        // $nomorsurat->save();

        // $detailnomorsurat = new DetailNomorSurat;
        // $detailnomorsurat->kode_detail_surat = $request->kode_detail_surat;
        // $detailnomorsurat->keterangan = $request->rincian;
        // $detailnomorsurat->master_surat_id = $nomorsurat->master_surat_id;
        // $detailnomorsurat->save();
        // if(count($request->kode_detail_surat)> 0) {
        //     foreach($request->kode_detail_surat as $data) {
        //         $data2 = array(
        //             'kode_detail_surat' => $request->kode_detail_surat[$data],
        //             'keterangan' => $request->rincian[$data],
        //             'master_surat_id' => $nomorsurat->master_surat_id,
        //         );
        //         DetailNomorSurat::create($data2);

        //     }
        // }

        // return redirect('nomor-surat')->with('toast_success', 'Data berhasil ditambahkan!');

        $request->validate([
            'kode_nomor_surat' => 'required',
            'keterangan' => 'required',
        ]);


        $nomorsurat = NomorSurat::updateOrCreate(
            [
                'master_surat_id' => request('master_surat_id'),
            ],
            [
                'kode_nomor_surat' => request('kode_nomor_surat'),
                'keterangan' => request('keterangan'),
                'desa_adat_id' => Auth::user()->desa_adat_id,

            ]);

        return Response::json($nomorsurat);

    }

    public function show($id)
    {
        $nomorsurat = NomorSurat::with('detailnomorsurat')->where('master_surat_id', $id)->first();

        return view('nomor-surat', compact('nomorsurat'));
    }

    public function edit(Request $request)
    {
        $where = array('master_surat_id' => $request->master_surat_id);
        $nomorsurat = NomorSurat::where($where)->first();

        return response()->json($nomorsurat);
    }

    public function update(Request $request, $id)
    {
        $nomorsurat = NomorSurat::findorFail($id);

        $data = $request->validate([
            'kode_nomor_surat' => 'required',
            'keterangan' => 'required',
        ]);

        $nomorsurat->update($data);

        return Response::json($nomorsurat);
    }

    public function destroy($id)
    {
        $nomorsurat = NomorSurat::findorFail($id);
        $nomorsurat->delete();

        return redirect()->route('nomor-surat');
    }
}
