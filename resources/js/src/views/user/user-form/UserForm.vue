<!-- =========================================================================================
  File Name: UserForm.vue
  Description: User Form Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-user-form">

    <vs-alert color="danger" title="User Not Found" :active.sync="user_not_found">
      <span>User record with id: {{ $route.params.id }} not found. </span>
      <span>
        <span>Check </span><router-link :to="{name:'page-user-list'}" class="text-inherit underline">All Users</router-link>
      </span>
    </vs-alert>

    <vx-card v-if="data">

      <div slot="no-body" class="tabs-container px-6 pt-6">

        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Account" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <div class="mt-4">
                <!-- Avatar Row -->
                <div class="vx-row">
                  <div class="vx-col w-full">
                    <div class="flex items-start flex-col sm:flex-row">
                      <img :src="data.avatar" class="mr-8 rounded h-24 w-24" />
                      <!-- <vs-avatar :src="data.avatar" size="80px" class="mr-4" /> -->
                      <div>
                        <p class="text-lg font-medium mb-2 mt-4 sm:mt-0">
                          {{ data.first_name }} {{ data.last_name }}
                        </p>
                        <input type="file" class="hidden" ref="update_avatar_input" @change="update_avatar" accept="image/*">

                        <!-- Toggle comment of below buttons as one for actual flow & currently shown is only for demo -->
                        <vs-button class="mr-4 mb-4">Change Avatar</vs-button>
                        <!-- <vs-button type="border" class="mr-4" @click="$refs.update_avatar_input.click()">Change Avatar</vs-button> -->

                        <vs-button type="border" color="danger">Remove Avatar</vs-button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Content Row -->
                <div class="vx-row">
                  <div class="vx-col md:w-1/2 w-full">
                    <vs-input class="w-full mt-4" label="Username" v-model="data.username" v-validate="'required|alpha_num'" name="username" />
                    <span class="text-danger text-sm"  v-show="errors.has('username')">{{ errors.first('username') }}</span>

                    <vs-input class="w-full mt-4" label="Name" v-model="data.first_name" v-validate="'required|alpha_spaces'" name="first_name" />
                    <span class="text-danger text-sm"  v-show="errors.has('first_name')">{{ errors.first('first_name') }}</span>

                    <vs-input class="w-full mt-4" label="Last Name" v-model="data.last_name" v-validate="'required|alpha_spaces'" name="last_name" />
                    <span class="text-danger text-sm"  v-show="errors.has('last_name')">{{ errors.first('last_name') }}</span>

                    <vs-input class="w-full mt-4" label="Email" v-model="data.email" type="email" v-validate="'required|email'" name="email" />
                    <span class="text-danger text-sm"  v-show="errors.has('email')">{{ errors.first('email') }}</span>
                  </div>

                  <div class="vx-col md:w-1/2 w-full">

                    <div class="mt-4">
                      <label class="vs-input--label">Status</label>
                      <v-select v-model="status_local" :clearable="false" :options="statusOptions" v-validate="'required'" name="status" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                      <span class="text-danger text-sm"  v-show="errors.has('status')">{{ errors.first('status') }}</span>
                    </div>

                    <div class="mt-4">
                      <label class="vs-input--label">Role</label>
                      <v-select v-model="role_local" :clearable="false" :options="roleOptions" v-validate="'required'" name="role" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                      <span class="text-danger text-sm"  v-show="errors.has('role')">{{ errors.first('role') }}</span>
                    </div>

                    <vs-input class="w-full mt-4" label="Company" v-model="data.company" v-validate="'alpha_spaces'" name="company" />
                    <span class="text-danger text-sm"  v-show="errors.has('company')">{{ errors.first('company') }}</span>

                  </div>
                </div>

                <!-- Permissions -->
                <vx-card class="mt-base" no-shadow card-border>

                  <div class="vx-row">
                    <div class="vx-col w-full">
                      <div class="flex items-end px-3">
                        <feather-icon svgClasses="w-6 h-6" icon="LockIcon" class="mr-2" />
                        <span class="font-medium text-lg leading-none">Permissions</span>
                      </div>
                      <vs-divider />
                    </div>
                  </div>

                  <div class="block overflow-x-auto">
                    <table class="w-full">
                      <tr>
                        <th class="font-semibold text-base text-left px-3 py-2" v-for="heading in ['Module', 'Read', 'Write', 'Create', 'Delete']" :key="heading">{{ heading }}</th>
                      </tr>

                      <tr v-for="(val, name) in data.permissions" :key="name">
                        <td class="px-3 py-2">{{ name }}</td>
                        <td v-for="(permission, name) in val" class="px-3 py-2" :key="name+permission">
                          <vs-checkbox v-model="val[name]" />
                        </td>
                      </tr>
                    </table>
                  </div>

                </vx-card>
              </div>
            </div>
          </vs-tab>
          <vs-tab label="Information" icon-pack="feather" icon="icon-info">
            <div class="tab-text">
              <div class="mt-4">
                <div class="vx-row">
                  <div class="vx-col w-full md:w-1/2">

                    <!-- Col Header -->
                    <div class="flex items-end">
                      <feather-icon icon="UserIcon" class="mr-2" svgClasses="w-5 h-5" />
                      <span class="leading-none font-medium">Personal Information</span>
                    </div>

                    <!-- Col Content -->
                    <div>

                      <!-- DOB -->
                      <div class="mt-4">
                        <label class="text-sm">Birth Date</label>
                        <flat-pickr v-model="data.birthdate" :config="{ dateFormat: 'd F Y', maxDate: new Date() }" class="w-full" v-validate="'required'" name="birthdate" />
                        <span class="text-danger text-sm" v-show="errors.has('birthdate')">{{ errors.first('birthdate') }}</span>
                      </div>

                      <vs-input class="w-full mt-4" label="Mobile" v-model="data.mobile_phone" v-validate="{regex: '^\\+?([0-9]+)$' }" name="mobile_phone" />
                      <span class="text-danger text-sm" v-show="errors.has('mobile_phone')">{{ errors.first('mobile_phone') }}</span>

                      <vs-input class="w-full mt-4" label="Website" v-model="data.website" v-validate="'url:require_protocol'" name="website" data-vv-as="field" />
                      <span class="text-danger text-sm" v-show="errors.has('website')">{{ errors.first('website') }}</span>

                      <div class="mt-4">
                        <label class="text-sm">Languages</label>
                        <v-select v-model="data.languages" multiple :closeOnSelect="false" :options="langOptions" v-validate="'required'" name="languages" :dir="$vs.rtl ? 'rtl' : 'ltr'" />
                        <span class="text-danger text-sm" v-show="errors.has('languages')">{{ errors.first('languages') }}</span>
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
                        <span class="leading-none font-medium">Address</span>
                      </div>

                      <!-- Col Content -->
                      <div>
                        <vs-input class="w-full mt-4" label="Address Line 1" v-model="data.address" v-validate="'required'" name="address" />
                        <span class="text-danger text-sm" v-show="errors.has('address')">{{ errors.first('address') }}</span>

                        <vs-input class="w-full mt-4" label="Address Line 2" v-model="data.address2" />

                        <vs-input class="w-full mt-4" label="Post Code" v-model="data.postcode" v-validate="'required|numeric'" name="postcode" />
                        <span class="text-danger text-sm" v-show="errors.has('postcode')">{{ errors.first('postcode') }}</span>

                        <vs-input class="w-full mt-4" label="City" v-model="data.city" v-validate="'required|alpha'" name="city" />
                        <span class="text-danger text-sm" v-show="errors.has('city')">{{ errors.first('city') }}</span>

                        <vs-input class="w-full mt-4" label="State" v-model="data.state" v-validate="'required|alpha'" name="state" />
                        <span class="text-danger text-sm" v-show="errors.has('state')">{{ errors.first('state') }}</span>

                        <vs-input class="w-full mt-4" label="Country" v-model="data.country" v-validate="'required|alpha'" name="country" />
                        <span class="text-danger text-sm" v-show="errors.has('country')">{{ errors.first('country') }}</span>

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
              <vs-button class="ml-auto mt-2" @click="save_changes" :disabled="!validateForm">Save Changes</vs-button>
              <vs-button class="ml-4 mt-2" type="border" color="warning" @click="reset_data">Reset</vs-button>
            </div>
          </div>
        </div>
      </div>

    </vx-card>
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
        contact_options: '',
        address: '',
        address2: '',
        postcode: '',
        city: '',
        state: '',
        country: ''
      },
      user_not_found: false,
      activeTab: 0,
      statusOptions: [
        { label: 'Active',  value: 'active' },
        { label: 'Blocked',  value: 'blocked' },
        { label: 'Deactivated',  value: 'deactivated' }
      ],
      roleOptions: [
        { label: 'Admin',  value: 'admin' },
        { label: 'User',  value: 'user' },
        { label: 'Staff',  value: 'staff' }
      ],
      langOptions: [
        { label: 'English',  value: 'english'  },
        { label: 'Spanish',  value: 'spanish'  },
        { label: 'French',   value: 'french'   },
        { label: 'Russian',  value: 'russian'  },
        { label: 'German',   value: 'german'   },
        { label: 'Arabic',   value: 'arabic'   },
        { label: 'Sanskrit', value: 'sanskrit' }
      ]
    }
  },
  computed: {
    status_local: {
      get () {
        return { label: this.capitalize(this.data.status),  value: this.data.status  }
      },
      set (obj) {
        this.data.status = obj.value
      }
    },
    role_local: {
      get () {
        return { label: this.capitalize(this.data.role),  value: this.data.role  }
      },
      set (obj) {
        this.data.role = obj.value
      }
    },
    validateForm () {
      return !this.errors.any()
    }
  },
  methods: {
    fetch_data (id) {
      this.data.id = id
      this.$store.dispatch('userManagement/fetchUser', id)
        .then(res => { this.data = res.data.data })
        .catch(err => {
          if (err.response.status === 404) {
            this.user_not_found = true
            return
          }
          console.error(err)
        })
    },
    capitalize (str) {
      return str ? str.slice(0, 1).toUpperCase() + str.slice(1, str.length) : ''
    },
    save_changes () {
      /* eslint-disable */
      if (!this.validateForm) return

      // Here will go your API call for updating data
      // You can get data in "this.data"

      /* eslint-enable */
    },
    reset_data () {
      for (const k in this.data) this.data[k] = ''
    },
    update_avatar () {
      // You can update avatar Here
      // For reference you can check dataList example
      // We haven't integrated it here, because data isn't saved in DB
    }
  },
  created () {
    // Register Module UserManagement Module
    if (!moduleUserManagement.isRegistered) {
      this.$store.registerModule('userManagement', moduleUserManagement)
      moduleUserManagement.isRegistered = true
    }

    if (this.$route.params.id) {
      this.fetch_data(this.$route.params.id)
    } else {
      this.reset_data()
    }
  }
}

</script>
