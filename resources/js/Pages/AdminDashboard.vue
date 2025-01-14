<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="w-full fixed top-0 left-0 bg-white shadow-md py-2 px-8 flex justify-between items-center z-50">
      <div>
        <h1 class="text-lg font-semibold text-gray-800">E-Commerce Dashboard</h1>
      </div>
      <div>
        <div class="flex items-center space-x-4">
          <p class="text-gray-600">Olá, {{ auth.user.name }}</p>
          <button
            @click="logout"
            class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700"
          >
            Logout
          </button>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <div class="pt-20 px-8">
      <h2 class="text-2xl font-bold text-gray-800">Bem-vindo ao Painel Administrativo</h2>
      <p class="mt-4 text-gray-600">Faça a gestão da sua aplicação de forma rápida e fácil.</p>

      <!-- Quick Links -->
      <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <a
          href="/categories"
          class="bg-gray-800 text-white px-6 py-4 rounded flex items-center justify-between hover:bg-gray-700"
        >
          <span>Gerir Categorias</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>

        <a
          href="/products"
          class="bg-gray-800 text-white px-6 py-4 rounded flex items-center justify-between hover:bg-gray-700"
        >
          <span>Gerir Produtos</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
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
    const csrfToken = props?.csrf_token;

    const logout = async () => {
      try {
        await axios.post('/logout', {}, {
          headers: {
            'X-CSRF-TOKEN': csrfToken,
          },
        });
        window.location.href = '/login';
      } catch (error) {
        console.error("Erro ao fazer logout:", error);
        alert("Ocorreu um erro ao tentar fazer logout.");
      }
    };

    return { ...props, logout };
  },
};
</script>
