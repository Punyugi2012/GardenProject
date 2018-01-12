<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use Carbon\Carbon;

class LeaveController extends Controller
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
        $leaves = DB::select('select * from takeleave natural join employee order by idtakeleave desc');
        return view('leave.list-leave', ['leaves'=>$leaves]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = DB::select('select * from employee');
        return view('leave.add-leave', ['employees'=>$employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveRequest $request)
    {
        $from_date = Carbon::parse($request->input('from_date'));
        $to_date =  Carbon::parse($request->input('to_date'));
        $totalDuration = $to_date->diffInDays($from_date);
        DB::insert('insert into takeleave(from_date, to_date, type, amount_day, cause, idEmployee) values (?, ?, ?, ?, ?, ?)', [
            $request->input('from_date'),
            $request->input('to_date'),
            $request->input('type'),
            $totalDuration,
            $request->input('cause'),
            $request->input('employee')
        ]);
        session()->flash('added', 'เพิ่มการลางาน เรียบร้อยแล้ว');
        return redirect('/leaves');
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
        $employees = DB::select('select * from employee');
        $leave = DB::select('select * from takeleave natural join employee where idtakeleave = ?', [$id]);
        return view('leave.edit-leave', ['leave'=>$leave[0], 'employees'=>$employees]);
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
        $from_date = Carbon::parse($request->input('from_date'));
        $to_date =  Carbon::parse($request->input('to_date'));
        $totalDuration = $to_date->diffInDays($from_date);
        DB::update('update takeleave set from_date = ?, to_date = ?, type = ?, amount_day = ?, cause = ?, idEmployee = ? where idtakeleave = ?', [
            $request->input('from_date'),
            $request->input('to_date'),
            $request->input('type'),
            $totalDuration,
            $request->input('cause'),
            $request->input('employee'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการลาทำงาน เรียบร้อยแล้ว');
        return redirect('/leaves/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from takeleave where idtakeleave = ?', [$id]);
        session()->flash('deleted', 'ลบการลางาน เรียบร้อยแล้ว');
        return redirect('/leaves');
    }
}
