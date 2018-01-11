<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AssignmentDetailRequest;

class AssignmentDetailController extends Controller
{
    private function setAmountEmployee($idAssignment) {
        $amount = DB::table('AssignmentDetail')->where('idAssignment', $idAssignment)->count('idAssignmentDetail');
        DB::update('update Assignment set amount_employee = ? where idAssignment = ?', [$amount, $idAssignment]);
    }
    public function store(AssignmentDetailRequest $request, $idAssignment) {
        DB::insert('insert into AssignmentDetail(idEmployee, idAssignment) values (?, ?)', [
            $request->input('employee'),
            $idAssignment
        ]);
        $this->setAmountEmployee($idAssignment);
        session()->flash('added', 'เพิ่ม เรียบร้อยแล้ว');
        return redirect('/assignments/'.$idAssignment);
    }
    public function destroy($idAssignmentDetail, $idAssignment) {
        DB::delete('delete from AssignmentDetail where idAssignmentDetail = ?', [$idAssignmentDetail]);
        $this->setAmountEmployee($idAssignment);
        session()->flash('deleted', 'ลบ เรียบร้อยแล้ว');
        return redirect('/assignments/'.$idAssignment);
    }
}
