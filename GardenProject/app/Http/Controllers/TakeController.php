<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TakeRequest;

class TakeController extends Controller
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
        $takes = DB::table('Take')->join('Employee', 'Take.idEmployee', '=', 'Employee.idEmployee')
            ->join('Assignment', 'Take.idAssignment', '=', 'Assignment.idAssignment')
            ->get();
        foreach($takes as $take) {
            $hasReturning = DB::table('Reverting')->where('idTake', $take->idTake)->first();
            $hasDeduction = DB::table('Deduction')->where('idTake', $take->idTake)->first();
            if($hasReturning || $hasDeduction) {
                $take->canDelete = false;
            }
            else {
                $take->canDelete = true;
            }
        }
        return view('take.list-take', ['takes'=>$takes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = DB::select('select * from Employee');
        $assignments = DB::table('Assignment')->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')->get();
        return view('take.add-take', ['employees'=>$employees, 'assignments'=>$assignments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TakeRequest $request)
    {
        DB::insert('insert into Take(date_take, time_take, status_returning, idEmployee, idAssignment) values(?, ?, ?, ?, ?)', [
            $request->input('date'),
            $request->input('time'),
            "unfully",
            $request->input('employee'),
            $request->input('assignment'),
        ]);
        session()->flash('added', 'เพิ่มการเบิก เรียบร้อยแล้ว');
        return redirect('/takes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $takesDetail = DB::table('Item')->join('TakeDetail', 'Item.idItem', '=', 'TakeDetail.idiTem')->where('idTake', $id)->get();
        $items = DB::select('select * from Item where type = "equipment"');
        return view('take.detail-take', ['takesDetail'=>$takesDetail, 'items'=>$items, 'idTake'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $take = DB::table('Take')->join('Employee', 'Take.idEmployee', '=', 'Employee.idEmployee')
            ->join('Assignment', 'Take.idAssignment', '=', 'Assignment.idAssignment')
            ->where('idTake', $id)->first();
        $employees = DB::select('select * from Employee');
        $assignments = DB::table('Assignment')->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')->get();
        return view('take.edit-take', ['take'=>$take, 'employees'=>$employees, 'assignments'=>$assignments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TakeRequest $request, $id)
    {
        DB::update('update Take set date_take = ?, time_take = ?, idEmployee = ?, idAssignment = ? where idTake = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('employee'),
            $request->input('assignment'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการเบิก เรียบร้อยแล้ว');
        return redirect('/takes/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from Take where idTake = ?', [$id]);
        session()->flash('added', 'เพิ่มการเบิก เรียบร้อยแล้ว');
        return redirect('/takes');
    }
}
