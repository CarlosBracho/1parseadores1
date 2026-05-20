var apiUrl = 'animales/';

var animals = [{
                    animal: "Hormiga",
                    number: 36
                }, {
                    animal: "Gato",
                    number: 11
                }, {
                    animal: "Caiman",
                    number: 30
                }, {
                    animal: "Raton",
                    number: 08
                }, {
                    animal: "Cebra",
                    number: 23
                }, {
                    animal: "Tigre",
                    number: 10
                }, {
                    animal: "leon",
                    number: 5
                }, {
                    animal: "Iguana",
                    number: 24
                }, {
                    animal: "Oso",
                    number: 16
                }, {
                    animal: "Panda",
                    number: 33
                }, {
                    animal: "Carnero",
                    number: 1
                }, {
                    animal: "Culebra",
                    number: 37
                }, {
                    animal: "Puerco",
                    number: 20
                }, {
                    animal: "Paloma",
                    number: 14
                }, {
                    animal: "Lapa",
                    number: 31
                }, {
                    animal: "Aguila",
                    number: 9
                }, {
                    animal: "Camello",
                    number: 22
                }, {
                    animal: "Burro",
                    number: 18
                }, {
                    animal: "Elefante",
                    number: 29
                }, {
                    animal: "Loro",
                    number: 7
                }, {
                    animal: "Zamuro",
                    number: 28
                }, {
                    animal: "Caballo",
                    number: 12
                }, {
                    animal: "Tiburon",
                    number: 35
                }, {
                    animal: "Ciempies",
                    number: 3
                }, {
                    animal: "Vaca",
                    number: 26
                }, {
                    animal: "Murcielago",
                    number: 32
                }, {
                    animal: "Zorro",
                    number: 15
                }, {
                    animal: "Cabra",
                    number: 19
                }, {
                    animal: "Alacran",
                    number: 4
                }, {
                    animal: "Gallo",
                    number: 21
                }, {
                    animal: "Araña",
                    number: 0
                }, {
                    animal: "Toro",
                    number: 2
                }, {
                    animal: "Gallina",
                    number: 25
                }, {
                    animal: "Pavo",
                    number: 17
                }, {
                    animal: "Pulpo",
                    number: 34
                }, {
                    animal: "Sapo",
                    number: 6
                },
                {
                    animal: "Perro",
                    number: 27
                }, {
                    animal: "Mono",
                    number: 13
                }
            ];

var options        = {};
options.prices     = animals;
options.clockWise  = false;
options.duration   = 1000;
options.separation = 0;
options.clockWise  = true;

$(function() {
    var $r = $('.roulette').fortune(options);
    var clickHandler = function() {
        $('.spinner').off('click');
        $('.spinner span').hide();

        $r.spin().done(function(win) {
			$('#animal').text(win.animal);
			$('#number').text(win.number);
			$('div.second').css('background-image', 'url(' + apiUrl + win.number + '.png' + ')');
            $('.spinner').on('click', clickHandler);
            $('.spinner span').show();
        });
    };

    $('.spinner').on('click', clickHandler);
});