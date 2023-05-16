<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Pasien;
use DataTables;

class PasienController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        


        $data = Pasien::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){   
                           $btn = '<button type="button"  data-toggle="tooltip"  data-original-title="Edit" id="editData" onclick="editData('.$row->id.')" class="edit btn btn-primary btn-sm editData"> <i class="fas fa-edit"></i> Ubah  </button> ';
   
                           $btn = $btn.'<button   class="btn btn-sm btn btn-danger btn_delete" id="deleteData" onclick="notificationBeforeDelete(event, '.$row->id.')" > <i class="fa fa-trash"></i> Hapus  </button>';
    
                            return "<center>{$btn} </center>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }

        return view('pasien.pasien',compact('data'));
      
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'no_rm' => 'required',
            'no_hp' => 'required',
            'tgl_periksa' => 'required',
            'keluhan' => 'required',
            'td' => 'required',
            'gd' => 'required',
            'diagnosa' => 'required',
            'keterangan' => 'required'
            
        ]);
        $array = $request->only([
            'nama_pasien',
            'no_rm',
            'no_hp',
            'tgl_periksa',
            'keluhan',
            'td',
            'gd',
            'diagnosa',
            'keterangan',
        ]);
        

        $data = Pasien::updateOrCreate(['id' =>  $request->get('id')],$array);

        return response()->json(['data' =>  $data], 200);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = Pasien::find($id);
        return response()->json($post);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = Pasien::find($id);
    
        if ($data) $data->delete();

        return response()->json(['data' =>  $data, "user" => $request->user()], 200);

    }
}
