<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Semester;
class SemesterController extends Controller
{
  public function index(){
      $semesters=Semester::all();
      return view('admin.semester.index',compact('semesters'));
  }
  public function store(Request $request)
  {
    $semester = new Semester();
    $semester->SEMESTER_DESCR = $request->name;
    $semester->save();
    return redirect()->route('semester.index');
  }//end of store
    public function update(Request $request, Semester $semester)
    {
        $semester->SEMESTER_DESCR = $request->name;
        $semester->save();
        return redirect()->route('semester.index');

    }//end of update
    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semester.index');

    }//end of destroy
}
