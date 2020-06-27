<template>
  <table-crud
    entityName="property"
    newRoute="/property/new"
    getDataAction="propertyManagement/list"
    management="propertyManagement"
    :thead="thead"
    :listColumns="listColumns"
    @edit-record="edit"
    @delete-record="confirmDelete"
  />
</template>

<script>
import table from '@/components/crud/table'

export default {
  data () {
    return {
      id: '',
      listColumns: ['name', 'value'],
      thead: [
        {
          name: this.$t('property.name'),
          key: 'name'
        },
        {
          name: this.$t('property.value'),
          key: 'value'
        }
      ]
    }
  },
  components: {
    'table-crud': table
  },
  methods: {
    edit (id) {
      this.$router.push(`/property/${id}`).catch(() => {})
    },
    confirmDelete (id) {
      this.id = id
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: this.$t('confirm_delete'),
        text: this.$t('common.are_you_sure_you_want_to_delete', { element: 'property' }),
        accept: () => this.delete(id),
        acceptText: this.$t('delete')
      })
    },
    deleteRecord (id) {
      this.$store
        .dispatch('propertyManagement/delete', id)
        .then(() => {
          this.showDeleteSuccess()
        })
        .catch(err => {
          console.error(err)
        })
    }
  }
}
</script>
