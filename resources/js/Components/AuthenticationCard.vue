<template>
    <div class="min-h-screen flex flex-col  sm:justify-center items-start ml-[130px] pt-6 sm:pt-0 bg-cover before:absolute before:left-0 before:top-0 before:w-[400px] before:h-full before:bg-black" style="background-image: url('/images/login_background.jpg');">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full  sm:max-w-sm z-10 mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg space-y-10">
            <slot />
        </div>
    </div>
</template>
