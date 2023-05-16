<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Services\UserService;
use DataTables;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        



        if ($request->ajax()) {
            $user = User::latest()->get();
            return Datatables::of($user)
                    // ->editColumn('name', '<> {{$name}}!') //   ->editColumn('name', function(User $user) { return 'Hi ' . $user->name . '!';})
                    ->addIndexColumn()
                    ->addColumn('action', function($row){   
                           $btn = '<button type="button"  data-toggle="tooltip"  data-original-title="Edit" id="editData" onclick="editData('.$row->id.')" class="edit btn btn-primary btn-sm editData"> <i class="fas fa-edit"></i> Ubah  </button> ';
   
                           $btn = $btn.'<button   class="btn btn-sm btn btn-danger btn_delete" id="deleteData" onclick="notificationBeforeDelete(event, '.$row->id.')" > <i class="fa fa-trash"></i> Hapus  </button>';
    
                            return "<center>{$btn} </center>";
                    })
                    ->rawColumns(['action'])
                   // ->setRowClass('{{ $id % 2 == 0 ? "alert-success" : "alert-warning" }}') //->setRowClass(function ($class) { return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning'; })
                    ->make(true);

           return view('users.index',compact('user'));
        } else {

            $users = User::all();
            return view('users.index', [
                'users' => $users
            ]);

        }
      

    }



    // public function index2(Request $request){
    //     if($request->ajax()) {
    //         return $this->userService->get($request->all());
    //     }
    //     return view('users.index');
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'name' => 'required',
            'email' => 'required|email|email',
            'password' => 'required|confirmed'
        ]);
        $array = $request->only([
            'name', 'email', 'password'
        ]);
        
        $array['password'] = bcrypt($array['password']);


        $user = User::updateOrCreate([
            'id' =>  $request->get('id')
        ],[
            'name' => $array['name'],
            'email' => $array['email'],
            'password' => $array['password'],
        ]);

        return response()->json(['data' =>  $user], 200);
        // return redirect()->route('users.index')
        //     ->with('success_message', 'Berhasil menambah user baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = User::find($id);
        // if (!$user) return redirect()->route('users.index')
        //     ->with('error_message', 'User dengan id'.$id.' tidak ditemukan');

        // return view('users.edit', [
        //     'user' => $user
        // ]);

        $post = User::find($id);
        return response()->json($post);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|confirmed'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil mengubah user');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
    
        if ($id == $request->user()->id) {

            return response()->json(['data' =>  $user, "user" => $request->user()], 422);

        } else {

            if ($user) $user->delete();

            return response()->json(['data' =>  $user, "user" => $request->user()], 200);
        }
        //     ->with('error_message', 'Anda tidak dapat menghapus diri sendiri.');
    
        // if ($user) $user->delete();

    
        // return redirect()->route('users.index')
        //     ->with('success_message', 'Berhasil menghapus user');
    
    }
}
