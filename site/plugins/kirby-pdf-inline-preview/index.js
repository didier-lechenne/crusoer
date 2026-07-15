panel.plugin("dlechenne/pdf-inline-preview", {
  blocks: {
    "pdf-inline": {
      template: `
        <div>
          <iframe
            v-if="content.pdf && content.pdf.length && content.pdf[0].url"
            :src="content.pdf[0].url"
            width="100%"
            :height="content.height || 800"
            style="border:none;display:block;pointer-events:none"
          ></iframe>
          <div v-else style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 0">
            <k-icon type="file" />
            <em style="opacity:0.5">Aucun fichier sélectionné</em>
          </div>
        </div>
      `,
    },
  },
});
