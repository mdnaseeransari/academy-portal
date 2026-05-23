<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="0;url={{ route('login') }}?expired=1">
    <title>Session Expired</title>
</head>
<body>
    <script>
        window.location.href = "{{ route('login') }}?expired=1";
    </script>
</body>
</html>
