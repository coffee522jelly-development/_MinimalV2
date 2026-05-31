document.addEventListener('DOMContentLoaded', () => {
  const codeBlocks = document.querySelectorAll('pre');

  codeBlocks.forEach((block) => {
    // Create container
    const container = document.createElement('div');
    container.className = 'my-6 rounded-lg overflow-hidden border shadow-sm bg-[#1e1e1e] text-white font-mono text-sm';

    // Create header (Mac Terminal style)
    const header = document.createElement('div');
    header.className = 'flex items-center justify-between px-4 py-2 bg-[#2d2d2d] border-b border-[#3d3d3d]';

    const dots = document.createElement('div');
    dots.className = 'flex gap-1.5';
    ['bg-[#ff5f56]', 'bg-[#ffbd2e]', 'bg-[#27c93f]'].forEach(color => {
      const dot = document.createElement('div');
      dot.className = `w-3 h-3 rounded-full ${color}`;
      dots.appendChild(dot);
    });

    const lang = block.querySelector('code')?.className.match(/language-(\w+)/)?.[1] || 'code';
    const langLabel = document.createElement('span');
    langLabel.className = 'text-xs text-muted-foreground uppercase ml-4';
    langLabel.textContent = lang;

    const leftSide = document.createElement('div');
    leftSide.className = 'flex items-center';
    leftSide.appendChild(dots);
    leftSide.appendChild(langLabel);

    const copyBtn = document.createElement('button');
    copyBtn.className = 'text-xs hover:text-primary transition-colors';
    copyBtn.textContent = 'Copy';
    copyBtn.onclick = () => {
      const text = block.textContent || '';
      navigator.clipboard.writeText(text).then(() => {
        copyBtn.textContent = 'Copied!';
        setTimeout(() => copyBtn.textContent = 'Copy', 2000);
      });
    };

    header.appendChild(leftSide);
    header.appendChild(copyBtn);

    // Style the original pre
    block.className = 'p-4 overflow-x-auto';
    block.style.margin = '0';

    // Wrap
    block.parentNode?.insertBefore(container, block);
    container.appendChild(header);
    container.appendChild(block);
  });
});
