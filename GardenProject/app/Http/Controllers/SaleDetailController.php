<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SaleDetailRequest;

class SaleDetailController extends Controller
{
    public function store(SaleDetailRequest $request, $idSale) {
        DB::insert('insert into SaleDetail(amount, total_price, price_per_product, idSale, idProduct) values(?, ?, ?, ?, ?)', [
            $request->input('amount'),
            $request->input('total_price'),
            $request->input('price_per_product'),
            $idSale,
            $request->input('product'),
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อย');
        return redirect('/sales/'.$idSale);
    }
    public function edit($idSaleDetail, $idSale) {
        $saleDetail = DB::table('Product')->join('SaleDetail', 'Product.idProduct', '=', 'SaleDetail.idProduct')
            ->where('idSaleDetail', $idSaleDetail)->first();
        $products = DB::select('select * from Product');
        return view('sale.edit-saleDetail', ['saleDetail'=>$saleDetail, 'products'=>$products, 'idSale'=>$idSale]);
    }
    public function update(SaleDetailRequest $request, $idSaleDetail, $idSale) {
        DB::update('update SaleDetail set amount = ?, total_price = ?, price_per_product = ?, idSale = ?, idProduct = ? where idSaleDetail = ?', [
            $request->input('amount'),
            $request->input('total_price'),
            $request->input('price_per_product'),
            $idSale,
            $request->input('product'),
            $idSaleDetail
        ]);
        session()->flash('edited', 'แก้ไข เรียบร้อย');
        return redirect('/edit-sales_detail/'.$idSaleDetail.'/sale/'.$idSale);
    }  
    public function destroy($idSaleDetail, $idSale) {
        DB::delete('delete from SaleDetail where idSaleDetail = ?', [$idSaleDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อย');
        return redirect('/sales/'.$idSale);
    }
}
