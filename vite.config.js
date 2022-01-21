import legacy from '@vitejs/plugin-legacy'
import ViteRestart from 'vite-plugin-restart'
import mkcert from 'vite-plugin-mkcert'
import copy from 'rollup-plugin-copy'

// https://vitejs.dev/config/
export default ({ command }) => ({
  base: command === 'serve' ? '' : '/dist/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: './public/dist/',
    rollupOptions: {
      input: {
        app: './resources/js/main.js',
      },
    },
  },
  plugins: [
    // This plugin copies files that should be included in the public (dist) folder on build
    copy({
      targets: [
        // { src: 'resources/images/**/*', dest: 'web/images' },
        // { src: 'resources/fonts/.htaccess', dest: 'web/dist/assets' },
      ],
      hook: 'writeBundle',
    }),

    // This plugin provides support for legacy browsers that do not support native ESM.
    legacy({
      targets: ['defaults', 'not IE 11'],
    }),

    // Plugin that add change listeners to restart the server
    ViteRestart({
      reload: ['./templates/**/*'],
    }),

    // Plugin that provides certificate support for vite https development services.
    mkcert(),
  ],

  server: {
    origin: 'https://localhost:3000',
    https: true,
    hmr: {
      host: 'localhost',
    },
  },
})
