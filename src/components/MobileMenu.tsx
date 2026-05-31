import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { Menu, X } from 'lucide-react';

declare global {
  interface Window {
    devminimalData: {
      menu: Array<{ title: string; url: string }>;
      home: string;
    };
  }
}

const MobileMenu = () => {
  const [isOpen, setIsOpen] = useState(false);
  const menuData = window.devminimalData?.menu || [];
  const homeUrl = window.devminimalData?.home || '/';

  return (
    <>
      <button
        onClick={() => setIsOpen(true)}
        className="p-2 rounded-md hover:bg-accent"
        aria-label="Open menu"
      >
        <Menu size={24} />
      </button>

      {isOpen && (
        <div className="fixed inset-0 z-50 bg-background flex flex-col p-6 animate-in fade-in zoom-in duration-300">
          <div className="flex justify-end">
            <button
              onClick={() => setIsOpen(false)}
              className="p-2 rounded-md hover:bg-accent"
              aria-label="Close menu"
            >
              <X size={24} />
            </button>
          </div>
          <nav className="mt-12 flex flex-col gap-6 text-2xl font-bold">
            <a href={homeUrl} onClick={() => setIsOpen(false)}>Home</a>
            {menuData.map((item, index) => (
              <a key={index} href={item.url} onClick={() => setIsOpen(false)}>
                {item.title}
              </a>
            ))}
          </nav>
        </div>
      )}
    </>
  );
};

const rootElement = document.getElementById('mobile-menu-root');
if (rootElement) {
  createRoot(rootElement).render(<MobileMenu />);
}
