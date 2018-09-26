<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
{!! Form::open() !!}
	<div>
        <span class="text-muted h5">Hello, {!! $clientFname !!} {!! $clientLname !!}</span>
	</div>
	<br />
	<div>
    <span class="text-muted h5">{!! $taskDescription !!}</span><br>
	</div>
	<br>
    <div>
        <span class="text-muted h6">
            Thank you for choosing Nebo Express for your project, if you have any questions please call us at: 800 000 1122.
        </span>
    </div>
    <br >
    <div>
        <span class="text-muted h6">{!! $firstName !!} {!! $lastName !!} </span>
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