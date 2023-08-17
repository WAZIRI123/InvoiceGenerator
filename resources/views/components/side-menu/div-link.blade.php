<div>
    <!-- start::Menu link -->
    <a x-data="{ linkHover: false }" @mouseover="linkHover = true" @mouseleave="linkHover = false"
    href="{{ route($route) }}" wire:navigate.hover
    class="{{ !Route::currentRouteNamed($route) ? '' : 'bg-black bg-opacity-30' }}
                flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200">
     
        <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
            {{ $title }}
        </span>
    </a>
    <!-- end::Menu link -->
</div>