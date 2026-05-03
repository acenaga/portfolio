/* === Compiled from JSX — Carlos Ferrer Portfolio === */
/* Hooks aliases declared once for all files. */
const { useState, useEffect, useRef, useMemo, useCallback, useLayoutEffect, useReducer, Fragment } = React;


/* ============ tweaks-panel.jsx ============ */
// tweaks-panel.jsx
// Reusable Tweaks shell + form-control helpers.
//
// Owns the host protocol (listens for __activate_edit_mode / __deactivate_edit_mode,
// posts __edit_mode_available / __edit_mode_set_keys / __edit_mode_dismissed) so
// individual prototypes don't re-roll it. Ships a consistent set of controls so you
// don't hand-draw <input type="range">, segmented radios, steppers, etc.
//
// Usage (in an HTML file that loads React + Babel):
//
//   const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
//     "primaryColor": "#D97757",
//     "fontSize": 16,
//     "density": "regular",
//     "dark": false
//   }/*EDITMODE-END*/;
//
//   function App() {
//     const [t, setTweak] = useTweaks(TWEAK_DEFAULTS);
//     return (
//       <div style={{ fontSize: t.fontSize, color: t.primaryColor }}>
//         Hello
//         <TweaksPanel>
//           <TweakSection label="Typography" />
//           <TweakSlider label="Font size" value={t.fontSize} min={10} max={32} unit="px"
//                        onChange={(v) => setTweak('fontSize', v)} />
//           <TweakRadio  label="Density" value={t.density}
//                        options={['compact', 'regular', 'comfy']}
//                        onChange={(v) => setTweak('density', v)} />
//           <TweakSection label="Theme" />
//           <TweakColor  label="Primary" value={t.primaryColor}
//                        onChange={(v) => setTweak('primaryColor', v)} />
//           <TweakToggle label="Dark mode" value={t.dark}
//                        onChange={(v) => setTweak('dark', v)} />
//         </TweaksPanel>
//       </div>
//     );
//   }
//
// ─────────────────────────────────────────────────────────────────────────────

const __TWEAKS_STYLE = `
  .twk-panel{position:fixed;right:16px;bottom:16px;z-index:2147483646;width:280px;
    max-height:calc(100vh - 32px);display:flex;flex-direction:column;
    background:rgba(250,249,247,.78);color:#29261b;
    -webkit-backdrop-filter:blur(24px) saturate(160%);backdrop-filter:blur(24px) saturate(160%);
    border:.5px solid rgba(255,255,255,.6);border-radius:14px;
    box-shadow:0 1px 0 rgba(255,255,255,.5) inset,0 12px 40px rgba(0,0,0,.18);
    font:11.5px/1.4 ui-sans-serif,system-ui,-apple-system,sans-serif;overflow:hidden}
  .twk-hd{display:flex;align-items:center;justify-content:space-between;
    padding:10px 8px 10px 14px;cursor:move;user-select:none}
  .twk-hd b{font-size:12px;font-weight:600;letter-spacing:.01em}
  .twk-x{appearance:none;border:0;background:transparent;color:rgba(41,38,27,.55);
    width:22px;height:22px;border-radius:6px;cursor:default;font-size:13px;line-height:1}
  .twk-x:hover{background:rgba(0,0,0,.06);color:#29261b}
  .twk-body{padding:2px 14px 14px;display:flex;flex-direction:column;gap:10px;
    overflow-y:auto;overflow-x:hidden;min-height:0;
    scrollbar-width:thin;scrollbar-color:rgba(0,0,0,.15) transparent}
  .twk-body::-webkit-scrollbar{width:8px}
  .twk-body::-webkit-scrollbar-track{background:transparent;margin:2px}
  .twk-body::-webkit-scrollbar-thumb{background:rgba(0,0,0,.15);border-radius:4px;
    border:2px solid transparent;background-clip:content-box}
  .twk-body::-webkit-scrollbar-thumb:hover{background:rgba(0,0,0,.25);
    border:2px solid transparent;background-clip:content-box}
  .twk-row{display:flex;flex-direction:column;gap:5px}
  .twk-row-h{flex-direction:row;align-items:center;justify-content:space-between;gap:10px}
  .twk-lbl{display:flex;justify-content:space-between;align-items:baseline;
    color:rgba(41,38,27,.72)}
  .twk-lbl>span:first-child{font-weight:500}
  .twk-val{color:rgba(41,38,27,.5);font-variant-numeric:tabular-nums}

  .twk-sect{font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;
    color:rgba(41,38,27,.45);padding:10px 0 0}
  .twk-sect:first-child{padding-top:0}

  .twk-field{appearance:none;width:100%;height:26px;padding:0 8px;
    border:.5px solid rgba(0,0,0,.1);border-radius:7px;
    background:rgba(255,255,255,.6);color:inherit;font:inherit;outline:none}
  .twk-field:focus{border-color:rgba(0,0,0,.25);background:rgba(255,255,255,.85)}
  select.twk-field{padding-right:22px;
    background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'><path fill='rgba(0,0,0,.5)' d='M0 0h10L5 6z'/></svg>");
    background-repeat:no-repeat;background-position:right 8px center}

  .twk-slider{appearance:none;-webkit-appearance:none;width:100%;height:4px;margin:6px 0;
    border-radius:999px;background:rgba(0,0,0,.12);outline:none}
  .twk-slider::-webkit-slider-thumb{-webkit-appearance:none;appearance:none;
    width:14px;height:14px;border-radius:50%;background:#fff;
    border:.5px solid rgba(0,0,0,.12);box-shadow:0 1px 3px rgba(0,0,0,.2);cursor:default}
  .twk-slider::-moz-range-thumb{width:14px;height:14px;border-radius:50%;
    background:#fff;border:.5px solid rgba(0,0,0,.12);box-shadow:0 1px 3px rgba(0,0,0,.2);cursor:default}

  .twk-seg{position:relative;display:flex;padding:2px;border-radius:8px;
    background:rgba(0,0,0,.06);user-select:none}
  .twk-seg-thumb{position:absolute;top:2px;bottom:2px;border-radius:6px;
    background:rgba(255,255,255,.9);box-shadow:0 1px 2px rgba(0,0,0,.12);
    transition:left .15s cubic-bezier(.3,.7,.4,1),width .15s}
  .twk-seg.dragging .twk-seg-thumb{transition:none}
  .twk-seg button{appearance:none;position:relative;z-index:1;flex:1;border:0;
    background:transparent;color:inherit;font:inherit;font-weight:500;min-height:22px;
    border-radius:6px;cursor:default;padding:4px 6px;line-height:1.2;
    overflow-wrap:anywhere}

  .twk-toggle{position:relative;width:32px;height:18px;border:0;border-radius:999px;
    background:rgba(0,0,0,.15);transition:background .15s;cursor:default;padding:0}
  .twk-toggle[data-on="1"]{background:#34c759}
  .twk-toggle i{position:absolute;top:2px;left:2px;width:14px;height:14px;border-radius:50%;
    background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.25);transition:transform .15s}
  .twk-toggle[data-on="1"] i{transform:translateX(14px)}

  .twk-num{display:flex;align-items:center;height:26px;padding:0 0 0 8px;
    border:.5px solid rgba(0,0,0,.1);border-radius:7px;background:rgba(255,255,255,.6)}
  .twk-num-lbl{font-weight:500;color:rgba(41,38,27,.6);cursor:ew-resize;
    user-select:none;padding-right:8px}
  .twk-num input{flex:1;min-width:0;height:100%;border:0;background:transparent;
    font:inherit;font-variant-numeric:tabular-nums;text-align:right;padding:0 8px 0 0;
    outline:none;color:inherit;-moz-appearance:textfield}
  .twk-num input::-webkit-inner-spin-button,.twk-num input::-webkit-outer-spin-button{
    -webkit-appearance:none;margin:0}
  .twk-num-unit{padding-right:8px;color:rgba(41,38,27,.45)}

  .twk-btn{appearance:none;height:26px;padding:0 12px;border:0;border-radius:7px;
    background:rgba(0,0,0,.78);color:#fff;font:inherit;font-weight:500;cursor:default}
  .twk-btn:hover{background:rgba(0,0,0,.88)}
  .twk-btn.secondary{background:rgba(0,0,0,.06);color:inherit}
  .twk-btn.secondary:hover{background:rgba(0,0,0,.1)}

  .twk-swatch{appearance:none;-webkit-appearance:none;width:56px;height:22px;
    border:.5px solid rgba(0,0,0,.1);border-radius:6px;padding:0;cursor:default;
    background:transparent;flex-shrink:0}
  .twk-swatch::-webkit-color-swatch-wrapper{padding:0}
  .twk-swatch::-webkit-color-swatch{border:0;border-radius:5.5px}
  .twk-swatch::-moz-color-swatch{border:0;border-radius:5.5px}
`;

// ── useTweaks ───────────────────────────────────────────────────────────────
// Single source of truth for tweak values. setTweak persists via the host
// (__edit_mode_set_keys → host rewrites the EDITMODE block on disk).
function useTweaks(defaults) {
  const [values, setValues] = React.useState(defaults);
  // Accepts either setTweak('key', value) or setTweak({ key: value, ... }) so a
  // useState-style call doesn't write a "[object Object]" key into the persisted
  // JSON block.
  const setTweak = React.useCallback((keyOrEdits, val) => {
    const edits = typeof keyOrEdits === 'object' && keyOrEdits !== null ? keyOrEdits : {
      [keyOrEdits]: val
    };
    setValues(prev => ({
      ...prev,
      ...edits
    }));
    window.parent.postMessage({
      type: '__edit_mode_set_keys',
      edits
    }, '*');
  }, []);
  return [values, setTweak];
}

// ── TweaksPanel ─────────────────────────────────────────────────────────────
// Floating shell. Registers the protocol listener BEFORE announcing
// availability — if the announce ran first, the host's activate could land
// before our handler exists and the toolbar toggle would silently no-op.
// The close button posts __edit_mode_dismissed so the host's toolbar toggle
// flips off in lockstep; the host echoes __deactivate_edit_mode back which
// is what actually hides the panel.
function TweaksPanel({
  title = 'Tweaks',
  children
}) {
  const [open, setOpen] = React.useState(false);
  const dragRef = React.useRef(null);
  const offsetRef = React.useRef({
    x: 16,
    y: 16
  });
  const PAD = 16;
  const clampToViewport = React.useCallback(() => {
    const panel = dragRef.current;
    if (!panel) return;
    const w = panel.offsetWidth,
      h = panel.offsetHeight;
    const maxRight = Math.max(PAD, window.innerWidth - w - PAD);
    const maxBottom = Math.max(PAD, window.innerHeight - h - PAD);
    offsetRef.current = {
      x: Math.min(maxRight, Math.max(PAD, offsetRef.current.x)),
      y: Math.min(maxBottom, Math.max(PAD, offsetRef.current.y))
    };
    panel.style.right = offsetRef.current.x + 'px';
    panel.style.bottom = offsetRef.current.y + 'px';
  }, []);
  React.useEffect(() => {
    if (!open) return;
    clampToViewport();
    if (typeof ResizeObserver === 'undefined') {
      window.addEventListener('resize', clampToViewport);
      return () => window.removeEventListener('resize', clampToViewport);
    }
    const ro = new ResizeObserver(clampToViewport);
    ro.observe(document.documentElement);
    return () => ro.disconnect();
  }, [open, clampToViewport]);
  React.useEffect(() => {
    const onMsg = e => {
      const t = e?.data?.type;
      if (t === '__activate_edit_mode') setOpen(true);else if (t === '__deactivate_edit_mode') setOpen(false);
    };
    window.addEventListener('message', onMsg);
    window.parent.postMessage({
      type: '__edit_mode_available'
    }, '*');
    return () => window.removeEventListener('message', onMsg);
  }, []);
  const dismiss = () => {
    setOpen(false);
    window.parent.postMessage({
      type: '__edit_mode_dismissed'
    }, '*');
  };
  const onDragStart = e => {
    const panel = dragRef.current;
    if (!panel) return;
    const r = panel.getBoundingClientRect();
    const sx = e.clientX,
      sy = e.clientY;
    const startRight = window.innerWidth - r.right;
    const startBottom = window.innerHeight - r.bottom;
    const move = ev => {
      offsetRef.current = {
        x: startRight - (ev.clientX - sx),
        y: startBottom - (ev.clientY - sy)
      };
      clampToViewport();
    };
    const up = () => {
      window.removeEventListener('mousemove', move);
      window.removeEventListener('mouseup', up);
    };
    window.addEventListener('mousemove', move);
    window.addEventListener('mouseup', up);
  };
  if (!open) return null;
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("style", null, __TWEAKS_STYLE), /*#__PURE__*/React.createElement("div", {
    ref: dragRef,
    className: "twk-panel",
    style: {
      right: offsetRef.current.x,
      bottom: offsetRef.current.y
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-hd",
    onMouseDown: onDragStart
  }, /*#__PURE__*/React.createElement("b", null, title), /*#__PURE__*/React.createElement("button", {
    className: "twk-x",
    "aria-label": "Close tweaks",
    onMouseDown: e => e.stopPropagation(),
    onClick: dismiss
  }, "\u2715")), /*#__PURE__*/React.createElement("div", {
    className: "twk-body"
  }, children)));
}

