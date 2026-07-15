/**
 * URL Break Handler
 * Adds <wbr> to URLs in links to allow line breaking in print/narrow containers.
 */
document.addEventListener('DOMContentLoaded', function () {
  const links = document.querySelectorAll('a[href^="http"], a[href^="www"]');
  links.forEach(function (link) {
    const content = link.textContent;
    if (!(link.childElementCount === 0 && content.match(/^http|^www|^[a-z0-9.-]+\.[a-z]{2,}/i))) return;

    let printableUrl = content.replace(/\/\//g, '//<wbr>');
    printableUrl = printableUrl.replace(/,/g, ',<wbr>');
    printableUrl = printableUrl.replace(/(\/|~|-|\.|,|_|\?|#|%)/g, '<wbr>$1');
    printableUrl = printableUrl.replace(/-/g, '<wbr>&#x2011;');

    link.setAttribute('data-print-url', printableUrl);
    link.innerHTML = printableUrl;
  });
});
