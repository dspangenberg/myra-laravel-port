import { defineConfig } from 'vite'
import { fileURLToPath, URL } from 'node:url'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import svgLoader from 'vite-svg-loader'
import { nodePolyfills } from 'vite-plugin-node-polyfills'

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.ts',
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    Components({
      dirs: ['resources/js/components'],
      extensions: ['vue', 'ts'],
      dts: true,
      deep: true,
      directoryAsNamespace: true
    }),
    nodePolyfills({
      globals: {
        Buffer: true,
        global: true,
        process: true
      },
      protocolImports: true
    }),
    svgLoader({
      svgoConfig: {
        plugins: [
          {
            name: 'preset-default',
            params: {
              overrides: {
                convertColors: {
                  currentColor: true
                }
              }
            }
          },
          {
            name: 'removeAttrs',
            params: {
              attrs: 'stroke-width'
            }
          }
        ]
      }
    })
  ],
  optimizeDeps: {
    include: ['pdfjs-dist'], // optionally specify dependency name
    esbuildOptions: {
      supported: {
        'top-level-await': true
      }
    }
  },
  resolve: {
    alias: {
      '@/': fileURLToPath(new URL('./resources/js', import.meta.url))
    }
  }
})
