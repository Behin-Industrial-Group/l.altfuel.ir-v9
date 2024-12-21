<?php

namespace Behin\Hamayesh\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Behin\Hamayesh\Imports\ParticipantsImport;
use Behin\Hamayesh\Models\EventParticipant;

class EventVerificationController extends Controller
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row)
    {
        return new EventParticipant([
            'ticket_id' => $row['شناسه'],
            'user_id' => $row['شناسه کاربری'],
            'first_name' => $row['نام'],
            'last_name' => $row['نام خانوادگی'],
            'username' => $row['نام کاربری'],
            'national_code' => $row['کد ملی'],
            'ticket' => $row['بلیت'],
            'role' => $row['نقش'],
            'type' => $row['نوع'],
            'status' => $row['وضعیت'],
        ]);
    }
}