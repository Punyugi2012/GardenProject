<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptClaimRequest;

class ReceiptClaimController extends Controller
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

        $receiptclaims = DB::table('ReceivingClaim')->where('idClaim', $request->input('claim'))->get();
        $status = DB::table('claim')->where('idClaim', $request->input('claim'))->first()->status;
        return view('receiptclaim.list-receiptclaim', ['receiptclaims'=>$receiptclaims, 'claim'=>$request->input('claim'), 'purchase'=>$request->input('purchase'), 'status'=>$status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)    
    {
        $claim = DB::table('Claim')->where('idClaim', $request->input('claim'))->first();
        return view('receiptclaim.add-receiptclaim', ['claim'=>$claim, 'purchase'=>$request->input('purchase')]);
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
        return redirect("/receiptclaims?claim={$request->input('claim')}&purchase={$request->input('purchase')}");
    }
    private function isClaimSuccess($items) {
        foreach($items as $item) {
            if($item['amount'] > 0) {
                return false;
            }
        }
        return true;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $receiptclaimsDetail = DB::table('Item')->join('ReceivingClaimDetail', 'Item.idItem', '=', 'ReceivingClaimDetail.idItem')->where('idReceivingClaim', $id)->get();
        $itemClaims = DB::table('Item')->join('ClaimDetail', 'Item.idItem', 'ClaimDetail.idItem')->where('idClaim', $request->input('claim'))->get();
        $itemReceipts = DB::table('ReceivingClaimDetail')->join('Item', 'ReceivingClaimDetail.idItem', '=', 'Item.idItem')
            ->join('ReceivingClaim', 'ReceivingClaimDetail.idReceivingClaim', '=', 'ReceivingClaim.idReceivingClaim')
            ->where('idClaim', $request->input('claim'))
            ->groupBy('Item.name')->selectRaw('name, sum(ReceivingClaimDetail.amount) as amount')->get();
        
        $items = [];
        foreach($itemClaims as $itemClaim) {
            $found = false;
            foreach($itemReceipts as $itemReceipt) {
                if($itemClaim->name == $itemReceipt->name) {
                    array_push($items, ['idItem'=>$itemClaim->idItem, 'name'=>$itemClaim->name, 'amount'=>$itemClaim->amount - $itemReceipt->amount]);
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                array_push($items, ['idItem'=>$itemClaim->idItem, 'name'=>$itemClaim->name, 'amount'=>$itemClaim->amount]);
            }
        }
        if($this->isClaimSuccess($items)) {
            DB::update('update Claim set status = "success" where idClaim = ?', [$request->input('claim')]);
        }
        else {
            DB::update('update Claim set status = "unsuccess" where idClaim = ?', [$request->input('claim')]);
        }
        return view('receiptclaim.detail-receiptclaim', ['receiptclaimsDetail'=>$receiptclaimsDetail, 'items'=>$items, 'idReceiptClaim'=>$id, 'claim'=>$request->input('claim'), 'purchase'=>$request->input('purchase')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $receiptclaim = DB::table('ReceivingClaim')->where('idReceivingClaim', $id)->first();
        $claim =  DB::table('Claim')->where('idClaim', $request->input('claim'))->first();
        return view('receiptclaim.edit-receiptclaim', ['receiptclaim'=>$receiptclaim, 'claim'=>$claim, 'purchase'=>$request->input('purchase')]); 
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
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::delete('delete from ReceivingClaim where idReceivingClaim = ?', [$id]);
        $itemClaims = DB::table('Item')->join('ClaimDetail', 'Item.idItem', 'ClaimDetail.idItem')->where('idClaim', $request->input('claim'))->get();
        $itemReceipts = DB::table('ReceivingClaimDetail')->join('Item', 'ReceivingClaimDetail.idItem', '=', 'Item.idItem')
            ->join('ReceivingClaim', 'ReceivingClaimDetail.idReceivingClaim', '=', 'ReceivingClaim.idReceivingClaim')
            ->where('idClaim', $request->input('claim'))
            ->groupBy('Item.name')->selectRaw('name, sum(ReceivingClaimDetail.amount) as amount')->get();
        
        $items = [];
        foreach($itemClaims as $itemClaim) {
            $found = false;
            foreach($itemReceipts as $itemReceipt) {
                if($itemClaim->name == $itemReceipt->name) {
                    array_push($items, ['idItem'=>$itemClaim->idItem, 'name'=>$itemClaim->name, 'amount'=>$itemClaim->amount - $itemReceipt->amount]);
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                array_push($items, ['idItem'=>$itemClaim->idItem, 'name'=>$itemClaim->name, 'amount'=>$itemClaim->amount]);
            }
        }
        if($this->isClaimSuccess($items)) {
            DB::update('update Claim set status = "success" where idClaim = ?', [$request->input('claim')]);
        }
        else {
            DB::update('update Claim set status = "unsuccess" where idClaim = ?', [$request->input('claim')]);
        }
        session()->flash('deleted', 'ลบการรับจากการเคลม เรียบร้อยแล้ว');
        return redirect("/receiptclaims?claim={$request->input('claim')}&purchase={$request->input('purchase')}");
    }
}
