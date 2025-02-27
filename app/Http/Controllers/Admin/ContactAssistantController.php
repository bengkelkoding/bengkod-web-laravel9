<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactAssistant;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class ContactAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? "";
        $per_page = $request->per_page ?? 10;
        $contactAssistant = ContactAssistant::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%");
            })->paginate($per_page);

        return view('admin.contactAssistant.index', compact('contactAssistant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contactAssistant.create', ['courses' => Course::all(), 'students' => User::role('student')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = [
                'id_course' => $request->id_course,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ];
            ContactAssistant::create($data);
            return response()->redirectToRoute('admin.contact-assistant.index');

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\ContactAssistant  $contactAssistant
     * @return \Illuminate\Http\Response
     */
    public function show(ContactAssistant $contactAssistant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\ContactAssistant  $contactAssistant
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactAssistant $contactAssistant)
    {
        return view('admin.contactAssistant.edit', compact('contactAssistant'),
            ['courses' => Course::all(), 'students' => User::role('student')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @param  \App\Models\Admin\ContactAssistant  $contactAssistant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactAssistant $contactAssistant)
    {
        try{
            $data = [
                'id_course' => $request->id_course,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ];
            $contactAssistant->update($data);
            return response()->redirectToRoute('admin.contact-assistant.index');
        } catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\ContactAssistant  $contactAssistant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactAssistant $contactAssistant)
    {
        $contactAssistant->delete();
        return response()->redirectToRoute('admin.contact-assistant.index');
    }
}
