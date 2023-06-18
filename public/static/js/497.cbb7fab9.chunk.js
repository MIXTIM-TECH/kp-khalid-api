"use strict";(self.webpackChunkfe=self.webpackChunkfe||[]).push([[497],{6131:function(a,e,n){var t=n(2791),s=n(184),r=function(a){var e=a.cardBody,n=a.cardClassName,t=a.cardHeader;return(0,s.jsxs)("div",{className:"card shadow ".concat(n),children:[t&&(0,s.jsx)("div",{className:"card-header",children:t}),e&&(0,s.jsx)("div",{className:"card-body",children:e})]})};e.Z=(0,t.memo)(r)},6492:function(a,e,n){var t=n(1413),s=n(4925),r=n(184),c=["text","className"];e.Z=function(a){var e=a.text,n=a.className,l=(0,s.Z)(a,c);return(0,r.jsx)("button",(0,t.Z)((0,t.Z)({className:"btn btn-lg fs-6 ".concat(n)},l),{},{children:e}))}},7276:function(a,e,n){var t=n(2791),s=n(7689),r=n(184),c=function(){var a=(0,s.s0)();return(0,r.jsxs)("button",{className:"d-inline-flex align-items-center mb-3 btn text-primary",id:"buttonBack",onClick:function(){return a(-1)},children:[(0,r.jsx)("i",{className:"bi bi-arrow-left me-2"}),(0,r.jsx)("span",{children:"Kembali"})]})};e.Z=(0,t.memo)(c)},5515:function(a,e,n){var t=n(2791),s=n(184),r=function(a){var e=a.children;return(0,s.jsx)("div",{className:"page-content-user",children:(0,s.jsx)("section",{className:"row",children:(0,s.jsx)("div",{className:"col-md-12 col-lg-12",children:e})})})};e.Z=(0,t.memo)(r)},8030:function(a,e,n){var t=n(1087),s=n(2791),r=n(20),c=n(184),l=function(a){var e=a.title,n=(0,r.a)().role;return(0,c.jsxs)(c.Fragment,{children:[(0,c.jsx)("header",{className:"mb-3",children:(0,c.jsx)(t.rU,{to:"#",className:"burger-btn d-block d-xl-none",children:(0,c.jsx)("i",{className:"bi bi-justify fs-3"})})}),(0,c.jsxs)("div",{className:"page-heading d-flex justify-content-between",children:[(0,c.jsx)("div",{className:"page-title",children:(0,c.jsx)("h3",{children:e})}),(0,c.jsxs)("div",{className:"user-avatar d-flex",children:[(0,c.jsx)("div",{className:"avatar bg-secondary me-2",style:{height:"32px"},children:(0,c.jsx)("span",{className:"avatar-content",children:(0,c.jsx)("i",{className:"bi bi-person text-primary"})})}),(0,c.jsx)(t.rU,{to:"/".concat(n,"/ubah-profil"),children:(0,c.jsxs)("p",{className:"avatar-detail pt-1",children:["user"===n?"User":"Admin"," JK"]})})]})]})]})};e.Z=(0,s.memo)(l)},9497:function(a,e,n){n.r(e),n.d(e,{default:function(){return Z}});var t=n(4165),s=n(5861),r=n(9439),c=n(2791),l=n(6131),i=n(7276),o=n(5515),d=n(8030),u=n(7689),m=n(1087),x=n(7612),f=n(1413),b=n(4925),h=n(184),j=["label","fileName","btnLabel","url","target"],v=function(a){var e=a.label,n=a.fileName,t=a.btnLabel,s=a.url,r=a.target,c=(0,b.Z)(a,j);return(0,h.jsxs)("div",{className:"row align-items-center mb-5",children:[(0,h.jsx)("p",{className:"mb-0",children:e}),(0,h.jsx)("p",{className:"col my-auto text-success",children:n}),(0,h.jsx)(m.rU,(0,f.Z)((0,f.Z)({className:"col-md-4 btn btn-success btn-lg fs-6",to:s,rel:"noreferrer",target:r},c),{},{children:t}))]})},N=n(7637),p=n(6492),g=n(2047),Z=function(){var a=(0,c.useState)(),e=(0,r.Z)(a,2),n=e[0],f=e[1],b=(0,u.UO)(),j=b.type,Z=b.id,k=b.jenis_surat,y=(0,c.useCallback)((0,s.Z)((0,t.Z)().mark((function a(){var e;return(0,t.Z)().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,(0,x.U2)("surat/".concat(k,"/").concat(Z));case 2:return(e=a.sent).ok&&f(e.data),console.log(e.data),a.abrupt("return");case 6:case"end":return a.stop()}}),a)}))),[k,Z]);(0,c.useEffect)((function(){y()}),[y]);return console.log(k),(0,h.jsxs)(h.Fragment,{children:[(0,h.jsx)(d.Z,{title:"Data Surat"}),(0,h.jsx)(i.Z,{}),(0,h.jsx)(o.Z,{children:(0,h.jsx)(l.Z,{cardHeader:(0,h.jsx)("h4",{className:"card-title text-success",children:"Detail Pengajuan Surat"}),cardClassName:"p-3 mt-3",cardBody:(0,h.jsxs)("form",{children:[(0,h.jsxs)("div",{className:"row",children:[(0,h.jsxs)("div",{className:"col-md-6",children:[(null===n||void 0===n?void 0:n.surat_pengantar)&&(0,h.jsx)(v,{label:"Surat Pengantar",fileName:"Surat Pengantar.pdf",btnLabel:"Lihat Surat",url:"/".concat(j,"/data-surat/").concat(k,"/").concat(Z,"/surat-pengantar?nama_file=").concat(n.surat_pengantar),target:"_blank"}),(0,h.jsx)(v,{label:"Surat yang Diajukan",fileName:"Surat ".concat(k),btnLabel:"Edit Surat",url:"/".concat(j,"/data-surat/").concat(k,"/").concat(Z,"/edit?nama=").concat(null===n||void 0===n?void 0:n.surat.info.nama)})]}),(0,h.jsx)("div",{className:"col-md-6",children:(0,h.jsx)(N.Z,{label:"NIK Pengaju Surat",id:"nik",name:"nik",defaultValue:null===n||void 0===n?void 0:n.surat.pemohon.nik,disabled:!0})})]}),(0,h.jsx)("div",{className:"row",children:(0,h.jsxs)("div",{className:"col-md-12 d-flex justify-content-end gap-3",children:[(0,h.jsx)(p.Z,{text:"Setujui",className:"btn-primary",onClick:function(a){var e,n=null===(e=a.currentTarget.dataset)||void 0===e?void 0:e.nik;(0,g.su)(function(){var a=(0,s.Z)((0,t.Z)().mark((function a(e){var s,r,c;return(0,t.Z)().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,(0,x.gz)("surat/upload/".concat(n),e);case 2:return s=a.sent,a.next=5,(0,x.r$)("surat/".concat(n,"/acc"));case 5:r=a.sent,console.log(r),s.ok&&(y(),g.nz.fire({icon:"success",text:null===(c=s.data)||void 0===c?void 0:c.message}));case 8:case"end":return a.stop()}}),a)})));return function(e){return a.apply(this,arguments)}}())},type:"button",disabled:null===n||void 0===n?void 0:n.surat.acc}),(0,h.jsx)(m.rU,{to:"/".concat(j,"/data-surat/").concat(k,"/").concat(Z,"/edit?nama=").concat(null===n||void 0===n?void 0:n.surat.info.nama),className:"btn btn-info btn-lg fs-6",children:"Cetak"})]})})]})})})]})}}}]);
//# sourceMappingURL=497.cbb7fab9.chunk.js.map