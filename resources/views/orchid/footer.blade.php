<div class="text-center user-select-none">
    <p class="small m-0">
        @foreach (language()->allowed() as $code => $name)
            <hr>
            <a href="{{ language()->back($code) }}">{{ $name }}</a>
        @endforeach
    </p>
</div>
