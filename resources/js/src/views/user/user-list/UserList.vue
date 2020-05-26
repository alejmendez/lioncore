<template>
  <div id="page-user-list">
    <user-filters></user-filters>
    <user-data-table></user-data-table>
  </div>
</template>

<script>
import UserFilters from './UserFilters.vue'
import UserDataTable from './UserDataTable.vue'

// Store Module
import moduleUserManagement from '@/store/user-management/moduleUserManagement.js'

export default {
  components: {
    UserFilters,
    UserDataTable
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
    if (!moduleUserManagement.isRegistered) {
      this.$store.registerModule('userManagement', moduleUserManagement)
      moduleUserManagement.isRegistered = true
    }
  }
}

</script>
