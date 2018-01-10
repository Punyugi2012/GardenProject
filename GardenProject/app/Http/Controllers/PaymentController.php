<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = DB::table('pay')->join('shop', 'pay.idShop', '=', 'shop.idShop')->get();
        return view('payment.list-payment', ['payments'=>$payments]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = DB::select('select * from shop');
        return view('payment.add-payment', ['shops'=>$shops]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        DB::insert('insert into pay(date, time, type, idShop) values(?, ?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            $request->input('type'),
            $request->input('shop')
        ]);
        session()->flash('added', 'เพิ่มการจ่ายเงิน เรียบร้อยแล้ว');
        return redirect('/payments');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentsDetail = DB::table('PayDetail')->join('purchase', 'PayDetail.idPurchase', '=', 'purchase.idPurchase')->where('idPay', $id)->get();
        $payment = DB::table('Pay')->where('idPay', $id)->first();
        $purchases = DB::select('select * from purchase where idShop = ? and status_payment = "notpaid"', [$payment->idShop]);
        return view('payment.detail-payment', ['paymentsDetail'=>$paymentsDetail, 'purchases'=>$purchases, 'idPayment'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shops = DB::select('select * from shop');
        $payment = DB::table('pay')->join('shop', 'pay.idShop', '=', 'shop.idShop')->where('idPay', $id)->first();
        return view('payment.edit-payment', ['payment'=>$payment, 'shops'=>$shops]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, $id)
    {
        DB::update('update pay set date = ?, time = ?, type = ?, idShop = ? where idPay = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('type'),
            $request->input('shop'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการจ่ายเงิน เรียบร้อยแล้ว');
        return redirect('/payments/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from pay where idPay = ?', [$id]);
        session()->flash('deleted', 'ลบการจ่ายเงิน เรียบร้อยแล้ว');
        return redirect('/payments');
    }
}
