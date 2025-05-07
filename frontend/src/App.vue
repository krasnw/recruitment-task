<script>
export default {
  name: 'App',
  computed: {
    currentRoute() {
      return this.$route.name;
    }
  }
}
</script>

<template>
  <div class="app">
    <nav class="navigation">
      <span :class="currentRoute === 'form' ? 'active-tab' : 'inactive-tab'" @click="$router.push({ name: 'form' })">
        Formularz
      </span>
      <span :class="currentRoute === 'list' ? 'active-tab' : 'inactive-tab'" @click="$router.push({ name: 'list' })">
        Lista
      </span>
    </nav>
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
  </div>
</template>

<style>
.app {
  position: relative;
  background-color: #ECECEC;
  padding: 32px 56px;
  border-radius: 40px;
  display: flex;
  flex-direction: column;
  gap: 24px;
  width: 750px;
  transition: all 300ms ease-in;
  box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.25);
}

.navigation {
  position: absolute;
  top: -43px;
  display: flex;
  gap: 16px;
  font-size: 16px;
  font-weight: 600;
  color: #000000;
}

.navigation span {
  cursor: pointer;
  transition: all 300ms ease-in;
  padding: 16px 40px 3px 40px;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
}

.active-tab {
  background-color: #ececec;
}

.inactive-tab {
  background-color: #b0b0b9;
}

.inactive-tab:hover {
  background-color: #c0c0c0;
}
</style>
