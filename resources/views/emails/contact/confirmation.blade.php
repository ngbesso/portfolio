@php
    /** @var \App\Core\Entities\Contact $contact */
    $name = e($contact->getName());
@endphp
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #10B981;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>✅ Message bien reçu !</h1>
    </div>

    <div class="content">
        <p>Bonjour {{ $name }},</p>

        <p>Merci d'avoir pris le temps de me contacter via mon portfolio.</p>

        <p>J'ai bien reçu votre message et je vous répondrai dans les meilleurs délais.</p>

        <p style="margin-top: 30px;">
            Cordialement,<br>
            <strong>{{ e($siteName) }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>Cet email est une confirmation automatique. Merci de ne pas y répondre.</p>
    </div>
</div>
</body>
</html>
