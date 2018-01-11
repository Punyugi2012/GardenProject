<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptClaimRequest;

class ReceiptClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receiptclaims = DB::table('Claim')->join('ReceivingClaim', 'Claim.idClaim', '=', 'ReceivingClaim.idClaim')->get();
        return view('receiptclaim.list-receiptclaim', ['receiptclaims'=>$receiptclaims]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()    
    {
        $claims = DB::select('select * from claim where status = "unsuccess"');
        return view('receiptclaim.add-receiptclaim', ['claims'=>$claims]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptClaimRequest $request)
    {
        DB::insert('insert into ReceivingClaim(date, time, idClaim) values(?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            $request->input('claim'),
        ]);
        session()->flash('added', 'เพิ่มการรับจากการเคลม เรียบร้อยแล้ว');
        return redirect('/receiptclaims');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receiptclaimsDetail = DB::table('Item')->join('ReceivingClaimDetail', 'Item.idItem', '=', 'ReceivingClaimDetail.idItem')->where('idReceivingClaim', $id)->get();
        $idClaim = DB::table('ReceivingClaim')->where('idReceivingClaim', $id)->first()->idClaim;
        $claimsDetail = DB::table('Item')->join('ClaimDetail', 'Item.idItem', '=', 'ClaimDetail.idItem')->where('idClaim', $idClaim)->get();
        return view('receiptclaim.detail-receiptclaim', ['receiptclaimsDetail'=>$receiptclaimsDetail, 'claimsDetail'=>$claimsDetail, 'idReceiptClaim'=>$id]);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receiptclaim = DB::table('ReceivingClaim')->join('Claim', 'ReceivingClaim.idClaim', '=', 'Claim.idClaim')->where('idReceivingClaim', $id)->first();
        $claims = DB::select('select * from claim where status = "unsuccess"');
        return view('receiptclaim.edit-receiptclaim', ['receiptclaim'=>$receiptclaim, 'claims'=>$claims]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReceiptClaimRequest $request, $id)
    {
        DB::update('update ReceivingClaim set date = ?, time = ?, idClaim = ? where idReceivingClaim = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('claim'),    
            $id
        ]);
        session()->flash('edited', 'แก้ไขการรับจากการเคลม เรียบร้อยแล้ว');
        return redirect('/receiptclaims/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from ReceivingClaim where idReceivingClaim = ?', [$id]);
        session()->flash('deleted', 'ลบการรับจากการเคลม เรียบร้อยแล้ว');
        return redirect('/receiptclaims');
    }
}
