<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'mogitate')</title>

    {{-- 共通CSS --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    {{-- ページ固有CSS --}}
    @yield('css')
</head>

<body>

    <header class="header">
        <div class="header__inner">
            <a class="logo" href="{{ url('/products') }}">mogitate</a>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
    <script>
        function showFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('file-name').textContent = input.files[0].name;
            }
        }
    </script>
</body>

</html>