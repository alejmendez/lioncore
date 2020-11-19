<template>
  <div id="page-grafica-form">
    <vs-alert color="danger" title="Grafica Not Found" :active.sync="not_found">
      <span>Grafica record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check </span><router-link :to="{name:'page-grafica-list'}" class="text-inherit underline">All Graficas</router-link>
      </span>
    </vs-alert>
    <ValidationObserver v-slot="{ handleSubmit, reset, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <vs-row>
            <vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="grafica.title" rules="required,min:3,max:250" v-slot="{ errors, invalid, validated }">
                <vs-text
                  class="w-full mt-4"
                  v-model="data.title"
                  :danger="invalid && validated"
                  :label="$t('grafica.title')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
                      </vs-row>
          <!-- Save & Reset Button -->
          <vs-row>
            <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12" class="p-4 sm:p-2">
              <vs-button
                class="mr-auto mt-2 float-left"
                color="dark"
                icon="arrow_back"
                @click="back"
              >
                {{ $t('common.back') }}
              </vs-button>
              <vs-button
                class="ml-auto mt-2 float-right vs-con-loading__container"
                button="submit"
                icon="save"
                :disabled="invalid"
              >
                {{ $t('common.save_changes') }}
              </vs-button>
              <vs-button
                class="ml-4 mt-2 float-right"
                type="border"
                button="reset"
                color="warning"
                icon="replay"
                @click="reset"
              >
                {{ $t('common.reset') }}
              </vs-button>
            </vs-col>
          </vs-row>
        </vx-card>
      </form>
    </ValidationObserver>
  </div>
</template>

<script>
import moduleGraficaManagement from '@/store/grafica/moduleGraficaManagement.js'

export default {
  data () {
    return {
      data: {
        id: '',
        title: '',
              },
      data_original: {},
      not_found: false
    }
  },
  methods: {
    loading () {
      this.$vs.loading()
    },
    loaded () {
      this.$vs.loading.close()
    },
    getModuleData () {
      this.$store.dispatch('graficaManagement/getModuleData')
    },
    fetch (id) {
      this.loading()
      this.not_found = false
      this.data.id = id
      this.$store.dispatch('graficaManagement/fetch', id)
        .then(res => {
            this.loaded()
          this.data = res.data.data
        })
        .catch(err => {
          this.loaded()
          this.data.id = ''
          if (err.response.status === 404) {
            this.not_found = true
            return
          }
          console.error(err)
        })
    },
    save () {
      this.loading()
      this.$store
        .dispatch('graficaManagement/save', this.data)
        .then(() => {
          this.loaded()
          this.showSuccess()
          this.back()
        })
        .catch(err => {
          this.loaded()
          this.showError()
          console.error(err)
        })
    },
    back () {
      this.$router.push({ name: 'grafica' }).catch(() => {})
    },
    reset () {
      this.data = Object.assign({}, this.data_original)
    },
    showSuccess () {
      this.$vs.notify({
        color: 'success',
        title: this.$t('common.save_success'),
        text: this.$t('common.the_record_has_been_saved_successfully')
      })
    },
    showError () {
      this.$vs.notify({
        color: 'danger',
        title: this.$t('common.save_error'),
        text: this.$t('common.an_exception_occurred_while_saving')
      })
    }
  },
  created () {
    if (!moduleGraficaManagement.isRegistered) {
      this.$store.registerModule('graficaManagement', moduleGraficaManagement)
      moduleGraficaManagement.isRegistered = true
    }

    this.data_original = Object.assign({}, this.data)
    this.reset()

    this.getModuleData()

    if (this.$route.params.id) {
      this.fetchData(this.$route.params.id)
    }
  }
}

</script>
