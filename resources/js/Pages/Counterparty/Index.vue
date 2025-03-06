<script setup>
import {router} from "@inertiajs/inertia-vue3";
import {ref, watch} from 'vue';
import {debounce} from 'lodash';
import {Button} from '@/components/ui/button/index.js';
import * as _ from 'lodash-es';

const props = defineProps({
    counterparties: Object,
    searchTerm: String
})

const search = ref(props.searchTerm)

watch(
    search,
    debounce(q => router.get(route('counterparty.index'), {search: q}, {preserveState: true}), 500),
)
</script>

<template>
    <div
        v-if="_.isEmpty(counterparties)"
        class="flex h-screen items-center"
    >
        <div class="text-center mx-auto">
            <div>
                <h2 class="font-semibold text-xl"> Контрагенты еще не добавлены </h2>
                <p class="text-sm text-muted-foreground pt-1">Добавьте первого контрагента</p>
            </div>
            <div class="pt-4">
                <a :href="route('counterparties.create')">
                    <Button>
                        Добавить
                    </Button>
                </a>
            </div>
        </div>
    </div>
    <div v-else class="flex h-screen items-center">
        <div v-for="counterparty in counterparties" :key="counterparty.id">
            {{ counterparty.name }}
            {{ counterparty.inn}}
            {{ counterparty.ogrn }}
        </div>
    </div>
</template>
