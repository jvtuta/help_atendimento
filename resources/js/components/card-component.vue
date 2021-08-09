<template>
  <div class="card bg-light mb-3 p-0">
    <div class="card-header" v-html="cardheader">
    </div>
    
    <slot name="cardbody"></slot>
    
    <slot name="cardfooter"></slot>
  </div>
</template>

<script>
export default {
    props: ['cardheader']
};
</script>

<style>
</style>