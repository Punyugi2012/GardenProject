<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AssignmentTypeRequest;

class AssignmentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignmentTypes = DB::select('select * from AssignmentType');
        return view('assignmentType.add-assignmentType', ['assignmentTypes'=>$assignmentTypes]);
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
    public function store(AssignmentTypeRequest $request)
    {
        DB::insert('insert into AssignmentType(name) values(?)', [$request->input('name')]);
        session()->flash('added', 'เพิ่มประเภทมอบหมายงาน เรียบร้อยแล้ว');
        return redirect('/assignmentTypes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignmentType = DB::table('AssignmentType')->where('idAssignmentType', $id)->first();
        return view('assignmentType.edit-assignmentType', ['assignmentType'=>$assignmentType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentTypeRequest $request, $id)
    {
        DB::update('update AssignmentType set name = ? where idAssignmentType = ?', [
            $request->input('name'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขประเภทการมอบหมายงาน เรียบร้อยแล้ว');
        return redirect('/assignmentTypes/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from AssignmentType where idAssignmentType = ?', [$id]);
        session()->flash('deleted', 'ลบประเภทการมอบหมายงาน เรียบร้อยแล้ว');
        return redirect('/assignmentTypes');
    }
}
