/**
 * PNG монограмма PY как в public/favicon.svg (Montserrat 700, белый фон, скругление).
 * Запуск: node scripts/export-favicon-png.mjs
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, '..');
const fontPath = path.join(
    root,
    'node_modules/@fontsource/montserrat/files/montserrat-latin-700-normal.woff2',
);
const outDir = path.join(root, 'public/brand');

const fontB64 = fs.readFileSync(fontPath).toString('base64');

/** viewBox 64×64, масштаб до px×px */
function buildSvg(px) {
    return `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="${px}" height="${px}">
  <defs>
    <style type="text/css"><![CDATA[
      @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 700;
        font-display: block;
        src: url('data:font/woff2;base64,${fontB64}') format('woff2');
      }
    ]]></style>
  </defs>
  <rect width="64" height="64" rx="14" fill="#ffffff"/>
  <text x="32" y="42" text-anchor="middle" font-family="Montserrat, sans-serif" font-weight="700" font-size="27" letter-spacing="-0.07em">
    <tspan fill="#0f0f0f">P</tspan><tspan fill="#c8e650">Y</tspan>
  </text>
</svg>`;
}

const sizes = [64, 128, 256, 512];

for (const px of sizes) {
    const svg = buildSvg(px);
    const file = `favicon-py-${px}.png`;
    const buf = await sharp(Buffer.from(svg)).png({ compressionLevel: 9 }).toBuffer();
    fs.writeFileSync(path.join(outDir, file), buf);
    console.log('Wrote', file, `(${px}×${px})`);
}
