<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentDetailRequest;

class PaymentDetailController extends Controller
{
    public function store(PaymentDetailRequest $request, $idPayment) {
        DB::insert('insert into Paydetail(amount_money, idPay, idPurchase) values(?, ?, ?)', [
            $request->input('amount_money'),
            $idPayment,
            $request->input('purchase')
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/payments/'.$idPayment);
    }
    public function edit($idPaymentDetail, $idPayment) {
        $paymentDetail = DB::table('PayDetail')->join('Purchase', 'PayDetail.idPurchase', '=', 'Purchase.idPurchase')->where('idPayDetail', $idPaymentDetail)->first();
        $purchases = DB::select('select * from purchase');
        return view('payment.edit-paymentDetail', ['paymentDetail'=>$paymentDetail, 'purchases'=>$purchases, 'idPayment'=>$idPayment]);
    }
    public function update(PaymentDetailRequest $request, $idPaymentDetail, $idPayment ) {
        DB::update('update PayDetail set amount_money = ?, idPay = ?, idPurchase = ? where idPayDetail = ?', [
            $request->input('amount_money'),
            $idPayment,
            $request->input('purchase'),
            $idPaymentDetail
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-payments_detail/'.$idPaymentDetail.'/payment/'.$idPayment);
    }
    public function destroy($idPaymentDetail, $idPayment) {
        DB::delete('delete from PayDetail where idPayDetail = ?', [$idPaymentDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/payments/'.$idPayment);
    }
}
