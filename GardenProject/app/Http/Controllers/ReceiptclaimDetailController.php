<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptclaimDetailRequest;

class ReceiptclaimDetailController extends Controller
{
    public function store(ReceiptclaimDetailRequest $request, $idReceiptClaim) {
        DB::insert('insert into ReceivingClaimDetail(amount, idReceivingClaim, idItem) values(?, ?, ?)', [
            $request->input('amount'),
            $idReceiptClaim,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/receiptclaims/'.$idReceiptClaim);
    }
    public function edit($idReceiptclaimDetail, $idReceiptClaim) {
        $receiptclaimDetail = DB::table('Item')->join('ReceivingClaimDetail', 'Item.idItem', '=', 'ReceivingClaimDetail.idItem')->where('idReceivingClaimDetail', $idReceiptclaimDetail)->first();
        $items = DB::select('select * from item');
        return view('receiptclaim.edit-receiptclaimDetail', ['receiptclaimDetail'=>$receiptclaimDetail, 'items'=>$items, 'idReceiptClaim'=>$idReceiptClaim]);
    }
    public function update(ReceiptclaimDetailRequest $request, $idReceiptclaimDetail, $idReceiptClaim) {
        DB::update('update ReceivingClaimDetail set amount = ?, idReceivingClaim = ?, idItem = ? where idReceivingClaimDetail = ?', [
            $request->input('amount'),
            $idReceiptClaim,
            $request->input('item'),
            $idReceiptclaimDetail
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-receiptclaims_detail/'.$idReceiptclaimDetail.'/receiptclaim/'.$idReceiptClaim);
    }   
    public function destroy($idReceiptclaimDetail, $idReceiptClaim) {
        DB::delete('delete from ReceivingClaimDetail where idReceivingClaimDetail = ?', [$idReceiptclaimDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/receiptclaims/'.$idReceiptClaim);
    }
}
