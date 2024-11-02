<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="w-full max-w-6xl p-8 bg-white border rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center mb-6">Attendance Logs</h1>

        <table class="min-w-full border divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">UID</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User Name</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">State</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Timestamp</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Type</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="log in attendanceLogs" :key="log.uid" class="hover:bg-gray-50">
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.uid }}</td>
              <td class="px-4 py-2 text-sm text-gray-700">{{ log.userName }}</td>
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
        users: {}, // Store users by ID for quick lookup
        attendanceLogs: [],
      };
    },
    async mounted() {
      await this.fetchUsers();
      await this.fetchAttendanceLogs();
      this.replaceUserIdWithName();
    },
    methods: {
      async fetchUsers() {
        try {
          const response = await axiosInstance.get('/device/get-users');
          const fetchedUsers = response.data["Fetched Users"];
          // Convert the fetched users to a map with userid as key
          this.users = Object.values(fetchedUsers).reduce((acc, user) => {
            acc[user.userid] = user.name;
            return acc;
          }, {});
        } catch (error) {
          console.error('Failed to fetch users', error);
        }
      },
      async fetchAttendanceLogs() {
        try {
          const response = await axiosInstance.get('/attendance/logs');
          this.attendanceLogs = response.data;
        } catch (error) {
          console.error('Failed to fetch attendance logs', error);
        }
      },
      replaceUserIdWithName() {
        this.attendanceLogs = this.attendanceLogs.map((log) => ({
          ...log,
          userName: this.users[log.id] || 'Unknown User', // Replace ID with name, default to 'Unknown User' if not found
        }));
      },
    },
  };
  </script>

  <style scoped>
  /* Optional: Additional styling if needed */
  </style>
