<template>
  <div id="app">
    <h1>Inscription</h1>
    <RegisterForm/>
  </div>
</template>

<script>
import RegisterForm from './components/RegisterForm.vue';

export default {
  name: 'App',
  components: {
    RegisterForm
  }
};
</script>

