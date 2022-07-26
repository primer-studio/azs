<?php

namespace App\Http\Controllers\Panel;

use App\Events\RecommendationStoredEvent;
use App\Http\Controllers\Controller;
use App\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecommendationController extends Controller
{
    public $saveRequestInputs = [
        'title',
        'description',
        'status',
        'sort',
    ];

    public $rules = [
        'title' => 'string|max:255',
    ];

    public function __construct()
    {
        $this->middleware(['can:change_diet']);
    }

    public function create()
    {
        return view('panel.main')->nest('content', 'panel.recommendations.set');
    }

    public function edit($id)
    {
        $recommendation = Recommendation::findOrFail($id);
        return view('panel.main')->nest('content', 'panel.recommendations.set', compact('recommendation'));
    }

    public function index()
    {
        $recommendations = Recommendation::orderBy('sort', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.recommendations.list', compact('recommendations'));
    }

    public function update($recommendation_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $recommendation = Recommendation::findOrFail($recommendation_id);
        $recommendation->update($data);
        event(new RecommendationStoredEvent($recommendation));
        return setSuccessfulResponse(route('panel.recommendations.edit', ['recommendation' => $recommendation->id]));
    }

    public function store(Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $rules['title'] .= "|required";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $recommendation = Recommendation::create($data);
        event(new RecommendationStoredEvent($recommendation));
        return setSuccessfulResponse(route('panel.recommendations.edit', ['recommendation' => $recommendation->id]));
    }
}
