<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="h-screen flex w-full bg-img vx-row no-gutter justify-center items-center">
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-2/5 m-4">
      <vx-card>

        <div class="vx-card__title mb-6">
          <h2 class="text-center">{{ $t('comingsoon.title') }}</h2>
        </div>

        <img src="@assets/images/pages/rocket.png" alt="coming-soon" class="mx-auto mb-2" width="150">

        <div class="count-down text-center">
          <countdown :time="new Date('03/09/2021 00:00:00').getTime() - new Date().getTime()">

            <template slot-scope="props">

              <div class="single-counter">
                <span class="timer">{{ props.days }}</span>
                <span>{{ $t('comingsoon.days') }}</span>
              </div>

              <div class="single-counter">
                <span class="timer">{{ props.hours }}</span>
                <span>{{ $t('comingsoon.hours') }}</span>
              </div>

              <div class="single-counter">
                <span class="timer">{{ props.minutes }}</span>
                <span>{{ $t('comingsoon.minutes') }}</span>
              </div>

              <div class="single-counter">
                <span class="timer">{{ props.seconds }}</span>
                <span>{{ $t('comingsoon.seconds') }}</span>
              </div>

            </template>
          </countdown>
        </div>

        <vs-divider position="center">{{ $t('comingsoon.subscribe') }}</vs-divider>

        <div class="subscription">

          <span>{{ $t('comingsoon.description') }}</span>
          <vs-input type="email" :label-placeholder="$t('comingsoon.email')" v-model="value1" class="w-full mb-4" />
          <vs-button class="w-full">{{ $t('comingsoon.subscribe') }}</vs-button>

        </div>
      </vx-card>
    </div>
  </div>
</template>


<script>
import VueCountdown from '@chenfengyuan/vue-countdown'

export default {
  data () {
    return {
      value1: ''
    }
  },
  components: {
    'countdown': VueCountdown
  }
}

</script>

