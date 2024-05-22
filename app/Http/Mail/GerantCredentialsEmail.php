<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GerantCredentialsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $gerant_name;
    public $gerant_email;
    public $password;

    public function __construct($gerant_name,$gerant_email, $password)
    {
        $this->gerant_name = $gerant_name;
        $this->gerant_email = $gerant_email;
        $this->password = $password;
    }

    public function build()
{
    return $this->markdown('emails.gerant_credentials_email')
                ->subject('Your Login Credentials');
}

}
