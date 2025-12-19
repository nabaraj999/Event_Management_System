<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Organizer Application Update</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f9fafb; padding:20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:24px; border-radius:8px;">

        <h2 style="margin-top:0; color:#111827;">
            Organizer Application Update
        </h2>

        <p style="color:#374151;">
            Dear {{ $application->contact_person }},
        </p>

        <p style="color:#374151;">
            Thank you for applying to become an organizer on our platform with
            <strong>{{ $application->organization_name }}</strong>.
        </p>

        <p style="color:#374151;">
            After reviewing your application, we’re unable to approve it at this time.
        </p>

        <p style="color:#374151;">
            If you believe this decision was made in error or you have additional
            information to share, you’re welcome to reapply or contact our support team.
        </p>

        <p style="margin-top:20px; color:#374151;">
            Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong>
        </p>

    </div>

</body>
</html>
