import Prism from 'prismjs';
import 'prismjs/components/prism-typescript';
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-css';
import 'prismjs/components/prism-json';
import 'prismjs/components/prism-bash';
import 'prismjs/themes/prism-tomorrow.css';

declare global {
  interface Window {
    devminimalData: {
      menu: Array<{ title: string; url: string }>;
      sns: { github?: string; twitter?: string; qiita?: string; zenn?: string };
      home: string;
      code: { bg: string; lineNumbers: boolean };
    };
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const codeBlocks = document.querySelectorAll('pre');
  const codeConfig = window.devminimalData?.code || { bg: '#1d1f21', lineNumbers: true };

  codeBlocks.forEach((block) => {
    const code = block.querySelector('code');
    if (!code) return;

    // Apply Prism
    Prism.highlightElement(code);

    // Create container
    const container = document.createElement('div');
    container.className = 'my-6 rounded-lg overflow-hidden border shadow-sm text-white font-mono text-sm';
    container.style.backgroundColor = codeConfig.bg;

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

    const lang = code.className.match(/language-(\w+)/)?.[1] || 'code';
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
      const text = code.textContent || '';
      navigator.clipboard.writeText(text).then(() => {
        copyBtn.textContent = 'Copied!';
        setTimeout(() => copyBtn.textContent = 'Copy', 2000);
      });
    };

    header.appendChild(leftSide);
    header.appendChild(copyBtn);

    // Line Numbers
    if (codeConfig.lineNumbers) {
      const lines = code.innerHTML.split('\n');
      if (lines.length > 1) {
          const numberedLines = lines.map((line, i) => `<span class="inline-block w-8 mr-4 text-right text-muted-foreground/40 select-none">${i + 1}</span>${line}`).join('\n');
          code.innerHTML = numberedLines;
      }
    }

    // Style the original pre
    block.className = 'p-4 overflow-x-auto m-0 bg-transparent';

    // Wrap
    block.parentNode?.insertBefore(container, block);
    container.appendChild(header);
    container.appendChild(block);
  });
});