// ── Layout helpers ──────────────────────────────────────────────────────────

function TweakSection({
  label,
  children
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: "twk-sect"
  }, label), children);
}
function TweakRow({
  label,
  value,
  children,
  inline = false
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: inline ? 'twk-row twk-row-h' : 'twk-row'
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-lbl"
  }, /*#__PURE__*/React.createElement("span", null, label), value != null && /*#__PURE__*/React.createElement("span", {
    className: "twk-val"
  }, value)), children);
}

// ── Controls ────────────────────────────────────────────────────────────────

function TweakSlider({
  label,
  value,
  min = 0,
  max = 100,
  step = 1,
  unit = '',
  onChange
}) {
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label,
    value: `${value}${unit}`
  }, /*#__PURE__*/React.createElement("input", {
    type: "range",
    className: "twk-slider",
    min: min,
    max: max,
    step: step,
    value: value,
    onChange: e => onChange(Number(e.target.value))
  }));
}
function TweakToggle({
  label,
  value,
  onChange
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: "twk-row twk-row-h"
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-lbl"
  }, /*#__PURE__*/React.createElement("span", null, label)), /*#__PURE__*/React.createElement("button", {
    type: "button",
    className: "twk-toggle",
    "data-on": value ? '1' : '0',
    role: "switch",
    "aria-checked": !!value,
    onClick: () => onChange(!value)
  }, /*#__PURE__*/React.createElement("i", null)));
}
function TweakRadio({
  label,
  value,
  options,
  onChange
}) {
  const trackRef = React.useRef(null);
  const [dragging, setDragging] = React.useState(false);
  const opts = options.map(o => typeof o === 'object' ? o : {
    value: o,
    label: o
  });
  const idx = Math.max(0, opts.findIndex(o => o.value === value));
  const n = opts.length;

  // The active value is read by pointer-move handlers attached for the lifetime
  // of a drag — ref it so a stale closure doesn't fire onChange for every move.
  const valueRef = React.useRef(value);
  valueRef.current = value;
  const segAt = clientX => {
    const r = trackRef.current.getBoundingClientRect();
    const inner = r.width - 4;
    const i = Math.floor((clientX - r.left - 2) / inner * n);
    return opts[Math.max(0, Math.min(n - 1, i))].value;
  };
  const onPointerDown = e => {
    setDragging(true);
    const v0 = segAt(e.clientX);
    if (v0 !== valueRef.current) onChange(v0);
    const move = ev => {
      if (!trackRef.current) return;
      const v = segAt(ev.clientX);
      if (v !== valueRef.current) onChange(v);
    };
    const up = () => {
      setDragging(false);
      window.removeEventListener('pointermove', move);
      window.removeEventListener('pointerup', up);
    };
    window.addEventListener('pointermove', move);
    window.addEventListener('pointerup', up);
  };
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("div", {
    ref: trackRef,
    role: "radiogroup",
    onPointerDown: onPointerDown,
    className: dragging ? 'twk-seg dragging' : 'twk-seg'
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-seg-thumb",
    style: {
      left: `calc(2px + ${idx} * (100% - 4px) / ${n})`,
      width: `calc((100% - 4px) / ${n})`
    }
  }), opts.map(o => /*#__PURE__*/React.createElement("button", {
    key: o.value,
    type: "button",
    role: "radio",
    "aria-checked": o.value === value
  }, o.label))));
}
function TweakSelect({
  label,
  value,
  options,
  onChange
}) {
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("select", {
    className: "twk-field",
    value: value,
    onChange: e => onChange(e.target.value)
  }, options.map(o => {
    const v = typeof o === 'object' ? o.value : o;
    const l = typeof o === 'object' ? o.label : o;
    return /*#__PURE__*/React.createElement("option", {
      key: v,
      value: v
    }, l);
  })));
}
function TweakText({
  label,
  value,
  placeholder,
  onChange
}) {
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("input", {
    className: "twk-field",
    type: "text",
    value: value,
    placeholder: placeholder,
    onChange: e => onChange(e.target.value)
  }));
}
function TweakNumber({
  label,
  value,
  min,
  max,
  step = 1,
  unit = '',
  onChange
}) {
  const clamp = n => {
    if (min != null && n < min) return min;
    if (max != null && n > max) return max;
    return n;
  };
  const startRef = React.useRef({
    x: 0,
    val: 0
  });
  const onScrubStart = e => {
    e.preventDefault();
    startRef.current = {
      x: e.clientX,
      val: value
    };
    const decimals = (String(step).split('.')[1] || '').length;
    const move = ev => {
      const dx = ev.clientX - startRef.current.x;
      const raw = startRef.current.val + dx * step;
      const snapped = Math.round(raw / step) * step;
      onChange(clamp(Number(snapped.toFixed(decimals))));
    };
    const up = () => {
      window.removeEventListener('pointermove', move);
      window.removeEventListener('pointerup', up);
    };
    window.addEventListener('pointermove', move);
    window.addEventListener('pointerup', up);
  };
  return /*#__PURE__*/React.createElement("div", {
    className: "twk-num"
  }, /*#__PURE__*/React.createElement("span", {
    className: "twk-num-lbl",
    onPointerDown: onScrubStart
  }, label), /*#__PURE__*/React.createElement("input", {
    type: "number",
    value: value,
    min: min,
    max: max,
    step: step,
    onChange: e => onChange(clamp(Number(e.target.value)))
  }), unit && /*#__PURE__*/React.createElement("span", {
    className: "twk-num-unit"
  }, unit));
}
function TweakColor({
  label,
  value,
  onChange
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: "twk-row twk-row-h"
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-lbl"
  }, /*#__PURE__*/React.createElement("span", null, label)), /*#__PURE__*/React.createElement("input", {
    type: "color",
    className: "twk-swatch",
    value: value,
    onChange: e => onChange(e.target.value)
  }));
}
function TweakButton({
  label,
  onClick,
  secondary = false
}) {
  return /*#__PURE__*/React.createElement("button", {
    type: "button",
    className: secondary ? 'twk-btn secondary' : 'twk-btn',
    onClick: onClick
  }, label);
}
Object.assign(window, {
  useTweaks,
  TweaksPanel,
  TweakSection,
  TweakRow,
  TweakSlider,
  TweakToggle,
  TweakRadio,
  TweakSelect,
  TweakText,
  TweakNumber,
  TweakColor,
  TweakButton
});

/* ============ data.jsx ============ */
// =================================================================
// data.jsx — All content (bilingual ES/EN)
// =================================================================

const I18N = {
  es: {
    // nav
    navAbout: 'Sobre mí',
    navStack: 'Stack',
    navClasses: 'Materias',
    navProjects: 'Proyectos',
    navBlog: 'Blog',
    navInstagram: 'Instagram',
    navYoutube: 'YouTube',
    navTwitch: 'Twitch',
    navVideos: 'Videos',
    navContact: 'Contacto',
    // hero
    heroEyebrow: '// Carlos Ferrer · @acenagadev',
    heroLocation: 'Buenos Aires, Argentina',
    heroAvailability: 'Disponible para charlas, mentorías y caos creativo',
    heroCtaPrimary: 'Sígueme en YouTube',
    heroCtaSecondary: 'Ver mis materias',
    heroStatusOn: 'EN_LINEA',
    // about
    aboutEyebrow: 'Sobre mí',
    aboutTitle: '<em>10+ años</em> haciendo que el código tenga sentido (y un poco de gracia).',
    aboutP1: 'Me apasiona el desarrollo web por la posibilidad de construir lo que otros sueñan. Llevo más de una década en este mundo y todavía me emociono cuando algo finalmente compila.',
    aboutP2: 'Soy profesor en DaVinci, donde mi misión es bajar el conocimiento complejo a palabras humanas — para que clientes entiendan qué se va a construir y mis alumnos sientan que esto no es magia inalcanzable.',
    aboutP3: 'Como creador de contenido muestro la realidad del desarrollo: los errores, las soluciones a las 3 a.m., el síndrome del impostor y, sí, también las victorias. Todo aderezado con humor, porque si no nos reímos, ¿qué estamos haciendo?',
    statYears: 'AÑOS DE EXPERIENCIA',
    statStudents: 'ESTUDIANTES',
    statProjects: 'PROYECTOS',
    statCoffee: 'CAFÉS',
    // stack
    stackEyebrow: 'Stack técnico',
    stackTitle: 'Las herramientas con las que <em>realmente</em> trabajo',
    stackSubtitle: 'No es una lista de buzzwords, es lo que uso a diario.',
    // classes
    classesEyebrow: 'Docencia · Escuela DaVinci',
    classesTitle: 'Las <em>materias</em> que enseño',
    classesSubtitle: 'Seis materias, un mismo objetivo: que salgas pudiendo construir cosas reales.',
    // projects
    projectsEyebrow: 'Proyectos seleccionados',
    projectsTitle: 'Cosas que <em>construí</em> y todavía duermen tranquilas',
    projectsSubtitle: 'Una selección de trabajos en producción.',
    // blog
    blogEyebrow: 'Entradas',
    blogTitle: 'Cosas que <em>escribo</em> cuando no estoy frente a una clase',
    blogSubtitle: 'Notas, tutoriales y reflexiones sobre desarrollo, IA y enseñanza.',
    blogReadMore: 'Leer más',
    // instagram
    igEyebrow: '@acenaga.dev',
    igTitle: 'Últimos posts en <em>Instagram</em>',
    igSubtitle: 'Reels, carruseles educativos y momentos detrás de cámara.',
    igFollow: 'Seguir en Instagram',
    // youtube
    ytEyebrow: '@acenagadev',
    ytTitle: 'Últimos videos en <em>YouTube</em>',
    ytSubtitle: 'Tutoriales, cursos y streams sobre Laravel, IA y desarrollo web.',
    ytSubscribe: 'Suscribirse',
    // twitch
    twEyebrow: 'twitch.tv/acenagadev',
    twTitle: 'Últimos streams en <em>Twitch</em>',
    twSubtitle: 'Coding en vivo, debugging en público y charla sobre código, IA y café.',
    twFollow: 'Seguir en Twitch',
    twLive: 'EN VIVO',
    twVod: 'VOD',
    // social
    socialEyebrow: 'Conectemos',
    socialTitle: 'Donde <em>vivo</em> el resto del tiempo',
    socialSubtitle: 'Si te gustó algo, me encuentras aquí.',
    // footer
    footerMade: 'Hecho con Laravel mental, café y mucho amor en Buenos Aires',
    footerCopy: '© 2026 Carlos Ferrer · acenagadev',
    footerVisitor: 'Visitante'
  },
  en: {
    navAbout: 'About',
    navStack: 'Stack',
    navClasses: 'Classes',
    navProjects: 'Projects',
    navBlog: 'Blog',
    navInstagram: 'Instagram',
    navYoutube: 'YouTube',
    navTwitch: 'Twitch',
    navVideos: 'Videos',
    navContact: 'Contact',
    heroEyebrow: '// Carlos Ferrer · @acenagadev',
    heroLocation: 'Buenos Aires, Argentina',
    heroAvailability: 'Available for talks, mentorships and creative chaos',
    heroCtaPrimary: 'Follow me on YouTube',
    heroCtaSecondary: 'See my classes',
    heroStatusOn: 'ONLINE',
    aboutEyebrow: 'About',
    aboutTitle: '<em>10+ years</em> making code make sense (with a bit of humor).',
    aboutP1: "I'm passionate about web development because of the chance to build what others only dream of. After a decade in this world, I still get excited when something finally compiles.",
    aboutP2: "I teach at DaVinci, where my mission is to translate complex knowledge into human words — so clients understand what's being built and my students feel programming isn't unreachable magic.",
    aboutP3: "As a content creator I show the real side of dev work: the bugs, the 3 a.m. fixes, the impostor syndrome and, yes, the wins too. All seasoned with humor — because if we don't laugh, what are we even doing?",
    statYears: 'YEARS OF EXPERIENCE',
    statStudents: 'STUDENTS',
    statProjects: 'PROJECTS',
    statCoffee: 'COFFEES',
    stackEyebrow: 'Tech stack',
    stackTitle: 'The tools I <em>actually</em> work with',
    stackSubtitle: "Not a buzzword list — what I use every day.",
    classesEyebrow: 'Teaching · DaVinci School',
    classesTitle: 'The <em>classes</em> I teach',
    classesSubtitle: 'Six subjects, one goal: that you walk out building real things.',
    projectsEyebrow: 'Selected projects',
    projectsTitle: "Things I've <em>built</em> that still sleep peacefully",
    projectsSubtitle: 'A selection of production work.',
    blogEyebrow: 'Posts',
    blogTitle: 'What I <em>write</em> when not in a classroom',
    blogSubtitle: 'Notes, tutorials and thoughts on dev, AI and teaching.',
    blogReadMore: 'Read more',
    igEyebrow: '@acenaga.dev',
    igTitle: 'Latest <em>Instagram</em> posts',
    igSubtitle: 'Reels, carousels and behind-the-scenes moments.',
    igFollow: 'Follow on Instagram',
    ytEyebrow: '@acenagadev',
    ytTitle: 'Latest <em>YouTube</em> videos',
    ytSubtitle: 'Tutorials, courses and streams on Laravel, AI and web dev.',
    ytSubscribe: 'Subscribe',
    twEyebrow: 'twitch.tv/acenagadev',
    twTitle: 'Latest <em>Twitch</em> streams',
    twSubtitle: 'Live coding, debugging in public and conversation about code, AI and coffee.',
    twFollow: 'Follow on Twitch',
    twLive: 'LIVE',
    twVod: 'VOD',
    socialEyebrow: "Let's connect",
    socialTitle: 'Where I <em>live</em> the rest of the time',
    socialSubtitle: 'If you liked something, you can find me here.',
    footerMade: 'Made with mental Laravel, coffee and a lot of love in Buenos Aires',
    footerCopy: '© 2026 Carlos Ferrer · acenagadev',
    footerVisitor: 'Visitor'
  }
};

