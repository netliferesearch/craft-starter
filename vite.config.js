import legacy from '@vitejs/plugin-legacy'
import ViteRestart from 'vite-plugin-restart'
import basicSsl from '@vitejs/plugin-basic-ssl'

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
    // This plugin provides support for legacy browsers that do not support native ESM.
    legacy({
      targets: ['defaults', 'not IE 11'],
    }),

    // Plugin that add change listeners to restart the server
    ViteRestart({
      reload: ['./templates/**/*'],
    }),

    // Plugin that provides certificate support for vite https development services.
    basicSsl(),
  ],

  server: {
    origin: 'https://localhost:3000',
    port: 3000,
    https: true,
    hmr: {
      host: 'localhost',
    },
  },
})
