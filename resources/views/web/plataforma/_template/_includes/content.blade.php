<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>{{ $view['titulo'] ?? 'Titulo' }}</h3>
            </div>
        </div>

        {{-- FEEDBACKS --}}
        @include('web.plataforma._template._components.feedback')

        <div class="layout-top-spacing">
            @yield('view')
        </div>
    </div>
</div>
