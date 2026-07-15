panel.plugin("cookbook/audio-block", {
    blocks: {
      audio: {
        computed: {
          source() {
            return this.content.source[0] || {};
          }
        },
        template: `
          <div>
            <div v-if="source.url">
              
              <audio style="margin-bottom:var(--spacing-4);" controls>
                <source :src="source.url" type="audio/mpeg">
              </audio>
                <div style="margin-bottom:var(--spacing-2);"  class="k-field-header k-block-type-heading-input" >{{ content.title }}</div>
                <div style="margin-bottom:var(--spacing-2);" class="" v-html="content.subtitle"></div>
                <div class="" v-html="content.description"></div>
            </div>
            <div v-else>No audio selected</div>
          </div>
        `
      }
    }
  });