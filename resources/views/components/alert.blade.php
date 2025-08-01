@if(session('success') || session('error') || session('debug'))
    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : 'debug');
        $styles = [
            'success' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
            'error' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
            'debug' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
        ];
    @endphp

    <div id="alert"
        class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 {{ $styles[$type]['bg'] }} {{ $styles[$type]['text'] }} border border-gray-200 px-6 py-4 rounded-xl shadow-xl text-sm transition-opacity duration-500"
        role="alert">
        {{ session($type) }}
    </div>

    <script>
        setTimeout(() => {
            const alertBox = document.getElementById('alert');
            if (alertBox) {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.style.display = 'none', 500);
            }
        }, 3000);
    </script>
@endif
