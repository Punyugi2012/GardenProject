<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\DeductionDetailRequest;

class DeductionDetailController extends Controller
{
    private function setTotalMoney($idDeduction) {
        $sum = DB::table('DeductionDetail')->where('idDeduction', $idDeduction)->sum('price');
        DB::update('update Deduction set total_money = ? where idDeduction = ?', [$sum, $idDeduction]);
    }
    public function store(DeductionDetailRequest $request, $idDeduction) {
        DB::insert('insert into DeductionDetail(price, cause, amount, idDeduction, idItem) values(?, ?, ?, ?, ?)', [
            $request->input('price'),
            $request->input('cause'),
            $request->input('amount'),
            $idDeduction,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        $this->setTotalMoney($idDeduction);
        return redirect('/deductions/'.$idDeduction);
    }
    public function edit($idDeductionDetail, $idDeduction) {
        $deductionDetail = DB::table('Item')->join('DeductionDetail', 'Item.idItem', '=', 'DeductionDetail.idItem')
        ->where('idDeductionDetail', $idDeductionDetail)->first();
        $items = DB::select('select * from Item where type = "equipment"');
        return view('deduction.edit-deductionDetail', ['deductionDetail'=>$deductionDetail, 'items'=>$items, 'idDeduction'=>$idDeduction]);
    }
    public function update(DeductionDetailRequest $request, $idDeductionDetail, $idDeduction) {
        DB::update('update DeductionDetail set price = ?, cause = ?, amount = ?, idDeduction = ?, idItem = ? where idDeductionDetail = ?', [
            $request->input('price'),
            $request->input('cause'),
            $request->input('amount'),
            $idDeduction,
            $request->input('item'),
            $idDeductionDetail
        ]);
        $this->setTotalMoney($idDeduction);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-deductions_detail/'.$idDeductionDetail.'/deduction/'.$idDeduction);
    }
    public function destroy($idDeductionDetail, $idDeduction) {
        DB::delete('delete from DeductionDetail where idDeductionDetail = ?', [$idDeductionDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        $this->setTotalMoney($idDeduction);
        return redirect('/deductions/'.$idDeduction);
    }
}
