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
      listColumns: ['email', 'username', 'person.first_name'],
      thead: [
        {
          name: 'Email',
          key: 'email'
        },
        {
          name: 'Username',
          key: 'username'
        },
        {
          name: 'Name',
          key: 'person.first_name'
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
        title: 'Confirm Delete',
        text: `Are you sure you want to delete the property?`,
        accept: () => this.delete(id),
        acceptText: 'Delete'
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
