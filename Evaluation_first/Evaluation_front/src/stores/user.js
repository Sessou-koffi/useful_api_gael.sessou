import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({

    userData: null,
    loading: false,
    error: null
  }),

actions: {
  async register(userData) {
    this.loading = true;
    this.error = null;
    try {
      const response = await fetch('api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Échec de l\'inscription');
      }

      const data = await response.json();
      this.user = data.user;
      this.token = data.token;

      localStorage.setItem('token', data.token);

    } catch (err) {
      this.error = err.message;
      this.user = null;
      this.token = null;
    } finally {
      this.loading = false;
    }
  },

    async login(credentials) {
      this.loading = true;
      this.error = null;
      try {
        const response = await fetch('api/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(credentials),
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Identifiants invalides');
        }

        const data = await response.json();
        this.user = data.user;
        this.token = data.token;

        localStorage.setItem('token', data.token);

      } catch (err) {
        this.error = err.message;
        this.user = null;
        this.token = null;
      } finally {
        this.loading = false;
      }
    },
    // ...
  },
});
