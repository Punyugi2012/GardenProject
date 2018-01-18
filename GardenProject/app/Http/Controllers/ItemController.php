<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
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
        $items = DB::select('select * from item');
        foreach($items as $item) {
            $hasPurchaseDetail = DB::table('PurchaseDetail')->where('idItem', $item->idItem)->first();
            $hasReceiptDetail = DB::table('ReceivingDetail')->where('idItem', $item->idItem)->first();
            $hasClaimDetail = DB::table('ClaimDetail')->where('idItem', $item->idItem)->first();
            $hasReceiptClaimDetail = DB::table('ReceivingClaimDetail')->where('idItem', $item->idItem)->first();
            $hasTakeDetail = DB::table('TakeDetail')->where('idItem', $item->idItem)->first();
            $hasReturningDetail = DB::table('RevertingDetail')->where('idItem', $item->idItem)->first();
            $hasDeductionDetail = DB::table('DeductionDetail')->where('idItem', $item->idItem)->first();
            if( $hasPurchaseDetail || $hasReceiptDetail || $hasClaimDetail || $hasReceiptClaimDetail || $hasTakeDetail || $hasReturningDetail || $hasDeductionDetail) {
                $item->canDelete = false;
            }
            else {
                $item->canDelete = true;
            }
        }
        return view('item.list-item', ['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item.add-item');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        DB::insert('insert into item(name, amount, type, price_per_item) values (?, ?, ?, ?)', [
            $request->input('name'),
            0,
            $request->input('type'),
            $request->input('price_per_item')
        ]);
        session()->flash('added', 'เพิ่มวัตถุดิบ เรียบร้อยแล้ว');
        return redirect('/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = DB::select('select * from item where idItem = ?', [$id]);
        
        return view('item.edit-item', ['item'=>$item[0]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        $amount = DB::table('Item')->where('idItem', $id)->first()->amount;
        $amount += (int)$request->input('inAmount');
        if((int)$request->input('deAmount') <= $amount) {
            $amount -= (int)$request->input('deAmount');
        }
        DB::update('update item set name = ?, amount = ?, type = ?, price_per_item = ? where idItem = ?', [
            $request->input('name'),
            $amount,
            $request->input('type'),
            $request->input('price_per_item'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขวัตถุดิบ เรียบร้อยแล้ว');
        return redirect('/items/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from item where idItem = ?', [$id]);
        session()->flash('deleted', 'ลบวัตถุ เรียบร้อยแล้ว');
        return redirect('/items');
    }
}
