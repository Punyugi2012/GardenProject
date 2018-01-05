<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TakeDetailRequest;

class TakeDetailController extends Controller
{
    public function store(TakeDetailRequest $request, $idTake) {
        DB::insert('insert into TakeDetail(amount, idTake, idItem) values(?, ?, ?)', [
            $request->input('amount'),
            $idTake,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/takes/'.$idTake);
    }
    public function destroy($idTakeDetail, $idTake) {
        DB::delete('delete from TakeDetail where idTakeDetail = ?', [$idTakeDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/takes/'.$idTake);
    }
}
