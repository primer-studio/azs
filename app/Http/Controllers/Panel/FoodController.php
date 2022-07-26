<?php

namespace App\Http\Controllers\Panel;

use App\Events\FoodStoredEvent;
use App\Food;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public $saveRequestInputs = [
        'title',
        'description',
        'status',
        'image',
        'sort',
        'unit',
        'recommended_amounts',
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
        return view('panel.main')->nest('content', 'panel.foods.set');
    }

    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('panel.main')->nest('content', 'panel.foods.set', compact('food'));
    }

    public function index()
    {
        $foods = Food::orderBy('sort', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.foods.list', compact('foods'));
    }

    public function update($food_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $food = Food::findOrFail($food_id);
        $food->update($data);
        event(new FoodStoredEvent($food));
        return setSuccessfulResponse(route('panel.foods.edit', ['food' => $food->id]));
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
        $food = Food::create($data);
        event(new FoodStoredEvent($food));
        return setSuccessfulResponse(route('panel.foods.edit', ['food' => $food->id]));
    }
}
