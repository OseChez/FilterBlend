<template id="sources">
    <aside class="single_sidebar_widget post_category_widget">
            <div class="sec__heading">
                <div class="sec__label">Backgrounds</div>
                <div @click="addNew" class="sec__btn">add new</div>
            </div>
            <div class="sec__inner">
              <div class="source">
                <div v-for="(item,index) in items" 
                     v-bind:class="{ &quot;is-selected&quot;: current == index, &quot;is-hidden&quot;: item.hidden }" 
                     class="source__item" :key="index">
                    <div class="source__top">
                      <div title="drag to reorder" class="source__drag-handler fa fa-bars"></div>
                      <div title="switch active background" @click="switchSelected(index)" class="source__selected fa fa-file-image-o"></div>
                        <div class="source__input">
                            <label class="source__input-area">
                                <input type="text" v-bind:value="item.fakeUrl" placeholder="enter background url" 
                                       @keyup="processImageURL($event, item)"/>
                            </label>
                            <div class="source__buttons">
                                <label title="choose local file" class="source__buttons-item -upload"><i class="fa fa-upload"></i>
                                    <input type="file" @change="processImageURL($event, item)"/>
                                </label>
                                <div title="hide" v-bind:class="{ &quot;is-hidden&quot;: items.length &lt; 2 }" 
                                    @click="hide(index)" class="source__buttons-item -hide"><i class="fa fa-eye-slash"></i>
                                </div>
                                <div title="remove" v-bind:class="{ &quot;is-hidden&quot;: items.length &lt; 2 }" 
                                     @click="remove(index)" class="source__buttons-item"><i class="fa fa-trash-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="source__bottom">
                        <div class="source__controls">
                            <div title="Background repeat" v-bind:class="{ &quot;is-active&quot;: item.repeat == &quot;repeat&quot; }" 
                                @click="changeRepeat(item)" class="source__controls-item -repeat">repeat</div>
                            <div title="Background position" v-bind:class="{ &quot;is-active&quot;: item.isCenter }" 
                                @click="changePosition($event, item)" class="source__controls-item -position">center</div>
                            <div title="Background size" v-bind:class="{ &quot;is-active&quot;: item.size == &quot;auto&quot; }" 
                                @click="changeSize($event, item)" class="source__controls-item -size">auto</div>
                        </div>
                    </div>
                 </div>
              </div>
            </div>
        </aside>
</template>
<script>
import { helpers, travelArray, range, loadImage } from '../helpers';

/**
 * Sources VM
 */

