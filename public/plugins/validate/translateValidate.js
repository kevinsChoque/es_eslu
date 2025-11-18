jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número entero válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    accept: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
    minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
    range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
    max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
    min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
});
jQuery.validator.setDefaults({
	errorPlacement: function(error, element)
	{

		// console.log(element.parent().parent('.input-group'));
		if(element.parent().parent('.form-group').find('.input-group-prepend').hasClass('input-group-prepend'))
		{
			// error.appendTo(element.parent('.input-group').parent('form-group').find('label').html());
			// console.log(element.parent().parent().find('.input-group-prepend').hasClass('input-group-prepend'));
			// console.log(element.parent().parent('.form-group').hasClass('form-group'));
			// console.log(element.parent().parent('.form-group').find('.input-group-prepend').hasClass('input-group-prepend'));
			error.appendTo(element.parent().parent('.form-group'));
		}
		else
		{
			if(element.parent('.input-group').hasClass('input-group'))
			{
				// if()
				console.log('si tiene');
				error.appendTo(element.parent('.input-group'));
			}
			else
			{
				error.appendTo(element.parent('.form-group'));
			}
			// console.log(element.parent('.form-group'));
			// error.appendTo(element.parent('.input-group'));
			// error.appendTo(element.prev());
		}
		if(element.parent().find('[id=numeroPart]').attr('id')=='numeroPart' || element.parent().find('[id=numeroPart]').attr('id')=='anioPart')
		{
			// console.log('si entro aiki----------');
			error.appendTo(element.parent().parent('form-group'));
		}
		// console.log('validacion start-------------------------------');
		// console.log(element.parent().find('[id=numeroPart]').attr('id')=='numeroPart');
		// console.log(element.parent().parent().attr('class'));
		// console.log('validacion end-------------------------------');
	}
});
