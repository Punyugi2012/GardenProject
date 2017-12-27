<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmployeeRequest;
use Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = DB::select('select * from employee');
        return view('employee/list-employee', ['employees'=>$employees]);
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
            $filename = str_random(10) . '.' . $request->file('profile_image')->getClientOriginalExtension(); $request->file('profile_image')->move(public_path() . '/images/', $filename);
            Image::make(public_path() . '/images/' . $filename)->resize(50, 50)->save(public_path() . '/images/resize/' .
            $filename);
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
        session()->flash('added', 'เพิ่มพนักงานเรียบร้อยแล้ว');
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
        DB::update('update employee set name = ?, surname = ?, phone = ?, nationality = ?, date_worked = ?, salary = ?, gender = ? where idEmployee = ?',[
            $request->name,
            $request->surname,
            $request->phone,
            $request->nationality,
            $request->date_worked,
            $request->salary,
            $request->gender,
            $id
        ]);
        session()->flash('edited', 'แก้ไขพนักงานเรียบร้อยแล้ว');
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
        //
    }
}
