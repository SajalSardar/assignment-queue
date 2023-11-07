<?php

namespace App\Http\Controllers;

use App\Models\CsvFileUploadReport;
use Yajra\DataTables\Facades\DataTables;

class uploadCsvFileReportController extends Controller {

    // uploaded file report view
    public function csvFileReport() {
        return view('user_info.report');
    }

    //// uploaded file report list datatable
    public function csvFileReportDatatable() {
        $datas = CsvFileUploadReport::query();
        return DataTables::of($datas)
            ->editColumn('created_at', function ($datas) {
                return $datas->created_at->format('d M Y');
            })
            ->addIndexColumn()
            ->make(true);
    }
}
