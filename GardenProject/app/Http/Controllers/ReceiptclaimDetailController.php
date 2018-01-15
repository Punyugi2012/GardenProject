<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptclaimDetailRequest;

class ReceiptclaimDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(ReceiptclaimDetailRequest $request, $idReceiptClaim) {
        DB::insert('insert into ReceivingClaimDetail(amount, idReceivingClaim, idItem) values(?, ?, ?)', [
            $request->input('amount'),
            $idReceiptClaim,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect("/receiptclaims/{$idReceiptClaim}?claim={$request->input('claim')}&purchase={$request->input('purchase')}");
    }   
    public function destroy(Request $request, $idReceiptclaimDetail, $idReceiptClaim) {
        DB::delete('delete from ReceivingClaimDetail where idReceivingClaimDetail = ?', [$idReceiptclaimDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect("/receiptclaims/{$idReceiptClaim}?claim={$request->input('claim')}&purchase={$request->input('purchase')}");
    }
}
