import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  // server: {
  //   port: 3000,
  //   // proxy: {
  //   //   port: 3000,
  //   //   // '/api': 'http://localhost:8000'
  //   // }
  // },
  plugins: [react()],
  server: {
    host: 'localhost',
    port: 3000,
    proxy: {
      '/api': 'http://localhost:8000',
      // changeOrigin: true,
      // secure: false,
    }
  }
})
