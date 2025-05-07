<script>
export default {
  name: 'NavigationBar',
  props: {
    current: {
      type: Number,
      required: true
    },
    all: {
      type: Number,
      required: true
    },
    isValid: {
      type: Boolean,
      default: false
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  },
  emits: ['go-next', 'go-back', 'submit']
}
</script>

<template>
  <div class="navigation-buttons">
    <div class="left-button">
      <button v-if="current > 1" class="nav-button" @click="$emit('go-back')">
        <img src="../../assets/arrow.svg" alt="Back arrow" />
        <span class="btn__label">Powrót</span>
      </button>
    </div>

    <div class="right-button">
      <button v-if="current < all" :class="['nav-button', { 'nav-button--disabled': !isValid }]" :disabled="!isValid"
        @click="$emit('go-next')">
        <span class="btn__label">Dalej</span>
        <img src="../../assets/arrow.svg" alt="Forward arrow" class="rotate-180"
          :class="{ 'img--disabled': !isValid }" />
      </button>

      <button v-if="current === all"
        :class="['nav-button', 'submit-button', { 'nav-button--disabled': !isValid || isLoading }]"
        :disabled="!isValid || isLoading" @click="$emit('submit')">
        <span v-if="!isLoading" class="btn__label">Wyślij</span>
        <span v-else class="btn__label">Wysyłanie...</span>
        <div v-if="isLoading" class="loader"></div>
      </button>
    </div>
  </div>
</template>

<style scoped>
.navigation-buttons {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.left-button {
  margin-right: auto;
}

.right-button {
  margin-left: auto;
}

.nav-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  transition: all 0.3s ease;
}

.nav-button--disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.img--disabled {
  opacity: 0.5;
}

.btn__label {
  font-family: Unbounded;
  font-size: 18px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  transition: opacity 0.3s ease;
}

.rotate-180 {
  transform: rotate(180deg);
}

.submit-button {
  background: #000;
  color: #fff;
  padding: 16px 32px;
  border: none;
  border-radius: 16px;
}

.submit-button:not(.nav-button--disabled):hover {
  opacity: 0.8;
}

.loader {
  width: 16px;
  height: 16px;
  border: 2px solid #fff;
  border-bottom-color: transparent;
  border-radius: 50%;
  display: inline-block;
  margin-left: 8px;
  animation: rotation 1s linear infinite;
}

@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
