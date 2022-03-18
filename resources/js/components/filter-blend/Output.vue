<template id="outputs">
   <div class="container">
     <header class="sec__heading">
     <label class="sec__label">Output</label>
   </header>
   <section class="sec__inner">
    <div class="output">
      <pre class="output__body">
         <code class="language-css" v-html="css"></code>
      </pre>
    </div>
   </section>
   </div>
</template>
<script>
  export default {
     props:['css'],
     mounted(){ this.highlight = highlight() },
     data() { return { highlight:undefined } },
  };

  function highlight() {
    let $outputBody = document.querySelector('.language-css');
    return function() {
      Prism.highlightElement($outputBody);
    }
  }
  
</script>