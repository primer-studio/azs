<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('my/test', 'TestController@test');

Route::group(['middleware' => ['web', 'checkAffiliationPartner', 'checkTrackingQueryString']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    # =========================  contact us - start ========================= #
    Route::resource('/contact-us-requests', 'ContactUsController')->only('store');
    # =========================  contact us -  end  ========================= #

    # =========================  contact us page - start ========================= #
    Route::get('/contact', 'ContactUsController@index')->name('contact');
    # =========================  contact us page -  end  ========================= #

    # =========================  about us page - start ========================= #
    Route::get('/about', 'AboutUsController@index')->name('about');
    # =========================  about us page -  end  ========================= #

    # =========================  terms page - start ========================= #
    Route::get('/terms', 'TermController@index')->name('terms');
    # =========================  terms page -  end  ========================= #

});


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

# =========================  override login with mobile login - start - start ========================= #
Route::group(['middleware' => 'throttle:5,1'], function () {
    Route::post('/setVerificationCode', 'Auth\LoginController@setVerificationCodeLogin')->name('set-verification-code');
});
Route::post('/login', 'Auth\LoginController@verificationCodeLogin')->name('verification-code-login');
# =========================  override login with mobile login - start -  end  ========================= #


# =========================  admin login - start ========================= #
Route::get('/panel/login', 'Auth\LoginController@showAdminLoginForm')->name('show-admin-login-form');
Route::post('/panel/login', 'Auth\LoginController@adminLogin')->name('admin-login');
Route::post('/panel/logout', 'Auth\LoginController@adminLogout')->name('admin-logout');
Route::get('/confirm-logout/{type}', 'Auth\LoginController@showConfirmLogout')->name('show-confirm-logout');
# =========================  admin login -  end  ========================= #


