<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Rejected</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', Arial, sans-serif; background: linear-gradient(145deg, #f0f3fa, #e9eef5); min-height: 100vh;">

    <table width="100%" cellpadding="0" cellspacing="0" style="min-height: 100vh; background: linear-gradient(145deg, #f0f3fa, #e9eef5);">
        <tr>
            <td align="center" style="padding: 50px 20px;">

                {{-- ── Card ── --}}
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background: rgba(255,255,255,0.75); border: 1px solid rgba(255,255,255,0.5); border-radius: 36px; box-shadow: 0 25px 50px -18px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.7) inset; overflow: hidden;">

                    {{-- ── Header ── --}}
                    <tr>
                        <td style="background: linear-gradient(145deg, #FF4C60, #d43f52); padding: 40px 48px 36px; text-align: center; border-radius: 36px 36px 0 0;">

                            {{-- Logo --}}
                            <div style="font-family: 'Space Grotesk', Arial, sans-serif; font-size: 2rem; font-weight: 600; letter-spacing: -0.02em; color: #ffffff; margin-bottom: 20px;">
                                Company Name
                            </div>

                            {{-- Badge --}}
                            <div style="display: inline-block; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 80px; padding: 6px 20px; margin-bottom: 20px;">
                                <span style="color: rgba(255,255,255,0.9); font-size: 0.8rem; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase;">Leave Management</span>
                            </div>

                            {{-- Cross Icon --}}
                            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.4); border-radius: 50%; margin: 0 auto 16px; line-height: 80px; text-align: center; font-size: 2.2rem;">
                                ✕
                            </div>

                            <h1 style="margin: 0; font-family: 'Space Grotesk', Arial, sans-serif; font-size: 1.8rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em;">
                                {{ $subject }}
                            </h1>
                        </td>
                    </tr>

                    {{-- ── Body ── --}}
                    <tr>
                        <td style="padding: 44px 48px;">

                            {{-- Greeting --}}
                            <p style="margin: 0 0 12px; font-size: 1rem; color: #7b8395; font-weight: 500; text-transform: uppercase; letter-spacing: 0.06em;">
                                Hello,
                            </p>
                            <p style="margin: 0 0 32px; font-size: 1.15rem; color: #1b1f2c; line-height: 1.7;">
                                {{ $msg }}
                            </p>

                            {{-- Info Card --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: rgba(255,76,96,0.06); border: 1px solid rgba(255,76,96,0.15); border-radius: 20px; margin-bottom: 36px;">
                                <tr>
                                    <td style="padding: 24px 28px;">
                                        <div style="margin-bottom: 8px;">
                                            <span style="width: 10px; height: 10px; background: #FF4C60; border-radius: 50%; display: inline-block; margin-right: 10px;"></span>
                                            <span style="font-size: 0.78rem; color: #7b8395; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em;">Status</span>
                                        </div>
                                        <p style="margin: 0; font-family: 'Space Grotesk', Arial, sans-serif; font-size: 1.5rem; font-weight: 700; color: #FF4C60;">
                                            Rejected ✕
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Notice Box --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: rgba(253,203,110,0.1); border: 1px solid rgba(253,203,110,0.3); border-radius: 20px; margin-bottom: 36px;">
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <p style="margin: 0; font-size: 0.92rem; color: #4d5466; line-height: 1.6;">
                                            <span style="font-size: 1rem; margin-right: 8px;">💡</span>
                                            If you believe this decision was made in error, please contact your supervisor or HR department for further clarification.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Divider --}}
                            <hr style="border: none; border-top: 1px solid rgba(0,0,0,0.07); margin: 0 0 32px;">

                            {{-- CTA Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/emp_leave') }}" style="display: inline-block; background: linear-gradient(145deg, #FF4C60, #d43f52); color: #ffffff; text-decoration: none; border-radius: 50px; padding: 1rem 2.8rem; font-size: 1rem; font-weight: 600; letter-spacing: 0.02em; box-shadow: 0 20px 30px -10px rgba(255,76,96,0.5);">
                                            View My Leaves
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- ── Footer ── --}}
                    <tr>
                        <td style="background: rgba(255,255,255,0.4); border-top: 1px solid rgba(255,255,255,0.5); border-radius: 0 0 36px 36px; padding: 28px 48px; text-align: center;">
                            <p style="margin: 0 0 6px; font-size: 0.85rem; color: #4d5466; font-weight: 500;">
                                Company Name — Office Management
                            </p>
                            <p style="margin: 0; font-size: 0.78rem; color: #7b8395;">
                                This is an automated email. Please do not reply directly to this message.
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- ── End Card ── --}}

            </td>
        </tr>
    </table>

</body>
</html>