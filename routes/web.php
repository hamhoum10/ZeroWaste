<?php


use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FrontOffice\RecyclingCenterControllerF;
use App\Http\Controllers\RecyclingTipController;
use App\Http\Controllers\WasteCategoryController;

use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\dashboard\Analytics;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\PostController;
//use App\Http\Controllers\EventController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\LoginBasic;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BestPracticeController;

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

$controller_path = 'App\Http\Controllers';

// Products routes
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('admin/products', [ProductController::class, 'admin'])->name('products.admin');
// Cart routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
Route::put('cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
// Order routes
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('myOrders', [OrderController::class, 'myOrders'])->name('orders.myOrders');
Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::get('myOrders/{id}', [OrderController::class, 'showOwned'])->name('orders.showOwned');
Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::put('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');

// Main Page Route
Route::middleware(['auth', 'role:admin'])->group(function () {
  Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
  Route::get('/admin/user-logs', [AdminController::class, 'viewUserLogs'])
    ->name('admin.user-logs');
});

// Tips & Challenges Routes
Route::middleware(['auth'])->group(function () {
  // Front office routes (user)
  Route::get('/my-recycling-tips', [RecyclingTipController::class, 'myTips'])->name('recycling-tips.my-tips');
  Route::get('/recycling-tips', [RecyclingTipController::class, 'index'])->name('recycling-tips.index');
  Route::post('/recycling-tips/like/{id}', [RecyclingTipController::class, 'like'])->name('recycling-tips.like');
  Route::get('/recycling-tips/create', [RecyclingTipController::class, 'create'])->name('recycling-tips.create');
  Route::post('/recycling-tips/store', [RecyclingTipController::class, 'store'])->name('recycling-tips.store');
  Route::post('/recycling-tips/generate', [RecyclingTipController::class, 'generateTip'])->name('recycling-tips.generate');
  Route::get('/recycling-tips/edit/{id}', [RecyclingTipController::class, 'edit'])->name('recycling-tips.edit');
  Route::put('/recycling-tips/update/{id}', [RecyclingTipController::class, 'update'])->name('recycling-tips.update');
  Route::delete('/recycling-tips/delete/{id}', [RecyclingTipController::class, 'destroy'])->name('recycling-tips.delete');

  Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
  Route::post('/challenges/participate/{id}', [ChallengeController::class, 'participate'])->name('challenges.participate');
  Route::post('/challenges/leave/{id}', [ChallengeController::class, 'leave'])->name('challenges.leave');
  Route::post('/challenges/suggest', [ChallengeController::class, 'suggest'])->name('challenges.suggest');

  // Back office routes (admin)
  Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/recycling-tips/pending', [RecyclingTipController::class, 'pendingTips'])->name('admin.recycling-tips.pending');
    Route::post('/admin/recycling-tips/approve/{id}', [RecyclingTipController::class, 'approveTip'])->name('admin.recycling-tips.approve');
    Route::post('/admin/recycling-tips/reject/{id}', [RecyclingTipController::class, 'rejectTip'])->name('admin.recycling-tips.reject');

    Route::get('/admin/challenges', [ChallengeController::class, 'adminIndex'])->name('admin.challenges.index');
    Route::get('/admin/challenges/create', [ChallengeController::class, 'create'])->name('admin.challenges.create');
    Route::post('/admin/challenges/store', [ChallengeController::class, 'store'])->name('admin.challenges.store');
    Route::get('/admin/challenges/edit/{id}', [ChallengeController::class, 'edit'])->name('admin.challenges.edit');
    Route::post('/admin/challenges/update/{id}', [ChallengeController::class, 'update'])->name('admin.challenges.update');
    Route::post('/admin/challenges/delete/{id}', [ChallengeController::class, 'destroy'])->name('admin.challenges.delete');
  });

});


// layout
Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');

// authentication
//Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
//Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
//Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::post('/auth/register-basic', [RegisterBasic::class, 'register'])->name('register-basic');
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::post('/auth/login-basic', [LoginBasic::class, 'login'])->name('login-basic');
Route::post('/logout', function (\App\Services\LogService $logService) {
  // Log the logout action
  $logService->logAction('logout', 'User logged out');
  Auth::logout(); // Log out the user
  return redirect()->route('auth-login-basic'); // Redirect to the login page
})->name('logout');

// cards
Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');

// User Interface
Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');


//homhoum test


Route::resource('wastecategories', WasteCategoryController::class);

use App\Http\Controllers\RecyclingCenterController;

Route::resource('recycling-centers', RecyclingCenterController::class);
Route::prefix('front')->name('front.')->group(function () {
  Route::get('/recycling-centers', [RecyclingCenterControllerF::class, 'index'])->name('recycling-centers.index');
  Route::get('/recycling-centers/{recyclingCenter}', [RecyclingCenterControllerF::class, 'show'])->name('recycling-centers.show');
});


Route::prefix('best-practices-BackOffice')->group(function () {
  Route::resource('best_practices', BestPracticeController::class)->names([
    'index' => 'back_office.best_practices.index',
    'create' => 'back_office.best_practices.create',
    'store' => 'back_office.best_practices.store',
    'show' => 'back_office.best_practices.show',
    'edit' => 'back_office.best_practices.edit',
    'update' => 'back_office.best_practices.update',
    'destroy' => 'back_office.best_practices.destroy',
  ]);
});


Route::get('/best-practices', [BestPracticeController::class, 'frontOfficeIndex'])->name('best_practices.front_office');
Route::get('/best-practices/{bestPractice}', [BestPracticeController::class, 'frontOfficeShow'])->name('best_practices.show');


Route::resource('categories', CategoryController::class);

