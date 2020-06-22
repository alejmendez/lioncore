<template>
  <div id="page-{{ $nameModel }}-list">
    <{{ $nameModel }}-filters></{{ $nameModel }}-filters>
    <{{ $nameModel }}-data-table></{{ $nameModel }}-data-table>
  </div>
</template>

<script>
import {{ ucfirst($nameModel) }}Filters from './{{ ucfirst($nameModel) }}Filters.vue'
import {{ ucfirst($nameModel) }}DataTable from './{{ ucfirst($nameModel) }}DataTable.vue'

// Store Module
import module{{ ucfirst($nameModel) }}Management from '@/store/{{ $nameModel }}-management/module{{ ucfirst($nameModel) }}Management.js'

export default {
  components: {
    {{ ucfirst($nameModel) }}Filters,
    {{ ucfirst($nameModel) }}DataTable
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
    if (!module{{ ucfirst($nameModel) }}Management.isRegistered) {
      this.$store.registerModule('{{ $nameModel }}Management', module{{ ucfirst($nameModel) }}Management)
      module{{ ucfirst($nameModel) }}Management.isRegistered = true
    }
  }
}

</script>
