(function ($) {
	"use strict";

	function parents(element, selector) {
		const parentsArray = [];
		let currentElement = element.parentElement;

		while (currentElement !== null) {
			if (currentElement.matches(selector)) {
				parentsArray.push(currentElement);
			}
			currentElement = currentElement.parentElement;
		}

		return parentsArray;
	}

	document.addEventListener("DOMContentLoaded", () => {

		var switcher = document.querySelectorAll('.redux-container-switch');

		if (switcher.length) {

			switcher.forEach(swtch => {

				let on = swtch.querySelector('.cb-enable'),
					off = swtch.querySelector('.cb-disable');

				if (on.classList.contains('selected')) {

					swtch.classList.add('sw--on');

				} else {

					swtch.classList.remove('sw--on');
				}

				swtch.addEventListener('click', () => {

					swtch.classList.toggle('sw--on');

					if (swtch.classList.contains('sw--on')) {

						off.click();
					} else {
						on.click();
					}

				})



			})

		}

		let typo = document.querySelectorAll('.redux-container-typography');

		if (typo.length) {

			typo.forEach(ty => {

				let tabField = parents(ty, '.redux-tab-field');


				if (tabField.length) {

					tabField.forEach(tb => {
						// tb.classList.add('typo--field')
					})

				}


			})


		}



	});

	jQuery(document).ready(function ($) {
		// WordPress medya yükleyiciyi tanımlamak için dışarıda bir değişken oluşturun
		var mediaUploader;

		// Medya seçiciyi aç
		$(document).off('click', '.add_variation_images').on('click', '.add_variation_images', function (e) {
			e.preventDefault();

			var $button = $(this); // Tıklanan butonu referans al
			var $galleryWrapper = $button.siblings('.variation_images_gallery_images');
			var $galleryInput = $button.siblings('.variation_gallery_images');

			// Eğer medya yükleyici zaten açıksa, yeniden oluşturma
			if (mediaUploader) {
				mediaUploader.off('select'); // Eski olay dinleyicilerini kaldır
				mediaUploader.on('select', function () {
					handleMediaSelection(mediaUploader, $galleryWrapper, $galleryInput);
				});
				mediaUploader.open();
				return;
			}

			// Yeni medya yükleyici oluştur
			mediaUploader = wp.media({
				title: 'Select or Upload Images',
				button: { text: 'Add to gallery' },
				multiple: true // Birden fazla görsel seçme
			});

			// Görsel seçildikten sonra işlemleri tanımla
			mediaUploader.on('select', function () {
				handleMediaSelection(mediaUploader, $galleryWrapper, $galleryInput);
			});

			// Yükleyiciyi aç
			mediaUploader.open();
		});

		// Seçilen görselleri işleme fonksiyonu
		function handleMediaSelection(mediaUploader, $galleryWrapper, $galleryInput) {
			var attachments = mediaUploader.state().get('selection').toJSON();
			var imageIds = $galleryInput.val() ? $galleryInput.val().split(',') : [];

			attachments.forEach(function (attachment) {
				if (!imageIds.includes(attachment.id.toString())) {
					imageIds.push(attachment.id);
					$galleryWrapper.append(
						'<li class="image" data-attachment_id="' +
						attachment.id +
						'"><img src="' +
						attachment.sizes.full.url +
						'" /><a href="#" class="delete" title="Remove image">&times;</a></li>'
					);
				}
			});

			$galleryInput.val(imageIds.join(','));
			$('#variable_description0').trigger(
				'change'
			);

		}

		// Görsel kaldırma
		$(document).on('click', '.variation_images_gallery_images .delete', function (e) {
			e.preventDefault();

			var $image = $(this).closest('li');
			var $galleryWrapper = $image.closest('.variation_images_gallery_images');
			var $galleryInput = $galleryWrapper.siblings('.variation_gallery_images');

			$image.remove();

			var imageIds = [];
			$galleryWrapper.find('li').each(function () {
				imageIds.push($(this).data('attachment_id'));
			});

			$galleryInput.val(imageIds.join(','));
			$('#variable_description0').trigger(
				'change'
			);
			console.log($('#variable_product_options'))

		});


		$('#woocommerce-product-data').on('woocommerce_variations_loaded', function () {

			$('.variation_images_gallery_images').sortable({
				items: 'li.image',
				cursor: 'move',
				scrollSensitivity: 40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start: function (event, ui) {
					ui.item.css('background-color', '#f6f6f6');
				},
				stop: function (event, ui) {
					ui.item.removeAttr('style');
				},
				update: function () {
					var $galleryWrapper = $(this);
					var $galleryInput = $galleryWrapper.siblings('.variation_gallery_images');
					var imageIds = [];

					$galleryWrapper.find('li').each(function () {
						imageIds.push($(this).data('attachment_id'));
					});

					$galleryInput.val(imageIds.join(','));
					$('#variable_description0').trigger(
						'change'
					);

				}
			});


			$('.linked_variation_checkbox').on('change', function () {
				var selectField = $(this).closest('.linked_variation').find('.linked_variation_select');
				if ($(this).is(':checked')) {
					selectField.show();
				} else {
					selectField.hide();
				}
			});

			$('.linked_variation_checkbox').each(function () {
				var selectField = $(this).closest('.linked_variation').find('.linked_variation_select');
				if ($(this).is(':checked')) {
					selectField.show();
				} else {
					selectField.hide();
				}
			});




		});


		// Select2 başlatma
		function initSelect2() {
			$('.wc-product-search').select2({
				ajax: {
					url: ajaxurl,
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							term: params.term,
							action: 'woocommerce_json_search_products',
							security: woocommerce_admin_meta_boxes.search_products_nonce,
						};
					},
					processResults: function (data) {
						return {
							results: $.map(data, function (item, id) {
								return { id: id, text: item };
							}),
						};
					},
					cache: true,
				},
				minimumInputLength: 1,
			});
		}

		// Yeni ürün satırı ekle
		$('.add-fbt-row').on('click', function () {
			const newRow = `
	<tr>
		<td>
			<select name="fbt_products[]" class="wc-product-search" style="width: 100%;" data-placeholder="Search for a product..." data-action="woocommerce_json_search_products"></select>
		</td>
		<td>
			<button type="button" class="button remove-fbt-row"><?php _e('Remove', 'saren'); ?></button>
		</td>
	</tr>`;
			$('.fbt-repeater tbody').append(newRow);
			initSelect2(); // Yeni eklenen select için select2 başlat
		});

		// Ürün satırını kaldır
		$(document).on('click', '.remove-fbt-row', function () {
			$(this).closest('tr').remove();
		});

		// Mevcut select2 alanlarını başlat
		initSelect2();



		


	});


})(jQuery)
