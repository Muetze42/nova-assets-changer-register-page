<template>
    <div>
        <Head :title="__('Register')"/>

        <form
            @submit.prevent="attempt"
            class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-[25rem] mx-auto"
        >
            <div class="mb-6">
                <label class="block mb-2" for="name">{{ __('Name') }}<span class="help-text-error">*</span></label>
                <input
                    v-model="form.name"
                    class="form-control form-input form-input-bordered w-full"
                    :class="{ 'form-input-border-error': form.errors.has('name') }"
                    id="name"
                    type="text"
                    name="name"
                    autofocus=""
                    required
                />
                <HelpText class="mt-2 text-red-500" v-if="form.errors.has('name')">
                    {{ form.errors.first('name') }}
                </HelpText>
            </div>

            <div class="mb-2">
                <label class="block mb-2" for="email">{{ __('Email Address') }}<span class="help-text-error">*</span></label>
                <input
                    v-model="form.email"
                    class="form-control form-input form-input-bordered w-full"
                    :class="{ 'form-input-border-error': form.errors.has('email') }"
                    id="email"
                    type="email"
                    name="email"
                    autofocus=""
                    required
                />
                <HelpText class="mt-2 text-red-500" v-if="form.errors.has('email')">
                    {{ form.errors.first('email') }}
                </HelpText>
            </div>
            <div class="mb-6">
                <label class="block mb-2" for="email_confirmation">{{ __('Verify Email Address') }}<span class="help-text-error">*</span></label>
                <input
                    v-model="form.email_confirmation"
                    class="form-control form-input form-input-bordered w-full"
                    :class="{ 'form-input-border-error': form.errors.has('email_confirmation') }"
                    id="email_confirmation"
                    type="email"
                    name="email_confirmation"
                    autofocus=""
                    required
                />
                <HelpText class="mt-2 text-red-500" v-if="form.errors.has('email_confirmation')">
                    {{ form.errors.first('email_confirmation') }}
                </HelpText>
            </div>

            <div class="mb-2">
                <label class="block mb-2" for="password">{{ __('Password') }}<span class="help-text-error">*</span></label>
                <input
                    v-model="form.password"
                    class="form-control form-input form-input-bordered w-full"
                    :class="{ 'form-input-border-error': form.errors.has('password') }"
                    id="password"
                    type="password"
                    name="password"
                    required
                />

                <HelpText class="mt-2 text-red-500" v-if="form.errors.has('password')">
                    {{ form.errors.first('password') }}
                </HelpText>
            </div>

            <div class="mb-6">
                <label class="block mb-2" for="password_confirmation">{{ __('Confirm Password') }}<span class="help-text-error">*</span></label>
                <input
                    v-model="form.password_confirmation"
                    class="form-control form-input form-input-bordered w-full"
                    :class="{ 'form-input-border-error': form.errors.has('password_confirmation') }"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"

                />

                <HelpText class="mt-2 text-red-500" v-if="form.errors.has('password_confirmation')">
                    {{ form.errors.first('password_confirmation') }}
                </HelpText>
            </div>

            <div class="mb-6">
                <label class="block mb-2" for="privacy">
                    <input
                        v-model="form.privacy"
                        class="checkbox mb-1 mr-1"
                        :class="{ 'form-input-border-error': form.errors.has('privacy') }"
                        id="privacy"
                        type="checkbox"
                        name="privacy"
                        required
                    />
                    <span v-html="privacyText" />
                    <span class="help-text-error">*</span>
                </label>

                <HelpText class="mt-2 text-red-500" v-if="form.errors.has('privacy')">
                    {{ form.errors.first('privacy') }}
                </HelpText>
            </div>

            <DefaultButton class="w-full flex justify-center mb-6" type="submit">
                <span>
                    {{ __('Register') }}
                </span>
            </DefaultButton>

            <div class="flex justify-between mt-6">
                <Link
                    :href="$url('/login')"
                    class="text-gray-500 font-bold no-underline"
                    v-text="__('Login')"
                />
                <div
                    v-if="supportsPasswordReset || forgotPasswordPath !== false"
                    class="ml-auto"
                >
                    <Link
                        v-if="forgotPasswordPath === false"
                        :href="$url('/password/reset')"
                        class="text-gray-500 font-bold no-underline"
                        v-text="__('Forgot your password?')"
                    />
                    <a
                        v-else
                        :href="forgotPasswordPath"
                        class="text-gray-500 font-bold no-underline"
                        v-text="__('Forgot your password?')"
                    />
                    <a
                        v-else
                        :href="forgotPasswordPath"
                        class="text-gray-500 font-bold no-underline"
                        v-text="__('Forgot your password?')"
                    />
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import Auth from '@/layouts/Auth'

export default {
    name: "RegisterPage",

    layout: Auth,

    data: () => ({
        form: Nova.form({
            name: '',
            email: '',
            email_confirmation: '',
            password: '',
            password_confirmation: '',
            privacy: false,
        }),
    }),

    props: {
        privacyText: String,
    },

    methods: {
        async attempt() {
            const {redirect} = await this.form.post(Nova.url('/register'))

            if (redirect !== undefined && redirect !== null) {
                window.location.href = redirect
            }

            window.location.href = Nova.config('base')
            //Nova.visit('/') // Missing dashboard auth
        },
    },

    computed: {
        supportsPasswordReset() {
            return Nova.config('withPasswordReset')
        },

        forgotPasswordPath() {
            return Nova.config('forgotPasswordPath')
        },
    },
}
</script>
