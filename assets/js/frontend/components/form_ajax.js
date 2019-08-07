import $ from 'jquery'
import 'jquery-form'

class FormAjax {
	constructor($block) {
		this.$block = $block
		this.init()
	}

	init() {
		var toContainer = this.$block.data('submit-to-container')
		var form = this.$block

		this.$block.prop('disabled', false)

		var submit = function (event, type) {
			event.preventDefault()

			$(form).ajaxSubmit({
				beforeSend: function() {
					$(form).find('input, textarea, button, select').attr('disabled','disabled')
				},
				success: function (responseText, statusText, xhr, $form) {
					var status = xhr.status
					if (status === 202) {
						var data = eval(responseText)
						if (data.redirect_to) {
							document.location.href = data.redirect_to;
						} else {
							document.location.reload();
						}
					} else {
						if (form.data('submit-callback')) {
							form.data('submit-callback')(responseText)
						} else {
							if (responseText) {
								$('#' + toContainer).html(responseText)
							}

							global.reinitEvents($('#' + toContainer))
						}
					}
				},
				error: function (error) {
					alert('Some technical problems. Please try again later');
				}
			})
		}

		this.$block.on('submit', submit)
		this.$block.on('send', submit)
	}

}

global.initAjaxForms = function (element) {
	if (element == undefined) {
		element = $('body')
	}

	if ($('.js-form-submit', element).length) {
		$('.js-form-submit', element).each((item, block) => {
			new FormAjax($(block))
		})
	}

	$('.js-auto-submit', element).bind('change', function () {
		$(this).form().submit()
	})

	$('.js-reset-submit', element).bind('click', function () {
		$(this).form().trigger("reset")
	})
}

global.initAjaxForms()
