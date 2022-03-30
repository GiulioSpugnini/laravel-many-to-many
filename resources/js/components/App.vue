<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <Header />

          <div class="card-body">
            <h1>Sito in manutenzione</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Header from "./Header.vue";
export default {
  name: "App",
  components: {
    Header,
  },
};
</script>
