import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { Plus, ArrowUp, LayoutGrid, Briefcase, Info, Mail } from 'lucide-react';

declare global {
  interface Window {
    devminimalData: {
      sns: { github?: string; twitter?: string; qiita?: string; zenn?: string };
      home: string;
      code: { bg: string; lineNumbers: boolean };
      fab: { apps: string; projects: string; about: string; contact: string };
    };
  }
}

const FAB = () => {
  const [isOpen, setIsOpen] = useState(false);
  const homeUrl = window.devminimalData?.home || '/';
  const fabConfig = window.devminimalData?.fab || {
    apps: '?type=app',
    projects: '/projects',
    about: '/about',
    contact: '/contact'
  };

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    setIsOpen(false);
  };

  const actions = [
    { icon: <ArrowUp size={20} />, label: 'Top', onClick: scrollToTop },
    { icon: <LayoutGrid size={20} />, label: 'Apps', href: fabConfig.apps.startsWith('http') || fabConfig.apps.startsWith('?') ? fabConfig.apps : `${homeUrl}${fabConfig.apps}` },
    { icon: <Briefcase size={20} />, label: 'Projects', href: fabConfig.projects.startsWith('http') ? fabConfig.projects : `${homeUrl}${fabConfig.projects}` },
    { icon: <Info size={20} />, label: 'About', href: fabConfig.about.startsWith('http') ? fabConfig.about : `${homeUrl}${fabConfig.about}` },
    { icon: <Mail size={20} />, label: 'Contact', href: fabConfig.contact.startsWith('http') ? fabConfig.contact : `${homeUrl}${fabConfig.contact}` },
  ];

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
                {action.label}
              </span>
              {action.href ? (
                <a
                  href={action.href}
                  className="w-12 h-12 rounded-full bg-card border text-card-foreground shadow-md flex items-center justify-center hover:bg-accent transition-colors"
                  aria-label={action.label}
                >
                  {action.icon}
                </a>
              ) : (
                <button
                  onClick={action.onClick}
                  className="w-12 h-12 rounded-full bg-card border text-card-foreground shadow-md flex items-center justify-center hover:bg-accent transition-colors"
                  aria-label={action.label}
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
