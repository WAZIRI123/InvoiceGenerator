<x-layouts.print>
    <x-slot name="title">
       Invoice
    </x-slot>

    <x-slot name="content">
        <x-documents.template.modern
            type="invoice"
            :document="$item"
        />
    </x-slot>
</x-layouts.print>
