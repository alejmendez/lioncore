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
            <div class="mt-8 mb-8 flex flex-wrap items-center justify-end">
                <vs-button
                  class="ml-auto mt-2"
                  button="submit"
                  :disabled="!invalid"
                >
                  @{{ $t('common.save_changes') }}
                </vs-button>
                <vs-button
                  class="ml-4 mt-2"
                  type="border"
                  button="reset"
                  color="warning"
                  @click="reset_data"
                >
                  @{{ $t('common.reset') }}
                </vs-button>
              </div>
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
    fetch_data (id) {
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

      // Here will go your API call for updating data
      // You can get data in "this.data"

      /* eslint-enable */
    },
    reset_data () {
      this.data = Object.assign({}, this.data_original)
    },
    update_avatar (event) {
      const input = event.target
      if (input.files && input.files[0]) {
        const reader = new FileReader()
        reader.onload = (e) => {
          console.log(e.target.result)
          this.data.avatar = e.target.result
        }
        reader.readAsDataURL(input.files[0])
      }
    }
  },
  created () {
    if (!module{{ ucfirst($nameModel) }}Management.isRegistered) {
      this.$store.registerModule('{{ $nameModel }}Management', module{{ ucfirst($nameModel) }}Management)
      module{{ ucfirst($nameModel) }}Management.isRegistered = true
    }

    this.data_original = Object.assign({}, this.data)
    this.reset_data()

    this.getModuleData()

    if (this.$route.params.id) {
      this.fetch_data(this.$route.params.id)
    }
  }
}

</script>