// =================================================================
// DATA — content blocks shared across languages
// =================================================================

const STATS = [{
  num: '10+',
  key: 'statYears'
}, {
  num: '500+',
  key: 'statStudents'
}, {
  num: '50+',
  key: 'statProjects'
}, {
  num: '∞',
  key: 'statCoffee'
}];
const STACK = [{
  name: 'Laravel',
  icon: '🅻',
  tier: 'main'
}, {
  name: 'PHP',
  icon: '🐘',
  tier: 'main'
}, {
  name: 'Vue.js',
  icon: '△',
  tier: 'main'
}, {
  name: 'Livewire',
  icon: '⚡',
  tier: 'main'
}, {
  name: 'JavaScript',
  icon: '{ }',
  tier: 'main'
}, {
  name: 'HTML',
  icon: '< >',
  tier: 'main'
}, {
  name: 'CSS',
  icon: '#',
  tier: 'main'
}, {
  name: 'Bootstrap',
  icon: 'B',
  tier: 'main'
}, {
  name: 'Alpine.js',
  icon: '⛰',
  tier: 'second'
}, {
  name: 'Tailwind',
  icon: '~',
  tier: 'second'
}, {
  name: 'WordPress',
  icon: 'W',
  tier: 'second'
}, {
  name: 'MySQL',
  icon: '◆',
  tier: 'second'
}, {
  name: 'Git',
  icon: '⎇',
  tier: 'second'
}, {
  name: 'Figma',
  icon: '◐',
  tier: 'second'
}, {
  name: 'OpenAI API',
  icon: '✦',
  tier: 'second'
}, {
  name: 'Vite',
  icon: '⚡',
  tier: 'second'
}];
const STACK_MARQUEE = ['LARAVEL', 'PHP', 'VUE.JS', 'LIVEWIRE', 'JAVASCRIPT', 'BOOTSTRAP', 'WORDPRESS', 'TAILWIND', 'IA', 'OPENAI', 'GIT', 'MYSQL'];
const CLASSES = {
  es: [{
    title: 'Maquetado y Desarrollo Web',
    tag: 'HTML · CSS',
    level: 'Inicial',
    hours: '64hs',
    desc: 'Los cimientos de todo. Aprendemos a estructurar contenido con HTML semántico y a darle vida con CSS moderno: flexbox, grid, animaciones y diseño responsive sin frameworks.'
  }, {
    title: 'Programación I',
    tag: 'JavaScript',
    level: 'Inicial',
    hours: '64hs',
    desc: 'Tu primer "hola mundo" que en realidad responde. Variables, condicionales, funciones, DOM y eventos. Salimos pudiendo construir interactividad real en el navegador.'
  }, {
    title: 'Programación con Entornos',
    tag: 'WordPress',
    level: 'Intermedio',
    hours: '64hs',
    desc: 'WordPress sin miedo: temas hijos, custom post types, hooks y un poquito de plugin propio. Salís pudiendo entregar sitios profesionales y mantenibles.'
  }, {
    title: 'Portales y Comercio Electrónico',
    tag: 'Laravel',
    level: 'Intermedio',
    hours: '96hs',
    desc: 'Construimos un e-commerce real con Laravel: catálogos, carrito, pagos, panel admin. Buenas prácticas, MVC, Eloquent y mucho debugging compartido.'
  }, {
    title: 'Aplicaciones Web Progresivas',
    tag: 'JavaScript',
    level: 'Avanzado',
    hours: '64hs',
    desc: 'PWAs en serio. Service workers, cache estratégica, instalación, push notifications y todo lo que hace que tu web se sienta como una app nativa.'
  }, {
    title: 'Producción Web',
    tag: 'Laravel',
    level: 'Avanzado',
    hours: '96hs',
    desc: 'Cómo se hace en la vida real: deploy, testing, queues, jobs, APIs, autenticación robusta y patrones de arquitectura para apps que no se rompan en producción.'
  }],
  en: [{
    title: 'Markup & Web Development',
    tag: 'HTML · CSS',
    level: 'Beginner',
    hours: '64h',
    desc: 'The foundation of everything. Semantic HTML structure plus modern CSS: flexbox, grid, animations and responsive design without frameworks.'
  }, {
    title: 'Programming I',
    tag: 'JavaScript',
    level: 'Beginner',
    hours: '64h',
    desc: "Your first 'hello world' that actually responds back. Variables, conditionals, functions, DOM and events. You leave able to build real browser interactivity."
  }, {
    title: 'Programming Environments',
    tag: 'WordPress',
    level: 'Intermediate',
    hours: '64h',
    desc: 'WordPress without fear: child themes, custom post types, hooks and a bit of custom plugin work. You finish able to ship professional, maintainable sites.'
  }, {
    title: 'Portals & E-commerce',
    tag: 'Laravel',
    level: 'Intermediate',
    hours: '96h',
    desc: 'We build a real e-commerce with Laravel: catalogs, cart, payments, admin panel. Best practices, MVC, Eloquent and lots of shared debugging.'
  }, {
    title: 'Progressive Web Apps',
    tag: 'JavaScript',
    level: 'Advanced',
    hours: '64h',
    desc: 'Serious PWAs. Service workers, strategic caching, install prompts, push notifications and everything that makes a web feel like a native app.'
  }, {
    title: 'Web Production',
    tag: 'Laravel',
    level: 'Advanced',
    hours: '96h',
    desc: 'How real life looks: deploy, testing, queues, jobs, APIs, robust auth and architecture patterns for apps that hold up in production.'
  }]
};
const PROJECTS = {
  es: [{
    name: 'Mentoría Bot',
    tags: ['Laravel', 'OpenAI', 'Livewire'],
    color: '#ffc932',
    bg: '#110090',
    icon: '🤖',
    desc: 'Asistente con IA que ayuda a alumnos a debuggear código en tiempo real. Detecta intenciones del estudiante y devuelve explicaciones, no soluciones.',
    url: '#'
  }, {
    name: 'Cursos.dev',
    tags: ['Laravel', 'Vue', 'MySQL'],
    color: '#110090',
    bg: '#fbdc6d',
    icon: '🎓',
    desc: 'Plataforma de cursos online en español con video, transcripciones, ejercicios autocorregidos y comunidad. Más de 2.000 estudiantes activos.',
    url: '#'
  }, {
    name: 'StreamHub LATAM',
    tags: ['Vue', 'Tailwind', 'API'],
    color: '#fbdc6d',
    bg: '#4c2e84',
    icon: '📡',
    desc: 'Dashboard que agrega streams de Twitch, YouTube y Kick de devs hispanohablantes. Útil para descubrir contenido y ver quién está en vivo.',
    url: '#'
  }, {
    name: 'CodeRoast',
    tags: ['Livewire', 'Alpine', 'IA'],
    color: '#5f3a92',
    bg: '#ffc932',
    icon: '🔥',
    desc: 'Subes un snippet de código y la IA lo "roastea" con humor mientras te enseña qué se puede mejorar. Un proyecto pasión que se volvió viral.',
    url: '#'
  }],
  en: [{
    name: 'Mentor Bot',
    tags: ['Laravel', 'OpenAI', 'Livewire'],
    color: '#ffc932',
    bg: '#110090',
    icon: '🤖',
    desc: 'AI assistant helping students debug code in real time. Detects student intent and returns explanations — not just answers.',
    url: '#'
  }, {
    name: 'Cursos.dev',
    tags: ['Laravel', 'Vue', 'MySQL'],
    color: '#110090',
    bg: '#fbdc6d',
    icon: '🎓',
    desc: 'Spanish-language online course platform with video, transcripts, auto-graded exercises and community. 2,000+ active students.',
    url: '#'
  }, {
    name: 'StreamHub LATAM',
    tags: ['Vue', 'Tailwind', 'API'],
    color: '#fbdc6d',
    bg: '#4c2e84',
    icon: '📡',
    desc: 'Dashboard aggregating Twitch, YouTube and Kick streams from Spanish-speaking devs. Discover content and see who is live now.',
    url: '#'
  }, {
    name: 'CodeRoast',
    tags: ['Livewire', 'Alpine', 'AI'],
    color: '#5f3a92',
    bg: '#ffc932',
    icon: '🔥',
    desc: "Upload a code snippet and the AI 'roasts' it with humor while teaching what to improve. A passion project that went viral.",
    url: '#'
  }]
};
const POSTS = {
  es: [{
    cat: 'Laravel',
    date: '15 ABR 2026',
    readTime: '6 min',
    title: 'Por qué Livewire 3 cambió cómo enseño full-stack',
    excerpt: 'Un repaso honesto de cómo dejé de explicar APIs REST en clase y empecé con componentes server-side. Pros, contras y código.'
  }, {
    cat: 'Carrera',
    date: '02 ABR 2026',
    readTime: '4 min',
    title: 'El síndrome del impostor del programador (no se cura, se gestiona)',
    excerpt: 'Diez años haciendo esto y todavía dudo de mí mismo. Cómo aprendí a convivir y por qué no es solo cosa de juniors.'
  }, {
    cat: 'IA',
    date: '20 MAR 2026',
    readTime: '8 min',
    title: 'Construí mi propio Copilot con Laravel y OpenAI',
    excerpt: 'Tutorial paso a paso de cómo armar un asistente de código integrado en tu app, con streaming de respuestas y rate limiting.'
  }, {
    cat: 'Docencia',
    date: '10 MAR 2026',
    readTime: '5 min',
    title: 'Lo que aprendí enseñando a 500 alumnos',
    excerpt: 'Patrones que se repiten, las preguntas que más cuestan, y por qué a veces dejar fallar al alumno es la mejor lección.'
  }, {
    cat: 'Vue',
    date: '28 FEB 2026',
    readTime: '7 min',
    title: 'Vue 3 + Composition API: cuándo (y cuándo no) usarla',
    excerpt: 'No todo proyecto necesita la Composition API. Una guía pragmática basada en proyectos reales en producción.'
  }, {
    cat: 'Off-topic',
    date: '14 FEB 2026',
    readTime: '3 min',
    title: 'Mi setup de developer + creador de contenido',
    excerpt: 'Cámaras, micros, software, atajos de teclado y por qué uso una iluminación que parece exagerada.'
  }],
  en: [{
    cat: 'Laravel',
    date: 'APR 15 2026',
    readTime: '6 min',
    title: 'Why Livewire 3 changed how I teach full-stack',
    excerpt: 'An honest take on how I stopped explaining REST APIs in class and started with server-side components. Pros, cons and code.'
  }, {
    cat: 'Career',
    date: 'APR 2 2026',
    readTime: '4 min',
    title: "Programmer's impostor syndrome (you don't cure it, you manage it)",
    excerpt: "Ten years doing this and I still doubt myself. How I learned to live with it and why it's not just a junior thing."
  }, {
    cat: 'AI',
    date: 'MAR 20 2026',
    readTime: '8 min',
    title: 'I built my own Copilot with Laravel and OpenAI',
    excerpt: "Step-by-step tutorial: a code assistant integrated into your app, with response streaming and rate limiting."
  }, {
    cat: 'Teaching',
    date: 'MAR 10 2026',
    readTime: '5 min',
    title: 'What I learned teaching 500 students',
    excerpt: 'Recurring patterns, the questions that hurt most, and why sometimes letting students fail is the best lesson.'
  }, {
    cat: 'Vue',
    date: 'FEB 28 2026',
    readTime: '7 min',
    title: 'Vue 3 + Composition API: when (and when not) to use it',
    excerpt: 'Not every project needs the Composition API. A pragmatic guide based on real production projects.'
  }, {
    cat: 'Off-topic',
    date: 'FEB 14 2026',
    readTime: '3 min',
    title: 'My developer + creator setup',
    excerpt: "Cameras, mics, software, keyboard shortcuts and why I use lighting that looks over-the-top."
  }]
};

