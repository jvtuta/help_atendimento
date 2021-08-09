<template>
    <ul :class='classe'>
        <slot></slot>
    </ul>
</template>

<script>
export default {
    props:['dir'],
    data() {
        return {
            classe: this.dir == 'direita' ? 'navbar-nav ms-auto' : 'navbar-nav me-auto'
        }
    },
}
</script>

<style>

</style>