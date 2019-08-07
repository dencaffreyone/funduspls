import $ from 'jquery'

class Accordion {
	constructor($block) {
		this.$block = $block
		this.$block.$item = $('.js-accordion_item', this.$block)
		this.$block.$opener = $('.js-accordion_item_opener', this.$block)
		this.bind()
	}

	bind() {
		this.$block.$opener.on('click', (e) => {
			let $item = $(e.currentTarget).parents('.js-accordion_item')
			let $content = $('.js-accordion_item_content', $item)

			$('.js-accordion_item').not($item).removeClass('-active')
			$('.js-accordion_item_content').stop().slideUp('fast')

			$item.toggleClass('-active')
			$content.stop().slideToggle('fast')
		})
	}

}

if ($('.js-accordion').length) {
	$('.js-accordion').each((item, block) => {
		new Accordion($(block))
	})
}
