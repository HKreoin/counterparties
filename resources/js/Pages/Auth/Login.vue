<script setup>
import {Button} from '@/components/ui/button/index.js';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card/index.js';
import {Input} from '@/components/ui/input/index.js';
import {Label} from '@/components/ui/label/index.js';
import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    email: null,
    password: null,
    remember: null,
})

const submit = () => {
    form.post(route('login'), {
        onError: () => form.reset('password'),
    })
}
</script>

<template>
    <form
        class="flex h-screen items-center w-full"
        @submit.prevent="submit"
    >
        <Card class="mx-auto w-full max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl"> Вход в аккаунт</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            placeholder="example@einzelwerk.ru"
                            required
                            v-model="form.email"
                        />
                        <small
                            class="text-destructive"
                            v-if="form.errors.email"
                        >{{ form.errors.email }}</small>
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label for="password">Пароль</Label>
                        </div>
                        <Input
                            id="password"
                            type="password"
                            required
                            v-model="form.password"
                        />
                        <small
                            class="text-destructive"
                            v-if="form.errors.password"
                        >{{ form.errors.password }}</small>
                    </div>
                    <Button
                        type="submit"
                        class="w-full"
                    > Войти
                    </Button>
                </div>
                <hr>
                <div class="mt-4 text-center text-sm">
                    Нет аккаунта?
                    <a
                        :href="route('register')"
                        class="underline"
                    > Зарегистрироваться </a>
                </div>
            </CardContent>
        </Card>
    </form>
</template>
