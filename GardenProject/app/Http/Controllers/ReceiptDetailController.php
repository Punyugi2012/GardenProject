<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptDetailRequest;

class ReceiptDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(ReceiptDetailRequest $request, $idReceipt) {
        DB::insert('insert into ReceivingDetail(amount, idReceiving, idItem) values(?, ?, ?)', [
            $request->input('amount'),
            $idReceipt,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        $currentAmount = DB::table('Item')->where('idItem', $request->input('item'))->first()->amount;
        $currentAmount += $request->input('amount');
        DB::update('update Item set amount = ? where idItem = ?', [$currentAmount, $request->input('item')]);
        return redirect("/receipts/{$idReceipt}?purchase={$request->input('purchase')}");
    }
    public function destroy(Request $request, $idReceiptDetail, $idReceipt) {
        $receiptDetail = DB::table('ReceivingDetail')->where('idReceivingDetail', $idReceiptDetail)->first();
        $currentAmount = DB::table('Item')->where('idItem', $receiptDetail->idItem)->first()->amount;
        if($receiptDetail->amount >= $currentAmount) {
            $currentAmount = 0;
        }
        else {
            $currentAmount -= $receiptDetail->amount;
        }
        DB::update('update Item set amount = ? where idItem = ?', [$currentAmount, $receiptDetail->idItem]);
        DB::delete('delete from ReceivingDetail where idReceivingDetail = ?', [$idReceiptDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect("/receipts/{$idReceipt}?purchase={$request->input('purchase')}");
    }
}
