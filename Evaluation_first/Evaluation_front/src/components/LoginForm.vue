<template>
  <form @submit.prevent="handleLogin">
    <div>
      <label for="email">Email :</label>
      <input type="email" id="email" v-model="form.email" required>
    </div>
    <div>
      <label for="password">password :</label>
      <input type="password" id="password" v-model="form.password" required>
    </div>
    <button type="submit">Login</button>
    <div v-if="error" class="error-message">{{ error }}</div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/user';

const store = useUserStore();
const router = useRouter();

const form = ref({
  email: '',
  password: ''
});

const error = ref('');

const handleLogin = async () => {
  error.value = '';

  try {
    await store.dispatch('user/login', form.value);

    router.push('/');
  } catch (err) {
    error.value = err.message || 'Échec de la connexion. Veuillez vérifier vos identifiants.';
  }
};
</script>

