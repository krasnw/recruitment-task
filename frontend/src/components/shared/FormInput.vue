<script>
export default {
  name: 'FormInput',
  props: {
    label: {
      type: String,
      required: true
    },
    modelValue: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      required: true,
      validator: (value) => ['text', 'email', 'date', 'tel'].includes(value)
    },
    error: {
      type: String,
      default: ''
    }
  },
  emits: ['update:modelValue', 'blur'],
  computed: {
    inputValue: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    },
    hasError() {
      return !!this.error
    }
  }
}
</script>

<template>
  <div class="form__input-container">
    <input :id="label" :type="type" :class="['form__input', { 'form__input_error': hasError }]" v-model="inputValue"
      @blur="$emit('blur')" placeholder=" ">
    <label :for="label" class="form__label">{{ label }}</label>
    <span v-if="hasError" class="form__error">
      {{ error }}
    </span>
  </div>
</template>

<style scoped>
.form__input-container {
  position: relative;
  width: 100%;
  height: 60px;
}

.form__input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 16px;
  border: 2px solid #000;
  background: #ECECEC;
  padding: 12px 18px;
  transition: all 300ms ease-in;
  font-size: 18px;
  font-weight: 400;
}

.form__input_error {
  border-color: rgb(217, 37, 17);
}

.form__input.form__input_error:focus {
  border-color: rgb(217, 37, 17);
  outline: none;
}

.form__input:focus {
  outline: none;
  border-color: #000;
}

.form__label {
  position: absolute;
  top: 17px;
  left: 16px;
  font-size: 18px;
  font-weight: 400;
  cursor: text;
  background-color: #ececec;
  padding: 0 4px;
  transition: top 140ms ease-in, left 140ms ease-in, font-size 140ms ease-in, color 140ms;
  color: #000;
}

.form__input:focus~.form__label,
.form__input:not(:placeholder-shown).form__input:not(:focus)~.form__label {
  top: -10px;
  left: 24px;
  font-size: 16px;
}

.form__input_error~.form__label {
  color: rgb(217, 37, 17);
}
</style>