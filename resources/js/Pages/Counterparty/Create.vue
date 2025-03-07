<script setup>
import { Button } from '@/components/ui/button/index.js'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card/index.js'
import { Input } from '@/components/ui/input/index.js'
import { useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
  inn: null,
})

const submit = () => {
  form.post(route('counterparties.store'))
}
</script>

<template>
  <form class="flex h-screen items-center" @submit.prevent="submit">
    <Card class="mx-auto w-full max-w-sm">
      <CardHeader>
        <CardTitle> Добавление контрагента</CardTitle>
        <CardDescription>
          Введите ИНН, чтобы добавить контрагента
        </CardDescription>
      </CardHeader>
      <CardContent>
        <div class="grid gap-4">
          <div class="grid gap-2">
            <Input
              id="inn"
              type="number"
              placeholder="ИНН"
              required
              v-model="form.inn"
            />
            <small class="text-destructive" v-if="form.errors.inn">{{
              form.errors.inn
            }}</small>
          </div>
          <div>
            <CardDescription>
              После нажатия на кнопку «Добавить», данные автоматически
              подгрузятся в таблицу
            </CardDescription>
          </div>
          <Button :disabled="form.processing"> Добавить</Button>
        </div>
        <hr />
      </CardContent>
    </Card>
  </form>
</template>

<style scoped></style>
