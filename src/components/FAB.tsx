import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { Plus, ArrowUp, Github, Twitter, MessageSquare, ExternalLink } from 'lucide-react';

declare global {
  interface Window {
    devminimalData: {
      sns: {
        github?: string;
        twitter?: string;
        qiita?: string;
        zenn?: string;
      };
      home: string;
    };
  }
}

const FAB = () => {
  const [isOpen, setIsOpen] = useState(false);
  const sns = window.devminimalData?.sns || {};

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    setIsOpen(false);
  };

  const actions = [
    { icon: <ArrowUp size={20} />, label: 'Top', onClick: scrollToTop },
  ];

  if (sns.github) actions.push({ icon: <Github size={20} />, label: 'GitHub', href: sns.github } as any);
  if (sns.twitter) actions.push({ icon: <Twitter size={20} />, label: 'X (Twitter)', href: sns.twitter } as any);
  if (sns.qiita) actions.push({ icon: <MessageSquare size={20} />, label: 'Qiita', href: sns.qiita } as any);
  if (sns.zenn) actions.push({ icon: <ExternalLink size={20} />, label: 'Zenn', href: sns.zenn } as any);

  return (
    <div className="fixed bottom-8 right-8 z-40 flex flex-col-reverse items-center gap-4">
      <button
        onClick={() => setIsOpen(!isOpen)}
        className={`w-14 h-14 rounded-full bg-primary text-primary-foreground shadow-lg flex items-center justify-center transition-transform duration-300 ${isOpen ? 'rotate-45' : ''}`}
        aria-label="Toggle menu"
      >
        <Plus size={28} />
      </button>

      {isOpen && (
        <div className="flex flex-col items-center gap-4 animate-in slide-in-from-bottom-4 duration-300">
          {actions.map((action, index) => (
            <div key={index} className="group flex items-center gap-3">
              <span className="opacity-0 group-hover:opacity-100 transition-opacity bg-background border px-2 py-1 rounded text-xs font-bold shadow-sm whitespace-nowrap">
                {(action as any).label}
              </span>
              {(action as any).href ? (
                <a
                  href={(action as any).href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="w-12 h-12 rounded-full bg-card border text-card-foreground shadow-md flex items-center justify-center hover:bg-accent transition-colors"
                  aria-label={(action as any).label}
                >
                  {action.icon}
                </a>
              ) : (
                <button
                  onClick={(action as any).onClick}
                  className="w-12 h-12 rounded-full bg-card border text-card-foreground shadow-md flex items-center justify-center hover:bg-accent transition-colors"
                  aria-label={(action as any).label}
                >
                  {action.icon}
                </button>
              )}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

const rootElement = document.getElementById('fab-root');
if (rootElement) {
  createRoot(rootElement).render(<FAB />);
}
