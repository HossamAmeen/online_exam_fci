<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ilo_type;
class IlosTypeController extends Controller
{
  public function index(){
      $ilosType=Ilo_type::all();
      return view('admin.ilosType.index',compact('ilosType'));
  }
  public function store(Request $request)
	{
		$ilosType = new Ilo_type();
		$ilosType->ILO_TYPE_DESCR = $request->name;
		$ilosType->save();
		return redirect()->route('IlosType.index');
	}//end of store
  public function update(Request $request,Ilo_type $ilosType)
  {
      $ilosType->ILO_TYPE_DESCR = $request->name;
      $ilosType->save();
      return redirect()->route('IlosType.index');

  }//end of update
  public function destroy(Ilo_type $ilosType)
  {

      $ilosType->delete();
      return redirect()->route('IlosType.index');

  }//end of destroy
}
