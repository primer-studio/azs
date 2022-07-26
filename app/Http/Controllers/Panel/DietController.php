<?php

namespace App\Http\Controllers\Panel;

use App\Constants\GeneralConstants;
use App\Diet;
use App\Events\DietCacheResetEvent;
use App\Events\DietStoredEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DietCollection;
use App\Http\Resources\Diet as DietResource;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;

class DietController extends Controller
{
    public $saveRequestInputs = [
        'title',
        'description',
        'status',
        'image',
        'sort',
        'periods',
        'page_title',
        'page_description',
        'page_keywords',
    ];

    public $rules = [
        'title' => 'string',
        'periods' => 'required|array',
        'periods.*.period' => 'required|max:50!min:1',
        'periods.*.duration_in_day' => 'required|max:365!min:1',
        'periods.*.price' => 'required|numeric|max:100000000000|min:1000',
        'periods.*.status' => 'required|in:active,inactive',
    ];

    public function __construct()
    {
        $this->middleware(['can:add_diet'])->only(['create', 'store']);
        $this->middleware(['can:change_diet'])->except(['index', 'create', 'store']);
    }

    public function create()
    {
        return view('panel.main')->nest('content', 'panel.diets.set');
    }

    public function edit($id)
    {
        $diet = Diet::findOrFail($id);
        return view('panel.main')->nest('content', 'panel.diets.set', compact('diet'));
    }

    public function index()
    {
        $diets = Diet::orderBy('sort', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.diets.list', compact('diets'));
    }

    public function preparePeriodsToSave($periods)
    {
        return collect($periods)->map(function ($period) {
            return collect($period)->only([
                'period',
                'duration_in_day',
                'price',
                'status',
            ]);
        })->keyBy('period')->toJson();
    }

    public function update($diet_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $data['show_price_in_diets_list'] = $request->has('show_price_in_diets_list');
        $diet = Diet::findOrFail($diet_id);
        $data['periods'] = $this->preparePeriodsToSave($data['periods']);
        $diet->update($data);
        event(new DietStoredEvent($diet));
        return setSuccessfulResponse(route('panel.diets.edit', ['diet' => $diet->id]));
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
        $data['show_price_in_diets_list'] = $request->has('show_price_in_diets_list');
        $data['periods'] = $this->preparePeriodsToSave($data['periods']);
        $diet = Diet::create($data);
        event(new DietStoredEvent($diet));
        return setSuccessfulResponse(route('panel.diets.edit', ['diet' => $diet->id]));
    }

    /**
     * create specific permission to get this diet
     * @param $diet_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPermission($diet_id, Request $request)
    {
        $diet = Diet::findOrFail($diet_id);
        $permission_name = GeneralConstants::DIET_PERMISSION_NAME_PREFIX . $diet->id;
        $need_permission = false;
        if ($request->has('need_permission')) {
            // create permission (if not exists)
            try {
                Permission::create(['guard_name' => 'web', 'name' => $permission_name]);
            } catch (PermissionAlreadyExists $exception) {
                // In the case of errors creating duplicate permissions
            } catch (\Exception $exception) {
                return setErrorResponse(__('there_was_a_problem'));
            }
            $need_permission = true;
        } else {
            // remove permission (if exists)
            try {
                $permission = Permission::where(['guard_name' => 'web', 'name' => $permission_name])->first();
                if (!empty($permission)) {
                    $permission->delete();
                }
            } catch (PermissionDoesNotExist $exception) {
                // permission not exist
            } catch (\Exception $exception) {
                return setErrorResponse(__('there_was_a_problem'));
            }
        }

        $diet->update([
            'need_permission' => $need_permission
        ]);
        event(new DietStoredEvent($diet));
        return setSuccessfulResponse(route('panel.diets.edit', ['diet' => $diet->id]));
    }
}
