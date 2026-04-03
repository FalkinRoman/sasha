/**
 * Генерирует PNG для писем из SVG с локально вшитым Montserrat 600 (без Google Fonts).
 * Запуск: node scripts/export-wordmark-email-png.mjs
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, '..');
const fontPath = path.join(
    root,
    'node_modules/@fontsource/montserrat/files/montserrat-latin-600-normal.woff2',
);
const outDir = path.join(root, 'public/brand');

const fontB64 = fs.readFileSync(fontPath).toString('base64');

function buildSvg(width, height) {
    return `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 200" width="${width}" height="${height}">
  <defs>
    <style type="text/css"><![CDATA[
      @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 600;
        font-display: block;
        src: url('data:font/woff2;base64,${fontB64}') format('woff2');
      }
    ]]></style>
  </defs>
  <rect width="640" height="200" fill="#fffffa"/>
  <text x="320" y="118" text-anchor="middle" font-family="Montserrat, sans-serif" font-size="52" font-weight="600" letter-spacing="-0.02em" fill="#0f0f0f">Prosto.<tspan fill="#c8e650">Yoga</tspan></text>
</svg>`;
}

const sizes = [
    { w: 1280, h: 400, file: 'wordmark-email-1280.png' },
    { w: 1920, h: 600, file: 'wordmark-email-1920.png' },
];

for (const { w, h, file } of sizes) {
    const svg = buildSvg(w, h);
    const buf = await sharp(Buffer.from(svg)).png({ compressionLevel: 9 }).toBuffer();
    fs.writeFileSync(path.join(outDir, file), buf);
    console.log('Wrote', file, `(${w}×${h})`);
}
