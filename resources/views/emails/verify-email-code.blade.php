<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Подтверждение email</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f0;font-family:Montserrat,Segoe UI,Helvetica,Arial,sans-serif;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f4f6f0;padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:520px;background:#fffffa;border-radius:20px;overflow:hidden;border:1px solid #dce2d6;">
                <tr>
                    <td style="padding:28px 28px 8px 28px;text-align:center;">
                        <p style="margin:0;font-size:11px;font-weight:600;letter-spacing:0.35em;text-transform:uppercase;color:#869274;">Prosto.Yoga</p>
                        <h1 style="margin:16px 0 0 0;font-size:22px;font-weight:600;color:#2d312d;line-height:1.25;">Подтверди почту</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 28px 24px 28px;">
                        <p style="margin:0;font-size:15px;line-height:1.6;color:#5c655c;">Привет{{ $userName ? ', '.$userName : '' }}!</p>
                        <p style="margin:14px 0 0 0;font-size:15px;line-height:1.6;color:#5c655c;">Введи этот код в форме подтверждения в личном кабинете. Код действует <strong>30 минут</strong>.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 28px 28px 28px;text-align:center;">
                        <div style="display:inline-block;padding:18px 36px;border-radius:16px;background:linear-gradient(135deg,#f6f8f1 0%,#eef2e6 100%);border:1px solid #cfd4c9;">
                            <span style="font-size:32px;font-weight:700;letter-spacing:0.35em;color:#2d312d;font-family:ui-monospace,Menlo,monospace;">{{ $code }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 28px 28px 28px;">
                        <p style="margin:0;font-size:13px;line-height:1.5;color:#7a837a;">Если это не ты регистрировалась на prostoyoga.ru — просто проигнорируй письмо.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 28px;background:#f9faf6;border-top:1px solid #ecece8;text-align:center;">
                        <p style="margin:0;font-size:11px;color:#9aa396;">© {{ date('Y') }} Prosto Yoga · дыхание, осанка, движение без давления</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
