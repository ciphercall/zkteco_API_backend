<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-4 bg-white border rounded-lg shadow-lg">
      <h1 class="text-2xl font-semibold text-center">Add User to Device</h1>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">UID</label>
          <input
            type="number"
            v-model="uid"
            placeholder="UID"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">User ID</label>
          <input
            type="text"
            v-model="userid"
            placeholder="User ID"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input
            type="text"
            v-model="name"
            placeholder="Name"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            v-model="password"
            placeholder="Password"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Role</label>
          <input
            type="number"
            v-model="role"
            placeholder="Role (0 for User, 1 for Admin)"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Card Number</label>
          <input
            type="text"
            v-model="cardno"
            placeholder="Card Number"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
      </div>

      <button
        @click="handleSetUser"
        class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
      >
        Add User
      </button>
    </div>
  </div>
</template>

<script>
import axiosInstance from '../utils/axiosInstance';

export default {
  name: 'SetUserPage',
  data() {
    return {
      uid: '',
      userid: '',
      name: '',
      password: '',
      role: 0, // Default role is 0 (User)
      cardno: '',
    };
  },
  methods: {
    async handleSetUser() {
      try {
        const response = await axiosInstance.post('/attendance/user', {
          uid: this.uid,
          userid: this.userid,
          name: this.name,
          password: this.password,
          role: this.role,
          cardno: this.cardno,
        });
        alert('User added successfully!');
      } catch (error) {
        console.error('Failed to add user', error);
        alert('Failed to add user');
      }
    },
  },
};
</script>

<style scoped>
/* Add any specific styles here if needed */
</style>
