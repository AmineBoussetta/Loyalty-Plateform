<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CaissierCredentialsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $caissier_name;
    public $caissier_email;
    public $password;

    public function __construct($caissier_name, $caissier_email, $password)
    {
        $this->caissier_name = $caissier_name;
        $this->caissier_email = $caissier_email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->markdown('emails.caissier_credentials_email')
                    ->subject('Your Login Credentials');
    }
}
