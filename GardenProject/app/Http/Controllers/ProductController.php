<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::select('select * from Product'); 
        foreach($products as $product) {
            $this->calculateAmountStock($product->idProduct);
            $hasHarvest = DB::table('Harvest')->where('idProduct', $product->idProduct)->first();
            $hasSaleDetail =  DB::table('SaleDetail')->where('idProduct', $product->idProduct)->first();
            if($hasHarvest || $hasSaleDetail) {
                $product->canDelete = false;
            }
            else {
                $product->canDelete = true;
            }
        }
        return view('product.list-product', ['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.add-product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::insert('insert into Product(name, price_per_product, amount_stock) values(?, ?, ?)', [
            $request->input('name'),
            $request->input('price_per_product'),
            0
        ]);
        session()->flash('added', 'เพิ่มผลผลิต เรียบร้อยแล้ว');
        return redirect('/products');
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
        $product = DB::table('Product')->where('idProduct', $id)->first();
        return view('product.edit-product', ['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        DB::update('update Product set name = ?, price_per_product = ? where idProduct = ?', [
            $request->input('name'),
            $request->input('price_per_product'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขผลผลิต เรียบร้อยแล้ว');
        return redirect('/products/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from Product where idProduct = ?', [$id]);
        session()->flash('deleted', 'ลบผลิต เรียบร้อยแล้ว');
        return redirect('/products');
    }
}