// IG: 12 placeholder posts with varied colors, types and stats
const IG_POSTS = [{
  type: 'reel',
  color: '#110090',
  accent: '#ffc932',
  emoji: '🎬',
  likes: '12.4K',
  cmts: '342'
}, {
  type: 'carousel',
  color: '#ffc932',
  accent: '#110090',
  emoji: '🎯',
  likes: '8.7K',
  cmts: '156'
}, {
  type: 'post',
  color: '#4c2e84',
  accent: '#fbdc6d',
  emoji: '💡',
  likes: '5.2K',
  cmts: '87'
}, {
  type: 'reel',
  color: '#fbdc6d',
  accent: '#110090',
  emoji: '⚡',
  likes: '21.8K',
  cmts: '512'
}, {
  type: 'carousel',
  color: '#5f3a92',
  accent: '#ffc932',
  emoji: '📚',
  likes: '6.4K',
  cmts: '203'
}, {
  type: 'post',
  color: '#110090',
  accent: '#fbdc6d',
  emoji: '🚀',
  likes: '9.1K',
  cmts: '178'
}, {
  type: 'reel',
  color: '#f6c745',
  accent: '#110090',
  emoji: '🔥',
  likes: '15.3K',
  cmts: '421'
}, {
  type: 'carousel',
  color: '#4c2e84',
  accent: '#ffc932',
  emoji: '🧠',
  likes: '7.8K',
  cmts: '231'
}, {
  type: 'post',
  color: '#ffc932',
  accent: '#110090',
  emoji: '😅',
  likes: '11.2K',
  cmts: '298'
}, {
  type: 'reel',
  color: '#110090',
  accent: '#fbdc6d',
  emoji: '☕',
  likes: '4.9K',
  cmts: '102'
}, {
  type: 'carousel',
  color: '#5f3a92',
  accent: '#fbdc6d',
  emoji: '✨',
  likes: '8.3K',
  cmts: '267'
}, {
  type: 'post',
  color: '#fbdc6d',
  accent: '#110090',
  emoji: '💻',
  likes: '6.7K',
  cmts: '145'
}];
const YT_VIDEOS = {
  es: [{
    featured: true,
    title: 'Curso completo de Laravel 11 desde cero (4 horas)',
    duration: '4:12:34',
    views: '142K',
    ago: 'hace 2 semanas',
    bg: '#110090',
    accent: '#ffc932',
    emoji: '🅻'
  }, {
    title: 'Construyendo un chatbot con IA en Laravel',
    duration: '38:21',
    views: '24K',
    ago: 'hace 1 mes',
    bg: '#ffc932',
    accent: '#110090',
    emoji: '🤖'
  }, {
    title: 'Livewire 3: lo que NADIE te explica',
    duration: '22:08',
    views: '67K',
    ago: 'hace 1 mes',
    bg: '#4c2e84',
    accent: '#fbdc6d',
    emoji: '⚡'
  }, {
    title: 'Mi setup de profesor + streamer en 2026',
    duration: '15:42',
    views: '18K',
    ago: 'hace 2 meses',
    bg: '#fbdc6d',
    accent: '#110090',
    emoji: '🎥'
  }, {
    title: 'PHP no está muerto (y aquí lo demuestro)',
    duration: '28:15',
    views: '89K',
    ago: 'hace 3 meses',
    bg: '#5f3a92',
    accent: '#ffc932',
    emoji: '🐘'
  }],
  en: [{
    featured: true,
    title: 'Complete Laravel 11 course from scratch (4 hours)',
    duration: '4:12:34',
    views: '142K',
    ago: '2 weeks ago',
    bg: '#110090',
    accent: '#ffc932',
    emoji: '🅻'
  }, {
    title: 'Building an AI chatbot in Laravel',
    duration: '38:21',
    views: '24K',
    ago: '1 month ago',
    bg: '#ffc932',
    accent: '#110090',
    emoji: '🤖'
  }, {
    title: "Livewire 3: what NOBODY explains",
    duration: '22:08',
    views: '67K',
    ago: '1 month ago',
    bg: '#4c2e84',
    accent: '#fbdc6d',
    emoji: '⚡'
  }, {
    title: 'My teacher + streamer setup in 2026',
    duration: '15:42',
    views: '18K',
    ago: '2 months ago',
    bg: '#fbdc6d',
    accent: '#110090',
    emoji: '🎥'
  }, {
    title: "PHP isn't dead (and here's why)",
    duration: '28:15',
    views: '89K',
    ago: '3 months ago',
    bg: '#5f3a92',
    accent: '#ffc932',
    emoji: '🐘'
  }]
};
const TW_STREAMS = {
  es: [{
    live: true,
    title: 'Construyendo un SaaS con Laravel + Livewire EN VIVO',
    category: 'Software & Game Development',
    viewers: '1.2K',
    ago: 'ahora',
    bg: '#9146ff',
    accent: '#ffc932',
    emoji: '🔴'
  }, {
    title: 'Refactor brutal: limpiando código de hace 5 años',
    category: 'Software Development',
    duration: '3:42:18',
    views: '8.4K',
    ago: 'hace 2 días',
    bg: '#110090',
    accent: '#ffc932',
    emoji: '🧹'
  }, {
    title: 'Aprendiendo Vue 3 con la comunidad',
    category: 'Software Development',
    duration: '2:18:05',
    views: '5.7K',
    ago: 'hace 5 días',
    bg: '#4c2e84',
    accent: '#fbdc6d',
    emoji: '△'
  }, {
    title: 'Code Review en vivo de proyectos de la comunidad',
    category: 'Just Chatting',
    duration: '4:05:32',
    views: '12.1K',
    ago: 'hace 1 semana',
    bg: '#ffc932',
    accent: '#110090',
    emoji: '👀'
  }],
  en: [{
    live: true,
    title: 'Building a SaaS with Laravel + Livewire LIVE',
    category: 'Software & Game Development',
    viewers: '1.2K',
    ago: 'now',
    bg: '#9146ff',
    accent: '#ffc932',
    emoji: '🔴'
  }, {
    title: 'Brutal refactor: cleaning up 5-year-old code',
    category: 'Software Development',
    duration: '3:42:18',
    views: '8.4K',
    ago: '2 days ago',
    bg: '#110090',
    accent: '#ffc932',
    emoji: '🧹'
  }, {
    title: 'Learning Vue 3 with the community',
    category: 'Software Development',
    duration: '2:18:05',
    views: '5.7K',
    ago: '5 days ago',
    bg: '#4c2e84',
    accent: '#fbdc6d',
    emoji: '△'
  }, {
    title: 'Live code review of community projects',
    category: 'Just Chatting',
    duration: '4:05:32',
    views: '12.1K',
    ago: '1 week ago',
    bg: '#ffc932',
    accent: '#110090',
    emoji: '👀'
  }]
};
const SOCIALS = [{
  name: 'YouTube',
  handle: '@acenagadev',
  url: 'https://youtube.com/@acenagadev',
  icon: 'youtube'
}, {
  name: 'Instagram',
  handle: '@acenaga.dev',
  url: 'https://instagram.com/acenaga.dev',
  icon: 'instagram'
}, {
  name: 'Twitch',
  handle: 'acenagadev',
  url: 'https://twitch.tv/acenagadev',
  icon: 'twitch'
}, {
  name: 'Kick',
  handle: 'acenagadev',
  url: 'https://kick.com/acenagadev',
  icon: 'kick'
}, {
  name: 'X / Twitter',
  handle: '@acenagadev',
  url: 'https://x.com/acenagadev',
  icon: 'x'
}, {
  name: 'Threads',
  handle: '@acenaga.dev',
  url: 'https://threads.net/@acenaga.dev',
  icon: 'threads'
}];
const TAGLINES = {
  es: ['Profesor que también compila', 'Code, café y caos en partes iguales', 'Enseño Laravel y a no asustarse del error 500', 'Devuelvo el ❤️ a los semicolons', 'PHP, Vue y mucha paciencia', 'Bug-driven development desde 2014'],
  en: ['A teacher who also compiles', 'Code, coffee and chaos in equal parts', "I teach Laravel — and how to not fear the 500", 'Bringing the ❤️ back to semicolons', 'PHP, Vue and a lot of patience', 'Bug-driven development since 2014']
};

// Expose all to window for cross-script consumption
Object.assign(window, {
  I18N,
  STATS,
  STACK,
  STACK_MARQUEE,
  CLASSES,
  PROJECTS,
  POSTS,
  IG_POSTS,
  YT_VIDEOS,
  TW_STREAMS,
  SOCIALS,
  TAGLINES
});

/* ============ icons.jsx ============ */
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
// =================================================================
// icons.jsx — All inline SVG icons (no external libs)
// =================================================================

const Icon = ({
  name,
  size = 20,
  stroke = 1.8
}) => {
  const props = {
    width: size,
    height: size,
    viewBox: '0 0 24 24',
    fill: 'none',
    stroke: 'currentColor',
    strokeWidth: stroke,
    strokeLinecap: 'round',
    strokeLinejoin: 'round'
  };
  switch (name) {
    case 'arrow-up-right':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M7 17L17 7M9 7h8v8"
      }));
    case 'arrow-right':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M5 12h14M13 5l7 7-7 7"
      }));
    case 'arrow-down':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M12 5v14M5 12l7 7 7-7"
      }));
    case 'sun':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("circle", {
        cx: "12",
        cy: "12",
        r: "4"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"
      }));
    case 'moon':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
      }));
    case 'menu':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M3 6h18M3 12h18M3 18h18"
      }));
    case 'play':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "currentColor"
      }, /*#__PURE__*/React.createElement("path", {
        d: "M8 5v14l11-7z"
      }));
    case 'heart':
      return /*#__PURE__*/React.createElement("svg", _extends({}, props, {
        fill: "currentColor"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
      }));
    case 'comment':
      return /*#__PURE__*/React.createElement("svg", _extends({}, props, {
        fill: "currentColor"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
      }));
    case 'eye':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
      }), /*#__PURE__*/React.createElement("circle", {
        cx: "12",
        cy: "12",
        r: "3"
      }));
    case 'clock':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("circle", {
        cx: "12",
        cy: "12",
        r: "10"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M12 6v6l4 2"
      }));
    case 'pin':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"
      }), /*#__PURE__*/React.createElement("circle", {
        cx: "12",
        cy: "10",
        r: "3"
      }));
    case 'sparkles':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M12 3l1.9 5.7L19 10l-5.1 1.3L12 17l-1.9-5.7L5 10l5.1-1.3z"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M5 3l.5 1.5L7 5l-1.5.5L5 7l-.5-1.5L3 5l1.5-.5z"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M19 17l.5 1.5L21 19l-1.5.5L19 21l-.5-1.5L17 19l1.5-.5z"
      }));
    case 'code':
      return /*#__PURE__*/React.createElement("svg", props, /*#__PURE__*/React.createElement("path", {
        d: "M16 18l6-6-6-6M8 6l-6 6 6 6M14 4l-4 16"
      }));
    case 'instagram':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: "1.8",
        strokeLinecap: "round",
        strokeLinejoin: "round"
      }, /*#__PURE__*/React.createElement("rect", {
        x: "2",
        y: "2",
        width: "20",
        height: "20",
        rx: "5",
        ry: "5"
      }), /*#__PURE__*/React.createElement("path", {
        d: "M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"
      }), /*#__PURE__*/React.createElement("line", {
        x1: "17.5",
        y1: "6.5",
        x2: "17.51",
        y2: "6.5"
      }));
    case 'youtube':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "currentColor"
      }, /*#__PURE__*/React.createElement("path", {
        d: "M23 7s-.2-1.6-.9-2.3c-.8-.9-1.7-.9-2.1-1C16.7 3.5 12 3.5 12 3.5s-4.7 0-8 .2c-.4.1-1.3.1-2.1 1C1.2 5.4 1 7 1 7s-.2 2-.2 3.9v1.8C.8 14.6 1 16.5 1 16.5s.2 1.6.9 2.3c.9 1 2.1.9 2.6 1 1.9.2 7.5.2 7.5.2s4.7 0 8-.2c.4-.1 1.3-.1 2.1-1 .7-.7.9-2.3.9-2.3s.2-1.9.2-3.9V11c0-1.9-.2-4-.2-4zM9.5 15V8.5l6 3.3-6 3.2z"
      }));
    case 'twitch':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "currentColor"
      }, /*#__PURE__*/React.createElement("path", {
        d: "M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714Z"
      }));
    case 'x':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "currentColor"
      }, /*#__PURE__*/React.createElement("path", {
        d: "M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
      }));
    case 'threads':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "currentColor"
      }, /*#__PURE__*/React.createElement("path", {
        d: "M17.84 11.16a8.39 8.39 0 0 0-.31-.14c-.18-3.32-1.99-5.21-5.04-5.23h-.04c-1.82 0-3.34.78-4.27 2.19l1.67 1.15c.7-1.06 1.79-1.28 2.6-1.28h.03c1.01.01 1.78.3 2.27.87.36.41.6.99.72 1.71-.94-.16-1.95-.21-3.04-.15-3.06.18-5.03 1.96-4.9 4.44.07 1.26.69 2.34 1.76 3.04.91.59 2.08.88 3.31.81 1.62-.09 2.89-.7 3.78-1.83.67-.85 1.1-1.96 1.29-3.34.78.47 1.36 1.09 1.68 1.83.54 1.27.57 3.36-1.13 5.06-1.49 1.49-3.27 2.13-5.97 2.15-2.99-.02-5.26-.98-6.74-2.85C2.32 17.4 1.6 14.93 1.58 12c.02-2.93.74-5.4 2.13-7.34 1.48-1.87 3.75-2.83 6.74-2.85 3.01.02 5.32.99 6.86 2.86.76.92 1.33 2.08 1.7 3.43l1.94-.52c-.45-1.66-1.16-3.09-2.13-4.27C16.86 1.07 14.07-.02 10.46 0h-.01C6.84.02 4.06 1.13 2.21 3.27.49 5.27-.02 8.06 0 11.99c-.02 3.94.49 6.73 2.21 8.74C4.06 22.87 6.85 23.97 10.46 24h.01c3.21-.02 5.46-.86 7.32-2.72 2.43-2.42 2.36-5.45 1.56-7.32-.57-1.34-1.66-2.43-3.16-3.16zm-5.45 5.54c-1.36.07-2.79-.54-2.86-1.85-.05-.97.69-2.05 2.95-2.18.26-.02.51-.02.76-.02.81 0 1.57.08 2.26.23-.26 3.21-1.78 3.74-3.11 3.81z"
      }));
    case 'kick':
      return /*#__PURE__*/React.createElement("svg", {
        width: size,
        height: size,
        viewBox: "0 0 24 24",
        fill: "currentColor"
      }, /*#__PURE__*/React.createElement("path", {
        d: "M3 3h5v4h2V5h2V3h5v4h-2v2h-2v2h-2v2h2v2h2v2h2v4h-5v-2h-2v-2h-2v2H8v2H3V3z"
      }));
    default:
      return null;
  }
};
window.Icon = Icon;

