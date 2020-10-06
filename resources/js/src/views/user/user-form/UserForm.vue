<template>
  <div id="page-user-form">

    <vs-alert color="danger" :title="$t('users.user_not_found')" :active.sync="user_not_found">
      <span>{{ $t('users.user_not_found_detail', { id: $route.params.id }) }}</span>
    </vs-alert>

    <ValidationObserver v-slot="{ handleSubmit, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <div slot="no-body" class="tabs-container px-6 pt-6">
            <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
              <vs-tab :label="$t('users.account')" icon-pack="feather" icon="icon-user">
                <div class="tab-text">
                  <div class="mt-4">
                    <!-- Avatar Row -->
                    <div class="vx-row">
                      <div class="vx-col w-full">
                        <div class="flex items-start flex-col sm:flex-row">
                          <!--
                          <img
                            class="mr-8 rounded h-24 w-24"
                            :src="data.avatar"
                            />
                          -->
                          <vs-avatar
                            class="mr-4"
                            size="80px"
                            :src="data.avatar"
                          />
                          <div>
                            <p class="text-lg font-medium mb-2 mt-4 sm:mt-0">
                              {{ data.first_name }} {{ data.last_name }}
                            </p>
                            <input type="file" class="hidden" ref="update_avatar_input" @change="update_avatar" accept="image/*">

                            <!-- Toggle comment of below buttons as one for actual flow & currently shown is only for demo -->
                            <vs-button
                              class="mr-4 mb-4"
                              icon="cloud_upload"
                              @click="$refs.update_avatar_input.click()"
                            >
                              {{ $t('users.change_avatar') }}
                            </vs-button>

                            <vs-button
                              type="border"
                              color="danger"
                              icon="clear"
                              @click="data.avatar = null"
                            >
                              {{ $t('users.remove_avatar') }}
                            </vs-button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Content Row -->
                    <div class="vx-row">
                      <div class="vx-col md:w-1/2 w-full">
                        <ValidationProvider name="users.username" rules="required|alpha_num" v-slot="{ errors, invalid, validated }">
                          <vs-input
                            class="w-full mt-4"
                            v-model="data.username"
                            :danger="invalid && validated"
                            :label="$t('users.username')"
                          />
                          <span class="text-danger text-sm">{{ errors[0] }}</span>
                        </ValidationProvider>

                        <ValidationProvider name="users.first_name" rules="required|alpha_spaces" v-slot="{ errors, invalid, validated }">
                          <vs-input
                            class="w-full mt-4"
                            v-model="data.first_name"
                            :danger="invalid && validated"
                            :label="$t('users.first_name')"
                          />
                          <span class="text-danger text-sm">{{ errors[0] }}</span>
                        </ValidationProvider>

                        <ValidationProvider name="users.last_name" rules="required|alpha_spaces" v-slot="{ errors, invalid, validated }">
                          <vs-input
                            class="w-full mt-4"
                            v-model="data.last_name"
                            :danger="invalid && validated"
                            :label="$t('users.last_name')"
                          />
                          <span class="text-danger text-sm">{{ errors[0] }}</span>
                        </ValidationProvider>

                        <ValidationProvider name="users.email" rules="required|email" v-slot="{ errors, invalid, validated }">
                          <vs-input
                            type="email"
                            class="w-full mt-4"
                            v-model="data.email"
                            :danger="invalid && validated"
                            :label="$t('users.email')"
                          />
                          <span class="text-danger text-sm">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>

                      <div class="vx-col md:w-1/2 w-full">

                        <div class="mt-4">
                          <ValidationProvider name="users.status" rules="required" v-slot="{ errors }">
                            <label class="vs-input--label">{{ $t('users.status') }}</label>
                            <v-select
                              label="label"
                              :reduce="data => data.value"
                              v-model="data.status"
                              :clearable="false"
                              :options="statusOptions"
                              :dir="$vs.rtl ? 'rtl' : 'ltr'"
                            />
                            <span class="text-danger text-sm">{{ errors[0] }}</span>
                          </ValidationProvider>
                        </div>

                        <div class="mt-4">
                          <ValidationProvider name="users.role" rules="required" v-slot="{ errors }">
                            <label class="vs-input--label">{{ $t('users.role') }}</label>
                            <v-select
                              label="label"
                              :reduce="data => data.value"
                              v-model="data.role"
                              :clearable="false"
                              :options="roleOptions"
                              :dir="$vs.rtl ? 'rtl' : 'ltr'"
                            />
                            <span class="text-danger text-sm">{{ errors[0] }}</span>
                          </ValidationProvider>
                        </div>

                        <ValidationProvider name="users.company" rules="alpha_spaces" v-slot="{ errors, invalid, validated }">
                          <vs-input
                            class="w-full mt-4"
                            v-model="data.company"
                            :danger="invalid && validated"
                            :label="$t('users.company')"
                          />
                          <span class="text-danger text-sm">{{ errors[0] }}</span>
                        </ValidationProvider>

                      </div>
                    </div>
                  </div>
                </div>
              </vs-tab>
              <vs-tab :label="$t('users.information')" icon-pack="feather" icon="icon-info">
                <div class="tab-text">
                  <div class="mt-4">
                    <div class="vx-row">
                      <div class="vx-col w-full md:w-1/2">

                        <!-- Col Header -->
                        <div class="flex items-end">
                          <feather-icon icon="UserIcon" class="mr-2" svgClasses="w-5 h-5" />
                          <span class="leading-none font-medium">{{ $t('users.personal_information') }}</span>
                        </div>

                        <!-- Col Content -->
                        <div>

                          <!-- DOB -->
                          <div class="mt-4">
                            <ValidationProvider name="users.birthdate" rules="required" v-slot="{ errors }">
                              <label class="text-sm">{{ $t('users.birthdate') }}</label>
                              <flat-pickr
                                class="w-full"
                                v-model="data.birthdate"
                                :config="{ dateFormat: 'd F Y', maxDate: new Date() }"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>
                          </div>

                          <ValidationProvider name="users.mobile_phone" :rules="{ regex: /^\+?([0-9 ]+)$/ }" v-slot="{ errors, invalid, validated }">
                            <vs-input
                              class="w-full mt-4"
                              v-model="data.mobile_phone"
                              :danger="invalid && validated"
                              :label="$t('users.mobile')"
                            />
                            <span class="text-danger text-sm">{{ errors[0] }}</span>
                          </ValidationProvider>

                          <ValidationProvider
                            name="users.website"
                            :rules="{ regex: /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/ }"
                            v-slot="{ errors, invalid, validated }">
                            <vs-input
                              class="w-full mt-4"
                              v-model="data.website"
                              :danger="invalid && validated"
                              :label="$t('users.website')"
                            />
                            <span class="text-danger text-sm">{{ errors[0] }}</span>
                          </ValidationProvider>

                          <div class="mt-4">
                            <ValidationProvider name="users.languages" rules="required" v-slot="{ errors }">
                              <label class="text-sm">Languages</label>
                              <v-select
                                multiple
                                label="label"
                                :reduce="data => data.value"
                                v-model="data.languages"
                                :closeOnSelect="false"
                                :options="langOptions"
                                :dir="$vs.rtl ? 'rtl' : 'ltr'"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>
                          </div>

                          <!-- Gender -->
                          <div class="mt-4">
                            <label class="text-sm">Gender</label>
                            <div class="mt-2">
                              <vs-radio v-model="data.gender" vs-value="male" class="mr-4">Male</vs-radio>
                              <vs-radio v-model="data.gender" vs-value="female" class="mr-4">Female</vs-radio>
                              <vs-radio v-model="data.gender" vs-value="other">Other</vs-radio>
                            </div>
                          </div>

                          <div class="mt-6">
                            <label>Contact Options</label>
                            <div class="flex flex-wrap mt-1">
                              <vs-checkbox v-model="data.contact_options" vs-value="email" class="mr-4 mb-2">Email</vs-checkbox>
                              <vs-checkbox v-model="data.contact_options" vs-value="message" class="mr-4 mb-2">Message</vs-checkbox>
                              <vs-checkbox v-model="data.contact_options" vs-value="phone" class=" mb-2">Phone</vs-checkbox>
                            </div>
                          </div>

                        </div>
                      </div>

                      <!-- Address Col -->
                      <div class="vx-col w-full md:w-1/2">

                          <!-- Col Header -->
                          <div class="flex items-end md:mt-0 mt-base">
                            <feather-icon icon="MapPinIcon" class="mr-2" svgClasses="w-5 h-5" />
                            <span class="leading-none font-medium">{{ $t('users.address') }}</span>
                          </div>

                          <!-- Col Content -->
                          <div>
                            <ValidationProvider name="users.address" rules="required" v-slot="{ errors, invalid, validated }">
                              <vs-input
                                class="w-full mt-4"
                                v-model="data.address"
                                :danger="invalid && validated"
                                :label="$t('users.address_line_1')"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>

                            <vs-input
                              class="w-full mt-4"
                              v-model="data.address2"
                              :label="$t('users.address_line_2')"
                            />

                            <ValidationProvider name="users.postcode" rules="required|numeric" v-slot="{ errors, invalid, validated }">
                              <vs-input
                                class="w-full mt-4"
                                v-model="data.postcode"
                                :danger="invalid && validated"
                                :label="$t('users.postcode')"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>

                            <ValidationProvider name="users.city" rules="required|alpha_spaces" v-slot="{ errors, invalid, validated }">
                              <vs-input
                                class="w-full mt-4"
                                v-model="data.city"
                                :danger="invalid && validated"
                                :label="$t('users.city')"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>

                            <ValidationProvider name="users.state" rules="required|alpha_spaces" v-slot="{ errors, invalid, validated }">
                              <vs-input
                                class="w-full mt-4"
                                v-model="data.state"
                                :danger="invalid && validated"
                                :label="$t('users.state')"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>

                            <ValidationProvider name="users.country" rules="required|alpha_spaces" v-slot="{ errors, invalid, validated }">
                              <vs-input
                                class="w-full mt-4"
                                v-model="data.country"
                                :danger="invalid && validated"
                                :label="$t('users.country')"
                              />
                              <span class="text-danger text-sm">{{ errors[0] }}</span>
                            </ValidationProvider>

                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </vs-tab>
            </vs-tabs>
            <!-- Save & Reset Button -->
            <div class="vx-row">
              <div class="vx-col w-full">
                <div class="mt-8 mb-8 flex flex-wrap items-center justify-end">
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
                </div>
              </div>
            </div>
          </div>
        </vx-card>
      </form>
    </ValidationObserver>
  </div>
