/**
 * Fetches all users from the API
 * @returns {Promise<Array>} Array of users
 */
export const getAllUsers = async () => {
  const response = await fetch('http://localhost:8000/api/users', {
    headers: {
      'Accept': 'application/json'
    }
  });

  if (!response.ok) {
    throw new Error('Failed to fetch users');
  }

  return response.json();
};

/**
 * Fetches a specific user by ID
 * @param {number} id - User ID
 * @returns {Promise<Object>} User data
 */
export const getUserById = async (id) => {
  const response = await fetch(`http://localhost:8000/api/users/${id}`, {
    headers: {
      'Accept': 'application/json'
    }
  });

  if (!response.ok) {
    throw new Error('Failed to fetch user');
  }

  return response.json();
};