<?php

namespace App\Http\Controllers\Panel;

use App\Admin;
use App\ComprehensiveReport;
use App\Constants\GeneralConstants;
use App\Events\ProfileUpdatedEvent;
use App\Events\ProfileUpdateRequestEvent;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileLog;
use App\ProfileUser;
use App\Province;
use App\Rules\ValidMobileNumber;
use Carbon\Carbon;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\QuestionHelper;
use Facades\App\Libraries\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // TODO[back-end]: add the remaining fields
    public $saveRequestInputs = [
        'name',
        'note',
        'gender',
        'date_of_birth',
        'height',
        'marital_status',
        'last_diet',
        'blood_type',
        'illness_history',
        'favorite_foods',
        'disgusting_foods',
        'prohibited_foods',
        'province_id',
        'city',
    ];

    public function __construct()
    {
        $this->middleware(['can:see_profiles_data']);
        $this->middleware(['can:change_profiles_data'])->only(['create', 'update', 'updateQuestionsAnswers']);
    }

    public function index(Request $request)
    {
        $query = ProfileUser::with(['user.affiliationPartner', 'province']);
        $search_items = $request->only([
            'profile_name',
            'mobile_number'
        ]);
        # =========================  search - start ========================= #
        $search_array = [];
        if (!empty($search_items['profile_name'])) {
            $search_array[] = ['name', 'like', "%" . $search_items['profile_name'] . "%"];
        }

        if (!empty($search_items['mobile_number'])) {
            $search_array[] = ['mobile_number', 'like', "%" . $search_items['mobile_number'] . "%"];
        }

        if (!empty($search_array)) {
            $query = $query->where($search_array);
        }
        $search_items = (object)$search_items;
        # =========================  search -  end  ========================= #

        $profiles = $query->orderBy('created_at', 'DESC')->paginate(20);
        $profiles->appends($request->input());
        return view('panel.main')->nest('content', 'panel.profiles.list', compact('profiles', 'search_items'));
    }

    public function comprehensiveReport(Request $request)
    {
        $query = ComprehensiveReport::with(['diet', 'cartItems.diet', 'inProgressBy']);
        $allowed_sort_by_items = [
            'profile_created_at',
            'paid_at',
            'order_created_at',
            'invoice_created_at',
            'order_start_date',
            'order_end_date',
            'mobile_number',
            'invoice_status',
            'payment_way',
        ];

        $allowed_date_range_events = [
            'profile_created_at',
            'paid_at',
            'order_created_at',
            'order_start_date',
            'order_end_date',
            'invoice_created_at'
        ];
        $allowed_sort_by_type_items = ['ASC', 'DESC'];

        $search_items = $request->only([
            'profile_name',
            'mobile_number',
            'diet_id',
            'payment_way',
            'paid',
            'in_progress',
            'not_in_progress',
            'order_created',
            'order_completed',
            'close_to_renewal',
            'expired',
        ]);

        $sort_items = $request->only([
            'sort_item_1',
            'sort_item_2',
            'sort_item_3',
            'sort_item_4',
        ]);

        $sort_type_items = $request->only([
            'sort_type_item_1',
            'sort_type_item_2',
            'sort_type_item_3',
            'sort_type_item_4',
        ]);

        $rules = [
            'sort_item_1' => 'nullable|in:' . implode(",", $allowed_sort_by_items),
            'sort_item_2' => 'nullable|in:' . implode(",", $allowed_sort_by_items),
            'sort_item_3' => 'nullable|in:' . implode(",", $allowed_sort_by_items),
            'sort_item_4' => 'nullable|in:' . implode(",", $allowed_sort_by_items),
            'sort_type_item_1' => 'nullable|in:' . implode(",", $allowed_sort_by_type_items),
            'sort_type_item_2' => 'nullable|in:' . implode(",", $allowed_sort_by_type_items),
            'sort_type_item_3' => 'nullable|in:' . implode(",", $allowed_sort_by_type_items),
            'sort_type_item_4' => 'nullable|in:' . implode(",", $allowed_sort_by_type_items),
            'sort_type_item_4' => 'nullable|in:' . implode(",", $allowed_sort_by_type_items),
            'date_range_event' => 'nullable|in:' . implode(",", $allowed_date_range_events),
            'date_range_start' => 'nullable|jdate',
            'date_range_end' => 'nullable|jdate',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(route('panel.comprehensive-report'));
        }

        # =========================  search - start ========================= #
        $search_array = [];
        if (!empty($search_items['profile_name'])) {
            $search_array[] = ['name', 'like', "%" . $search_items['profile_name'] . "%"];
        }

        if (!empty($search_items['mobile_number'])) {
            $search_array[] = ['mobile_number', 'like', "%" . $search_items['mobile_number'] . "%"];
        }

        if (!empty($search_items['diet_id'])) {
            $search_array[] = ['diet_id', $search_items['diet_id']];
        }

        if (!empty($search_items['payment_way'])) {
            $search_array[] = ['payment_way', $search_items['payment_way']];
        }

        if (!empty($search_array)) {
            $query = $query->where($search_array);
        }

        // order_created
        if (!empty($search_items['order_created'])) {
            $query = $query->where([
                ['order_id', '>', 0],
                ['order_status', GeneralConstants::ORDER_STATUS_CREATED]
            ]);
        }

        // paid
        if (!empty($search_items['paid'])) {
            $query = $query->where([
                ['invoice_status', GeneralConstants::TRANSACTION_VERIFIED]
            ]);
        }

        // in_progress
        if (!empty($search_items['in_progress'])) {
            $query = $query->where([
                ['in_progress', true]
            ]);
        }

        // not_in_progress
        if (!empty($search_items['not_in_progress'])) {
            $query = $query->where([
                ['in_progress', false]
            ]);
        }

        // ipg_paid
        if (!empty($search_items['ipg_paid'])) {
            $query = $query->where([
                ['invoice_status', GeneralConstants::TRANSACTION_VERIFIED],
                ['payment_way', GeneralConstants::PAYMENT_WAY_IPG]
            ]);
        }

        // order_created
        if (!empty($search_items['order_completed'])) {
            $query = $query->where([
                ['order_id', '>', 0],
                ['order_status', GeneralConstants::ORDER_STATUS_COMPLETED]
            ]);
        }

        // close_to_renewal
        if (!empty($search_items['close_to_renewal'])) {
            $query = $query->where([
                ['order_id', '>', 0],
                ['order_status', GeneralConstants::ORDER_STATUS_COMPLETED],
                ['order_end_date', '!=', null],
                ['order_end_date', '<', Carbon::now()->startOfDay()->addDay(7)->timestamp],
                ['order_end_date', '>', Carbon::now()->startOfDay()->timestamp],
            ]);
        }

        // expired
        if (!empty($search_items['expired'])) {
            $query = $query->where([
                ['order_id', '>', 0],
                ['order_status', GeneralConstants::ORDER_STATUS_COMPLETED],
                ['order_end_date', '!=', null],
                ['order_end_date', '<', Carbon::now()->startOfDay()->timestamp],
            ]);
        }
        # =========================  search -  end  ========================= #


        # =========================  date range - start ========================= #
        $date_range_event = $request->input('date_range_event', null);
        $date_range_start = $request->input('date_range_start', null);
        $date_range_end = $request->input('date_range_end', null);
        if (!empty($date_range_event) && (!empty($date_range_start) || !empty($date_range_end))) {
            if (!empty($date_range_start)) {
                $query = $query->whereDate($date_range_event, ">=", Carbon::createFromTimestamp(jdateToTimestamp($date_range_start))->startOfDay());
            }
            if (!empty($date_range_end)) {
                $query = $query->whereDate($date_range_event, "<=", Carbon::createFromTimestamp(jdateToTimestamp($date_range_end))->endOfDay());
            }
        }
        # =========================  date range -  end  ========================= #


        # =========================  sort - start ========================= #
        // show just used items in page not all of them
        $filtered_sort_items = [];
        $filtered_sort_type_items = [];
        for ($i = 1; $i <= 4; $i++) {
            $sort_item_key = 'sort_item_' . $i;
            $sort_type_item_key = 'sort_type_item_' . $i;
            if (!empty($sort_items[$sort_item_key]) && !empty($sort_type_items[$sort_type_item_key]) && !in_array($sort_items[$sort_item_key], $filtered_sort_items)) {
                $filtered_sort_items[$sort_item_key] = $sort_items[$sort_item_key];
                $filtered_sort_type_items[$sort_type_item_key] = $sort_type_items[$sort_type_item_key];
                $query = $query->orderBy($sort_items[$sort_item_key], $sort_type_items[$sort_type_item_key]);
            }
        }

        // default sort (if the custom sort is empty)
        if (empty($filtered_sort_items)) {
            $query = $query->orderBy('profile_created_at', 'DESC')
                ->orderBy('invoice_created_at', 'DESC')
                ->orderBy('order_created_at', 'DESC');
        }

        # =========================  sort -  end  ========================= #

        $items = $query->paginate(25);
        // convert $search_items to object
        $search_items = (object)$search_items;
        $sort_items = (object)$filtered_sort_items;
        $sort_type_items = (object)$filtered_sort_type_items;
        $items->appends($request->input());
        return view('panel.main')->nest('content', 'panel.profiles.comprehensive-report', compact('items', 'search_items', 'sort_items', 'sort_type_items', 'date_range_event', 'date_range_start', 'date_range_end'))->with(['minimize_sidebar' => true]);
    }

    public function create()
    {
        $provinces = Province::orderBy('sort', 'ASC')->get();
        return view('panel.main')->nest('content', 'panel.profiles.create');
    }

    public function edit($profile_id)
    {
        $provinces = Province::orderBy('sort', 'ASC')->get();
        $profile = Profile::with([
            'inProgressBy',
            'user.affiliationPartner',
            'user.roles',
            'invoices' => function ($q) {
                return $q->orderBy('created_at', 'DESC')->limit(10);
            },
            'orders' => function ($q) {
                return $q->orderBy('created_at', 'DESC')->limit(10);
            },
        ])->findOrFail($profile_id);
        $questions = QuestionHelper::getAllQuestions(true, true);
        return view('panel.main')->nest('content', 'panel.profiles.set', compact('profile', 'questions', 'provinces'));
    }

    public function update($profile_id, Request $request)
    {
        $profile = Profile::findOrFail($profile_id);
        // save this action's log for the profile
        event(new ProfileUpdateRequestEvent($profile, 'array', $request->input()));

        $rules = [];
        // append rules for basic information
        $rules['name'] = 'nullable|string|max:255';
        $rules['note'] = 'nullable|string|max:2000';
        $rules['gender'] = 'string|in:male,female';
        $rules['date_of_birth'] = 'nullable|jdate';
        $rules['height'] = 'nullable|numeric|max:300|min:5';
        $rules['marital_status'] = 'in:single,married';
        $rules['last_diet'] = 'max:255';
        $rules['blood_type'] = 'max:10';
        $rules['illness_history'] = 'max:500';
        $rules['favorite_foods'] = 'max:500';
        $rules['disgusting_foods'] = 'max:500';
        $rules['prohibited_foods'] = 'max:500';
        $rules['province_id'] = 'exists:provinces,id';
        $rules['city'] = 'max:255';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            flashError(__('general.data_will_be_lost_by_leaving_this_page'));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only($this->saveRequestInputs);
        $data['is_dissatisfied'] = $request->has('is_dissatisfied');
        $data['in_progress'] = $request->has('in_progress');
        $data['date_of_birth'] = !empty($data['date_of_birth']) ? jdateToTimestamp($data['date_of_birth']) : null;

        // if the admin (operator) checks in_progress, so she will be in charge to follow the next steps
        if (!empty($data['in_progress'])) {
            $data['in_progress_by'] = Auth::guard('admin')->user()->id;
        } else {
            // if before this update, profile was in_progress, and now in_progress is empty, it means
            // that admin is not in charge any more
            $data['in_progress_by'] = null;
        }
        $update_result = $profile->update($data);

        if (empty($update_result)) {
            return redirect()->back()->withErrors( __('general.data_will_be_lost_by_leaving_this_page'))->withInput();
        }
        // save this action's log for the profile
        event(new ProfileUpdatedEvent($profile, 'array', $data));
        # =========================  profile log -  end  ========================= #

        return redirect()->back()->with('success', __('general.data_saved_successfully'));
    }

    public function updateQuestionsAnswers($profile_id, Request $request)
    {
        $profile = Profile::findOrFail($profile_id);
        // save this action's log for the profile
        event(new ProfileUpdateRequestEvent($profile, 'array', $request->input()));
        $questions = QuestionHelper::getAllQuestions(true);
        // you can skip require even when the question is_required_to_receive_diet and $user_can_pay_without_answering_diet_required_questions
        // you can set list of questions short_names which are required even when the question not is_required_to_receive_diet and not $user_can_pay_without_answering_diet_required_questions
        // read mangeRequestBasedOnQuestions() description in QuestionHelper()
        $manged = QuestionHelper::mangeRequestBasedOnQuestions($questions, $request, true);

        $rules = $manged['rules'];
        $attributes = $manged['attributes'];
        $questions_data = $manged['data'];

        # =========================  manage data_comment attributes (operator_comment) - start ========================= #
        // show proper message for error
        foreach ($questions as $question) {
            $attributes['data_comments.' . $question->id] = __('general.operator_comment') . " '" . $question->title . "'";
        }
        $rules['data_comments.*'] = 'nullable|string|max:255';
        # =========================  manage data_comment attributes (operator_comment) -  end  ========================= #

        $validator = Validator::make($request->all(), $rules, [], $attributes);
        if ($validator->fails()) {
            flashError(__('general.data_will_be_lost_by_leaving_this_page'));
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->only($this->saveRequestInputs);
        $data['data'] = $questions_data;
        $data['data_comments'] = collect($request->input('data_comments'))->only($questions->pluck('id'))->reject(function ($comment) {
            return empty($comment);
        })->toArray();

        $update_result = $profile->update($data);

        if (empty($update_result)) {
            return redirect()->back()->withErrors( __('general.data_will_be_lost_by_leaving_this_page'))->withInput();
        }
        # =========================  profile log - start ========================= #
        $profile_log_data = $data;
        // data_comments uses questions ids to keep data, we want to use question's short_name to keep data
        // to make it more readable as an individual document in profile log
        if (!empty($profile_log_data['data_comments'])) {
            $translated_data_comments = [];
            foreach ($profile_log_data['data_comments'] as $question_id => $comment) {
                $question = collect($questions)->where('id', $question_id)->first();
                if (!empty($question)) {
                    $translated_data_comments[$question->short_name] = $comment;
                }
            }
            $profile_log_data['data_comments'] = $translated_data_comments;
        }
        // save this action's log for the profile
        event(new ProfileUpdatedEvent($profile, 'array', $profile_log_data));
        # =========================  profile log -  end  ========================= #

        return redirect()->back()->with('success', __('general.data_saved_successfully'));
    }

    public function store(Request $request)
    {
        // sanitizeMobileNumber: convert persian digits to english digits, add 0 to the first of mobile number (if it is required)
        UserHelper::sanitizeMobileNumber($request);

        // create basic user and profile, admin can complete user's data in profile's edit page
        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required', 'unique:users', new ValidMobileNumber()],
            'name' => ['required'],
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only([
            'name', 'mobile_number'
        ]);
        // createUser will file ProfileStoredEvent
        $user = UserHelper::createUser($data, true);
        $profile = $user->profiles()->first();
        $redirect_url = route('panel.profiles.edit', ['profile' => $profile->id]);
        return setSuccessfulResponse($redirect_url);
    }
}
