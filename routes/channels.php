<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('meeting.{meetingId}', function ($user, $meetingId) {
    return true;
});
