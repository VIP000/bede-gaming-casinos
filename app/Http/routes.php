<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::group(["middleware" => "cors", "prefix" => "api", "namespace" => "Api"], function () {
Route::group(["prefix" => "api", "namespace" => "Api"], function () {
    Route::get("csrf", function() {
        return csrf_field();
    });

    // Route::group(["prefix" => "users", "middleware" => "auth:api"], function () {
    //     Route::get("selected-count", "UserController@totalSelected");
    //     Route::get("balance", "UserController@balance");

    //     Route::group(["prefix" => "basket"], function () {
    //         Route::get("/", "UserController@basketWithSummary");
    //         Route::get("summary", "UserController@basketSummary");

    //         Route::get("purchase", "UserController@purchaseBasketRequest");
    //         Route::post("purchase", "UserController@purchaseBasketConfirmation");
    //     });

    //     Route::group(["prefix" => "transactions"], function () {
    //         Route::get("/", "TransactionHistoryController@getAllTransactions");
    //         Route::get("history", "TransactionHistoryController@getAllTransactions");
    //         Route::post("topup", "TransactionHistoryController@topupAccount");
    //     });
    // });

    // Route::group(["prefix" => "categories"], function () {
    //     Route::get("/", "CategoryController@index");

    //     Route::get("{slug}", "CategoryController@getCategoryChildren");
    //     // Route::get("{slug}/search/{query}", "CategoryController@searchCategory");

    //     Route::get("{parent_slug}/{slug}", "CategoryController@getSubCategoryProducts");
    //     // Route::get("{parent_slug}/{slug}/search/{query}", "CategoryController@searchSubCategory");
    // });

    // Route::group(["prefix" => "products"], function () {
    //     Route::get("/", "ProductController@index");
    //     Route::get("search/{query}", "ProductController@search");
    //     Route::get("{slug}", "ProductController@get");

    //     Route::group(["middleware" => "auth:api"], function () {
    //         Route::get("{slug}/ping/{number}", "BallController@ping");
    //         Route::get("{slug}/reserve/{number}", "BallController@reserve");
    //         Route::get("{slug}/unreserve/{number}", "BallController@unReserve");
    //     });
    // });

    // Route::group(["prefix" => "notifications"], function () {
    //     // Route::get("/", "NotificationController@overview");
    //     // Route::get("unread", "NotificationController@unread");
    //     // Route::get("since-last-login", "NotificationController@sinceLastLogin");

    //     Route::group(["prefix" => "user", "middleware" => "auth:api"], function () {
    //         Route::get("/", "NotificationController@userOverview");
    //         Route::get("unread", "NotificationController@userUnread");
    //         Route::get("since-last-login", "NotificationController@userSinceLastLogin");
    //         Route::get("send-test", "NotificationController@userSendTestNotification");

    //         Route::get("{message_id}", "NotificationController@getMessage");
    //         Route::put("{message_id}", "NotificationController@markMessageAsUnread");
    //         // Route::delete("{message_id}", "NotificationController@deleteMessage");
    //     });

    //     // Route::group(["prefix" => "app"], function () {
    //     //     Route::get("/", "NotificationController@appOverview");
    //     //     Route::get("unread", "NotificationController@appUnread");
    //     //     Route::get("since-last-login", "NotificationController@appSinceLastLogin");
    //     // });
    // });

    // Route::group(["prefix" => "activity"], function () {
    //     Route::get("/", "ActivityController@overview");
    //     Route::get("since-last-login", "ActivityController@sinceLastLogin");
    // });

    // Route::group(["prefix" => "profile"], function () {
    //     Route::get("/", "UserController@getProfile");
    //     Route::post("/", "UserController@updateProfile");
    // });
});

Route::group(["middleware" => "web"], function () {
    Route::auth();

    // Route::any("/", function() {
    //     return redirect(route("home"));
    // });

    Route::get("{vue_capture?}", ["as" => "home", function () {
        return view("welcome");
    }])->where("vue_capture", "[\/\w\.-]*");
});
