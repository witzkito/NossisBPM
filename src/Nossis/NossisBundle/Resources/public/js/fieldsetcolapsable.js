    function construirFieldSetColapsables()
{
    var fsets = document.getElementsByTagName('fieldset');
    var fset = null;
    for (var i = 0; i < fsets.length; i++)
    {
        fset = fsets[i];
        if (fset.attributes['colapsado'] != null)
            construirFieldSetColapsable(fset, fset.attributes['colapsado'].value);
    }
}

// colapsa un fieldset especifico
function construirFieldSetColapsable(fset, colapsado)
{
    //main content:
    var divContenido = fset.getElementsByTagName('div')[0];
    if (divContenido == null)
        return;

    if (colapsado == 'true')
        divContenido.style.display = 'none';

    //+/- ahref:
    var ahrefText = getAlternadorAHref(colapsado);

    //leyenda:
    var leyenda = fset.getElementsByTagName('legend')[0];
    if (leyenda != null)
        leyenda.innerHTML = ahrefText + leyenda.innerHTML;
    else
        fset.innerHTML = '<legend>' + ahrefText + '</legend>' + fset.innerHTML;
}

function getAlternadorAHref(colapsado)
{
    var ahrefText = "<a onClick='alternadorFieldset(this.parentNode.parentNode);' style='text-decoration: none;'>";
    ahrefText = ahrefText + getItemExpansor(colapsado) + "</a>&nbsp;";
    return ahrefText;
}

function getItemExpansor(colapsado)
{
    var ecChar;
    if (colapsado == 'true')
        ecChar = '+';
    else
        ecChar = '-';

    return ecChar;
}

function alternadorFieldset(fset)
{
    var ahref = fset.getElementsByTagName('a')[0];
    var div = fset.getElementsByTagName('div')[0];

    if (div.style.display != "none")
    {
        ahref.innerHTML = getItemExpansor('true');
        div.style.display = 'none';
    }
    else
    {
        ahref.innerHTML = getItemExpansor('false');
        div.style.display = '';
    }
}