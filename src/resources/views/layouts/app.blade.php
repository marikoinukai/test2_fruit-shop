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

        // 画像プレビュー（登録・更新 共通）
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('image');
            const previewImg = document.getElementById('previewImage');

            if (!input || !previewImg) return;

            input.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (!file) return;

                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = () => {
                    previewImg.src = reader.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>

</html>