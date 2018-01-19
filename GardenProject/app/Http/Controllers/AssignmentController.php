<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AssignmentRequest;

class AssignmentController extends Controller
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
        $assignments = DB::table('Assignment')
            ->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')
            ->join('Zone', 'Assignment.idZone', '=', 'Zone.idZone')
            ->get();
        foreach($assignments as $assignment) {
            $hasTake = DB::table('Take')->where('idAssignment', $assignment->idAssignment)->first();
            $hasReport = DB::table('Report')->where('idAssignment', $assignment->idAssignment)->first();
            $hasHarvest = DB::table('Harvest')->where('idAssignment', $assignment->idAssignment)->first();
            $assignment->amount_employee = DB::table('AssignmentDetail')->where('idAssignment', $assignment->idAssignment)->count('idAssignment');
            if($hasTake ||  $hasReport || $hasHarvest) {
                $assignment->canDelete = false;
            }
            else {
                $assignment->canDelete = true;
            }
        }
        return view('assignment.list-assignment', ['assignments'=>$assignments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignmentTypes = DB::select('select * from AssignmentType');
        $zones = DB::select('select * from Zone');
        return view('assignment.add-assignment', ['assignmentTypes'=>$assignmentTypes, 'zones'=>$zones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {
        DB::insert('insert into Assignment(amount_employee, date, time, idZone, status, idAssignmentType) values(?, ?, ?, ?, ?, ?)', [
            0,
            $request->input('date'),
            $request->input('time'),
            $request->input('zone'),
            $request->input('status'),
            $request->input('type'),
        ]);
        session()->flash('added', 'เพิ่มการมอบหมายงาน เรียบร้อยแล้ว');
        return redirect('/assignments');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignmentsDetail = DB::table('AssignmentDetail')->join('Employee', 'AssignmentDetail.idEmployee', '=', 'Employee.idEmployee')
            ->where('idAssignment', $id)->get();
        $employees = DB::select('select * from Employee');
        return view('assignment.detail-assignment', ['assignmentsDetail'=>$assignmentsDetail, 'employees'=>$employees, 'idAssignment'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignment = DB::table('Assignment')
        ->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')
        ->join('Zone', 'Assignment.idZone', '=', 'Zone.idZone')
        ->where('idAssignment', $id)
        ->first();
        $assignmentTypes = DB::select('select * from AssignmentType');
        $zones = DB::select('select * from Zone');
        return view('assignment.edit-assignment', ['assignment'=>$assignment, 'assignmentTypes'=>$assignmentTypes, 'zones'=>$zones]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, $id)
    {
        DB::update('update Assignment set date = ?, time = ?, idZone = ?, status = ?, idAssignmentType = ? where idAssignment = ?', [
            $request->input('date'),
            $request->input('time'),
            $request->input('zone'),
            $request->input('status'),
            $request->input('type'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการมอบหมายงาน เรียบร้อยแล้ว');
        return redirect('/assignments/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from Assignment where idAssignment = ?', [$id]);
        session()->flash('deleted', 'ลบการมอบหมายงาน เรียบร้อยแล้ว');
        return redirect('/assignments');
    }
}
