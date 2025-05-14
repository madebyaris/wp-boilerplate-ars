import { defineConfig } from 'vite';
import { resolve } from 'path';

// https://vitejs.dev/config/
export default defineConfig({
  // Define entry points
  build: {
    outDir: 'assets/dist',
    emptyOutDir: true,
    manifest: true,
    sourcemap: true,
    rollupOptions: {
      input: {
        admin: resolve(__dirname, 'assets/src/admin.js'),
        frontend: resolve(__dirname, 'assets/src/frontend.js'),
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].[hash].js',
        assetFileNames: ({ name }) => {
          if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
            return 'images/[name].[hash][extname]';
          }
          if (/\.css$/.test(name ?? '')) {
            return '[name].css';
          }
          return '[name].[hash][extname]';
        },
      },
    },
  },
  
  // Define config for blocks (optional)
  plugins: [
    {
      name: 'watch-external', // Watch for changes in PHP files and reload
      configureServer({ watcher, ws }) {
        watcher.add(resolve('**/*.php'));
        watcher.on('change', function (path) {
          if (path.endsWith('.php')) {
            ws.send({ type: 'full-reload' });
          }
        });
      },
    },
  ],
  
  // Development server settings
  server: {
    // Adjust the port if needed
    port: 3000,
    strictPort: true,
    cors: true,
    // Customize HMR origin for WordPress development
    hmr: {
      host: 'localhost',
    },
  },
  
  // Allow configuring paths dynamically
  // Replace with actual public path based on the WordPress site URL
  base: process.env.NODE_ENV === 'production' 
    ? '/wp-content/plugins/${PLUGIN_SLUG}/assets/dist/' 
    : '/',
  
  // Resolve config
  resolve: {
    alias: {
      '@': resolve(__dirname, 'assets/src'),
    },
  },
}); 