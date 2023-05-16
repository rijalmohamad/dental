<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Pengingat;
use App\Services\UserService;
use DataTables;

class DashboardController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['users']      = User::count();
        $data['pasien']     = Pasien::count();
        $data['terkirim']   = Pengingat::where('status', 1)->count();
        $data['pending']    = Pengingat::where('status', 0)->count();

        $data['chart1']  =   [];  
        $data['chart2']  =   [];  

        for($i = 1; $i <= 12; $i++) {
            $data['chart1'][] = Pengingat::whereMonth('tgl_kirim', $i)->where('status', 0)->count();//tdk terkirim
            $data['chart2'][] = Pengingat::whereMonth('tgl_kirim', $i)->where('status', 1)->count();//terkirim
        }

        
        return view('dashboard.dashboard', $data);

    }



}
