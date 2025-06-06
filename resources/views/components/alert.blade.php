@if(session('success'))
    <div id="alert" class="fixed bottom-4 right-4 bg-green-100 text-green-800 px-4 py-3 rounded shadow-lg" role="alert">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div id="alert" class="fixed bottom-4 right-4 bg-red-100 text-red-800 px-4 py-3 rounded shadow-lg" role="alert">
        {{ session('error') }}
    </div>
@elseif(session('debug'))
    <div id="alert" class="fixed bottom-4 right-4 bg-blue-100 text-blue-800 px-4 py-3 rounded shadow-lg" role="alert">
        {{ session('debug') }}
    </div>
@endif

 <script>
    setTimeout(() => {
    let alertBox = document.getElementById('alert');
    if (alertBox) {
        alertBox.style.opacity = '0';
            setTimeout(() => alertBox.style.display = 'none', 500);
        }
    }, 3000);
</script>
