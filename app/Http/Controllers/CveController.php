<?php

namespace App\Http\Controllers;

use App\Cve;
use App\Http\Requests\CveGetRequest;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CveController extends Controller
{

    /**
     * @param $cveNumber
     * @return JsonResponse
     */
    public function details($cveNumber){
        $validation = Validator::make([
            'cveNumber' => $cveNumber
        ],[
            'cveNumber' => 'alpha_dash|exists:cve,name'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //Cache::forget("cve_CVE-2019-0001"); // Clear cache
        $key = "cve_{$cveNumber}";
        $cve = Cache::get($key); // Check if the cache exist
        if(!$cve) {
            $cve = Cve::where([
                'name' => $cveNumber
            ])->first();

            Cache::forever($key, $cve); // Save the result into Redis
        }
        return response()->json($cve, Response::HTTP_OK);
    }

    /**
     * Get all cve's
     * @param CveGetRequest $request
     * @return JsonResponse
     */
    public function all(CveGetRequest $request){
        $year      = date("Y");
        $offset    = 0;
        $limit     = 50;
        $validated = $request->validated(); // Validate the request

        if(is_object($validated) && $validated->fails()){
            return response()->json($validated->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($request->has('offset')) {
            $offset  = (int) $request->input('offset');
        }
        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
        }
        if ($request->has('year')) {
            $year   = (int) $request->input('year');
        }
        $key = "cve_page_{$offset}";
        //Cache::forget("cve_page_0"); // Clear cache
        $cve = Cache::get($key); // Check if the cache exist
        if(!$cve){
            $cve  = Cve::query()
                ->where("name","like","%-{$year}-%")
                ->limit($limit)
                ->offset($offset)
                ->get();
            Cache::forever($key, $cve); // Save the result into Redis
        }
        return response()->json($cve, Response::HTTP_OK);
    }
}
