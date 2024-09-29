<?php

use App\Enums\CategoryEnum;
use App\Http\Controllers\Admin\SecondController;
use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OfferControllerAjax;
use App\Http\Controllers\Relation\RelationController;
use App\Http\Controllers\Youtub\YoutubController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/', function () {
//     //array
//     $data = [
//         'name' => 'Zainab',
//         'age' => 24,
//         'city' => 'taiz'
//     ];
//     //object
//     $obj=new \stdClass();
//         $obj->name='zainab';
//         $obj->id=44789999;
//         $obj->age=10;
//         $data1=['a','b'];
//         $data2=[];
//     return view('welcome',$data,compact('obj','data1','data2'));
// });

Route::get('/index', [UserController::class, 'getIndex']);

Route::get('/landing', function () {
    return view('landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/test1', function () {
    return 'welcome';
});

//route parameter

Route::get('/test2/{id}', function ($id) {

    return $id;
});

//Optional Parameters
Route::get('/test3/{id?}', function () {

    return 'welcome';
});

Route::get('/user/{name?}', function (string $name = 'null') {
    return $name;
});

Route::get('/page/{name?}', function (string $name = 'Zainab') {
    return $name;
});

Route::get('/pageform/{tel}/{name?}', function (int $telephone, string $name = 'Zainab') {
    return $name . '  ' . $telephone;
});

//define as many route parameter
Route::get('/pag1/{id}/pag2/{name}/pag3/{address}', function (int $id_1, string $name, string $address) {

    return $id_1 . ' ' . $name . ' ' . $address;
});

Route::get('/log-form', function () {
    return view('login');
});

//Parameters and Dependency Injection Request

Route::get('/login/{username}/{password}', function (Request $rq, string $name, int $passw) {
    $remember = $rq->input('remember');

    return ' username:' . $name . ' password:' . $passw . ' Remember Me: ' . ($remember ? 'yes' : 'no');
});

//route name
Route::get('/test4/{id}', function ($id) {
    return $id;
})->name('a');

Route::get('/test5/{id?}', function () {

    return 'welcome';
})->name('b');

//Redirect Routes
Route::redirect('/old_page', '/new_page', 302);

//route view
Route::view('/firstpage', 'new_page');

//route view with parameter
Route::view('/firstpage', 'new_page', ['name' => 'zainab']);

//Regular Expression Constraints
Route::get('/main1/{name}', function (string $name) {
    return $name;
});

Route::get('/main2/{id}', function (int $id) {
    return $id;
});

Route::get('/main3/{name}/{id}', function (string $name, int $id) {
    return $name . ' ' . $id;
})->where(['name' => '[a-z]+', 'id' => '[0-9]+']);

Route::get('/main4/{id}', function (int $id) {
    return $id . " this is number";
})->whereNumber('id');

Route::get('/main5/{name}', function (string $name) {
    return $name . " this is alpha";
})->whereAlpha('name');

Route::get('/main6/{name}', function (string $name) {
    return $name . "this is alpha and numeric";
})->whereAlphaNumeric('name');

Route::get('/category/{category}', function (string $category) {
    return 'Category: ' . $category;
})->whereIn('category', ['movie', 'song', 'painting']);

Route::get('/category/{category}', function (CategoryEnum $category) {
    return 'Category: ' . $category->value;
})->whereIn('category', array_map(fn($case) => $case->value, CategoryEnum::cases()));

Route::get('/search/{search}', function (string $search) {
    return $search;
})->where('search', '.*');

Route::namespace('Front')->group(function () {
//all route only access controller or method in folder name Front

    Route::get('users', 'UserController@showUserName');

});

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/', function () {return "hello";});
    Route::get('show', [UserController::class, 'showUserName']);
    Route::get('delete', [UserController::class, 'deleteUserName']);
    Route::get('edit', [UserController::class, 'showUserName']);
    Route::get('update', [UserController::class, 'showUserName']);
});

Route::get('check', function () {
    return 'middleware';
})->middleware('web');

Route::group(['namespace' => 'Admin'], function () {
    Route::get('second0', [SecondController::class, 'showString0']);
    Route::get('second1', [SecondController::class, 'showString1']);
    Route::get('second2', [SecondController::class, 'showString2']);
});

Route::get('secondform', [SecondController::class, 'showString0'])->middleware('auth');

Route::get('/loginuser', function () {
    return view('login');
});

Route::resource('news', NewsController::class);

