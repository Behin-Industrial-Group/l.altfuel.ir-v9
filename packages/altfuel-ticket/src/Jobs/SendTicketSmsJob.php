<?php
namespace Mkhodroo\AltfuelTicket\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mkhodroo\SmsTemplate\Controllers\SendSmsController;


class SendTicketSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobile;
    protected $ticketId;

    public function __construct($mobile, $ticketId)
    {
        $this->mobile = $mobile;
        $this->ticketId = $ticketId;
    }

    public function handle(): void
    {
        $message = "کاربر گرامی \n یک پاسخ برای تیکت شماره {$this->ticketId} ثبت شد. \n l.altfuel.ir";

        $smsSender = new SendSmsController();
        $smsSender->send($this->mobile, $message);
    }
}