# =========================  panel (admin) - start ========================= #
Route::group(['middleware' => 'auth:admin', 'prefix' => 'panel', 'namespace' => 'Panel', 'as' => 'panel.'], function () {
    Route::get('/', 'PanelController@home')->name('panel-home');

    # =========================  diets - start ========================= #
    Route::resource("/diets", 'DietController')->except(['destroy']);
    Route::group(['prefix' => 'diets', 'as' => 'diets.'], function () {
        Route::post('{diet}/set-permission', "DietController@setPermission")->name('set-permission');
    });
    # =========================  diets -  end  ========================= #

    # =========================  steps - start ========================= #
    Route::resource("/steps", 'StepsController')->except(['destroy']);
    # =========================  steps -  end  ========================= #

    # =========================  questions - start ========================= #
    Route::resource("/questions", 'QuestionController')->except(['show', 'destroy']);
    Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
        Route::post("/get-all-questions", 'QuestionController@getAllQuestions')->name('get-all-questions');
        Route::get("/tidy-list", 'QuestionController@tidyList')->name('tidy-list');
    });
    # =========================  questions -  end  ========================= #

    # =========================  foods - start ========================= #
    Route::resource("/foods", 'FoodController')->except(['destroy']);
    # =========================  foods -  end  ========================= #

    # =========================  sports - start ========================= #
    Route::resource("/sports", 'SportController')->except(['destroy']);
    # =========================  sports -  end  ========================= #

    # =========================  recommendations - start ========================= #
    Route::resource("/recommendations", 'RecommendationController')->except(['destroy']);
    # =========================  recommendations -  end  ========================= #

    # =========================  orders - start ========================= #
    Route::resource("/orders", 'OrderController')->except(['create', 'destroy']);
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::post("/search", 'OrderController@search')->name('search');
        Route::post("/{order}/store-daily-plan", 'OrderController@storeDailyPlan')->name('store-daily-plan');




        /** V2 - Primer Changes */
        Route::post("/{order}/store-json-daily-plan", 'OrderController@storeJsonDailyPlan')->name('store-json-daily-plan');
        /** V2 - Primer Changes */




        Route::post("/{order}/custom-diet-daily-plan", 'OrderController@storeCustomDailyPlan')->name('store-custom-daily-plan');

        Route::post("/{order}/upload-diet-file", "OrderController@uploadDietFile")->name("upload-diet-file");
        Route::post("/{order}/delete-diet-file", "OrderController@deleteDietFile")->name("delete-diet-file");
    });
    # =========================  orders -  end  ========================= #

    # =========================  invoices - start ========================= #
    Route::resource("/invoices", 'InvoiceController')->except(['create', 'destroy']);
    Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
        Route::post("/recheck-invoice-item/{invoice_item}", 'InvoiceController@recheckInvoiceItem')->name('recheck-invoice-item');
    });
    # =========================  invoices -  end  ========================= #

    # =========================  discounts - start ========================= #
    Route::group(['prefix' => 'discounts', 'as' => 'discounts.'], function () {
        Route::get("/", 'DiscountController@index')->name('index');
        Route::any("/add", 'DiscountController@create')->name('add');
        Route::any("/edit/{id}", 'DiscountController@edit')->name('edit');
    });

    # =========================  discounts -  end  ========================= #

    # =========================  users - start ========================= #
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::post("/set-roles/{user}", 'UserController@setRoles')->name('set-roles');
    });
    # =========================  users -  end  ========================= #

    # =========================  role - permissions - start ========================= #
    Route::resource("/roles", 'RoleController')->except(['show', 'destroy']);
    # =========================  role - permissions -  end  ========================= #

    # ========================= admin role - permissions - start ========================= #
    Route::group(['middleware' => ['can:change_permissions']], function () {
        Route::resource("/admin-roles", 'AdminRoleController')->except(['show', 'destroy']);
    });
    # ========================= admin role - permissions -  end  ========================= #

    # =========================  profiles - start ========================= #
    Route::group(['prefix' => 'profiles', 'as' => 'profiles.'], function () {
        Route::post("/update-questions-answers/{profile}", 'ProfileController@updateQuestionsAnswers')->name('update-questions-answers');
        Route::post("/{profile}", 'ProfileController@update')->name('update');
    });
    Route::resource("/profiles", 'ProfileController')->except(['show', 'update', 'destroy']);
    # =========================  profiles -  end  ========================= #

    # =========================  comprehensive report - start ========================= #
    Route::get('comprehensive-report', "ProfileController@comprehensiveReport")->name('comprehensive-report');
    # =========================  comprehensive report -  end  ========================= #

    # =========================  affiliation partners - start ========================= #
    Route::resource("/affiliation-partners", 'AffiliationPartnerController')->except(['show', 'destroy']);
    # =========================  affiliation partners -  end  ========================= #

    # =========================  cart items - start ========================= #
    Route::resource("/cart-items", 'CartController')->except(['store', 'create', 'show', 'destroy']);
    Route::group(['prefix' => 'cart-items', 'as' => 'cart-items.'], function () {
        Route::post('send-reminder-sms/{cart_item}', "CartController@sendReminderSms")->name('send-reminder-sms');
        // remove by cart item id
        Route::post("{profile}/remove-diet-from-cart", "CartController@removeDietFromCart")->name('remove-diet-from-cart');
        Route::post("{profile}/add-diet-to-cart", "CartController@addDietToCart")->name('add-diet-to-cart');
        Route::post("{profile}/create-invoice-by-cart", "CartController@createInvoiceByCart")->name('create-invoice-by-cart');
    });
    # =========================  cart items -  end  ========================= #

    # =========================  affiliation invoices - start ========================= #
    Route::resource("/affiliation-invoices", 'AffiliationInvoiceController')->except(['show', 'destroy']);
    # =========================  affiliation invoices -  end  ========================= #

    # =========================  profiles - start ========================= #
    Route::group(['middleware' => ['can:change_admins']], function () {
        Route::resource("/admins", 'AdminController')->except(['show', 'destroy']);
    });
    # =========================  profiles -  end  ========================= #

    # =========================  settings - start ========================= #
    Route::group(['middleware' => ['can:change_settings'], 'prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/', 'SettingController@index')->name('show');
        Route::put('/', 'SettingController@save')->name('save');
    });
    # =========================  settings -  end  ========================= #

    # =========================  contact us - start ========================= #
    Route::resource('/contact-us-requests', 'ContactUsController')->only('edit', 'update', 'index');
    # =========================  contact us -  end  ========================= #

    // laravel file manger - start | NOTICE: don't forget to use auth:admin middleware
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    // laravel file manger - end

});
# =========================  panel (admin) -  end  ========================= #