//////////////////////////////////////////

Route::get('/dashboard', function () {
    return 'Not adualts';
})->name('not.adualts');

// Auth::routes(); // إنشاء مسارات المصادقة

// Route::get('/dashboard', function () {
//     return view('dashboard'); // صفحة لوحة التحكم
// })->middleware('auth')->name('dashboard');

// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// // Route::group('',function(){
// //     //set of routes
// // });
//Auth::routes();
////////////////////////////////////////////

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');

Route::get('/', function () {
    return 'Home';
});

Route::get('fillable', [CrudController::class, 'getOffers']);

############################################################################
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    Route::group(['prefix' => 'offers'], function () {
        //create
        Route::get('create', [CrudController::class, 'createOffer']);
        //store or insert into DB
        Route::post('store', [CrudController::class, 'storeOffer'])->name('offers.store');
        //edit
        Route::get('edit/{offer_id}', [CrudController::class, 'editOffer']);
        //update
        Route::post('update/{offer_id}', [CrudController::class, 'updateOffer'])->name('offers.update');
        //retrieve all data with database
        Route::get('all', [CrudController::class, 'getAllOffers'])->name('offers.all');
        //delete
        Route::get('delete/{offer_id}', [CrudController::class, 'deleteOffer'])->name('offers.delete');
    });
    //route of youtub
    Route::get('/youtube', [YoutubController::class, 'getVideo'])->name('youtube');

});

############################# Begin Ajax routes ########################################
Route::group(['prefix' => 'Ajax-offers'], function () {
    Route::get('create', [OfferControllerAjax::class, 'create']);
    Route::post('store', [OfferControllerAjax::class, 'store'])->name('ajax.offers.store');
    Route::get('all', [OfferControllerAjax::class, 'getAllOffers'])->name('ajax.offers.all');
    Route::post('delete', [OfferControllerAjax::class, 'deleteOffer'])->name('ajax.offers.delete');
    Route::get('edit/{offer_id}', [OfferControllerAjax::class, 'editOffer'])->name('ajax.offers.edit');
    Route::post('update', [OfferControllerAjax::class, 'updateOffer'])->name('ajax.offers.update');

});

############################# End Ajax routes ########################################

####################### Begin Authentication && Guards ##################################
Route::group(['middleware' => 'CheckAge'], function () {
    Route::get('adults', [CustomAuthController::class, 'adualt'])->name('adults');

});

Route::get('site', [CustomAuthController::class, 'site'])->middleware('auth:web')->name('site');
Route::get('admin', [CustomAuthController::class, 'admin'])->middleware('auth:admin')->name('admin');

Route::get('admin/login', [CustomAuthController::class, 'adminlogin'])->name('admin.login');
Route::post('admin/login', [CustomAuthController::class, 'checkadminlogin'])->name('save.admin.login');

####################### End Authentication && Guards ##################################

################################ Begin relations routes ##############################
Route::get('has-one', [RelationController::class, 'hasOneRelation']);

Route::get('has-one-reserve', [RelationController::class, 'hasOneRelationReverse']);

Route::get('get-user-has-phones', [RelationController::class, 'getUserHasPhones']);

Route::get('get-user-not-has-phones', [RelationController::class, 'getUserNotHasPhones']);

######################### Begin one to many relationship ################################

Route::get('hospital-has-many', [RelationController::class, 'getHospitalDoctors']);

Route::get('hospitals', [RelationController::class, 'hospitals'])->name('hospitals');

Route::get('hospitals/{id_hospital}', [RelationController::class, 'deleteHospitals'])->name('deleteHospitals');

Route::get('doctors/{id_hospital}', [RelationController::class, 'doctors'])->name('doctors');

Route::post('doctors/{id_doctor}', [RelationController::class, 'deletsDoctor'])->name('delets');

Route::get('hospitals_has_doctors', [RelationController::class, 'getHospitalsHasDoctor']);

Route::get('hospitals_has_doctors_male', [RelationController::class, 'getHospitalsHasDoctorMale']);

Route::get('hospitals_not_has_doctors', [RelationController::class, 'getHospitalsNotHasDoctor']);

######################### End one to many relationship ################################

######################### Begin many to many relationship ################################

Route::get('doctors_services', [RelationController::class, 'getDoctorServices']);

Route::get('services_doctors', [RelationController::class, 'getServiceDoctor']);

######################### End many to many relationship ################################

################################ End relations routes ##############################