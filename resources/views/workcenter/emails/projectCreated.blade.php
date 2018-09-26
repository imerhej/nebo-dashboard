<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
{!! Form::open() !!}
	<div>
        <span class="text-muted h5">Hello, {!! $supervisorFname !!} {!! $supervisorLname !!}</span>
	</div>
	<br />
	<div>
    <span class="text-muted h5">Project Name: {!! $projectName !!}</span><br>
	</div>
	<br>
    <div>
        <span class="text-muted h6">
            Project Details: {!! $projectDetails !!}
        </span><br>
        <span class="text-muted h6">
               Start date:  {!! $start_date !!}
        </span><br>
        <span class="text-muted h6">
               End Date: {!! $end_date !!}
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