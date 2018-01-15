<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptRequest;

class ReceiptController extends Controller
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
        $receipts = DB::table('receiving')->where('idPurchase', $request->input('purchase'))->get();
        return view('receipt.list-receipt', ['receipts'=>$receipts, 'purchase'=>$request->input('purchase')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $purchase = DB::table('Purchase')->where('idPurchase', $request->input('purchase'))->first();
        return view('receipt.add-receipt', ['purchase'=>$purchase]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptRequest $request)
    {
        DB::insert('insert into receiving(date, time, idPurchase) values (?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            $request->input('purchase'),
        ]);
        DB::update('update Purchase set status_receipt = "receipted" where idPurchase = ?', [$request->input('purchase')]);
        session()->flash('added', 'เพิ่มการรับวัตถุดิบ เรียบร้อยแล้ว');
        return redirect("/receipts?purchase={$request->input('purchase')}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $receiptsDetail = DB::table('Item')->join('ReceivingDetail', 'Item.idItem', '=', 'ReceivingDetail.idItem')
                        ->where('idReceiving', $id)->get();
        $idPurchase = DB::table('Receiving')->where('idReceiving',$id)->first()->idPurchase;
        $purchasesDetail = DB::table('Item')->join('PurchaseDetail', 'Item.idItem', '=','PurchaseDetail.idItem')->where('idPurchase', $idPurchase)->get();
        return view('receipt.detail-receipt', ['receiptsDetail'=>$receiptsDetail, 'purchasesDetail'=>$purchasesDetail, 'idReceipt'=>$id, 'purchase'=>$request->input('purchase')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $receipt = DB::table('receiving')->join('purchase', 'receiving.idPurchase', '=', 'purchase.idPurchase')
                ->where('idReceiving', $id)->first();
        $purchase = DB::table('Purchase')->where('idPurchase', $request->input('purchase'))->first();
        return view('receipt.edit-receipt', ['receipt'=>$receipt, 'purchase'=>$purchase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReceiptRequest $request, $id)
    {
        DB::update('update receiving set date = ?, time = ?, idPurchase = ?  where idReceiving = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('purchase'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการรับวัตถุดิบ เรียบร้อยแล้ว');
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
        $idPurchase = DB::table('Receiving')->where('idReceiving', $id)->first()->idPurchase;
        DB::update('update Purchase set status_receipt = "unreceipted" where idPurchase = ?', [$idPurchase]);
        DB::delete('delete from receiving where idReceiving = ?', [$id]);
        session()->flash('deleted', 'ลบการรับวัตถุดิบ เรียบร้อยแล้ว');
        return redirect('/receipts');
    }
}
