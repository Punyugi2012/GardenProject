<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;

class ShopController extends Controller
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
        $shops = DB::select('select * from shop order by idShop desc');
        return view('shop.list-shop', ['shops'=>$shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shop.add-shop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {
        DB::insert('insert into shop(name, address, phone, account_number) values (?, ?, ?, ?)', [
            $request->input('name'),
            $request->input('address'),
            $request->input('phone'),
            $request->input('account_number')
        ]);
        session()->flash('added', 'เพิ่มร้านค้า เรียบร้อยแล้ว');
        return redirect('/shops');
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
        $shop = DB::select('select * from shop where idShop = ?', [$id]);
        return view('shop.edit-shop', ['shop'=>$shop[0]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequest $request, $id)
    {
        DB::update('update shop set name = ?, address = ?, phone = ?, account_number = ? where idShop = ?', [
            $request->input('name'),
            $request->input('address'),
            $request->input('phone'),
            $request->input('account_number'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขร้านค้า เรียบร้อยแล้ว');
        return redirect('/shops/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from shop where idShop = ?', [$id]);
        session()->flash('deleted', 'ลบร้านค้า เรียบร้อยแล้ว');
        return redirect('/shops');
    }
}
