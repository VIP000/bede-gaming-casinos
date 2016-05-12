<?php

namespace App\Http\Controllers\Api;

use App\Casino;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CasinoController extends Controller
{
    protected $http;

    public function __construct(GuzzleClient $http)
    {
        $this->http = $http;
    }

    public function show(Request $request, $id = false)
    {
        $geolocation = $this->getGeolocationFromCookie($request);

        if (!$geolocation) {
            $geolocation = $this->getGeolocationFromIP($request);
        }

        if (!empty($id)) {
            try {
                $casino = Casino::withDistance($geolocation["lat"], $geolocation["lng"])->findOrFail($id);
            } catch (ModelNotFoundException $e) {
                return app()->abort(404);
            }

            return $this->formatCasino($casino);
        }

        return Casino::withDistance($geolocation["lat"], $geolocation["lng"])->get()->transform(function($casino) {
                        return $this->formatCasino($casino);
                    });
    }

    public function create(Request $request)
    {
        return Casino::create($request->only([
                        "name",
                        "position_lat",
                        "position_lng",
                        "address",
                        "hours",
                    ]));
                    // ->transform(function($casino) {
                    //     return $this->formatCasino($casino);
                    // });
    }

    public function update(Request $request, $id)
    {
        try {
            $casino = Casino::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return app()->abort(404);
        }

        $new = $request->only([
            "name",
            "position_lat",
            "position_lng",
            "address",
            "hours",
        ]);

        foreach ($new as $key => $value) {
            $casino->{$key} = $value;
        }

        return [
            "updated" => $casino->save(),
        ];

        dd($casino);
    }

    public function delete(Request $request, $id)
    {
        try {
            $casino = Casino::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return app()->abort(404);
        }

        return [
            "deleted" => $casino->delete(),
        ];
    }

    protected function formatCasino(Casino $casino)
    {
        $content = view("components.marker", compact("casino"))->render();

        return [
            "id" => $casino->id,
            "name" => $casino->name,
            "position" => [
                "lat" => $casino->position_lat,
                "lng" => $casino->position_lng,
            ],
            "address" => $casino->address,
            "hours" => $casino->hours,
            "distance" => $casino->distance,
            "content" => $content,
        ];
    }

    protected function sendRequest($url, $raw = false)
    {
        try {
            $response = $this->http->request("GET", $url);
        } catch (RequestException $e) {
            return false;
        }

        $response = (string)$response->getBody();

        if ($raw) {
            return $response;
        }

        return json_decode($response);
    }

    protected function getGeolocationFromCookie(Request $request)
    {
        return empty($_COOKIE["geolocation"]) ? false : json_decode($_COOKIE["geolocation"], true);
    }

    protected function getGeolocationFromIP(Request $request)
    {
        $url = sprintf("http://ip-api.com/json/%s", $request->ip());
        $response = $this->sendRequest($url);

        if (empty($response->lat) || empty($response->lng)) {
            return [
                "lat" =>  55.01928299999999,
                "lng" => -1.590985000000046,
            ];
        }

        return [
            "lat" => $response->lat,
            "lng" => $response->lng,
        ];
    }
}
