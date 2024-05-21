<!DOCTYPE html>
<html>
<head>
    <title>Our Latest Offers</title>
</head>
<body>
    <table style="width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;">
        
        <tr>
            <td style="text-align: center; padding: 20px 0;">
                <h1 style="font-size: 24px; color: #333; margin-bottom: 10px;"> Hello {{ $userName }}, Here's some exciting new Offers Just for You 😍 !</h1>
                <p style="font-size: 16px; color: #666; margin: 0;">We have some amazing offers lined here 👇 </p>
                <p style="font-size: 20px; color: #666; margin: 2;">Don't miss out ! </p>

            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 0;">
                <a href="https://yourwebsite.com/offers" style="background-color: #00337C; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 16px;">View All Offers</a>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 0;">
                <img src="{{ asset('img/home_c.png') }}" alt="Company Logo" style="max-width: 200px;">
            </td>
        </tr>
    </table>
</body>
</html>