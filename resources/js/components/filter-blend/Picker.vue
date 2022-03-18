<template >
   <div class="picker__body">
        <label for="pick" title="choose background color" class="picker__current transp">
          <div v-bind:style="{ &quot;background&quot;: color }" class="picker__current-inner"></div>
        </label>
        <div class="picker__input">
          <input type="text" v-model="color" class="inp-text"/>
          <label title="open color picker" class="picker__call fa fa-eyedropper">
            <input id="pick" type="color" v-model="color" class="inp-color" @change="addStyle()"/>
          </label>
        </div>
        <div class="picker__variants">
          <div v-for="(preset,index) in presets" 
               v-bind:style="{ &quot;background&quot;: preset == &quot;transparent&quot; ? &quot;&quot; : preset }" 
               @click="color = preset" class="picker__variants-item transp" :key="index">
          </div>
        </div>
    </div>
</template>
<script>
/**
 * Picker VM
 */

let data = {
  presets: ['#fff', '#2b2a2f', '#e45353', '#58cb6b', 'transparent'],
  color:'yellowgreen'
};
export default {
  props:["colore"],
   data() { return data; },
   methods: {
     addStyle(){
       this.$parent.$emit('loadedColor',this.color);
     }
   }
}
</script>
