<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUserInfoCsv;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'userinfo' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $csvFile = file($request->userinfo);

        $chankData = array_chunk($csvFile, 1);

        //return $dataMaps;
        $header    = null;
        $batchData = Bus::batch([])->dispatch();

        foreach ($chankData as $key => $data) {
            $dataMaps = array_map('str_getcsv', $data);
            if (!$header) {
                $header = $dataMaps[0];
                unset($dataMaps[0]);
            }
            $batchData->add(new ProcessUserInfoCsv($dataMaps, $header));
        }
        toastr()->addSuccess('CSV file uploaded and is being processed.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(UserInfo $userInfo) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserInfo $userInfo) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserInfo $userInfo) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo) {
        //
    }
}
