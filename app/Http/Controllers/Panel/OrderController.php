<?php

namespace App\Http\Controllers\Panel;

use App\DailyFoodPlan;
use App\DailyRecommendationPlan;
use App\DailySportPlan;
use App\Events\DailyPlanStoredEvent;
use App\Events\OrderCompletedEvent;
use App\Events\OrderSeenEvent;
use App\Events\OrderStoredEvent;
use App\Food;
use App\Http\Controllers\ThirdParty\SmsController;
use App\Order;
use App\Http\Controllers\Controller;
use App\Recommendation;
use App\Sport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class OrderController extends Controller
{
    public $saveRequestInputs = [
        'status',
        'start_date',
    ];

    public function __construct()
    {
        $this->middleware('can:change_order');
    }

    public function edit($id, Request $request)
    {
        $order = Order::findOrFail($id);
        // TODO[back-end]: this is for test, remove this
        if ($request->has('fake')) {
            # =========================  fake data - start ========================= #
            $foods = Food::get();
            $sports = Sport::get();
            $recommendations = Recommendation::get();

            $duration_in_day = $order->duration_in_day;

            $food_plan = [];
            $sport_plan = [];
            $recommendation_plan = [];
            $meals = [
                'breakfast',
                'snack1',
                'lunch',
                'snack2',
                'dinner',
                'snack3',
            ];

            $before = [
                '',
                '',
                'ناشتا',
                '',
                'با احتیاط',
                '',
            ];

            $after = [
                '',
                '',
                'همراه خانواده',
                '',
                'بدون چربی',
                '',
            ];

            for ($day = 1; $day <= $duration_in_day; $day++) {
                # =========================  foods - start ========================= #
                foreach ($meals as $meal) {
                    for ($count = 1; $count <= rand(3, 9); $count++) {
                        $food = $foods->random();
                        $food_plan[] = [
                            'order_id' => $order->id,
                            'day' => $day,
                            'food_id' => $food->id,
                            'before_food_comment' => $before[rand(0, 5)],
                            'after_food_comment' => $after[rand(0, 5)],
                            'amount_in_unit' => rand(5, 10),
                            'total_calories' => rand(50, 1000),
                            'meal' => $meal,
                            'section' => $count,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
                # =========================  foods -  end  ========================= #

                # =========================  sports - start ========================= #
                for ($count = 1; $count <= rand(1, 2); $count++) {
                    $sport = $sports->random();
                    $sport_plan[] = [
                        'order_id' => $order->id,
                        'day' => $day,
                        'sport_id' => $sport->id,
                        // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
                        'before_sport_comment' => $before[rand(0, 5)],
                        'after_sport_comment' => $after[rand(0, 5)],
                        'amount_in_unit' => rand(10, 20),
                        'total_calories' => rand(500, 1000),
                        'section' => $count,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                # =========================  sports -  end  ========================= #

                # =========================  recommendations - start ========================= #
                for ($count = 1; $count <= rand(1, 2); $count++) {
                    $recommendation = $recommendations->random();
                    $recommendation_plan[] = [
                        'order_id' => $order->id,
                        'day' => $day,
                        'recommendation_id' => $recommendation->id,
                        'before_recommendation_comment' => $before[rand(0, 5)],
                        'after_recommendation_comment' => $after[rand(0, 5)],
                        'section' => $count,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                # =========================  recommendations -  end  ========================= #
            }

            DailyFoodPlan::insert($food_plan);
            DailySportPlan::insert($sport_plan);
            DailyRecommendationPlan::insert($recommendation_plan);
            # =========================  fake data -  end  ========================= #
        }
        $diet = $order->diet;
        return view('panel.main')->nest('content', 'panel.orders.set', compact('order', 'diet'));
    }

    public function index()
    {
        $orders = Order::with(['invoiceItem', 'profile'])->orderBy('created_at', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.orders.list', compact('orders'));
    }

    public function update($order_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $valid_statuses = [
            \App\Constants\GeneralConstants::ORDER_STATUS_CREATED,
            \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED,
        ];
        $rules = [
            'status' => "required|in:" . implode(",", $valid_statuses),
            'start_date' => 'jdate'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $order = Order::findOrFail($order_id);
        $completed_status = \App\Constants\GeneralConstants::ORDER_STATUS_COMPLETED;
        $order_completed = false;
        if ($data['status'] == $completed_status && $order->status != $completed_status) {
            // order's status changed to completed
            $order_completed = true;
        }

        $order->update($data);
        //event(new OrderStoredEvent($order));
        event(new DailyPlanStoredEvent($order));
        if ($order_completed) {
            event(new OrderCompletedEvent($order));
//            $adapter = New SmsController();
//            $profile = [
//                'mobile_number' => User::find($order->profile->user_id)->mobile_number,
//                'name' => (is_null($order->profile->name)) ? 'کاربر' : $order->profile->name,
//            ];
//            $adapter->SendDietReadySMS($profile['mobile_number'], $profile['name']);
        }
        return setSuccessfulResponse(route('panel.orders.edit', ['order' => $order->id]));
    }

    public function uploadDietFile($order_id, Request $request)
    {
        $order = Order::with('profile')->findOrFail($order_id);
        $validator = Validator::make($request->all(), [
            'diet_file' => 'required|mimes:pdf|max:3000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages());
        }

        // delete the old file
        if (!empty($file_path)) {
            $this->deleteFile($order->file);
        }

        $file_name = $order->profile->name . "_" . $order->id . "_" . date('Y_m_d_His') . '_' . rand(10000, 500000) . '.' . $request->diet_file->extension();
        $relative_path = 'upload/diets/' . date('Y') . "/" . date("m") . "/";
        $directory_path = public_path($relative_path);
        $request->diet_file->move($directory_path, $file_name);
        $full_path = $relative_path . $file_name;
        $order->update([
            'file' => $full_path
        ]);
        return redirect()->back()->with(['success' => __('general.data_saved_successfully')]);
    }

    public function deleteDietFile($order_id)
    {
        $order = Order::with('profile')->findOrFail($order_id);
        if (!empty($order->file)) {
            $this->deleteFile($order->file);
            $order->update([
                'file' => null
            ]);
        }
        return setSuccessfulResponse(route('panel.orders.edit', ['order' => $order->id]));
    }

    public function deleteFile($file_path)
    {
        $full_path = public_path($file_path);
        if (File::exists($full_path)) {
            File::delete($full_path);
        }
    }

    public function search(Request $request)
    {
        $rules = [
            'title' => 'required|min:2|max:255|string',
            'type' => 'required|in:food,sport,recommendation'
        ];
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        switch ($request->input('type')) {
            case 'food':
                return $this->searchFood($request);
                break;
            case 'sport':
                return $this->searchSport($request);
                break;
            case 'recommendation':
                return $this->searchRecommendation($request);
                break;
            default:
                return setErrorResponse('wrong type');
        }
    }

    public function searchFood(Request $request)
    {
        $foods = Food::where('title', 'like', "%" . convertArabicStringToPersian($request->input('title')) . "%")
            ->get();
        return successfulDataResponse($foods);
    }

    public function searchSport(Request $request)
    {
        $sports = Sport::where('title', 'like', "%" . convertArabicStringToPersian($request->input('title')) . "%")
            ->get();
        return successfulDataResponse($sports);
    }

    public function searchRecommendation(Request $request)
    {
        $recommendations = Recommendation::where('title', 'like', "%" . convertArabicStringToPersian($request->input('title')) . "%")
            ->get();
        return successfulDataResponse($recommendations);
    }

    public function storeDailyPlan($order_id, Request $request)
    {
        $order = Order::findOrFail($order_id);
        // TODO[back-end]: validate fields, this is temporary
        $rules = [
            'removed_daily_food_plans' => 'required',
            'removed_daily_sport_plans' => 'required',
            'removed_daily_recommendation_plans' => 'required',
            // foods
            'foods.days.*.*.*.food_id' => 'required',
            'foods.days.*.*.*.amount_in_unit' => 'required',
            'foods.days.*.*.*.total_calories' => 'required',
            // sports
            'sports.days.*.*.sport_id' => 'required',
            'sports.days.*.*.amount_in_unit' => 'required',
            'sports.days.*.*.total_calories' => 'required',
            // recommendations
            'recommendations.days.*.*.recommendation_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }

        # =========================  insert foods - start ========================= #
        if ($request->has('foods')) {
            $insert_foods = [];
            foreach ($request->input('foods.days') as $day => $meals) {
                foreach ($meals as $meal => $foods) {
                    foreach ($foods as $section => $daily_food_plan) {
                        $insert_foods[] = [
                            'id' => (!empty($daily_food_plan['id']) ? $daily_food_plan['id'] : null),
                            'order_id' => $order->id,
                            'day' => $day,
                            'food_id' => $daily_food_plan['food_id'],
                            // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
                            'before_food_comment' => xssClean(convertArabicStringToPersian($daily_food_plan['before_food_comment'])),
                            'after_food_comment' => xssClean(convertArabicStringToPersian($daily_food_plan['after_food_comment'])),
                            'amount_in_unit' => $daily_food_plan['amount_in_unit'],
                            'total_calories' => $daily_food_plan['total_calories'],
                            'meal' => $meal,
                            'section' => $section,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
            DailyFoodPlan::insertOnDuplicateKey($insert_foods);
        }
        // remove removed_daily_food_plans
        $removed_daily_food_plans = $request->input('removed_daily_food_plans');
        if (!empty($removed_daily_food_plans)) {
            $order->dailyFoodPlans()->whereIN('id', json_decode($removed_daily_food_plans, true))->delete();
        }
        # =========================  insert foods -  end  ========================= #


        # =========================  insert sports - start ========================= #
        if ($request->has('sports')) {
            $insert_sports = [];
            foreach ($request->input('sports.days') as $day => $sports) {
                foreach ($sports as $section => $daily_sport_plan) {
                    $insert_sports[] = [
                        'id' => (!empty($daily_sport_plan['id']) ? $daily_sport_plan['id'] : null),
                        'order_id' => $order->id,
                        'day' => $day,
                        'sport_id' => $daily_sport_plan['sport_id'],
                        // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
                        'before_sport_comment' => xssClean(convertArabicStringToPersian($daily_sport_plan['before_sport_comment'])),
                        'after_sport_comment' => xssClean(convertArabicStringToPersian($daily_sport_plan['after_sport_comment'])),
                        'amount_in_unit' => $daily_sport_plan['amount_in_unit'],
                        'total_calories' => $daily_sport_plan['total_calories'],
                        'section' => $section,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            DailySportPlan::insertOnDuplicateKey($insert_sports);
        }
        // remove removed_daily_sport_plans
        $removed_daily_sport_plans = $request->input('removed_daily_sport_plans');
        if (!empty($removed_daily_sport_plans)) {
            $order->dailySportPlans()->whereIN('id', json_decode($removed_daily_sport_plans, true))->delete();
        }
        # =========================  insert sports -  end  ========================= #


        # =========================  insert recommendations - start ========================= #
        if ($request->has('recommendations')) {
            $insert_recommendations = [];
            foreach ($request->input('recommendations.days') as $day => $recommendations) {
                foreach ($recommendations as $section => $daily_recommendation_plan) {
                    $insert_recommendations[] = [
                        'id' => (!empty($daily_recommendation_plan['id']) ? $daily_recommendation_plan['id'] : null),
                        'order_id' => $order->id,
                        'day' => $day,
                        'recommendation_id' => $daily_recommendation_plan['recommendation_id'],
                        // We are using Yadakhov/InsertOnDuplicateKey to add InsertOnDuplicateKey to laravel! But you should remember that while using this package, the Eloquent Mutators Does not apply And you should apply them manually.!
                        'before_recommendation_comment' => xssClean(convertArabicStringToPersian($daily_recommendation_plan['before_recommendation_comment'])),
                        'after_recommendation_comment' => xssClean(convertArabicStringToPersian($daily_recommendation_plan['after_recommendation_comment'])),
                        'section' => $section,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            DailyRecommendationPlan::insertOnDuplicateKey($insert_recommendations);
        }
        // remove removed_daily_recommendation_plans
        $removed_daily_recommendation_plans = $request->input('removed_daily_recommendation_plans');
        if (!empty($removed_daily_recommendation_plans)) {
            $order->dailyRecommendationPlans()->whereIN('id', json_decode($removed_daily_recommendation_plans, true))->delete();
        }
        # =========================  insert recommendations -  end  ========================= #


        if (!$order->seen) {
            $order->update(['seen' => 1]);
            event(new OrderSeenEvent($order));
        }
        event(new DailyPlanStoredEvent($order));

//        return [
//            'foods' => $insert_foods,
//            'recommendations' => $insert_recommendations,
//            'sports' => $insert_sports
//        ];

        return setSuccessfulResponse(route('panel.orders.edit', ['order' => $order->id]));
    }
}
