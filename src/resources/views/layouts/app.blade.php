<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alice&family=Lora:ital,wght@1,400..700&family=Playwrite+AU+VIC+Guides&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body>
    <header>
        <a href="/">
            <h1>mogitate</h1>
        </a>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>