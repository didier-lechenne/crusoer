import { kql } from "./kql.js";

export default async function () {
  return kql({
		query: "page('about')",
		select: {
      title: "page.title.value",
      titre_principal: "page.content.get('titre_principal').kti.orthotypo",
      contenu_principal: "page.content.get('contenu_principal').toBlocks.toHtml",
		},
	});
}
