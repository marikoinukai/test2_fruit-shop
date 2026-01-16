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
        function handleImageChange(input) {
            // ファイル名表示
            const fileNameEl = document.getElementById('file-name');
            if (fileNameEl && input.files && input.files[0]) {
                fileNameEl.textContent = input.files[0].name;
            }

            // プレビュー表示
            const previewImg = document.getElementById('previewImage');
            if (!previewImg) return;

            const file = input.files && input.files[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = () => {
                previewImg.src = reader.result;
                previewImg.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>

</html>