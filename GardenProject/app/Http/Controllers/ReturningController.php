<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReturningRequest;

class ReturningController extends Controller
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
    public function index(Request $request)
    {
        $returnings = DB::table('Reverting')->join('Employee', 'Reverting.idEmployee', '=', 'Employee.idEmployee')->where('idTake', $request->input('take'))->get();
        $status = DB::table('Take')->where('idTake', $request->input('take'))->first()->status_returning;
        return view('returning.list-returning', ['returnings'=>$returnings, 'take'=>$request->input('take'), 'status'=>$status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $take = DB::table('Take')->where('idTake', $request->input('take'))->first();
        $employees = DB::select('select * from Employee');
        return view('returning.add-returning', ['take'=>$take, 'employees'=>$employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReturningRequest $request)
    {
        DB::insert('insert into Reverting(date, time, idTake, idEmployee) values(?, ?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            $request->input('take'),
            $request->input('employee'),
        ]);
        session()->flash('added', 'เพิ่มการคืน เรียบร้อยแล้ว');
        return redirect("/returnings?take={$request->input('take')}");
    }
    private function isFullyReturn($items) {
        foreach($items as $item) {
            if($item['amount'] > 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $returningsDetail = DB::table('Item')->join('RevertingDetail', 'Item.idItem', '=', 'RevertingDetail.idItem')
        ->where('idReverting', $id)->get();
        $itemTakes = DB::table('Item')->join('TakeDetail', 'Item.idItem', '=', 'TakeDetail.idItem')->where('idTake', $request->input('take'))->get();
        $itemReceipts = DB::table('RevertingDetail')->join('Reverting', 'RevertingDetail.idReverting', '=', 'Reverting.idReverting')
            ->join('Item', 'RevertingDetail.idItem', '=', 'Item.idItem')->where('Reverting.idTake', $request->input('take'))->groupBy('Item.name')->selectRaw('name, sum(RevertingDetail.amount) as amount')->get();
        $items = [];
        foreach($itemTakes as $itemTake) {
            $found = false;
            foreach($itemReceipts as $itemReceipt) {
                if($itemTake->name == $itemReceipt->name) {
                    array_push($items, ['idItem'=>$itemTake->idItem, 'name'=>$itemTake->name, 'amount'=>$itemTake->amount - $itemReceipt->amount]);
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                array_push($items, ['idItem'=>$itemTake->idItem, 'name'=>$itemTake->name, 'amount'=>$itemTake->amount]);
            }
        }
        if($this->isFullyReturn($items)) {
            DB::update('update Take set status_returning = "fully" where idTake = ?', [$request->input('take')]);
        }
        else {
            DB::update('update Take set status_returning = "unfully" where idTake = ?', [$request->input('take')]);
        }
        return view('returning.detail-returning', ['returningsDetail'=>$returningsDetail, 'items'=>$items, 'take'=>$request->input('take'), 'idReturning'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $returning = DB::table('Reverting')->join('Employee', 'Reverting.idEmployee', '=', 'Employee.idEmployee')->where('idReverting', $id)->first();
        $take = DB::table('Take')->where('idTake', $request->input('take'))->first();
        $employees = DB::select('select * from Employee');
        return view('returning.edit-returning', ['returning'=>$returning, 'take'=>$take, 'employees'=>$employees]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReturningRequest $request, $id)
    {
        DB::update('update Reverting set date = ?, time = ?, idTake = ?, idEmployee = ? where idReverting = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('take'),
            $request->input('employee'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการคืน เรียบร้อยแล้ว');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::delete('delete from Reverting where idReverting = ?', [$id]);
        $itemTakes = DB::table('Item')->join('TakeDetail', 'Item.idItem', '=', 'TakeDetail.idItem')->where('idTake', $request->input('take'))->get();
        $itemReceipts = DB::table('RevertingDetail')->join('Reverting', 'RevertingDetail.idReverting', '=', 'Reverting.idReverting')
            ->join('Item', 'RevertingDetail.idItem', '=', 'Item.idItem')->where('Reverting.idTake', $request->input('take'))->groupBy('Item.name')->selectRaw('name, sum(RevertingDetail.amount) as amount')->get();
        $items = [];
        foreach($itemTakes as $itemTake) {
            $found = false;
            foreach($itemReceipts as $itemReceipt) {
                if($itemTake->name == $itemReceipt->name) {
                    array_push($items, ['idItem'=>$itemTake->idItem, 'name'=>$itemTake->name, 'amount'=>$itemTake->amount - $itemReceipt->amount]);
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                array_push($items, ['idItem'=>$itemTake->idItem, 'name'=>$itemTake->name, 'amount'=>$itemTake->amount]);
            }
        }
        if($this->isFullyReturn($items)) {
            DB::update('update Take set status_returning = "fully" where idTake = ?', [$request->input('take')]);
        }
        else {
            DB::update('update Take set status_returning = "unfully" where idTake = ?', [$request->input('take')]);
        }
        session()->flash('deleted', 'ลบการคืน เรียบร้อยแล้ว');
        return redirect("/returnings?take={$request->input('take')}");

    }
}
