"use strict";(self.webpackChunkfe=self.webpackChunkfe||[]).push([[921],{6492:function(n,t,e){var a=e(1413),r=e(4925),s=e(184),i=["text","className"];t.Z=function(n){var t=n.text,e=n.className,c=(0,r.Z)(n,i);return(0,s.jsx)("button",(0,a.Z)((0,a.Z)({className:"btn btn-lg fs-6 ".concat(e)},c),{},{children:t}))}},7276:function(n,t,e){var a=e(2791),r=e(7689),s=e(184),i=function(){var n=(0,r.s0)();return(0,s.jsxs)("button",{className:"d-inline-flex align-items-center mb-3 btn text-primary",id:"buttonBack",onClick:function(){return n(-1)},children:[(0,s.jsx)("i",{className:"bi bi-arrow-left me-2"}),(0,s.jsx)("span",{children:"Kembali"})]})};t.Z=(0,a.memo)(i)},2921:function(n,t,e){e.r(t),e.d(t,{default:function(){return K}});var a=e(4165),r=e(5861),s=e(9439),i=e(2791),c=e(7689),u=e(1087),l=e(1413),o=e(4925),d=e(184),h=["judulSurat","children"],x=function(n){var t=n.judulSurat,e=n.children,a=(0,o.Z)(n,h);return(0,d.jsxs)("td",{className:"judul-surat form-control-input-surat",colSpan:3,children:[(0,d.jsx)("h2",{children:t}),(0,d.jsxs)("h2",{children:["NOMOR:",(0,d.jsx)("span",(0,l.Z)((0,l.Z)({},a),{},{children:e}))]})]})},m=e(7276),f=function(){var n=new Date;return{Y:n.getFullYear(),m:["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"][n.getMonth()],d:n.getDate(),date:n}};var j=e.p+"static/media/logo-kota.be20cb98929e5ac64101a8972527bfc1.svg",p=e(6492),b=e(7612),N=e(7903),v=e(4576),A=e(2047),S=(0,i.lazy)((function(){return e.e(453).then(e.bind(e,9453))})),k=(0,i.lazy)((function(){return e.e(277).then(e.bind(e,3744))})),g=(0,i.lazy)((function(){return e.e(377).then(e.bind(e,5377))})),Z=(0,i.lazy)((function(){return e.e(697).then(e.bind(e,8865))})),y=(0,i.lazy)((function(){return e.e(437).then(e.bind(e,9437))})),C=(0,i.lazy)((function(){return e.e(865).then(e.bind(e,3865))})),E=function(){var n,t=(0,c.UO)(),e=t.jenis_surat,l=t.id,o=t.type,h=e,E=(0,u.lr)(),K=(null===(n=(0,s.Z)(E,1)[0].get("nama"))||void 0===n?void 0:n.toUpperCase())||"",I=f(),T=I.Y,w=I.m,M=I.d,U=(0,v.Z)(),z=(0,c.s0)(),B=(0,i.useState)(),D=(0,s.Z)(B,2),L=D[0],P=D[1],J="form-control-input-surat";(0,i.useEffect)((function(){var n=function(){var n=(0,r.Z)((0,a.Z)().mark((function n(){var t;return(0,a.Z)().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,(0,b.U2)("surat/".concat(e,"/").concat(l));case 2:(t=n.sent).ok&&P(t.data);case 4:case"end":return n.stop()}}),n)})));return function(){return n.apply(this,arguments)}}();n()}),[e,l]);var R=function(){var n=(0,r.Z)((0,a.Z)().mark((function n(){var t,e,r,s;return(0,a.Z)().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return t=(0,N.f)(".".concat(J)),e=[],t.forEach((function(n,t){var a=n.dataset.name;e.push({name:a||"",value:n.textContent||""})})),r=U(e),n.next=6,(0,b.gz)("surat/".concat(l),r);case 6:s=n.sent,console.log(r),s.ok&&A.nz.fire({icon:"success",text:"Berhasil Menyimpan Data"}),setTimeout((function(){return z("/".concat(o,"/data-surat"))}),600);case 10:case"end":return n.stop()}}),n)})));return function(){return n.apply(this,arguments)}}();return(0,d.jsxs)(d.Fragment,{children:[(0,d.jsx)(m.Z,{}),(0,d.jsxs)("div",{className:"surat shadow rounded-3",children:[(0,d.jsx)("section",{id:"kop-surat",children:(0,d.jsx)("table",{children:(0,d.jsxs)("tbody",{children:[(0,d.jsxs)("tr",{children:[(0,d.jsx)("td",{className:"logo",colSpan:1,children:(0,d.jsx)("img",{src:j,alt:"logo-kelurahan"})}),(0,d.jsxs)("td",{className:"instansi",colSpan:2,children:[(0,d.jsx)("h3",{children:"PEMERINTAHAN KOTA BENGKULU"}),(0,d.jsx)("h3",{children:"KECAMATAN SINGARAN PATI"}),(0,d.jsx)("h1",{children:"KELURAHAN JEMBATAN KECIL"}),(0,d.jsx)("p",{children:"Jl. Rinjani ayam RT X Nomor 1 Kelurahan Jembatan Kecil Kota Bengkulu Tlp. (0736) 342645"})]})]}),(0,d.jsx)("tr",{children:(0,d.jsx)(x,{judulSurat:K,contentEditable:!0,suppressContentEditableWarning:!0,"data-name":"no_surat",children:"200/OK/VI/2004"})})]})})}),L&&(0,d.jsxs)(i.Suspense,{children:["Domisili"===h&&(0,d.jsx)(S,{dataSurat:L,formControlInputSurat:J}),"BelumMenikah"===h&&(0,d.jsx)(k,{dataSurat:L,formControlInputSurat:J}),"Skck"===h&&(0,d.jsx)(g,{dataSurat:L,formControlInputSurat:J}),"Sktm"===h&&(0,d.jsx)(Z,{dataSurat:L,formControlInputSurat:J}),"KeteranganUsaha"===h&&(0,d.jsx)(y,{dataSurat:L,formControlInputSurat:J}),"PengantarPernikahan"===h&&(0,d.jsx)(C,{})]}),(0,d.jsx)("section",{id:"tanda-tangan",children:(0,d.jsx)("table",{children:(0,d.jsx)("tbody",{children:(0,d.jsx)("tr",{children:(0,d.jsxs)("td",{colSpan:3,children:[(0,d.jsxs)("div",{className:"lokasi-tanggal",children:[(0,d.jsx)("p",{children:"DITETAPKAN DI : BENGKULU"}),(0,d.jsxs)("p",{children:["PADA TANGGAL : ","".concat(M," ").concat(w," ").concat(T)]})]}),(0,d.jsx)("div",{className:"lurah",children:(0,d.jsx)("p",{children:"KA. KELURAHAN JEMBATAN KECIL"})}),(0,d.jsxs)("div",{className:"ttd-lurah",children:[(0,d.jsx)("p",{children:"Lilis Suryani, SP."}),(0,d.jsx)("p",{children:"NIP. 198002092005022006"})]})]})})})})})]}),(0,d.jsxs)("div",{className:"action my-5 d-flex justify-content-end gap-3 px-5 mx-5",children:[(0,d.jsx)(p.Z,{className:"btn-primary",text:"Simpan",onClick:R}),(0,d.jsx)(p.Z,{className:"btn-info",text:"Cetak",onClick:function(){return window.print()}})]})]})},K=(0,i.memo)(E)}}]);
//# sourceMappingURL=921.961e7c74.chunk.js.map