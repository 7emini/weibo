<!DOCTYPE html>
<html lang="en">
<head>
    <title>请确认您的链接</title>
</head>
<body>
    <h1>感谢您在 Web App 进行注册</h1>
    <p><a href="{{ route('confirm_email', $user->activation_token) }}">{{ route('confirm_email', $user->activation_token) }}</a></p>
    <p>
        如果不是您本人操作，请忽略此邮件。
    </p>
</body>
</html>