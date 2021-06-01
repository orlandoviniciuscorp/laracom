<?php

namespace App\Mail;

use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Orders\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFeedBackToAdminMailable extends Mailable
{
    use Queueable, SerializesModels, AddressTransformable;

    public $user;
    public $comment;
    public $employee;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct($user, $comment, $employee)
    {
        $this->user = $user;
        $this->comment = $comment;
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'user' => $this->user,
            'comment' => $this->comment,
            'employee' => $this->employee,
        ];

        return $this->subject('Feedback para a Cesta')->view('emails.admin.FeedbackNotificationEmail', $data);
    }


}
