<script setup>

</script>

<template>
  <div v-if="$page.props.flash.success">
    <p class="p-4 bg-green-200">{{ $page.props.flash.success}}</p>
  </div>
  <div v-if="$page.props.flash.message">
    <p class="p-4 bg-blue-200">{{ $page.props.flash.message }}</p>
  </div>
  <div v-if="$page.props.flash.error">
    <p class="p-4 bg-red-200">{{ $page.props.flash.error }}</p>
  </div>
    <div class="flex h-screen items-center justify-center bg-primary-foreground">
        <slot />
    </div>
</template>

