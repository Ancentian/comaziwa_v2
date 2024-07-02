<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leave;
use App\Models\Employee;
use App\Mail\TransactionalMail;
use Mail; 
use App\Models\HubtelSMS;


class TransactionalEmails extends Model
{
    use HasFactory;
 
    public static function buildMsg($type, $data)
    {
        $message = (string) view('emails.transactional_emails_body', compact('type', 'data'));
        $sms = (string) view('emails.transactional_sms_body', compact('type', 'data'));
        
        
        $subject = (string) view('emails.transactional_subject_body', compact('type', 'data'));
        if(!empty($data['to_email']) && !empty($message)  && !empty($subject)){
            Mail::to($data['to_email'])->send(new TransactionalMail($subject, $message));
        }
        
        if(!empty($data['to_phone'])){
            TransactionalEmails::sendSMS($data['to_phone'],$subject.PHP_EOL.$sms);
        }
        
        return ['subject' => $subject, 'message' => $message];
    }
    
    
    public static function sendSMS($phone,$msg)
    {
        // $hubtelSMS = new HubtelSMS(config('services.hubtel'));
        // $response = $hubtelSMS->sendSMS($phone,$msg);
        
    }  

}
