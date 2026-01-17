@php
    /** @var \App\Core\Entities\Contact $contact */

    $name = e($contact->getName());
    $email = e($contact->getEmail()->getValue());
    $subject = e($contact->getSubject());
    $message = nl2br(e($contact->getMessage()));
    $date = $contact->getCreatedAt()->format('d/m/Y à H:i');
@endphp

    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau message de contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: #4F46E5;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .content {
            padding: 20px;
        }

        .field {
            margin-bottom: 15px;
        }

        .label {
            display: block;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 5px;
        }

        .message-box {
            background: #f9fafb;
            padding: 15px;
            border-left: 4px solid #4F46E5;
            white-space: normal;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            padding: 15px;
            background: #f9fafb;
        }

        a {
            color: #4F46E5;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>📧 Nouveau message de contact</h1>
    </div>

    <div class="content">
        <div class="field">
            <span class="label">Nom</span>
            {{ $name }}
        </div>

        <div class="field">
            <span class="label">Email</span>
            <a href="mailto:{{ $email }}">{{ $email }}</a>
        </div>

        <div class="field">
            <span class="label">Sujet</span>
            {{ $subject }}
        </div>

        <div class="field">
            <span class="label">Date</span>
            {{ $date }}
        </div>

        <div class="field">
            <span class="label">Message</span>
            <div class="message-box">
                {!! $message !!}
            </div>
        </div>
    </div>

    <div class="footer">
        Cet email a été envoyé automatiquement depuis <strong>{{ e($siteName) }}</strong>.
    </div>
</div>

</body>
</html>
