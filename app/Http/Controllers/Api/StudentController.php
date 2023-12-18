<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function getStudent()
    {
        $Students = Student::all();

        if($Students->count() > 0){
            $data = [
                'status' => 200,
                'students' => $Students
            ];
            return response()->json($data, 200 );
        }else{
            $data = [
                'status' => 404,
                'Message' => 'No student found'
            ];
            return response()->json($data, 404 );
        }
    }

    public function getStudentById($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }
        
    // create student
    public function createStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'error' => $validator->Message()
            ], 422);
        }else{
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if($student){
                return response()->json([
                    'status'=>200,
                    'message'=>'student successfully created'
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'error' => 'something went wrong!'
                ]);
            }
        }
    }


    // updateStudent

    public function updateStudent(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'error'=> $validator->Message()
            ],422);
        }else{
            $student = Student::find($id);

            if(!$student){
                return response()->json([
                    'status' => 404,
                    'error' =>  'Student not found'
                ],404);
            }

            $student->name = $request->name;
            $student->course = $request->course;
            $student->email = $request->email;
            $student->phone = $request->phone;

            if($student->save()){
                return response()->json([
                    'status' => 200,
                    'message' => 'successfully updated'
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'error' => 'something went wrong!'
                ],500);
            }

        }
    }

    // delete controler
    public function deleteStudent($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'student' => 'successfully deleted'
            ],200);
        }else{
            return response()->json([
                'status'=>500,
                'error' => 'Something went wrong!'
            ],500);
        }
    }
}
