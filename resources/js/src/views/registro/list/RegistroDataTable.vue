<template>
  <table-crud
    newRoute="/registro/new"
    getDataAction="registroManagement/list"
    management="registroManagement"
    ref="table"
    :entityName="$t('registro.title.view')"
    :thead="thead"
    :listColumns="listColumns"
  >
    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td style="width:14 %">{{ tr.firstName }} {{ tr.lastname }}</vs-td>
          <vs-td style="width:14 %">{{ tr.semester }}</vs-td>
          <vs-td style="width:14 %">
            <vs-chip :color="tr.consultancies == 0 ? 'danger' : 'success'">
              {{ tr.consultancies == 0 ? 'No' : 'Si' }}
            </vs-chip>
          </vs-td>
          <vs-td style="width:14 %">
            <vs-chip :color="tr.documentation == 0 ? 'danger' : 'success'">
              {{ tr.documentation == 0 ? 'No' : 'Si' }}
            </vs-chip>
          </vs-td>
          <vs-td style="width:14 %">
            <vs-chip :color="tr.assignedDate == 0 ? 'danger' : 'success'">
              {{ tr.assignedDate == 0 ? 'No' : 'Si' }}
            </vs-chip>
          </vs-td>
          <vs-td style="width:14 %">
            <vs-chip :color="tr.presentation == 0 ? 'danger' : 'success'">
              {{ tr.presentation == 0 ? 'No' : 'Si' }}
            </vs-chip>
          </vs-td>
          <vs-td style="width:14 %">
            <vs-chip :color="tr.finalTome == 0 ? 'danger' : 'success'">
              {{ tr.finalTome == 0 ? 'No' : 'Si' }}
            </vs-chip>
          </vs-td>
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
      listColumns: ['alumno.firstname', 'alumno.semester', 'consultancies', 'documentation', 'assignedDate', 'presentation', 'finalTome'],
      thead: [
        {
          name: this.$t('alumno.firstName'),
          key: 'firstname'
        },
        {
          name: this.$t('alumno.semester'),
          key: 'semester'
        },
        {
          name: this.$t('registro.consultancies'),
          key: 'consultancies'
        },
        {
          name: this.$t('registro.documentation'),
          key: 'documentation'
        },
        {
          name: this.$t('registro.assignedDate'),
          key: 'assignedDate'
        },
        {
          name: this.$t('registro.presentation'),
          key: 'presentation'
        },
        {
          name: this.$t('registro.finalTome'),
          key: 'finalTome'
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
      this.$router.push({ name: 'registro-edit', params: { id } }).catch(() => {})
    },
    confirmDelete (id) {
      this.id = id
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: this.$t('common.confirm_delete'),
        text: this.$t('common.are_you_sure_you_want_to_delete', { entityName: this.$t('registro.title.view') }),
        accept: () => this.delete(id),
        acceptText: this.$t('common.delete')
      })
    },
    delete (id) {
      this.loading()
      this.$store
        .dispatch('registroManagement/delete', id)
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
        text: this.$t('common.the_selected_entityname_was_successfully_deleted', { entityName: this.$t('registro.title.view') })
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
