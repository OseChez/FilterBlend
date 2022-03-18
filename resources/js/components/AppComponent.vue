<template>
     <div class="row">
            <div class="col-lg-8">
                <div class="drag-overlay"></div>
                <div class="container__main">
                    <div class="container__main-inner">
                        <div class="header">
                            <div class="header__inner">
                                <div class="header__logo"></div>
                                <h1>Filter Blend</h1>
                                <h3>CSS blend modes and filters playground</h3>
                            </div>
                        </div>
                        <div class="preview">
                            <div class="hint">
                                <div class="hint__body sec -dimm -spacing-small js-hint">
                                    <div class="sec__heading">
                                        <div class="sec__label">Como  usar la App</div>
                                        <div class="sec__btn">ok, hagamóslo</div>
                                    </div>
                                    <div class="sec__inner">
                                        <ul>
                                            <li><i class="fa fa-hand-rock-o"></i><span>Arrastar preview area para cambiar Posición.</span></li>
                                            <li><i class="fa fa-sort"></i><span>Usa el mouse wheel  para cambiar el tamaño.</span></li>
                                            <li><i class="fa fa-crosshairs"></i><span>Click para elegir el actual background layer.</span></li>
                                        </ul>
                                    </div>                
                                </div>
                            </div>
                            <div class="preview__inner">
                              <div v-bind:style="previewStyle" class="preview__screen"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                  <div class="options__inner nano-content">
                      <div class="options__section sec">
                          <sources ref="sources" :background="setBackground"></sources>
                      </div>
                      <div class="options__section sec">
                          <picker :colore="setColor"></picker>
                      </div>
                      <div class="options__section sec">
                          <blend :blendstr="setBlendstr"></blend>
                      </div>
                      <div class="options__section sec">
                          <filters :filter="setFilter"></filters>
                      </div>
                      <div class="options__section sec -spacing-small">
                        <div class="scroll-container">
                           <outputs :css="previewStyle"></outputs>
                        </div>
                      </div>
                      <div class="options__section sec -dimm -spacing-small">
                        <div class="sec__heading">
                          <div class="sec__label">About this project</div>
                        </div>
                        <div class="sec__inner">
                          <p>FilterBlend is a playground for the new CSS <code>background-blend-mode</code> and <code>filter</code> properties.</p>
                          <p>You can find this project on <a href='https://github.com/ilyashubin/FilterBlend' target='_blank'>Github</a> or <a href='https://twitter.com/intent/tweet?text=Handy CSS blend modes and filters playground.&url=http://ilyashubin.github.io/FilterBlend/' class='share'>Tweet</a> about it.</p>
                        </div>
                      </div>
                  </div>
                </div>
            </div> 
        </div>
</template>
<script>
 
 import { helpers } from './helpers';
 import Sources from './filter-blend/Sources';
 import Blend from './filter-blend/Blend';
 import Filters from './filter-blend/Filter';
 import Picker from './filter-blend/Picker';
 import Output from './filter-blend/Output';

 /**
 * Main VM
 */

export default {
  data(){
   return { 
        backgroundStr: '',
        blendStr: '',
        css:'',
        filterStr: '',
        color: 'transparent',
    }
  },
  computed: {
    previewStyle(){
     let s = '';
          s += this.setBackground;
          s += this.setBlendstr;
          s += this.setFilter;
          s += `background-color: ${this.setColor};`;
        return s;
    },
   setBackground:{
     get(){
       return this.backgroundStr;
     },
     set(value){
       this.backgroundStr = value;
     }
   },
   setBlendstr:{
     get(){
       return this.blendStr;
     },
     set(value){
       this.blendStr = value;
     }
   },
    setColor:{
       get(){
       return this.color;
     },
     set(value){
       this.color = value;
     }
    },
    setFilter:{
     get(){
       return this.filterStr;
     },
     set(value){
       this.filterStr = value;
     }
    },
    outputStr() {
      return this.blendStr + '\n' + this.filterStr;
    }
  },

  methods: {
    handleEvents(e) {
      let methodsMap = {
        'mousedown': 'changePosition',
        'click': 'switchSelected',
        'wheel': 'changeSize',
      };

      let method = methodsMap[e.type];
      method && this.$refs.sources[method].apply(this, arguments);
    },
  
  },
  components: {
    'sources': Sources,
    'blend': Blend,
    'filters': Filters,
    'picker': Picker,
    'outputs': Output,
  },
  mounted:postBind,
  created(){
    this.$on('loadedBckgr',(b) =>{
      this.backgroundStr = b;
    });
   
    this.$on("loadedBlend",(val)=>{
      this.blendStr = val;
    });
     this.$on("loadedFilter",(val)=>{
      this.filterStr = val;
    });
    this.$on("loadedColor",(val)=>{
      this.color = val;
    });
  }
}
function postBind() {
  let $win = $(window);
  $('.preview__screen').on('mousedown click wheel', (e)=> {
    this.handleEvents(e.originalEvent);
  });

  $(document).on('focus', 'input', function() {
    setTimeout(this.select.bind(this), 50);
  });

  $win.on('mouseup', function() {
    $win.off('mousemove.fb');
     helpers.toggleDragOverlay(false);
  });
 

  /**
   * Hint popup
   */
  let isHintClosed = localStorage.getItem('isHintClosed');
  if (!isHintClosed) {
    let $hintBody = $('.js-hint').addClass('is-visible');

    $hintBody.on('click', function() {
      $hintBody.removeClass('is-visible');
      localStorage.isHintClosed = true;
    });
  }

  /**
   * Twitter share window
   */
  $('.share').click(function() {
    var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = this.href,
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;

    window.open(url, 'twitter', opts);

    return false;
  });

}
</script>
<style scoped>
  .scroll-container{
    display: block;
    width: 290px;
    height: 200px;
    overflow-x: scroll;
    overflow-y: scroll;
    scroll-behavior: smooth;
  }
</style>