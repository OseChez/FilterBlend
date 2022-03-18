<template id="filters">
  <div class="row">
    <div class="sec__heading">
          <div class="sec__label">Filters</div>
          <div @click="reset" class="sec__btn">reset</div>
        </div>
        <div class="sec__inner">
          <div class="filters">
            <div v-for="(filter,index) in filters" :key="index">
              <label v-bind:class="{ &quot;is-active&quot;: filter.enabled }" 
                     class="filters__item">
                <div class="check">
                  <input type="checkbox" v-model="filter.enabled" @change="setFilter()"/><span class="check__display"></span><span class="check__background"></span>
                </div><span class="filters__label"><span class="filters__property">{{ filter.name }}</span><span title="drag up or down to change" @mousedown="change($event, filter)" class="filters__value">{{ filter.value.current + filter.value.measure }}</span></span>
              </label>
            </div>
          </div>
        </div>
  </div>
</template>
<script>
 import { helpers, range } from '../helpers';

/**
 * Filters VM
 */

let data = {
  filters: [
    {
      name: 'saturate',
      enabled: false,
      value: {
        current: 2,
        measure: '',
        step: 0.05,
        min: 0,
        max: 100,
      },
    },
    {
      name: 'grayscale',
      enabled: false,
      value: {
        current: 0.5,
        measure: '',
        step: 0.01,
        min: 0,
        max: 1,
      },
    },
    {
      name: 'sepia',
      enabled: false,
      value: {
        current: 0.5,
        measure: '',
        step: 0.01,
        min: 0,
        max: 1,
      },
    },
    {
      name: 'brightness',
      enabled: false,
      value: {
        current: 1.5,
        measure: '',
        step: 0.03,
        min: 0,
        max: 10,
      },
    },
    {
      name: 'contrast',
      enabled: false,
      value: {
        current: 1.5,
        measure: '',
        step: 0.03,
        min: 0,
        max: 10,
      },
    },
    {
      name: 'hue-rotate',
      enabled: false,
      value: {
        current: 30,
        measure: 'deg',
        step: 1,
        min: 0,
        max: 360,
      },
    },
    {
      name: 'invert',
      enabled: false,
      value: {
        current: 1,
        measure: '',
        step: 0.01,
        min: 0,
        max: 1,
      },
    },
    {
      name: 'opacity',
      enabled: false,
      value: {
        current: 0.5,
        measure: '',
        step: 0.01,
        min: 0,
        max: 1,
      },
    },
    {
      name: 'blur',
      enabled: false,
      value: {
        current: 5.0,
        measure: 'px',
        step: 0.1,
        min: 0,
        max: 100,
      },
    },
  ],
};
export default {
  data() { return data; },
  props: {
    filter:String,
    required:true
  },

  methods: {
    change(e, item) {
      let curr = item.value.current;
      let originY = e.pageY;

      helpers.drag(function(evt) {
        item.enabled = true;

        item.value.current = Math.round((curr - (evt.pageY - originY) *
          item.value.step) * 10) / 10;

        item.value.current = range.between(item.value.current, item.value.min, item.value.max);

        if (item.value.step % 1 !== 0)
          item.value.current = item.value.current.toFixed(1);
      }, true);
    },

    reset() {
      this.filters.forEach((el)=> el.enabled = false );
    },
    setFilter(){
      this.$parent.$emit('loadedFilter', this.compileStyle());
    },
    compileStyle() {
      let s = '';
      let enabled = 0;

      for (let i = 0, len = this.filters.length; i < len; i++) {
        let curr = this.filters[i];
        if (!curr.enabled) continue;
        enabled++;
        s += `${curr.name}(${curr.value.current}${curr.value.measure}) `;
      }
      s = s.slice(0, -1);
      if (!enabled) s = 'none';
      let  css = '';
      css = `filter: ${s}; `;
      return css;
    },
  },

  watch: {
    'filters': {
      deep: true,
      handler() { this.compileStyle() },
    }
  },

  mounted() { 
    this.$parent.$emit('loadedFilter', this.compileStyle());
   },
}

</script>