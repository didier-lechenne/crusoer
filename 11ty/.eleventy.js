import { kirbyUrl, warmMedia, clearKqlCache } from "./_data/kql.js";
import publicationsData from "./_data/publications.js";
import aboutData from "./_data/about.js";
import mentionsData from "./_data/mentions.js";

export default function (eleventyConfig) {
  eleventyConfig.addWatchTarget("../content/");
  eleventyConfig.addPassthroughCopy({ "../assets": "assets" });
  eleventyConfig.addPassthroughCopy({ "../media/pages": "media/pages" });
  eleventyConfig.addPassthroughCopy({ "../media/plugins": "media/plugins" });

  eleventyConfig.on("eleventy.before", async () => {
    clearKqlCache();

    const [publications, about, mentions] = await Promise.all([
      publicationsData(),
      aboutData(),
      mentionsData(),
    ]);

    const html = publications
      .flatMap((pub) => [
        pub.intro_principal,
        pub.chapo_principal,
        pub.contenu_principal,
        pub.intro_secondaire,
        pub.chapo_secondaire,
        pub.contenu_secondaire,
      ])
      .concat([about.contenu_principal, mentions.contenu_principal])
      .filter(Boolean)
      .join("\n");

    await warmMedia(html);
  });

  eleventyConfig.addTransform(
    "rewrite-kirby-urls",
    function (content, outputPath) {
      if (outputPath && outputPath.endsWith(".html")) {
        return content.replaceAll(kirbyUrl, "");
      }
      return content;
    },
  );

  eleventyConfig.setServerOptions({ port: 8080 });

  return {
    dir: {
      input: ".",
      includes: "_includes",
      data: "_data",
      output: "../static",
    },
    templateFormats: ["njk", "html", "11ty.js"],
    htmlTemplateEngine: "njk",
  };
}
