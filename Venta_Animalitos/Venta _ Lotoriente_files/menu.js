$(document).ready( function() {

	var menu_fv01 = '.menu-fv01';
	var container_cmfv01 = '.container--cmfv01';

	function openSubMenu(sub_menu_element, ul_element) {
		$(sub_menu_element).addClass('open');
		$(ul_element).slideDown('fast');
	}

	function closeSubMenu(sub_menu_element, ul_element) {
		$(sub_menu_element).removeClass('open');
		$(ul_element).slideUp('fast');
	}

	function toggleSubMenu(sub_menu_element) {
		var ul_element_all = $(menu_fv01).find('li.sub-menu-fv01 ul');
		var ul_element_li_all = $(menu_fv01).find('li.sub-menu-fv01');		
		var ul_element = $(sub_menu_element).children('ul');
		var display_property = $(ul_element).css('display');

		if (display_property == 'none') {
			closeSubMenu(ul_element_li_all, ul_element_all);
			openSubMenu(sub_menu_element, ul_element);
		}
		else
			closeSubMenu(sub_menu_element, ul_element);
	}

	$(menu_fv01).find('li.sub-menu-fv01').children('a').click( function(e) {
		e.preventDefault();
		toggleSubMenu($(this).parent());
	});

	function openMenu() {
		$(menu_fv01).addClass('open');

		// Agrego la clase que permite que el contenedor principal se desplaze hacia la derecha.
		$(container_cmfv01).addClass('menu-open-overlay-click');
	}

	function closeMenu() {
		$(menu_fv01).removeClass('open');

		// Remuevo la clase para que el margen izquierdo se elimine.
		$(container_cmfv01).removeClass('menu-open-overlay-click');
	}

	function toggleMenu() {
		var state_menu = $(menu_fv01).attr('class');

		if (state_menu == 'menu-fv01')
			openMenu();
		else
			closeMenu();
	}

	// Abro o cierro el menú al presionar el botón hamburger.
	$('.btn-toggle-cmfv01').click( function() {
		toggleMenu();
	});

	$(document).on('click', '.menu-open-overlay-click', function() {
		toggleMenu();
	});

	// Versión mini.
	$('.btn-toggle-mini-cmfv01').click(function() {
		if ($(menu_fv01).attr('mini') == 'true') {
			$(this).find('span').attr('class', 'fa fa-ellipsis-v');
			$(menu_fv01).removeAttr('animation');
			$(menu_fv01).attr('mini', 'false');
			$(menu_fv01).attr('animation', 'animation-menu-show');
		}
		else {
			$(menu_fv01).removeAttr('animation');
			$(this).find('span').attr('class', 'fa fa-navicon');
			$(menu_fv01).attr('mini', 'true');
			$(menu_fv01).attr('animation', 'animation-menu-hide');
		}
	});
});
