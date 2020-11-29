<template>
  <div id="page-registro-form">
    <vs-alert color="danger" title="Registro Not Found" :active.sync="not_found">
      <span>Registro record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check </span><router-link :to="{name:'page-registro-list'}" class="text-inherit underline">All Registros</router-link>
      </span>
    </vs-alert>
    <ValidationObserver v-slot="{ handleSubmit, reset, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <vs-row>
            <vs-col class="px-2" vs-w="12">
              <ValidationProvider class="w-full" name="registro.title" rules="required|min:3|max:250" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.title"
                  :danger="invalid && validated"
                  :label="$t('registro.title_label')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2 mt-4" vs-w="12">
              <ValidationProvider class="w-full" name="registro.alumno" rules="required" v-slot="{ errors, invalid, validated }">
                <label class="vs-input--label">{{ $t('registro.alumno') }}</label>
                <v-select
                  label="label"
                  v-model="data.alumno_idSelect"
                  :reduce="data => data.value"
                  :clearable="false"
                  :options="alumnoList"
                  :danger="invalid && validated"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2" vs-w="12">
              <ValidationProvider class="w-full" name="registro.tutor" rules="required|min:3|max:50" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.tutor"
                  :danger="invalid && validated"
                  :label="$t('registro.tutor')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2 mt-5 mb-2" vs-w="12">
              <vs-checkbox v-model="data.consultancies">{{ $t('registro.consultancies') }}</vs-checkbox>
            </vs-col>
            <vs-col class="px-2 mt-2 mb-2" vs-w="12">
              <vs-checkbox v-model="data.documentation">{{ $t('registro.documentation') }}</vs-checkbox>
            </vs-col>
            <vs-col class="px-2 mt-2 mb-2" vs-w="12">
              <vs-checkbox v-model="data.assignedDate">{{ $t('registro.assignedDate') }}</vs-checkbox>
            </vs-col>
            <vs-col class="px-2 mt-2 mb-2" vs-w="12">
              <vs-checkbox v-model="data.presentation">{{ $t('registro.presentation') }}</vs-checkbox>
            </vs-col>
            <vs-col class="px-2 mt-2 mb-2" vs-w="12">
              <vs-checkbox v-model="data.finalTome">{{ $t('registro.finalTome') }}</vs-checkbox>
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
import moduleRegistroManagement from '@/store/registro/moduleRegistroManagement.js'
import vSelect from 'vue-select'

export default {
  components: {
    vSelect
  },
  data () {
    return {
      data: {
        id: '',
        title: '',
        tutor: '',
        alumno_idSelect: '',
        alumno_id: '',
        consultancies: false,
        documentation: false,
        assignedDate: false,
        presentation: false,
        finalTome: false
      },
      data_original: {},
      not_found: false
    }
  },
  computed: {
    alumnoList () {
      return this.$store.state.registroManagement.moduleData.alumnos
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
      this.$store.dispatch('registroManagement/getModuleData')
    },
    fetch (id) {
      this.loading()
      this.not_found = false
      this.data.id = id
      this.$store.dispatch('registroManagement/fetch', id)
        .then(res => {
          this.loaded()
          this.data = res.data.data
          this.data.alumno_idSelect = res.data.data.alumno_id
        })
        .catch(err => {
          this.loaded()
          this.data.id = ''
          console.log(err)
          if (err.response.status === 404) {
            this.not_found = true
            return
          }
          console.error(err)
        })
    },
    save () {
      this.loading()
      this.data.alumno_id = this.data.alumno_idSelect
      this.$store
        .dispatch('registroManagement/save', this.data)
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
      this.$router.push({ name: 'registro' }).catch(() => {})
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
    if (!moduleRegistroManagement.isRegistered) {
      this.$store.registerModule('registroManagement', moduleRegistroManagement)
      moduleRegistroManagement.isRegistered = true
    }

    this.data_original = Object.assign({}, this.data)
    this.reset()

    this.getModuleData()

    if (this.$route.params.id) {
      this.fetch(this.$route.params.id)
    }
  }
}

</script>
