"use strict";(self.webpackChunkfe=self.webpackChunkfe||[]).push([[488],{6131:function(e,a,r){var t=r(2791),n=r(184),s=function(e){var a=e.cardBody,r=e.cardClassName,t=e.cardHeader;return(0,n.jsxs)("div",{className:"card shadow ".concat(r),children:[t&&(0,n.jsx)("div",{className:"card-header",children:t}),a&&(0,n.jsx)("div",{className:"card-body",children:a})]})};a.Z=(0,t.memo)(s)},7276:function(e,a,r){var t=r(2791),n=r(7689),s=r(184),c=function(){var e=(0,n.s0)();return(0,s.jsxs)("button",{className:"d-inline-flex align-items-center mb-3 btn text-primary",id:"buttonBack",onClick:function(){return e(-1)},children:[(0,s.jsx)("i",{className:"bi bi-arrow-left me-2"}),(0,s.jsx)("span",{children:"Kembali"})]})};a.Z=(0,t.memo)(c)},9487:function(e,a,r){var t=r(1413),n=r(184);a.Z=function(e){var a=e.props,r=e.nik;return(0,n.jsx)("button",(0,t.Z)((0,t.Z)({className:"text-danger btn p-0","data-nik":r},a),{},{children:(0,n.jsx)("i",{className:"bi bi-trash","data-feather":"delete-data"})}))}},2458:function(e,a,r){var t=r(1087),n=r(184);a.Z=function(e){var a=e.to;return(0,n.jsx)(t.rU,{to:a,className:"text-success",children:(0,n.jsx)("i",{className:"bi bi-pencil","data-feather":"edit-data"})})}},5515:function(e,a,r){var t=r(2791),n=r(184),s=function(e){var a=e.children;return(0,n.jsx)("div",{className:"page-content-user",children:(0,n.jsx)("section",{className:"row",children:(0,n.jsx)("div",{className:"col-md-12 col-lg-12",children:a})})})};a.Z=(0,t.memo)(s)},8030:function(e,a,r){var t=r(1087),n=r(2791),s=r(20),c=r(184),i=function(e){var a=e.title,r=(0,s.a)().role;return(0,c.jsxs)(c.Fragment,{children:[(0,c.jsx)("header",{className:"mb-3",children:(0,c.jsx)(t.rU,{to:"#",className:"burger-btn d-block d-xl-none",children:(0,c.jsx)("i",{className:"bi bi-justify fs-3"})})}),(0,c.jsxs)("div",{className:"page-heading d-flex justify-content-between",children:[(0,c.jsx)("div",{className:"page-title",children:(0,c.jsx)("h3",{children:a})}),(0,c.jsxs)("div",{className:"user-avatar d-flex",children:[(0,c.jsx)("div",{className:"avatar bg-secondary me-2",style:{height:"32px"},children:(0,c.jsx)("span",{className:"avatar-content",children:(0,c.jsx)("i",{className:"bi bi-person text-primary"})})}),(0,c.jsx)(t.rU,{to:"/".concat(r,"/ubah-profil"),children:(0,c.jsxs)("p",{className:"avatar-detail pt-1",children:["user"===r?"User":"Admin"," JK"]})})]})]})]})};a.Z=(0,n.memo)(i)},9671:function(e,a,r){r.d(a,{c:function(){return h},Z:function(){return f}});var t=r(2791),n=r(6131),s=r(4165),c=r(5861),i=r(7612),l=r(184),d=function(){var e=(0,t.useContext)(h),a=e.url,r=e.dispatch,n=function(){var e=(0,c.Z)((0,s.Z)().mark((function e(t){var n,c;return(0,s.Z)().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(a&&r){e.next=2;break}return e.abrupt("return");case 2:return n=o(a,t),e.next=5,(0,i.U2)(n);case 5:(c=e.sent).ok&&r(c.data);case 7:case"end":return e.stop()}}),e)})));return function(a){return e.apply(this,arguments)}}(),d=function(){var e=(0,c.Z)((0,s.Z)().mark((function e(a){var r;return(0,s.Z)().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a.preventDefault(),r=a.currentTarget.querySelector('[name="search"]'),n(r.value);case 3:case"end":return e.stop()}}),e)})));return function(a){return e.apply(this,arguments)}}(),o=function(e,a){return e?e.replace(":keyword",a):""},u=function(){var e=(0,c.Z)((0,s.Z)().mark((function e(a){var r;return(0,s.Z)().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!(r=a.currentTarget.value)){e.next=3;break}return e.abrupt("return");case 3:n(r);case 4:case"end":return e.stop()}}),e)})));return function(a){return e.apply(this,arguments)}}();return(0,l.jsx)("div",{className:"search",children:(0,l.jsx)("form",{className:"container-fluid",onSubmit:d,children:(0,l.jsxs)("div",{className:"input-group",children:[(0,l.jsx)("input",{type:"text",className:"form-control",name:"search",placeholder:"Cari berdasarkan NIK","aria-label":"NIK","aria-describedby":"basic-addon1",onKeyUp:u}),(0,l.jsx)("span",{className:"input-group-text",id:"basic-addon1",children:(0,l.jsx)("i",{className:"bi bi-search"})})]})})})},o=(0,t.memo)(d),u=function(e){var a=e.title;return(0,l.jsxs)("div",{className:"card-header d-flex justify-content-between",children:[(0,l.jsx)("h4",{className:"card-title",children:a}),(0,l.jsx)(o,{})]})},x=(0,t.memo)(u),h=(0,t.createContext)({}),m=function(e){var a=e.children,r=e.rowThead,t=e.title,s=e.search;return(0,l.jsx)(h.Provider,{value:s,children:(0,l.jsx)("div",{className:"row mt-5",children:(0,l.jsx)("div",{className:"col-12",children:(0,l.jsx)(n.Z,{cardClassName:"p-3",cardHeader:(0,l.jsx)(x,{title:t}),cardBody:(0,l.jsx)("div",{className:"table-responsive",children:(0,l.jsxs)("table",{className:"table table-hover mb-0 text-center",children:[(0,l.jsx)("thead",{children:r}),(0,l.jsx)("tbody",{children:a})]})})})})})})},f=(0,t.memo)(m)},6488:function(e,a,r){r.r(a);var t=r(4165),n=r(5861),s=r(9439),c=r(7689),i=r(1087),l=r(7637),d=r(7276),o=r(5515),u=r(8030),x=r(2791),h=r(7612),m=r(9671),f=r(2458),p=r(9487),j=r(6131),b=r(2047),v=r(184);a.default=function(){var e=(0,x.useState)(),a=(0,s.Z)(e,2),r=a[0],N=a[1],k=(0,c.UO)(),g=k.no_kk,Z=k.type,y=(0,x.useCallback)((0,n.Z)((0,t.Z)().mark((function e(){var a;return(0,t.Z)().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,(0,h.U2)("data-keluarga/".concat(g));case 2:return(a=e.sent).ok&&N(a.data),e.abrupt("return",a);case 5:case"end":return e.stop()}}),e)}))),[g]);(0,x.useEffect)((function(){y()}),[y]);var w=(0,v.jsxs)("tr",{children:[(0,v.jsx)("th",{children:"No"}),(0,v.jsx)("th",{children:"Nama"}),(0,v.jsx)("th",{children:"NIK"}),(0,v.jsx)("th",{colSpan:2,children:"ACTION"})]});return(0,v.jsxs)(v.Fragment,{children:[(0,v.jsx)(u.Z,{title:"Data Keluarga"}),(0,v.jsx)(d.Z,{}),(0,v.jsxs)(o.Z,{children:[(0,v.jsx)(j.Z,{cardHeader:(0,v.jsx)("h4",{className:"card-title text-success",children:"Detail Anggota Keluarga"}),cardClassName:"p-3",cardBody:(0,v.jsx)("form",{children:(0,v.jsx)("div",{className:"row",children:r&&(0,v.jsxs)(v.Fragment,{children:[(0,v.jsxs)("div",{className:"col-md-6",children:[(0,v.jsx)(l.Z,{label:"Nomor KK",type:"text",id:"no-kk",defaultValue:r.no_kk,disabled:!0}),(0,v.jsx)(l.Z,{label:"Nama Kepala Keluarga",type:"text",id:"nama-kepala-keluarga",defaultValue:r.kepala_keluarga.nama,disabled:!0}),(0,v.jsx)(l.Z,{label:"NIK Kepala Keluarga",type:"text",id:"nik-kepala-keluarga",defaultValue:r.kepala_keluarga.nik,disabled:!0}),(0,v.jsx)(l.Z,{label:"Nomor Whatsapp",type:"text",id:"no-wa",defaultValue:r.kepala_keluarga.no_whatsapp,disabled:!0})]}),(0,v.jsx)("div",{className:"col-md-6",children:(0,v.jsxs)("div",{className:"row align-items-center",children:[(0,v.jsx)("p",{className:"mb-0",children:"Foto KK"}),(0,v.jsx)("p",{className:"col my-auto text-success",children:"Foto KK"}),(0,v.jsx)(i.rU,{className:"col-md-4 btn btn-success btn-lg fs-6",to:"/".concat(Z,"/data-keluarga/").concat(g,"/foto-kk/"),rel:"noreferrer",target:"_blank",children:"Lihat Foto"})]})})]})})})}),(0,v.jsx)(m.Z,{title:"Tabel Data Keluarga",rowThead:w,search:{url:"",dispatch:N},children:r&&r.anggota_keluarga.map((function(e,a){var r=e.nama,s=e.nik;return(0,v.jsxs)("tr",{children:[(0,v.jsx)("td",{className:"text-bold-500",children:++a}),(0,v.jsx)("td",{children:r}),(0,v.jsx)("td",{children:s}),(0,v.jsxs)("td",{className:"d-flex justify-content-center align-items-center gap-2",children:[(0,v.jsx)(f.Z,{to:"/".concat(Z,"/data-keluarga/").concat(g,"/").concat(s)}),(0,v.jsx)(p.Z,{props:{onClick:function(){!function(e){(0,b.TX)((0,n.Z)((0,t.Z)().mark((function a(){var r;return(0,t.Z)().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,(0,h.ob)("anggota-keluarga/".concat(e,"?no_kk=").concat(g));case 2:if((r=a.sent).ok){a.next=5;break}return a.abrupt("return");case 5:return a.next=7,y();case 7:a.sent.ok&&b.nz.fire({icon:"success",text:r.data.message});case 9:case"end":return a.stop()}}),a)}))))}(s)}}})]})]},a)}))})]})]})}}}]);
//# sourceMappingURL=488.86078c04.chunk.js.map