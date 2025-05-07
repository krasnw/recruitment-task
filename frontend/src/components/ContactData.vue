<script>
import FormTitle from './shared/FormTitle.vue'
import FormInput from './shared/FormInput.vue'
import { validateForm } from '../utils/validation'

export default {
  name: 'ContactData',
  components: {
    FormTitle,
    FormInput
  },
  props: {
    formData: {
      type: Object,
      required: true
    }
  },
  emits: ['update:formData', 'validation-change'],
  data() {
    return {
      validationErrors: {},
      touchedFields: {
        phoneNumber: false,
        email: false
      },
      fields: [
        { name: 'phoneNumber', type: 'phone', label: 'Telefon' },
        { name: 'email', type: 'email', label: 'Email' }
      ]
    }
  },
  computed: {
    isValid() {
      const { isValid } = validateForm(this.formData, this.fields)
      return isValid
    }
  },
  methods: {
    handleBlur(fieldName) {
      this.touchedFields[fieldName] = true
      this.validateTouchedFields()
    },
    validateTouchedFields() {
      const touchedFieldsConfig = this.fields.filter(field =>
        this.touchedFields[field.name]
      )
      const { errors } = validateForm(this.formData, touchedFieldsConfig)
      this.validationErrors = errors
      this.$emit('validation-change', this.isValid)
    },
    validateAll() {
      this.fields.forEach(field => {
        this.touchedFields[field.name] = true
      })

      const { errors } = validateForm(this.formData, this.fields)
      this.validationErrors = errors
      this.$emit('validation-change', this.isValid)
    }
  },
  watch: {
    formData: {
      deep: true,
      handler() {
        this.validateTouchedFields()
      }
    }
  },
  mounted() {
    if (Object.values(this.formData).some(value => value)) {
      this.validateAll()
    }
  },
  activated() {
    this.validateAll()
  }
}
</script>

<template>
  <div class="form-page">
    <FormTitle title="Dane kontaktowe" :subtitle="{ current: 2, all: 3 }" />

    <form class="form" @submit.prevent>
      <FormInput v-for="field in fields" :key="field.name" v-model="formData[field.name]" :label="field.label"
        :type="field.type === 'phone' ? 'tel' : field.type" :error="validationErrors[field.name]"
        @blur="handleBlur(field.name)" />
    </form>
  </div>
</template>