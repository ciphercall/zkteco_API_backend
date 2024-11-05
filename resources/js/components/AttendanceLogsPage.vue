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
      users: {},
      attendanceLogs: [],
      processedAttendanceLogs: [],
    };
  },
  async mounted() {
    await this.syncAndFetchAttendanceLogs();
    this.startAutoRefresh();
  },
  methods: {
    async syncAndFetchAttendanceLogs() {
      // Step 1: Fetch and process logs, save to database, and clear device logs
      await this.fetchUsers();
      await this.fetchAndProcessAttendanceLogs();
      await this.clearDeviceLogs();
      
      // Step 2: Fetch attendance logs from the database
      await this.fetchLogsFromDatabase();
    },
    async fetchUsers() {
      try {
        const response = await axiosInstance.get('/device/get-users');
        const fetchedUsers = response.data["Fetched Users"];
        this.users = Object.values(fetchedUsers).reduce((acc, user) => {
          acc[user.userid] = { name: user.name, userId: user.userid };
          return acc;
        }, {});
      } catch (error) {
        console.error('Failed to fetch users', error);
      }
    },
    async fetchAndProcessAttendanceLogs() {
      try {
        const response = await axiosInstance.get('/attendance/logs');
        const rawLogs = response.data;

        const logsByDateAndUser = {};
        rawLogs.forEach((log) => {
          const date = new Date(log.timestamp).toISOString().split('T')[0];
          const userKey = `${log.id}-${date}`;

          if (!logsByDateAndUser[userKey]) {
            logsByDateAndUser[userKey] = { ...log, checkIn: log.timestamp, checkOut: log.timestamp };
          } else {
            logsByDateAndUser[userKey].checkIn = Math.min(logsByDateAndUser[userKey].checkIn, log.timestamp);
            logsByDateAndUser[userKey].checkOut = Math.max(logsByDateAndUser[userKey].checkOut, log.timestamp);
          }
        });

        this.processedAttendanceLogs = Object.values(logsByDateAndUser).map((log) => ({
          ...log,
          userName: this.users[log.id] ? this.users[log.id].name : 'Unknown User',
          userId: log.id,
          checkIn: new Date(log.checkIn).toLocaleString(),
          checkOut: new Date(log.checkOut).toLocaleString(),
        }));

        // Save processed logs to the database
        await axiosInstance.post('/attendance/save-logs', this.processedAttendanceLogs);
      } catch (error) {
        console.error('Failed to process and save attendance logs', error);
      }
    },
    async clearDeviceLogs() {
      try {
        await axiosInstance.delete('/attendance/logs');
      } catch (error) {
        console.error('Failed to clear device logs', error);
      }
    },
    async fetchLogsFromDatabase() {
      try {
        const response = await axiosInstance.get('/attendance/fetch-db-logs');
        this.processedAttendanceLogs = response.data.map(log => ({
          ...log,
          checkIn: new Date(log.checkIn).toLocaleString(),
          checkOut: new Date(log.checkOut).toLocaleString(),
        }));
      } catch (error) {
        console.error('Failed to fetch logs from the database', error);
      }
    },
    startAutoRefresh() {
      setInterval(this.syncAndFetchAttendanceLogs, 300000); // 5 minutes
    },
  },
};
</script>

<style scoped>
/* Optional: Additional styling if needed */
</style>
