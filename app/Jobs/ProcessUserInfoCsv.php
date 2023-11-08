<?php

namespace App\Jobs;

use App\Models\CsvFileUploadReport;
use App\Models\UserInfo;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUserInfoCsv implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $userInfos;
    protected $header;
    protected $fileName;
    /**
     * Create a new job instance.
     */
    public function __construct($userInfo, $header, $fileName) {
        $this->header    = $header;
        $this->userInfos = $userInfo;
        $this->fileName  = $fileName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $totalDuplicateData  = 0;
        $totalInvalidData    = 0;
        $totalInsertData     = 0;
        $totalIncompleteData = 0;
        $totalData           = count($this->userInfos);

        foreach ($this->userInfos as $userInfo) {

            $combineData = array_combine($this->header, $userInfo);

            $duplicateEmail = UserInfo::where('email', $combineData['email'])->orWhere('phone', $combineData['phone'])->exists();

            $emailCheck = preg_match('/^[\w\.-]+@[\w\.-]+\.\w+$/', $combineData['email']);
            $phoneCheck = preg_match('/^\+?(88)?0?1[3-9]\d{8}$/', $combineData['phone']);

            if ($duplicateEmail) {
                $totalDuplicateData++;
            } elseif ($emailCheck == 0 || $phoneCheck == 0) {
                // Check Valid Email and Phone ant count
                $totalInvalidData++;

            } elseif ($this->checkEmptyValue($combineData)) {
                //Incompleted or empty value  check and count
                $totalIncompleteData++;

            } else {
                // Insert the data if it's not a duplicate and not empty or Incompleted
                try {
                    UserInfo::create($combineData);
                    $totalInsertData++;

                } catch (\Exception $e) {
                    // Log the error and continue processing other records
                    \Log::error('Error processing record: ' . $e->getMessage());
                }

            }
        }

        $checkReport = CsvFileUploadReport::where('file_name', $this->fileName)->first();
        if ($checkReport) {
            $checkReport->update([
                "total_data"       => $totalData + $checkReport->total_data,
                "total_store"      => $totalInsertData + $checkReport->total_store,
                "total_duplicate"  => $totalDuplicateData + $checkReport->total_duplicate,
                "total_invalid"    => $totalInvalidData + $checkReport->total_invalid,
                "total_incomplete" => $totalIncompleteData + $checkReport->total_incomplete,
            ]);
        } else {
            CsvFileUploadReport::create([
                "file_name"        => $this->fileName,
                "total_data"       => $totalData,
                "total_store"      => $totalInsertData,
                "total_duplicate"  => $totalDuplicateData,
                "total_invalid"    => $totalInvalidData,
                "total_incomplete" => $totalIncompleteData,
            ]);
        }

    }

    public function checkEmptyValue(array $array) {
        foreach ($array as $value) {
            if (empty($value)) {
                return true;
            }
        }
    }

}
