import { kql } from "./kql.js";

export default async function () {
  return kql({
    query: "page('publications').children.listed",
    select: {
      slug: true,
      url: true,
      title: "page.title.value",
      // Onglet principal
      titre_principal:    "page.content.get('titre_principal').kti.orthotypo",
      auteur_principal:   "page.content.get('auteur_principal').kti.orthotypo",
      annee_principal:    "page.content.get('annee_principal').kti.orthotypo",
      intro_principal:    "page.content.get('intro_principal').toBlocks.toHtml",
      chapo_principal:    "page.content.get('chapo_principal').toBlocks.toHtml",
      onglet_principal:   "page.content.get('onglet_principal').kti.orthotypo",
      contenu_principal:  "page.content.get('contenu_principal').toBlocks.toHtml",
      titre_principal_home: "page.content.get('titre_principal_home').kti.orthotypo",
      home_principal:     "page.content.get('home_principal').toBool",
      // Onglet secondaire
      titre_secondaire:   "page.content.get('titre_secondaire').kti.orthotypo",
      auteur_secondaire:  "page.content.get('auteur_secondaire').kti.orthotypo",
      annee_secondaire:   "page.content.get('annee_secondaire').kti.orthotypo",
      intro_secondaire:   "page.content.get('intro_secondaire').toBlocks.toHtml",
      chapo_secondaire:   "page.content.get('chapo_secondaire').toBlocks.toHtml",
      onglet_secondaire:  "page.content.get('onglet_secondaire').kti.orthotypo",
      contenu_secondaire: "page.content.get('contenu_secondaire').toBlocks.toHtml",
      titre_secondaire_home: "page.content.get('titre_secondaire_home').kti.orthotypo",
      home_secondaire:    "page.content.get('home_secondaire').toBool",
    },
  });
}
