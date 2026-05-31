import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { LayoutGrid, List, Grid3X3 } from 'lucide-react';

const LayoutSwitcher = () => {
  const [columns, setColumns] = useState<number>(2);

  useEffect(() => {
    const savedColumns = localStorage.getItem('list-columns');
    if (savedColumns) {
      const cols = parseInt(savedColumns);
      setColumns(cols);
      updateGridClass(cols);
    }
  }, []);

  const updateGridClass = (cols: number) => {
    const grid = document.getElementById('post-grid');
    if (grid) {
      grid.classList.remove('grid-cols-1', 'grid-cols-2', 'md:grid-cols-2', 'lg:grid-cols-4');
      if (cols === 1) {
        grid.classList.add('grid-cols-1');
      } else if (cols === 2) {
        grid.classList.add('grid-cols-1', 'md:grid-cols-2');
      } else if (cols === 4) {
        grid.classList.add('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-4');
      }
    }
  };

  const handleSwitch = (cols: number) => {
    setColumns(cols);
    localStorage.setItem('list-columns', cols.toString());
    updateGridClass(cols);
  };

  return (
    <div className="flex gap-2 bg-muted p-1 rounded-md mb-6 w-fit">
      <button
        onClick={() => handleSwitch(1)}
        className={`p-1.5 rounded-sm ${columns === 1 ? 'bg-background shadow-sm' : 'hover:bg-background/50'}`}
        aria-label="1 column"
      >
        <List size={18} />
      </button>
      <button
        onClick={() => handleSwitch(2)}
        className={`p-1.5 rounded-sm ${columns === 2 ? 'bg-background shadow-sm' : 'hover:bg-background/50'}`}
        aria-label="2 columns"
      >
        <LayoutGrid size={18} />
      </button>
      <button
        onClick={() => handleSwitch(4)}
        className={`p-1.5 rounded-sm ${columns === 4 ? 'bg-background shadow-sm' : 'hover:bg-background/50'}`}
        aria-label="4 columns"
      >
        <Grid3X3 size={18} />
      </button>
    </div>
  );
};

const rootElement = document.getElementById('layout-switcher-root');
if (rootElement) {
  createRoot(rootElement).render(<LayoutSwitcher />);
}
