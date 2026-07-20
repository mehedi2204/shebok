<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

Route::get("/lang/{locale}", function ($locale) {
    if (in_array($locale, ["en", "bn"])) {
        session(["locale" => $locale]);
    }
    return redirect()->back();
});

// Auth Routes
Route::get("/login", [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::get("/register", [AuthController::class, "showRegister"]);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/logout", [AuthController::class, "logout"])->name("logout");

// User Routes
Route::get("/", [HomeController::class, "index"]);
Route::get("/packages", [HomeController::class, "packages"]);
Route::get("/about-us", [HomeController::class, "about"]);
Route::get("/contact-us", [HomeController::class, "contact"]);
Route::post("/contact-us", [HomeController::class, "storeContact"])->name('contact.store');
Route::get("/help-center", [HomeController::class, "help"]);
Route::get("/privacy-policy", [HomeController::class, "privacy"]);
Route::get("/terms-of-service", [HomeController::class, "terms"]);

Route::get("/services", [ServiceController::class, "index"]);
Route::get("/service-provider/{id}", [ServiceController::class, "show"]);

// Location API
Route::get("/api/locations/countries", [\App\Http\Controllers\LocationController::class, "getCountries"]);
Route::get("/api/locations/{parentId}/children", [\App\Http\Controllers\LocationController::class, "getChildren"]);

Route::middleware(['auth'])->group(function () {
    Route::get("/user/dashboard", [UserController::class, "dashboard"]);
    Route::get("/user/profile", [UserController::class, "showProfile"])->name('user.profile');
    Route::post("/user/profile", [UserController::class, "updateProfile"])->name('user.profile.update');
    Route::delete("/user/profile", [UserController::class, "deleteAccount"])->name('user.profile.delete');
    Route::post("/user/toggle-provider-status", [UserController::class, "toggleProviderStatus"])->name('user.toggle-provider-status');

    Route::get("/service-giver/setup-profile", [ServiceController::class, "showSetupProfile"])->name('provider.setup');
    Route::post("/service-giver/setup-profile", [ServiceController::class, "storeProfile"]);

    Route::post("/service-provider/{id}/rate", [ServiceController::class, "rateProvider"])->name('provider.rate');
    Route::post("/service-provider/{id}/save", [ServiceController::class, "saveProfile"])->name('provider.save');

    Route::get("/chat", [\App\Http\Controllers\ChatController::class, "index"])->name('chat.index');
    Route::get("/chat/{id}", [\App\Http\Controllers\ChatController::class, "show"])->name('chat.show');
    Route::post("/chat/{id}", [\App\Http\Controllers\ChatController::class, "store"])->name('chat.store');
    Route::get("/chat/start/{receiverId}", [\App\Http\Controllers\ChatController::class, "start"])->name('chat.start');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get("/dashboard", [AdminController::class, "dashboard"]);

    // Categories
    Route::get("/categories", [AdminController::class, "categories"])->name('admin.categories');
    Route::post("/categories", [AdminController::class, "storeCategory"])->name('admin.categories.store');
    Route::get("/categories/{id}/edit", [AdminController::class, "editCategory"])->name('admin.categories.edit');
    Route::put("/categories/{id}", [AdminController::class, "updateCategory"])->name('admin.categories.update');
    Route::delete("/categories/{id}", [AdminController::class, "deleteCategory"])->name('admin.categories.delete');

    // Locations
    Route::get("/locations", [AdminController::class, "locations"]);
    Route::post("/locations", [AdminController::class, "storeLocation"])->name('admin.locations.store');
    Route::delete("/locations/{id}", [AdminController::class, "deleteLocation"])->name('admin.locations.delete');

    // Approvals
    Route::get("/approvals", [AdminController::class, "approvals"]);
    Route::post("/approve-provider/{id}", [AdminController::class, "approveProvider"])->name('admin.approve-provider');
    Route::post("/reject-provider/{id}", [AdminController::class, "rejectProvider"])->name('admin.reject-provider');
    Route::post("/approve-update/{id}", [AdminController::class, "approveUpdate"])->name('admin.approve-update');
    Route::post("/reject-update/{id}", [AdminController::class, "rejectUpdate"])->name('admin.reject-update');

    // Users
    Route::get("/users", [AdminController::class, "users"])->name('admin.users');
    Route::get("/users/{id}", [AdminController::class, "showUser"])->name('admin.users.show');
    Route::get("/users/{id}/edit", [AdminController::class, "editUser"])->name('admin.users.edit');
    Route::put("/users/{id}", [AdminController::class, "updateUser"])->name('admin.users.update');
    Route::post("/users/{id}/toggle-status", [AdminController::class, "toggleUserStatus"])->name('admin.users.toggle-status');
    Route::delete("/users/{id}", [AdminController::class, "deleteUser"])->name('admin.users.delete');

    // Packages
    Route::get("/packages", [AdminController::class, "packages"]);
    Route::post("/packages", [AdminController::class, "storePackage"])->name('admin.packages.store');
    Route::delete("/packages/{id}", [AdminController::class, "deletePackage"])->name('admin.packages.delete');

    // Form Builder
    Route::get("/form-builder", [AdminController::class, "formBuilder"])->name('admin.form-builder');
    Route::post("/form-builder/field", [AdminController::class, "storeField"])->name('admin.form-builder.store-field');
    Route::delete("/form-builder/field/{id}", [AdminController::class, "deleteField"])->name('admin.form-builder.delete-field');

    Route::get("/settings", [AdminController::class, "settings"])->name('admin.settings');
    Route::post("/settings", [AdminController::class, "updateSettings"])->name('admin.settings.update');

    Route::get("/messages", [AdminController::class, "messages"])->name('admin.messages');
    Route::get("/messages/{id}", [AdminController::class, "showMessage"])->name('admin.messages.show');
    Route::delete("/messages/{id}", [AdminController::class, "deleteMessage"])->name('admin.messages.delete');
});
