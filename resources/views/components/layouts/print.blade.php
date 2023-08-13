<!DOCTYPE html>
<html dir="" lang="">
    <x-layouts.print.head>
        <x-slot name="title">
          Invoice
        </x-slot>
    </x-layouts.print.head>

    <body onload="window.print();">
        @stack('body_start')

        <x-layouts.print.content>
            {!! $content !!}
        </x-layouts.print.content>

        @stack('body_end')

        @livewireScripts
    </body>
</html>
