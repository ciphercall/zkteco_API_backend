<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="w-full max-w-4xl p-8 bg-white border rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center mb-6">Registered Users</h1>

        <table class="min-w-full border divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">UID</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User ID</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Role</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Card Number</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="user in users" :key="user.uid" class="hover:bg-gray-50">
              <td class="px-4 py-2 text-sm text-gray-700">{{ user.uid }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ user.userid }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ user.name }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ user.role }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ user.cardno }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script>
  import axiosInstance from '../utils/axiosInstance';

  export default {
    name: 'RegisteredUsersPage',
    data() {
      return {
        users: [],
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      async fetchUsers() {
        try {
          const response = await axiosInstance.get('/device/get-users');
          const fetchedUsers = response.data["Fetched Users"];
          // Convert the object of users into an array
          this.users = Object.values(fetchedUsers);
        } catch (error) {
          console.error('Failed to fetch registered users', error);
        }
      },
    },
  };
  </script>

  <style scoped>
  /* Optional: Additional styling if needed */
  </style>
