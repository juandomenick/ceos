<div id="Feedbacks" class="mt-2 mb-2">
    @if ($info = Session::get('informacao'))
        <div class="row">
            <div class="col-lg-12">
                @foreach ($info as $i => $feedback)
                    <div class="alert alert-arrow-left alert-icon-left alert-light-info font-weight-bold fade show mb-1" role="alert">
                        <i class="fa-light fa-info-circle"></i>
                        {!! $feedback !!}
                        <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($atencao = Session::get('atencao'))
        <div class="row">
            <div class="col-lg-12">
                @foreach ($atencao as $i => $feedback)
                    <div class="alert alert-arrow-left alert-icon-left alert-light-warning font-weight-bold fade show mb-1" role="alert">
                        <i class="fa-light fa-exclamation-circle"></i>
                        {!! $feedback !!}
                        <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($sucesso = Session::get('sucesso'))
        <div class="row">
            <div class="col-lg-12">
                @foreach ($sucesso as $i => $feedback)
                    <div class="alert alert-arrow-left alert-icon-left alert-light-primary font-weight-bold fade show mb-1" role="alert">
                        <i class="fa-light fa-check-circle"></i>
                        {!! $feedback !!}
                        <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($erros = Session::get('erro'))
        <div class="row">
            <div class="col-lg-12">
                @foreach ($erros as $i => $error)
                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger font-weight-bold fade show mb-1" role="alert">
                        <i class="fa-light fa-check-circle"></i>
                        {!! $error !!}
                        <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="row">
            <div class="col-lg-12">
                @foreach ($errors->all() as $i => $error)
                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger font-weight-bold fade show mb-1" role="alert">
                        <i class="fa-light fa-times-circle"></i>
                        {!! $error !!}
                        <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (@$feedbacks)
        <div class="row">
            <div class="col-lg-12">
                @foreach ($feedbacks as $type => $feedback)
                    @switch($type)
                        @case('informacao')
                            @foreach ($feedback as $message)
                                <div class="alert alert-arrow-left alert-icon-left alert-light-info font-weight-bold fade show mb-1" role="alert">
                                    <i class="fa-light fa-info-circle"></i>
                                    {!! $message !!}
                                    <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                                </div>
                            @endforeach
                        @break

                        @case('atencao')
                            @foreach ($feedback as $message)
                                <div class="alert alert-arrow-left alert-icon-left alert-light-warning font-weight-bold fade show mb-1" role="alert">
                                    <i class="fa-light fa-exclamation-circle"></i>
                                    {!! $message !!}
                                    <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                                </div>
                            @endforeach
                        @break

                        @case('sucesso')
                            @foreach ($feedback as $message)
                                <div class="alert alert-arrow-left alert-icon-left alert-light-primary font-weight-bold fade show mb-1" role="alert">
                                    <i class="fa-light fa-check-circle"></i>
                                    {!! $message !!}
                                    <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                                </div>
                            @endforeach
                        @break

                        @case('erro')
                            @foreach ($feedback as $message)
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger font-weight-bold fade show mb-1" role="alert">
                                    <i class="fa-light fa-times-circle"></i>
                                    {!! $message !!}
                                    <i class="fa-light fa-times close" data-dismiss="alert" aria-label="Close"></i>
                                </div>
                            @endforeach
                        @break
                    @endswitch
                @endforeach
            </div>
        </div>

    @endif
</div>
