import { kirbyUrl } from "./_data/kql.js";

export default class Feed {
  data() {
    return {
      permalink: "feed.xml",
      eleventyExcludeFromCollections: true,
    };
  }

  async render() {
    const res = await fetch(`${kirbyUrl}/feed.xml`);
    return res.text();
  }
}
