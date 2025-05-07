<script>
import BasicData from './components/BasicData.vue'
import ContactData from './components/ContactData.vue'
import WorkExpData from './components/WorkExpData.vue'
import NavigationBar from './components/shared/NavigationBar.vue'
import { submitFormData } from './services/formService'

export default {
  name: 'FormPage',
  components: {
    BasicData,
    ContactData,
    WorkExpData,
    NavigationBar
  },
  data() {
    return {
      currentPage: 1,
      totalPages: 3,
      isFormValid: false,
      isSubmitting: false,
      pagesValidation: {
        1: false,
        2: false,
        3: false
      },
      formData: {
        basic: {
          firstName: '',
          lastName: '',
          birthDate: ''
        },
        contact: {
          phoneNumber: '',
          email: ''
        },
        workExperience: []
      }
    }
  },
  computed: {
    isAllValid() {
      return Object.values(this.pagesValidation).every(isValid => isValid);
    }
  },
  methods: {
    goNext() {
      if (this.currentPage < this.totalPages && this.isFormValid) {
        this.currentPage++
        this.isFormValid = false
      }
    },
    goBack() {
      if (this.currentPage > 1) {
        this.currentPage--
      }
    },
    updateFormData(section, data) {
      this.formData[section] = { ...this.formData[section], ...data }
    },
    handleValidationChange(isValid) {
      this.isFormValid = isValid;
      this.pagesValidation[this.currentPage] = isValid;
    },
    async handleSubmit() {
      if (this.isAllValid && !this.isSubmitting) {
        this.isSubmitting = true;
        try {
          const formDataToSubmit = JSON.parse(JSON.stringify(this.formData));

          // Clean phone number - remove all non-digit characters
          formDataToSubmit.contact.phoneNumber = formDataToSubmit.contact.phoneNumber.replace(/\D/g, '');
          const response = await submitFormData(formDataToSubmit);
          console.log('Form submitted successfully');

          // Redirect to user page using the ID from response
          this.$router.push(response.redirect);
        } catch (error) {
          console.error('Error submitting form:', error);
        } finally {
          this.isSubmitting = false;
        }
      }
    }
  },
  watch: {
    currentPage: {
      immediate: true,
      handler() {
        this.$nextTick(() => {
          const currentForm = this.$refs.currentForm
          if (currentForm) {
            this.isFormValid = currentForm.isValid
          }
        })
      }
    }
  }
}
</script>

<template>
  <BasicData v-if="currentPage === 1" ref="currentForm" :formData="formData.basic"
    @update:formData="(data) => updateFormData('basic', data)" @validation-change="handleValidationChange" />
  <ContactData v-if="currentPage === 2" ref="currentForm" :formData="formData.contact"
    @update:formData="(data) => updateFormData('contact', data)" @validation-change="handleValidationChange" />
  <WorkExpData v-if="currentPage === 3" ref="currentForm" v-model:formData="formData.workExperience"
    @validation-change="handleValidationChange" />
  <NavigationBar :current="currentPage" :all="totalPages" :is-valid="isFormValid" :is-loading="isSubmitting"
    @go-next="goNext" @go-back="goBack" @submit="handleSubmit" />
</template>