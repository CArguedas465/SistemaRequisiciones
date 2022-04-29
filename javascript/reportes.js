function validacionReporte()
{
    var tipoReporte = document.getElementById('_TipoReporte').value;
    var rangoReporte = document.getElementById('_RangoReporte');

    if (tipoReporte == 'N/A' || rangoReporte == 'N/A')
    {
        alert("Se debe seleccionar un tipo de reporte y su rango respectivo para poder continuar.");
        return;
    }

    var form = document.getElementById('formularioReportes');
    form.submit();
}