<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\courseRequest;
use App\Models\ActivateToken;
use App\Models\ClassManagement;
use App\Models\Classroom;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('course.index', ['coursees' => Course::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(courseRequest $request)
    {
        try {
            Course::create($request->all());
            return response()->redirectToRoute('course.index');

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $classrooms = Classroom::where('id_course', $id)->get();
        // Retrieve all class management records for the user with associated classrooms
        $classManagements = null;
        $class = null;
        if($user !== null) {
            $classManagements = ClassManagement::where('id_student', $user->id)->with('classroom')->get();
            $class = $classManagements->pluck('classroom')->where('id_course', $id);
        }
        // Extract the associated classrooms from the collection
        // $joined = ClassManagement::where('id_classroom', $id)->get()
        $course = Course::withCount('users')->find($id);
        $tools = explode(',', $course->tools);

        $tokens = ActivateToken::all();

        return view('course.detail', compact('course', 'tools', 'classrooms', 'classManagements', 'class', 'tokens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        // dd($course->id);
        return view('admin.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Course::updateOrCreate(
                ['id' => $id],
                $request->all(),
            );
            return response()->redirectToRoute('course.index');
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Course::find($id)->delete();
            return response()->redirectToRoute('course.index');
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function admin()
    {
        return view('admin.course.index', ['courses' => Course::all()]);
    }
}
