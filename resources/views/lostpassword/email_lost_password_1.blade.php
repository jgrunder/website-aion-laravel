<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ Lang::get('all.login.missing_password') }}</title>
    <style>
        body {
            font-family: Sans-Serif;
            background-color: #fcf8f7;
            color: #555555;
        }
    </style>
</head>
<body>
    {{ Lang::get('all.forgot_password.mail_hello') }} <?php echo $account->pseudo; ?>,
    <br> <br>
    {{ Lang::get('all.forgot_password.mail1_part1') }}
    <a href="<?php echo $link; ?>">{{ Lang::get('all.forgot_password.click_here') }}</a>.<br/>
	{{ Lang::get('all.forgot_password.mail1_part2') }}
	<br> <br>
	{{ Lang::get('all.forgot_password.mail_ending') }}
</body>
</html>
