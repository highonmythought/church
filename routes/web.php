<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MemberController, DepartmentController, PastorController, SearchController,
    EventController, AttendanceController, ExpenseController, FinancialRecordController,
    PledgeController, RoleController, UserRoleController, PermissionController,
    EquipmentController, SermonController, EventPhotoController, DashboardController,
    Auth\RegisteredUserController, Auth\AuthenticatedSessionController,
    Auth\ForgotPasswordController, Auth\ResetPasswordController, RolePermissionController,
    NotificationController
};

// ----------------- Public Routes -----------------
Route::get('/', fn() => view('welcome'))->name('home');

// Password Reset
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// ----------------- Authenticated Routes -----------------
Route::middleware(['auth', \App\Http\Middleware\CheckPermission::class])->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->defaults('permission', 'view dashboard');
    Route::view('/profile', 'profile.edit')->name('profile.edit')->defaults('permission', 'edit profile');
// Define all resource controllers and permissions
$resources = [
    'members' => [MemberController::class, 'view members', 'create members', 'edit members', 'delete members'],
    'departments' => [DepartmentController::class, 'view departments', 'create departments', 'edit departments', 'delete departments'],
    'pastors' => [PastorController::class, 'view pastors', 'create pastors', 'edit pastors', 'delete pastors'],
    'events' => [EventController::class, 'view events', 'create events', 'edit events', 'delete events'],
    'attendance' => [AttendanceController::class, 'view attendance', 'create attendance', 'edit attendance', 'delete attendance'],
    'expenses' => [ExpenseController::class, 'view expenses', 'create expenses', 'edit expenses', 'delete expenses'],
    'financial-records' => [FinancialRecordController::class, 'view financial records', 'create financial records', 'edit financial records', 'delete financial records'],
    'pledges' => [PledgeController::class, 'view pledges', 'create pledges', 'edit pledges', 'delete pledges'],
    'equipments' => [EquipmentController::class, 'view equipments', 'create equipments', 'edit equipments', 'delete equipments'],
    'sermons' => [SermonController::class, 'view sermons', 'create sermons', 'edit sermons', 'delete sermons'],
];

// Special routes for individual resources
$specialRoutes = [
    'expenses' => [
        ['get', 'summary', 'summary', 'expenses.summary'],
        ['get', 'export/excel', 'exportExcel', 'expenses.export.excel'],
        ['get', 'export/pdf', 'exportPDF', 'expenses.export.pdf'],
    ],
    'attendance' => [
        ['get', 'chart', 'chart', 'attendance.chart'],
    ],
    'events' => [
        ['post', '{event}/photos', [EventPhotoController::class, 'store'], 'event_photos.store'],
        ['delete', 'photos/{photo}', [EventPhotoController::class, 'destroy'], 'event_photos.destroy'],
    ],
];

foreach ($resources as $prefix => [$controller, $view, $create, $edit, $delete]) {
    Route::prefix($prefix)->group(function () use ($controller, $view, $create, $edit, $delete, $prefix, $specialRoutes) {

        // ✅ Register special routes first if they exist
        if (isset($specialRoutes[$prefix])) {
            foreach ($specialRoutes[$prefix] as $route) {
                [$method, $uri, $action, $name] = $route;

                // Allow array controllers (like EventPhotoController)
                if (is_array($action)) {
                    Route::$method($uri, $action)->name($name)->defaults('permission', "view $prefix");
                } else {
                    Route::$method($uri, [$controller, $action])->name($name)->defaults('permission', "view $prefix");
                }
            }
        }

        // ✅ Standard CRUD routes
        Route::get('/', [$controller, 'index'])->name("$prefix.index")->defaults('permission', $view);
        Route::get('/create', [$controller, 'create'])->name("$prefix.create")->defaults('permission', $create);
        Route::post('/', [$controller, 'store'])->name("$prefix.store")->defaults('permission', $create);
        Route::get('/{id}', [$controller, 'show'])->name("$prefix.show")->defaults('permission', $view);
        Route::get('/{id}/edit', [$controller, 'edit'])->name("$prefix.edit")->defaults('permission', $edit);
        Route::put('/{id}', [$controller, 'update'])->name("$prefix.update")->defaults('permission', $edit);
        Route::delete('/{id}', [$controller, 'destroy'])->name("$prefix.destroy")->defaults('permission', $delete);
        Route::get('/search', [$controller, 'search'])->name("$prefix.search")->defaults('permission', $view);
    });
}



    // Global search & logout
    Route::get('/search', [SearchController::class, 'global'])->name('search')->defaults('permission', 'search');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->defaults('permission', 'logout');
});

// ----------------- Admin Only Routes -----------------
Route::middleware(['auth', 'role:Admin', \App\Http\Middleware\CheckPermission::class])->group(function () {
    $adminResources = [
        'roles' => [RoleController::class, 'view roles', 'create roles', 'edit roles', 'delete roles'],
        'permissions' => [PermissionController::class, 'view permissions', 'create permissions', 'edit permissions', 'delete permissions'],
    ];

    foreach ($adminResources as $prefix => $values) {
        [$controller, $view, $create, $edit, $delete] = $values;

        Route::prefix($prefix)->group(function () use ($controller, $view, $create, $edit, $delete, $prefix) {
            Route::get('/', [$controller, 'index'])->name("$prefix.index")->defaults('permission', $view);
            Route::get('/create', [$controller, 'create'])->name("$prefix.create")->defaults('permission', $create);
            Route::post('/', [$controller, 'store'])->name("$prefix.store")->defaults('permission', $create);
            Route::get('/{id}', [$controller, 'show'])->name("$prefix.show")->defaults('permission', $view);
            Route::get('/{id}/edit', [$controller, 'edit'])->name("$prefix.edit")->defaults('permission', $edit);
            Route::put('/{id}', [$controller, 'update'])->name("$prefix.update")->defaults('permission', $edit);
            Route::delete('/{id}', [$controller, 'destroy'])->name("$prefix.destroy")->defaults('permission', $delete);
        });
    }

    // Event Photos
Route::post('/event-photos', [EventPhotoController::class, 'store'])->name('event_photos.store');
Route::delete('/event-photos/{eventPhoto}', [EventPhotoController::class, 'destroy'])->name('event_photos.destroy');


    Route::get('users/roles', [UserRoleController::class, 'index'])->name('users.roles.index')->defaults('permission', 'view user roles');
    Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.roles.edit')->defaults('permission', 'edit user roles');
    Route::post('users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update')->defaults('permission', 'edit user roles');

    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])->name('roles_permissions.index')->defaults('permission', 'manage roles and permissions');
    Route::post('/assign-role', [RolePermissionController::class, 'assignRole'])->name('roles.assign')->defaults('permission', 'assign roles');
    Route::post('/assign-permission', [RolePermissionController::class, 'assignPermission'])->name('permissions.assign')->defaults('permission', 'assign permissions');
});
Route::post('/notifications/mark-read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'success']);
})->name('notifications.markRead');


Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});


Route::get('/register-member', [MemberController::class, 'publicCreate'])->name('members.publicRegister');
Route::post('/register-member', [MemberController::class, 'publicStore'])->name('members.publicStore');


require __DIR__.'/auth.php';
