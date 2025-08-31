<template>
    <div class="flex flex-row w-full space-x-2
        rounded-md
        hover:text-gray-500
        hover:outline
        hover:outline-1 
        hover:outline-gray-500"
        >
        <div class="p-2">
          <img
            src="@/assets/images/model-2.webp"
            alt="fabric picture"
            class="size-40 object-cover rounded-lg h-32 w-32"
          >
        </div>
        <div class="flex flex-col justify-center">
          <slot name="title"></slot>
        </div>
    </div>      
</template>