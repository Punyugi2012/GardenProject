<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReturningRequest;

class ReturningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnings = DB::table('Reverting')->join('Take', 'Reverting.idTake', '=', 'Take.idTake')
            ->join('Employee', 'Reverting.idEmployee', '=', 'Employee.idEmployee')->get();
        return view('returning.list-returning', ['returnings'=>$returnings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $takes = DB::select('select * from Take');
        $employees = DB::select('select * from Employee');
        return view('returning.add-returning', ['takes'=>$takes, 'employees'=>$employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReturningRequest $request)
    {
        DB::insert('insert into Reverting(date, time, idTake, idEmployee) values(?, ?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            $request->input('take'),
            $request->input('employee'),
        ]);
        session()->flash('added', 'เพิ่มการคืน เรียบร้อยแล้ว');
        return redirect('/returnings');
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
        DB::delete('delete from Reverting where idReverting = ?', [$id]);
        session()->flash('deleted', 'ลบการคืน เรียบร้อยแล้ว');
        return redirect('/returnings');

    }
}
