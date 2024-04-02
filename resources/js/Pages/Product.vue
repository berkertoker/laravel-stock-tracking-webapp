<script setup>
import ManagerLayout from '@/Layouts/ManagerLayout.vue';
import {router} from '@inertiajs/vue3'

function destroy(product){
	router.delete('/products/'+product)
}

</script>

<template>
  <ManagerLayout>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="user-table">
            <div class="user-table-section">
                <h2>Products <a style=" float: right; margin-right: 10px; color: blue;" :href="route('products.create')">Add New Product</a></h2>
                <table>
                <thead>
                    <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id">
                    <td>
                        <tr v-for="image in products.productImages" :key="image.id">
                            <img :src="'http://127.0.0.1:8000/storage/images/'+image.url" alt="Product Image">
                        </tr>
                    </td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }}</td>
                    <td>
                        <span v-if="product.stock">{{ product.stock.amount }}</span>
                    </td>
                    <td>
                        <a :href="route('products.edit',products)" class="edit-btn">Edit</a>
                        <button @click.prevent="destroy(product.id)" class="delete-btn">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <!-- {{ $products.links('pagination::default') }} -->
    </div>
  </ManagerLayout>
</template>

<script>

export default {
  props: {
    products: {
      type: Object,
      required: true,
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
