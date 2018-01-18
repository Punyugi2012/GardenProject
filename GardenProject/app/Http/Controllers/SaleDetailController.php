<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SaleDetailRequest;

class SaleDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function calculateAmountStock($productId) {
        $sumSaleDetail = DB::table('SaleDetail')->where('idProduct', $productId)->groupBy('idProduct')->sum('SaleDetail.amount');
        $sumHarvest = DB::table('Harvest')->where('idProduct', $productId)->groupBy('idProduct')->sum('Harvest.amount');
        if($sumHarvest >= $sumSaleDetail) {
            $sumHarvest -= $sumSaleDetail;
        }
        else {
            $sumHarvest = 0; 
        }
        DB::update('update Product set amount_stock = ? where idProduct = ?', [$sumHarvest, $productId]);
    }
    public function store(SaleDetailRequest $request, $idSale) {
        $product = DB::table('Product')->where('idProduct', $request->input('product'))->first();
        $total = $product->price_per_product * $request->input('amount');
        DB::insert('insert into SaleDetail(amount, total_price, price_per_product, idSale, idProduct) values(?, ?, ?, ?, ?)', [
            $request->input('amount'),
            $total,
            $product->price_per_product,
            $idSale,
            $request->input('product'),
        ]);
        $this->calculateAmountStock($request->input('product'));
        session()->flash('added', 'เพิ่ม เรียบร้อย');
        return redirect('/sales/'.$idSale);
    } 
    public function destroy($idSaleDetail, $idSale) {
        $idProduct = DB::table('SaleDetail')->where('idSaleDetail', $idSaleDetail)->first()->idProduct;
        DB::delete('delete from SaleDetail where idSaleDetail = ?', [$idSaleDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อย');
        $this->calculateAmountStock($idProduct);
        return redirect('/sales/'.$idSale);
    }
}
