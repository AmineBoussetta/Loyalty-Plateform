@component('mail::message')
# Login Credentials

Hello {{ $client_name }},

Your login credentials:

- Email: {{ $client_email }}
- Password: {{ $password }}

Thank you!

@endcomponent
