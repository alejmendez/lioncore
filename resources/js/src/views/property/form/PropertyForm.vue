<template>
  <div id="page-property-form">
    <vs-alert color="danger" title="Property Not Found" :active.sync="not_found">
      <span>Property record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check </span><router-link :to="{name:'page-property-list'}" class="text-inherit underline">All Propertys</router-link>
      </span>
    </vs-alert>
    <ValidationObserver v-slot="{ handleSubmit, reset, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <vs-row>
            <vs-col vs-type="flex" vs-w="6">
              <ValidationProvider name="property.name" rules="required|min:3|max:50" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.name"
                  :danger="invalid && validated"
                  :label="$t('property.name')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col vs-type="flex" vs-w="6">
              <ValidationProvider name="property.value" rules="required|min:3" v-slot="{ errors, invalid, validated }">
                <vs-textarea
                  class="w-full mt-4"
                  v-model="data.value"
                  :danger="invalid && validated"
                  :label="$t('property.value')"
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
                class="ml-auto mt-2 float-right"
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
import vSelect from 'vue-select'

import modulePropertyManagement from '@/store/property/modulePropertyManagement.js'

export default {
  components: {
    vSelect
  },
  data () {
    return {
      data: {
        id: '',
        name: '',
        value: ''
      },
      data_original: {},
      not_found: false,
      activeTab: 0
    }
  },
  methods: {
    getModuleData () {
      this.$store.dispatch('propertyManagement/getModuleData')
    },
    fetchData (id) {
      this.data.id = id
      this.$store.dispatch('propertyManagement/fetch', id)
        .then(res => { this.data = res.data.data })
        .catch(err => {
          if (err.response.status === 404) {
            this.not_found = true
            return
          }
          console.error(err)
        })
    },
    save () {
      /* eslint-disable */
      if (!this.validateForm) return

      this.$store
        .dispatch('propertyManagement/save', this.data)
        .then(() => {
          this.showSuccess()
          this.back()
        })
        .catch(err => {
          this.showError()
          console.error(err)
        })

      /* eslint-enable */
    },
    back () {
      this.$router.push('/property').catch(() => {})
    },
    reset () {
      this.data = Object.assign({}, this.data_original)
    },
    showSuccess () {
      this.$vs.notify({
        color: 'success',
        title: this.$t('save_success'),
        text: this.$t('the_record_has_been_saved_successfully')
      })
    },
    showError () {
      this.$vs.notify({
        color: 'danger',
        title: this.$t('save_error'),
        text: this.$t('an_exception_occurred_while_saving')
      })
    }
  },
  created () {
    if (!modulePropertyManagement.isRegistered) {
      this.$store.registerModule('propertyManagement', modulePropertyManagement)
      modulePropertyManagement.isRegistered = true
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
