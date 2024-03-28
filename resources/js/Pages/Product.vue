<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {router} from '@inertiajs/vue3'

function destroy(id){
	router.delete('/products/'+id)
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="user-table">
            <div class="user-table-section">
                <h2>Admin Users <a style=" float: right; margin-right: 10px; color: blue;" :href="route('products.create')">Add New Product</a></h2>
                <table>
                <thead>
                    <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id">
                    <td><img :src="product.image" alt="Product Image"></td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>
                        <a :href="route('products.edit',products.id)" class="edit-btn">Edit</a>
                        <button @click.prevent="destroy(products.id)" class="delete-btn">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
                <pagination :data="products" @pagination="fetchProducts" />
            </div>
        </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import Pagination from '@/Components/Pagination.vue';

export default {
  components: {
    Pagination,
  },
  props: {
    products: {
      type: Object,
      required: true,
    },
  },
  methods: {
    fetchProducts(page) {
      this.$inertia.get(route('route.a'), { page: page });
    },
  },
};
</script>

<style scoped>
.user-table {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.user-table-section {
  border: 1px solid #ccc;
  padding: 20px;
  background-color: white;
}

.user-table-section table {
  width: 100%;
  border-collapse: collapse;
}

.user-table-section table th,
.user-table-section table td {
  border: 1px solid #ccc;
  padding: 8px;
}

.user-table-section table th {
  background-color: #f2f2f2;
}

.user-table-section h2 {
  margin-bottom: 10px;
}

.edit-btn {
  background-color: #3DDAB4;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
  margin-right: 4px;
}

.delete-btn {
  background-color: #FF0069;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}
</style>
