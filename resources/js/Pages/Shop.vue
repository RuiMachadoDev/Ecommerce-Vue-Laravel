<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white shadow-md py-4 px-8 flex justify-between items-center">
      <h1 class="text-lg font-bold">Loja Virtual</h1>
      <div class="flex items-center space-x-6">
        <a href="/" class="hover:underline">Início</a>
        <a href="/cart" class="hover:underline flex items-center">
          Carrinho
          <span
            v-if="cartCount > 0"
            class="ml-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm"
          >
            {{ cartCount }}
          </span>
        </a>
      </div>
    </nav>

    <!-- Boas-vindas -->
    <div class="bg-blue-100 text-blue-800 py-6 px-4 text-center text-lg font-semibold">
      Bem-vindo à nossa Loja Virtual! Explore os melhores produtos e ofertas.
    </div>

    <!-- Produtos -->
    <div class="container mx-auto p-6">
      <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Explore os nossos Produtos</h2>

      <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div
          v-for="product in products.data"
          :key="product.id"
          class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
        >
          <!-- Imagem do Produto -->
          <div class="bg-gray-200 h-48 flex items-center justify-center">
            <p class="text-gray-500 text-sm">Imagem do Produto</p>
          </div>

          <!-- Detalhes do Produto -->
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 truncate">{{ product.name }}</h3>
            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ product.description }}</p>
            <p class="text-xl font-bold text-gray-800 mt-4">{{ product.price }} €</p>
          </div>

          <!-- Ações -->
          <div class="p-4 bg-gray-100 flex justify-between">
            <button
              @click="viewDetails(product.id)"
              class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700"
            >
              Ver Detalhes
            </button>
            <button
              @click="addToCart(product)"
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500"
            >
              Adicionar ao Carrinho
            </button>
          </div>
        </div>
      </div>

      <!-- Mensagem quando não há produtos -->
      <div v-else class="text-center text-gray-600">
        <p class="text-lg">Nenhum produto disponível.</p>
      </div>

      <!-- Paginação -->
      <div v-if="products.prev_page_url || products.next_page_url" class="mt-10 flex justify-center items-center space-x-4">
        <button
          v-if="products.prev_page_url"
          @click="goToPage(products.prev_page_url)"
          class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"
        >
          Anterior
        </button>
        <button
          v-if="products.next_page_url"
          @click="goToPage(products.next_page_url)"
          class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"
        >
          Próximo
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { usePage, router } from "@inertiajs/vue3";
import axios from "axios";

export default {
  props: {
    products: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const { props } = usePage();
    const auth = props.auth;

    // Mock cart count (substitua por lógica real quando o carrinho estiver funcional)
    const cartCount = 3;

    const goToPage = (url) => {
      router.visit(url);
    };

    const viewDetails = (id) => {
      router.visit(`/products/${id}`);
    };

    const addToCart = (product) => {
      if (!auth.user) {
        const proceed = confirm(
          "Precisa de estar autenticado para adicionar produtos ao carrinho. Deseja fazer login ou registar-se?"
        );
        if (proceed) {
          router.visit("/login");
        }
        return;
      }

      axios
        .post(
          "/cart/add",
          { product_id: product.id, quantity: 1 },
          {
            headers: {
              "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            },
          }
        )
        .then(() => {
          alert("Produto adicionado ao carrinho com sucesso!");
          router.visit("/cart");
        })
        .catch((error) => {
          console.error("Erro ao adicionar ao carrinho:", error);
          alert("Erro ao adicionar ao carrinho. Tente novamente.");
        });
    };

    return {
      goToPage,
      viewDetails,
      addToCart,
      cartCount,
    };
  },
};
</script>