let data = {
  current: 0,
  image: undefined,
  viewport: {
    width: 0,
    height: 0,
  },
  items: [
    {
      fakeUrl: '/img/ron_banio.jpg',
      x: 50,
      y: 50,
      repeat: 'no-repeat',
      isCenter: true,
      size: 540,
      hidden: false,
      isPreset: true,
      img: {
        url: '/img/ron_banio.jpg',
        width: 350,
        height: 300,
        aspectRatio: 1,
      },
    },
    {
      fakeUrl: '/img/moon.jpeg',
      x: 50,
      y: 50,
      repeat: 'no-repeat',
      isCenter: true,
      size: 1665,
      hidden: false,
      isPreset: true,
      img: {
        url: '/img/moon.jpeg',
        width: 790,
        height: 700,
        aspectRatio: 1,
      },
    },
  ],
};
export default {
  props :['background'],
  data() { return data; },//
  name: 'sources',
  methods: {

    /**
     * Switch current background to control--
     */
    switchSelected(index) {

      if (typeof index == 'number') {
        this.current = index;
        return;
      }

      let nextInd = travelArray(this.items, this.current);

      if (this.items[nextInd].hidden)
        nextInd = travelArray(this.items, nextInd)

      this.current = nextInd;
      this.$parent.$emit('loadesBckgr',this.compileStyle());
    },

    changeRepeat(item) {
      item.repeat = (item.repeat == 'repeat') ? 'no-repeat' : 'repeat';
      this.$parent.$emit('loadedBckgr',this.compileStyle());
    },

    changePosition(e, item) {
      item = item || this.items[this.current];
      let self = this;
      if (e.type == 'click') {
        item.isCenter = true;
        this.centerImage(item);
        this.$parent.$emit('loadedBckgr',this.compileStyle());
        return;
      }

      let incX = item.x;
      let incY = item.y;
      let originX = e.pageX;
      let originY = e.pageY;

      helpers.drag((evt)=> {
        item.isCenter = false;
        item.x = incX + (evt.pageX - originX);
        item.y = incY + (evt.pageY - originY);
        this.$parent.$emit('loadedBckgr',self.compileStyle());
      });
    },

    changeSize(e, item = null) {

      if (e.type == 'click') {

        let difference = item.img.width - item.size;
        item.size = 'auto';
        item.x -= difference / 2;
        item.y -= difference / item.img.aspectRatio / 2;
        this.$parent.$emit('loadedBckgr',self.compileStyle());
      } else if (e.type == 'wheel') {

        item = this.items[this.current];
        const MIN_SIZE = 3;

        // set starting point
        let curr = item.size == 'auto' ? item.img.width : item.size;

        // adjust zoom speed
        let incrementStep = curr < this.viewport.width ? 18 : 8;

        let increment = this.viewport.width / incrementStep;
        increment *= (e.deltaY < 0) ? 1 : -1;

        if (curr + increment >= MIN_SIZE) {
          item.size = curr + increment;

          // zoom starting point is center,
          // so also adjusting coordinates
          item.x -= increment / 2;
          item.y -= increment / item.img.aspectRatio / 2;
        }

      }

      if (item.isCenter) this.centerImage(item);

    },

    hide(index) {
      let item = this.items[index];
      if (item.hidden) {
        this.items[index].hidden = false;
        this.$parent.$emit('loadedBckgr',this.compileStyle());
        return;
      }

      this.items.forEach((el)=>{ el.hidden = false;  this.$parent.$emit('loadedBckgr',this.compileStyle());} );
      this.items[index].hidden = true;

      if (this.current == index)
        this.current = travelArray(this.items, this.current);
    },

    remove(index) {
      this.items.splice(index, 1);
       this.$parent.$emit('loadedBckgr',this.compileStyle());
    },

    addNew() {
      this.items.push({
        fakeUrl: '',
        x: 0,
        y: 0,
        repeat: 'no-repeat',
        isCenter: true,
        size: 'auto',
        hidden: false,
        isPreset: false,
        img: {
          url: '',
          width: 0,
          height: 0,
          aspectRatio: 1,
        },
      });

      this.current = this.items.length - 1;

      this.$nextTick(()=> {
        $('.source__input-area').eq(this.current)
          .find('input').focus();
      });
      this.$parent.$emit('loadedBckgr',this.compileStyle());
    },

    move(from, to) {
      let item = this.items.splice(from, 1)[0];
      this.items.splice(to, 0, item);
      this.current === from && (this.current = to);
    },

    /**
     * Image centering logic
     */
    centerImage(item) {
      if (!item.isCenter) return;

      let currentItemSize = (item.size == 'auto')
        ? item.img.width
        : item.size;

      item.x = Math.round((this.viewport.width - currentItemSize ) / 2);
      item.y = Math.round((this.viewport.height - currentItemSize / item.img.aspectRatio ) / 2);
      this.$parent.$emit('loadedBckgr',this.compileStyle());
    },

    /**
     * Extract image dimensions
     * and set item defaults
     */
    setImageProps(item, image) {
      
      item.img.width = image.width;
      item.img.height = image.height;
      item.img.aspectRatio = image.width / image.height;

      // not set defaults for preset (default) images
      if (!item.isPreset) {
        item.isCenter = true;
        item.size = 'auto';
        this.current = this.items.indexOf(item);
      }
      item.isPreset = false;
      this.centerImage(item);
      this.$parent.$emit('loadedBckgr',this.compileStyle());
    },

    /**
     * Handle input url field
     * or image file uploading
     */
    processImageURL(e,item,value) {
      let self = this;
      let input = null;
     
      if (e) {
        input = e.target;
        value = input.value;
       }
      if (value === item.fakeUrl && !item.isPreset) return;

      if (input && input.files) {
        let reader = new FileReader();
        reader.onload = function(e) {
          loadImage(e.target.result, function() {
            self.setImageProps(item, this);
            item.fakeUrl = value.replace(/^.*fakepath[\/\\]?/, '');
            item.img.url = e.target.result;
          });
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        
         loadImage(value, function() {
          self.setImageProps(item, this);
          item.fakeUrl = value;
          item.img.url = this.src;
        });
      }
       
    },

    compileStyle() {
      let s = '';
      let curr, x, y, size;
      for (let i = 0, len = this.items.length; i < len; i++) {
        curr = this.items[i];
        if (curr.hidden) continue;

        x = curr.isCenter ? 'center' : curr.x + 'px';
        y = curr.isCenter ? 'center' : curr.y + 'px';
        size = curr.size === 'auto' ? 'auto' : curr.size + 'px';

        s += `url('${curr.img.url}') ${curr.repeat} ${x} ${y} / ${size}`;

        if (i !== len-1) s += ', ';
      }
      let css = '';
      css = `background: ${s};`;
      return css;
    },
  },

  watch: {
    '$data': {
      deep: true,
      handler() { this.compileStyle(); },
    },
    'items'() {
      if (this.current > this.items.length - 1)
          this.current = this.items.length - 1;
    },
  },

  mounted() {
    // process initial presets styles
    this.items.forEach((el)=> {
      this.processImageURL(null, el, el.img.url);
    });
  
    postBind.call(this);
  },
};

function postBind() {
  let $viewport = $('.preview');
  let self = this;
  $(window).on('resize', ()=> {
    this.viewport.width  = $viewport.width();
    this.viewport.height = $viewport.height();
    
    this.items.forEach((item)=> {
      if (item.isCenter) this.centerImage(item);
    });
  }).trigger('resize');
  
  /**
   * Draggable panes
   * Al restaurar el proyecto, esto funciona
   */
  let container = $('.source')[0];
    Sortable.create(container, {
      animation: 150,
      scroll: false,
      handle: '.source__drag-handler',
      draggable: '.source__item',
      onUpdate: function(e) {
        self.move(e.oldIndex, e.newIndex);
      },
    });
}
</script>