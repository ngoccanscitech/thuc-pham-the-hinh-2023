@if ($errors->any())
    <div class="alert alert-danger" alert-dismissible fade show>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($message = session()->get('error'))
<div class="alert alert-danger alert-dismissible fade show">
    <strong>{{$message}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($message = session()->get('success'))
<div class="alert alert-success alert-dismissible fade show">
    <strong>{{$message}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
