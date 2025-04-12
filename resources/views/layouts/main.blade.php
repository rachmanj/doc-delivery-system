@php
    $title =
        $title ??
        (isset($__env) && $__env->hasSection('title')
            ? trim($__env->yieldContent('title'))
            : 'Document Delivery System');
@endphp

@include('layouts.partials.header', ['title' => $title])

<div class="wrapper">
    @include('layouts.partials.navbar')

    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('layouts.partials.footer')
</div>

@include('layouts.partials.scripts')
