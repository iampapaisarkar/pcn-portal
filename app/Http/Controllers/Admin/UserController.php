<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserStoreRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index(Request $request)
    {   
        $users = User::with('role', 'user_state')->where('id', '!=', Auth::user()->id);

        if($request->page){
            $perPage = (integer) $request->page;
        }else{
            $perPage = 10;
        }

        if(!empty($request->search)){
            $search = $request->search;
            $users = $users->where(function($q) use ($search){
                $q->where('firstname', 'like', '%' .$search. '%');
                $q->orWhere('lastname', 'like', '%' .$search. '%');
                $q->orWhere('email', 'like', '%' .$search. '%');
            });
        }

        $users = $users->latest()->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('code', '!=', 'vendor')->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        // if($request->type == 'state_office'){
        //     $this->validate($request, [
        //         'firstname' => [
        //             'required', 'min:3', 'max:255'
        //         ],
        //         'lastname' => [
        //             'required', 'min:3', 'max:255'
        //         ],
        //         'email' => [
        //             'required', Rule::unique((new User)->getTable())->ignore($this->route()->user ?? null)
        //         ],
        //         'phone' => [
        //             'required'
        //         ],
        //         'type' => [
        //             'required'
        //         ],
        //         'state' => [
        //             'required'
        //         ]
        //     ]);
        // }else{
        //     $this->validate($request, [
        //         'firstname' => [
        //             'required', 'min:3', 'max:255'
        //         ],
        //         'lastname' => [
        //             'required', 'min:3', 'max:255'
        //         ],
        //         'email' => [
        //             'required', Rule::unique((new User)->getTable())->ignore($this->route()->user ?? null)
        //         ],
        //         'phone' => [
        //             'required'
        //         ],
        //         'type' => [
        //             'required'
        //         ]
        //     ]);
        // }

        return back()->with('success','User added successfully');
       
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
