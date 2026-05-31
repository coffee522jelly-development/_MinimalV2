import React from 'react';
import { createRoot } from 'react-dom/client';
import { Github, Twitter, MessageSquare, ExternalLink } from 'lucide-react';

const FooterSNS = () => {
  const sns = window.devminimalData?.sns || {};

  return (
    <div className="flex gap-4">
      {sns.github && (
        <a href={sns.github} target="_blank" rel="noopener noreferrer" className="text-muted-foreground hover:text-primary transition-colors">
          <Github size={20} />
        </a>
      )}
      {sns.twitter && (
        <a href={sns.twitter} target="_blank" rel="noopener noreferrer" className="text-muted-foreground hover:text-primary transition-colors">
          <Twitter size={20} />
        </a>
      )}
      {sns.qiita && (
        <a href={sns.qiita} target="_blank" rel="noopener noreferrer" className="text-muted-foreground hover:text-primary transition-colors">
          <MessageSquare size={20} />
        </a>
      )}
      {sns.zenn && (
        <a href={sns.zenn} target="_blank" rel="noopener noreferrer" className="text-muted-foreground hover:text-primary transition-colors">
          <ExternalLink size={20} />
        </a>
      )}
    </div>
  );
};

const rootElement = document.getElementById('footer-sns-root');
if (rootElement) {
  createRoot(rootElement).render(<FooterSNS />);
}