</template>

<script>
import vSelect from 'vue-select'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
// Store Module
import moduleUserManagement from '@/store/user-management/moduleUserManagement.js'

export default {
  components: {
    vSelect,
    flatPickr
  },
  data () {
    return {
      data: {
        id: '',
        avatar: null,
        username: '',
        first_name: '',
        last_name: '',
        email: '',
        company: '',
        permissions: '',
        status: '',
        role: '',
        birthdate: '',
        mobile_phone: '',
        website: '',
        languages: '',
        gender: '',
        contact_options: [],
        address: '',
        address2: '',
        postcode: '',
        city: '',
        state: '',
        country: ''
      },
      data_original: {},
      user_not_found: false,
      activeTab: 0
    }
  },
  computed: {
    statusOptions () {
      return this.$store.state.userManagement.moduleData.status
    },
    roleOptions () {
      return this.$store.state.userManagement.moduleData.roles
    },
    langOptions () {
      return this.$store.state.userManagement.moduleData.langs
    },
    permissions () {
      return this.$store.state.userManagement.moduleData.permissions
    }
  },
  methods: {
    loading () {
      this.$vs.loading()
    },
    loaded () {
      this.$vs.loading.close()
    },
    back () {
      this.$router.push({ name: 'user' }).catch(() => {})
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
    },
    getModuleData () {
      this.$store.dispatch('userManagement/getModuleData')
    },
    fetch (id) {
      this.loading()
      this.not_found = false
      this.data.id = id
      this.$store.dispatch('userManagement/fetch', id)
        .then(res => {
          this.data = res.data.data
          this.data_original = Object.assign({}, this.data)
          this.loaded()
        })
        .catch(err => {
          this.loaded()
          if (err.response.status === 404) {
            this.user_not_found = true
            return
          }
          console.error(err)
        })
    },
    save () {
      this.loading()
      this.$store.dispatch('userManagement/save', this.data)
        .then(() => {
          this.loaded()
          this.showSuccess()
          this.back()
        })
        .catch((err) => {
          this.loaded()
          this.showError()
          console.error(err)
        })
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
    // Register Module UserManagement Module
    if (!moduleUserManagement.isRegistered) {
      this.$store.registerModule('userManagement', moduleUserManagement)
      moduleUserManagement.isRegistered = true
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
