<template>
  <div>
    <ValidationObserver v-slot="{ handleSubmit, invalid }">
      <form @submit.prevent="handleSubmit(loginJWT)">
        <ValidationProvider rules="required|email|min:3" v-slot="{ errors }">
          <vs-input
            name="email"
            class="w-full"
            icon-no-border
            icon="icon icon-user"
            icon-pack="feather"
            v-model="email"
            :label-placeholder="$t('login.email')"
            />
          <span class="text-danger text-sm">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider rules="required|min:6|max:10" v-slot="{ errors }">
          <vs-input
            name="password"
            type="password"
            class="w-full mt-6"
            icon-no-border
            icon="icon icon-lock"
            icon-pack="feather"
            v-model="password"
            :label-placeholder="$t('login.password')"
            />
          <span class="text-danger text-sm">{{ errors[0] }}</span>
        </ValidationProvider>

        <div class="flex flex-wrap justify-between my-5">
          <vs-checkbox v-model="checkbox_remember_me" class="mb-3">{{ $t('login.remember_me') }}</vs-checkbox>
          <router-link to="/pages/forgot-password">{{ $t('login.forgot_password') }}</router-link>
        </div>
        <div class="flex flex-wrap justify-between mb-3">
          <vs-button type="border" @click="registerUser">{{ $t('login.register') }}</vs-button>
          <vs-button button="submit" :disabled="invalid">{{ $t('login.login') }}</vs-button>
        </div>
      </form>
    </ValidationObserver>
  </div>
</template>

<script>
export default {
  data () {
    return {
      email: 'alejmendez.87@gmail.com',
      password: 'cq43351la',
      checkbox_remember_me: false
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.email !== '' && this.password !== ''
    }
  },
  methods: {
    checkLogin () {
      // If user is already logged in notify
      if (this.$store.state.auth.isUserLoggedIn()) {

        // Close animation if passed as payload
        // this.$vs.loading.close()

        this.$vs.notify({
          title: 'Login Attempt',
          text: 'You are already logged in!',
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'warning'
        })

        return false
      }
      return true
    },
    loginJWT () {
      // Loading
      this.$vs.loading()

      const payload = {
        checkbox_remember_me: this.checkbox_remember_me,
        userDetails: {
          email: this.email,
          password: this.password
        }
      }

      this.$store.dispatch('auth/loginJWT', payload)
        .then(() => { this.$vs.loading.close() })
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: this.$t('login.error.unauthorized'),
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
    },
    registerUser () {
      if (!this.checkLogin()) return
      this.$router.push({ name: 'page-register' }).catch(() => {})
    }
  }
}

</script>

