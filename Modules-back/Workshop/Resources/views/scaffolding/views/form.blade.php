<template>
  <v-card>
    <v-card-title primary-title class="grey lighten-4">
      <h3 class="headline mb-0">@{{ title }}</h3>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-text>
      @foreach ($this->json as $ele)
<{{ $ele['htmlType'] }}-input
        :form="form"
        :label="$t('{{ $ele['label'] }}')"
        :v-errors="errors"
        :value.sync="form.{{ $ele['name'] }}"
        counter="50"
        name="{{ $ele['name'] }}"
        v-validate="'{{ str_replace(',', '|', $ele['validations']) }}'">
      </{{ $ele['htmlType'] }}-input>
      @endforeach
    </v-card-text>
    <v-btn
      :loading="busy"
      :disabled="busy"
      color="primary"
      @click="save">
      @{{ $t('save') }}
      <v-icon right dark>save</v-icon>
    </v-btn>
    <v-btn
      color="blue-grey"
      class="white--text"
      :disabled="busy"
      @click="cancel">
      @{{ $t('cancel') }}
      <v-icon right dark>cancel</v-icon>
    </v-btn>
  </v-card>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import router from '~/router'

export default {
  name: '{{ strtolower(Illuminate\Support\Str::plural($nameModel)) }}-form-view',
  data: () => ({
    form: new Form({
      @foreach ($this->json as $ele)
      {{ $ele['name'] }}: '',
      @endforeach
    }),
    roles: [],
    busy: false,
    title: '',
    eye: true
  }),
  metaInfo () {
    return { title: this.$t('{{ $title }}') }
  },
  mounted () {
    let id = this.$route.params.id
    this.form.id = id || ''
    this.title = id ? this.$t('{{ $nameModel }}._singular') : this.$t('new_{{ $nameModel }}')
    this.getDataFromApi(id)
  },
  methods: {
    cancel () {
      router.push({ name: '{{ strtolower(Illuminate\Support\Str::plural($nameModel)) }}' })
    },
    getDataFromApi (id) {
      if (!id) {
        return
      }

      return axios.get(`/api/v1/{{ strtolower(Illuminate\Support\Str::plural($nameModel)) }}/${id}`)
        .then(response => {
          let data = response.data.data

          this.form.fill(data)
        })
    },
    save () {
      let form = this.form
      let url = `/api/v1/{{ strtolower(Illuminate\Support\Str::plural($nameModel)) }}/${form.id}`
      let promise = form.id ? form.put(url) : form.post(url)

      this.$emit('busy', true)

      return promise.then(response => {
          this.$emit('busy', false)
          router.push({
            name: '{{ strtolower(Illuminate\Support\Str::plural($nameModel)) }}'
          })
        })
        .catch(() => {
          this.$emit('busy', false)
        })
    }
  }
}
</script>
