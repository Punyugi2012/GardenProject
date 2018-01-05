<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReturningDetailRequest;

class ReturningDetailController extends Controller
{
    public function store(ReturningDetailRequest $request, $idReturning) {
        DB::insert('insert into RevertingDetail(amount, cause, idReverting, idItem) values(?, ?, ?, ?)', [
            $request->input('amount'),
            $request->input('cause'),
            $idReturning,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/returnings/'.$idReturning);
    }
    public function destroy($idReturningDetail, $idReturning) {
        DB::delete('delete from RevertingDetail where idRevertingDetail = ?', [$idReturningDetail]);
        session()->flash('added', 'ลบ เรียบร้อยแล้ว');
        return redirect('/returnings/'.$idReturning);
    }
    public function edit($idReturningDetail, $idReturning) {
        $returningDetail = DB::table('Item')->join('RevertingDetail', 'Item.idItem', '=', 'RevertingDetail.idItem')
        ->where('idRevertingDetail', $idReturningDetail)->first();
        $items = DB::select('select * from Item where type="equipment"');
        return view('returning.edit-returningDetail', ['returningDetail'=>$returningDetail, 'items'=>$items, 'idReturning'=>$idReturning]);
        
    }
    public function update(ReturningDetailRequest $request, $idReturningDetail, $idReturning) {
        DB::update('update RevertingDetail set amount = ?, cause = ?, idReverting = ?, idItem = ? where idRevertingDetail = ?', [
            $request->input('amount'),
            $request->input('cause'),
            $idReturning,
            $request->input('item'),
            $idReturningDetail
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-returnings_detail/'.$idReturningDetail.'/returning/'.$idReturning);
    }
}
