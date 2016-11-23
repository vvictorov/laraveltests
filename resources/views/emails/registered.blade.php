<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Verify Your Email Address</h2>

<div>
    <pre>
    Hello, {{$user->name}}!
    Thanks for creating an account. Please follow the link below to verify your email address
    <a href="{{ URL::to('register/verify/' . $user->confirmation_code) }}"> Click here to verify your email address!</a><br/>
    In case the link above is not working you can verify your account by going to domainhere/register/verify.
    Your verification code is:
    {{ $user->confirmation_code }}
    </pre>
</div>

</body>
</html>