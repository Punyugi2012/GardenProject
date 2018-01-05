<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AssignmentDetailRequest;

class AssignmentDetailController extends Controller
{
    public function store(AssignmentDetailRequest $request, $idAssignment) {
        DB::insert('insert into AssignmentDetail(idEmployee, idAssignment) values (?, ?)', [
            $request->input('employee'),
            $idAssignment
        ]);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/assignments/'.$idAssignment);
    }
    public function destroy($idAssignmentDetail, $idAssignment) {
        DB::delete('delete from AssignmentDetail where idAssignmentDetail = ?', [$idAssignmentDetail]);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/assignments/'.$idAssignment);
    }
}
