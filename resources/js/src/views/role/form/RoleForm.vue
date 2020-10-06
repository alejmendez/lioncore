<template>
  <div id="page-role-form">
    <vs-alert color="danger" title="Role Not Found" :active.sync="not_found">
      <span>Role record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check </span><router-link :to="{name:'page-role-list'}" class="text-inherit underline">All Roles</router-link>
      </span>
    </vs-alert>
    <ValidationObserver v-slot="{ handleSubmit, reset, invalid }">
      <form @submit.prevent="handleSubmit(save)">
        <vx-card>
          <vs-row>
            <vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="role.name" rules="alpha_spaces|min:3|max:80" v-slot="{ errors, invalid, validated }">
                <vs-input
                  class="w-full mt-4"
                  v-model="data.name"
                  :danger="invalid && validated"
                  :label="$t('role.name')"
                />
                <span class="text-danger text-sm">{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
          </vs-row>
          <vs-row class="mt-8">
            <h2>Permisos</h2>
          </vs-row>
          <vs-row class="mt-8" vs-justify="center">
            <vs-col
              type="flex"
              vs-justify="center"
              vs-align="center"
              vs-w="12"
              v-for="(permissionsGroup, moduleName) in permissionsList"
              :key="moduleName"
            >
              <vs-card>
                <div slot="header">
                  <h3 class="cursor-pointer">
                    <vs-button
                      class="float-left mr-3"
                      color="primary"
                      type="filled"
                      size="small"
                      icon="check"
                      @click="checkGroup(permissionsGroup)"
                    >
                    </vs-button>
                    <vs-button
                      class="float-left mr-3"
                      color="danger"
                      type="filled"
                      size="small"
                      icon="cancel"
                      @click="removeGroup(permissionsGroup)"
                    >
                    </vs-button>
                    {{ moduleName }}
                  </h3>
                </div>
                <div>
                  <ul class="centerx">
                    <li
                      class="mb-2"
                      v-for="permission in permissionsGroup"
                      :key="permission.id"
                    >
                      <vs-checkbox
                        v-model="permissions"
                        :vs-value="permission.id"
                      >
                        {{ permission.displayName }}
                      </vs-checkbox>
                    </li>
                  </ul>
                </div>
              </vs-card>
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
import moduleRoleManagement from '@/store/role/moduleRoleManagement.js'

export default {
  data () {
    return {
      data: {
        id: '',
        name: '',
        permissions: []
      },
      permissions: [],
      data_original: {},
      not_found: false
    }
  },
  computed: {
    permissionsList () {
      return this.$store.state.roleManagement.moduleData.permissions
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
      this.$store.dispatch('roleManagement/getModuleData')
    },
    fetch (id) {
      this.loading()
      this.not_found = false
      this.data.id = id
      this.$store.dispatch('roleManagement/fetch', id)
        .then(res => {
          this.loaded()
          this.data = res.data.data
          this.data.permissions.map((permission) => {
            this.permissions.push(permission)
          })
          this.data.permissions = []
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
      this.data.permissions = this.permissions
      this.$store
        .dispatch('roleManagement/save', this.data)
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
      this.$router.push({ name: 'role' }).catch(() => {})
    },
    reset () {
      this.data = Object.assign({}, this.data_original)
      this.permissions = []
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
    checkGroup (permissionsGroup) {
      permissionsGroup.map((permission) => {
        if (!this.permissions.includes(permission)) {
          this.permissions.push(permission.id)
        }
      })
    },
    removeGroup (permissionsGroup) {
      permissionsGroup.map((permission) => {
        for (let i = 0; i < this.permissions.length; i++) {
          if (this.permissions[i] === permission.id) {
            this.permissions.splice(i, 1)
          }
        }
      })
    }
  },
  created () {
    if (!moduleRoleManagement.isRegistered) {
      this.$store.registerModule('roleManagement', moduleRoleManagement)
      moduleRoleManagement.isRegistered = true
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
