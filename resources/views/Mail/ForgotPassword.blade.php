<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="margin:0;padding:0;font-family:'Helvetica Neue',Arial,sans-serif;background-color:#f0f0f8;min-height:100vh;">

    <!-- outer wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f0f0f8;min-height:100vh;padding:40px 16px;">
        <tr>
            <td align="center" valign="top">

                <!-- card -->
                <table cellpadding="0" cellspacing="0" border="0" width="460" style="max-width:460px;width:100%;background-color:#ffffffeb;border:1px solid rgba(255,255,255,0.75);border-radius:36px;box-shadow:0 8px 32px rgba(108,99,255,0.13);overflow:hidden;">
                    <tr>
                        <td style="padding:48px 44px 42px;">

                            <!-- top row: icon + accent dot -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                                <tr>
                                    <td valign="middle">
                                        <!-- icon badge -->
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,#FF4C60 0%,#6C63FF 100%);box-shadow:0 8px 24px rgba(255,76,96,0.30);text-align:center;vertical-align:middle;">
                                                    <!-- SVG lock icon inline -->
                                                    <img src="https://img.icons8.com/ios-filled/50/ffffff/lock-2.png" width="30" height="30" alt="" style="display:block;margin:17px auto;">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" valign="top" style="padding-top:6px;">
                                        <!-- accent dot matching stat-card::after -->
                                        <div style="width:10px;height:10px;border-radius:50%;background-color:#FF4C60;opacity:0.55;"></div>
                                    </td>
                                </tr>
                            </table>

                            <!-- eyebrow label — matches .stat-label -->
                            <p style="margin:0 0 8px 0;font-size:11px;text-transform:uppercase;letter-spacing:2px;font-weight:600;color:#888888;font-family:'Helvetica Neue',Arial,sans-serif;">Account Security</p>

                            <!-- heading — gradient matches .stat-value -->
                            <h1 style="margin:0 0 14px 0;font-size:30px;font-weight:700;line-height:1.15;font-family:'Helvetica Neue',Arial,sans-serif;color:#FF4C60;background:linear-gradient(135deg,#FF4C60,#6C63FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Reset Your&nbsp;Password</h1>

                            <!-- body copy -->
                            <p style="margin:0 0 6px 0;font-size:15px;color:#888888;line-height:1.65;font-family:'Helvetica Neue',Arial,sans-serif;">We received a request to reset the password for your account. Click the button below to set a new password.</p>

                            <!-- expiry pill — accent-yellow tone -->
                            <table cellpadding="0" cellspacing="0" border="0" style="margin:16px 0 28px 0;">
                                <tr>
                                    <td style="background-color:#fdf3d8;border:1px solid #f5d98a;border-radius:999px;padding:7px 14px 7px 12px;">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding-right:7px;vertical-align:middle;line-height:0;">
                                                    <!-- inline SVG clock -->
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#b8870a" xmlns="http://www.w3.org/2000/svg" style="display:block;">
                                                        <path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10 10-4.49 10-10S17.51 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>
                                                    </svg>
                                                </td>
                                                <td style="font-size:12px;font-weight:600;color:#b8870a;letter-spacing:0.5px;white-space:nowrap;font-family:'Helvetica Neue',Arial,sans-serif;">Expires in 60 minutes</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA button — pink→purple gradient -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:10px;">
                                <tr>
                                    <td align="center" style="border-radius:16px;background:linear-gradient(135deg,#FF4C60 0%,#6C63FF 100%);box-shadow:0 8px 24px rgba(255,76,96,0.30);">
                                        <a href="{{ url('/reset_password/' . $token . '?email=' . urlencode($email)) }}"
                                           target="_blank"
                                           style="display:block;padding:16px 24px;color:#ffffff;text-decoration:none;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:600;letter-spacing:0.5px;text-align:center;border-radius:16px;mso-padding-alt:0;">
                                            &#x1F511;&nbsp; Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- divider -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:26px 0 22px 0;">
                                <tr>
                                    <td style="height:1px;background-color:#e0dff5;font-size:0;line-height:0;border:none;">&nbsp;</td>
                                </tr>
                            </table>

                            <!-- footer note -->
                            <p style="margin:0;font-size:12px;color:#aaaaaa;text-align:center;line-height:1.65;font-family:'Helvetica Neue',Arial,sans-serif;">
                                If you did not request a password reset, you can safely ignore this email.<br>
                                Your password will not be changed.
                            </p>

                        </td>
                    </tr>
                </table>
                <!-- /card -->

            </td>
        </tr>
    </table>

</body>
</html>