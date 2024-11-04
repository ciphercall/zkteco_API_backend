<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-6xl p-8 bg-white border rounded-lg shadow-lg">
      <h1 class="text-2xl font-semibold text-center mb-6">Attendance Logs</h1>

      <table class="min-w-full border divide-y divide-gray-200">
        <thead>
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">UID</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User ID</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User Name</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Check-In</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Check-Out</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Type</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="log in processedAttendanceLogs" :key="log.uid" class="hover:bg-gray-50">
            <td class="px-4 py-2 text-sm text-gray-700">{{ log.uid }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ log.userId }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ log.userName }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ log.checkIn }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ log.checkOut }}</td>
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
      processedAttendanceLogs: [], // Processed logs with check-in and check-out times
    };
  },
  async mounted() {
    await this.fetchUsers();
    await this.fetchAttendanceLogs();
    this.replaceUserIdWithName();
    this.processLogs();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axiosInstance.get('/device/get-users');
        const fetchedUsers = response.data["Fetched Users"];
        this.users = Object.values(fetchedUsers).reduce((acc, user) => {
          acc[user.userid] = { name: user.name, userId: user.userid }; // Save both name and userId
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
        userName: this.users[log.id] ? this.users[log.id].name : 'Unknown User',
        userId: log.id, // Retain user ID for the new column
      }));
    },
    processLogs() {
      const logsByDateAndUser = {};

      // Organize logs by user and date
      this.attendanceLogs.forEach((log) => {
        const date = new Date(log.timestamp).toISOString().split('T')[0];
        const userKey = `${log.userId}-${date}`;

        if (!logsByDateAndUser[userKey]) {
          logsByDateAndUser[userKey] = { ...log, checkIn: log.timestamp, checkOut: log.timestamp };
        } else {
          logsByDateAndUser[userKey].checkIn = Math.min(logsByDateAndUser[userKey].checkIn, log.timestamp);
          logsByDateAndUser[userKey].checkOut = Math.max(logsByDateAndUser[userKey].checkOut, log.timestamp);
        }
      });

      // Convert the logs back to an array format and format timestamps for display
      this.processedAttendanceLogs = Object.values(logsByDateAndUser).map((log) => ({
        ...log,
        checkIn: new Date(log.checkIn).toLocaleString(),
        checkOut: new Date(log.checkOut).toLocaleString(),
      }));
    },
  },
};
</script>

<style scoped>
/* Optional: Additional styling if needed */
</style>
