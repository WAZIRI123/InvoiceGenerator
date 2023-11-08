<!-- start::Black overlay -->
<div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false"
    class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
<!-- end::Black overlay -->
<aside :class="menuOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 bg-secondary overflow-y-auto lg:translate-x-0 lg:inset-0 custom-scrollbar">
    <!-- start::Logo -->
    <div class="flex items-center justify-center bg-black bg-opacity-30 h-16">
        <h1 class="text-gray-100 text-center text-lg font-bold uppercase tracking-widest">
        Menu
        </h1>
    </div>
    <!-- end::Logo -->

    <!-- start::Navigation  -->
    <nav class="py-10 custom-scrollbar">
        <!-- start::Menu link -->
        <x-side-menu.div-link
        route="dashboard.index" 
        title="Dashboard" />
        <!-- end::Menu link -->


         <!-- start::Menu link -->
         <x-side-menu.div-link
        route="exam.index" 
        title="Exam" />
        <!-- end::Menu link -->

         <!-- start::Menu link -->
         <x-side-menu.div-link
        route="admin.index" 
        title="Admin" />
        <!-- end::Menu link -->

           
        @hasrole('admin')  
    
        <!-- start::Menu link -->
        <x-side-menu.div-link  
        route="class.index" 
        title="class"/>
        <!-- end::Menu link -->

        <!-- start::Menu link -->
        <x-side-menu.div-link  
        route="subject.index" 
        title="Subject"/>
        <!-- end::Menu link -->

          <!-- start::Menu link -->
          <x-side-menu.div-link  
        route="student.index" 
        title="student"/>
        <!-- end::Menu link -->

         <!-- start::Menu link -->
         <x-side-menu.div-link  
        route="stream.index" 
        title="stream"/>
        <!-- end::Menu link -->

              <!-- start::Menu link -->
              <x-side-menu.div-link  
        route="teacher.index" 
        title="teacher"/>
        <!-- end::Menu link -->

        @endhasrole
    
        <!-- start::Menu  link -->
        <x-side-menu.div-link  
        route="Reports.ExamResult" 
        title="Exam Result" />
        <!-- end::Menu link -->

        <p class="text-xs text-gray-600 mt-10 mb-2 px-6 uppercase">School activities</p>

        {{-- start menu wrapper --}}

     
        <p class="text-xs text-gray-600 mt-10 mb-2 px-6 uppercase">Account</p>

        <!-- start::Menu link -->
        <a x-data="{ linkHover: false }" @mouseover="linkHover = true" @mouseleave="linkHover = false"
            class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
            href="">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                Profile
            </span>
        </a>
        <!-- end::Menu link  -->

        <!-- start::Menu link -->
        <form method="POST" action="{{ route('logout') }}" class="grid gap-2">
            @csrf
            <a x-data="{ linkHover: false }" @mouseover="linkHover = true" @mouseleave="linkHover = false"
                href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                    :class=" linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                    Logout
                </span>
            </a>
        </form>
        <!-- end::Menu link -->

    </nav>
    <!-- end::Navigation -->
</aside>