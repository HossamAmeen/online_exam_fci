<?php
use App\Student_cource_exam;
?>
<table border>
	<tr>
	    
		<th>Exam Name</th>
		<th>Total Students</th>
		<th>Success Students</th>
		<th>its persntage</th>
		<th>Exam Total</th>
	</tr>
	@foreach($exams as $one_exam)
		<tr>
		    
			<td>
			    {{$one_exam->EXAM_NAME}}
			    <br>
			    <?php
			       $students =  Student_cource_exam::where([
			       	      ['COURSE_ID',$course_id],
			       	      ['EXAM_ID',$one_exam->id],
			       	      ['Total_Student_Score','!=',' '],
			       	])->get();
			       
			    ?>
			    
			</td>
			<td>
			    {{$students->count()}}
		    </td>
			<td>
                @if($students->count() != 0)
				    <label>
				        success student
				        <?php
				           $success_students = $students->where('Total_Student_Score',$one_exam->EXAM_TOTAL)->count()
				        ?>
				        
				        {{$success_students}}
				    </label>
				    
			    @endif		
		    </td>
			<td>
				@if($students->count() != 0)
					 {{($success_students/($students->count()))*100}} % 
				@endif
			</td>
			<td>{{$one_exam->EXAM_TOTAL}}</td>
		</tr>
	@endforeach
</table>


