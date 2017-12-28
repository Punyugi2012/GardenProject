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
        $attendances = DB::select('select * from attendance natural join employee');
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
