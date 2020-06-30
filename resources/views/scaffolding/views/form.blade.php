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
            @foreach ($fields as $field)<vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="{{ $nameModel }}.{{ $field['name'] }}" rules="{{ $field['validations'] }}" v-slot="{ errors, invalid, validated }">
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
                :disabled="loading"
                @click="back"
              >
                @{{ $t('common.back') }}
              </vs-button>
              <vs-button
                class="ml-auto mt-2 float-right vs-con-loading__container"
                button="submit"
                icon="save"
                ref="saveButton"
                :disabled="invalid || loading"
              >
                @{{ $t('common.save_changes') }}
              </vs-button>
              <vs-button
                class="ml-4 mt-2 float-right"
                type="border"
                button="reset"
                color="warning"
                icon="replay"
                :disabled="loading"
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
import module{{ ucfirst($nameModel) }}Management from '@/store/{{ $nameModel }}/module{{ ucfirst($nameModel) }}Management.js'

export default {
  data () {
    return {
      data: {
        id: '',
        @foreach ($fields as $field){{ $field['name'] }}: '',
        @endforeach
      },
      data_original: {},
      not_found: false,
      loading: false
    }
  },
  methods: {
    getModuleData () {
      this.$store.dispatch('{{ $nameModel }}Management/getModuleData')
    },
    fetchData (id) {
      this.loading = true
      this.data.id = id
      this.$store.dispatch('{{ $nameModel }}Management/fetch', id)
        .then(res => {
          this.loading = false
          this.data = res.data.data
        })
        .catch(err => {
          this.data.id = ''
          this.loading = false
          if (err.response.status === 404) {
            this.not_found = true
            return
          }
          console.error(err)
        })
    },
    save () {
        this.loading = true
      this.$vs.loading({
        background: 'primary',
        color: '#fff',
        container: this.$refs.saveButton.$el,
        scale: 0.45
      })
      this.$store
        .dispatch('{{ $nameModel }}Management/save', this.data)
        .then(() => {
          this.loading = false
          this.showSuccess()
          this.back()
          this.$vs.loading.close(this.$refs.saveButton.$el)
        })
        .catch(err => {
          this.loading = false
          this.showError()
          this.$vs.loading.close(this.$refs.saveButton.$el)
          console.error(err)
        })
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
