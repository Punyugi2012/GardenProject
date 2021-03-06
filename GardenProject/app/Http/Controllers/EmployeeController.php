<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmployeeRequest;
use Image;
use File;

class EmployeeController extends Controller
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
        $employees = DB::select('select * from employee');
        return view('employee.list-employee', ['employees'=>$employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.add-employee');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $filename = 'nopic.png';
        if ($request->hasFile('profile_image')) {
            $filename = str_random(10) . '.' . $request->file('profile_image')->getClientOriginalExtension(); 
            $request->file('profile_image')->move(public_path() . '/images/', $filename);
            Image::make(public_path() . '/images/' . $filename)->resize(50, 50)->save(public_path() . '/images/resize/' .$filename);
        } 
        DB::insert('insert into employee(name, surname, phone, nationality, date_worked, profile_image, salary, gender) values(?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->name,
            $request->surname,
            $request->phone,
            $request->nationality,
            $request->date_worked,
            $filename,
            $request->salary,
            $request->gender
        ]);
        session()->flash('added', 'เพิ่มพนักงาน เรียบร้อยแล้ว');
        return redirect('/employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = DB::table('Employee')->where('idEmployee', $id)->first();
        $leaves = DB::select('select * from TakeLeave where idEmployee = ?', [$id]);
        $salaries = DB::select('select * from Salary where idEmployee = ?', [$id]);
        $attendances = DB::select('select * from Attendance where idEmployee = ?', [$id]);
        $takes = DB::table('Take')->where('idEmployee', $id)->get();
        foreach($takes as $take) {
            $take->assignment = DB::table('Assignment')->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')
                ->where('idAssignment', $take->idAssignment)->first();
        }
        $deductions = DB::table('Deduction')->join('Take', 'Deduction.idTake', '=', 'Take.idTake')->where('Deduction.idEmployee', $id)->get();
        $returnings = DB::table('Reverting')->join('Take', 'Reverting.idTake', '=', 'Take.idTake')
            ->where('Reverting.idEmployee', $id)->get();
        $assignments = DB::table('Assignment')->join('AssignmentDetail', 'Assignment.idAssignment', '=', 'AssignmentDetail.idAssignment')
            ->join('AssignmentType', 'Assignment.idAssignmentType', '=', 'AssignmentType.idAssignmentType')->where('idEmployee', $id)->get();
        return view('employee.detail-employee', ['leaves'=>$leaves, 'employee'=>$employee, 'salaries'=>$salaries, 'attendances'=>$attendances, 'takes'=>$takes, 'deductions'=>$deductions, 'returnings'=>$returnings, 'assignments'=>$assignments, 'idEmployee'=>$id]);
    }
    public function detailTake(Request $request, $idTake) {
        $takesDetail = DB::table('Item')->join('TakeDetail', 'Item.idItem', '=', 'TakeDetail.idiTem')->where('idTake', $idTake)->get();
        return view('employee.detail-take', ['takesDetail'=>$takesDetail, 'employee'=>$request->input('employee')]);
    }
    public function detailDeduction(Request $request, $idDeduction) {
        $deductionsDetail = DB::table('Item')->join('DeductionDetail', 'Item.idItem', '=', 'DeductionDetail.idItem')
        ->where('idDeduction', $idDeduction)->get(); 
        return view('employee.detail-deduction', ['deductionsDetail'=>$deductionsDetail, 'employee'=>$request->input('employee')]);
    }
    public function detailReturning(Request $request, $idReturning) {
        $returningsDetail = DB::table('Item')->join('RevertingDetail', 'Item.idItem', '=', 'RevertingDetail.idItem')
        ->where('idReverting', $idReturning)->get();
        return view('employee.detail-returning', ['returningsDetail'=>$returningsDetail, 'employee'=>$request->input('employee')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = DB::select('select * from employee where idemployee = ?', [$id]);
        return view('employee.edit-employee', ['employee'=>$employee[0]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employee = DB::select('select * from employee where idEmployee = ?', [$id]);
        $filename = 'nopic.png';
        if($employee[0]->profile_image != 'nopic.png') {
            $filename = $employee[0]->profile_image;
        }
        if ($request->hasFile('profile_image')) {
            if($employee[0]->profile_image != 'nopic.png') {
                File::delete(public_path() . '/images/' . $employee[0]->profile_image);
                File::delete(public_path() . '/images/resize/' . $employee[0]->profile_image);
            }
            $filename = str_random(10) . '.' . $request->file('profile_image')->getClientOriginalExtension(); 
            $request->file('profile_image')->move(public_path() . '/images/', $filename);
            Image::make(public_path() . '/images/' . $filename)->resize(50, 50)->save(public_path() . '/images/resize/' .$filename);
        }
        DB::update('update employee set name = ?, surname = ?, phone = ?, nationality = ?, date_worked = ?, profile_image = ?, salary = ?, gender = ? where idEmployee = ?',[
            $request->input('name'),
            $request->input('surname'),
            $request->input('phone'),
            $request->input('nationality'),
            $request->input('date_worked'),
            $filename,
            $request->input('salary'),
            $request->input('gender'),
            $id
        ]);
        session()->flash('edited', 'แก้ไขพนักงาน เรียบร้อยแล้ว');
        return redirect('/employees/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = DB::select('select * from employee where idEmployee = ?', [$id]);
        if ($employee[0]->profile_image != 'nopic.png') {
            File::delete(public_path() . '/images/' . $employee[0]->profile_image);
            File::delete(public_path() . '/images/resize/' . $employee[0]->profile_image);
        }
        DB::delete('delete from employee where idEmployee = ?', [$id]);
        session()->flash('deleted', 'ลบพนักงาน เรียบร้อยแล้ว');
        return redirect('/employees');
    }
}
