<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUserInfoCsv;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserInfoController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('user_info.index');
    }
    /**
     * Display a listing using data table.
     */
    public function listDatatable() {
        $datas = UserInfo::query();
        return DataTables::of($datas)
            ->editColumn('created_at', function ($datas) {
                return $datas->created_at->format('d M Y');
            })
            ->addIndexColumn()
            ->make(true);
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

        $fileName = $request->file('userinfo')->getClientOriginalName() . '_' . time();

        $chankData = array_chunk($csvFile, 1000);

        // return $chankData;
        $header    = null;
        $batchData = Bus::batch([])->dispatch();

        foreach ($chankData as $data) {
            $dataMaps = array_map('str_getcsv', $data);
            if (!$header) {
                $header = $dataMaps[0];
                unset($dataMaps[0]);
            }
            $batchData->add(new ProcessUserInfoCsv($dataMaps, $header, $fileName));

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
