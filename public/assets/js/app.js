document.addEventListener('DOMContentLoaded',()=>{
 const menu=document.querySelector('[data-mobile-menu]');const links=document.querySelector('.navlinks');if(menu&&links)menu.addEventListener('click',()=>{const isOpen=links.classList.toggle('open');menu.setAttribute('aria-expanded',String(isOpen));});
 const adminToggle=document.querySelector('[data-admin-toggle]');const sidebar=document.querySelector('.admin-sidebar');if(adminToggle&&sidebar)adminToggle.addEventListener('click',()=>sidebar.classList.toggle('open'));
 document.querySelectorAll('[data-confirm]').forEach(form=>form.addEventListener('submit',e=>{if(!window.confirm(form.dataset.confirm||'Are you sure?'))e.preventDefault();}));
 document.querySelectorAll('[data-image-fallback]').forEach(img=>img.addEventListener('error',function(){this.onerror=null;this.src=this.dataset.imageFallback;}));
 const mainPhoto=document.querySelector('[data-main-photo]');document.querySelectorAll('[data-thumb]').forEach(el=>el.addEventListener('click',()=>{if(mainPhoto)mainPhoto.src=el.dataset.thumb;}));
});
