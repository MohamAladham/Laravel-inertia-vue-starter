<?php

namespace App\Notifications;

use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $user;
    private $email_subject;
    private $email_text;
    private $sms_text;
    private $notification_text;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $user )
    {
        $this->user = $user;
        $this->setText();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via( $notifiable )
    {
        return [ 'mail', 'database' ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail( $notifiable )
    {
        $content = ( new MailMessage )
            ->subject( $this->email_subject )
            ->line( $this->email_text )
            ->action( 'التفاصيل', route( 'admin.users.edit', $notifiable->id ) );

        return $content;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray( $notifiable )
    {
        return [
            'text' => $this->notification_text,
            'url'  => route( 'admin.users.edit', $notifiable->id ),
        ];
    }


    /*
     *
     */
    private function setText()
    {
        $template = NotificationTemplate::where( 'key', '=', 'new_user' )->first();
        $keys     = [ '[اسم_المستخدم]' ];
        $values   = [ $this->user->name ];

        $this->email_subject     = str_replace( $keys, $values, $template->email_subject );
        $this->email_text        = str_replace( $keys, $values, $template->email_text );
        $this->sms_text          = str_replace( $keys, $values, $template->sms_text );
        $this->notification_text = str_replace( $keys, $values, $template->notification_text );
    }
}
