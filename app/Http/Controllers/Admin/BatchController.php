<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\School\SchoolStoreRequest;
use App\Http\Requests\School\SchoolUpdateRequest;
use DB;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 30;

        $batches = new Batch;

        $batches = $batches->latest()->paginate($perPage);

        return view('admin.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.batches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'batch_no' => ['required'],
            'year' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            // Store batch 
            Batch::create([
                'batch_no' => $request->batch_no,
                'year' => $request->year,
            ]);

            DB::commit();

            return back()->with('success','Batch added successfully');

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch = Batch::where('id', $id)
        ->first();

        if($batch){
            return view('admin.batches.show', compact('batch'));
        }else{
            return abort(404);
        }
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
        try {
            DB::beginTransaction();

            if(Batch::where(['id' => $id, 'status', true])){
                // Update batch 
                Batch::where('id', $id)->update([
                    'status' => false
                ]);
                $response = true;
            }else{
                $response = false;
            }
           

            DB::commit();

            if($response == true){
                return redirect()->route('batches.index')->with('success','Batch closed successfully');
            }else{
                return abort(404);
            }

        }catch(Exception $e) {
            DB::rollback();
            return back()->with('error','There is something error, please try after some time');
        }  
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
