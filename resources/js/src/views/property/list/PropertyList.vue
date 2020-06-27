<template>
  <div id="page-property-list">
    <property-filters></property-filters>
    <property-data-table></property-data-table>
  </div>
</template>

<script>
import PropertyFilters from './PropertyFilters.vue'
import PropertyDataTable from './PropertyDataTable.vue'

// Store Module
import modulePropertyManagement from '@/store/property/modulePropertyManagement.js'

export default {
  components: {
    PropertyFilters,
    PropertyDataTable
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
    if (!modulePropertyManagement.isRegistered) {
      this.$store.registerModule('propertyManagement', modulePropertyManagement)
      modulePropertyManagement.isRegistered = true
    }
  }
}

</script>
