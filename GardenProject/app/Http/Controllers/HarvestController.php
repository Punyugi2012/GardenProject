<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

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
    private function addAmountStock($idProduct, $amount) {
        $currentAmount = DB::table('Product')->where('idProduct', $idProduct)->first()->amount_stock;
        $currentAmount += $amount;
        DB::update('update Product set amount_stock = ? where idProduct = ?', [$currentAmount, $idProduct]);
    }
    private function deleteAmountStock($idProduct, $amount) {
        $currentAmount = DB::table('Product')->where('idProduct', $idProduct)->first()->amount_stock;
        if($currentAmount >= $amount) {
            $currentAmount -= $amount;
        }
        else {
            $currentAmount = 0;
        }
        DB::update('update Product set amount_stock = ? where idProduct = ?', [$currentAmount, $idProduct]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::insert('insert into Harvest(amount, date_harvest, time_harvest, idAssignment, idProduct) values(?, ?, ?, ?, ?)', [
            $request->input('amount'),
            $request->input('date'),
            $request->input('time'),
            $request->input('assignment'),
            $request->input('product'),
        ]);
        $this->addAmountStock($request->input('product'), $request->input('amount'));
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
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $harvest = DB::table('Harvest')->where('idHarvest', $id)->first();
        $this->deleteAmountStock($harvest->idProduct, $harvest->amount);
        DB::delete('delete from Harvest where idHarvest = ?', [$id]);
        session()->flash('deleted', 'ลบการเก็บเกี่ยว เรียบร้อยแล้ว');
        return redirect('/harvests');
    }
}
