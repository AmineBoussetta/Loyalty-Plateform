@component('mail::message')
# Login Credentials

Hello {{ $gerant_name }},

Your login credentials:

- Email: {{ $gerant_email }}
- Password: {{ $password }}

Thank you!

@endcomponent
