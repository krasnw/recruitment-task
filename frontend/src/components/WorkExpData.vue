<script>
import FormTitle from './shared/FormTitle.vue'
import FormInput from './shared/FormInput.vue'
import { validateField, validateExperienceDates } from '../utils/validation'

export default {
  name: 'WorkExpData',
  components: {
    FormTitle,
    FormInput
  },
  props: {
    formData: {
      type: Array,
      required: true
    }
  },
  emits: ['update:formData', 'validation-change'],
  data() {
    return {
      isAddingExperience: false,
      newExperience: {
        company: '',
        position: '',
        dateFrom: '',
        dateTo: ''
      },
      errors: {}
    }
  },
  computed: {
    isValid() {
      return this.formData.length > 0;
    },
    isExpFormValid() {
      // Check if all fields in exp form are filled and there are no errors
      const isAllFieldsFilled = Object.values(this.newExperience).every(value => value)
      const hasNoErrors = Object.keys(this.errors).length === 0

      return isAllFieldsFilled && hasNoErrors
    }
  },
  watch: {
    formData: {
      immediate: true,
      handler() {
        this.$emit('validation-change', this.isValid);
      }
    }
  },
  methods: {
    validateField(fieldName) {
      const value = this.newExperience[fieldName]
      let error = ''

      if (!value) {
        error = 'To pole jest wymagane'
      } else if (fieldName === 'company' || fieldName === 'position') {
        error = validateField(value, 'text', 'To pole')
      }

      if (error) {
        this.errors[fieldName] = error
      } else {
        delete this.errors[fieldName]
      }

      // Validate dates relationship when either date changes
      if (fieldName === 'dateFrom' || fieldName === 'dateTo') {
        const dateError = validateExperienceDates(
          this.newExperience.dateFrom,
          this.newExperience.dateTo
        )
        if (dateError) {
          this.errors.dateFrom = dateError
          this.errors.dateTo = dateError
        } else {
          delete this.errors.dateFrom
          delete this.errors.dateTo
        }
      }
    },
    toggleAddExperience() {
      this.isAddingExperience = !this.isAddingExperience
      if (!this.isAddingExperience) {
        this.resetForm()
      }
    },
    resetForm() {
      this.newExperience = {
        company: '',
        position: '',
        dateFrom: '',
        dateTo: ''
      }
      this.errors = {}
    },
    handleAddExperience() {
      if (this.isExpFormValid) {
        const experienceToAdd = { ...this.newExperience }
        this.$emit('update:formData', [...this.formData, experienceToAdd])
        this.resetForm()
        this.isAddingExperience = false
      }
    },
    deleteExperience(index) {
      const updatedExperiences = [...this.formData]
      updatedExperiences.splice(index, 1)
      this.$emit('update:formData', updatedExperiences)
    }
  }
}
</script>

<template>
  <div class="form-page">
    <FormTitle title="Doświadczenie zawodowe" :subtitle="{ current: 3, all: 3 }" />

    <div class="form">
      <!-- If no experiences added, show big add button -->
      <div v-if="formData.length === 0 && !isAddingExperience" class="add-experience-button"
        @click="toggleAddExperience">
        <div class="add-icon">+</div>
        <span class="add-text">Dodaj doświadczenie zawodowe</span>
      </div>

      <!-- List of added experiences -->
      <div v-if="formData.length > 0 && !isAddingExperience" class="experiences-list">
        <div v-for="(experience, index) in formData" :key="index" class="experience__item">
          <div class="experience__details">
            <p class="experience__company">{{ experience.company }}</p>
            <p class="experience__position">{{ experience.position }}</p>
            <p>{{ experience.dateFrom }} — {{ experience.dateTo }}</p>
          </div>
          <button class="delete-button" @click="deleteExperience(index)"><img src="../assets/trash.svg"
              alt="trash icon"></button>
        </div>
      </div>

      <!-- Add experience form -->
      <div v-if="isAddingExperience" class="add-experience-form">
        <div class="form-row">
          <FormInput label="Firma" type="text" v-model="newExperience.company" @blur="validateField('company')"
            :error="errors.company" />
        </div>
        <div class="form-row">
          <FormInput label="Stanowisko" type="text" v-model="newExperience.position" @blur="validateField('position')"
            :error="errors.position" />
        </div>
        <div class="form-row dates">
          <FormInput label="Data od" type="date" v-model="newExperience.dateFrom" @blur="validateField('dateFrom')"
            :error="errors.dateFrom" />
          <FormInput label="Data do" type="date" v-model="newExperience.dateTo" @blur="validateField('dateTo')"
            :error="errors.dateTo" />
          <div v-if="errors.dateFrom" class="form__error">
            Data od nie może być późniejsza niż data do
          </div>
        </div>
        <div class="buttons-row">
          <button class="cancel-button" @click="toggleAddExperience">
            Anuluj
          </button>
          <button class="add-button" :disabled="!isExpFormValid" @click="handleAddExperience">
            Dodaj doświadczenie
          </button>
        </div>
      </div>

      <!-- Show small add button when there are experiences -->
      <button v-if="formData.length > 0 && !isAddingExperience" class="secondary-add-button"
        @click="toggleAddExperience">
        <span class="add-icon">+</span>
        <span>Dodaj kolejne doświadczenie</span>
      </button>
    </div>
  </div>
</template>

<style scoped>
.add-experience-button {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 200px;
  background: #ECECEC;
  border: 2px dashed #646464;
  border-radius: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  gap: 12px;
}

.add-experience-button:hover {
  cursor: pointer;
}

.add-icon {
  font-size: 40px;
  font-weight: 300;
  color: #646464;
}

.add-text {
  font-size: 20px;
  color: #646464;
}

.secondary-add-button {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 16px 32px;
  background: none;
  border: 2px dashed #646464;
  border-radius: 16px;
  cursor: pointer;
  font-family: 'Unbounded', sans-serif;
  font-size: 18px;
  color: #646464;
  transition: all 0.3s ease;
}

.secondary-add-button:hover {
  cursor: pointer;
}

.experiences-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.experience__item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  border: 2px solid #000;
  border-radius: 16px;
  position: relative;
}

.experience__details {
  flex: 1;
}

.experience__company {
  font-weight: bold;
  font-size: 18px;
}

.experience__position {
  font-size: 16px;
  color: #646464;
}

.delete-button {
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  opacity: 0;
  padding: 8px 16px;
  background: #0000;
  border-radius: 8px;
  color: #fff;
  position: absolute;
  right: 16px;
}

.experience__item:hover .delete-button {
  opacity: 1;
}

.add-experience-form {
  border: 2px solid #000;
  border-radius: 32px;
  padding: 32px;
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.form-row {
  width: 100%;
}

.form-row.dates {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  position: relative;
}

.buttons-row {
  display: flex;
  justify-content: flex-end;
  gap: 16px;
}

.cancel-button,
.add-button {
  padding: 16px 32px;
  border-radius: 16px;
  font-family: 'Unbounded', sans-serif;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cancel-button {
  background: none;
  border: 2px solid #000;
  color: #000;
}

.add-button {
  width: 100%;
  background: #000;
  border: 2px solid #000;
  color: #fff;
}

.add-button:hover {
  opacity: 0.8;
}

.add-button:disabled {
  background: #ccc;
  border-color: #ccc;
  cursor: not-allowed;
  opacity: 0.7;
}

.add-button:disabled:hover {
  opacity: 0.7;
}

.cancel-button:hover {
  background: rgb(217, 37, 17);
  border-color: rgb(150, 17, 0);
  color: #fff;
}
</style>