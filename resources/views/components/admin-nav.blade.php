

<aside class=" text-white w-full duration-500 absolute lg:static bg-gray-900">
    <div class="lg:hidden">
        <button  @click="toggleNav()" :class="!navToggle ? '' : 'opacity-0'" class="btn duration-1000 relative  z-10 "><i class="fa fa-arrow-right"></i></button>
    </div>
     
    <div :class=" !navToggle ? '-left-full' : ' left-0' " class="fixed h-full bg-gray-900 duration-500 w-full top-16 lg:static lg:mx-auto lg:w-10/12">
        <button @click="toggleNav()" class="btn text-white block ml-auto mr-0 "><i class="fa fa-arrow-left lg:hidden"></i></button>
        <h1 class="text-lg font-bold p-2  lg:hidden">Admin</h1>
        <div @click="redirectRoute('/admin/employers')" class="p-2 hover:bg-gray-600 duration-500 cursor-pointer lg:inline-block">
            <h6>Employers</h6>
        </div>
    </div>
    
</aside>