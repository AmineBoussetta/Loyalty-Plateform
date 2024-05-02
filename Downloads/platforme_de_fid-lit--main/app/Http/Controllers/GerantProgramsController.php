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
        $programs = Program::where('status', 'active')->paginate(10);

        return view('gerantPrograms.list', [
            'title' => 'Programs List',
            'programs' => $programs
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
            'status' => $request->status ?? 'active',
        ]); 

        // Redirect the user back to the client listing page or any other desired page
        return redirect()->route('gerantPrograms.index')->with('message', 'Program added successfully!');
    }

    public function edit(Program $program)
    {
        $inactive = $program -> status == 'inactive';
        return view('gerantPrograms.edit', [
            'title' => 'Edit Program',
            'program' => $program,
            'inactive' => $inactive,
        ]);
    }

    public function update(EditProgramRequest $request, Program $program)
    {
        $program->name = $request->name;
        $program->expiration_date = $request->expiration_date;
        $program->tier = $request->tier;
        $program->reward = $request->reward;
        $program->status = $request->status;
        $program->save();

        if ($program->status === 'inactive') {
            return redirect()->route('gerantPrograms.index')->with('message', 'Program marked as inactive!');
        }

        return redirect()->route('gerantPrograms.index')->with('message', 'Program updated successfully!');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('gerantPrograms.index')->with('message', 'Program deleted successfully!');
    }

    public function inactive()
    {
        $inactivePrograms = Program::where('status', 'inactive')->paginate(10);

        return view('gerantPrograms.inactive', [
            'title' => 'Inactive Programs',
            'inactivePrograms' => $inactivePrograms
        ]);
    }

    public function activate(Program $program)
    {
        $program->status = 'active';
        $program->save();

        return redirect()->route('gerantPrograms.index')->with('message', 'Program activated successfully!');
    }

    public function toggleStatus(Program $program)
    {
        if ($program->status === 'active') {
            $program->status = 'inactive';
        } else {
            $program->status = 'active';
        }
        $program->save();

        return redirect()->route('gerantPrograms.index')->with('message', 'Program status toggled successfully!');
    }


}
