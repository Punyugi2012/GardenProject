<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptDetailRequest;

class ReceiptDetailController extends Controller
{
    public function store(ReceiptDetailRequest $request, $idReceipt) {
        DB::insert('insert into ReceivingDetail(amount, idReceiving, idItem) values(?, ?, ?)', [
            $request->input('amount'),
            $idReceipt,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/receipts/'.$idReceipt);
    }
    public function destroy($idReceiptDetail, $idReceipt) {
        DB::delete('delete from ReceivingDetail where idReceivingDetail = ?', [$idReceiptDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/receipts/'.$idReceipt);
    }
    public function edit($idReceiptDetail, $idReceipt) {
        $receiptDetail = DB::table('Item')
        ->join('ReceivingDetail', 'Item.idItem', '=', 'ReceivingDetail.idItem')
        ->where('idReceivingDetail', $idReceiptDetail)
        ->first();
        $items = DB::select('select * from item');
        return view('receipt.edit-receiptDetail', ['receiptDetail'=>$receiptDetail, 'items'=>$items, 'idReceipt'=>$idReceipt]);
    }
    public function update(ReceiptDetailRequest $request, $idReceiptDetail, $idReceipt) {
        DB::update('update ReceivingDetail set amount = ?, idReceiving = ?, idItem = ? where idReceivingDetail = ?', [
            $request->input('amount'),
            $idReceipt,
            $request->input('item'),
            $idReceiptDetail
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-receipt_detail/'.$idReceiptDetail.'/receipt/'.$idReceipt);
    }
}
