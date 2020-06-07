<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question_type;
class QuestionTypeController extends Controller
{

    public function index(){
        $questionType=Question_type::all();
        return view('admin.questionType.index',compact('questionType'));
    }
    public function store(Request $request)
  	{
  		$quetype = new Question_type();
  		$quetype->QUESTION_TYPE_DESCR = $request->name;
  		$quetype->save();
  		return redirect()->route('questionType.index');
  	}//end of store
      public function update(Request $request, Question_type $quetype)
      {
          $quetype->QUESTION_TYPE_DESCR = $request->name;
          $quetype->save();
          return redirect()->route('questionType.index');

      }//end of update
      public function destroy(Question_type $quetype)
      {
          $quetype->delete();
          return redirect()->route('questionType.index');

      }//end of destroy
}
