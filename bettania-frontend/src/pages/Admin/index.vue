<template>
  <div class="bg-white flex flex-col px-16 md:px-24">
    <section class="container mx-auto my-20 p-6">
      <article
        class="bg-deep-plum relative mb-6 overflow-hidden rounded p-4 sm:p-6"
      >
        <div aria-hidden="true">
          <h1 class="mb-1 text-2xl font-bold text-white md:text-3xl">
            Good day, Ken Mar. 👋
          </h1>
          <p class="text-white">
            Here is what's happening with your shop today:
          </p>
        </div>
      </article>

      <div
        class="mb-5 grid gap-6 text-center md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3"
      >
        <article
          v-for="panel in panels"
          :key="panel.title"
          class="rounded border pt-6 border-gray-200 bg-white shadow-sm text-center"
        >
          <router-link
            :to="panel.route"
            class="block pb-5 hover:text-brand-yellow"
          >
            <i :class="panel.icon" class="text-5xl"></i>
            <h2
              class="text-brand-dblue text-lg font-semibold hover:text-brand-yellow"
            >
              {{ panel.title }}
            </h2>
          </router-link>
        </article>
      </div>

    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      panels: [
        {
          title: 'Products',
          icon: 'ri-shopping-cart-2-line',
          route: '/admin/product',
          desc: 'Manage all products',
        },
        {
          title: 'Categories',
          icon: 'ri-folder-2-line',
          route: '/admin/categories',
          desc: 'Manage categories',
        },
        {
          title: 'Fabric',
          icon: 'ri-t-shirt-line',
          route: '/admin/variants/fabric',
          desc: 'Edit fabrics',
        },
        {
          title: 'Style',
          icon: 'ri-contrast-drop-line',
          route: '/admin/variants/style',
          desc: 'Edit styles',
        },
        {
          title: 'Lapel',
          icon: 'ri-collage-line',
          route: '/admin/variants/lapel',
          desc: 'Edit lapels',
        },
        {
          title: 'Buttons',
          icon: 'ri-checkbox-multiple-line',
          route: '/admin/variants/buttons',
          desc: 'Edit buttons',
        },
        {
          title: 'Internal Lining',
          icon: 'ri-layout-masonry-line',
          route: '/admin/variants/internal-lining',
          desc: 'Edit linings',
        },
        {
          title: 'Successfully Ordered',
          icon: 'ri-check-double-line',
          route: '/admin/orders/success',
          desc: 'View completed orders',
        },
        {
          title: 'Users',
          icon: 'ri-user-3-line',
          route: '/admin/users',
          desc: 'Manage users',
        },
      ],
    }
  },
}
</script>
