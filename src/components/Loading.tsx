import React from 'react';
import { createRoot } from 'react-dom/client';

const Skeleton = () => {
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-pulse">
      {[...Array(6)].map((_, i) => (
        <div key={i} className="bg-muted rounded-lg h-64"></div>
      ))}
    </div>
  );
};

// This could be used during client-side navigation or initial loading if implemented as a SPA
// For a standard WP theme, we can use it to show a progress bar
const ProgressBar = () => {
  const [progress, setProgress] = React.useState(0);

  React.useEffect(() => {
    const timer = setInterval(() => {
      setProgress((oldProgress) => {
        if (oldProgress === 100) {
          clearInterval(timer);
          return 100;
        }
        const diff = Math.random() * 10;
        return Math.min(oldProgress + diff, 100);
      });
    }, 200);

    window.addEventListener('load', () => {
      setProgress(100);
    });

    return () => {
      clearInterval(timer);
    };
  }, []);

  return (
    <div
      className="fixed top-0 left-0 h-1 bg-primary z-[60] transition-all duration-300 ease-out"
      style={{ width: `${progress}%`, opacity: progress === 100 ? 0 : 1 }}
    />
  );
};

const progressRoot = document.createElement('div');
document.body.appendChild(progressRoot);
createRoot(progressRoot).render(<ProgressBar />);
