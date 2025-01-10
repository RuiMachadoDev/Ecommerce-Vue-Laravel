<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4 px-8 flex justify-between items-center">
      <h1 class="text-lg font-semibold text-gray-800">Loja</h1>
      <a href="/" class="text-gray-600 hover:text-gray-800">Início</a>
    </nav>

    <!-- Produtos -->
    <div class="p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Explore nossos produtos</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div
          v-for="product in products.data"
          :key="product.id"
          class="bg-white shadow rounded p-4"
        >
          <h3 class="text-lg font-semibold text-gray-800">{{ product.name }}</h3>
          <p class="text-gray-600 mt-2">{{ product.description }}</p>
          <p class="text-gray-800 font-bold mt-4">{{ product.price }} €</p>
        </div>
      </div>

      <!-- Paginação -->
      <div class="mt-6 flex justify-center">
        <button
          v-if="products.prev_page_url"
          @click="goToPage(products.prev_page_url)"
          class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 mx-1"
        >
          Anterior
        </button>
        <button
          v-if="products.next_page_url"
          @click="goToPage(products.next_page_url)"
          class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 mx-1"
        >
          Próximo
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

export default {
  setup() {
    const { props } = usePage();

    const goToPage = (url) => {
      axios.get(url).then((response) => {
        window.location.href = response.data.url;
      });
    };

    return {
      products: props.products,
      goToPage,
    };
  },
};
</script>
