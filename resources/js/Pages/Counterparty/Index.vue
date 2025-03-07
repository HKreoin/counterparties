<script setup>
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {
  Combobox,
  ComboboxAnchor,
  ComboboxInput,
} from '@/components/ui/combobox'

import { ref, watch } from 'vue'
import { debounce } from 'lodash'
import { Button } from '@/components/ui/button/index.js'
import * as _ from 'lodash'
import { CardTitle } from '@/components/ui/card/index.js'
import { Search } from 'lucide-vue-next'
import PaginationLinks from '@/components/PaginationLinks.vue'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  counterparties: Object,
  searchTerm: String,
})

let search = ref(props.searchTerm)

watch(
  search,
  debounce(q => {
    Inertia.get(
      route('counterparties.index'),
      { search: q, page: props.counterparties?.current_page || 1 },
      { preserveState: true },
    )
  }, 300),
)
</script>

<template>
  <div
    v-if="_.isEmpty(counterparties['data'])"
    class="flex h-screen items-center"
  >
    <div class="text-center mx-auto">
      <div>
        <h2 class="font-semibold text-xl">Контрагенты еще не добавлены</h2>
        <p class="text-sm text-muted-foreground pt-1">
          Добавьте первого контрагента
        </p>
      </div>
      <div class="pt-4">
        <a :href="route('counterparties.create')">
          <Button> Добавить </Button>
        </a>
      </div>
    </div>
  </div>
  <div v-else class="w-full items-center p-12">
    <div class="flex h-full items-center justify-between w-full">
      <CardTitle class="text-2xl content-around"
        >Добавленные контрагенты</CardTitle
      >
      <div>
        <a :href="route('counterparties.create')">
          <Button> Добавить </Button>
        </a>
      </div>
    </div>
    <Combobox by="label">
      <ComboboxAnchor class="w-full mt-6">
        <div class="relative items-center">
          <ComboboxInput
            class="pl-9"
            v-model="search"
            placeholder="Поиск по ИНН / наименованию"
          />
          <span
            class="absolute start-0 inset-y-0 flex items-center justify-center px-3"
          >
            <Search class="size-4 text-muted-foreground" />
          </span>
        </div>
      </ComboboxAnchor>
    </Combobox>
    <div class="rounded-md border mt-4">
      <Table>
        <TableHeader>
          <TableRow class="grid grid-cols-4">
            <TableHead class="content-around"> ИНН </TableHead>
            <TableHead class="content-around"> Наименование </TableHead>
            <TableHead class="content-around"> ОГРН </TableHead>
            <TableHead class="content-around"> Адрес </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow
            v-for="counterparty in counterparties.data"
            :key="counterparty.id"
            class="grid grid-cols-4"
          >
            <TableCell>{{ counterparty.inn }}</TableCell>
            <TableCell>{{ counterparty.name }}</TableCell>
            <TableCell>{{ counterparty.ogrn }}</TableCell>
            <TableCell>{{ counterparty.address }}</TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
    <div class="flex justify-center w-full mt-4">
      <PaginationLinks :pagination="counterparties"></PaginationLinks>
    </div>
  </div>
</template>
