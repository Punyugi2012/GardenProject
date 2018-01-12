<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseDetailRequest;

class PurchaseDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function sumTotalMoney($idPurchase) {
        $sum = DB::table('PurchaseDetail')->where('idPurchase', $idPurchase)->sum('total_money');
        DB::update('update Purchase set total_money = ? where idPurchase = ?', [$sum, $idPurchase]);
    }
    public function store(PurchaseDetailRequest $request, $idPurchase) {
        $item = DB::select('select * from item where idItem = ?', [$request->input('item')]);
        $total_money = $item[0]->price_per_item * $request->input('amount');
        DB::insert('insert into purchasedetail(amount, total_money, idPurchase, idItem) values(?, ?, ?, ?)', [
            $request->input('amount'),
            $total_money,
            $idPurchase,
            $request->input('item')
        ]);
        $this->sumTotalMoney($idPurchase);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/purchases/'.$idPurchase);
    }
    public function destroy($idPurchaseDetail, $idPurchase) {
        DB::delete('delete from purchasedetail where idPurchaseDetail = ?', [$idPurchaseDetail]);
        $this->sumTotalMoney($idPurchase);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/purchases/'.$idPurchase);
    }
    public function edit($idPurchaseDetail, $idPurchase) {
        $items = DB::select('select * from item');
        $purchaseDetail = DB::table('Item')
        ->join('PurchaseDetail', 'Item.idItem', '=', 'PurchaseDetail.idItem')
        ->where('idPurchaseDetail', $idPurchaseDetail)
        ->first();
        return view('purchase.edit-purchaseDetail', ['items'=>$items, 'purchaseDetail'=>$purchaseDetail, 'idPurchase'=>$idPurchase]);
    }
    public function update(PurchaseDetailRequest $request, $idPurchaseDetail, $idPurchase) {
        $item = DB::table('Item')->where('idItem', $request->input('item'))->first();
        $total_money = $item->price_per_item * $request->input('amount');
        DB::table('PurchaseDetail')
            ->where('idPurchaseDetail', $idPurchaseDetail)
            ->update([
                'amount'=>$request->input('amount'),
                'total_money'=>$total_money,
                'idPurchase'=>$idPurchase,
                'idItem'=>$request->input('item')
            ]);
        $this->sumTotalMoney($idPurchase); 
        session()->flash('edited', 'แก้ไข เรียบร้อยแล้ว');
        return redirect('/edit-purchases_detail/'.$idPurchaseDetail.'/purchase/'.$idPurchase);
    }
}
