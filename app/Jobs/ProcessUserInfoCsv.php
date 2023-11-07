<?php

namespace App\Jobs;

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
    /**
     * Create a new job instance.
     */
    public function __construct($userInfo, $header) {
        $this->header    = $header;
        $this->userInfos = $userInfo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $totalDuplicateData = 0;
        $totalInvalidData   = 0;
        $totalInsertData    = 0;
        $totalData          = count($this->userInfos);

        foreach ($this->userInfos as $userInfo) {
            $combineData    = array_combine($this->header, $userInfo);
            $isEmpty        = empty(array_filter($combineData));
            $duplicateEmail = UserInfo::where('email', $combineData['email'])->exists();

            if ($duplicateEmail) {
                $totalDuplicateData++;
            } elseif ($isEmpty) {
                // Check for empty values
                $totalInvalidData++;
            } else {
                // Insert the data if it's not a duplicate and not empty
                try {
                    UserInfo::create($combineData);
                    $totalInsertData++;

                } catch (\Exception $e) {
                    // Log the error and continue processing other records
                    \Log::error('Error processing record: ' . $e->getMessage());
                }

            }

        }
    }
}
