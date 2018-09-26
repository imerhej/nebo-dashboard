<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
{!! Form::open() !!}
	<div>
        <span class="text-muted h5">Hello, {!! $firstName !!} {!! $lastName !!}</span>
	</div>
	<br />
	<div>
        <span class="text-muted h5">Your account is created, below you'll find the credentials to log in.</span><br>
	</div>
	<br >
	<div>
            <span class="text-muted h6">Username: {!! $email !!}</span><br>
        <span class="text-muted h6">Password: {!! $password !!}</span><br>
        <span class="text-muted h6">Click here to <a href="http://www.excelomega.com/neboexpress">Login</a></span>
    </div>
    <br>
    <div>
        <span class="text-muted h6">
            Thank you for choosing Nebo Express for your project, if you have any questions please call us at: 800 000 1122.
        </span>
    </div>
    <br>
    <div>
        <span class="text-muted h6">
            This is an automated email, please do not reply.
        </span>
    </div>
{!! Form::close() !!}
</div>

</body>
</html>