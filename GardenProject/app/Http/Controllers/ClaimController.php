<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ClaimRequest;

class ClaimController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $claims = DB::table('Claim')->where('idPurchase', $request->input('purchase'))->get();
        return view('claim.list-claim', ['claims'=>$claims, 'purchase'=>$request->input('purchase')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $purchase = DB::table('Purchase')->where('idPurchase', $request->input('purchase'))->first();
        return view('claim.add-claim', ['purchase'=>$purchase]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClaimRequest $request)
    {
        DB::insert('insert into claim(date_claim, date_get, time_claim, time_get, status, idPurchase) value(?, ?, ?, ?, ?, ?)', [
            $request->input('date_claim'),
            $request->input('date_get'),
            $request->input('time_claim'),
            $request->input('time_get'),
            "unsuccess",
            $request->input('purchase'),
        ]);
        session()->flash('added', 'เพิ่มการเคลม เรียบร้อยแล้ว');
        return redirect('/claims?purchase='.$request->input('purchase'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $claimsDetail = DB::table('item')->join('claimdetail', 'item.idItem', '=', 'claimdetail.idItem')->where('idClaim', $id)->get();
        $items = DB::table('Item')->join('PurchaseDetail', 'Item.idItem', '=','PurchaseDetail.idItem')
        ->where('type', 'equipment')
        ->where('idPurchase', $request->input('purchase'))->get();
        return view('claim.detail-claim', ['claimsDetail'=>$claimsDetail, 'items'=>$items, 'idClaim'=>$id, 'purchase'=>$request->input('purchase')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $claim = DB::table('Claim')->where('idClaim', $id)->first();
        $purchase = DB::table('Purchase')->where('idPurchase', $request->input('purchase'))->first();
        return view('claim.edit-claim', ['claim'=>$claim, 'purchase'=>$purchase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClaimRequest $request, $id)
    {
        DB::update('update claim set date_claim = ?, date_get = ?, time_claim = ?, time_get = ?, idPurchase = ? where idClaim = ?', [
            $request->input('date_claim'),
            $request->input('date_get'),
            $request->input('time_claim'),
            $request->input('time_get'),
            $request->input('purchase'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการเคลม เรียบร้อยแล้ว');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from claim where idClaim = ?', [$id]);
        session()->flash('deleted', 'ลบการเคลม เรียบร้อยแล้ว');
        return back();
    }
}
