<!DOCTYPE html>
<html>
<head>
    <title>Your Account Credentials</title>
</head>
<body>
    <table style="width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;">
        <tr>
            <td style="text-align: center; padding: 20px 0;">
                <h1 style="font-size: 24px; color: #333; margin-bottom: 10px;">Welcome to <strong> REWARDZ </strong> , {{ $name }}!</h1>
                <p style="font-size: 16px; color: #666; margin: 0;">Your account credentials are as follows:</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 0;">
                <p style="font-size: 16px; color: #666; margin: 0;"><strong>Email:</strong> {{ $email }}</p>
                <p style="font-size: 16px; color: #666; margin: 0;"><strong>Password:</strong> {{ $password }}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 0;">
                <p style="font-size: 16px; color: #666; margin: 0;">Please keep this information secure and do not share it with anyone.</p>
                <p style="font-size: 16px; color: #666; margin: 0;">If there is any problem. contact us!</p>

            </td>
        </tr>
    </table>
</body>
</html>