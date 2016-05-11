<?php

Route::group(["middleware" => "web"], function () {
    Route::group(["prefix" => "api", "namespace" => "Api", "as" => "api."], function () {
        Route::get("csrf", ["as" => "csrf", "uses" => function() {
            return csrf_field();
        }]);

        Route::group(["prefix" => "profile", "middleware" => "auth"], function () {
            Route::get("/", "UserController@getProfile");
        });

        // Route::group(["prefix" => "casinos"], function () {
        //     Route::get("/", "CasinoController@index");
        //     Route::get("search/{query}", "CasinoController@search");
        //     Route::get("{slug}", "CasinoController@get");
        // });
    });

    Route::group(["as" => "auth.", "namespace" => "Auth"], function() {
        // Authentication Routes...
        // $this->get("login", ["as" => "login", "uses" => "AuthController@showLoginForm"]);
        $this->post("login", ["as" => "login", "uses" => "AuthController@login"]);
        $this->get("logout", ["as" => "logout", "uses" => "AuthController@logout"]);

        // Registration Routes...
        // $this->get("register", ["as" => "register", "uses" => "AuthController@showRegistrationForm"]);
        $this->post("register", ["as" => "register", "uses" => "AuthController@register"]);

        // Password Reset Routes...
        Route::group(["prefix" => "password", "as" => "password."], function() {
            $this->get("reset/{token?}", ["as" => "reset", "uses" => "PasswordController@showResetForm"]);
            $this->post("email", ["as" => "email", "uses" => "PasswordController@sendResetLinkEmail"]);
            $this->post("reset", ["as" => "reset", "uses" => "PasswordController@reset"]);
        });
    });

    // Route::any("/", function() {
    //     return redirect(route("home"));
    // });

    Route::get("{vue_capture?}", ["as" => "home", function () {
        return view("welcome");
    }])->where("vue_capture", "[\/\w\.-]*");
});
