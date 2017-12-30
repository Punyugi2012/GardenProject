<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $day = $today->day;
        $month = $today->month;
        $year = $today->year;
        $today = $year.'-'.$month.'-'.$day;
        $employees = DB::select('select * from employee');
        $attendances = DB::select('select * from attendance natural join employee order by idattendance desc');
        return view('attendance.attendance', ['today'=>$today, 'employees'=>$employees, 'attendances'=>$attendances]);
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
    public function store(AttendanceRequest $request)
    {
        $finishTime = Carbon::parse($request->input('finish_time'));
        $startTime =  Carbon::parse($request->input('start_time'));
        $totalDuration = $finishTime->diffInHours($startTime);
        DB::insert('insert into attendance(start_time, finish_time, amount_time, date, idEmployee) values(?, ?, ?, ?, ?)', [
            $request->input('start_time'),
            $request->input('finish_time'),
            $totalDuration,
            $request->input('date'),
            $request->input('employee')
        ]);
        session()->flash('added', 'เพิ่มการลาทำงานเรียบร้อยแล้ว');
        return redirect('/attendances');
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
        $attendance = DB::select('select * from attendance natural join employee where idAttendance = ?', [$id]);
        return view('attendance.edit-attendance', ['attendance'=>$attendance[0], 'employees'=>$employees]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceRequest $request, $id)
    {
        $finishTime = Carbon::parse($request->input('finish_time'));
        $startTime =  Carbon::parse($request->input('start_time'));
        $totalDuration = $finishTime->diffInHours($startTime);
        DB::update('update attendance set start_time = ?, finish_time = ?, amount_time = ?, date = ?, idEmployee = ? where idAttendance = ?', [
            $request->input('start_time'),
            $request->input('finish_time'),
            $totalDuration,
            $request->input('date'),
            $request->input('employee'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการลงเวลาสำเร็จ');
        return redirect('/attendances/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from attendance where idAttendance = ?', [$id]);
        session()->flash('deleted', 'ลบการลงเวลาทำงานเรียบร้อยแล้ว');
        return redirect('/attendances');
    }
}
