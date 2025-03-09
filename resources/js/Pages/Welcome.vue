<script setup>
import { Button } from '@/components/ui/button/index.js'
</script>

<template>
  <Head title="| Welcome" />
  <div class="flex h-screen items-center justify-center">
    <div>
      <div>
        <h1 class="text-blue-500 text-4xl">Добро пожаловать</h1>
      </div>
      <div class="mt-4 text-center text-sm">
        Уже есть аккаунт?
        <a :href="route('login')" class="underline"> Войти </a>
      </div>
      <div class="mt-4 text-center text-sm">
        Нет аккаунта?
        <a :href="route('register')" class="underline"> Зарегистрироваться </a>
      </div>
      <Link
        :href="route('counterparties.index')"
        class="w-full mt-2"
        as="button"
      >
        <Button>Список контрагентов</Button>
      </Link>
      <Link
        :href="route('logout')"
        method="post"
        class="w-full mt-2"
        as="button"
      >
        <Button>Выйти</Button>
      </Link>
    </div>
  </div>
</template>
