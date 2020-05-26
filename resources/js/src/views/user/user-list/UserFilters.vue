<template>
  <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8" actionButtons @refresh="resetColFilters" @remove="resetColFilters">
    <div class="vx-row">
      <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
        <label class="text-sm opacity-75">Role</label>
        <v-select :options="roleOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="roleFilter" class="mb-4 md:mb-0" />
      </div>
      <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
        <label class="text-sm opacity-75">Status</label>
        <v-select :options="statusOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="statusFilter" class="mb-4 md:mb-0" />
      </div>
      <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
        <label class="text-sm opacity-75">Verified</label>
        <v-select :options="isVerifiedOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="isVerifiedFilter" class="mb-4 sm:mb-0" />
      </div>
      <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
        <label class="text-sm opacity-75">Department</label>
        <v-select :options="departmentOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="departmentFilter" />
      </div>
    </div>
  </vx-card>
</template>

<script>
import vSelect from 'vue-select'

export default {
  components: {
    vSelect
  },
  data () {
    return {

      // Filter Options
      roleFilter: { label: 'All', value: 'all' },
      roleOptions: [
        { label: 'All', value: 'all' },
        { label: 'Admin', value: 'admin' },
        { label: 'User', value: 'user' },
        { label: 'Staff', value: 'staff' }
      ],

      statusFilter: { label: 'All', value: 'all' },
      statusOptions: [
        { label: 'All', value: 'all' },
        { label: 'Active', value: 'active' },
        { label: 'Deactivated', value: 'deactivated' },
        { label: 'Blocked', value: 'blocked' }
      ],

      isVerifiedFilter: { label: 'All', value: 'all' },
      isVerifiedOptions: [
        { label: 'All', value: 'all' },
        { label: 'Yes', value: 'yes' },
        { label: 'No', value: 'no' }
      ],

      departmentFilter: { label: 'All', value: 'all' },
      departmentOptions: [
        { label: 'All', value: 'all' },
        { label: 'Sales', value: 'sales' },
        { label: 'Development', value: 'development' },
        { label: 'Management', value: 'management' }
      ]
    }
  },
  watch: {
    roleFilter (obj) {
      this.setColumnFilter('role', obj.value)
    },
    statusFilter (obj) {
      this.setColumnFilter('status', obj.value)
    },
    isVerifiedFilter (obj) {
      const val = obj.value === 'all' ? 'all' : obj.value === 'yes' ? 'true' : 'false'
      this.setColumnFilter('is_verified', val)
    },
    departmentFilter (obj) {
      this.setColumnFilter('department', obj.value)
    }
  },
  computed: {
    getFiltersValues () {
      return this.$store.state.userManagement.users
    },
    totalItems () {
      return this.$store.state.userManagement.recordsTotal
    }
  },
  methods: {
    setColumnFilter (column, val) {
      console.log(column, val)
    },
    resetColFilters () {
      // Reset Filter Options
      this.roleFilter = this.statusFilter = this.isVerifiedFilter = this.departmentFilter = { label: 'All', value: 'all' }

      this.$refs.filterCard.removeRefreshAnimation()
    }
  },
  mounted () {

  },
  created () {
    this.$store.dispatch('userManagement/getFiltersValues').catch(err => { console.error(err) })
  }
}

</script>

<style lang="scss" scoped>
.user-list-filters {
  .vs__actions {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-58%);
  }
}
</style>
