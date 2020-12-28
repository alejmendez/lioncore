<template>
  <vx-card ref="filterCard" title="Filters" class="user-list-filters mb-8" actionButtons @refresh="resetColFilters" @remove="resetColFilters">
    <div class="vx-row">
      <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
        <label class="text-sm opacity-75">{{ $t('users.role') }}</label>
        <v-select
          v-model="roleFilter"
          class="mb-4 md:mb-0"
          label="label"
          :reduce="data => data.value"
          :options="rolesOptions"
          :clearable="false"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
        />
      </div>
      <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
        <label class="text-sm opacity-75">{{ $t('users.status') }}</label>
        <v-select
          class="mb-4 md:mb-0"
          v-model="statusFilter"
          label="label"
          :reduce="data => data.value"
          :options="statusOptions"
          :clearable="false"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
        />
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
      roleFilter: { label: this.$t('common.all'), value: '' },
      statusFilter: { label: this.$t('common.all'), value: '' }
    }
  },
  watch: {
    roleFilter (obj) {
      this.setColumnFilter('role', obj.value)
    },
    statusFilter (obj) {
      this.setColumnFilter('status', obj.value)
    }
  },
  computed: {
    getFiltersValues () {
      return this.$store.state.userManagement.users
    },
    totalItems () {
      return this.$store.state.userManagement.recordsTotal
    },
    rolesOptions () {
      return this.$store.state.userManagement.filtersValues.rolesOptions
    },
    statusOptions () {
      return this.$store.state.userManagement.filtersValues.statusOptions
    }
  },
  methods: {
    setColumnFilter (column, val) {
      console.log(column, val)
    },
    resetColFilters () {
      // Reset Filter Options
      this.roleFilter = this.statusFilter = { label: this.$t('common.all'), value: '' }
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
