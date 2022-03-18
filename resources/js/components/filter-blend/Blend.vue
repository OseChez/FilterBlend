<template id="blend">
 <aside class="single_sidebar_widget post_category_widget">
   <div class="sec__heading">
          <div class="sec__label">Blend-mode</div>
          <div @click="reset" class="sec__btn">reset</div>
        </div>
        <div class="sec__inner">
          <div class="blend">
            <div v-for="(value,index) in values" @click="addStyle(index)"
                 v-bind:class="{ &quot;is-active&quot;: current == index }" 
                 class="blend__item" :key="index">{{ value }}</div>
          </div>
        </div> 
  </aside>
</template>
<script>
/**
 * Blend Mode VM
 */

let data = {
  blend_mode:"",
  current: 6,
  values: [
    'normal', 'multiply', 'screen', 'overlay', 'darken', 'lighten',
    'color-dodge', 'color-burn', 'hard-light', 'soft-light', 'difference',
    'exclusion', 'hue', 'saturation', 'color', 'luminosity'
  ],
};
export default {
  data() { return data; },
  props: ['blendstr'],
  methods: {
    reset() {
      this.current = 0;
    },
    addStyle(index){
     this.current = index;
     this.$parent.$emit("loadedBlend",this.compileStyle());
    },
    compileStyle() {
      this.blend_mode = `background-blend-mode: ${this.values[this.current]}; `;
      return this.blend_mode;
    },
  },
  computed:{
    changeCurrent:{
      get(){
        return this.current;
      },
      set(val){
        this.current =val;
      }
    }
  },
  watch: {
    'current'() { this.compileStyle() }
  },

  mounted() { 
      this.$parent.$emit("loadedBlend",this.compileStyle());
  },
}
</script>