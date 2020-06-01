<template>
  <table-crud
    entityName="user"
    newRoute="/user/new"
    editRoute="/user"
    getDataAction="userManagement/list"
    deleteAction="userManagement/removeRecord"
    management="userManagement"
    :listColumns="['email', 'username', 'person.first_name']"
    />
</template>

<script>
import table from '@/components/crud/table'

export default {
  data () {
    return {
    }
  },
  components: {
    'table-crud': table
  }
}
</script>
