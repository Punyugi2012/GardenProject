<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReturningRequest;

class ReturningController extends Controller
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
        $takes = DB::select('select * from Take where status_returning = "unfully"');
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
        $returningsDetail = DB::table('Item')->join('RevertingDetail', 'Item.idItem', '=', 'RevertingDetail.idItem')
        ->where('idReverting', $id)->get();
        $idTake = DB::table('Reverting')->where('idReverting', $id)->first()->idTake;
        $takeDetails = DB::table('Item')->join('TakeDetail', 'Item.idItem', '=', 'TakeDetail.idItem')->where('idTake', $idTake)->get();
        return view('returning.detail-returning', ['returningsDetail'=>$returningsDetail, 'takeDetails'=>$takeDetails, 'idReturning'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $returning = DB::table('Reverting')->join('Take', 'Reverting.idTake', '=', 'Take.idTake')
        ->join('Employee', 'Reverting.idEmployee', '=', 'Employee.idEmployee')->where('idReverting', $id)->first();
        $takes = DB::select('select * from Take');
        $employees = DB::select('select * from Employee');
        return view('returning.edit-returning', ['returning'=>$returning, 'takes'=>$takes, 'employees'=>$employees]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReturningRequest $request, $id)
    {
        DB::update('update Reverting set date = ?, time = ?, idTake = ?, idEmployee = ? where idReverting = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('take'),
            $request->input('employee'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการคืน เรียบร้อยแล้ว');
        return redirect('/returnings/'.$id.'/edit');
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
