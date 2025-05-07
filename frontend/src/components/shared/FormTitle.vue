<script>
const numbers = {
  1: "pierwszy",
  2: "drugi",
  3: "trzeci",
  4: "czwarty",
  5: "piąty"
}

export default {
  name: 'FormTitle',
  props: {
    title: {
      type: String,
      required: true
    },
    subtitle: {
      type: Object,
      default: () => ({ current: 1, all: 1 }),
      validator: (value) => {
        return typeof value.current === 'number' && typeof value.all === 'number';
      }
    }
  },
  computed: {
    subtitleText() {
      const { current, all } = this.subtitle;
      if (all === 1) {
        return 'Wypełni wszystkie niezbędne pola';
      }
      if (current === all) {
        return 'Ostatni etap';
      }
      const etapName = numbers[current] ? `Etap ${numbers[current]}` : `Etap ${current}`;
      return `${etapName} (z ${all})`;
    }
  }
}
</script>

<template>
  <div class="form-title">
    <h2>{{ title }}</h2>
    <p v-if="subtitle">{{ subtitleText }}</p>
  </div>
</template>

<style scoped>
h2 {
  font-size: 24px;
  font-weight: 600;
  margin: 0;
}

p {
  font-size: 18px;
  font-weight: 400;
  color: #646464;
}
</style>
