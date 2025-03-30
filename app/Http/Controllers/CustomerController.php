<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = DB::table('permissions')
        ->join('features AS f', 'f.id', '=', 'permissions.feature_id')
        ->join('roles_permission AS rp', 'rp.permission_id', '=', 'permissions.id')
        ->join('roles AS r', 'r.id', '=', 'rp.role_id')
        ->groupBy('r.name', 'f.name')
        ->selectRaw('r.name AS rolename, GROUP_CONCAT(permissions.name) AS permissions, f.name AS feature')
            ->get();

        $roles = DB::table('roles')
                ->selectRaw(' name')
                ->get();
      
        //dd($roles);
        return view('customer.index',[
            'results'=>$results,
            'roles' =>$roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
