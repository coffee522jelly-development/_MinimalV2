document.addEventListener('DOMContentLoaded', () => {
  const content = document.querySelector('.entry-content');
  const tocDesktop = document.getElementById('toc-content');
  const tocMobile = document.getElementById('toc-content-mobile');
  const readingTimeEl = document.querySelector('.reading-time-value'); // Assuming we can find it in the DOM

  if (!content || (!tocDesktop && !tocMobile)) return;

  const headings = content.querySelectorAll('h2, h3');
  if (headings.length === 0) {
    const tocContainers = document.querySelectorAll('#toc-content, #toc-mobile');
    tocContainers.forEach(el => (el as HTMLElement).style.display = 'none');
    return;
  }

  const generateTocList = () => {
    const tocList = document.createElement('ul');
    tocList.className = 'space-y-2';

    headings.forEach((heading, index) => {
      const id = `heading-${index}`;
      heading.id = id;

      const li = document.createElement('li');
      const level = parseInt(heading.tagName.substring(1));
      li.style.paddingLeft = `${(level - 2) * 1}rem`;

      const a = document.createElement('a');
      a.href = `#${id}`;
      a.textContent = heading.textContent;
      a.className = 'hover:text-primary transition-colors text-muted-foreground block py-1';

      a.addEventListener('click', (e) => {
        e.preventDefault();
        heading.scrollIntoView({ behavior: 'smooth' });
      });

      li.appendChild(a);
      tocList.appendChild(li);
    });

    // Add Reading Time at the bottom
    const readingTime = readingTimeEl?.textContent || '5 min'; // Fallback
    const rtLi = document.createElement('li');
    rtLi.className = 'mt-6 pt-4 border-t border-border text-xs text-muted-foreground font-medium flex items-center gap-2';
    rtLi.innerHTML = `<span>⏱</span> 読了目安：${readingTime}`;
    tocList.appendChild(rtLi);

    return tocList;
  };

  if (tocDesktop) tocDesktop.appendChild(generateTocList());
  if (tocMobile) tocMobile.appendChild(generateTocList());

  // Intersection Observer for highlighting
  const observerOptions = {
    root: null,
    rootMargin: '-100px 0px -70%',
    threshold: 0
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const id = entry.target.id;
        const activeLinks = document.querySelectorAll(`a[href="#${id}"]`);

        document.querySelectorAll('#toc-content a, #toc-content-mobile a').forEach(link => {
          link.classList.remove('text-primary', 'font-bold');
          link.classList.add('text-muted-foreground');
        });

        activeLinks.forEach(link => {
          link.classList.add('text-primary', 'font-bold');
          link.classList.remove('text-muted-foreground');
        });
      }
    });
  }, observerOptions);

  headings.forEach(heading => observer.observe(heading));
});
