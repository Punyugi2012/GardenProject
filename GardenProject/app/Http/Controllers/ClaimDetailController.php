<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ClaimDetailRequest;

class ClaimDetailController extends Controller
{
    public function store(ClaimDetailRequest $request, $idClaim) {
        DB::insert('insert into ClaimDetail(amount, cause, idClaim, idItem) values(?, ?, ?, ?)', [
            $request->input('amount'),
            $request->input('cause'),
            $idClaim,
            $request->input('item'),
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/claims/'.$idClaim);
    }
    public function destroy($idClaimDetail, $idClaim) {
        DB::delete('delete from ClaimDetail where idClaimDetail = ?', [$idClaimDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/claims/'.$idClaim);
    }
    public function edit($idClaimDetail, $idClaim) {
        $claimDetail = DB::table('Item')->join('ClaimDetail', 'Item.idItem', '=', 'ClaimDetail.idItem')->where('idClaimDetail', $idClaimDetail)->first();
        $items = DB::select('select * from item');
        return view('claim.edit-claimDetail', ['claimDetail'=>$claimDetail, 'items'=>$items, 'idClaim'=>$idClaim]);
    }
    public function update(ClaimDetailRequest $request, $idClaimDetail,  $idClaim) {
        DB::update('update ClaimDetail set amount = ?, cause = ?, idClaim = ?, idItem = ?', [
            $request->input('amount'),
            $request->input('cause'),
            $idClaim,
            $request->input('item'),
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-claims_detail/'.$idClaimDetail.'/claim/'.$idClaim);
    }
}
