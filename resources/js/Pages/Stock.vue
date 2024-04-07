<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import {router} from '@inertiajs/vue3';
import moment from 'moment';

function destroy(stock_id){
	router.delete('/stocks/'+stock_id)
}

</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="user-table">
            <div class="user-table-section">
                <h2>Stocks <a style=" float: right; margin-right: 10px; color: blue;" :href="route('stocks.create')">Add New Stock</a></h2>
                <table>
                <thead>
                    <tr>
                    <th>Product Name</th>
                    <th>Amount</th>
                    <th>Active Stock</th>
                    <th>Added At</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="stock in stocks" :key="stock.id">
                    <td>{{ stock.product_name }}</td>
                    <td>{{ stock.quantity }}</td>
                    <td>{{ stock.stock.amount }}</td>
                    <td>{{ formatDate(stock.created_at) }}</td>
                    <td>
                        <button @click.prevent="destroy(stock.id)" class="delete-btn">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <Pagination :pagination="paginates" />
        </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>

export default {
  props: {
    stocks: {
      type: Object,
      required: true,
    },
    paginates: {
      type: Object,
      required: true,
    },
  },
  methods: {
    formatDate(date) {
      return moment(date).format('DD-MM-YYYY');
    }
  }
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

.delete-btn {
  background-color: #FF0069;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 4px;
}
</style>
