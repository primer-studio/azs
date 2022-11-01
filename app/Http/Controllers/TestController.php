<?php

namespace App\Http\Controllers;

use App\Food;
use App\Http\Controllers\ThirdParty\SmsController;
use App\Invoice;
use App\Jobs\AdminNewOrderJob;
use App\Libraries\UserHelper;
use App\Mail\OrderCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class TestController extends Controller
{
    public function GenerateOTP()
    {
        return substr(str_shuffle('0123456789' . time()), 6, 5);
    }

    public function test()
    {
//        $adapter = new SmsController();
//        $adapter->SendVerificationCode('09128026221', $this->GenerateOTP());
//        $user = User::where('mobile_number', Auth::user()->mobile_number)
//            ->first()
//            ->profiles
//            ->whereNotNull('name')
//            ->first();
//        return is_null($user) ? "کاربر" : $user->name;


//        $invoice = Invoice::findOrFail(4650);
//        $backpack = [
//            'is_test' => true,
//            'invoice_id' => $invoice->id
//        ];
////        return (new OrderCreated($backpack))->render();
//        Mail::to('arbazargani1998@gmail.com')->send(new OrderCreated($backpack));

//        AdminNewOrderJob::dispatchNow($backpack);


        $input = 'ماده غذائی مقدار کالری
آش جو یک لیوان ۱۵۰
آش دوغ یک لیوان ۲۱۷
آش رشته یک لیوان ۲۶۱
آجیل سنتی ۱۰۰ گرم ۴۵۰
آجیل بدون پوست ۱۰۰گرم ۴۶۰
آرد ذرت ۱۰۰ گرم ۳۷۰
آرد گندم ۱۰۰ گرم
 ۳۴۰ آلبالو ( کمپوت) ۱۰۰ گرم ۸۱
آلبالو با هسته ۱۰۰گرم ۵۰
آلبالو تازه با هسته یک لیوان ۶۰
انجیر تازه یک عدد ۳۷
انجیر (تازه) ۱۰۰گرم ۷۴
انجیر خشک ۱۰۰گرم ۲۴۹
انگور ۱۰۰گرم ۶۹
انگور(آب) یک لیوان ۱۵۰
مغز بادام  ۱۰۰گرم ۵۷۵
پودر بادام ۱۰۰گرم ۵۸۳
بادام هندی ۱۰۰ گرم ۵۵۳
بادام زمینی ۱۰۰گرم ۵۶۷
بادمجان ۱۰۰گرم ۲۵
برنج پخته (آبکش) یک کفگیر ۲۳۸
بستنی پاستوریزه ۱۰۰گرم ۲۰۷
به ۱۰۰گرم ۵۷
بیسکویت ساقه طلایی ۱ عدد ۵۵
بیفتک ۱۰۰گرم ۲۲۵
پاچه پخته ۱۰۰گرم ۲۵۸
پرتقال ۱ عدد ۶۹
پرتقال (آب) یک لیوان ۱۰۷
مغز پسته یک عدد ۷
پودر پسته ۱۰۰گرم ۵۷۰
تخم کدو ۱۰۰گرم ۵۵۹
تخم مرغ (زرده تنها) یک عدد ۵۵
تخم مرغ (سفیده تنها) یک عدد ۳۴
تخم مرغ آب پز یک عدد ۷۸
تخم مرغ عسلی یک عدد ۷۲
تخم مرغ نیمرو کم روغن یک عدد ۹۸
تخم هندوانه ۱۰۰گرم ۵۵۷
ترب ۱۰۰گرم ۱۷
تربچه یک عدد ۱
ترخون خشک ۱۰۰گرم ۲۹۱
جگر سفید ۱۰۰گرم ۱۱۳
جگر مرغ پخته ۲۰ گرم ۱۳۷
جگر مرغ (دوپیازه) ۱۰۰گرم ۱۵۰
جگر یک سیخ ۵۰گرم ۱۱۱
جو  ۱۰۰گرم ۳۵۴
چاشنی مایونز ۱ قاشق غذاخوری ۱۲۰
چای تلخ یک لیوان ۰
چای شیرین (۴حبه قند) یک لیوان ۴۰
چغندر پخته (لبو) ۱۰۰گرم ۴۴
چغندر خام ۱۰۰گرم ۴۳
خرما یک عدد ۲۰
خرما با هسته ۱۰۰گرم ۲۸۲
خرما (چیپس) ۱۰۰گرم ۲۷۵
خرمالو یک عدد ۱۱۲
خرمای دگلت نور ۱۰۰گرم ۲۸۲
خرمای مجول ۱۰۰گرم ۲۷۷
خیار ۱۰۰گرم ۱۵
خیار شور ۱۰۰گرم ۱۱
تخمه آفتابگردان ۱۰۰گرم ۵۹۲
دنت دسر کرم کارامل ۱۰۰ گرم ۱۲۳
روغن زیتون یک قاشق ۱۲۰
روغن نباتی ۱ قاشق ۱۲۴
ریحان ۱۰۰گرم ۲۲
ریواس ۱۰۰گرم ۲۱
زبان گوساله ۱۰۰گرم ۲۰۲
زبان گوسفند ۱۰۰گرم ۲۲۲
زردآلو تازه ۱ عدد ۱۷
زردآلو(برگه خشک) ۱۰۰گرم ۲۴۱
زردآلو(کمپوت) یک لیوان ۱۱۷
زیتون پرورده ۱۰۰ گرم ۴۰۰
سوپ گوجه فرنگی ۱ لیوان ۱۲۰
سوپ سبزیجات ۱ لیوان ۷۷
سوپ جو ۱ لیوان ۱۵۰
سوخاری (نان) ۱ عدد ۴۱
سوسیس ۱۰۰گرم ۳۰۰
سوسیس بندری ۱ قاشق ۴۳
سویا (آجیل) ۱۰۰گرم ۴۴۶
سیب با پوست ۱ عدد  ۸۰
سیب زمینی آبپز ۱ عدد ۷۴
سیب زمینی (پوره) ۱۰۰گرم ۸۹
شیرینی خشک ۱ عدد ۲۲۶
شکر سفید ۱۰۰گرم ۳۸۶
شکر قهوه‌ای ۱۰۰ گرم ۳۸۱
شکلات تلخ ۱۰۰گرم ۵۹۰
شکلات صبحانه یک قاشق ۱۰۰
شکوفه ذرت بدون روغن یک لیوان ۲۵
شلغم ۱۰۰گرم ۲۸
شلیل ۱ عدد ۶۲
شنبلیله ۱۰۰گرم ۴۳
شوید(شبد) ۱۰۰گرم ۳۰
عدسی یک لیوان ۲۵۰
عدس (دال عدس) ۱ لیوان ۱۵۳
 عسل ۱۰۰ گرم ۳۰۰
عناب خشک یک عدد ۵
فرنی یک لیوان ۲۵۰
فلفل سبزیا قرمز ۱۰۰گرم ۴۰
فلافل یک عدد ۵۰
فندق یک عدد ۹
قارچ خام ۱۰۰گرم ۲۲
قره قوروت ۱۰۰گرم ۲۴۰
کدو حلوایی ۱۰۰گرم ۲۶
کدو سبز خام ۱۰۰گرم ۱۷
کرفس ۱۰۰گرم ۱۴
کره گیاهی ۱۰۰ گرم ۷۱۷
کره حیوانی ۱۰۰گرم ۷۵۰
کشک خشک ۱۰۰گرم ۳۷۰
کشک بادمجان ۱ قاشق ۵۶
کشمش ۱۰۰گرم ۲۹۶
کلم پیچ ۱۰۰گرم ۲۵
کلم پلو با گوشت ۱ قاشق ۴۸
کیک شکلاتی ۱۰۰گرم ۴۶۶
کیک یزدی متوسط ۱ عدد ۱۲۰  
گردو (مغز) یک عدد ۳۰
گریپ فروت  ۱۰۰گرم ۳۴
گریپ فروت (آب) یک لیوان ۸۰
گرمک ۱۰۰ گرم ۸۰
گز ۱۰۰گرم ۳۸۵
گشنیز ۱۰۰گرم ۲۰
گلابی متوسط ۱ عدد ۱۰۰
گندم (سبوس) ۱۰۰گرم ۲۱۶
گوشت بوقلمون ۱۰۰گرم ۱۲۰
گوشت قرمز ۱۰۰گرم ۲۵۰
گوشت کوبیده ۱۰۰گرم ۲۴۶
گوشت ماهی ۱۰۰گرم ۱۰۰
گوشت مرغ ۱۰۰گرم ۲۰۰
گوجه فرنگی ۱۰۰گرم ۱۹
گیلاس ۱ عدد ۵
لپه خام ۱۰۰گرم ۳۴۱
لپه پخته ۱۰۰گرم ۱۱۷
خوراک لوبیا سبز ۱۰۰گرم ۱۳۶
لیمو ترش ۱۰۰ گرم ۳۰
لیمو شیرین ۱۰۰گرم ۳۰
مارچوبه ۱۰۰گرم ۲۰
مارمالاد ۱۰۰گرم ۲۴۶
مارشمالو ۱۰۰ گرم ۳۳۶
ماست ۱۰۰گرم ۵۵
ماست کم چرب یک لیوان ۱۰۰
ماست چکیده ۱۰۰گرم ۸۹
ماکارونی با مخلفات ۱ لیوان ۲۴۷
ماکارونی (سالاد) یک لیوان ۳۲۵
مغز گردو ۱۰۰گرم ۶۵۱
موز ۱ عدد ۱۰۵
شیرموز یک لیوان ۱۵۷
میگو سوخاری ۱ عدد ۲۷
نارگیل (پودر) ۱۰۰گرم ۷۲۰
نارگیل  ۱۰۰گرم ۳۵۴
شیرینی نارگیلی ۱۰۰گرم ۲۹۰
نارنج ۱ عدد ۴۰
نارنگی ۱۰۰گرم ۵۳
نان سنگک (کف دست) ۳۰ گرم ۷۵
نان بربری (کف دست) یک عدد ۷۶
نان لواش  ۱۰۰گرم ۲۸۸
نخود پخته ۱۰۰گرم ۱۶۴
نخود فرنگی (خام) ۱۰۰گرم ۸۱
نوشابه یک لیوان ۱۰۰
نوشمک ۱۰۰گرم ۴۶
ماهی قزل آلا ۱۰۰گرم ۱۰۰
آلوی زرد و قرمز ۱۰۰گرم ۵۰
آناناس ۱۰۰گرم ۶۰
آناناس (کمپوت) ۱۰۰گرم ۷۳
آب آناناس ۱۰۰گرم ۵۱
آلوئه ورا ۱۰۰ گرم ۱۵
اسفناج خام ۱۰۰گرم ۲۳
آلو بخارا ۱۰۰ گرم ۱۰۷
انار  ۱۰۰گرم ۸۳
رب انار ۱۰۰کرم ۲۹۰
انبه ۱۰۰گرم ۶۰
باقلا یک عدد ۵
باقلا سبز ۱ لیوان ۱۳۹
باقلا خشک ۱۰۰گرم ۳۵۳
باقلوا  ۱۰۰گرم ۳۹۰
بامیه(سبز) ۱۰۰گرم ۳۳
برگ چغندر ۱۰۰گرم ۲۲
برگ مو (دلمه) ۱ عدد ۱۵۰
برنج (کته) ۱ کفگیر  ۲۶۰
برنج قهوه‌ای (پخته) ۱ کفگیر ۲۰۰
شیر برنج ۱ لیوان ۲۵۰
پفک  ۱۰۰ گرم ۴۸۶
پنیر سفید ۱۰۰گرم ۲۶۴
پنیر خامه‌ای ۱۰۰گرم ۳۴۹
پنیر پیتزا ۱۰۰گرم ۲۹۰
پولکی ۱۰۰ گرم ۳۱۳
پوره سیب زمینی یک لیوان ۱۸۲
پیاز یک عدد ۴۴
پیتزا چیکن ۱۰۰ گرم ۲۸۷
پیتزا پپرونی ۱۰۰ گرم ۲۶۷
تخم آفتابگردان ۱۰۰گرم ۵۸۰
تره ۱۰۰گرم ۲۵
تمبر هندی با دانه ۱۰۰گرم ۱۱۵
تمبر هندی بدون دانه ۱۰۰گرم ۲۴۰
تمشک  ۱۰۰گرم ۵۲
تن ماهی با روغن  ۱۰۰گرم ۱۸۶
توت سیاه ۱۰۰گرم ۴۳
توت سفید خشک ۱۰۰گرم ۳۶۵
توت فرنگی ۱۰۰گرم ۳۲
جعفری ۱۰۰گرم ۲۲
چیپس ۱۰۰گرم ۵۳۶
چیپس و پنیر ۱۰۰ گرم ۴۹۶
حلوا ۱۰۰گرم ۳۰۴
حلوا ارده ۱۰۰گرم ۴۳۷
حلیم گندم ۱۰۰ گرم ۱۸۴
خامه سفت ۱۰۰گرم ۳۴۵
خامه شل ۱۰۰گرم ۲۵۰
خاویار ۱۰۰گرم ۲۶۴  
آب خربزه ۱۰۰گرم ۳۴
خربزه ۱۰۰ گرم ۳۶
خردل ۱۰۰گرم ۶۶
دل گوسفند پخته ۱۰۰گرم ۱۸۵
دل مرغ پخته ۱۰۰گرم ۱۸۵
دلمه برگ مو یک عدد متوسط ۱۵۰
دوغ ۱۰۰گرم ۲۸
آرد ذرت ۱۰۰گرم ۳۷۰
ذرت بو داده با روغن ۱۰۰گرم ۵۰۰
ذرت شکوفه کم روغن ۱۰۰گرم ۳۷۵
دانه ذرت پخته ۱۰۰گرم ۹۸
رطب ۱۰۰گرم ۲۸۲
روغن حیوانی ۱۰۰گرم
۸۸۹ زیتون سبز ۱۰۰گرم ۱۰۰
زیتون سیاه ۱۰۰ گرم ۱۲۵
ژله آماده شده  ۱۰۰گرم ۶۲
ژله (پودر) ۱۰۰ گرم ۲۶۶
ساندویچ مرغ ۱۰۰ گرم  ۲۸۳
ساندویچ همبرگر ۱۰۰ گرم ۲۹۵
سرکه انگور ۱۰۰ گرم ۱۸
سمنو ۱۰۰ گرم ۱۵۰
سنجد ۱۰۰گرم ۱۳۰
سنگدان مرغ ۱۰۰گرم ۱۵۴
سیب زمینی آب پز ۱۱۰ گرمی ۸۶
سیب زمینی سرخ کرده ۱۰۰گرم ۳۱۲
آب سیب ۱۰۰ گرم ۴۶
کمپوت سیب  ۱۰۰ گرم ۶۷
سیر ۱۰۰گرم ۱۴۹
سیرابی ۱۰۰گرم ۱۳۹
شاهی ۱۰۰گرم ۲۲
شربت آلبالو ۱۰۰ گرم ۲۶۰
شربت پرتقال ۱۰۰ گرم  ۲۱۷
شربت افرا ۱۰۰ گرم ۲۶۰
شیر کاکائو ۱۰۰ گرم ۸۳
شیربز ۱۰۰ گرم ۶۹
شیرخشک ۱۰۰گرم ۴۹۶
شیر گاو کم چرب ۱۰۰گرم ۴۲
شیرگاو پرچرب ۱۰۰گرم ۵۸
شیر سویا ۱۰۰گرم ۴۵
صدف دریایی ۱۰۰گرم ۱۶۴
طالبی ۱۰۰گرم ۳۴
آب طالبی(بدون شکر) ۱۰۰ گرم ۳۴
جوانه عدس  ۱۰۰گرم ۸۲
قلوه گوسفند ۱۰۰گرم ۱۶۰
قند ۱۰۰گرم ۳۳۳
قهوه تلخ ۱۰۰ گرم ۰
کاکائو ۱۰۰ گرم ۲۲۸
کالباس ۱۰۰گرم ۳۵۳
کاهو ۱۰۰گرم ۱۵
کاهو فرانسوی ۱۰۰ گرم ۲۲
کباب برگ (یک سیخ) ۱۰۰ گرم ۳۶۰
کباب کوبیده (یک سیخ) ۱۰۰ گرم ۲۷۰
کتلت ۱۰۰ گرم ۳۰۰
کلم بروکلی ۱۰۰ گرم ۳۴
کلم بروکسل (فندقی) ۱۰۰گرم ۴۳
کلم قرمز ۱۰۰گرم ۳۱
کله پاچه ۱۰۰گرم ۳۵۰
کمپوت گیلاس ۱۰۰ گرم ۶۲
کنجد ۱۰۰گرم ۵۷۳
کوفته تبریزی ۱۰۰ گرم ۱۷۰
چیز کیک ۱۰۰گرم ۳۲۱
کیک مرغ ۱۰۰گرم ۴۴۴
پنکیک ۱۰۰گرم ۲۲۰
کنسرو گوجه فرنگی ۱۰۰گرم ۱۰۰
گوجه سبز ۱۰۰گرم ۴۷
گوجه فرنگی ۱۰۰گرم ۱۹
آب گوجه فرنگی ۱۰۰گرم ۱۷
رب گوجه فرنگی ۱۰۰ گرم ۸۲
سس کچاپ ۱۰۰گرم ۹۷
گوشت شترمرغ ۱۰۰گرم ۲۰۰
آلبالو	۱ عدد	۳
آلبالو	۱ لیوان	۷۰
آلبالو	۱۰۰ گرم	۶۰
آلو زرد	۱ عدد	۶۰
آلو زرد	۱۰۰ گرم	۷۵
آلو قرمز	۱۰۰ گرم	۴۶
آلو قرمز متوسط	۱ عدد	۴۰
آلوئه‌ور	۱۰۰ گرم	۶۰
آناناس	۱ لیوان	۷۰
آناناس	۱۰۰ گرم	۴۸
آواکادو	۱ عدد	۲۵۰
آواکادو	۱۰۰ گرم	۱۹۰
ازگیل	۱ عدد	۱۰
ازگیل	۱۰۰ گرم	۹۰
انار	۱۰۰ گرم	۴۰
انار بزرگ	۱ عدد	۱۴۰
انار دانه شده	۱ لیوان	۱۲۰
انار دانه شده	۱۰۰ گرم	۶۵
انبه	۱۰۰ گرم	۶۵
انبه متوسط	۱ عدد	۱۳۵
انجیر	۱۰۰ گرم	۷۰
انجیر خشک	۱۰۰ گرم	۳۰۰
انجیر متوسط	۱ عدد	۲۵
انگور	۱ لیوان	۹۰
انگور سبز	۱۰۰ گرم	۷۰
انگور قرمز	۱۰۰ گرم	۷۰
به	۱۰۰ گرم	۳۰
به متوسط	۱ عدد	۷۵
پرتقال	۱۰۰ گرم	۳۵
پرتقال متوسط	۱ عدد	۷۵
تمر هندی	۱ عدد	۵
تمر هندی	۱۰۰ گرم	۲۴۰
تمشک	۱ لیوان	۵۵
تمشک	۱۰۰ گرم	۵۲
توت خشک	۱۰۰ گرم	۳۶۰
توت سفید	۱ عدد	۲
توت سفید	۱ لیوان	۵۰
توت سفید	۱۰۰ گرم	۴۵
توت سیاه (شاه توت)	۱ لیوان	۶۰
توت سیاه (شاه توت)	۱۰۰ گرم	۵۰
توت فرنگی	۱ لیوان	۵۵
توت فرنگی	۱۰۰ گرم	۳۲
توت فرنگی متوسط	۱ عدد	۴
چاقاله بادام	۱ عدد	۴
چاقاله بادام	۱۰۰ گرم	۳۰
خربزه	۱ لیوان	۴۵
خربزه	۱۰۰ گرم	۲۵
خرم	۱ عدد	۲۰
خرم	۱۰۰ گرم	۲۸۰
خرمالو	۱۰۰ گرم	۶۰
خرمالوی متوسط	۱ عدد	۷۰
خیار	۱۰۰ گرم	۱۲
خیار قلمی	۱ عدد	۵
ریواس	۱ لیوان	۲۱
ریواس	۱۰۰ گرم	۲۱
زالزالک	۱ لیوان	۸۰
زالزالک	۱۰۰ گرم	۶۰
زردآلو	۱ عدد	۲۰
زردآلو	۱۰۰ گرم	۵۰
زغال اخته	۱ عدد	۱
زغال اخته	۱ لیوان	۸۵
زغال اخته	۱۰۰ گرم	۵۷
سیب	۱۰۰ گرم	۵۰
سیب متوسط	۱ عدد	۷۵
شلیل	۱۰۰ گرم	۶۰
شلیل متوسط	۱ عدد	۴۴
طالبی	۱ لیوان	۴۵
طالبی	۱۰۰ گرم	۲۵
غوره	۱۰۰ گرم	۳۰
کیوی	۱۰۰ گرم	۵۰
کیوی متوسط	۱ عدد	۴۰
گریپ فروت	۱۰۰ گرم	۳۰
گریپ فروت متوسط	۱ عدد	۸۰
گلابی	۱۰۰ گرم	۵۸
گلابی متوسط	۱ عدد	۸۰
گوجه سبز	۱ عدد	۸
گوجه سبز	۱۰۰ گرم	۳۰
گیلاس	۱ عدد	۴
گیلاس	۱ لیوان	۷۰
گیلاس	۱۰۰ گرم	۶۰
لیمو ترش	۱۰۰ گرم	۳۰
لیمو ترش متوسط	۱ عدد	۲۰
لیمو شیرین	۱۰۰ گرم	۳۰
لیمو شیرین متوسط	۱ عدد	۴۰
موز	۱۰۰ گرم	۷۰
موز بدون پوست	۱۰۰ گرم	۹۵
موز متوسط	۱ عدد	۱۰۰
نارگیل	۱۰۰ گرم	۳۵۵
نارگیل رنده شده	۱ لیوان	۲۵۰
نارنج	۱ عدد	۲۵
نارنج	۱۰۰ گرم	۲۰
نارنگی	۱۰۰ گرم	۴۵
نارنگی کوچک	۱ عدد	۳۵
هلو	۱۰۰ گرم	۴۰
هلو متوسط	۱ عدد	۶۰
هندوانه	۱ لیوان	۴۵
هندوانه	۱۰۰ گرم	۲۵
ساندویچ مرغ ۱۰۰ گرم  ۲۸۳
ساندویچ همبرگر ۱۰۰ گرم ۲۹۵
سرکه انگور ۱۰۰ گرم ۱۸
سمنو ۱۰۰ گرم ۱۵۰
سنجد ۱۰۰گرم ۱۳۰
سنگدان مرغ ۱۰۰گرم ۱۵۴
سیب زمینی آب پز ۱۱۰ گرمی ۸۶
سیب زمینی سرخ کرده ۱۰۰گرم ۳۱۲
آب سیب ۱۰۰ گرم ۴۶
کمپوت سیب  ۱۰۰ گرم ۶۷
سیر ۱۰۰گرم ۱۴۹
سیرابی ۱۰۰گرم ۱۳۹
شاهی ۱۰۰گرم ۲۲
شربت آلبالو ۱۰۰ گرم ۲۶۰
شربت پرتقال ۱۰۰ گرم  ۲۱۷
شربت افرا ۱۰۰ گرم ۲۶۰
شیر کاکائو ۱۰۰ گرم ۸۳
شیربز ۱۰۰ گرم ۶۹
شیرخشک ۱۰۰گرم ۴۹۶
شیر گاو کم چرب ۱۰۰گرم ۴۲
شیرگاو پرچرب ۱۰۰گرم ۵۸
شیر سویا ۱۰۰گرم ۴۵
صدف دریایی ۱۰۰گرم ۱۶۴
طالبی ۱۰۰گرم ۳۴
آب طالبی(بدون شکر) ۱۰۰ گرم ۳۴
جوانه عدس  ۱۰۰گرم ۸۲
قلوه گوسفند ۱۰۰گرم ۱۶۰
قند ۱۰۰گرم ۳۳۳
قهوه تلخ ۱۰۰ گرم ۰
کاکائو ۱۰۰ گرم ۲۲۸
کالباس ۱۰۰گرم ۳۵۳
کاهو ۱۰۰گرم ۱۵
کاهو فرانسوی ۱۰۰ گرم ۲۲
کباب برگ (یک سیخ) ۱۰۰ گرم ۳۶۰
کباب کوبیده (یک سیخ) ۱۰۰ گرم ۲۷۰
کتلت ۱۰۰ گرم ۳۰۰
کلم بروکلی ۱۰۰ گرم ۳۴
کلم بروکسل (فندقی) ۱۰۰گرم ۴۳
کلم قرمز ۱۰۰گرم ۳۱
کله پاچه ۱۰۰گرم ۳۵۰
کمپوت گیلاس ۱۰۰ گرم ۶۲
کنجد ۱۰۰گرم ۵۷۳
کوفته تبریزی ۱۰۰ گرم ۱۷۰
چیز کیک ۱۰۰گرم ۳۲۱
کیک مرغ ۱۰۰گرم ۴۴۴
پنکیک ۱۰۰گرم ۲۲۰
کنسرو گوجه فرنگی ۱۰۰گرم ۱۰۰
گوجه سبز ۱۰۰گرم ۴۷
گوجه فرنگی ۱۰۰گرم ۱۹
آب گوجه فرنگی ۱۰۰گرم ۱۷
رب گوجه فرنگی ۱۰۰ گرم ۸۲
سس کچاپ ۱۰۰گرم ۹۷
گوشت شترمرغ ۱۰۰گرم ۲۰۰
گوشت گوسفندی آبپز ۱۰۰گرم ۲۵۰
گوشت شتر ۱۰۰گرم ۲۵۰
گوشت گوساله ۱۰۰گرم ۲۵۰
لوبیا چشم بلبلی پخته ۱۰۰گرم ۹۷
لوبیا سبز پخته ۱۰۰گرم ۳۵
لوبیا سفید پخته ۱۰۰گرم ۱۴۰
لوبیا چیتی پخته ۱۰۰گرم ۱۲۰
لوبیا قرمز پخته ۱۰۰ گرم ۱۲۷
آب لیمو ترش ۱۰۰ گرم ۲۲
آب لیمو شیرین ۱۰۰گرم ۲۵
مربای گل سرخ ۱۰۰گرم ۲۹۴
مربای انجیر ۱۰۰گرم ۳۰۵
مربای تمشک ۱۰۰گرم ۳۲۰
مربای سیب ۱۰۰گرم ۱۲۹
مربای بالنگ ۱۰۰گرم ۲۳۲
مربای به ۱۰۰گرم ۱۳۲
مربای هویج ۱۰۰گرم ۱۷۲
مربای آلبالو ۱۰۰ گرم ۳۴۰
ران مرغ ۱۰۰گرم ۱۸۰
مغز تخمه هندوانه ۱۰۰گرم ۵۸۹
مغز کله پاچه ۱۰۰گرم ۲۷۰
مغز تخمه آفتابگردان ۱۰۰گرم ۶۰۰
مغز فندق ۱۰۰گرم ۶۳۰
نان جو ۱۰۰گرم ۲۵۰
نان خشک ۱۰۰گرم ۳۹۵
نان روغنی ۱۰۰گرم ۳۸۰
نان باگت  ۱۰۰ گرم ۲۵۰
نان خامه ای  ۱۰۰ گرم ۵۰۰
نان تافتون  ۱۰۰ گرم ۲۸۴
نان برنجی ۱۰۰ گرم  ۲۲۱
نان سوخاری(کعک) ۱۰۰ گرم ۴۰۷
نان تست ۱۰۰گرم ۳۱۳
نان گندم محلی ۱۰۰گرم ۲۸۰
کمپوت هلو ۱۰۰ گرم ۴۴
هندوانه ۱۰۰گرم ۳۰
آب هندوانه ۱۰۰گرم ۳۰
هویج زرد ۱۰۰گرم ۴۱
هویج فرنگی ۱۰۰گرم ۴۱
کباب برگ  (۱ سیخ) ۳۶۰
توت سفید تازه ۱۰۰گرم ۴۳
هلو (متوسط) ۱ عدد ۵۹
دیزی یک لیوان ۳۲۰


';
//        if(strpos($input, "\n") !== FALSE) {
//            echo 'New line break found';
//        }
//        else {
//            echo 'not found';
//        }
//        $input = str_replace("\n", '%------%', $input);
//        $must = [
//            0 => ['۱','۲','۳','۴','۵','۶','۷','۸','۹','۰'],
//            1 => '100 گرم',
//            2 => '1 قاشق',
//            3 => '1 عدد',
//            4 => 'یک عدد',
//            5 => '1 لیوان',
//            6 => 'یک لیوان',
//            7 => '1 کفگیر',
//            8 => 'یک کفگیر',
//        ];
//        $replace = [
//            0 => [1,2,3,4,5,6,7,8,9,0],
//            1 => '100گرم',
//            2 => '1قاشق',
//            3 => '1عدد',
//            4 => '1عدد',
//            5 => '1لیوان',
//            6 => '1لیوان',
//            7 => '1کفگیر',
//            8 => '1کفگیر',
//        ];
//        $input = str_replace($must[0], $replace[0], $input);
//        $input = str_replace('100گرم', "---100گرم---", $input);
//        for ($i = 1; $i < count($must); $i++) {
//            $input = str_replace($must[$i], "---".$replace[$i]."---", $input);
//        }
//        $input = explode('%------%', $input);
//        $final = [];
//        foreach ($input as $key => $val) {
////            $input[$key] = explode('---', $val);
//            $content = explode('---', $val);
//            $should_append = true;
//            foreach ($content as $item) {
//                if (is_null($item)) {
//                    $should_append = false;
//                }
//            }
//            if ($should_append) {
//                $final[$key] = $content;
//            }
//        }
////        echo "<pre>";
////        print_r($final);
////        return;
//
//        foreach ($final as $item) {
//            $passed = 0;
//            if (count($item) == 3 && is_numeric($item[2])) {
//                $food = New Food();
//                $food->title = $item[0];
//                $food->status = 'active';
//                $food->unit = $item[1];
//                $food->calories_per_unit = $item[2];
//                $food->save();
//            } else {
//                $passed += 1;
//            }
//        }
//
//        echo "$passed item passed from ".count($final);


        $foods = Food::all();
        foreach ($foods as $food) {

            Food::where('id', $food->id)->update([
                'title' => preg_replace("/&#?[a-z0-9]+;/i", "", $food->title),
            ]);
        }

    }


    public function JwtListenToken()
    {
        define ( '__USERNAME__', 'root' );
        define ( '__PASSWORD__', 'adminstrator09308990856' );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => __BASEAPI__ . '/wp-json/jwt-auth/v1/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "username": "' . __USERNAME__ . '",
                "password": "' . __PASSWORD__ . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $token = json_decode($response)->data->token;
        return $token;
    }

    public function remoteIt()
    {
        define ( '__BASEAPI__', 'http://baniansnp.ir' );
        define ( '__ENDPOINT__', '/wp-json/wp/v2/media' );
        $input = 'https://cdn2.tala.ir/content/thumb/tumbnail800x450/content/post-img/202209/136214-102002.jpg';
        $backpack = [
            'token' => $this->JwtListenToken()
        ];

        $file_name = basename($input);
        file_put_contents($file_name, file_get_contents($input));
        $file = file_get_contents($file_name);
        $mime = mime_content_type($file_name);
        $url = __BASEAPI__ . __ENDPOINT__;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: ' . $mime,
            'Content-Disposition: attachment; filename="' . basename($input) . '"',
            'Authorization: Bearer ' . $backpack['token'],
        ]);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            return 'Error due runnnig curl req: ' . curl_error($ch);
            die();
        }

        curl_close($ch);
        print_r(json_decode($result));
        exit();
    }

    public function AasaamImageHandler($file)
    {
        $contents = Http::withoutVerifying()->get($file)->body();
        $cookie = "zcx_ir_0_4c19_c[u]=WlBPLt; _ym_uid=1661955185596456545; _ym_d=1661955185; _pk_id.2.482c=9b93325409c3f210.1662376073.; _ga_311ESJMFSB=GS1.1.1662380684.3.0.1662380684.60.0.0; _ga=GA1.1.1161054672.1661955183; _ga_FQ74GE5YHY=GS1.1.1662808745.4.1.1662808745.60.0.0; zcx_ir_0_4c19_c[uc]=88; _5e47eb4b310a2a511e1d1862=true; zcx_ir_0_4c19_su=AAAAAhQDBgARIGE4ZjBmMTVhOTVkMzk0YzU4Mzk3NTQ2MDY3OTRkNjUwBgERIDlkNzZkYzBhODJmNDcwNWQyMGE5ZDNmYjc5NTJhY2FlBgIRIDRjOTMwMDg4MjU3NmJjZGI0NGU3MTAyNjhlYjZhYjdh; zcx_ir_0_4c19_remember=9-G7E6mV_c9FviHVfARZiUROteatDVj5wWK7PDoyDO1_khAOweyjTuT1Nyvb3-TTdoX63WWowm7L7ZzIT0blCseI8teQWPJDN5bDIsyT2duEIIlximishTE2GBgMJIYm; zcx_ir_0_4c19_sid=6g5va6lbrrmor2m09b2iu0da34; ACNNOCACHE=ON; zcx_ir_0_4c19_su=AAAAAhQDBgARIGE4ZjBmMTVhOTVkMzk0YzU4Mzk3NTQ2MDY3OTRkNjUwBgERIDlkNzZkYzBhODJmNDcwNWQyMGE5ZDNmYjc5NTJhY2FlBgIRIDRjOTMwMDg4MjU3NmJjZGI0NGU3MTAyNjhlYjZhYjdh";
        Storage::disk("public")->put('uploads/'.basename($file), $contents);

        $response = Http::withoutVerifying()->withDigestAuth('systemapi', 'System@147852')
            ->withHeaders([
                'cookie' => $cookie,
            ])
            ->get('https://www.rokna.net/admin/files/uploader/');

        $source = (string) $response->getBody();

        $doc = new \DOMDocument;
        @$doc->loadHTML(mb_convert_encoding($source, 'HTML-ENTITIES', 'UTF-8'));

        $form_data = [];
        $requirments = [
            'form' => $doc->getElementsByTagName('form'),
            'input' => $doc->getElementsByTagName('input'),
        ];


        $form_data = [
            'action' => $requirments['form'][0]->getAttribute('action'),
            'token' => null,
            'identifier' => null,
            'files' => null,
        ];

        foreach ( $requirments['input'] as $item ) {

            if ($item->getAttribute('name') == 'token') {
                $form_data['token'] = $item->getAttribute('value');
            } elseif ($item->getAttribute('name') == 'identifier') {
                $form_data['identifier'] = $item->getAttribute('value');
            } else {
                //
            }
        }

        $progress = Http::withoutVerifying()->attach('attachment', Storage::disk("public")->get('uploads/'.basename($file)), basename($file))->post($form_data['action'], [
            'token' => $form_data['token'],
            'identifier' => $form_data['identifier']
        ]);

        $identifier = str_replace('jsoncallback(["', '', $progress->body());
        $identifier = str_replace('"]);', '', $identifier);
        $result = [
            'response_body' => $progress->body(),
            'file_identifier' => $identifier
        ];

        /** https://www.rokna.net/files/savefiles/?id=WLV6FbguSCrv&server=https://static1.rokna.net/upload?X-Progress-ID=WLV6FbguSCrv&params[w]=300&params[h]=200 */
        $FORMID = $form_data['identifier'];
        $FORMACTION = $form_data['action'];
        $saveURL = "https://www.rokna.net/files/savefiles/?id=$FORMID&server=$FORMACTION&params[w]=300&params[h]=200";

        $saveProgress = Http::withoutVerifying()->withDigestAuth('systemapi', 'System@147852')
            ->withHeaders([
                'authority'       => "www.rokna.net",
                'accept'          => "*/*",
                'accept-language' => "en-US,en;q=0.9,fa;q=0.8",
                'cookie'          => "$cookie",
                'referer'         => "https://www.rokna.net/admin/files/uploader",
                'sec-ch-ua'       => '"Google Chrome";v="105", "Not)A;Brand";v="8", "Chromium";v="105"',
                'sec-ch-ua-mobile' => '?0',
                'sec-ch-ua-platform' => '"Windows',
                'sec-fetch-dest' => 'empty',
                'sec-fetch-mode' => 'cors',
                'sec-fetch-site' => 'same-origin',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
                'x-requested-with' => 'XMLHttpRequest'
            ])
            ->get($saveURL);
        $op = (array) json_decode($saveProgress->body(), true);
        foreach ($op as $master => $data) {
            return $op[$master]['data']['view'];
        }
    }

    public function adsBuddy()
    {
//        $webpage = Http::withoutVerifying()->get('https://rokna.net');
//        $source = $webpage->body();
//        return view('public.test', compact(['source']));
        return view('public.test');
    }
}
