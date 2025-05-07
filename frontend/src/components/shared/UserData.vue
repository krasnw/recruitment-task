<script>
import { getUserById } from '../../services/userService'

export default {
  name: 'UsersData',
  data() {
    return {
      userData: null,
      loading: false,
      error: null
    }
  },
  async created() {
    try {
      this.loading = true
      const userId = this.$route.params.id
      this.userData = await getUserById(userId)
    } catch (err) {
      this.error = err.message
    } finally {
      this.loading = false
    }
  },
  methods: {
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('pl-PL')
    }
  }
}
</script>

<template>
  <section class="user-data">
    <div v-if="loading" class="user-data__loading">
      Ładowanie...
    </div>
    <div v-else-if="error" class="user-data__error">
      {{ error }}
    </div>
    <div v-else-if="userData" class="user-data__container">
      <h1 class="user-data__title">Dane użytkownika</h1>
      <!-- Basic Data -->
      <div class="user-data__section">
        <h2 class="user-data__subtitle">Podstawowe informacje</h2>
        <div class="user-data__content">
          <div class="user-data__field">
            <span class="user-data__label">Imię:</span>
            <span class="user-data__value">{{ userData.basic.firstName }}</span>
          </div>
          <div class="user-data__field">
            <span class="user-data__label">Nazwisko:</span>
            <span class="user-data__value">{{ userData.basic.lastName }}</span>
          </div>
          <div class="user-data__field">
            <span class="user-data__label">Data urodzenia:</span>
            <span class="user-data__value">{{ formatDate(userData.basic.birthDate) }}</span>
          </div>
        </div>
      </div>
      <!-- Contact Data -->
      <div class="user-data__section">
        <h2 class="user-data__subtitle">Dane kontaktowe</h2>
        <div class="user-data__content">
          <div class="user-data__field">
            <span class="user-data__label">Telefon:</span>
            <span class="user-data__value">{{ userData.contact.phoneNumber }}</span>
          </div>
          <div class="user-data__field">
            <span class="user-data__label">Email:</span>
            <span class="user-data__value">{{ userData.contact.email }}</span>
          </div>
        </div>
      </div>
      <!-- Work Experience -->
      <div class="user-data__section">
        <h2 class="user-data__subtitle">Doświadczenie zawodowe</h2>
        <div class="user-data__content">
          <div v-for="(experience, index) in userData.workExperience" :key="index" class="work-experience">
            <div class="user-data__field">
              <span class="user-data__label">Firma:</span>
              <span class="user-data__value">{{ experience.company }}</span>
            </div>
            <div class="user-data__field">
              <span class="user-data__label">Stanowisko:</span>
              <span class="user-data__value">{{ experience.position }}</span>
            </div>
            <div class="user-data__field">
              <span class="user-data__label">Okres:</span>
              <span class="user-data__value">
                {{ formatDate(experience.dateFrom) }} - {{ formatDate(experience.dateTo) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.user-data {
  max-height: 60svh;
  overflow-y: auto;
  padding-right: 24px;
}

.user-data::-webkit-scrollbar {
  width: 8px;
  background-color: #0001;
  border-radius: 8px;
}

.user-data::-webkit-scrollbar-thumb {
  background: #0003;
  border-radius: 1px;
}

.user-data__title {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 16px;
}

.user-data__section {
  margin-bottom: 18px;
}

.user-data__subtitle {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 12px;
  color: #202124;
}

.user-data__content {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.user-data__field {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 16px;
}

.user-data__label {
  font-weight: 500;
  color: #646464;
  min-width: 180px;
}

.user-data__value {
  font-weight: 600;
}

.work-experience {
  padding: 16px 24px;
  border-radius: 16px;
  border: 2px solid black;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.user-data__loading,
.user-data__error {
  text-align: center;
  padding: 20px;
}

.user-data__error {
  color: #dc3545;
}
</style>
