<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReceiptRequest;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = DB::table('receiving')->join('purchase', 'receiving.idPurchase', '=', 'purchase.idPurchase')->get();
        return view('receipt.list-receipt', ['receipts'=>$receipts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchases = DB::select('select * from purchase where status_receipt = "unreceipted"');
        return view('receipt.add-receipt', ['purchases'=>$purchases]);
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
        session()->flash('added', 'เพิ่มการรับวัตถุ เรียบร้อยแล้ว');
        return redirect('/receipts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receiptsDetail = DB::table('Item')->join('ReceivingDetail', 'Item.idItem', '=', 'ReceivingDetail.idItem')
                        ->where('idReceiving', $id)->get();
        $idPurchase = DB::table('Receiving')->where('idReceiving',$id)->first()->idPurchase;
        $purchasesDetail = DB::select('select * from PurchaseDetail where idPurchase = ?', [$idPurchase]);
        foreach($purchasesDetail as $detail) {
            $detail->name = DB::table('Item')->where('idItem', $detail->idItem)->first()->name;
        }
        return view('receipt.detail-receipt', ['receiptsDetail'=>$receiptsDetail, 'purchasesDetail'=>$purchasesDetail, 'idReceipt'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receipt = DB::table('receiving')->join('purchase', 'receiving.idPurchase', '=', 'purchase.idPurchase')
                ->where('idReceiving', $id)->first();
        $purchases = DB::select('select * from purchase');
        return view('receipt.edit-receipt', ['receipt'=>$receipt, 'purchases'=>$purchases]);
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
        session()->flash('edited', 'แก้ไขการรับวัตถุ เรียบร้อยแล้ว');
        return redirect('/receipts/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from receiving where idReceiving = ?', [$id]);
        session()->flash('deleted', 'ลบการรับวัตถุดิบ เรียบร้อยแล้ว');
        return redirect('/receipts');
    }
}
