# Carlos Ferrer — Portfolio

Portfolio personal exportado como HTML/CSS/JS plano.

## Estructura

- `index.html` — punto de entrada
- `styles.css` — estilos completos (con responsive, dark/light, retro 90s)
- `app.js` — todo el JavaScript ya compilado (sin JSX, sin Babel)
- `assets/carlos.jpg` — foto de perfil

## Cómo usarlo

Solo abrí `index.html` en un navegador. Necesita conexión la primera vez para cargar React desde CDN; después queda en caché.

Si querés servirlo con un servidor local:

```
npx serve .
# o
python3 -m http.server 8000
```

## Tecnologías

- React 18 (vía CDN)
- CSS puro con custom properties
- LocalStorage para preferencias (idioma, tema, visitas)

## Tips

- Probá el código Konami: ↑↑↓↓←→←→BA
- Toggle de idioma ES/EN en el nav
- Toggle de tema oscuro/claro
- Panel de Tweaks (cuando lo activás desde la barra)

— acenagadev