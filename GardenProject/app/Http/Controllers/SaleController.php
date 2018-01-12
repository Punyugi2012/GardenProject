<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;

class SaleController extends Controller
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
        $sales = DB::select('select * from Sale');
        return view('sale.list-sale', ['sales'=>$sales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.add-sale');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        DB::insert('insert into Sale(date, time, total_money) values(?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            0
        ]);
        session()->flash('added', 'เพิ่มการขาย เรียบร้อยแล้ว');
        return redirect('/sales');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salesDetail = DB::table('Product')->join('SaleDetail', 'Product.idProduct', '=', 'SaleDetail.idProduct')
            ->where('idSale', $id)->get();
        $products = DB::select('select * from Product');
        return view('sale.detail-sale', ['salesDetail'=>$salesDetail, 'products'=>$products, 'idSale'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = DB::table('Sale')->where('idSale', $id)->first();
        return view('sale.edit-sale', ['sale'=>$sale]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleRequest $request, $id)
    {
        DB::update('update Sale set date = ?, time = ? where idSale = ?', [
            $request->input('date'),
            $request->input('time'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการขาย เรียบร้อยแล้ว');
        return redirect('/sales/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from Sale where idSale = ?', [$id]);
        session()->flash('deleted', 'ลบการขาย เรียบร้อยแล้ว');
        return redirect('/sales');
    }
}
