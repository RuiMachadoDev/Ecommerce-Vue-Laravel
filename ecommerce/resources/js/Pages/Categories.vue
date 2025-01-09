<template>
  <div>
    <h1>Gestão de Categorias</h1>
    <button @click="showCreateForm">Adicionar Nova Categoria</button>

    <ul>
      <li v-for="category in categories" :key="category.id">
        {{ category.name }}
        <button @click="editCategory(category)">Editar</button>
        <button @click="deleteCategory(category.id)">Excluir</button>
      </li>
    </ul>

    <!-- Formulário para criar/editar categorias -->
    <div v-if="formVisible">
      <input v-model="formData.name" placeholder="Nome da Categoria" />
      <input v-model="formData.slug" placeholder="Slug" />
      <button @click="saveCategory">Salvar</button>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const categories = ref([]);
    const formVisible = ref(false);
    const formData = reactive({ id: null, name: '', slug: '' });

    const fetchCategories = async () => {
      const response = await axios.get('/api/categories');
      categories.value = response.data;
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
        await axios.get('/sanctum/csrf-cookie');
    };

    const saveCategory = async () => {
        try {
            await initializeCsrf();
            if (formData.id) {
                await axios.put(`/api/categories/${formData.id}`, formData);
            } else {
                await axios.post('/api/categories', formData);
            }
            fetchCategories();
            formVisible.value = false;
        } catch (error) {
            console.error(error.response.data);
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
