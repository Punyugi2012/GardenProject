<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use File;
use Image;

class ReportController extends Controller
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
        $reports = DB::table('Report')->join('Employee', 'Report.idEmployee', '=', 'Employee.idEmployee')
            ->join('Assignment', 'Report.idAssignment', '=', 'Assignment.idAssignment')->get();
        return view('report.list-report', ['reports'=>$reports]);
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
        return view('report.add-report', ['employees'=>$employees, 'assignments'=>$assignments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        DB::insert('insert into Report(detail, date_report, time_report, type, idEmployee, idAssignment) values(?, ?, ?, ?, ?, ?)', [
            $request->input('detail'),
            $request->input('date'),
            $request->input('time'),
            $request->input('type'),
            $request->input('employee'),
            $request->input('assignment'),
        ]);
        session()->flash('added', 'เพิ่มการรายงาน เรียบร้อยแล้ว');
        return redirect('/reports');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $images = DB::table('ReportImage')->where('idReport', $id)->get();
        return view('report.detail-report', ['images'=>$images, 'idReport'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = DB::table('Report')->join('Employee', 'Report.idEmployee', '=', 'Employee.idEmployee')
        ->join('Assignment', 'Report.idAssignment', '=', 'Assignment.idAssignment')->where('idReport', $id)->first();
        $employees = DB::select('select * from Employee');
        $assignments = DB::table('Assignment')->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')->get();
        return view('report.edit-report', ['report'=>$report, 'employees'=>$employees, 'assignments'=>$assignments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $id)
    {
        DB::update('update Report set detail = ?, date_report = ?, time_report = ?, type = ?, idEmployee = ?, idAssignment = ? where idReport = ?', [
            $request->input('detail'),
            $request->input('date'),
            $request->input('time'),
            $request->input('type'),
            $request->input('employee'),
            $request->input('assignment'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขการรายงาน เรียบร้อยแล้ว');
        return redirect('/reports/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images = DB::select('select * from ReportImage where idReport = ?', [$id]);
        foreach($images as $image) {
            File::delete(public_path() . '/images/' . $image->pathFile);
            DB::delete('delete from ReportImage where idReportImage = ?', [$image->idReportImage]);
        }
        DB::delete('delete from Report where idReport = ?', [$id]);
        session()->flash('deleted', 'ลบการรายงาน เรียบร้อยแล้ว');
        return redirect('/reports');
    }
    public function storeImage(Request $request, $idReport) {
        $validatedData = $request->validate([
            'report_image' => 'required',
        ]);
        if ($request->hasFile('report_image')) {
            if ($request->hasFile('report_image')) {
                $filename = str_random(10) . '.' . $request->file('report_image')->getClientOriginalExtension(); 
                $request->file('report_image')->move(public_path() . '/images/', $filename);
                DB::insert('insert into ReportImage(pathFile, idReport) values(?, ?)', [
                    $filename,
                    $idReport
                ]);
                session()->flash('added', 'เพิ่มรูปรายงาน เรียบร้อยแล้ว');
            } 
        } 
        return redirect('/reports/'.$idReport);
    }
    public function destroyImage($idImage, $idReport) {
        $image = DB::table('ReportImage')->where('idReportImage', $idImage)->first();
        File::delete(public_path() . '/images/' .  $image->pathFile );
        DB::delete('delete from ReportImage where idReportImage = ?', [$idImage]);
        session()->flash('deleted', 'ลบรูปรายงาน เรียบร้อยแล้ว');
        return redirect('/reports/'.$idReport);
    }
}
