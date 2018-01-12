<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\DeductionRequest;

class DeductionController extends Controller
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
        $deductions = DB::table('Deduction')->join('Employee', 'Deduction.idEmployee', '=', 'Employee.idEmployee')
            ->join('Take', 'Deduction.idTake', '=', 'Take.idTake')->get();
        return view('deduction.list-deduction', ['deductions'=>$deductions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $takes = DB::select('select * from Take');
        $employees = DB::select('select * from employee');
        return view('deduction.add-deduction', ['takes'=>$takes, 'employees'=>$employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeductionRequest $request)
    {
        DB::insert('insert into Deduction(date, total_money, idEmployee, idTake) values(?, ?, ?, ?)', [
            $request->input('date'),
            0,
            $request->input('employee'),
            $request->input('take'),
        ]);
        session()->flash('added', 'เพิ่มการหักเงิน เรียบร้อยแล้ว');
        return redirect('/deductions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deductionsDetail = DB::table('Item')->join('DeductionDetail', 'Item.idItem', '=', 'DeductionDetail.idItem')
            ->where('idDeduction', $id)->get();
        $items = DB::select('select * from Item where type = "equipment"');
        return view('deduction.detail-deduction', ['deductionsDetail'=>$deductionsDetail, 'items'=>$items, 'idDeduction'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deduction = DB::table('Deduction')->join('Employee', 'Deduction.idEmployee', '=', 'Employee.idEmployee')
        ->join('Take', 'Deduction.idTake', '=', 'Take.idTake')->where('idDeduction', $id)->first();
        $takes = DB::select('select * from Take');
        $employees = DB::select('select * from employee');
        return view('deduction.edit-deduction', ['deduction'=>$deduction, 'takes'=>$takes, 'employees'=>$employees]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeductionRequest $request, $id)
    {
        DB::update('update Deduction set date = ?, idEmployee = ?, idTake = ? where idDeduction = ?', [
            $request->input('date'),
            $request->input('employee'),
            $request->input('take'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการหักเงิน เรียบร้อยแล้ว');
        return redirect('/deductions/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from Deduction where idDeduction = ?', [$id]);
        session()->flash('deleted', 'ลบการหักเงิน เรียบร้อยแล้ว');
        return redirect('/deductions');
    }
}