/* ============ sections.jsx ============ */
// =================================================================
// sections.jsx — Hero, About, Stack, Classes
// =================================================================

/* (hooks already aliased globally) */
// ---------- Helper: parse <em> in titles ----------
const RichTitle = ({
  html,
  className = 'section-title'
}) => /*#__PURE__*/React.createElement("h2", {
  className: className,
  dangerouslySetInnerHTML: {
    __html: html
  }
});

// ---------- TAGLINE CAROUSEL ----------
const TaglineCarousel = ({
  lang,
  startIdx = 0,
  interval = 3500,
  fontSize = 18,
  fontFamily = 'var(--f-mono)',
  italic = false,
  centered = false
}) => {
  const taglines = window.TAGLINES[lang];
  const [idx, setIdx] = useState(startIdx % taglines.length);
  const [phase, setPhase] = useState('in'); // 'in' | 'out'

  useEffect(() => {
    setIdx(startIdx % taglines.length);
  }, [startIdx, lang]);
  useEffect(() => {
    const tick = setInterval(() => {
      setPhase('out');
      setTimeout(() => {
        setIdx(i => (i + 1) % taglines.length);
        setPhase('in');
      }, 350);
    }, interval);
    return () => clearInterval(tick);
  }, [interval, taglines.length]);
  const goTo = i => {
    if (i === idx) return;
    setPhase('out');
    setTimeout(() => {
      setIdx(i);
      setPhase('in');
    }, 250);
  };
  return /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 20
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      minHeight: italic ? 56 : 48,
      display: 'flex',
      alignItems: 'center',
      justifyContent: centered ? 'center' : 'flex-start',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("p", {
    key: idx,
    className: italic ? '' : 'cursor-blink',
    style: {
      fontFamily,
      fontSize,
      color: 'var(--ink-soft)',
      fontStyle: italic ? 'italic' : 'normal',
      opacity: phase === 'in' ? 1 : 0,
      transform: phase === 'in' ? 'translateY(0)' : 'translateY(-8px)',
      transition: 'opacity 0.35s ease, transform 0.35s ease',
      margin: 0
    }
  }, italic ? `“${taglines[idx]}”` : taglines[idx])), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8,
      marginTop: 14,
      justifyContent: centered ? 'center' : 'flex-start'
    }
  }, taglines.map((_, i) => /*#__PURE__*/React.createElement("button", {
    key: i,
    onClick: () => goTo(i),
    "aria-label": `Tagline ${i + 1}`,
    style: {
      width: i === idx ? 22 : 8,
      height: 8,
      borderRadius: 4,
      background: i === idx ? 'var(--accent)' : 'var(--border-strong)',
      border: 'none',
      padding: 0,
      cursor: 'pointer',
      transition: 'width 0.3s, background 0.3s'
    }
  }))));
};

// ---------- HERO ----------
const Hero = ({
  t,
  lang,
  taglineIdx,
  heroVariant
}) => {
  const [time, setTime] = useState('');
  useEffect(() => {
    const update = () => {
      const d = new Date();
      const h = String(d.getHours()).padStart(2, '0');
      const m = String(d.getMinutes()).padStart(2, '0');
      const s = String(d.getSeconds()).padStart(2, '0');
      setTime(`${h}:${m}:${s}`);
    };
    update();
    const id = setInterval(update, 1000);
    return () => clearInterval(id);
  }, []);
  return /*#__PURE__*/React.createElement("section", {
    className: "hero",
    id: "top"
  }, /*#__PURE__*/React.createElement("div", {
    className: "hero-grid-bg"
  }), /*#__PURE__*/React.createElement("div", {
    className: "hero-orb hero-orb-1"
  }), /*#__PURE__*/React.createElement("div", {
    className: "hero-orb hero-orb-2"
  }), /*#__PURE__*/React.createElement("div", {
    className: "container",
    style: {
      position: 'relative',
      zIndex: 2
    }
  }, heroVariant === 'photo-left' && /*#__PURE__*/React.createElement(HeroPhotoLeft, {
    t: t,
    lang: lang,
    taglineIdx: taglineIdx,
    time: time
  }), heroVariant === 'centered' && /*#__PURE__*/React.createElement(HeroCentered, {
    t: t,
    lang: lang,
    taglineIdx: taglineIdx,
    time: time
  }), heroVariant === 'split' && /*#__PURE__*/React.createElement(HeroSplit, {
    t: t,
    lang: lang,
    taglineIdx: taglineIdx,
    time: time
  })));
};

// Variant A: classic with photo on the right
const HeroPhotoLeft = ({
  t,
  lang,
  taglineIdx,
  time
}) => /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'grid',
    gridTemplateColumns: '1.4fr 1fr',
    gap: 48,
    alignItems: 'center'
  },
  className: "hero-grid-resp"
}, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
  className: "eyebrow"
}, t.heroEyebrow), /*#__PURE__*/React.createElement("h1", {
  style: {
    fontFamily: 'var(--f-display)',
    fontSize: 'clamp(48px, 8vw, 110px)',
    fontWeight: 700,
    lineHeight: 0.92,
    letterSpacing: '-0.04em',
    marginTop: 22
  }
}, "Hola, soy", /*#__PURE__*/React.createElement("br", null), /*#__PURE__*/React.createElement("span", {
  style: {
    color: 'var(--accent)'
  }
}, "Carlos"), /*#__PURE__*/React.createElement("span", {
  style: {
    fontFamily: 'var(--f-serif)',
    fontStyle: 'italic',
    fontWeight: 400
  }
}, ".")), /*#__PURE__*/React.createElement(TaglineCarousel, {
  lang: lang,
  startIdx: taglineIdx,
  fontSize: 18
}), /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'flex',
    gap: 8,
    flexWrap: 'wrap',
    marginTop: 24
  }
}, /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    transform: 'rotate(-2deg)'
  }
}, "\uD83D\uDCCD ", t.heroLocation), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    transform: 'rotate(1deg)',
    background: 'var(--c-yellow-soft)'
  }
}, "\u23F1 ", time, " \xB7 BA"), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    transform: 'rotate(-1deg)',
    background: '#4ade80'
  }
}, "\u25CF ", t.heroStatusOn)), /*#__PURE__*/React.createElement("p", {
  style: {
    fontSize: 16,
    marginTop: 24,
    color: 'var(--ink-soft)',
    maxWidth: 540
  }
}, t.heroAvailability), /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'flex',
    gap: 14,
    marginTop: 36,
    flexWrap: 'wrap'
  }
}, /*#__PURE__*/React.createElement("a", {
  href: "#youtube",
  className: "btn btn-primary glitch"
}, "\u25B6 ", t.heroCtaPrimary), /*#__PURE__*/React.createElement("a", {
  href: "#classes",
  className: "btn"
}, t.heroCtaSecondary, " ", /*#__PURE__*/React.createElement(Icon, {
  name: "arrow-right",
  size: 14
})))), /*#__PURE__*/React.createElement(HeroPhotoCard, null));

// Variant B: centered, big typography
const HeroCentered = ({
  t,
  lang,
  taglineIdx,
  time
}) => /*#__PURE__*/React.createElement("div", {
  style: {
    textAlign: 'center',
    maxWidth: 1000,
    margin: '0 auto'
  }
}, /*#__PURE__*/React.createElement("div", {
  className: "eyebrow",
  style: {
    justifyContent: 'center',
    display: 'inline-flex'
  }
}, t.heroEyebrow), /*#__PURE__*/React.createElement("h1", {
  style: {
    fontFamily: 'var(--f-display)',
    fontSize: 'clamp(56px, 10vw, 160px)',
    fontWeight: 700,
    lineHeight: 0.88,
    letterSpacing: '-0.05em',
    marginTop: 28
  }
}, "Hola, soy", /*#__PURE__*/React.createElement("br", null), /*#__PURE__*/React.createElement("span", {
  style: {
    color: 'var(--accent)'
  }
}, "Carlos"), /*#__PURE__*/React.createElement("span", {
  style: {
    fontFamily: 'var(--f-serif)',
    fontStyle: 'italic',
    fontWeight: 400
  }
}, " Ferrer.")), /*#__PURE__*/React.createElement(TaglineCarousel, {
  lang: lang,
  startIdx: taglineIdx,
  fontSize: 20,
  centered: true
}), /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'inline-block',
    marginTop: 36,
    padding: 6,
    border: '3px solid var(--ink)',
    borderRadius: 200,
    transform: 'rotate(-2deg)'
  }
}, /*#__PURE__*/React.createElement("img", {
  src: "assets/carlos.jpg",
  alt: "Carlos Ferrer",
  style: {
    width: 96,
    height: 96,
    borderRadius: '50%',
    objectFit: 'cover',
    display: 'block'
  }
})), /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'flex',
    gap: 8,
    flexWrap: 'wrap',
    marginTop: 24,
    justifyContent: 'center'
  }
}, /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    transform: 'rotate(-2deg)'
  }
}, "\uD83D\uDCCD ", t.heroLocation), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    transform: 'rotate(1deg)',
    background: 'var(--c-yellow-soft)'
  }
}, "\u23F1 ", time), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    transform: 'rotate(-1deg)',
    background: '#4ade80'
  }
}, "\u25CF ", t.heroStatusOn)), /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'flex',
    gap: 14,
    marginTop: 36,
    flexWrap: 'wrap',
    justifyContent: 'center'
  }
}, /*#__PURE__*/React.createElement("a", {
  href: "#youtube",
  className: "btn btn-primary"
}, "\u25B6 ", t.heroCtaPrimary), /*#__PURE__*/React.createElement("a", {
  href: "#classes",
  className: "btn"
}, t.heroCtaSecondary, " ", /*#__PURE__*/React.createElement(Icon, {
  name: "arrow-right",
  size: 14
}))));

