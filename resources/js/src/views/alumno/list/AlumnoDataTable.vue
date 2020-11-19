<template>
  <table-crud
    newRoute="/alumno/new"
    getDataAction="alumnoManagement/list"
    management="alumnoManagement"
    ref="table"
    :entityName="$t('alumno.title.view')"
    :thead="thead"
    :listColumns="listColumns"
  >
    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td style="width:16 %">{{ tr.firstName  }}</vs-td>
          <vs-td style="width:16 %">{{ tr.lastname  }}</vs-td>
          <vs-td style="width:16 %">{{ tr.phone  }}</vs-td>
          <vs-td style="width:16 %">{{ tr.email  }}</vs-td>
          <vs-td style="width:16 %">{{ tr.specialty  }}</vs-td>
          <vs-td style="width:16 %">{{ tr.semester  }}</vs-td>
          <vs-td class="whitespace-no-wrap" style="width:90px">
            <feather-icon
              icon="EditIcon"
              svgClasses="w-5 h-5 hover:text-primary stroke-current"
              @click.stop="edit(tr.id)"
            />
            <feather-icon
              icon="TrashIcon"
              svgClasses="w-5 h-5 hover:text-danger stroke-current"
              class="ml-2"
              @click.stop="confirmDelete(tr.id)"
            />
          </vs-td>
        </vs-tr>
      </tbody>
    </template>
  </table-crud>
</template>

<script>
import table from '@/components/crud/table'

export default {
  data () {
    return {
      id: '',
      listColumns: ['firstName', 'lastname', 'phone', 'email', 'specialty', 'semester'],
      thead: [
        {
          name: this.$t('alumno.firstName'),
          key: 'firstName'
        },
        {
          name: this.$t('alumno.lastname'),
          key: 'lastname'
        },
        {
          name: this.$t('alumno.phone'),
          key: 'phone'
        },
        {
          name: this.$t('alumno.email'),
          key: 'email'
        },
        {
          name: this.$t('alumno.specialty'),
          key: 'specialty'
        },
        {
          name: this.$t('alumno.semester'),
          key: 'semester'
        }
      ]
    }
  },
  components: {
    'table-crud': table
  },
  methods: {
    getData () {
      this.$refs.table.getData()
    },
    loading () {
      this.$vs.loading()
    },
    loaded () {
      this.$vs.loading.close()
    },
    edit (id) {
      this.$router.push({ name: 'alumno-edit', params: { id } }).catch(() => {})
    },
    confirmDelete (id) {
      this.id = id
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: this.$t('common.confirm_delete'),
        text: this.$t('common.are_you_sure_you_want_to_delete', { entityName: this.$t('alumno.title.view') }),
        accept: () => this.delete(id),
        acceptText: this.$t('common.delete')
      })
    },
    delete (id) {
      this.loading()
      this.$store
        .dispatch('alumnoManagement/delete', id)
        .then(() => {
          this.showDeleteSuccess()
        })
        .catch(err => {
          this.showDeleteError()
          console.error(err)
        })
    },
    showDeleteSuccess () {
      this.getData()
      this.$vs.notify({
        color: 'success',
        title: this.$t('common.record_deleted'),
        text: this.$t('common.the_selected_entityname_was_successfully_deleted', { entityName: this.$t('alumno.title.view') })
      })
    },
    showDeleteError () {
      this.getData()
      this.$vs.notify({
        color: 'danger',
        title: this.$t('common.record_deleted'),
        text: this.$t('common.an_error_was_generated_while_trying_to_delete_the_record')
      })
    }
  }
}
</script>
