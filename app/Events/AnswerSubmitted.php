<?php

namespace App\Events;

use App\Models\Answer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $answer;
    /**
     * Create a new event instance.
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer->load('question', 'option', 'participation.user');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
/*         return [
            new PrivateChannel('channel-name'),
        ]; */

        return [
            new Channel('meeting.' . $this->answer->participation->meeting_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'question_id' => $this->answer->question_id,
            'option_id' => $this->answer->option_id,
            'user_name' => $this->answer->participation->user->name,
        ];
    }
}
