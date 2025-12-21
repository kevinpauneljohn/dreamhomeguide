<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Notification</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
    <tr>
        <td align="center">

            <!-- Container -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background:#1f2937; padding:24px; text-align:center;">
                        <h1 style="margin:0; color:#ffffff; font-size:22px; letter-spacing:0.5px;">
                            {{ucwords(strtolower($subject))}}
                        </h1>
                        <p style="margin:6px 0 0; color:#d1d5db; font-size:14px;">
                            <a href="{{route('appointment.show',['appointment' => $appointment->id])}}" style="color: white;">Click here</a>
                        </p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#374151;">

                        <p style="margin-top:0; font-size:15px;">
                            Hello,
                        </p>

                        <p style="font-size:15px; line-height:1.6;">
                            {{$title}} Below are the details:
{{--                            You have a new appointment scheduled. Below are the details:--}}
                        </p>

                        <!-- Details Card -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:6px; padding:20px;">
                            <tr>
                                <td style="padding-bottom:12px;">
                                    <strong>Title:</strong><br>
                                    {{ ucwords(strtolower($appointment->title)) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:12px;">
                                    <strong>Date & Time:</strong><br>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y | h:i A') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:12px;">
                                    <strong>Location:</strong><br>
                                    {{ $appointment->location }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:12px;">
                                    <strong>Type:</strong><br>
                                    {{ ucfirst($appointment->appointment_type) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:12px;">
                                    <strong>Status:</strong><br>
                                    {{ ucfirst($appointment->status) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Notes:</strong><br>
                                    {!! $appointment->notes ?? '—' !!}
                                </td>
                            </tr>
                        </table>

                        <!-- Agent -->
                        @if($appointment->agent)
                            <p style="margin-top:20px; font-size:14px;">
                                <strong>Assigned Agent:</strong><br>
                                {{ ucwords(strtolower($appointment->agent->full_name)) }}
                            </p>
                        @endif

                        <p style="margin-top:30px; font-size:14px; color:#6b7280;">
                            If you have questions or need to reschedule, please contact us directly.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f3f4f6; padding:20px; text-align:center; font-size:12px; color:#6b7280;">
                        © {{ date('Y') }} John Kevin Paunel · All rights reserved<br>
                        Dream Home Guide Realty
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
