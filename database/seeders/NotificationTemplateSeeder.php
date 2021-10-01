<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            [
                'key'               => 'new_user',
                'name'              => 'تسجيل مستخدم جديد',
                'sms_text'          => '',
                'notification_text' => '',
                'email_subject'     => 'تسجيل مستخدم جديد',
                'email_text'        => "تم تسجيل المستخدم '[اسم_المستخدم]'",
                'description'       => "يتم إرسالها للإدارة عند قيام مستخدم بالتسجيل في الموقع.
                المتغيرات:
                [اسم_المستخدم]
                ",
            ],
        ];

        foreach ( $arr as $a )
        {
            NotificationTemplate::firstOrCreate(
                [ 'key' => $a['key'] ],
                $a
            );
        }
    }
}
