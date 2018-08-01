/**
 * Created by vitor on 18/07/2018.
 */

function scrollSuave( id )
{
    var element = document.getElementById( id ) ;
    var rect = element.getBoundingClientRect();

    window.scroll({
        top: rect.top,
        left: 0,
        behavior: 'smooth'
    });
}

var timeout = null;

function selecionarHorario( element ) {

    $(".horario").removeClass("horario-selecionado") ;
    $(element).addClass("horario-selecionado") ;

    $("#horarioSelecionado").val( $(element).data("horario") ) ;

    $("#formulario").submit() ;
}

function selecionarData( element ) {

    clearTimeout(timeout);

    timeout = setTimeout(function () {

        $("#containerHorarios").html("");
        $("#containerHorarios").html('' +
            '<div class="preloader-wrapper big active">' +
            '   <div class="spinner-layer spinner-blue-only">' +
            '       <div class="circle-clipper left">' +
            '           <div class="circle"></div> ' +
            '       </div>' +
            '       <div class="gap-patch"> ' +
            '           <div class="circle"></div> ' +
            '       </div>' +
            '       <div class="circle-clipper right"> ' +
            '           <div class="circle"></div> ' +
            '       </div>' +
            '   </div> ' +
            '</div>');

        $.ajax({
            url: uri + "/api/agendamentos/horarios/dia/" + element.value,
            delay: 500
        }).done(function(data) {
            var horarios = JSON.parse(data) ;
            imprimirHorarios( horarios ) ;
        });
    }, 500) ;
}

function imprimirHorarios( horarios )
{
    $("#containerHorarios").html("");

    for( var x = 0 ; x < horarios.length ; x++ ) {
        var divRow = document.createElement("div");
        $(divRow).addClass("col s2");

        var divButton = document.createElement("div");
        $(divButton).addClass("horario waves-effect waves-light z-depth-1") ;

        if( horarios[x].status == true ) {
            $(divButton).addClass("horario-disponivel") ;
        } else {
            $(divButton).addClass("horario-ocupado") ;
        }

        $(divButton).on("click", function () {
            selecionarHorario(this)
        });

        $(divButton).attr("data-horario", horarios[x].horario);
        $(divButton).html(horarios[x].horario);

        $(divRow).append(divButton) ;

        $("#containerHorarios").append(divRow);
    }
}

function getOffset( el ) {
    var _x = 0;
    var _y = 0;
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    return { top: _y, left: _x };
}