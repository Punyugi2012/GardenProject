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
        return redirect('/receipts/'.$idReceipt);
    }
    public function destroy($idReceiptDetail, $idReceipt) {
        DB::delete('delete from ReceivingDetail where idReceivingDetail = ?', [$idReceiptDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/receipts/'.$idReceipt);
    }
}
