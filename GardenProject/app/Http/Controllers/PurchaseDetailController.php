<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseDetailRequest;

class PurchaseDetailController extends Controller
{
    public function store(PurchaseDetailRequest $request, $idPurchase) {
        $item = DB::select('select * from item where idItem = ?', [$request->input('item')]);
        $total_money = $item[0]->price_per_item * $request->input('amount');
        DB::insert('insert into purchasedetail(amount, total_money, idPurchase, idItem) values(?, ?, ?, ?)', [
            $request->input('amount'),
            $total_money,
            $idPurchase,
            $request->input('item')
        ]);
        session()->flash('added', 'เพิ่มเรียบร้อยแล้ว');
        return redirect('/purchases/'.$idPurchase);
    }
    public function destroy($idPurchaseDetail, $idPurchase) {
        DB::delete('delete from purchasedetail where idPurchaseDetail = ?', [$idPurchaseDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/purchases/'.$idPurchase);
    }
}
