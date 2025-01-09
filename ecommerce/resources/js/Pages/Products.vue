<template>
  <div>
    <h1>Gestão de Produtos</h1>
    <button @click="showCreateForm">Adicionar Novo Produto</button>

    <ul>
      <li v-for="product in products" :key="product.id">
        {{ product.name }} - {{ product.price }}€
        <button @click="editProduct(product)">Editar</button>
        <button @click="deleteProduct(product.id)">Excluir</button>
      </li>
    </ul>

    <!-- Formulário para criar/editar produtos -->
    <div v-if="formVisible">
      <input v-model="formData.name" placeholder="Nome do Produto" />
      <textarea v-model="formData.description" placeholder="Descrição"></textarea>
      <input type="number" v-model="formData.price" placeholder="Preço" />
      <input type="number" v-model="formData.stock" placeholder="Stock" />
      <select v-model="formData.category_id">
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
      <button @click="saveProduct">Salvar</button>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const products = ref([]);
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

    const fetchProducts = async () => {
      const response = await axios.get('/api/products');
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
      if (formData.id) {
        await axios.put(`/api/products/${formData.id}`, formData);
      } else {
        await axios.post('/api/products', formData);
      }
      formVisible.value = false;
      fetchProducts();
    };

    const deleteProduct = async (id) => {
      await axios.delete(`/api/products/${id}`);
      fetchProducts();
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
      showCreateForm,
      editProduct,
      saveProduct,
      deleteProduct,
    };
  },
};
</script>
