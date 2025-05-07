<script>
export default {
  name: 'UserPreview',
  props: {
    userPrev: {
      type: Object,
      required: true,
    }
  },
  methods: {
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('pl-PL')
    },
    moreUserInfo() {
      return this.$router.push({ name: 'user', params: { id: this.userPrev.id } })
    }
  }
}
</script>

<template>
  <div class="user-preview" @click="moreUserInfo">
    <div class="user-preview__info">
      <div class="user-preview__name">{{ userPrev.firstName }} {{ userPrev.lastName }}</div>
      <div class="user-preview__birth-date">{{ formatDate(userPrev.birthDate) }}</div>
    </div>
  </div>
</template>

<style scoped>
.user-preview {
  padding: 16px 24px;
  border-radius: 20px;
  border: 2px solid #000;
  cursor: pointer;
  width: 100%;
  transition: all 200ms ease-in-out;
}

.user-preview__info {
  display: flex;
  flex-direction: column;
}

.user-preview__name {
  font-size: 18px;
  font-weight: 600;
}

.user-preview__birth-date {
  color: #5f6368;
  font-size: 14px;
}
</style>