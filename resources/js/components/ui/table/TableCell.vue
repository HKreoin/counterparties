<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <td
    :class="
      cn(
        'p-2 align-middle [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-0.5 overflow-hidden overflow-ellipsis whitespace-nowrap',
        props.class,
      )
    "
  >
    <slot />
  </td>
</template>
