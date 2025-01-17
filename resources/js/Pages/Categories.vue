<template>
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-8 text-gray-800">
    <h1 class="text-2xl font-bold mb-6 text-center">Gestão de Categorias</h1>

    <button
      @click="showCreateForm"
      class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition mb-4"
    >
      Adicionar Nova Categoria
    </button>

    <ul class="space-y-4">
      <li
        v-for="category in categories"
        :key="category.id"
        class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-sm"
      >
        <span class="text-lg font-medium">{{ category.name }}</span>
        <div class="space-x-2">
          <button
            @click="editCategory(category)"
            class="bg-gray-800 text-white px-3 py-1 rounded-md hover:bg-gray-700 transition"
          >
            Editar
          </button>
          <button
            @click="deleteCategory(category.id)"
            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-500 transition"
          >
            Excluir
          </button>
        </div>
      </li>
    </ul>

    <!-- Formulário para criar/editar categorias -->
    <div v-if="formVisible" class="mt-6 bg-gray-50 p-4 rounded-lg shadow">
      <h2 class="text-xl font-semibold mb-4">
        {{ formData.id ? 'Editar Categoria' : 'Adicionar Categoria' }}
      </h2>
      <div class="mb-4">
        <input
          v-model="formData.name"
          type="text"
          placeholder="Nome da Categoria"
          class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-gray-500"
        />
      </div>
      <div class="mb-4">
        <input
          v-model="formData.slug"
          type="text"
          placeholder="Slug"
          class="w-full p-2 bg-gray-100 border border-gray-300 rounded-md focus:ring focus:ring-gray-500"
        />
      </div>
      <button
        @click="saveCategory"
        class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition"
      >
        Salvar
      </button>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue';
import axios from 'axios';

axios.defaults.withCredentials = true;

export default {
  setup() {
    const categories = ref([]);
    const formVisible = ref(false);
    const formData = reactive({ id: null, name: '', slug: '' });

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/api/categories');
        console.log('Headers enviados:', axios.defaults.headers.common);
        categories.value = response.data;
      } catch (error) {
        console.error('Erro ao carregar categorias:', error.response);
      }
    };

    const showCreateForm = () => {
      formVisible.value = true;
      formData.id = null;
      formData.name = '';
      formData.slug = '';
    };

    const editCategory = (category) => {
      formVisible.value = true;
      formData.id = category.id;
      formData.name = category.name;
      formData.slug = category.slug;
    };

    const initializeCsrf = async () => {
      try {
        await axios.get('/sanctum/csrf-cookie');
        console.log('CSRF token carregado.');
      } catch (error) {
        console.error('Erro ao carregar CSRF token:', error.response);
      }
    };

    const saveCategory = async () => {
      try {
        await initializeCsrf();
        if (formData.id) {
          await axios.put(`/api/categories/${formData.id}`, formData, { withCredentials: true });
        } else {
          await axios.post('/api/categories', formData, { withCredentials: true });
        }
        fetchCategories();
        formVisible.value = false;
      } catch (error) {
        console.error('Erro na requisição:', error.response?.data || error.message);
      }
    };

    const deleteCategory = async (id) => {
      await axios.delete(`/api/categories/${id}`);
      fetchCategories();
    };

    fetchCategories();

    return {
      categories,
      formVisible,
      formData,
      showCreateForm,
      editCategory,
      saveCategory,
      deleteCategory,
    };
  },
};
</script>
