<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $text;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text) //これで変数を値を操作する
    {
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() //handle()は、ジョブがキューによって、処理された時に呼ばれるメソッド
    {
        logger()->info("It is work! | ".$this->text);
    }
}
