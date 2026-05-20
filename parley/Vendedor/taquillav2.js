$(document).ready(init);
var directorio = '/parleyven.com.ve'; //Variable se llena cuando esta local
var macuare = 'N';

String.prototype.trim = function() {
    return this.replace(/^\s*|\s*$/g, '');
};
String.prototype.endsWith = function(str) {
    return this.match(str + '$') == str;
};
String.prototype.startsWith = function(str) {
    return this.match('^' + str) == str;
};
var ultimoErrorCombinacion = '';
var imprime = '';
var isTaquilla = true;
var logrosCalc = new Array();
var reglasPago = null;
var pagoVeces = new Array();
var pagoMonto = new Array();
window.habilitado = true;
var impresion_click = false;

function init() {
    //toastr.success('Modulo Taquilla', "Listo !!!");

    $('#logroSoccer').DataTable({
        info: false,
        lengthChange: false,
    });

    window.onerror = function(msg, url, line) {
        //swal("Mensaje del Sistema", "Message : " + msg + "\nUrl : " + url + "\nLine : "+ line, "error");
        toastr.error(
            'Mensaje del Sistema',
            'Message : ' + msg + '\nUrl : ' + url + '\nLine : ' + line,
            'error'
        );
        return true;
    };
    $(document).on('click', '#copy_clipboard', function() {
        $('#informacion_ticket').focus();
        $('#informacion_ticket').select();
        document.execCommand('copy');
        toastr.success('Datos del Ticket Copiados Correctamente', 'Listo !!!');
    });
    $('#btnImprimir').click(imprimirTicket); // evento click de jquery que llamamos al metodo nuevos
    $('#btnEmail').click(envioEmail); // evento click de jquery que llamamos al metodo nuevos
    $('#btnSms').click(envioSms); // evento click de jquery que llamamos al metodo nuevos
    $('form#form').submit(enviar);
    $('[data-toggle="tooltip"]').tooltip();
}

function changeCellClick(el) {
    if (el.onclick == null) {
        el.onclick = function() {
            //var check = verif_hora(el.className);
            //console.log(check);
            //if (check == 0) {
            var hacer = calcular(el.onmouseout !== null, el.className);
            console.log(hacer);
            if (hacer) {
                if (el.onmouseout == null) {
                    changeCellOut(el);
                    el.onmouseout = function() {
                        el.style.background = '';
                        el.style.color = '#000000';
                    };
                } else {
                    el.onmouseout = null;
                    el.style.background = '#ff4800';
                    el.style.color = '#000000';
                }
            }
            //}
        };
    }
}

function changeCell(el) {
    if (el.innerHTML.replace(/{{br}}/g, '') != '') {
        el.style.background = '#ff4800';
        el.style.cursor = 'pointer';
        el.style.color = '#000000';
        changeCellClick(el);
    }
}

function changeCellOut(el) {
    el.style.color = '#000000';
    el.style.background = '';
}

function verif_hora(val) {
    var v = val.split(',');
    var deporte = v[9];
    var referencia_mismarcadores = v[10];
    var hora_juego = v[11];
    var mismarca = v[12];
    var theResponse = null;
    $.ajax({
        url: 'cuotas_mismarcadores/verificarHoraJuego',
        data: {
            ref: referencia_mismarcadores,
            hora: hora_juego,
            deporte: deporte,
            mismarca: mismarca,
        },
        type: 'GET',
        dataType: 'html',
        async: false,
        success: function(result) {
            console.log('Result' + result);
            //return result;
            //alert();
            theResponse = result;
        },
    });
    return theResponse;
}

