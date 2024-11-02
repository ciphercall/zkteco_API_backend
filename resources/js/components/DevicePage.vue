<template>
    <div class="flex flex-col items-center justify-center min-h-screen space-y-6 bg-gray-100">
      <!-- Device Connect Section -->
      <div class="w-full max-w-md p-8 space-y-4 bg-white border rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center">Device Connect</h1>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">IP Address</label>
            <input
              type="text"
              placeholder="IP Address"
              v-model="ip"
              class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Port</label>
            <input
              type="number"
              placeholder="Port"
              v-model="port"
              class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
        </div>

        <button
          @click="handleConnect"
          class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
        >
          Connect
        </button>
      </div>

      <!-- Device Info Section -->
      <div class="w-full max-w-md p-8 space-y-4 bg-white border rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center">Device Information</h1>

        <button
          @click="fetchDeviceInfo"
          class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
        >
          Get Device Info
        </button>

        <div v-if="deviceInfo" class="space-y-2">
          <p class="text-gray-700">
            <span class="font-semibold">Device Name:</span> {{ deviceInfo.device_name }}
          </p>
          <p class="text-gray-700">
            <span class="font-semibold">Firmware Version:</span> {{ deviceInfo.firmware_version }}
          </p>
          <p class="text-gray-700">
            <span class="font-semibold">Device Serial:</span> {{ deviceInfo.device_serial }}
          </p>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axiosInstance from '../utils/axiosInstance';

  export default {
    name: 'DevicePage',
    data() {
      return {
        ip: '',
        port: 4370,
        deviceInfo: null,
      };
    },
    methods: {
      async handleConnect() {
        try {
          await axiosInstance.post('/device/connect', { ip: this.ip, port: this.port });
          alert('Device connected successfully');
        } catch (error) {
          console.error('Device connection failed', error);
          alert('Device connection failed');
        }
      },
      async fetchDeviceInfo() {
        try {
          const response = await axiosInstance.get('/device/info');
          this.deviceInfo = response.data.device_info;
        } catch (error) {
          console.error('Failed to fetch device info', error);
        }
      },
    },
  };
  </script>

  <style scoped>
  /* Add any specific styles here */
  </style>
