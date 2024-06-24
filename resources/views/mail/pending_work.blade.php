<!DOCTYPE html>
<html>
<head>
    <title>Pending Work Notification</title>
</head>
<body>
    <h1>Pending Work Notification</h1>
    <p>Dear {{ $employee->name }},</p>
    <p>Here is the list of your pending works:</p>
    <ul>
        @foreach ($pendingWorks as $work)
            <li>{{ $work->order->order_number }} - {{ $work->process->name }}</li>
        @endforeach
    </ul>
    <p>Please make sure to complete them as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>
