<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="w-full max-w-md p-8 space-y-4 bg-white border rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center">Login</h1>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input
              type="email"
              placeholder="Email"
              v-model="email"
              class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input
              type="password"
              placeholder="Password"
              v-model="password"
              class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
            />
          </div>
        </div>

        <button
          @click="handleLogin"
          class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
        >
          Login
        </button>
      </div>
    </div>
  </template>

  <script>
  import axiosInstance from '../utils/axiosInstance';

  export default {
    name: 'LoginPage',
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async handleLogin() {
        try {
          const response = await axiosInstance.post('/login', {
            email: this.email,
            password: this.password,
          });
          localStorage.setItem('token', response.data.token);
          alert('Login successful!');
        } catch (error) {
          console.error('Login failed', error);
          alert('Login failed');
        }
      },
    },
  };
  </script>

  <style scoped>
  /* Add any component-specific styles if necessary */
  </style>
