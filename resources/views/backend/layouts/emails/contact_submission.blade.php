<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New contact request</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f4f4;padding:20px 0;">
    <tr>
        <td align="center">
            <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
                   style="background:#ffffff;border-radius:6px;overflow:hidden;border:1px solid #e2e2e2;">
                <tr>
                    <td style="background:#0f172a;color:#ffffff;padding:16px 24px;">
                        <h2 style="margin:0;font-size:20px;">New contact request</h2>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 24px;font-size:14px;color:#0f172a;">
                        <p style="margin:0 0 8px;">You received a new contact submission from your website.</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 24px 20px 24px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                               style="font-size:14px;color:#111827;">
                            <tr>
                                <td style="padding:6px 0;width:120px;font-weight:bold;">Name:</td>
                                <td style="padding:6px 0;">{{ $data['name'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;width:120px;font-weight:bold;">Phone:</td>
                                <td style="padding:6px 0;">{{ $data['phone'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;width:120px;font-weight:bold;">Email:</td>
                                <td style="padding:6px 0;">{{ $data['email'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;width:120px;font-weight:bold;">Area:</td>
                                <td style="padding:6px 0;">{{ $data['area'] }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;width:120px;font-weight:bold;">Spots:</td>
                                <td style="padding:6px 0;">{{ $data['spots'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0 0;width:120px;font-weight:bold;vertical-align:top;">
                                    Description:
                                </td>
                                <td style="padding:10px 0 0;white-space:pre-line;">
                                    {{ $data['description'] }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:14px 24px 18px 24px;font-size:12px;color:#6b7280;background:#f9fafb;">
                        <p style="margin:0;">This email was generated automatically from the contact form on your website.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
