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
        foreach ($this->userInfos as $userInfo) {
            $combineData = array_combine($this->header, $userInfo);
            UserInfo::create($combineData);
        }
    }
}
