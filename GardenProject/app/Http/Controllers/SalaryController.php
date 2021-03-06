<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SalaryRequest;
use Carbon\Carbon;

class SalaryController extends Controller
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
        $salaries = DB::select('select * from salary natural join employee order by idsalary desc');
        return view('salary.list-salary', ['salaries'=>$salaries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = DB::select('select * from employee');
        return view('salary.add-salary', ['employees'=>$employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryRequest $request)
    {
        $rest_money = $request->input('amount_money') - $request->input('cost');
        DB::insert('insert into salary(date, time, amount_money, cost, rest_money, round, idEmployee) values (?, ?, ?, ?, ?, ?, ?)', [
           $request->input('date'),
           $request->input('time'),
           $request->input('amount_money'),
           $request->input('cost'),
           $rest_money,
           $request->input('round'),
           $request->input('employee') 
        ]);
        session()->flash('added', 'เพิ่มการจ่ายเงินเดือน เรียบร้อยแล้ว');
        return redirect('/salaries');
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
        $salary = DB::select('select * from salary where idSalary = ?', [$id]);
        return view('salary.edit-salary', ['salary'=>$salary[0], 'employees'=>$employees]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryRequest $request, $id)
    {
        $rest_money = $request->input('amount_money') - $request->input('cost');
        DB::update('update salary set date = ?, time = ?, amount_money = ?, cost = ?, rest_money = ?, round = ? where idSalary = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('amount_money'),
            $request->input('cost'),
            $rest_money,
            $request->input('round'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการจ่ายเงินเดือน เรียบร้อยแล้ว');
        return redirect('/salaries/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from salary where idSalary = ?', [$id]);
        session()->flash('deleted', 'ลบการจ่ายเงินเดือน เรียบร้อยแล้ว');
        return redirect('/salaries');
    }
}
