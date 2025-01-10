<template>
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-8 text-gray-800">
    <h1 class="text-2xl font-bold mb-6 text-center">Gestão de Produtos</h1>

    <!-- Botão Adicionar Novo Produto -->
    <button
      @click="showCreateForm"
      class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition mb-4"
    >
      Adicionar Novo Produto
    </button>

    <!-- Lista de Produtos -->
    <ul v-if="products.data.length" class="space-y-4">
      <li
        v-for="product in products.data"
        :key="product.id"
        class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-sm"
      >
        <div>
          <h3 class="text-lg font-medium">{{ product.name }}</h3>
          <p class="text-gray-600">Preço: {{ product.price }} €</p>
          <p class="text-gray-600">Estoque: {{ product.stock }}</p>
        </div>
        <div class="space-x-2">
          <button
            @click="editProduct(product)"
            class="bg-gray-800 text-white px-3 py-1 rounded-md hover:bg-gray-700 transition"
          >
            Editar
          </button>
          <button
            @click="deleteProduct(product.id)"
            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-500 transition"
          >
            Excluir
          </button>
        </div>
      </li>
    </ul>
    <p v-else class="text-center text-gray-600">Nenhum produto encontrado.</p>

    <!-- Paginação -->
    <div v-if="products.data.length" class="mt-6 flex justify-center items-center space-x-4">
      <button
        v-if="products.prev_page_url"
        @click="fetchProducts(products.prev_page_url)"
        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"
      >
        Anterior
      </button>
      <button
        v-if="products.next_page_url"
        @click="fetchProducts(products.next_page_url)"
        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"
      >
        Próximo
      </button>
    </div>

    <!-- Formulário para Criar/Editar Produto -->
    <div v-if="formVisible" class="mt-6 bg-gray-50 p-4 rounded-lg shadow">
      <h2 class="text-xl font-semibold mb-4">
        {{ formData.id ? 'Editar Produto' : 'Adicionar Produto' }}
      </h2>
      <div class="mb-4">
        <input
          v-model="formData.name"
          type="text"
          placeholder="Nome do Produto"
          class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-gray-500"
        />
      </div>
      <div class="mb-4">
        <input
          v-model="formData.price"
          type="number"
          placeholder="Preço"
          class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-gray-500"
        />
      </div>
      <div class="mb-4">
        <input
          v-model="formData.stock"
          type="number"
          placeholder="Estoque"
          class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-gray-500"
        />
      </div>
      <div class="mb-4">
        <select
          v-model="formData.category_id"
          class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-gray-500"
        >
          <option value="" disabled>Selecione uma Categoria</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
      <button
        @click="saveProduct"
        class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition"
      >
        Salvar
      </button>
    </div>

    <!-- Mensagem de Feedback -->
    <div v-if="message" class="mt-4 p-4 bg-green-100 text-green-800 rounded">
      {{ message }}
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const products = ref({ data: [], prev_page_url: null, next_page_url: null });
    const categories = ref([]);
    const formVisible = ref(false);
    const formData = reactive({
      id: null,
      name: '',
      description: '',
      price: 0,
      stock: 0,
      category_id: null,
    });
    const message = ref('');

    const fetchProducts = async (url = '/api/products') => {
      const response = await axios.get(url);
      products.value = response.data;
    };

    const fetchCategories = async () => {
      const response = await axios.get('/api/categories');
      categories.value = response.data;
    };

    const showCreateForm = () => {
      formVisible.value = true;
      formData.id = null;
      formData.name = '';
      formData.description = '';
      formData.price = 0;
      formData.stock = 0;
      formData.category_id = null;
    };

    const editProduct = (product) => {
      formVisible.value = true;
      formData.id = product.id;
      formData.name = product.name;
      formData.description = product.description;
      formData.price = product.price;
      formData.stock = product.stock;
      formData.category_id = product.category_id;
    };

    const saveProduct = async () => {
      try {
        if (formData.id) {
          await axios.put(`/api/products/${formData.id}`, formData);
        } else {
          await axios.post('/api/products', formData);
        }
        formVisible.value = false;
        fetchProducts();
        message.value = 'Produto salvo com sucesso!';
      } catch (error) {
        console.error(error);
        message.value = 'Erro ao salvar o produto. Tente novamente.';
      }
    };

    const deleteProduct = async (id) => {
      try {
        await axios.delete(`/api/products/${id}`);
        fetchProducts();
        message.value = 'Produto excluído com sucesso!';
      } catch (error) {
        console.error(error);
        message.value = 'Erro ao excluir o produto. Tente novamente.';
      }
    };

    onMounted(() => {
      fetchProducts();
      fetchCategories();
    });

    return {
      products,
      categories,
      formVisible,
      formData,
      message,
      fetchProducts,
      showCreateForm,
      editProduct,
      saveProduct,
      deleteProduct,
    };
  },
};
</script>
