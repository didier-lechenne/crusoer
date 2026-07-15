/**
 * Transforme les <span class="inline-note"> générés par PHP
 * en structure sidenote CSS-toggle :
 *   [label.sn-toggle-label][input.sn-toggle][aside.sn-note]
 *
 * - Desktop : aside.sn-note flotte dans la marge droite (CSS)
 * - Mobile  : aside.sn-note masqué, label cliquable → input:checked + aside { display: block }
 *
 * @param {String} rootSel - sélecteur du conteneur à traiter
 * @param {String} noteSel - sélecteur des spans inline-note
 */
var processFootNotes = function processFootNotes(rootSel, noteSel) {
  rootSel = rootSel || "main";
  noteSel = noteSel || "span.inline-note";
  var notes = document.querySelectorAll(rootSel + " " + noteSel);
  var i = 1;

  Array.prototype.forEach.call(notes, function (note) {
    var id = "sn-" + i;

    // aside.sn-note - contenu de la note
    var noteNode = document.createElement("aside");
    noteNode.classList.add("sn-note");
    noteNode.setAttribute("data-ref", i);
    Array.prototype.forEach.call(note.childNodes, function (child) {
      noteNode.appendChild(child.cloneNode(true));
    });

    // input.sn-toggle - checkbox cachée pour le toggle mobile (CSS pur)
    var toggle = document.createElement("input");
    toggle.type = "checkbox";
    toggle.id = id;
    toggle.classList.add("sn-toggle");

    // label.sn-toggle-label - appel de note
    var label = document.createElement("label");
    label.htmlFor = id;
    label.classList.add("sn-toggle-label");
    label.textContent = i;

    // Remplace le span par [label][input][aside]
    var parent = note.parentNode;
    parent.insertBefore(label, note);
    parent.insertBefore(toggle, note);
    parent.insertBefore(noteNode, note);
    parent.removeChild(note);

    // Supprime le whitespace résiduel après l'aside
    var next = noteNode.nextSibling;
    if (next && next.nodeType === Node.TEXT_NODE) {
      // next.textContent = next.textContent.replace(/^\s+/, "");
    }

    i++;
  });
};

document.addEventListener("DOMContentLoaded", function () {
  processFootNotes();
});
