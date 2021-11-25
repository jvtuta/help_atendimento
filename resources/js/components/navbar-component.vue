<template>
  <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="float-start">
        <a href="http://memoriaram.com.br/" target="_blank">
            <img :src="asset_logo" alt="" width="160px">
        </a>
    </div>
    <div class="container">
      <a :href="brandroute" class="navbar-brand">{{ brand }}</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <slot></slot>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  props: ["brand", "brandroute", "asset_logo"],
};
</script>

<style>
</style>