@if(session('success'))
    <div class="alert alert-success alert-dismissible" style="position:absolute;bottom:0;left:0;z-index:1021;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-success alert-dismissible" style="position:absolute;bottom:0;left:0;z-index:1021;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('error') }}
    </div>
@endif
