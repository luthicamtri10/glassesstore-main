<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
</head>
<body>
    <form id="redirectForm" action="{{ $checkoutUrl }}" method="POST">
        @csrf
    </form>
    <script>
        document.getElementById('redirectForm').submit();
    </script>
</body>
</html>