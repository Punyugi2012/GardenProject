<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ClaimDetailRequest;

class ClaimDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(ClaimDetailRequest $request, $idClaim) {
        DB::insert('insert into ClaimDetail(amount, cause, idClaim, idItem) values(?, ?, ?, ?)', [
            $request->input('amount'),
            $request->input('cause'),
            $idClaim,
            $request->input('item'),
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect("/claims/{$idClaim}?purchase={$request->input('purchase')}");
    }
    public function destroy(Request $request, $idClaimDetail, $idClaim) {
        DB::delete('delete from ClaimDetail where idClaimDetail = ?', [$idClaimDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect("/claims/{$idClaim}?purchase={$request->input('purchase')}");
    }
    public function edit(Request $request, $idClaimDetail, $idClaim) {
        $claimDetail = DB::table('Item')->join('ClaimDetail', 'Item.idItem', '=', 'ClaimDetail.idItem')->where('idClaimDetail', $idClaimDetail)->first();
        $items = DB::select('select * from item');
        return view('claim.edit-claimDetail', ['claimDetail'=>$claimDetail, 'items'=>$items, 'idClaim'=>$idClaim, 'purchase'=>$request->input('purchase')]);
    }
    public function update(ClaimDetailRequest $request, $idClaimDetail,  $idClaim) {
        DB::update('update ClaimDetail set amount = ?, cause = ?, idClaim = ?, idItem = ? where idClaimDetail = ?', [
            $request->input('amount'),
            $request->input('cause'),
            $idClaim,
            $request->input('item'),
            $idClaimDetail
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return back();
    }
}