// Variant C: editorial split with terminal
const HeroSplit = ({
  t,
  lang,
  taglineIdx,
  time
}) => /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'grid',
    gridTemplateColumns: '1fr 1fr',
    gap: 0,
    minHeight: 'calc(100vh - 200px)'
  },
  className: "hero-grid-resp"
}, /*#__PURE__*/React.createElement("div", {
  style: {
    padding: '40px 40px 40px 0',
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center'
  }
}, /*#__PURE__*/React.createElement("div", {
  className: "eyebrow"
}, t.heroEyebrow), /*#__PURE__*/React.createElement("h1", {
  style: {
    fontFamily: 'var(--f-display)',
    fontSize: 'clamp(48px, 7vw, 96px)',
    fontWeight: 700,
    lineHeight: 0.92,
    letterSpacing: '-0.04em',
    marginTop: 22
  }
}, "Carlos", /*#__PURE__*/React.createElement("br", null), /*#__PURE__*/React.createElement("span", {
  style: {
    color: 'var(--accent)'
  }
}, "Ferrer"), /*#__PURE__*/React.createElement("span", {
  style: {
    fontFamily: 'var(--f-serif)',
    fontStyle: 'italic',
    fontWeight: 400
  }
}, ".")), /*#__PURE__*/React.createElement(TaglineCarousel, {
  lang: lang,
  startIdx: taglineIdx,
  fontSize: 22,
  fontFamily: "var(--f-serif)",
  italic: true
}), /*#__PURE__*/React.createElement("div", {
  style: {
    display: 'flex',
    gap: 14,
    marginTop: 36,
    flexWrap: 'wrap'
  }
}, /*#__PURE__*/React.createElement("a", {
  href: "#youtube",
  className: "btn btn-primary"
}, "\u25B6 ", t.heroCtaPrimary), /*#__PURE__*/React.createElement("a", {
  href: "#classes",
  className: "btn"
}, t.heroCtaSecondary))), /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'relative',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center'
  }
}, /*#__PURE__*/React.createElement(FakeTerminal, {
  t: t,
  time: time
})));
const HeroPhotoCard = () => /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'relative',
    maxWidth: 380,
    marginLeft: 'auto'
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'relative',
    transform: 'rotate(2deg)'
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    inset: 0,
    background: 'var(--accent)',
    borderRadius: 12,
    transform: 'translate(14px, 14px)',
    zIndex: 0
  }
}), /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'relative',
    background: 'var(--surface-2)',
    border: '3px solid var(--ink)',
    borderRadius: 12,
    padding: 14,
    zIndex: 1
  }
}, /*#__PURE__*/React.createElement("img", {
  src: "assets/carlos.jpg",
  alt: "Carlos",
  style: {
    width: '100%',
    borderRadius: 8,
    display: 'block',
    filter: 'contrast(1.05)'
  }
}), /*#__PURE__*/React.createElement("div", {
  style: {
    marginTop: 12,
    fontFamily: 'var(--f-mono)',
    fontSize: 11,
    display: 'flex',
    justifyContent: 'space-between',
    color: 'var(--ink-soft)'
  }
}, /*#__PURE__*/React.createElement("span", null, "// IMG_2026.jpg"), /*#__PURE__*/React.createElement("span", null, "1080\xD71080")))), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    position: 'absolute',
    top: -16,
    left: -20,
    transform: 'rotate(-12deg)',
    background: '#4ade80',
    zIndex: 2
  }
}, "\u25CF ON AIR"), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    position: 'absolute',
    bottom: 20,
    right: -28,
    transform: 'rotate(8deg)',
    background: 'var(--c-yellow-soft)',
    zIndex: 2
  }
}, "\uD83D\uDC68\u200D\uD83D\uDCBB dev/teacher"));
const FakeTerminal = ({
  t,
  time
}) => /*#__PURE__*/React.createElement("div", {
  style: {
    width: '100%',
    maxWidth: 480,
    background: '#0a0050',
    border: '3px solid var(--ink)',
    borderRadius: 10,
    boxShadow: '8px 8px 0 var(--accent)',
    fontFamily: 'var(--f-mono)',
    fontSize: 12,
    overflow: 'hidden'
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    padding: '8px 12px',
    background: 'rgba(0,0,0,0.3)',
    display: 'flex',
    alignItems: 'center',
    gap: 6,
    borderBottom: '2px solid var(--ink)'
  }
}, /*#__PURE__*/React.createElement("span", {
  style: {
    width: 10,
    height: 10,
    borderRadius: '50%',
    background: '#ff5f57'
  }
}), /*#__PURE__*/React.createElement("span", {
  style: {
    width: 10,
    height: 10,
    borderRadius: '50%',
    background: '#febc2e'
  }
}), /*#__PURE__*/React.createElement("span", {
  style: {
    width: 10,
    height: 10,
    borderRadius: '50%',
    background: '#28c840'
  }
}), /*#__PURE__*/React.createElement("span", {
  style: {
    marginLeft: 'auto',
    color: '#fff8e1',
    opacity: 0.7
  }
}, "~/carlos \xB7 zsh")), /*#__PURE__*/React.createElement("div", {
  style: {
    padding: 18,
    color: '#fff8e1',
    minHeight: 240
  }
}, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#4ade80'
  }
}, "\u279C"), " ", /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#ffc932'
  }
}, "carlos"), " whoami"), /*#__PURE__*/React.createElement("div", {
  style: {
    paddingLeft: 16,
    opacity: 0.85
  }
}, "profesor + dev + creador de contenido"), /*#__PURE__*/React.createElement("div", {
  style: {
    marginTop: 8
  }
}, /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#4ade80'
  }
}, "\u279C"), " ", /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#ffc932'
  }
}, "carlos"), " cat skills.txt"), /*#__PURE__*/React.createElement("div", {
  style: {
    paddingLeft: 16,
    opacity: 0.85
  }
}, "Laravel \xB7 PHP \xB7 Vue \xB7 Livewire", /*#__PURE__*/React.createElement("br", null), "HTML \xB7 CSS \xB7 JS \xB7 Bootstrap", /*#__PURE__*/React.createElement("br", null), "+ paciencia infinita"), /*#__PURE__*/React.createElement("div", {
  style: {
    marginTop: 8
  }
}, /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#4ade80'
  }
}, "\u279C"), " ", /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#ffc932'
  }
}, "carlos"), " uptime"), /*#__PURE__*/React.createElement("div", {
  style: {
    paddingLeft: 16,
    opacity: 0.85
  }
}, "10+ a\xF1os, load avg: \u2615\u2615\u2615"), /*#__PURE__*/React.createElement("div", {
  style: {
    marginTop: 8
  },
  className: "cursor-blink"
}, /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#4ade80'
  }
}, "\u279C"), " ", /*#__PURE__*/React.createElement("span", {
  style: {
    color: '#ffc932'
  }
}, "carlos"))));

// ---------- ABOUT ----------
const About = ({
  t,
  lang
}) => /*#__PURE__*/React.createElement("section", {
  id: "about",
  className: "reveal"
}, /*#__PURE__*/React.createElement("div", {
  className: "container"
}, /*#__PURE__*/React.createElement("div", {
  className: "about-grid"
}, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
  className: "eyebrow"
}, t.aboutEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
  html: t.aboutTitle
}), /*#__PURE__*/React.createElement("div", {
  style: {
    marginTop: 32,
    display: 'flex',
    flexDirection: 'column',
    gap: 18,
    fontSize: 17,
    lineHeight: 1.65,
    color: 'var(--ink-soft)'
  }
}, /*#__PURE__*/React.createElement("p", null, t.aboutP1), /*#__PURE__*/React.createElement("p", null, t.aboutP2), /*#__PURE__*/React.createElement("p", null, t.aboutP3)), /*#__PURE__*/React.createElement("div", {
  className: "stat-grid"
}, window.STATS.map((s, i) => /*#__PURE__*/React.createElement("div", {
  className: "stat",
  key: i
}, /*#__PURE__*/React.createElement("div", {
  className: "stat-num"
}, s.num), /*#__PURE__*/React.createElement("div", {
  className: "stat-label"
}, t[s.key]))))), /*#__PURE__*/React.createElement("div", {
  className: "about-photo-wrap"
}, /*#__PURE__*/React.createElement("div", {
  className: "about-photo-frame"
}), /*#__PURE__*/React.createElement("img", {
  src: "assets/carlos.jpg",
  alt: "Carlos Ferrer",
  className: "about-photo"
}), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    position: 'absolute',
    top: -14,
    right: -16,
    transform: 'rotate(8deg)'
  }
}, "\u2605 Profesor"), /*#__PURE__*/React.createElement("span", {
  className: "sticker",
  style: {
    position: 'absolute',
    bottom: 18,
    left: -18,
    transform: 'rotate(-6deg)',
    background: 'var(--c-yellow-soft)'
  }
}, '</> dev')))));

// ---------- STACK ----------
const Stack = ({
  t,
  visible
}) => {
  if (!visible) return null;
  return /*#__PURE__*/React.createElement("section", {
    id: "stack",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head"
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.stackEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.stackTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)',
      maxWidth: 600
    }
  }, t.stackSubtitle))), /*#__PURE__*/React.createElement("div", {
    className: "stack-marquee"
  }, /*#__PURE__*/React.createElement("div", {
    className: "stack-track"
  }, [...window.STACK_MARQUEE, ...window.STACK_MARQUEE].map((s, i) => /*#__PURE__*/React.createElement("span", {
    key: i
  }, s)))), /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "stack-grid"
  }, window.STACK.map((s, i) => /*#__PURE__*/React.createElement("div", {
    className: "stack-chip",
    key: i
  }, /*#__PURE__*/React.createElement("span", {
    className: "stack-chip-icon",
    style: {
      fontFamily: 'var(--f-mono)'
    }
  }, s.icon), /*#__PURE__*/React.createElement("span", null, s.name))))));
};

// ---------- CLASSES ----------
const Classes = ({
  t,
  lang,
  visible
}) => {
  if (!visible) return null;
  const items = window.CLASSES[lang];
  return /*#__PURE__*/React.createElement("section", {
    id: "classes",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head"
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.classesEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.classesTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)',
      maxWidth: 600
    }
  }, t.classesSubtitle)), /*#__PURE__*/React.createElement("div", {
    className: "classes-grid"
  }, items.map((c, i) => /*#__PURE__*/React.createElement("article", {
    className: "class-card",
    key: i
  }, /*#__PURE__*/React.createElement("span", {
    className: "class-num"
  }, "[", String(i + 1).padStart(2, '0'), "]"), /*#__PURE__*/React.createElement("div", {
    className: "class-tag"
  }, c.tag), /*#__PURE__*/React.createElement("h3", {
    className: "class-title"
  }, c.title), /*#__PURE__*/React.createElement("p", {
    className: "class-desc"
  }, c.desc), /*#__PURE__*/React.createElement("div", {
    className: "class-meta"
  }, /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement(Icon, {
    name: "sparkles",
    size: 12
  }), " ", c.level), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement(Icon, {
    name: "clock",
    size: 12
  }), " ", c.hours)))))));
};
Object.assign(window, {
  Hero,
  About,
  Stack,
  Classes,
  RichTitle
});

/* ============ sections2.jsx ============ */
// =================================================================
// sections2.jsx — Projects, Blog, Instagram, YouTube, Social, Footer
// =================================================================

// ---------- PROJECTS ----------
const Projects = ({
  t,
  lang,
  visible
}) => {
  if (!visible) return null;
  const items = window.PROJECTS[lang];
  return /*#__PURE__*/React.createElement("section", {
    id: "projects",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head"
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.projectsEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.projectsTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)',
      maxWidth: 600
    }
  }, t.projectsSubtitle)), /*#__PURE__*/React.createElement("div", {
    className: "projects-grid"
  }, items.map((p, i) => /*#__PURE__*/React.createElement("a", {
    href: p.url,
    className: "project-card",
    key: i
  }, /*#__PURE__*/React.createElement("div", {
    className: "project-thumb",
    style: {
      background: p.bg
    }
  }, /*#__PURE__*/React.createElement(ProjectThumb, {
    project: p
  })), /*#__PURE__*/React.createElement("div", {
    className: "project-body"
  }, /*#__PURE__*/React.createElement("div", {
    className: "project-tags"
  }, p.tags.map((tag, j) => /*#__PURE__*/React.createElement("span", {
    className: "project-tag",
    key: j
  }, tag))), /*#__PURE__*/React.createElement("h3", {
    className: "project-name"
  }, p.name, /*#__PURE__*/React.createElement("span", {
    className: "project-arrow"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "arrow-up-right",
    size: 16
  }))), /*#__PURE__*/React.createElement("p", {
    className: "project-desc"
  }, p.desc)))))));
};
const ProjectThumb = ({
  project
}) => /*#__PURE__*/React.createElement("div", {
  className: "project-thumb-inner",
  style: {
    color: project.color,
    position: 'relative'
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    inset: 0,
    backgroundImage: `radial-gradient(circle, ${project.color}33 1px, transparent 1px)`,
    backgroundSize: '20px 20px',
    opacity: 0.6
  }
}), /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'relative',
    textAlign: 'center'
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    fontSize: 72,
    marginBottom: 8
  }
}, project.icon), /*#__PURE__*/React.createElement("div", {
  style: {
    fontFamily: 'var(--f-mono)',
    fontSize: 11,
    letterSpacing: '0.15em',
    textTransform: 'uppercase',
    opacity: 0.8
  }
}, "./", project.name.toLowerCase().replace(/\s+/g, '-'))));

