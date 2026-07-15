(() => {
  // site/plugins/kirby-markdown-field-extras/src/unicode.js
  var UNICODE_CHARS = {
    // ========================
    // ESPACES SPECIAUX
    // ========================
    /** Espace fine insecable (U+202F) - avant ; ! ? et dans les guillemets */
    NO_BREAK_THIN_SPACE: "\u202F",
    /** Espace insecable (U+00A0) - avant : en francais */
    NO_BREAK_SPACE: "\xA0",
    // ========================
    // GUILLEMETS
    // ========================
    /** Guillemet francais ouvrant (U+00AB) */
    LAQUO: "\xAB",
    /** Guillemet francais fermant (U+00BB) */
    RAQUO: "\xBB",
    /** Guillemet anglais ouvrant (U+201C) */
    LDQUO: "\u201C",
    /** Guillemet anglais fermant (U+201D) */
    RDQUO: "\u201D"
  };

  // site/plugins/kirby-markdown-field-extras/src/index.js
  if (window.panel && window.panel.plugin) {
    window.panel.plugin("dlechenne/markdown-field-extras", {
      icons: {
        cite: '<g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></g>',
        smallcap: '<g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 16 2.536-7.328a1.02 1.02 1 0 1 1.928 0L22 16"/><path d="M15.697 14h5.606"/><path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"/><path d="M3.304 13h6.392"/></g>',
        guillemet: '<text x="12" y="17" text-anchor="middle" font-family="serif" font-size="20" fill="currentColor">\xAB</text>',
        "space-nbsp": '<text x="12" y="16" text-anchor="middle" font-size="11" font-family="serif" fill="currentColor">nb</text><line x1="4" y1="19" x2="20" y2="19" stroke="currentColor" stroke-width="2"/>',
        "space-nnbsp": '<text x="12" y="16" text-anchor="middle" font-size="9" font-family="serif" fill="currentColor">nnb</text><line x1="7" y1="19" x2="17" y2="19" stroke="currentColor" stroke-width="2"/>'
      }
    });
  }
  window.markdownEditorButtons = window.markdownEditorButtons || [];
  var getSelection = (editor) => {
    try {
      if (editor.getSelection) return editor.getSelection() || "";
      if (editor.codemirror && editor.codemirror.getSelection)
        return editor.codemirror.getSelection() || "";
    } catch (e) {
    }
    return "";
  };
  var wrap = (editor, before, after, placeholder = "") => {
    const sel = getSelection(editor);
    if (sel) {
      try {
        editor.deleteSelection();
      } catch (e) {
      }
      editor.insert(before + sel + after);
    } else {
      editor.insert(before + placeholder + after);
    }
  };
  var button = (name, def) => ({
    get button() {
      return typeof def === "function" ? def.call(this) : def;
    },
    get name() {
      return name;
    },
    get isDisabled() {
      return () => false;
    }
  });
  window.markdownEditorButtons.push(
    // — Cite —
    button("cite", function() {
      return {
        icon: "cite",
        label: "Cite",
        command: () => wrap(this.editor, "<cite>", "</cite>")
      };
    }),
    // — Petites capitales —
    button("smallcap", function() {
      return {
        icon: "smallcap",
        label: "Petites capitales",
        command: () => wrap(this.editor, '<span class="smallcaps">', "</span>", "texte")
      };
    }),
    // — Espace insécable (U+00A0) —
    button("space-nbsp", function() {
      return {
        icon: "space-nbsp",
        label: "Espace ins\xE9cable",
        command: () => this.editor.insert(UNICODE_CHARS.NO_BREAK_SPACE)
      };
    }),
    // — Espace insécable fine (U+202F) —
    button("space-nnbsp", function() {
      return {
        icon: "space-nnbsp",
        label: "Espace ins\xE9cable fine",
        command: () => this.editor.insert(UNICODE_CHARS.NO_BREAK_THIN_SPACE)
      };
    }),
    // — Exposants (sup / sub) —
    button("exposants", function() {
      return {
        icon: "superscript",
        label: "Exposants",
        dropdown: [
          {
            label: "Exposant",
            command: () => wrap(this.editor, "<sup>", "</sup>", "texte")
          },
          {
            label: "Indice",
            command: () => wrap(this.editor, "<sub>", "</sub>", "texte")
          }
        ]
      };
    }),
    // — Guillemets (espace fine insécable à l'intérieur) —
    button("guillemets-dropdown", function() {
      const fr = [UNICODE_CHARS.LAQUO + UNICODE_CHARS.NO_BREAK_THIN_SPACE, UNICODE_CHARS.NO_BREAK_THIN_SPACE + UNICODE_CHARS.RAQUO];
      const en = [UNICODE_CHARS.LDQUO + UNICODE_CHARS.NO_BREAK_THIN_SPACE, UNICODE_CHARS.NO_BREAK_THIN_SPACE + UNICODE_CHARS.RDQUO];
      return {
        icon: "guillemet",
        label: "Guillemets",
        dropdown: [
          {
            label: `Guillemets fran\xE7ais ${UNICODE_CHARS.LAQUO}${UNICODE_CHARS.NO_BREAK_SPACE}${UNICODE_CHARS.RAQUO}`,
            command: () => wrap(this.editor, fr[0], fr[1], "texte")
          },
          {
            label: `Guillemets second niveau ${UNICODE_CHARS.LDQUO}${UNICODE_CHARS.NO_BREAK_SPACE}${UNICODE_CHARS.RDQUO}`,
            command: () => wrap(this.editor, en[0], en[1], "texte")
          }
        ]
      };
    }),
    // — Listes —
    button("listes-dropdown", function() {
      return {
        icon: "list-bullet",
        label: "Listes",
        dropdown: [
          {
            label: "Liste \xE0 puces",
            icon: "list-bullet",
            command: () => this.editor.toggleBlockFormat("BulletList"),
            token: "BulletList",
            tokenType: "block"
          },
          {
            label: "Liste num\xE9rot\xE9e",
            icon: "list-numbers",
            command: () => this.editor.toggleBlockFormat("OrderedList"),
            token: "OrderedList",
            tokenType: "block"
          }
        ]
      };
    })
  );
})();
