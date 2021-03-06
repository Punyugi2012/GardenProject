<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\HarvestRequest;

class HarvestController extends Controller
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
        $harvests = DB::table('Harvest')->join('Assignment', 'Harvest.idAssignment', '=', 'Assignment.idAssignment')
            ->join('Product', 'Harvest.idProduct', '=', 'Product.idProduct')->get(); 
        return view('harvest.list-harvest', ['harvests'=>$harvests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignments = DB::table('Assignment')->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')
            ->where('AssignmentType.name', 'like', 'เก็บเกี่ยว%')->get();
        $products = DB::select('select * from Product');
        return view('harvest.add-harvest', ['assignments'=>$assignments, 'products'=>$products]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HarvestRequest $request)
    {
        DB::insert('insert into Harvest(amount, date_harvest, time_harvest, idAssignment, idProduct) values(?, ?, ?, ?, ?)', [
            $request->input('amount'),
            $request->input('date'),
            $request->input('time'),
            $request->input('assignment'),
            $request->input('product'),
        ]);
        $this->calculateAmountStock($request->input('product'));
        session()->flash('added', 'เพิ่มการเก็บเกี่ยว เรียบร้อยแล้ว');
        return redirect('/harvests');
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
        $harvest = DB::table('Harvest')->join('Assignment', 'Harvest.idAssignment', '=', 'Assignment.idAssignment')
        ->join('Product', 'Harvest.idProduct', '=', 'Product.idProduct')->where('idHarvest', $id)->first();
        $assignments = DB::table('Assignment')->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')
            ->where('AssignmentType.name', 'like', 'เก็บเกี่ยว%')->get();
        $products = DB::select('select * from Product');
        return view('harvest.edit-harvest', ['harvest'=>$harvest, 'assignments'=>$assignments, 'products'=>$products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HarvestRequest $request, $id)
    {
        DB::update('update Harvest set amount = ?, date_harvest = ?, time_harvest = ?, idAssignment = ?, idProduct = ? where idHarvest = ?', [
            $request->input('amount'),
            $request->input('date'),
            $request->input('time'),
            $request->input('assignment'),
            $request->input('product'),
            $id
        ]);
        $this->calculateAmountStock($request->input('product'));
        session()->flash('edited', 'แก้ไขการเก็บเกี่ยว เรียบร้อยแล้ว');
        return redirect('/harvests/'.$id.'/edit');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idProduct = DB::table('Harvest')->where('idHarvest', $id)->first()->idProduct;
        DB::delete('delete from Harvest where idHarvest = ?', [$id]);
        $this->calculateAmountStock($idProduct);
        session()->flash('deleted', 'ลบการเก็บเกี่ยว เรียบร้อยแล้ว');
        return redirect('/harvests');
    }
}
