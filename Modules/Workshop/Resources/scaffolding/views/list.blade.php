<template>
  <v-card>
    <v-card-title primary-title class="grey lighten-4">
      <h3 class="headline mb-0">@{{ $t('<?php echo strtolower(str_plural($nameModel)); ?>') }}</h3>

      <v-btn slot="activator" color="primary" right dark class="mb-2" :to="{ name: '<?php echo strtolower(str_plural($nameModel)); ?>' }">@{{ $t('new_<?php echo strtolower(str_plural($nameModel)); ?>') }}</v-btn>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      <v-data-table
        :headers="headers"
        :items="{{ strtolower(str_plural($nameModel)) }}"
        :pagination.sync="pagination"
        :total-items="total"
        :loading="loading"
        class="elevation-1">
        <template slot="items" slot-scope="props">
          @foreach ($jsonContent as $ele)
            <td>@{{ props.item.<?php echo $ele['name']; ?> }}</td>
          @endforeach
          <td class="justify-center layout px-0">
            <v-icon
              small
              class="mr-2"
              @click="editItem(props.item)">
              edit
            </v-icon>
            <v-icon
              small
              @click="deleteItem(props.item)">
              delete
            </v-icon>
          </td>
        </template>
        <template slot="no-data">
          @{{ $t('no_data') }}
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios'
import router from '~/router'

export default {
  name: '{{ strtolower(str_plural($nameModel)) }}-list-view',
  metaInfo () {
    return { title: this.$t('{{ strtolower(str_plural($nameModel)) }}') }
  },
  data () {
    return {
      total: 0,
      {{ strtolower(str_plural($nameModel)) }}: [],
      loading: true,
      pagination: {},
      headers: [
        { text: this.$t('user.name'),    value: 'name' },
        { text: this.$t('user.profile'), value: 'profile' },
        { text: this.$t('user.email'),   value: 'email' },
        { text: this.$t('actions'),      value: 'name', sortable: false }
      ]
    }
  },
  watch: {
    pagination: {
      handler () {
        this.getDataFromApi()
      },
      deep: true
    }
  },
  mounted () {
    this.getDataFromApi()
  },
  methods: {
    editItem (user) {
      router.push({
        name: '{{ strtolower(str_plural($nameModel)) }}',
        params: {
          id: user.id
        }
      })
    },
    deleteItem (user) {
      console.log('click eliminar');
    },
    initialize () {
      console.log('click initialize');
    },
    getDataFromApi () {
      this.loading = true
      const { sortBy, descending, page, rowsPerPage } = $this.pagination

      return axios.get('/api/v1/{{ strtolower(str_plural($nameModel)) }}', {
          params: {
            sortBy,
            descending,
            page,
            rowsPerPage
          }
        })
        .then(response => {
          let data = response.data

          this.{{ strtolower(str_plural($nameModel)) }} = data.data
          this.total = data.paginator.total
          this.loading = false
        })
        .catch(thrown => {
          this.loading = false
          if (axios.isCancel(thrown)) {
            console.log('Request canceled', thrown.message);
          } else {
            // handle error
          }
        });
    }
  }
}
</script>
