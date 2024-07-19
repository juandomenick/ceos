@section('scripts_view')
    @isset($scripts)
        @foreach ($scripts ?? [] as $script)
            <script src='{{ asset("$script") . '?v=' . rand(1, 9) . '.' . rand(100, 999) }}'></script>
        @endforeach
    @endisset
@endsection
