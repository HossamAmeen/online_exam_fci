<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faculty;
use App\Http\Requests\FaclitiesRequest;
class FaclitiesController extends Controller
{
  public function index(){
      $faculties=Faculty::all();
      return view('admin.faculities.index',compact('faculties'));
  }
  public function store(FaclitiesRequest $request)
	{
		$faculty = new Faculty();
		$faculty->FACULTY_NAME = $request->name;
		$faculty->save();
		return redirect()->route('faclities.index');
	}//end of store
    public function update(FaclitiesRequest $request, Faculty $faculty)
    {
        $faculty->FACULTY_NAME = $request->name;
        $faculty->save();
        return redirect()->route('faclities.index');

    }//end of update
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('faclities.index');

    }//end of destroy
}
