<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
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
    public function index()
    {
        $purchases = DB::select('select * from purchase natural join shop order by idPurchase desc');
        return view('purchase.list-purchase', ['purchases'=>$purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = DB::select('select * from shop');
        return view('purchase.add-purchase', ['shops'=>$shops]);    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        DB::insert('insert into purchase(date_order, date_pay, date_get, time_order, time_pay, time_get, total_money, status_claim, status_payment, status_receipt, idShop) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('date_order'),
            $request->input('date_pay'),
            $request->input('date_get'),
            $request->input('time_order'),
            $request->input('time_pay'),
            $request->input('time_get'),
            0,
            $request->input('status_claim'),
            "notpaid",
            "unreceipted",
            $request->input('shop'),
        ]);
        session()->flash('added', 'เพิ่มการสั่งซื้อ เรียบร้อยแล้ว');
        return redirect('/purchases');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = DB::select('select * from item');
        $purchasesDetail = DB::table('Item')
        ->join('PurchaseDetail', 'Item.idItem', '=', 'PurchaseDetail.idItem')
        ->where('idPurchase', $id)
        ->get();
        return view('purchase.detail-purchase', ['idPurchase'=>$id, 'items'=>$items, 'purchasesDetail'=>$purchasesDetail]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = DB::select('select * from purchase natural join shop where idPurchase = ?', [$id]);
        $shops = DB::select('select * from shop');
        return view('purchase.edit-purchase', ['purchase'=>$purchase[0], 'shops'=>$shops]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseRequest $request, $id)
    {
        DB::update('update purchase set date_order = ?, date_pay = ?, date_get = ?, time_order = ?, time_pay = ?, time_get = ?, status_claim = ?, idShop = ? where idPurchase = ?', [
            $request->input('date_order'),
            $request->input('date_pay'),
            $request->input('date_get'),
            $request->input('time_order'),
            $request->input('time_pay'),
            $request->input('time_get'),
            $request->input('status_claim'),
            $request->input('shop'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการสั่งซื้อ เรียบร้อยแล้ว');
        return redirect('/purchases/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from purchase where idPurchase = ?', [$id]);
        session()->flash('deleted', 'ลบการสั่งซื้อ เรียบร้อยแล้ว');
        return redirect('/purchases');
    }
}
