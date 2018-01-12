<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SaleDetailRequest;

class SaleDetailController extends Controller
{
    private function setTotalMoney($idSale) {
        $sum = DB::table('SaleDetail')->where('idSale', $idSale)->sum('total_price');
        DB::update('update Sale set total_money = ? where idSale = ?', [$sum, $idSale]);
    }
    public function store(SaleDetailRequest $request, $idSale) {
        $total = $request->input('price_per_product') * $request->input('amount');
        DB::insert('insert into SaleDetail(amount, total_price, price_per_product, idSale, idProduct) values(?, ?, ?, ?, ?)', [
            $request->input('amount'),
            $total,
            $request->input('price_per_product'),
            $idSale,
            $request->input('product'),
        ]);
        $amount_stock = DB::table('Product')->where('idProduct', $request->input('product'))->first()->amount_stock;
        if($amount_stock >= $request->input('amount')) {
            $amount_stock -= $request->input('amount');
            DB::update('update Product set amount_stock = ? where idProduct = ?', [$amount_stock, $request->input('product')]);
        }
        $this->setTotalMoney($idSale);
        session()->flash('added', 'เพิ่ม เรียบร้อย');
        return redirect('/sales/'.$idSale);
    } 
    public function destroy($idSaleDetail, $idSale) {
        $saleDetail = DB::table('SaleDetail')->where('idSaleDetail', $idSaleDetail)->first();
        $amount_stock = DB::table('Product')->where('idProduct', $saleDetail->idProduct)->first()->amount_stock;
        $amount_stock += $saleDetail->amount;
        DB::update('update Product set amount_stock = ? where idProduct = ?', [$amount_stock, $saleDetail->idProduct]);
        DB::delete('delete from SaleDetail where idSaleDetail = ?', [$idSaleDetail]);
        $this->setTotalMoney($idSale);
        session()->flash('deleted', 'ลบ เรียบร้อย');
        return redirect('/sales/'.$idSale);
    }
}
