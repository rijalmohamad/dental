<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Pengingat;
use DataTables;

class PengingatController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $pengingat = Pengingat::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($pengingat)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){   

                   
                           $btn = '<a href="javascript:;" class="btn btn-sm btn btn-warning btn_kirim" onclick="kirimWA('.$row->id.')"> <i class="fas fa-paper-plane"></i> Kirim  </a> ';
     
                           $btn .= '<button type="button"  data-toggle="tooltip"  data-original-title="Edit" id="editData" onclick="editData('.$row->id.')" class="edit btn btn-primary btn-sm editData"> <i class="fas fa-edit"></i> Ubah  </button> ';
   
                           $btn .= '<button   class="btn btn-sm btn btn-danger btn_delete" id="deleteData" onclick="notificationBeforeDelete(event, '.$row->id.')" > <i class="fa fa-trash"></i> Hapus  </button>';
    
                            return "<center>{$btn} </center>";
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }

        $data['pasien'] = Pasien::get();

        return view('pasien.pengingat', $data);
      
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $input =  $request->all();

        if ($input['is_pasien_baru'] == 1) {
           
            $request->validate([
                'nama_pasien' => 'required',
                'no_rm' => 'required',
                'no_hp' => 'required',
                'tgl_periksa' => 'required',
                'keluhan' => 'required',
                'td' => 'required',
                'gd' => 'required',
                'diagnosa' => 'required',
                'keterangan' => 'required',

                'tgl_kirim'   => 'required',
                'kategori'    => 'required',
                'pesan'       => 'required',
                
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
            Pasien::create($array);


            $array2 = $request->only([
                'nama_pasien',
                'no_hp',
                'tgl_kirim',
                'kategori',
                'pesan',
            ]);
            Pengingat::create($array2);

        } else {
            $request->validate([
                'nama_pasien' => 'required',
                'no_hp'       => 'required',
                'tgl_kirim'   => 'required',
                'kategori'    => 'required',
                'pesan'       => 'required',
                // 'status' => 'required'
                
            ]);
            $array = $request->only([
                'nama_pasien',
                'no_hp',
                'tgl_kirim',
                'kategori',
                'pesan',
            ]);

            $data = Pengingat::updateOrCreate(['id' =>  $request->get('id')],$array);
        }
    


        return response()->json(['data' => $input], 200);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = Pengingat::find($id);
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
        $data = Pengingat::find($id);
    
        if ($data) $data->delete();

        return response()->json(['data' =>  $data], 200);

    }
}
