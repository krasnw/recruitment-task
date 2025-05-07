// Validation rules
const rules = {
  text: {
    pattern: /^[\p{L}\s'-]+$/u,
    minLength: 2,
    message: () => `To pole musi mieć co najmniej 2 znaki`,
  },
  email: {
    pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    message: () => "Wprowadź poprawny adres email",
  },
  date: {
    futureNotAllowed: true,
    message: () => "Data nie może być w przyszłości",
  },
  phone: {
    validate: (value) => {
      const digitsOnly = value.replace(/\D/g, "");
      return digitsOnly.length === 9;
    },
    message: () => "Wprowadź poprawny numer telefonu (9 cyfr)",
  },
};

// Validation functions
export const validateField = (value, type, fieldName) => {
  if (!value || value.trim() === "") {
    return `${fieldName} jest wymagane`;
  }

  const rule = rules[type];
  if (!rule) return "";

  if (rule.pattern && !rule.pattern.test(value)) {
    return rule.message(fieldName);
  }

  if (type === "text" && value.length < rule.minLength) {
    return rule.message(fieldName);
  }

  if (type === "date" && rule.futureNotAllowed) {
    const inputDate = new Date(value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (inputDate > today) {
      return rule.message(fieldName);
    }
  }

  if (type === "phone" && rule.validate && !rule.validate(value)) {
    return rule.message(fieldName);
  }

  return "";
};

// Experience dates validation
export const validateExperienceDates = (dateFrom, dateTo) => {
  if (!dateFrom || !dateTo) return "";

  const startDate = new Date(dateFrom);
  const endDate = new Date(dateTo);

  if (startDate > endDate) {
    return " ";
  }

  return "";
};

// Form validation
export const validateForm = (formData, fields) => {
  const errors = {};
  let isValid = true;

  fields.forEach(({ name, type, label }) => {
    const error = validateField(formData[name], type, label);
    if (error) {
      errors[name] = error;
      isValid = false;
    }
  });

  return { isValid, errors };
};
