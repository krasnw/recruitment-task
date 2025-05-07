<script>
import UserData from './components/shared/UserData.vue'
import UserPreview from './components/shared/UserPreview.vue'
import { getAllUsers } from './services/userService'

export default {
  name: 'UsersList',
  components: {
    UserData,
    UserPreview
  },
  data() {
    return {
      users: [],
      loading: false,
      error: null
    }
  },
  async created() {
    try {
      this.loading = true
      this.users = await getAllUsers()
    } catch (err) {
      this.error = err.message
    } finally {
      this.loading = false
    }
  }
}
</script>

<template>
  <div class="users-list">
    <div v-if="loading" class="users-list__loading">
      Ładowanie ...
    </div>
    <div v-else-if="error" class="users-list__error">
      {{ error }}
    </div>
    <template v-else-if="users.length === 0">
      Nie dodano jeszcze żadnych użytkowników
    </template>
    <template v-else>
      <UserPreview v-for="user in users" :key="user.id" :userPrev="user" class="users-list__item" />
    </template>
  </div>
</template>

<style scoped>
.users-list {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.users-list__item {
  width: 100%;
}

.users-list__loading,
.users-list__error {
  text-align: center;
  padding: 20px;
}

.users-list__error {
  color: #dc3545;
}
</style>