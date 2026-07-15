import { UNICODE_CHARS as U } from "./unicode.js";

// — Icônes custom (enregistrées une seule fois pour tous les boutons) —
if (window.panel && window.panel.plugin) {
	window.panel.plugin("dlechenne/markdown-field-extras", {
		icons: {
			cite: '<g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></g>',
			smallcap:
				'<g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 16 2.536-7.328a1.02 1.02 1 0 1 1.928 0L22 16"/><path d="M15.697 14h5.606"/><path d="m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16"/><path d="M3.304 13h6.392"/></g>',
			guillemet:
				'<text x="12" y="17" text-anchor="middle" font-family="serif" font-size="20" fill="currentColor">«</text>',
			"space-nbsp":
				'<text x="12" y="16" text-anchor="middle" font-size="11" font-family="serif" fill="currentColor">nb</text><line x1="4" y1="19" x2="20" y2="19" stroke="currentColor" stroke-width="2"/>',
			"space-nnbsp":
				'<text x="12" y="16" text-anchor="middle" font-size="9" font-family="serif" fill="currentColor">nnb</text><line x1="7" y1="19" x2="17" y2="19" stroke="currentColor" stroke-width="2"/>',
		},
	});
}

window.markdownEditorButtons = window.markdownEditorButtons || [];

// Récupère la sélection courante de l'éditeur (quelle que soit son API)
const getSelection = (editor) => {
	try {
		if (editor.getSelection) return editor.getSelection() || "";
		if (editor.codemirror && editor.codemirror.getSelection)
			return editor.codemirror.getSelection() || "";
	} catch (e) {}
	return "";
};

// Entoure la sélection (ou un placeholder) de `before` / `after`
const wrap = (editor, before, after, placeholder = "") => {
	const sel = getSelection(editor);
	if (sel) {
		try {
			editor.deleteSelection();
		} catch (e) {}
		editor.insert(before + sel + after);
	} else {
		editor.insert(before + placeholder + after);
	}
};

// Petit helper pour déclarer un bouton (réduit la répétition des getters)
const button = (name, def) => ({
	get button() {
		return typeof def === "function" ? def.call(this) : def;
	},
	get name() {
		return name;
	},
	get isDisabled() {
		return () => false;
	},
});

window.markdownEditorButtons.push(
	// — Cite —
	button("cite", function () {
		return {
			icon: "cite",
			label: "Cite",
			command: () => wrap(this.editor, "<cite>", "</cite>"),
		};
	}),

	// — Petites capitales —
	button("smallcap", function () {
		return {
			icon: "smallcap",
			label: "Petites capitales",
			command: () =>
				wrap(this.editor, '<span class="smallcaps">', "</span>", "texte"),
		};
	}),

	// — Espace insécable (U+00A0) —
	button("space-nbsp", function () {
		return {
			icon: "space-nbsp",
			label: "Espace insécable",
			command: () => this.editor.insert(U.NO_BREAK_SPACE),
		};
	}),

	// — Espace insécable fine (U+202F) —
	button("space-nnbsp", function () {
		return {
			icon: "space-nnbsp",
			label: "Espace insécable fine",
			command: () => this.editor.insert(U.NO_BREAK_THIN_SPACE),
		};
	}),

	// — Exposants (sup / sub) —
	button("exposants", function () {
		return {
			icon: "superscript",
			label: "Exposants",
			dropdown: [
				{
					label: "Exposant",
					command: () => wrap(this.editor, "<sup>", "</sup>", "texte"),
				},
				{
					label: "Indice",
					command: () => wrap(this.editor, "<sub>", "</sub>", "texte"),
				},
			],
		};
	}),

	// — Guillemets (espace fine insécable à l'intérieur) —
	button("guillemets-dropdown", function () {
		const fr = [U.LAQUO + U.NO_BREAK_THIN_SPACE, U.NO_BREAK_THIN_SPACE + U.RAQUO];
		const en = [U.LDQUO + U.NO_BREAK_THIN_SPACE, U.NO_BREAK_THIN_SPACE + U.RDQUO];
		return {
			icon: "guillemet",
			label: "Guillemets",
			dropdown: [
				{
					label: `Guillemets français ${U.LAQUO}${U.NO_BREAK_SPACE}${U.RAQUO}`,
					command: () => wrap(this.editor, fr[0], fr[1], "texte"),
				},
				{
					label: `Guillemets second niveau ${U.LDQUO}${U.NO_BREAK_SPACE}${U.RDQUO}`,
					command: () => wrap(this.editor, en[0], en[1], "texte"),
				},
			],
		};
	}),

	// — Listes —
	button("listes-dropdown", function () {
		return {
			icon: "list-bullet",
			label: "Listes",
			dropdown: [
				{
					label: "Liste à puces",
					icon: "list-bullet",
					command: () => this.editor.toggleBlockFormat("BulletList"),
					token: "BulletList",
					tokenType: "block",
				},
				{
					label: "Liste numérotée",
					icon: "list-numbers",
					command: () => this.editor.toggleBlockFormat("OrderedList"),
					token: "OrderedList",
					tokenType: "block",
				},
			],
		};
	})
);
