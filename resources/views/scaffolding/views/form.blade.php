<template>
  <div id="page-{{ $nameModel }}-form">
    <vs-alert color="danger" title="{{ ucfirst($nameModel) }} Not Found" :active.sync="not_found">
      <span>{{ ucfirst($nameModel) }} record with id: @{{ $route.params.id }} not found.</span>
      <span>
        <span>Check </span><router-link :to="{name:'page-{{ $nameModel }}-list'}" class="text-inherit underline">All {{ ucfirst($nameModel) }}s</router-link>
      </span>
    </vs-alert>
    <ValidationObserver v-slot="{ handleSubmit, reset, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <vs-row>
            @foreach ($fields as $field)<vs-col vs-type="flex" vs-w="6">
              <ValidationProvider name="{{ $nameModel }}.{{ $field['name'] }}" rules="{{ $field['validations'] }}" v-slot="{ errors, invalid, validated }">
                <vs-{{ $field['htmlType'] }}
                  class="w-full mt-4"
                  v-model="data.{{ $field['name'] }}"
                  :danger="invalid && validated"
                  :label="$t('{{ $nameModel }}.{{ $field['name'] }}')"
                />
                <span class="text-danger text-sm">@{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            @endforeach
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
                @{{ $t('common.back') }}
              </vs-button>
              <vs-button
                class="ml-auto mt-2 float-right"
                button="submit"
                icon="save"
                :disabled="invalid"
              >
                @{{ $t('common.save_changes') }}
              </vs-button>
              <vs-button
                class="ml-4 mt-2 float-right"
                type="border"
                button="reset"
                color="warning"
                icon="replay"
                @click="reset"
              >
                @{{ $t('common.reset') }}
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

import module{{ ucfirst($nameModel) }}Management from '@/store/{{ $nameModel }}/module{{ ucfirst($nameModel) }}Management.js'

export default {
  components: {
    vSelect
  },
  data () {
    return {
      data: {
        id: '',
        @foreach ($fields as $field){{ $field['name'] }}: '',
        @endforeach
      },
      data_original: {},
      not_found: false,
      activeTab: 0
    }
  },
  methods: {
    getModuleData () {
      this.$store.dispatch('{{ $nameModel }}Management/getModuleData')
    },
    fetchData (id) {
      this.data.id = id
      this.$store.dispatch('{{ $nameModel }}Management/fetch', id)
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
        .dispatch('{{ $nameModel }}Management/save', this.data)
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
      this.$router.push('/{{ $nameModel }}').catch(() => {})
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
    if (!module{{ ucfirst($nameModel) }}Management.isRegistered) {
      this.$store.registerModule('{{ $nameModel }}Management', module{{ ucfirst($nameModel) }}Management)
      module{{ ucfirst($nameModel) }}Management.isRegistered = true
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
