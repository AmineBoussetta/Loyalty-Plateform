<?php

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientCredentialsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $client_name;
    public $client_email;
    public $password;

    public function __construct($client_name,$client_email, $password)
    {
        $this->client_name = $client_name;
        $this->client_email = $client_email;
        $this->password = $password;
    }

    public function build()
{
    return $this->markdown('emails.client_credentials_email')
                ->subject('Your Login Credentials');
}

}
