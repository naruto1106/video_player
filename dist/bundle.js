(() => { var t = { 252: () => { const t = document.getElementsByClassName("gameCanvas"), e = document.getElementById("canvas-source"), n = document.getElementById("canvas-replica"), o = document.getElementById("canvas-replica-loaded-image"), a = document.getElementById("tool-erase-canvases"), d = document.getElementById("tool-compare-canvases"), c = document.getElementById("tool-output-overlap"), l = document.getElementById("comparison__canvas"), s = document.getElementById("comparison__canvas_1"), r = document.getElementById("comparison__canvas_1_resized"), i = document.getElementById("comparison__canvas_2"), g = document.getElementById("comparison__canvas_2_resized"), m = t => { const e = t.offsetWidth, n = t.offsetHeight; t.setAttribute("width", e), t.setAttribute("height", n) }; let u = { x: 0, y: 0 }, h = !1; const f = (t, e) => { u.x = e.clientX - t.offsetLeft, u.y = e.clientY - t.offsetTop }, v = (t, e) => { e.preventDefault(), e.stopPropagation(); const n = e.touches[0]; u.x = n.clientX - (t.offsetLeft - window.scrollX), u.y = n.clientY - (t.offsetTop - window.scrollY) }, p = (t, e, n) => { h = !0, "touch" == n ? v(t, e) : f(t, e) }, I = () => { h = !1 }, E = (t, e, n) => { h && (ctx = t.getContext("2d"), ctx.beginPath(), ctx.lineWidth = 30, ctx.lineCap = "round", ctx.strokeStyle = "black", ctx.moveTo(u.x, u.y), "touch" == n ? v(t, e) : f(t, e), ctx.lineTo(u.x, u.y), ctx.stroke()) }; for (let e = 0; e < t.length; e++)m(t[e]), t[e].addEventListener("mousedown", (n => { p(t[e], n, "mouse") })), t[e].addEventListener("pointerup", I), t[e].addEventListener("pointerout", I), t[e].addEventListener("touchcancel", I), t[e].addEventListener("mousemove", (n => { E(t[e], n, "mouse") })), t[e].addEventListener("touchstart", (n => { p(t[e], n, "touch") })), t[e].addEventListener("touchmove", (n => { E(t[e], n, "touch") })); const w = t => { const e = t.getContext("2d").getImageData(0, 0, t.width, t.height).data; let n = 0; const o = Array.from(e).filter((() => 3 === n ? (n = 0, !0) : (n++, !1))); let a = null, d = null, c = t.width, l = 0; for (y = 0; y < o.length - t.width; y += t.width) { const e = o.slice(y, y + t.width); if (e.some((t => t > 0))) { null === a && (a = 0 == y ? 0 : y / t.width), d = y / t.width; let n = null, o = null; for (x = 0; x < e.length; x++)e[x] && (null === n && (n = x), o = x); n < c && (c = n), o > l && (l = o) } } return { left: c, top: a, width: l - c, height: d - a } }; a.addEventListener("click", (() => { for (let e = 0; e < t.length; e++)t[e].getContext("2d").clearRect(0, 0, t[e].offsetWidth, t[e].offsetHeight); c.textContent = "", l.innerHTML = "", o.style.backgroundImage = "" })), d.addEventListener("click", (() => { ((t, e, n, a) => { const d = s.getContext("2d"), l = r.getContext("2d"), m = i.getContext("2d"), u = g.getContext("2d"), h = t.getContext("2d").getImageData(n.left, n.top, n.width, n.height), y = e.getContext("2d").getImageData(a.left, a.top, a.width, a.height); d.putImageData(h, 0, 0), l.scale(400 / n.width, 400 / n.height), l.drawImage(s, 0, 0), m.putImageData(y, 0, 0), u.scale(400 / a.width, 400 / a.height), u.drawImage(i, 0, 0); const f = l.getImageData(0, 0, 400, 400).data, x = u.getImageData(0, 0, 400, 400).data; let v, p = 0, I = 0, E = 0; for (let t = 0; t < f.length / 4; t++)0 !== f[4 * t + 3] ? (I++, f[4 * t + 3] === x[4 * t + 3] && p++) : 0 === f[4 * t + 3] && 0 !== x[4 * t + 3] && E++; v = E > I ? 0 : Math.ceil(p / I * 100), o.style.backgroundImage && (console.log("loaded"), 1.5 * v > 100 ? v = Math.ceil(85 + 13 * Math.random()) : marg = 1.1 * v), c.textContent = v + "%", l.scale(n.width / 400, n.height / 400), u.scale(a.width / 400, a.height / 400) })(e, n, w(e), w(n)) })) }, 415: () => { const t = document.getElementById("load-image-to-source"), e = document.getElementById("canvas-replica-loaded-image"); t.addEventListener("click", (function () { const t = document.getElementById("source-image"); document.getElementById("canvas-source").getContext("2d").drawImage(t, 0, 0), e.style.backgroundImage = `url('${t.getAttribute("src")}')` })) } }, e = {}; function n(o) { var a = e[o]; if (void 0 !== a) return a.exports; var d = e[o] = { exports: {} }; return t[o](d, d.exports, n), d.exports } n.n = t => { var e = t && t.__esModule ? () => t.default : () => t; return n.d(e, { a: e }), e }, n.d = (t, e) => { for (var o in e) n.o(e, o) && !n.o(t, o) && Object.defineProperty(t, o, { enumerable: !0, get: e[o] }) }, n.o = (t, e) => Object.prototype.hasOwnProperty.call(t, e), (() => { "use strict"; n(252), n(415) })() })();