@props([
    'title',
])

<head>
    @stack('head_start')

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8; charset=ISO-8859-1"/>

    <title>{!! $title !!}</title>
   
    <base href="{{ config('app.url') . '/' }}">

    <!-- Favicon -->


    <!-- Css -->


    @livewireStyles
    @stack('css')

    @stack('stylesheet')


    @stack('js')

    @stack('scripts')

    @stack('head_end')
</head>