// ---------- BLOG ----------
const Blog = ({
  t,
  lang,
  visible
}) => {
  if (!visible) return null;
  const items = window.POSTS[lang];
  return /*#__PURE__*/React.createElement("section", {
    id: "blog",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head"
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.blogEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.blogTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)',
      maxWidth: 600
    }
  }, t.blogSubtitle)), /*#__PURE__*/React.createElement("div", {
    className: "posts-grid"
  }, items.map((p, i) => /*#__PURE__*/React.createElement("article", {
    className: "post-card",
    key: i
  }, /*#__PURE__*/React.createElement("div", {
    className: "post-meta"
  }, /*#__PURE__*/React.createElement("span", {
    className: "post-cat"
  }, p.cat), /*#__PURE__*/React.createElement("span", null, p.date), /*#__PURE__*/React.createElement("span", null, "\xB7 ", p.readTime)), /*#__PURE__*/React.createElement("h3", {
    className: "post-title"
  }, p.title), /*#__PURE__*/React.createElement("p", {
    className: "post-excerpt"
  }, p.excerpt), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 18,
      fontFamily: 'var(--f-mono)',
      fontSize: 12,
      color: 'var(--accent)',
      display: 'inline-flex',
      gap: 6,
      alignItems: 'center'
    }
  }, t.blogReadMore, " ", /*#__PURE__*/React.createElement(Icon, {
    name: "arrow-right",
    size: 12
  })))))));
};

// ---------- INSTAGRAM ----------
const Instagram = ({
  t,
  visible
}) => {
  if (!visible) return null;
  return /*#__PURE__*/React.createElement("section", {
    id: "instagram",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head",
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'flex-end',
      flexWrap: 'wrap',
      gap: 24,
      maxWidth: '100%'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 600
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.igEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.igTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)'
    }
  }, t.igSubtitle)), /*#__PURE__*/React.createElement("a", {
    href: "https://instagram.com/acenaga.dev",
    className: "btn btn-primary"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "instagram",
    size: 16
  }), " ", t.igFollow)), /*#__PURE__*/React.createElement("div", {
    className: "ig-grid"
  }, window.IG_POSTS.map((p, i) => /*#__PURE__*/React.createElement("a", {
    href: "https://instagram.com/acenaga.dev",
    key: i,
    className: "ig-item",
    style: {
      background: p.color
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "ig-item-bg",
    style: {
      color: p.accent,
      fontSize: 40
    }
  }, p.emoji), p.type === 'reel' && /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 8,
      right: 8,
      width: 22,
      height: 22,
      display: 'grid',
      placeItems: 'center',
      color: 'white'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "play",
    size: 20
  })), p.type === 'carousel' && /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 8,
      right: 8,
      color: 'white',
      fontSize: 16
    }
  }, "\u229E"), /*#__PURE__*/React.createElement("div", {
    className: "ig-item-overlay"
  }, /*#__PURE__*/React.createElement("div", {
    className: "ig-item-stats"
  }, /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement(Icon, {
    name: "heart",
    size: 11
  }), " ", p.likes), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement(Icon, {
    name: "comment",
    size: 11
  }), " ", p.cmts))))))));
};

// ---------- YOUTUBE ----------
const YouTube = ({
  t,
  lang,
  visible
}) => {
  if (!visible) return null;
  const items = window.YT_VIDEOS[lang];
  const featured = items.find(v => v.featured);
  const rest = items.filter(v => !v.featured);
  return /*#__PURE__*/React.createElement("section", {
    id: "youtube",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head",
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'flex-end',
      flexWrap: 'wrap',
      gap: 24,
      maxWidth: '100%'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 600
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.ytEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.ytTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)'
    }
  }, t.ytSubtitle)), /*#__PURE__*/React.createElement("a", {
    href: "https://youtube.com/@acenagadev",
    className: "btn btn-primary"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "youtube",
    size: 16
  }), " ", t.ytSubscribe)), /*#__PURE__*/React.createElement("div", {
    className: "yt-grid"
  }, featured && /*#__PURE__*/React.createElement(YTCard, {
    video: featured,
    featured: true
  }), rest.map((v, i) => /*#__PURE__*/React.createElement(YTCard, {
    video: v,
    key: i
  })))));
};
const YTCard = ({
  video,
  featured
}) => /*#__PURE__*/React.createElement("a", {
  href: "https://youtube.com/@acenagadev",
  className: `yt-card${featured ? ' featured' : ''}`
}, /*#__PURE__*/React.createElement("div", {
  className: "yt-thumb",
  style: {
    background: video.bg
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    inset: 0,
    display: 'grid',
    placeItems: 'center',
    color: video.accent,
    fontSize: featured ? 96 : 64
  }
}, video.emoji), /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    bottom: 12,
    left: 12,
    fontFamily: 'var(--f-mono)',
    fontSize: 10,
    color: video.accent,
    letterSpacing: '0.15em',
    textTransform: 'uppercase',
    opacity: 0.85
  }
}, "./video_", String(Math.floor(Math.random() * 999)).padStart(3, '0'), ".mp4"), /*#__PURE__*/React.createElement("div", {
  className: "yt-play"
}, /*#__PURE__*/React.createElement("div", {
  className: "yt-play-icon"
}, /*#__PURE__*/React.createElement(Icon, {
  name: "play",
  size: 26
}))), /*#__PURE__*/React.createElement("div", {
  className: "yt-duration"
}, video.duration)), /*#__PURE__*/React.createElement("div", {
  className: "yt-body"
}, /*#__PURE__*/React.createElement("h3", {
  className: "yt-title"
}, video.title), /*#__PURE__*/React.createElement("div", {
  className: "yt-meta"
}, /*#__PURE__*/React.createElement(Icon, {
  name: "eye",
  size: 11,
  style: {
    verticalAlign: 'middle'
  }
}), " ", video.views, " views \xB7 ", video.ago)));

// ---------- SOCIAL ----------
const Social = ({
  t
}) => /*#__PURE__*/React.createElement("section", {
  id: "contact",
  className: "reveal"
}, /*#__PURE__*/React.createElement("div", {
  className: "container"
}, /*#__PURE__*/React.createElement("div", {
  className: "section-head"
}, /*#__PURE__*/React.createElement("div", {
  className: "eyebrow"
}, t.socialEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
  html: t.socialTitle
}), /*#__PURE__*/React.createElement("p", {
  style: {
    marginTop: 14,
    fontSize: 17,
    color: 'var(--ink-soft)',
    maxWidth: 600
  }
}, t.socialSubtitle)), /*#__PURE__*/React.createElement("div", {
  className: "social-grid"
}, window.SOCIALS.map((s, i) => /*#__PURE__*/React.createElement("a", {
  href: s.url,
  className: "social-card",
  key: i,
  style: {
    transform: `rotate(${(i % 2 === 0 ? -1 : 1) * 0.6}deg)`
  }
}, /*#__PURE__*/React.createElement("div", {
  className: "social-icon"
}, /*#__PURE__*/React.createElement(Icon, {
  name: s.icon,
  size: 22
})), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
  className: "social-name"
}, s.name), /*#__PURE__*/React.createElement("div", {
  className: "social-handle"
}, s.handle)), /*#__PURE__*/React.createElement("div", {
  style: {
    marginLeft: 'auto'
  }
}, /*#__PURE__*/React.createElement(Icon, {
  name: "arrow-up-right",
  size: 18
})))))));

// ---------- FOOTER ----------
const Footer = ({
  t
}) => {
  const [visitor, setVisitor] = useState('00042');
  useEffect(() => {
    const stored = parseInt(localStorage.getItem('acenaga_visits') || '42');
    const next = stored + 1;
    localStorage.setItem('acenaga_visits', String(next));
    setVisitor(String(next).padStart(5, '0'));
  }, []);
  return /*#__PURE__*/React.createElement("footer", {
    className: "footer"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "footer-inner"
  }, /*#__PURE__*/React.createElement("div", null, t.footerCopy), /*#__PURE__*/React.createElement("div", null, t.footerMade), /*#__PURE__*/React.createElement("div", {
    className: "footer-clock"
  }, /*#__PURE__*/React.createElement("span", {
    className: "footer-clock-dot"
  }), /*#__PURE__*/React.createElement("span", {
    className: "visitor-counter"
  }, t.footerVisitor, " #", visitor))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 24,
      fontFamily: 'var(--f-mono)',
      fontSize: 11,
      color: 'var(--ink-dim)',
      textAlign: 'center',
      opacity: 0.6
    }
  }, "\u25B2 Tip: prob\xE1 el c\xF3digo ", /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--accent)'
    }
  }, "\u2191\u2191\u2193\u2193\u2190\u2192\u2190\u2192BA"), " \u25BC")));
};

// ---------- TWITCH ----------
const Twitch = ({
  t,
  lang,
  visible
}) => {
  if (!visible) return null;
  const items = window.TW_STREAMS[lang];
  return /*#__PURE__*/React.createElement("section", {
    id: "twitch",
    className: "reveal"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container"
  }, /*#__PURE__*/React.createElement("div", {
    className: "section-head",
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'flex-end',
      flexWrap: 'wrap',
      gap: 24,
      maxWidth: '100%'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 600
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "eyebrow"
  }, t.twEyebrow), /*#__PURE__*/React.createElement(RichTitle, {
    html: t.twTitle
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 14,
      fontSize: 17,
      color: 'var(--ink-soft)'
    }
  }, t.twSubtitle)), /*#__PURE__*/React.createElement("a", {
    href: "https://twitch.tv/acenagadev",
    className: "btn btn-primary"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "twitch",
    size: 16
  }), " ", t.twFollow)), /*#__PURE__*/React.createElement("div", {
    className: "yt-grid"
  }, items.map((s, i) => /*#__PURE__*/React.createElement(TwitchCard, {
    stream: s,
    t: t,
    key: i,
    featured: i === 0
  })))));
};
const TwitchCard = ({
  stream,
  t,
  featured
}) => /*#__PURE__*/React.createElement("a", {
  href: "https://twitch.tv/acenagadev",
  className: `yt-card${featured ? ' featured' : ''}`
}, /*#__PURE__*/React.createElement("div", {
  className: "yt-thumb",
  style: {
    background: stream.bg
  }
}, /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    inset: 0,
    display: 'grid',
    placeItems: 'center',
    color: stream.accent,
    fontSize: featured ? 96 : 64
  }
}, stream.emoji), /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    bottom: 12,
    left: 12,
    fontFamily: 'var(--f-mono)',
    fontSize: 10,
    color: stream.accent,
    letterSpacing: '0.15em',
    textTransform: 'uppercase',
    opacity: 0.85
  }
}, stream.category), /*#__PURE__*/React.createElement("div", {
  className: "yt-play"
}, /*#__PURE__*/React.createElement("div", {
  className: "yt-play-icon"
}, /*#__PURE__*/React.createElement(Icon, {
  name: "play",
  size: 26
}))), stream.live ? /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    top: 10,
    left: 10,
    background: '#ef4444',
    color: 'white',
    padding: '4px 10px',
    fontFamily: 'var(--f-mono)',
    fontWeight: 700,
    fontSize: 11,
    letterSpacing: '0.1em',
    borderRadius: 4,
    display: 'inline-flex',
    alignItems: 'center',
    gap: 6
  }
}, /*#__PURE__*/React.createElement("span", {
  style: {
    width: 8,
    height: 8,
    borderRadius: '50%',
    background: 'white',
    animation: 'pulse 1.2s infinite'
  }
}), t.twLive) : /*#__PURE__*/React.createElement("div", {
  style: {
    position: 'absolute',
    top: 10,
    left: 10,
    background: 'rgba(0,0,0,0.85)',
    color: '#9146ff',
    padding: '3px 8px',
    fontFamily: 'var(--f-mono)',
    fontWeight: 700,
    fontSize: 10,
    letterSpacing: '0.1em',
    borderRadius: 3
  }
}, t.twVod), /*#__PURE__*/React.createElement("div", {
  className: "yt-duration"
}, stream.live ? `👁 ${stream.viewers}` : stream.duration)), /*#__PURE__*/React.createElement("div", {
  className: "yt-body"
}, /*#__PURE__*/React.createElement("h3", {
  className: "yt-title"
}, stream.title), /*#__PURE__*/React.createElement("div", {
  className: "yt-meta"
}, /*#__PURE__*/React.createElement(Icon, {
  name: "eye",
  size: 11
}), " ", stream.live ? `${stream.viewers} viewers` : `${stream.views} views`, " \xB7 ", stream.ago)));
Object.assign(window, {
  Projects,
  Blog,
  Instagram,
  YouTube,
  Twitch,
  Social,
  Footer
});

/* ============ app.jsx ============ */
// =================================================================
// app.jsx — Main shell (Nav, theme, language, tweaks, easter eggs)
// =================================================================