function calcular(checked, val) {
    $.ajaxSetup({
        //This will change behavior of all subsequent ajax requests!!
        async: false,
    });
    var v = val.split(',');
    var id = v[0];
    var tipo = v[1];
    var cantidad = v[2];
    var ref = v[3];
    var logro = v[4] > 0 ? '+' + v[4] : v[4];
    var nombre = v[5];
    var juego = v[6];
    var numero = v[7];
    var padre = v[8];
    var deporte = v[9];
    console.log('Deporte ' + deporte);
    if (deporte != 20) {
        if (
            tipo == 'A' ||
            tipo == 'B' ||
            tipo == '5A' ||
            tipo == '5B' ||
            tipo == 'RL' ||
            tipo == '5RL' ||
            tipo == 'SR' ||
            tipo == 'AG'
        ) {
            ref = ref.substring(1);
            if (parseFloat(cantidad) == 0) {
                //alert("La combinacion elegida no es valida: Punto esta en cero.");
                toastr.error(
                    'La combinacion elegida no es valida: Punto esta en cero',
                    ' Error !!!'
                );
                return false;
            }
        }
        if (parseInt(logro) == 0) {
            //alert("La combinacion elegida no es valida: Logro esta en cero.");
            toastr.error(
                'La combinacion elegida no es valida: Logro esta en cero',
                ' Error !!!'
            );
            //alert("El logro esta en cero.");
            return false;
        }
        /*if(deportes == "3"){
            if(tipo == 'A' || tipo == '5A'){
                if(parseFloat(cantidad) > mxaltafut){
                    alert("La combinacion elegida no es valida: Reformule su apuesta.");
                    return false;
                }
            }    
        }*/
        if (checked) {
            if (logrosCalc.length >= com_bax) {
                //alert("No puede exceder la cantidad de logros por apuesta");
                toastr.error(
                    'No puede exceder la cantidad de logros por apuesta',
                    ' Error !!!'
                );
                return false;
            }
            console.log(logrosCalc);
            console.log(padre);
            console.log(numero);
            console.log(nombre);
            console.log(ref);
            console.log(deporte);
            var isValid = isValido(logrosCalc, padre, numero, nombre, ref, deporte);
            if (isValid == -1) {
                //alert("La combinacion elegida no es valida: "+ultimoErrorCombinacion);



                toastr.error(
                    'La combinacion elegida no es valida: ' + ultimoErrorCombinacion,
                    ' Error !!!'
                );
                return false;
            } else if (isValid == -2) {
                //alert("Los juegos seleccionados no se pueden combinar en una misma apuesta");
                toastr.error(
                    'Los juegos seleccionados no se pueden combinar en una misma apuesta',
                    ' Error !!!'
                );
                return false;
            }
            // verificamos que no este duplicado el logro
            for (var m = 0; m < logrosCalc.length; m++) {
                if (logrosCalc[m].codigo == id && logrosCalc[m].tipo == tipo) {
                    return false;
                }
            }
            var hembra = 0;
            var macho = 0;
            var futbol = 0;
            var beisbol = 0;
            var basket = 0;
            var otros = 0;
            if (logrosCalc.length) {
                for (var y = 0; y < logrosCalc.length; y++) {
                    if (logrosCalc[y].logro > 0) {
                        hembra++;
                    } else {
                        macho++;
                    }
                    var deportes = logrosCalc[y].deporte;
                    switch (deportes) {
                        case '3': //Futbol
                            if (deporte == deportes) {
                                futbol++;
                            }
                            break;
                        case '4': //Beisbol
                            if (deporte == deportes) {
                                beisbol++;
                            }
                            break;
                        case '6': //basket
                            if (deporte == deportes) {
                                basket++;
                            }
                            break;
                        default:
                            //Otros
                            if (deporte == deportes) {
                                otros++;
                            }
                            break;
                    }
                }
                if (logro > 0) {
                    hembra++;
                    futbol++;
                    beisbol++;
                    basket++;
                    otros++;
                } else {
                    macho++;
                    futbol++;
                    beisbol++;
                    basket++;
                    otros++;
                }
            }
            if (comb_hembra != 0) {
                if (hembra > comb_hembra) {
                    //alert("Advertencia!. M�ximo Hembras por combinaciÃƒÆ’Ã‚Â³n "+comb_hembra+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo Hembras por combinaci�n ' +
                        comb_hembra +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            } else if (mxhemper != 'N') {
                if (hembra > parseInt(mxhemper)) {
                    //alert("Advertencia!. M�ximo Hembras por combinaciÃƒÆ’Ã‚Â³n "+mxhemper+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo Hembras por combinaci�n ' +
                        comb_hembra +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            if (mxmachper != 'N') {
                if (macho > parseInt(mxmachper)) {
                    //alert("Advertencia!. M�ximo Machos por combinaciÃƒÆ’Ã‚Â³n "+mxmachper+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo Machos por combinaci�n ' +
                        mxmachper +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            if (mxcombft != 'N') {
                if (futbol > parseInt(mxcombft)) {
                    //alert("Advertencia!. M�ximo combinaciones por juego Futbol "+mxcombft+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo combinaciones por juego Futbol ' +
                        mxcombft +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            if (mxcombbs != 'N') {
                if (beisbol > parseInt(mxcombbs)) {
                    //alert("Advertencia!. M�ximo combinaciones por juego Beisbol "+mxcombbs+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo combinaciones por juego Beisbol ' +
                        mxcombbs +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            if (mxcombbk != 'N') {
                if (basket > parseInt(mxcombbk)) {
                    //alert("Advertencia!. M�ximo combinaciones por juego Basket "+mxcombbk+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo combinaciones por juego Basket ' +
                        mxcombbk +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            if (mxcombotr != 'N') {
                if (otros > parseInt(mxcombotr)) {
                    //alert("Advertencia!. M�ximo combinaciones por juego Otros "+mxcombotr+" logros.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'M�ximo combinaciones por juego Otros ' +
                        mxcombotr +
                        ' logros.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            logrosCalc[logrosCalc.length] = {
                codigo: id,
                tipo: tipo,
                cantidad: cantidad,
                referencia: ref,
                logro: logro,
                equipo: nombre,
                juego: juego,
                numero: numero,
                padre: padre,
                deporte: deporte,
            };
        } else {
            for (var m = 0; m < logrosCalc.length; m++) {
                if (logrosCalc[m].codigo == id && logrosCalc[m].tipo == tipo) {
                    logrosCalc.splice(m, 1);
                    break;
                }
            }
        }
        llenarCalculadora(logrosCalc, reglasPago);
    } else {
        if (checked) {
            // verificamos que no este duplicado el logro
            for (var m = 0; m < logrosCalc.length; m++) {
                if (
                    logrosCalc[m].cantidad == cantidad &&
                    logrosCalc[m].padre == padre
                ) {
toastr.warning(
                        'No puede seleccionar 2 ejemplares en la misma Valida.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
            logrosCalc[logrosCalc.length] = {
                codigo: id,
                tipo: tipo,
                cantidad: cantidad,
                referencia: ref,
                logro: logro,
                equipo: nombre,
                juego: juego,
                numero: numero,
                padre: padre,
                deporte: deporte,
            };
        } else {
            for (var m = 0; m < logrosCalc.length; m++) {
                if (
                    logrosCalc[m].cantidad == cantidad &&
                    logrosCalc[m].padre == padre
                ) {
                    logrosCalc.splice(m, 1);
                    break;
                }
            }
        }
        llenarCalculadora(logrosCalc, reglasPago);
    }
    return true;
}

function llenarCalculadora(logrosCalcPadre, reglasPagoPadre) {
    logrosCalc = logrosCalcPadre;
    reglasPago = reglasPagoPadre;
    limpiar();
    with(document.forms[0]) {
        premio(null, null);
        for (var k = 0; k < logrosCalc.length; k++) {
            codigo[k].value = logrosCalc[k].codigo;
            tipo[k].value = logrosCalc[k].tipo;
            referencia[k].value = logrosCalc[k].referencia;
            cantidad[k].value = logrosCalc[k].cantidad;
            logro[k].value = logrosCalc[k].logro;
            equipo[k].value = logrosCalc[k].equipo;
            juego[k].value = logrosCalc[k].juego;
            numero[k].value = logrosCalc[k].numero;
            padre[k].value = logrosCalc[k].padre;
            deporte[k].value = logrosCalc[k].deporte;
            descrip[k].value =
                logrosCalc[k].equipo +
                ' ' +
                logrosCalc[k].tipo +
                ' ' +
                logrosCalc[k].cantidad +
                ' ' +
                logrosCalc[k].logro;
            // si es juego teaser ocultamos el logro
            logro[k].style.color = '#fff';
            if (logrosCalc[k].referencia.charAt(0) == 'T') {
                logro[k].style.color = '#000';
            }
            premio(null, null);
        }
    }
}

function dosDecimales(n) {
    let t = n.toString();
    let regex = /(\d*.\d{0,2})/;
    return t.match(regex)[0];
}

function premio(key, obj) {

    if (macuare === 'N') {
        if (obj != null && typeof obj != 'undefined') {
            obj.value = obj.value.replace(/[^0-9.]/g, '');
            obj.value = obj.value.replace(/(^0)/g, '');
            
            
        }
        with(document.forms[0]) {
            montoPremio.value = 0;
            var cuenta = false;
            var apuesta = 0;
            try {
                var cuenta =
                    montoApostar.value != '' && parseFloat(montoApostar.value) > 0 ?
                    true :
                    false;
                apuesta = parseFloat(montoApostar.value);
            } catch (e) {}
            for (var y = 0; y < logrosCalc.length; y++) {
                if (cuenta) {
                    if (logro[y].value > 0) {
                        apuesta =
                            apuesta + apuesta * (logro[y].value / parseInt(fact_mult_hem));
                    } else if (logro[y].value < 0) {
                        apuesta =
                            apuesta +
                            apuesta / ((logro[y].value * -1) / parseInt(fact_mult_mac));
                    }

                    montoPremio.value = dosDecimales(apuesta); //Math.round(apuesta);
                }
            }

            montoApuesta = parseInt(montoApostar.value);
            montoMaximo = 0;
            totalPremio = montoPremio.value;



        }
    } else {
        with(document.forms[0]) {
            montoPremio.value = 0;
            var cuenta = false;
            var apuesta = 0;
            // aplicamos las reglas
            montoApuesta = parseInt(montoApostar.value);
            //alert(montoApuesta)
            montoMaximo = 0;
            //alert(pago_macuare)
            montoPremio.value = Math.round(
                parseInt(montoApuesta) * parseInt(pago_macuare)
            );
            totalPremio = montoPremio.value;

            //if(key && key.keyCode == 13){
            //alert('2')
            ///if(confirm("Desea crear el ticket","Mensaje")) {
            //$("#DialogoAjax").dialog("open");
            /*if(window.parent.send(document.forms[0])){
                                  document.forms[0].submit();
                          }*/
            //} else {
            //   try {
            //document.forms[0].numeroRef.focus();
            // } catch(e){}
            // }
            //  }
        }

    }
}

function limpiar() {
    console.log(document.forms[0]);
    with(document.forms[0]) {
        for (var f = 0; f < comb_max; f++) {
            codigo[f].value = '';
            tipo[f].value = '';
            cantidad[f].value = '';
            referencia[f].value = '';
            equipo[f].value = '';
            logro[f].value = '';
            juego[f].value = '';
            numero[f].value = '';
            numero[f].value = '';
            padre[f].value = '';
            deporte[f].value = '';
            descrip[f].value = '';
        }
    }
}

function isValido(jug, j, n, nombre, ref, deporte) {
    //alert(deporte)
    console.log(deporte);
    ultimoErrorCombinacion = '';
    //alert(jug+' '+j+' '+n+' '+nombre+' '+ref+' '+deporte);
    //logrosCalc,padre,numero,nombre,ref,deporte
    // validamos por id de juego
    var bloqueados = ',80476-80466,';
    for (var p = 0; p < jug.length; p++) {
        var r1 = ',' + j + '-' + jug[p].juego + ',';
        var r2 = ',' + jug[p].juego + '-' + j + ',';
        if (bloqueados.indexOf(r1) != -1 || bloqueados.indexOf(r2) != -1) {
            return -2;
        }
    }
    /*if(deporte==7 || deporte==17 || deporte==45){
              deporte=4
      } else if(deporte==15){
              deporte=6*/
    /*} else if(deporte==8) {
              deporte==37*/
    //}
    var error = new Array();
    error[1] = error_nhl.split(',');
    error[3] = error_futbol.split(',');
    error[4] = error_beisbol.split(',');
    error[5] = error_nfl.split(',');
    error[6] = error_basket.split(',');
    error[37] = error_otros.split(',');
    error[8] = '1-5,1-25,5-1,5-25'.split(',');
    error[9] = error_otros.split(',');
    error[10] = error_esports.split(',');
    error[11] = error_esports.split(',');
    error[12] = error_otros.split(',');
    error[13] = error_esports.split(',');
    error[14] = error_otros.split(',');
    error[15] = error_otros.split(',');
    // verificamos si hay jugada teaser
    var refTeaser = false;
    //window.frames.frmCalculadora.document.forms[0].teaser.value='false';
    //document.forms[0].teaser.value='false';
    $('#teaser').val('false');
    for (var k = 0; k < logrosCalc.length; k++) {
        if (logrosCalc[k].deporte == '30') {
            refTeaser = true;
            break;
        }
    }
    if (refTeaser || (ref.charAt(0) == 'T' && logrosCalc.length == 0)) {
        if (ref.charAt(0) != 'T') {
            return -1;
        }
        var refA = ref.substring(0, ref.length - 2);
        var refAZ = ref.substring(ref.length - 2, ref.length - 1);
        var refNO;
        var nRef = parseInt(ref.substring(1, ref.length - 1));
        var refNO = 'T' + (nRef % 2 == 0 ? nRef - 1 : nRef + 1) + '.';
        //alert(refNO);
        // buscamos la referencia no aceptada
        for (var x = 0; x < logrosCalc.length; x++) {
            //alert(logrosCalc[x].referencia.substring(0,logrosCalc[k].referencia.length-1));
            if (refNO == logrosCalc[x].referencia) {
                return -1;
            }
        }
        //window.frames.frmCalculadora.document.forms[0].teaser.value='true';
        document.forms[0].teaser.value = 'true';
        return 0;
    } else {
        if (ref.charAt(0) == 'T') {
            return -1;
        }
    }
    if (error[deporte].length == 0) {
        return -1;
    }
    var con = 0;
    var todos = n;
    var sep = '-';
    for (var p = 0; p < jug.length; p++) {
        //alert(parseInt(jug[p].padre)+"  "+parseInt(j));
        if (parseInt(jug[p].padre) === parseInt(j)) {
            todos += sep + jug[p].numero;
            con++;
        }
    }
    //alert(todos)
    if (con === 0) {
        return 0;
    }
    var todos = permuta(todos.split('-'));
    // alert(todos)
    todos = ',' + todos + ',';
    //alert(todos)
    for (var x = 0; x < error[deporte].length; x++) {
        if (error[deporte][x].trim() == '') return -1;
        if (todos.indexOf(',' + error[deporte][x] + ',') != -1) {
            //alert(error[deporte][x])
            //alert(todos.indexOf(','+error[deporte][x]+','))
            ultimoErrorCombinacion = error[deporte][x];
            //alert(ultimoErrorCombinacion)
            return -1;
        }
    }
    return 0;
}

function permuta(letras) {
    var perm = new Array();
    for (var i = 0; i < letras.length; i++) {
        for (var k = 0; k < letras.length; k++) {
            if (letras[i] != letras[k]) {
                perm[perm.length] = letras[i] + '-' + letras[k];
            }
        }
    }
    return perm.join(',');
}

function enviar(e) {
    e.preventDefault(); // para que no se recargue la pagina



    send(document.forms[0]);



}

function send(forma) {
    if (macuare === 'N') {
        //if(isEmptyInt(forma.montoApostar,"El Monto Apostar",2,10)){return false;}
        if (jugada_minima_ve > 0) {
            if (parseFloat(forma.montoApostar.value) < jugada_minima_ve) {
                //alert("Advertencia!. El monto minimo a jugar es de Bs. "+jugada_minima_ve);
                toastr.warning(
                    'El monto minimo a jugar es de ' + jugada_minima_ve,
                    ' Advertencia !!!'
                );
                return false;
            }
        } else {
            if (parseFloat(forma.montoApostar.value) < jugada_minima) {
                //alert("Advertencia!. El monto minimo a jugar es de Bs. "+jugada_minima+".");
                toastr.warning(
                    'El monto minimo a jugar es de ' + jugada_minima + '.',
                    ' Advertencia !!!'
                );
                return false;
            }
        }
        if (jugada_maxima_ve > 0) {
            if (parseFloat(forma.montoApostar.value) > jugada_maxima_ve) {
                //alert("Advertencia!. El monto minimo a jugar es de Bs. "+jugada_minima_ve);
                toastr.warning(
                    'El monto m�ximo a jugar es de ' + jugada_maxima_ve,
                    ' Advertencia !!!'
                );
                return false;
            }
        }
        if (tipo_taquilla == 'C') {
            if (parseFloat(forma.montoApostar.value) > parseFloat(acreditacion)) {
                //alert("Advertencia!. Saldo disponible de Bs. "+acreditacion+".\n\nPor favor reformule su apuesta.");
                toastr.warning(
                    'Saldo disponible de ' +
                    acreditacion +
                    '.\n\nPor favor reformule su apuesta.',
                    ' Advertencia !!!'
                );
                return false;
            }
        }
        if (logrosCalc.length <= 0) {
            //alert("Advertencia!. No hay apuestas.");
            toastr.warning('No hay apuestas.', ' Advertencia !!!');
            return false;
        }
        if (logrosCalc.length < comb_min) {
            //alert("Advertencia!. Debe seleccionar al menos "+comb_min+" combinaciones para efectuar la apuesta.");
            toastr.warning(
                'Debe seleccionar al menos ' +
                comb_min +
                ' combinaciones para efectuar la apuesta.',
                ' Advertencia !!!'
            );
            return false;
        }
        if (parseInt(forma.montoPremio.value) == 0) {
            //alert("Advertencia!. No hay premio para esta apuesta.");
            toastr.warning('No hay premio para esta apuesta.', ' Advertencia !!!');
            return false;
        }
        if (parseFloat(factor_pago) > 0) {
            var total_factor =
                parseInt(forma.montoApostar.value) * parseFloat(factor_pago);
           /*/ if (parseInt(forma.montoPremio.value) > total_factor) {
                //alert("Advertencia!. No se puede vender el ticket por que el monto a pagar supera el monto establecido por el factor apuesta cuyo valor calculado es de "+total_factor+" Bs. FAVOR REFORMULE SU APUESTA.");
                toastr.warning(
                    'No se puede vender el ticket por que el monto a pagar supera el monto establecido por el factor apuesta cuyo valor calculado es de <b>' +
                    total_factor +
                    ' (' +
                    forma.moneda.value +
                    ')</b> . FAVOR REFORMULE SU APUESTA.',
                    ' Advertencia !!!'
                );
                return false;
            }/*/
        }
        if (parseInt(forma.montoPremio.value) > monto_premio) {
           /*/ //alert("Advertencia!. Monto maximo para los premios hasta "+monto_premio+" BS.F. por Ticket.\n\nPor favor reformule su apuesta.");
            toastr.warning(
                'Monto maximo para los premios hasta <b>' +
                monto_premio +
                ' (' +
                forma.moneda.value +
                ')</b> . por Ticket.\n\nPor favor reformule su apuesta.',
                ' Advertencia !!!'
            );
            return false;/*/
        }
        //alert(mxaltafut)
        cant_parl = logrosCalc.length;
        if (cant_parl == 1) {
            if (cupoDvend > 0) {
                if (parseInt(forma.montoApostar.value) > cupoDvend) {
                    //alert("Advertencia!. El Cupo Derecho, supero el limite asignado.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo Derecho, supero el limite asignado.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                }
            }
        }
        var pathname = window.location.pathname;
        //alert(pathname)
        var URLdomain = window.location.host;
        //alert(URLdomain)
        var tmpURL = 'http://' + URLdomain + directorio + '/home'; //+pathname;
        //alert(tmpURL)
        //var url = tmpURL+"/jugada_repetida";
        var url = 'jugadaduplicada.php';
        //<?php  echo site_url('home/jugada_repetida') ?>
        //alert(url);
        $('#zona_impresion').html('ticket.ticket');
        $.post(

            url, {
                logrosCalc: logrosCalc,
                montoApuesta: forma.montoApostar.value,
                montoPremio: parseInt(forma.montoPremio.value),
                mxtcrep: mxtcrep,
            },
            function(eData) {
                //document.write(eData)
                //alert(eData)
                if (eData == 1) {
                    //alert("Advertencia!. El Cupo Derecho Grupo, supero el limite asignado.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo Derecho Grupo, supero el limite asignado.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 2) {
                    //alert("Advertencia!. El Cupo Parley Grupo, supero el limite asignado.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo Parley Grupo, supero el limite asignado.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 3) {
                    //alert("Advertencia!. El Cupo Derecho Vendedor, supero el limite asignado.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo Derecho Vendedor, supero el limite asignado.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 4) {
                    //alert("Advertencia!. El Cupo Parley Vendedor, supero el limite asignado.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo Parley Vendedor, supero el limite asignado.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 5) {
                    //alert("Advertencia!. El Cupo, supero el limite asignado.\n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo, supero el limite asignado.\n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 6) {
                    //alert("Advertencia!. Supero el limite de Ticket repetidos "+mxtcrep+" m�ximo.");
                    toastr.warning(
                        'Supero el limite de Ticket repetidos ' + mxtcrep + ' m�ximo.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 7) {
                    //alert("Advertencia!. El Cupo, supero el limite de Combinaci�n Repetidas Venta en Bs. \n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo, supero el limite de Combinaci�n Repetidas Venta en <b>(' +
                        forma.moneda.value +
                        ')</b>  \n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 8) {
                    //alert("Advertencia!. Logro no conside con el valor establecido. \n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'Logro no conside con el valor establecido. \n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else if (eData == 9) {
                    //alert("Advertencia!. El Cupo, supero el limite de Combinaci�n Repetidas Premio en Bs. \n\nPor favor reformule su apuesta.");
                    toastr.warning(
                        'El Cupo, supero el limite de Combinaci�n Repetidas Premio en <b>(' +
                        forma.moneda.value +
                        ')</b>  \n\nPor favor reformule su apuesta.',
                        ' Advertencia !!!'
                    );
                    return false;
                } else {









                    //alert(tipo_impresion)
                    if (window.habilitado) {

                        forma.agregar.value = 'true';
                        nticket = forma.n_ticket.value;
                        sid = forma.serial.value;
                        cant_parl = logrosCalc.length;
                        if (cant_parl == 1) {

                            tipo = 'DE';
                        } else {
                            tipo = 'PA';
                        }

                        if (imprime == 'S') {
                            $('#enviarChatBoton').prop("disabled", true);
                            var url = 'ingresar_ventav2.php';
                            //este es el que usa
                            $.post(
                                url,
                                $('#form').serialize() +
                                '&tipo=' +
                                tipo +
                                '' +
                                '&logrosCalc=' +
                                JSON.stringify(logrosCalc) +
                                '',
                                function(eData) {

                                    console.log(eData);
                                    var ticket7 = JSON.parse(eData);
                                    var ticket = eData;

                                    //alert(ticket7.error);
                                    console.log(ticket);
                                    if (ticket) {

                                        if (ticket7.error > 0) {
                                            limpiar();

                                            if (ticket7.error == 1) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO CORRECTAMENTE ALGUN JUEGO ESTA CERRADO\n\n POR FAVOR VUELVA A REALIZAR LA APUESTA. GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;
                                            }
                                            if (ticket7.error == 2) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO CORRECTAMENTE ALGUN LOGRO A CAMBIADO\n\n POR FAVOR VUELVA A REALIZAR LA APUESTA. GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;
                                            }
                                            if (ticket7.error == 3) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO3 \n\n . GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;
                                            }
                                            if (ticket7.error == 4) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO4 \n\n . GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;
                                            }
                                            if (ticket7.error == 5) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO5 \n\n . GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;

                                            }
                                            if (ticket7.error == 6) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO6 \n\n . GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;

                                            }



                                            if (ticket7.error > 6) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO CORRECTAMENTE \n\n SIN DEFINIR COMPROBACION. GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;

                                            }

                                            //limpiarPantalla()






                                        } else {






                                            if (tipot2 == 0) {







                                            function imprSelec(muestra) {
                                                var ficha = document.getElementById(muestra);
                                                var ventimp = window.open(' ', '_blank', 'width=0, height=0, scrollbars=NO, top=0, left=0');
                                                ventimp.document.write(ficha.innerHTML);
                                                ventimp.document.close();
                                                ventimp.print();
                                                ventimp.close();
                                            }


                                            function nuevoAjax() {
                                                var xmlhttp = false;
                                                try {
                                                    // Creacion del objeto AJAX para navegadores no IE
                                                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                                                } catch (e) {
                                                    try {
                                                        // Creacion del objet AJAX para IE
                                                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                                    } catch (E) { xmlhttp = false; }
                                                }
                                                if (!xmlhttp && typeof XMLHttpRequest != 'undefined') { xmlhttp = new XMLHttpRequest(); }
                                                return xmlhttp;
                                            }

                                            function imprimeTicketie(cod, acceso) {

                                                if (acceso == 1) {
                                                    ajax = nuevoAjax();
                                                    ajax.open('POST', 't_imprimeticketp.php', true);
                                                    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                    ajax.send("iD=" + cod);
                                                    ajax.onreadystatechange = function() {
                                                        if (ajax.readyState == 4) {
                                                            document.getElementById('divImprime').innerHTML = ajax.responseText;
                                                            imprSelec('divImprime');
                                                            infou();
                                                            limpiarPantalla();
                                                        }
                                                    }
                                                }
                                            }


                                            function imprimeTicketall(cod, acceso) {
                                                if (acceso == 1) {
                                                    limpiar();

                                                    ajax = nuevoAjax();
                                                    ajax.open('POST', 't_imprimeticketp.php', true);
                                                    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                    ajax.send("iD=" + cod);
                                                    ajax.onreadystatechange = function() {
                                                        if (ajax.readyState == 4) {
                                                            //document.getElementById('divImprime').innerHTML = ajax.responseText;
                                                            //doPrint();
                                                            //imprSelec('divImprime');
                                                            document.getElementById('divImprime').innerHTML = ajax.responseText;
                                                            var htmlString = document.getElementById('divImprime').innerHTML;
                                                            var newIframe = document.createElement('iframe');
                                                            newIframe.width = '1px';
                                                            newIframe.height = '1px';
                                                            newIframe.src = 'about:blank';
                                                            // for IE wait for the IFrame to load so we can access contentWindow.document.body
                                                            newIframe.onload = function() {
                                                                var script_tag = newIframe.contentWindow.document.createElement("script");
                                                                script_tag.type = "text/javascript";
                                                                var script = newIframe.contentWindow.document.createTextNode('function Print(){ window.focus(); window.print(); }');
                                                                script_tag.appendChild(script);
                                                                newIframe.contentWindow.document.body.innerHTML = htmlString;

                                                                newIframe.contentWindow.document.body.appendChild(script_tag);
                                                                // for chrome, a timeout for loading large amounts of content
                                                                setTimeout(function() {
                                                                    newIframe.contentWindow.Print();
                                                                    //newIframe.contentWindow.document.removeChild(script_tag);
                                                                    newIframe.remove();
                                                                }, 1);
                                                            };
                                                            document.body.appendChild(newIframe);
                                                            document.getElementById(monto).value = "";
                                                            //limpiarPantalla()
                                                            infou();
                                                        }
                                                    }
                                                }
                                            }


                                            imprimeTicketie(ticket, '1');



                                        }
                                        if (tipot2 == 1) {
                                        infou();
                                        limpiarPantalla();
                                    }










                                            //alert('show1111111111111');
                                            //$('#modalTicket').modal('show'); /// ***este bloquea la pantalla
                                            //$('#informacion_ticket').html(
                                            //  ticket.whatApp.replace(/<br ?\/?>/g, '\r\n')
                                            // );
                                            // $('#zona_impresion').html(ticket.ticket);


                                            // $('#info_ticketact').html(ticket.sms);
                                            //$('#inf_ticket_pdf').html(ticket.pdf);
                                            //$('#nticket1').val(ticket.nticket);
                                        }
                                    } else {
                                        toastr.warning(
                                            'Problema con la conexi�n de servidor.',
                                            ' Advertencia !!!'
                                        );
                                    }
                                }
                            );
                            limpiar();
                            //window.habilitado = false;
                            //document.forms[0].submit();
                            return true;
                        } else if (imprime == 'N') {
                            alert('Aqui Estoy');
                            alert(imprime);
                            if (impresion_click == false) {
                                impresion_click = true;
                                if (logrosCalc.length > 0) {
                                    var url = 'ingresar_ventav2.php';
                                    $.post(
                                        url,
                                        $('#form').serialize() +
                                        '&tipo=' +
                                        tipo +
                                        '' +
                                        '&logrosCalc=' +
                                        JSON.stringify(logrosCalc) +
                                        '',
                                        function(eData) {
                                            console.log(eData);
                                            var ticket = JSON.parse(eData);
                                            if (ticket.error > 0) {
                                                toastr.warning(
                                                    'TICKET NO FUE GRABADO CORRECTAMENTE POR FAVOR VERIFIQUE JUEGOS CERRADOS\n\n ERROR EN EVIDENCIA DE LOGROS. GRACIAS!',
                                                    ' Advertencia !!!'
                                                );
                                                return false;
                                            } else {
                                                if (tipot == 'A') {
                                                    toastr.success('TICKET # '+ticket.nticket.substr(ticket.nticket.length - 4)+' SOLICITELO A LA TAQUILLA.');

                                                    Swal.fire({
                                                        title: 'Ticket Auto-Servicio',
                                                        text: 'TICKET # ' +
                                                            ticket.nticket.substr(ticket.nticket.length - 4) +
                                                            ' SOLICITELO A LA TAQUILLA.',
                                                        icon: 'warning',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ticket Registrado',
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            document.forms[0].submit();
                                                        }
                                                    });
                                                } else {
                                                    toastr.success(ticket.sms);
                                                }
                                            }
                                        }
                                    );
                                    limpiar();
                                    return true;
                                } else {
                                    toastr.success(
                                        'EL TICKET NO FUE GRABADO  POR FAVOR VERIFIQUE. GRACIAS!'
                                    );
                                    return false;
                                }
                            } else {
                                document.forms[0].submit();
                            }
                        } else {
                            return false;
                        }
                    }
                    return false;
                }









            }
        );
    } else {
        tipo = 'MA';
        forma.agregar.value = 'true';
        nticket = forma.n_ticket.value;
        sid = forma.serial.value;
        if (parseInt(forma.montoPremio.value) == 0) {
            alert('No hay premio para esta apuesta');
            return false;
        }
        if (jdmin_macuare > 0) {
            if (parseFloat(forma.montoApostar.value) < jdmin_macuare) {
                alert(
                    'El monto minimo a jugar es de <b>(' +
                    forma.moneda.value +
                    ')</b>. ' +
                    jdmin_macuare
                );
                return false;
            }
        } else {
            if (parseFloat(forma.montoApostar.value) < jdmin_macuare) {
                alert(
                    'El monto minimo a jugar es de <b>(' +
                    forma.moneda.value +
                    ')</b>. ' +
                    jdmin_macuare
                );
                return false;
            }
        }
        if (parseInt(forma.montoApostar.value) > tope_venta) {
            alert(
                'Tope maximo de venta hasta <b>' +
                tope_venta +
                ' (' +
                forma.moneda.value +
                ')</b>. por Ticket.\n\nPor favor reformule su apuesta.'
            );
            return false;
        }
        if (parseInt(forma.montoPremio.value) > tope_macuare) {
            alert(
                'Monto maximo para los premios hasta <b>' +
                tope_macuare +
                ' (' +
                forma.moneda.value +
                ')</b>. por Ticket.\n\nPor favor reformule su apuesta.'
            );
            return false;
        }
        if (logrosCalc.length < 7) {
            alert(
                'Debe de jugar las 7 Carreras.\n\nPor favor reformule su apuesta. '
            );
            return false;
        }
        if (imprime == 'S') {
            switch (tipo_impresion) {
                case 'T': //'TICKET-MySQL'
                    var consola = new ActiveXObject('WScript.Shell');
                    var retorno = consola.run(
                        'c:\\printer\\ticket.exe "' +
                        serial +
                        '" "' +
                        n_ticket +
                        '" ' +
                        puerto +
                        ' ' +
                        'N' +
                        ' ' +
                        '' +
                        ' ' +
                        ''
                    );
                    logrosCalc.length = 0;
                    location.reload();
                    break;
                case 'P': //'PRINTER-DIRECT'
                    if (typeof getCookie('puertoTicket') == 'undefined') {
                        setPuertoTicket();
                        if (typeof getCookie('puertoTicket') == 'undefined') {
                            alert(
                                'El puerto no fue grabado, habilite las cookies en el navegador'
                            );
                            dpUI.loading.stop('Loading ...');
                            return false;
                        }
                    }
                    var navegador = navigator.appName;
                    if (navegador == 'Microsoft Internet Explorer') {
                        if (!ActiveXEnabledOrUnnecessary()) {
                            alert(
                                'Tu navegador no soporta Activex. Consulte con el administrador del sistema.'
                            );
                            document.forms[0].submit();
                            return false;
                        } else {
                            var consola = new ActiveXObject('WScript.Shell');
                            $.post(
                                "<?php  echo site_url('ingresar_ventav2.php3') ?>",
                                $('#form').serialize() +
                                '&tipo=' +
                                tipo +
                                '' +
                                '&logrosCalc=' +
                                JSON.stringify(logrosCalc) +
                                '',
                                function(eData) {
                                    if (eData == 'Error') {
                                        alert(
                                            'TICKET NO FUE GRABADO CORRECTAMENTE POR FAVOR VERIFIQUE JUEGOS CERRADOS\n\n ERROR EN EVIDENCIA DE LOGROS. GRACIAS!'
                                        );
                                        dpUI.loading.stop('Loading ...');
                                        return false;
                                    } else {
                                        mypopup = window.open(
                                            "<?php  echo site_url('home/impresion/" +
                                            nticket +
                                            "') ?>",
                                            'ventana',
                                            'toolbar=no,location=no,status=no,menubar=no,rezisable=yes,width=100,height=100,left=0,top=0,alwaysRaised=no'
                                        );
                                    }
                                }
                            );
                            limpiar();
                            window.habilitado = false;
                            document.forms[0].submit();
                            return true;
                        }
                    } else {
                        alert(
                            'Advertencia! No puedes imprimir ticket por este navegador. Consulte con Administrador'
                        );
                        //dpUI.loading.stop("Loading ...")
                        return false;
                    }
                    break;
                case 'J': //'PRINTER-JAVA'
                    $.post(
                        "<?php  echo site_url('ingresar_ventav2.php4') ?>",
                        $('#form').serialize() +
                        '&tipo=' +
                        tipo +
                        '' +
                        '&logrosCalc=' +
                        JSON.stringify(logrosCalc) +
                        '',
                        function(eData) {
                            if (eData == 'Error') {
                                alert(
                                    'TICKET NO FUE GRABADO CORRECTAMENTE POR FAVOR VERIFIQUE JUEGOS CERRADOS\n\n ERROR EN EVIDENCIA DE LOGROS. GRACIAS!'
                                );
                                dpUI.loading.stop('Loading ...');
                                return false;
                            } else {
                                mypopup = window.open(
                                    "<?php  echo site_url('home/impresion_java/" +
                                    nticket +
                                    "') ?>",
                                    'ventana',
                                    'toolbar=no,location=no,status=no,menubar=no,rezisable=yes,width=100,height=100,left=0,top=0,alwaysRaised=no'
                                );
                            }
                        }
                    );
                    limpiar();
                    window.habilitado = false;
                    document.forms[0].submit();
                    return true;
                    break;
                case 'F': //'PRINTER-JAVA'
                    $.post(
                        "<?php  echo site_url('ingresar_ventav2.php5') ?>",
                        $('#form').serialize() +
                        '&tipo=' +
                        tipo +
                        '' +
                        '&logrosCalc=' +
                        JSON.stringify(logrosCalc) +
                        '',
                        function(eData) {
                            if (eData == 'Error') {
                                alert(
                                    'TICKET NO FUE GRABADO CORRECTAMENTE POR FAVOR VERIFIQUE JUEGOS CERRADOS\n\n ERROR EN EVIDENCIA DE LOGROS. GRACIAS!'
                                );
                                //dpUI.loading.stop("Loading ...")
                                return false;
                            } else {
                                $.post(
                                    "<?php  echo site_url('home/impresion_firefox') ?>", { n_ticket: nticket },
                                    //$("#form_buscar2015").serialize(),
                                    function(eData) {
                                        $('#ticketimpresora').html(eData);
                                        imprSelec2('ticketimpresora');
                                    }
                                );
                            }
                        }
                    );
                    limpiar();
                    window.habilitado = false;
                    document.forms[0].submit();
                    return true;
                    break;
            }
        } else if (imprime == 'N') {
            if (impresion_click == false) {
                impresion_click = true;
                if (logrosCalc.length > 0) {
                    $.post(
                        "<?php  echo site_url('home/insertar_ventas') ?>", {
                            nticket: nticket,
                            sid: sid,
                            montoApuesta: forma.montoApostar.value,
                            totalPremio: forma.montoPremio.value,
                            tipo: tipo,
                        },
                        function(eData) {
                            if (eData > 0) {
                                for (var k = 0; k < logrosCalc.length; k++) {
                                    $.post(
                                        "<?php  echo site_url('home/insert_ventas_detalles') ?>", {
                                            tipo: logrosCalc[k].tipo,
                                            cant: logrosCalc[k].cantidad,
                                            referencia: logrosCalc[k].referencia,
                                            logro: logrosCalc[k].logro,
                                            calendario: logrosCalc[k].padre,
                                            deporte: logrosCalc[k].deporte,
                                            n_ticket: nticket,
                                            equipo: logrosCalc[k].juego,
                                        },
                                        function(eData) {}
                                    );
                                }
                                $.post(
                                    "<?php  echo site_url('home/buscar_ventas_detalle') ?>", { n_ticket: nticket },
                                    function(eData) {
                                        if (eData != logrosCalc.length) {
                                            alert(
                                                'TICKET NO FUE GRABADO CORRECTAMENTE POR FAVOR VERIFIQUE. GRACIAS!'
                                            );
                                            $.post(
                                                "<?php  echo site_url('home/anular_ticket_auto') ?>", { n_ticket: nticket },
                                                function(eData) {
                                                    alert(
                                                        'TICKET FUE ANULADO AUTOMATICAMENTE POR wParley. GRACIAS!'
                                                    );
                                                    dpUI.loading.stop('Loading ...');
                                                }
                                            );
                                        }
                                    }
                                );
                                limpiar();
                                document.forms[0].submit();
                                return true;
                            } else {
                                alert('EL TICKET NO FUE GRABADO POR FAVOR VERIFIQUE. GRACIAS!');
                                dpUI.loading.stop('Loading ...');
                            }
                        }
                    );
                } else {
                    alert('EL TICKET NO FUE GRABADO  POR FAVOR VERIFIQUE. GRACIAS!');
                    dpUI.loading.stop('Loading ...');
                    return false;
                }
            } else {
                document.forms[0].submit();
            }
        } else {
            return false;
        }
    }
}

function imprSelec2(muestra) {
    var ficha = document.getElementById(muestra);
    var ventimp = window.open('', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}

function imprimirTicket() {
    imprSelec2('zona_impresion');
    $('#modalTicket').modal('hide');
    window.habilitado = false;
    document.forms[0].submit();
}

function envioEmail() {
    var pathname = window.location.pathname;
    var URLdomain = window.location.host;
    tmpURL = 'http://' + URLdomain + directorio + '/email';
    bootbox.prompt({
        title: 'Ingresa el Email a enviar Ticket',
        inputType: 'email',
        closeButton: false,
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancelar',
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Enviar',
            },
        },
        callback: function(result) {
            console.log(result);
            if (result) {
                var code1 = $('#nticket1').val();
                //alert(code1);
                //alert(result);
                console.log(result);
                $.ajax({
                    type: 'POST',
                    url: '' + tmpURL,
                    global: false,
                    data: { n_ticket: code1, email: result },
                    timeout: 20000,
                    beforeSend: function() {
                        //$('#info2').html('<i class="fa fa-spinner fa-spin fa-2x"></i><br/>En Proceso! Por favor espere ...');
                        $('#btnImprimir').prop('disabled', true);
                        $('#btnEmail').prop('disabled', true);
                        $('#btnSms').prop('disabled', true);
                        $('#btnAnularTick').prop('disabled', true);
                    },
                    success: function(eData) {
                        //alert(eData)
                        var ticket = JSON.parse(eData);
                        if (ticket.error == 1) {
                            bootbox.alert(ticket.sms);
                            $('#btnImprimir').prop('disabled', false);
                            $('#btnEmail').prop('disabled', false);
                            $('#btnSms').prop('disabled', false);
                            $('#btnAnularTick').prop('disabled', false);
                        } else {
                            bootbox.alert(ticket.sms);
                            $('#modalTicket').modal('hide');
                            window.habilitado = false;
                            document.forms[0].submit();
                        }
                        //bootbox.alert(eData);
                        //alert(eData)
                        //$('#btnBuscarTaq').prop("disabled", false);
                        //var ticket = JSON.parse(eData);
                        //$("#info2").html(ticket.ticket);
                        //$('#nticket').val(ticket.nticket);
                    },
                    error: function(e) {
                        //alert(e.responseText)
                        bootbox.alert({
                            message: '<div class="text-center"><h3>NO HUBO RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</div>',
                            callback: function() {
                                $('#btnImprimir').prop('disabled', false);
                                $('#btnEmail').prop('disabled', false);
                                $('#btnSms').prop('disabled', false);
                                $('#btnAnularTick').prop('disabled', false);
                                console.log(e.responseText);
                            },
                        });
                    },
                });
            }
        },
    });
}

function envioSms() {
    var pathname = window.location.pathname;
    var URLdomain = window.location.host;
    tmpURL = 'http://' + URLdomain + directorio + '/sms';
    //bootbox.prompt("Ingresa el n�mero de Tel�fono a enviar Ticket", function(result){
    bootbox.prompt({
        title: 'Ingresa el n�mero de Tel�fono a enviar Ticket',
        inputType: 'numer',
        closeButton: false,
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancelar',
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Enviar',
            },
        },
        callback: function(result) {
            if (result) {
                var code1 = $('#nticket1').val();
                //alert(code1);
                //alert(result);
                console.log(result);
                $.ajax({
                    type: 'POST',
                    url: '' + tmpURL + '/interconectados',
                    global: false,
                    data: { code: code1, cell: result },
                    timeout: 20000,
                    beforeSend: function() {
                        //$('#info2').html('<i class="fa fa-spinner fa-spin fa-2x"></i><br/>En Proceso! Por favor espere ...');
                        $('#btnImprimir').prop('disabled', true);
                        $('#btnEmail').prop('disabled', true);
                        $('#btnSms').prop('disabled', true);
                        $('#btnAnularTick').prop('disabled', true);
                    },
                    success: function(eData) {
                        //alert(eData)
                        var ticket = JSON.parse(eData);
                        if (ticket.error == 1) {
                            bootbox.alert(ticket.sms);
                            $('#btnImprimir').prop('disabled', false);
                            $('#btnEmail').prop('disabled', false);
                            $('#btnSms').prop('disabled', false);
                            $('#btnAnularTick').prop('disabled', false);
                        } else {
                            bootbox.alert(ticket.sms);
                            $('#modalTicket').modal('hide');
                        }
                        //bootbox.alert(eData);
                        //alert(eData)
                        //$('#btnBuscarTaq').prop("disabled", false);
                        //var ticket = JSON.parse(eData);
                        //$("#info2").html(ticket.ticket);
                        //$('#nticket').val(ticket.nticket);
                    },
                    error: function(e) {
                        //alert(e.responseText)
                        bootbox.alert({
                            message: '<div class="text-center"><h3>NO HUBO RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</div>',
                            callback: function() {
                                $('#btnImprimir').prop('disabled', false);
                                $('#btnEmail').prop('disabled', false);
                                $('#btnSms').prop('disabled', false);
                                $('#btnAnularTick').prop('disabled', false);
                                console.log(e.responseText);
                            },
                        });
                    },
                });
            }
        },
    });
}

function limpiarPantalla() {
    location.reload();
}

function btnlogrofutbol(id) {
    var pathname = window.location.pathname;
    var URLdomain = window.location.host;
    tmpURL = 'http://' + URLdomain + directorio + '/taquilla_ticket';

    $.post('' + tmpURL + '/logrosMobilSoccer', { id: id }, function(eData) {
        $('#viewLogro').html(eData);
        $('#exampleModal').modal('show');
    });
}