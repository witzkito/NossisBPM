function confirmar(mensaje, url) {
    if(confirm(mensaje)) {
         document.location.href= url;
    }
}