/* (hooks already aliased globally) */
// ---------- NAV ----------
const Nav = ({
  t,
  lang,
  setLang,
  theme,
  setTheme,
  sections
}) => {
  const [active, setActive] = useState('top');
  const [mobileOpen, setMobileOpen] = useState(false);
  const [videosOpen, setVideosOpen] = useState(false);
  const videosRef = useRef(null);
  useEffect(() => {
    const close = () => setMobileOpen(false);
    window.addEventListener('hashchange', close);
    return () => window.removeEventListener('hashchange', close);
  }, []);
  useEffect(() => {
    const handler = e => {
      if (videosRef.current && !videosRef.current.contains(e.target)) {
        setVideosOpen(false);
      }
    };
    document.addEventListener('click', handler);
    return () => document.removeEventListener('click', handler);
  }, []);
  useEffect(() => {
    const handler = () => {
      const ids = ['top', 'about', 'stack', 'classes', 'projects', 'blog', 'instagram', 'youtube', 'twitch', 'contact'];
      const visible = ids.find(id => {
        const el = document.getElementById(id);
        if (!el) return false;
        const r = el.getBoundingClientRect();
        return r.top <= 120 && r.bottom > 120;
      });
      if (visible) setActive(visible);
    };
    window.addEventListener('scroll', handler, {
      passive: true
    });
    handler();
    return () => window.removeEventListener('scroll', handler);
  }, []);
  const baseLinks = [sections.about && {
    id: 'about',
    label: t.navAbout
  }, sections.stack && {
    id: 'stack',
    label: t.navStack
  }, sections.classes && {
    id: 'classes',
    label: t.navClasses
  }, sections.projects && {
    id: 'projects',
    label: t.navProjects
  }, sections.blog && {
    id: 'blog',
    label: t.navBlog
  }, sections.instagram && {
    id: 'instagram',
    label: t.navInstagram
  }].filter(Boolean);
  const videoLinks = [sections.youtube && {
    id: 'youtube',
    label: t.navYoutube,
    icon: 'youtube'
  }, sections.twitch && {
    id: 'twitch',
    label: t.navTwitch,
    icon: 'twitch'
  }].filter(Boolean);
  const tailLinks = [{
    id: 'contact',
    label: t.navContact
  }];

  // mobile uses flat list
  const mobileLinks = [...baseLinks, ...videoLinks, ...tailLinks];
  const videosActive = videoLinks.some(l => l.id === active);
  return /*#__PURE__*/React.createElement("nav", {
    className: "nav"
  }, /*#__PURE__*/React.createElement("div", {
    className: "container nav-inner"
  }, /*#__PURE__*/React.createElement("a", {
    href: "#top",
    className: "nav-logo"
  }, /*#__PURE__*/React.createElement("span", {
    className: "nav-logo-mark"
  }, "A"), /*#__PURE__*/React.createElement("span", null, "acenaga", /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--accent)'
    }
  }, ".dev"))), /*#__PURE__*/React.createElement("ul", {
    className: "nav-links"
  }, baseLinks.map(l => /*#__PURE__*/React.createElement("li", {
    key: l.id
  }, /*#__PURE__*/React.createElement("a", {
    href: `#${l.id}`,
    className: active === l.id ? 'active' : ''
  }, l.label))), videoLinks.length > 0 && /*#__PURE__*/React.createElement("li", {
    className: `nav-item${videosOpen ? ' open' : ''}`,
    ref: videosRef
  }, /*#__PURE__*/React.createElement("button", {
    className: `nav-dropdown-trigger${videosActive ? ' active' : ''}`,
    onClick: e => {
      e.stopPropagation();
      setVideosOpen(o => !o);
    }
  }, t.navVideos, /*#__PURE__*/React.createElement("span", {
    className: "nav-dropdown-caret"
  }, "\u25BC")), /*#__PURE__*/React.createElement("ul", {
    className: "nav-dropdown"
  }, videoLinks.map(l => /*#__PURE__*/React.createElement("li", {
    key: l.id
  }, /*#__PURE__*/React.createElement("a", {
    href: `#${l.id}`,
    onClick: () => setVideosOpen(false)
  }, /*#__PURE__*/React.createElement(Icon, {
    name: l.icon,
    size: 14
  }), l.label))))), tailLinks.map(l => /*#__PURE__*/React.createElement("li", {
    key: l.id
  }, /*#__PURE__*/React.createElement("a", {
    href: `#${l.id}`,
    className: active === l.id ? 'active' : ''
  }, l.label)))), /*#__PURE__*/React.createElement("div", {
    className: "nav-actions"
  }, /*#__PURE__*/React.createElement("button", {
    className: "nav-btn lang",
    onClick: () => setLang(lang === 'es' ? 'en' : 'es'),
    title: "Toggle language"
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      opacity: lang === 'es' ? 1 : 0.4
    }
  }, "ES"), /*#__PURE__*/React.createElement("span", {
    style: {
      opacity: 0.4
    }
  }, "/"), /*#__PURE__*/React.createElement("span", {
    style: {
      opacity: lang === 'en' ? 1 : 0.4
    }
  }, "EN")), /*#__PURE__*/React.createElement("button", {
    className: "nav-btn",
    onClick: () => setTheme(theme === 'dark' ? 'light' : 'dark'),
    title: "Toggle theme",
    "aria-label": "Toggle theme"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: theme === 'dark' ? 'sun' : 'moon',
    size: 16
  })), /*#__PURE__*/React.createElement("button", {
    className: "nav-mobile-toggle",
    onClick: () => setMobileOpen(o => !o),
    "aria-label": "Toggle menu"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: mobileOpen ? 'arrow-down' : 'menu',
    size: 16
  })))), /*#__PURE__*/React.createElement("div", {
    className: `nav-mobile-menu${mobileOpen ? ' open' : ''}`
  }, /*#__PURE__*/React.createElement("ul", null, mobileLinks.map(l => /*#__PURE__*/React.createElement("li", {
    key: l.id
  }, /*#__PURE__*/React.createElement("a", {
    href: `#${l.id}`,
    className: active === l.id ? 'active' : '',
    onClick: () => setMobileOpen(false)
  }, l.label))))));
};

// ---------- TWEAKS ----------
const TweaksUI = ({
  tweaks,
  setTweak,
  t
}) => {
  return /*#__PURE__*/React.createElement(TweaksPanel, {
    title: "Tweaks"
  }, /*#__PURE__*/React.createElement(TweakSection, {
    title: "Aspecto"
  }, /*#__PURE__*/React.createElement(TweakColor, {
    label: "Color de acento",
    value: tweaks.accent,
    onChange: v => setTweak('accent', v)
  }), /*#__PURE__*/React.createElement(TweakRadio, {
    label: "Tipograf\xEDa",
    value: tweaks.font,
    options: [{
      value: 'space',
      label: 'Space'
    }, {
      value: 'fraunces',
      label: 'Editorial'
    }, {
      value: 'mono',
      label: 'Mono'
    }],
    onChange: v => setTweak('font', v)
  }), /*#__PURE__*/React.createElement(TweakRadio, {
    label: "Hero variant",
    value: tweaks.heroVariant,
    options: [{
      value: 'photo-left',
      label: 'Foto'
    }, {
      value: 'centered',
      label: 'Centrado'
    }, {
      value: 'split',
      label: 'Terminal'
    }],
    onChange: v => setTweak('heroVariant', v)
  }), /*#__PURE__*/React.createElement(TweakSlider, {
    label: "Tagline",
    min: 0,
    max: window.TAGLINES.es.length - 1,
    step: 1,
    value: tweaks.taglineIdx,
    onChange: v => setTweak('taglineIdx', v)
  })), /*#__PURE__*/React.createElement(TweakSection, {
    title: "Secciones visibles"
  }, /*#__PURE__*/React.createElement(TweakToggle, {
    label: "Stack t\xE9cnico",
    value: tweaks.showStack,
    onChange: v => setTweak('showStack', v)
  }), /*#__PURE__*/React.createElement(TweakToggle, {
    label: "Materias",
    value: tweaks.showClasses,
    onChange: v => setTweak('showClasses', v)
  }), /*#__PURE__*/React.createElement(TweakToggle, {
    label: "Proyectos",
    value: tweaks.showProjects,
    onChange: v => setTweak('showProjects', v)
  }), /*#__PURE__*/React.createElement(TweakToggle, {
    label: "Blog",
    value: tweaks.showBlog,
    onChange: v => setTweak('showBlog', v)
  }), /*#__PURE__*/React.createElement(TweakToggle, {
    label: "Instagram",
    value: tweaks.showInstagram,
    onChange: v => setTweak('showInstagram', v)
  }), /*#__PURE__*/React.createElement(TweakToggle, {
    label: "YouTube",
    value: tweaks.showYoutube,
    onChange: v => setTweak('showYoutube', v)
  }), /*#__PURE__*/React.createElement(TweakToggle, {
    label: "Twitch",
    value: tweaks.showTwitch,
    onChange: v => setTweak('showTwitch', v)
  })));
};

// ---------- APP ----------
const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
  "accent": "#ffc932",
  "font": "space",
  "heroVariant": "photo-left",
  "taglineIdx": 0,
  "showStack": true,
  "showClasses": true,
  "showProjects": true,
  "showBlog": true,
  "showInstagram": true,
  "showYoutube": true,
  "showTwitch": true
} /*EDITMODE-END*/;
const App = () => {
  const [lang, setLang] = useState(() => localStorage.getItem('acenaga_lang') || 'es');
  const [theme, setTheme] = useState(() => localStorage.getItem('acenaga_theme') || 'dark');
  const [tweaks, setTweak] = useTweaks(TWEAK_DEFAULTS);
  const t = window.I18N[lang];

  // persist
  useEffect(() => {
    localStorage.setItem('acenaga_lang', lang);
  }, [lang]);
  useEffect(() => {
    localStorage.setItem('acenaga_theme', theme);
    document.documentElement.setAttribute('data-theme', theme);
  }, [theme]);

  // apply accent
  useEffect(() => {
    document.documentElement.style.setProperty('--accent', tweaks.accent);
  }, [tweaks.accent]);

  // apply font
  useEffect(() => {
    const map = {
      space: "'Space Grotesk', system-ui, sans-serif",
      fraunces: "'Fraunces', serif",
      mono: "'JetBrains Mono', monospace"
    };
    document.documentElement.style.setProperty('--f-display', map[tweaks.font]);
  }, [tweaks.font]);

  // reveal on scroll
  useEffect(() => {
    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('in');
      });
    }, {
      threshold: 0.1
    });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
    return () => obs.disconnect();
  }, [lang, tweaks.heroVariant, tweaks.showStack, tweaks.showClasses, tweaks.showProjects, tweaks.showBlog, tweaks.showInstagram, tweaks.showYoutube, tweaks.showTwitch]);

  // Konami easter egg
  useEffect(() => {
    const seq = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
    let i = 0;
    const handler = e => {
      if (e.key.toLowerCase() === seq[i].toLowerCase()) {
        i++;
        if (i === seq.length) {
          document.body.classList.toggle('crt-mode');
          showToast(document.body.classList.contains('crt-mode') ? '★ MODO CRT 90s ACTIVADO ★' : '✕ CRT MODE OFF');
          i = 0;
        }
      } else {
        i = 0;
      }
    };
    window.addEventListener('keydown', handler);
    return () => window.removeEventListener('keydown', handler);
  }, []);
  const sections = {
    about: true,
    stack: tweaks.showStack,
    classes: tweaks.showClasses,
    projects: tweaks.showProjects,
    blog: tweaks.showBlog,
    instagram: tweaks.showInstagram,
    youtube: tweaks.showYoutube,
    twitch: tweaks.showTwitch
  };
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(Nav, {
    t: t,
    lang: lang,
    setLang: setLang,
    theme: theme,
    setTheme: setTheme,
    sections: sections
  }), /*#__PURE__*/React.createElement(Hero, {
    t: t,
    lang: lang,
    taglineIdx: tweaks.taglineIdx,
    heroVariant: tweaks.heroVariant
  }), /*#__PURE__*/React.createElement(About, {
    t: t,
    lang: lang
  }), /*#__PURE__*/React.createElement(Stack, {
    t: t,
    visible: tweaks.showStack
  }), /*#__PURE__*/React.createElement(Classes, {
    t: t,
    lang: lang,
    visible: tweaks.showClasses
  }), /*#__PURE__*/React.createElement(Projects, {
    t: t,
    lang: lang,
    visible: tweaks.showProjects
  }), /*#__PURE__*/React.createElement(Blog, {
    t: t,
    lang: lang,
    visible: tweaks.showBlog
  }), /*#__PURE__*/React.createElement(Instagram, {
    t: t,
    visible: tweaks.showInstagram
  }), /*#__PURE__*/React.createElement(YouTube, {
    t: t,
    lang: lang,
    visible: tweaks.showYoutube
  }), /*#__PURE__*/React.createElement(Twitch, {
    t: t,
    lang: lang,
    visible: tweaks.showTwitch
  }), /*#__PURE__*/React.createElement(Social, {
    t: t
  }), /*#__PURE__*/React.createElement(Footer, {
    t: t
  }), /*#__PURE__*/React.createElement(TweaksUI, {
    tweaks: tweaks,
    setTweak: setTweak,
    t: t
  }));
};
function showToast(msg) {
  let toast = document.querySelector('.easter-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.className = 'easter-toast';
    document.body.appendChild(toast);
  }
  toast.textContent = msg;
  toast.classList.add('show');
  clearTimeout(window.__toastTimer);
  window.__toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
}
ReactDOM.createRoot(document.getElementById('root')).render(/*#__PURE__*/React.createElement(App, null));
