<template>
  <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-8 text-gray-800">
    <h1 class="text-2xl font-bold mb-6 text-center">Gestão de Categorias</h1>

    <button
      @click="showCreateForm"
      class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition mb-4"
    >
      Adicionar Nova Categoria
    </button>

    <ul v-if="categories.length > 0" class="space-y-4">
      <li
        v-for="category in categories"
        :key="category?.id || Math.random()" <!-- Adicione fallback ao `key` -->
        class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-sm"
      >
        <span class="text-lg font-medium">{{ category?.name || 'Categoria Inválida' }}</span>
        <div class="space-x-2">
          <button
            v-if="category"
            @click="editCategory(category)"
            class="bg-gray-800 text-white px-3 py-1 rounded-md hover:bg-gray-700 transition"
          >
            Editar
          </button>
          <button
            v-if="category"
            @click="deleteCategory(category?.id)"
            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-500 transition"
          >
            Excluir
          </button>
        </div>
      </li>
    </ul>
    <p v-else class="text-center text-gray-600">Nenhuma categoria disponível.</p>

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
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

axios.defaults.withCredentials = true;

export default {
  setup() {
    const categories = ref([]);
    const formVisible = ref(false);
    const formData = reactive({ id: null, name: '', slug: '' });

    const csrfToken = ref(null);

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/api/categories');
        console.log('Categorias carregadas:', response.data);
        categories.value = response.data;
      } catch (error) {
        console.error('Erro ao carregar categorias:', error.response || error.message);
        categories.value = [];
      }
    };

    const initializeCsrf = async () => {
      try {
        const response = await axios.get('/sanctum/csrf-cookie');
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log('CSRF Token inicializado:', csrfToken.value);
      } catch (error) {
        console.error('Erro ao carregar CSRF token:', error.response);
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

    const saveCategory = async () => {
      try {
        console.log('Dados enviados:', formData);
        console.log('CSRF Token:', csrfToken.value);

        const response = await axios.post('/api/categories', formData, {
          withCredentials: true,
          headers: {
            'X-CSRF-TOKEN': csrfToken.value,
          },
        });

        console.log('Resposta da API:', response.data);
        await fetchCategories();
        formVisible.value = false;
      } catch (error) {
        console.error('Erro ao salvar categoria:', error.response?.data || error.message);
      }
    };

    const deleteCategory = async (id) => {
      try {
        await axios.delete(`/api/categories/${id}`, {
          headers: {
            'X-CSRF-TOKEN': csrfToken.value,
          },
        });
        await fetchCategories();
      } catch (error) {
        console.error('Erro ao excluir categoria:', error.response?.data || error.message);
      }
    };

    onMounted(async () => {
      await initializeCsrf();
      await fetchCategories();
    });

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
