<script setup>
defineProps({
    pagination: {
        type: Object,
        required: true,
    },
})

const makeLabel = label => {
    if (label.includes('Previous')) {
        return '< Назад'
    } else if (label.includes('Next')) {
        return 'Далее >'
    } else {
        return label
    }
}
</script>

<template>
    <nav class="relative flex justify-center">
        <template v-for="link in pagination.links" :key="link.label">
            <Link
                preserve-scroll
                :href="link.url ?? ''"
                v-html="makeLabel(link.label)"
                class="flex items-center justify-center px-3 py-2 text-sm rounded-lg mx-1"
                :class="{ 'bg-white': link.active, '!text-gray-300': !link.url }"
            />
        </template>
    </nav>
</template>
