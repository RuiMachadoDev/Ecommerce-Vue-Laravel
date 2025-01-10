<template>
  <div class="min-h-screen bg-gray-100 p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Carrinho de Compras</h2>
    <div v-if="cart.length" class="space-y-4">
      <div
        v-for="item in cart"
        :key="item.id"
        class="bg-white shadow-lg rounded-lg p-4 flex justify-between items-center"
      >
        <div>
          <h3 class="text-lg font-semibold text-gray-800">{{ item.name }}</h3>
          <p class="text-gray-600">Preço: {{ item.price }} €</p>
          <p class="text-gray-600">Quantidade: {{ item.quantity }}</p>
        </div>
        <button
          @click="removeFromCart(item.id)"
          class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
        >
          Remover
        </button>
      </div>
    </div>
    <div v-else>
      <p class="text-gray-600">O carrinho está vazio.</p>
    </div>
  </div>
</template>

<script>
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

export default {
  setup() {
    const { props } = usePage();
    const cart = props.cart;

    const removeFromCart = (id) => {
      axios.post('/cart/remove', { id })
        .then(response => {
          alert(response.data.message);
          location.reload();
        })
        .catch(error => {
          console.error('Erro ao remover item do carrinho:', error);
        });
    };

    return { cart, removeFromCart };
  },
};
</script>
