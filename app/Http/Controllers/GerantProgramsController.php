<?php

namespace App\Http\Controllers;

use App\Program;
use Illuminate\Http\Request;
use App\Http\Requests\AddProgramRequest;
use App\Http\Requests\EditProgramRequest;

class GerantProgramsController extends Controller
{
    public function index()
    {
        return view('gerantPrograms.list', [
            'title' => 'Programs List',
            'programs' => Program::paginate(10)
        ]);
    }
    
    public function create()
    {
        return view('gerantPrograms.create', [
        'title' => 'New Program',
        'programs' => Program::paginate(10)
        ]);
    }

    public function store(AddProgramRequest $request)
    {
        Program::create([
            'name' => $request->name,
            'expiration_date' => $request->expiration_date,
            'tier' => $request->tier,
            'reward' => $request->reward,
            'status' => $request->status,
        ]); 

        // Redirect the user back to the client listing page or any other desired page
        return redirect()->route('gerantPrograms.index')->with('message', 'Program added successfully!');
    }

    public function edit(Program $program)
    {
        return view('gerantPrograms.edit', [
            'title' => 'Edit Program',
            'program' => $program // Pass the program data to the view
        ]);
    }

    public function update(EditProgramRequest $request, Program $program)
    {
        $program->name = $request->name;
        $program->phone = $request->phone;
        $program->email = $request->email;
        $program->save();

        return redirect()->route('gerantPrograms.index')->with('message', 'Program updated successfully!');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('gerantPrograms.index')->with('message', 'Program deleted successfully!');
    }
}
