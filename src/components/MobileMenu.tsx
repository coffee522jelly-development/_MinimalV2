import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { Menu, X, ChevronDown } from 'lucide-react';

interface MenuItem {
  title: string;
  url: string;
  children?: MenuItem[];
}

declare global {
  interface Window {
    devminimalData: {
      menu: MenuItem[];
      home: string;
    };
  }
}

const MobileMenu = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [openSubMenus, setOpenSubMenus] = useState<Record<number, boolean>>({});

  const menuData = window.devminimalData?.menu || [];
  const homeUrl = window.devminimalData?.home || '/';

  const toggleSubMenu = (index: number) => {
    setOpenSubMenus(prev => ({
      ...prev,
      [index]: !prev[index]
    }));
  };

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
        <div className="fixed inset-0 z-50 bg-background flex flex-col p-6 animate-in fade-in zoom-in duration-300 overflow-y-auto">
          <div className="flex justify-end mb-8">
            <button
              onClick={() => setIsOpen(false)}
              className="p-2 rounded-md hover:bg-accent"
              aria-label="Close menu"
            >
              <X size={24} />
            </button>
          </div>

          <nav className="flex flex-col gap-4 text-xl font-bold">
            <a href={homeUrl} onClick={() => setIsOpen(false)} className="py-2 border-b">Home</a>

            {menuData.map((item, index) => (
              <div key={index} className="flex flex-col border-b">
                <div className="flex items-center justify-between py-2">
                  <a href={item.url} onClick={() => setIsOpen(false)} className="flex-grow">
                    {item.title}
                  </a>
                  {item.children && item.children.length > 0 && (
                    <button
                      onClick={() => toggleSubMenu(index)}
                      className={`p-2 transition-transform duration-200 ${openSubMenus[index] ? 'rotate-180' : ''}`}
                    >
                      <ChevronDown size={20} />
                    </button>
                  )}
                </div>

                {item.children && item.children.length > 0 && openSubMenus[index] && (
                  <div className="flex flex-col pl-4 gap-3 pb-4 animate-in slide-in-from-top-2 duration-200">
                    {item.children.map((child, childIndex) => (
                      <a
                        key={childIndex}
                        href={child.url}
                        onClick={() => setIsOpen(false)}
                        className="text-lg font-medium text-muted-foreground"
                      >
                        {child.title}
                      </a>
                    ))}
                  </div>
                )}
              </div>
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
