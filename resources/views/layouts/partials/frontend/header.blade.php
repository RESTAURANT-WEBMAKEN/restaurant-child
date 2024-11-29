@props(['metadata'])

<header class="displayinpc">
    <div class="header_gap">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="margin-top: 41px;">
            <div class="container-fluid m_nopadding">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logos/logo_white.png') }}" alt="{{ config('app.name') }}"
                        class="logocss">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#res_navbar"
                    aria-controls="res_navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="res_navbar">
                    <ul class="navbar-nav ms-auto">
                        @include('layouts.partials.frontend.navbar-items', compact('metadata'))
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
