<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EmailSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'email_from',
        'name',
        'host',
        'smtp_user',
        'password',
        'port',
        'smtp_security'
    ];

    public static function getSettings(){
        if(empty(settings()->mailsettings())){
            // update email settings:
            $config = array(
                'driver'     => 'smtp',
                'host'       => env('MAIL_HOST'),
                'port'       => env('MAIL_PORT'),
                'from'       => array('address' => env('MAIL_FROM_ADDRESS'), 'name' => company()->mycompany()->name),
                'encryption' => env('MAIL_ENCRYPTION'),
                'username'   => env('MAIL_USERNAME'),
                'password'   => env('MAIL_PASSWORD'),
            );
        }else{
            $mail = settings()->mailsettings();
            // update email settings:
            $config = array(
                'driver'     => 'smtp',
                'host'       => $mail->host,
                'port'       => $mail->port,
                'from'       => array('address' => $mail->email_from, 'name' => $mail->name),
                'encryption' => $mail->smtp_security,
                'username'   => $mail->smtp_user,
                'password'   => $mail->password,
            );
        }

        

        Config::set('mail', $config);

        $mailer = Mail::mailer('smtp');

        return $mailer;

        
    }
}
