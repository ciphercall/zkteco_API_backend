<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="w-full max-w-4xl p-8 bg-white border rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center mb-6">Attendance Logs</h1>

        <table class="min-w-full border divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">UID</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">State</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Timestamp</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Type</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="log in logs" :key="log.uid" class="hover:bg-gray-50">
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.uid }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.id }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.state }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.timestamp }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.type }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script>
  import axiosInstance from '../utils/axiosInstance';

  export default {
    name: 'AttendanceLogsPage',
    data() {
      return {
        logs: [],
      };
    },
    mounted() {
      this.fetchLogs();
    },
    methods: {
      async fetchLogs() {
        try {
          const response = await axiosInstance.get('/attendance/logs');
          this.logs = response.data; // Assuming the endpoint returns JSON array
        } catch (error) {
          console.error('Failed to fetch attendance logs', error);
        }
      },
    },
  };
  </script>

  <style scoped>
  /* Optional: Additional styling if needed */
  </style>
