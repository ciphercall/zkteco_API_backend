<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-4 bg-white border rounded-lg shadow-lg">
      <h1 class="text-2xl font-semibold text-center">Register</h1>
      <div class="space-y-4">
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
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="email"
            v-model="email"
            placeholder="Email"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            v-model="password"
            placeholder="Password"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
            type="password"
            v-model="confirmPassword"
            placeholder="Confirm Password"
            class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
          />
        </div>
      </div>
      <button
        @click="handleRegister"
        class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
      >
        Register
      </button>
    </div>
  </div>
</template>

<script>
import axiosInstance from '../utils/axiosInstance';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
    };
  },
  methods: {
    async handleRegister() {
      try {
        await axiosInstance.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.confirmPassword,
        });
        alert('Registration successful!');
      } catch (error) {
        console.error('Registration failed', error);
        alert('Registration failed');
      }
    },
  },
};
</script>

<style scoped>
/* Any component-specific styles */
</style>
