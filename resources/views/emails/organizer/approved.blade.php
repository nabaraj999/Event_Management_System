<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Organizer Approved</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f9fafb; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:24px; border-radius:8px;">

        <h2 style="margin-top:0; color:#111827;">
            Organizer Account Approved 🎉
        </h2>

        <p style="color:#374151;">
            Dear {{ $organizer->contact_person ?? $organizer->name }},
        </p>

        <p style="color:#374151;">
            Your organizer account for <strong>{{ $organizer->name }}</strong> has been approved.
            You can now log in and start creating events.
        </p>

        <div style="background:#f3f4f6; padding:12px; border-radius:6px; margin:16px 0;">
            <p style="margin:4px 0;"><strong>Email:</strong> {{ $organizer->email }}</p>
            <p style="margin:4px 0;"><strong>Temporary Password:</strong> {{ $plainPassword }}</p>
        </div>

        <a href="{{ url('/org/login') }}"
           style="display:inline-block; background:#2563eb; color:#ffffff; padding:12px 20px;
                  text-decoration:none; border-radius:6px; font-weight:bold;">
            Login to Dashboard
        </a>

        <p style="margin-top:20px; color:#6b7280; font-size:14px;">
            Please log in and complete your organizer profile to get started.
        </p>

        <p style="color:#374151;">
            Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong>
        </p>

    </div>

</body>
</html>
