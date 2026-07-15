import { kql } from "./kql.js";

export default async function () {
  return kql({
    query: "site",
    select: {
      title: "site.title.value",
      url: "site.url",
      description: "site.content.get('description').value",
      notesMode: "site.content.get('notesMode').or('footnotes').value",
    },
  });
}
