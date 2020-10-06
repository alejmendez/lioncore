<template>
  <div id="page-role-list">
    <role-data-table></role-data-table>
  </div>
</template>

<script>
import RoleFilters from './RoleFilters.vue'
import RoleDataTable from './RoleDataTable.vue'

// Store Module
import moduleRoleManagement from '@/store/role/moduleRoleManagement.js'

export default {
  components: {
    RoleFilters,
    RoleDataTable
  },
  data () {
    return {
    }
  },
  methods: {

  },
  mounted () {

  },
  created () {
    if (!moduleRoleManagement.isRegistered) {
      this.$store.registerModule('roleManagement', moduleRoleManagement)
      moduleRoleManagement.isRegistered = true
    }
  }
}

</script>
