<?php
namespace Registration\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mkhodroo\SmsTemplate\Controllers\SendSmsController;


class SendVerifyRegisterSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobile;
    protected $name;
    protected $package;

    public function __construct($mobile, $name, $package)
    {
        $this->mobile = $mobile;
        $this->name = $name;
        $this->package = $package;
    }

    public function handle(): void
    {
        $package = number_format($this->package);
        $message = "{$this->name} با موبایل {$this->mobile} در آزمون {$package} ثبت نام کرد.";

        $smsSender = new SendSmsController();
        $smsSender->send('09376922176', $message);
        $smsSender->send('09361531887', $message);
    }
}
