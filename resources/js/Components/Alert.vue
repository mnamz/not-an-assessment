<template>
    <div></div>
  </template>
  
  <script setup>
  import Swal from 'sweetalert2';
  
  export default {
    props: ['message'],
    mounted() {
      Swal.fire({
        title: 'Success',
        text: message,
        icon: 'success',
        showConfirmButton: false,
        timer: 1500
      });
    }
  };
  </script>
  