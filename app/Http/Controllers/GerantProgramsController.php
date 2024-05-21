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
            'start_date' => $request->start_date,
            'expiry_date' => $request->expiry_date,
            'amount' => $request->amount,
            'points' => $request->points,
            'minimum_amount' => $request->minimum_amount,
            'amount_premium' => $request->amount_premium,
            'points_premium' => $request->points_premium,
            'minimum_amount_premium' => $request->minimum_amount_premium,
            'conversion_factor' => $request->conversion_factor,
            'status' => $request->status ?? 'active',
            'comment' => $request->comment,
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
        $program->start_date = $request->start_date;
        $program->expiry_date = $request->expiry_date;
        $program->amount = $request->amount;
        $program->points = $request->points; 
        $program->minimum_amount = $request->minimum_amount;
        $program->amount_premium = $request->amount_premium;
        $program->points_premium = $request->points_premium; 
        $program->minimum_amount_premium = $request->minimum_amount_premium;
        $program->conversion_factor = $request->conversion_factor;
        $program->status = $request->status ?? 'active';
        $program->comment = $request->comment;
        $program->save();

        if ($program->status === 'inactive') {
            return redirect()->route('gerantPrograms.index')->with('message', 'Program marked as inactive!');
        }

        return redirect()->route('gerantPrograms.index')->with('message', 'Program updated successfully!');
    }

    public function destroy(Program $program)
    {
        if ($program->status === 'inactive') {
            $program->delete();
            return redirect()->route('gerantPrograms.index')->with('message', 'Program deleted successfully!');
        } else {
            return redirect()->route('gerantPrograms.index')->with('warning', 'Cannot delete an active program!');
        }
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
        $program->status = $program->status === 'active'? 'inactive' : 'active';
        $program->save();

        return redirect()->route('gerantPrograms.index')->with('message', 'Program status toggled successfully!');
    }


}
