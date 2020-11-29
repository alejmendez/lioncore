<template>
  <div id="page-grafica-list">
    <vx-card class="pb-5">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-row>
          <vs-col class="px-2" vs-w="12">
            <label class="vs-input--label">Indicador</label>
            <v-select
              label="label"
              v-model="indicador"
              :reduce="data => data.value"
              :clearable="false"
              :options="indicadores"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
              input="graficar"
            />
          </vs-col>

          <vs-col class="px-2 mt-3" vs-w="12">
            <label class="vs-input--label">Agrupar por</label>
            <v-select
              label="label"
              v-model="grupo"
              :reduce="data => data.value"
              :clearable="false"
              :options="grupos"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
              input="graficar"
            />
          </vs-col>
          <vs-col class="px-2 mt-3" vs-w="12">
            <vs-button
              class="ml-auto mt-2 float-right vs-con-loading__container"
              icon="show_chart"
              @click="graficar"
            >
              Generar Grafico
            </vs-button>
          </vs-col>
        </vs-row>
      </div>
    </vx-card>

    <vx-card class="mt-3" v-show="iteraciones > 0">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <e-charts autoresize :options="pie" ref="pie" auto-resize />
      </div>
    </vx-card>

  </div>
</template>

<script>
import moduleGraficaManagement from '@/store/grafica/moduleGraficaManagement.js'

import vSelect from 'vue-select'
import ECharts from 'vue-echarts/components/ECharts'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/legend'
import 'echarts/lib/chart/pie'

export default {
  components: {
    vSelect,
    ECharts
  },
  data () {
    return {
      grupo: 'semester',
      grupos: [
        {
          value: 'semester',
          label: 'Semestre'
        },
        {
          value: 'specialty',
          label: 'Especialidad'
        }
      ],
      indicador: 'aprobados_por_semestre',
      indicadores: [
        {
          value: 'aprobados_por_semestre',
          label: 'Porcentaje de alumnos Aprobados por Semestre'
        },
        {
          value: 'sin_tutor_académico_asignado',
          label: 'Porcentaje de alumnos sin tutor académico asignado'
        },
        {
          value: 'inasistentes_a_asesorías_académicas',
          label: 'Porcentaje de alumnos inasistentes a asesorías académicas'
        },
        {
          value: 'sin_completar_requisitos_académicos',
          label: 'Porcentaje de alumnos sin completar requisitos académicos'
        },
        {
          value: 'inasistentes_a_presentación_de_teg',
          label: 'Porcentaje de alumnos inasistentes a presentación de TEG'
        },
        {
          value: 'sin_entrega_de_tomo_final_de_teg',
          label: 'Porcentaje de alumnos sin entrega de tomo final de TEG'
        }
      ],
      iteraciones: 0,
      pie: {
        tooltip: {
          trigger: 'item',
          formatter: '{b} : {c} ({d}%)'
        },
        legend: {
          orient: 'vertical',
          left: 'left',
          data: ['Sistemas', 'Informática', 'Mantenimiento', 'Ambiental']
        },
        series: [
          {
            name: '',
            type: 'pie',
            radius: '55%',
            center: ['50%', '60%'],
            color: ['#FF9F43', '#28C76F', '#EA5455', '#87ceeb', '#7367F0'],
            label: {
              formatter: '{b}: {c} ({d}%)'
            },
            data: [
              { value: 335, name: 'Sistemas' },
              { value: 310, name: 'Informática' },
              { value: 234, name: 'Mantenimiento' },
              { value: 135, name: 'Ambiental' }
            ],
            itemStyle: {
              emphasis: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
              }
            }
          }
        ]
      }
    }
  },
  methods: {
    loading () {
      this.$vs.loading()
    },
    loaded () {
      this.$vs.loading.close()
    },
    graficar () {
      this.loading()
      const data = {
        grupo: this.grupo,
        indicador: this.indicador
      }
      this.$store.dispatch('graficaManagement/fetch', data)
        .then(res => {
          this.iteraciones++

          this.pie.legend.data = res.data.data.legend
          this.pie.series[0].data = res.data.data.data
          this.loaded()
        })
        .catch(err => {
          this.loaded()
          if (err.response.status === 404) {
            this.user_not_found = true
            return
          }
          console.error(err)
        })
    }
  },
  mounted () {
    this.graficar()
  },
  created () {
    if (!moduleGraficaManagement.isRegistered) {
      this.$store.registerModule('graficaManagement', moduleGraficaManagement)
      moduleGraficaManagement.isRegistered = true
    }
  }
}

</script>
