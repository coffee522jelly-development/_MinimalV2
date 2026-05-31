document.addEventListener('DOMContentLoaded', () => {
  const content = document.querySelector('.entry-content');
  const tocDesktop = document.getElementById('toc-content');
  const tocMobile = document.getElementById('toc-content-mobile');

  if (!content || (!tocDesktop && !tocMobile)) return;

  const headings = content.querySelectorAll('h2, h3, h4');
  if (headings.length === 0) {
    const tocContainers = document.querySelectorAll('#toc-content, #toc-mobile');
    tocContainers.forEach(el => el.style.display = 'none');
    return;
  }

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
    a.className = 'hover:text-primary transition-colors text-muted-foreground';

    // Smooth scroll
    a.addEventListener('click', (e) => {
      e.preventDefault();
      heading.scrollIntoView({ behavior: 'smooth' });
    });

    li.appendChild(a);
    tocList.appendChild(li);
  });

  if (tocDesktop) tocDesktop.appendChild(tocList.cloneNode(true));
  if (tocMobile) tocMobile.appendChild(tocList.cloneNode(true));

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