# =========================  dashboard (user) - start ========================= #
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', 'DashboardController@index')->name('home');
    Route::get("/diets", "DietController@index")->name('diets');

    # =========================  profile - start ========================= #
    Route::group(['prefix' => 'my-profiles', 'as' => 'my-profiles.'], function () {
        Route::get('/', "ProfileController@myProfiles")->name('index');
        Route::post('/', "ProfileController@store")->name('store');
        Route::get('/{profile}/edit', "ProfileController@editProfile")->name('edit');
        Route::post('/{profile}/edit', "ProfileController@updateProfile")->name('update');
        Route::post('/set-current-profile', "ProfileController@setCurrentProfile")->name('set-current-profile');
        Route::get('/current-profile', "ProfileController@currentProfile")->name('current-profile');
    });
    # =========================  profile -  end  ========================= #

    # =========================  invoice - start ========================= #
    Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
        Route::get('/', "InvoiceController@index")->name('index');
        Route::get('/{invoice}', "InvoiceController@show")->name('show');
        Route::post("/recheck-invoice-item/{invoice_item}", 'InvoiceController@recheckInvoiceItem')->name('recheck-invoice-item');
    });
    # =========================  invoice -  end  ========================= #

    # =========================  invoice -  end  ========================= #

    # =========================  order - start ========================= #
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', "OrderController@index")->name('index');
        Route::get('/{order}', "OrderController@show")->name('show');
    });
    # =========================  order -  end  ========================= #

    # =========================  offline payment - start ========================= #
    Route::group(['middleware' => 'checkUserIsValid', 'prefix' => 'offline-payment', 'as' => 'offline-payment.'], function () {
        Route::get("/create", "PaymentController@showregisterOfflinePayment")->name('show');
        Route::post("/", "PaymentController@registerOfflinePayment")->name('store');
        Route::get("/", "PaymentController@index")->name('index');
    });
    # =========================  offline payment -  end  ========================= #

    # =========================  payment - start ========================= #
    # tempUser and checkProfileRequiredData middlewares are used in DietController __construct
    Route::get("/pay/{diet_slug}/period/{period}/step/{step_number}", "PaymentController@payWithDietSlug")->name('pay-with-diet-slug');
    Route::post("/pay/IPG", "PaymentController@payIPG")->name('pay-ipg');
    Route::any("/pay/IPG/callback/{gateway_id}/{invoice_id}", "PaymentController@IPGCallback")->name('ipg-callback');
    Route::get("/proforma-invoice", "PaymentController@proformaInvoice")->name('proforma-invoice');



    /** V2 - Primer Changes */
    Route::post("set-discount", 'PaymentController@InvoiceSetDiscount')->name('set-order-discount');
    /** V2 - Primer Changes */


    // remove by cart item id
    Route::post("/remove-diet-from-cart", "PaymentController@removeDietFromCart")->name('remove-diet-from-cart');
    // remove by diet id and period
    Route::post("/proforma-remove-diet-from-cart", "PaymentController@proformaRemoveDietFromCart")->name('proforma-remove-diet-from-cart');
    # =========================  payment -  end  ========================= #

    # =========================  diets - start ========================= #
    Route::group(['middleware' => ['checkAffiliationPartner', 'checkTrackingQueryString'], 'prefix' => 'diets', 'as' => 'diets.'], function () {
        Route::group(['middleware' => 'CheckUserMustPayWithoutAnsweringDietRequiredQuestions'], function () {
            // the following routes must be checked by CheckUserMustPayWithoutAnsweringDietRequiredQuestions middleware
            Route::get("/{slug}/period/{period}/step/{step_number}", "DietController@showStep")->name('show-step');
            Route::post("/{slug}/period/{period}/step/{step_number}", "DietController@saveStepData")->name('save-step-data');
        });
        Route::get("/{slug}", "DietController@show")->name('show');
    });
    # =========================  diets -  end  ========================= #

    # =========================  steps - start ========================= #
    Route::group(['prefix' => 'steps', 'as' => 'steps.'], function () {
    });
    # =========================  steps -  end  ========================= #

    # =========================  notifications - start ========================= #
    Route::get("/notifications", "DashboardController@notifications")->name('notifications');
    # =========================  notifications -  end  ========================= #

});
# =========================  dashboard (user) -  end  ========================= #


Route::get('test', "TestController@adsBuddy");
