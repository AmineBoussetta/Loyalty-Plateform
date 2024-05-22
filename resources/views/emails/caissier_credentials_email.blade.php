@component('mail::message')
# Login Credentials

Hello {{ $caissier_name }},

Your login credentials:

- Email: {{ $caissier_email }}
- Password: {{ $password }}

Thank you!

@endcomponent
