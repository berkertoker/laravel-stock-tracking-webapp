<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {router} from '@inertiajs/vue3'

function destroy(id){
	router.delete('/admindashboard/'+id)
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="user-table">
            <div class="user-table-section">
                <h2>Admin Users <a style=" float: right; margin-right: 10px; color: blue;" :href="route('admindashboard.create')">Add New User</a></h2>
                <table>
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in adminUsers" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <a :href="route('admindashboard.edit',user.id)" class="edit-btn">Edit</a>
                        <button @click.prevent="destroy(user.id)" class="delete-btn">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>

            <div class="user-table-section">
                <h2>Manager Users <a style=" float: right; margin-right: 10px; color: blue;" :href="route('admindashboard.create')">Add New User</a></h2>
                <table>
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in managerUsers" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <a :href="route('admindashboard.edit',user.id)" class="edit-btn">Edit</a>
                        <button @click.prevent="destroy(user.id)" class="delete-btn">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>

            <div class="user-table-section">
                <h2>Regular Users <a style=" float: right; margin-right: 10px; color: blue;" :href="route('admindashboard.create')">Add New User</a></h2>

                <table>
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in regularUsers" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <a :href="route('admindashboard.edit',user.id)" class="edit-btn">Edit</a>
                        <button @click.prevent="destroy(user.id)" class="delete-btn">Delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
export default {
  props: {
    adminUsers: {
      type: Array,
      required: true,
    },
    managerUsers: {
      type: Array,
      required: true,
    },
    regularUsers: {
      type: Array,
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
