<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SendProjectsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Weekly Projects Newsletter';

    public User $user;
    public Collection $projects;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Collection $projects
     * 
     * @return void
     */
    public function __construct($user, $projects)
    {
        $this->user = $user;
        $this->projects = $projects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.projects.projects-notification', [
            '_projects' => $this->projects->take(10)
        ]);
    }
}
