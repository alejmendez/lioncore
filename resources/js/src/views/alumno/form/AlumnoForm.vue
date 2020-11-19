<template>
  <div id="page-alumno-form">
    <vs-alert color="danger" title="Alumno Not Found" :active.sync="not_found">
      <span>Alumno record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check </span><router-link :to="{name:'page-alumno-list'}" class="text-inherit underline">All Alumnos</router-link>
      </span>
    </vs-alert>
    <ValidationObserver v-slot="{ handleSubmit, reset, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <vs-row>
            <vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="alumno.firstName" rules="required|min:3|max:50" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.firstName"
                  :danger="invalid && validated"
                  :label="$t('alumno.firstName')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="alumno.lastname" rules="required|min:3|max:50" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.lastname"
                  :danger="invalid && validated"
                  :label="$t('alumno.lastname')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="alumno.phone" rules="required|min:8|max:50" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.phone"
                  :danger="invalid && validated"
                  :label="$t('alumno.phone')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="alumno.email" rules="email|min:10|max:80" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.email"
                  :danger="invalid && validated"
                  :label="$t('alumno.email')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2 mt-4" vs-w="6">
              <ValidationProvider class="w-full" name="alumno.specialty" rules="required|min:3|max:20" v-slot="{ errors, invalid, validated }">
                <label class="vs-input--label">{{ $t('alumno.specialty') }}</label>
                <v-select
                  label="label"
                  v-model="data.specialty"
                  :clearable="false"
                  :options="specialtyOptions"
                  :danger="invalid && validated"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
            <vs-col class="px-2 mt-4" vs-w="6">
              <ValidationProvider class="w-full" name="alumno.semester" rules="required|min:3|max:20" v-slot="{ errors, invalid, validated }">
                <label class="vs-input--label">{{ $t('alumno.semester') }}</label>
                <v-select
                  label="label"
                  v-model="data.semester"
                  :clearable="false"
                  :options="semesterOptions"
                  :danger="invalid && validated"
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
import moduleAlumnoManagement from '@/store/alumno/moduleAlumnoManagement.js'
import vSelect from 'vue-select'

export default {
  components: {
    vSelect
  },
  data () {
    return {
      data: {
        id: '',
        firstName: '',
        lastname: '',
        phone: '',
        email: '',
        specialty: '',
        semester: ''
      },
      data_original: {},
      not_found: false,
      specialtyOptions: [
        'Sistemas',
        'Informatica',
        'Mantenimiento',
        'Ambiental'
      ],
      semesterOptions: [
        'I-2016',
        'II-2016',
        'I-2017',
        'II-2017',
        'I-2018',
        'II-2018',
        'I-2019',
        'II-2019',
        'I-2020',
        'II-2020'
      ]
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
      this.$store.dispatch('alumnoManagement/getModuleData')
    },
    fetch (id) {
      this.loading()
      this.not_found = false
      this.data.id = id
      this.$store.dispatch('alumnoManagement/fetch', id)
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
        .dispatch('alumnoManagement/save', this.data)
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
      this.$router.push({ name: 'alumno' }).catch(() => {})
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
    if (!moduleAlumnoManagement.isRegistered) {
      this.$store.registerModule('alumnoManagement', moduleAlumnoManagement)
      moduleAlumnoManagement.isRegistered = true
    }

    this.data_original = Object.assign({}, this.data)
    this.reset()

    this.getModuleData()
    console.log(this.$route.params)
    if (this.$route.params.id) {
      this.fetch(this.$route.params.id)
    }
  }
}

</script>
