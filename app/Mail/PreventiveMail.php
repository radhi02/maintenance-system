<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreventiveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$filename)
    {
        $this->details = $details;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dd = $this->details;
        $file = $this->filename;
        $equipment_name = $dd[0]['equipment_name'];
        $assigned_user = $dd[0]['assigned_user'];
        $ticket_status = $dd[0]['ticket_status'];
        $plan_date = $dd[0]['plan_date'];
        return $this->subject('Preventive Plan Notification')->view('mail.'.$file)->with(['preventive' => $this->details,'equipment_name'=>$equipment_name,'assigned_user'=>$assigned_user,'ticket_status'=>$ticket_status,'plan_date'=>$plan_date]);  
    }
}
