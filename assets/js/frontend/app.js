import $ from 'jquery'

import './components/form_ajax'
import './components/accordion'

global.reinitEvents = function (element) {
	global.initAjaxForms(element)
}