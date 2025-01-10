<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="w-full fixed top-0 left-0 bg-white shadow-md py-2 px-8 flex justify-between items-center z-50">
      <div>
        <h1 class="text-lg font-semibold text-gray-800">E-Commerce App</h1>
      </div>
      <div>
        <div v-if="auth.user" class="flex items-center space-x-4">
          <p class="text-gray-600">Olá, {{ auth.user.name }}</p>
          <form method="POST" action="/logout">
            <input type="hidden" name="_token" :value="csrfToken" />
            <button
              type="submit"
              class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700"
            >
              Logout
            </button>
          </form>
        </div>
        <div v-else>
          <a
            v-if="canLogin"
            href="/login"
            class="text-gray-600 hover:text-gray-800 px-3"
          >
            Login
          </a>
          <a
            v-if="canRegister"
            href="/register"
            class="text-gray-600 hover:text-gray-800 px-3"
          >
            Registrar
          </a>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <div class="text-center">
      <h2 class="text-3xl font-bold text-gray-800 pt-20">Bem-vindo ao E-Commerce App</h2>
      <p class="mt-4 text-gray-600">
        Explore as categorias e produtos disponíveis ou gerencie a plataforma!
      </p>
      <div class="mt-6 space-x-4">
        <a
          href="/categories"
          class="bg-gray-800 text-white px-6 py-3 rounded hover:bg-gray-700"
        >
          Gerenciar Categorias
        </a>
        <a
          href="/products"
          class="bg-gray-800 text-white px-6 py-3 rounded hover:bg-gray-700"
        >
          Gerenciar Produtos
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { usePage } from "@inertiajs/vue3";

export default {
  setup() {
    const { props } = usePage();
    return { ...props };
  },
};
</script>
