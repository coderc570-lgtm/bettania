<template>
  <div class="min-h-screen bg-white flex flex-col">
    <BaseHeader class="bg-gradient-to-r from-deep-plum to-l-deep-plum shadow-md">
        <div class="mx-16 mb-8 mt-20">
            <span class="flex items-center gap-6 pb-3 text-[1rem] font-medium text-white">
            <span class="h-[2px] w-10 bg-white"></span>

            <router-link
                to="/"
                class="px-3 py-1 rounded-md
                transition-colors duration-200
                hover:bg-white hover:text-black"
            >
                HOME
            </router-link>
            <router-link
                to="/admin"
                class="px-3 py-1 rounded-md
                transition-colors duration-200
                hover:bg-white hover:text-black"
            >
                ADMIN
            </router-link>
            </span>
            <h1 class="text-4xl font-extrabold text-white lg:text-6xl">
                Users
            </h1>
        </div>
    </BaseHeader>

    <div class="mx-16 my-8">
        <div class="my-6 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap justify-start gap-2">
            <button
                type="button"
                class="
                w-auto
                border-black
                bg-black
                focus:bg-brand-grey hover:bg-black w-40
                rounded-xl
                border
                border-solid
                px-4
                py-2
                text-center
                text-white
                "
            >
                <span
                    class="flex items-center justify-center"
                    aria-hidden="true"
                >
                    <i class="ri-add-line"></i>
                    <span class="pr-1">
                        Add User
                    </span>
                </span>
            </button>
            </div>
        </div>
    </div>
  </div>
</template>