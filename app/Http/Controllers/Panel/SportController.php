<?php

namespace App\Http\Controllers\Panel;

use App\Events\SportStoredEvent;
use App\Http\Controllers\Controller;
use App\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SportController extends Controller
{
    public $saveRequestInputs = [
        'title',
        'description',
        'status',
        'sort',
        'unit',
        'calories_per_unit',
    ];

    public $rules = [
        'title' => 'string|max:255',
        'unit' => 'string|max:255',
        'calories_per_unit' => 'numeric|max:10000000',
    ];

    public function __construct()
    {
        $this->middleware(['can:change_diet']);
    }

    public function create()
    {
        return view('panel.main')->nest('content', 'panel.sports.set');
    }

    public function edit($id)
    {
        $sport = Sport::findOrFail($id);
        return view('panel.main')->nest('content', 'panel.sports.set', compact('sport'));
    }

    public function index()
    {
        $sports = Sport::orderBy('sort', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.sports.list', compact('sports'));
    }

    public function update($sport_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $sport = Sport::findOrFail($sport_id);
        $sport->update($data);
        event(new SportStoredEvent($sport));
        return setSuccessfulResponse(route('panel.sports.edit', ['sport' => $sport->id]));
    }

    public function store(Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $rules['title'] .= "|required";
        $rules['unit'] .= "|required";
        $rules['calories_per_unit'] .= "|required";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $sport = Sport::create($data);
        event(new SportStoredEvent($sport));
        return setSuccessfulResponse(route('panel.sports.edit', ['sport' => $sport->id]));
    }
}
