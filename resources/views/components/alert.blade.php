@if(session('success'))
    <div id="alert" class="alert alert-success position-absolute bottom-0 end-0 p-3 rounded shadow" role="alert">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div id="alert" class="alert alert-danger position-absolute bottom-0 end-0 p-3 rounded shadow" role="alert">
        {{ session('error') }}
    </div>
@elseif(session('debug'))
    <div id="alert" class="alert alert-info position-absolute bottom-0 end-0 p-3 rounded shadow" role="alert">
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
