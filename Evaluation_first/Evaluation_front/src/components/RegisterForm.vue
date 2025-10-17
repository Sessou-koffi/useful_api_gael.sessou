<template>
  <form @submit.prevent="handleSubmit">
    <div>
      <label for="name">Name :</label>
      <input type="text" id="rname" v-model="name" required>
    </div>
    <div>
      <label for="email">Email :</label>
      <input type="email" id="email" v-model="email" required>
    </div>
    <div>
      <label for="password">password :</label>
      <input type="password" id="password" v-model="password" required>
    </div>
    <div>
      <label for="password">Confirm password :</label>
      <input type="password" id="password" v-model="password" required>
    </div>
    <button type="submit">Register</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user';

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirm = ref('');
//const store = useUserStore();

const handleSubmit = async () => {
  try {
    const userData = {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirm: password_confirm.value,
    };
    await useUserStore.register(userData);
    alert('Utilisateur enregistré avec succès !');
  } catch  {
    alert('Erreur lors de l\'enregistrement de l\'utilisateur.');
  }
};
</script>
