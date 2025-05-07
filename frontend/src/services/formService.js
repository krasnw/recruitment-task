export const submitFormData = async (formData) => {
  const response = await fetch("http://localhost:8000/api/form", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(formData),
  });

  if (!response.ok) {
    throw new Error("Form submission failed");
  }

  return response.json();
};
