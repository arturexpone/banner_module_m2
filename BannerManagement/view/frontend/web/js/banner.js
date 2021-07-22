define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function (
        $,
        modal
    ) {
        function initializeModalComponent() {
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Popup title',
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
            };

            modal(options, $('.banner-modal'));
            $('.banner-wrapper').click(function () {
                $('.banner-modal').modal('openModal');
            });
        }

        function setModalData(banner) {
            $('.banner-modal-popup_content').html(banner.banner_popup_text_content);
            $('.banner-content').html(banner.banner_text_content);
            $('.banner-background source').attr('srcset', banner.desktop_image);
            $('.banner-background img').attr('src', banner.mobile_image);
            $('.banner-wrapper').addClass('initialize');
        }

        function alertErrorInPage(error) {
            alert(error);
        }

        function setBannerIdToLS(id) {
            var viewedBanners = getViewedBannersInLS();
            var summaryBanners;

            if (viewedBanners) {
                summaryBanners = viewedBanners + ',' + id;
            } else {
                summaryBanners = id;
            }

            localStorage.setItem('viewed_banners', summaryBanners);
        }

        function getViewedBannersInLS() {
            return localStorage.getItem('viewed_banners');
        }

        return function ({groupCode, baseUrl}) {
            var compiledUrl = baseUrl
                + '?group_code=' + groupCode
                + '&viewed_banners=' + (getViewedBannersInLS() || '0');
            $.ajax({
                url: compiledUrl,
                method: 'GET',
                cache: false,
                dataType: 'JSON',
                success: function (banner) {
                    if (banner.show_once === '1') {
                        setBannerIdToLS(banner.banner_id);
                    }
                    initializeModalComponent();
                    setModalData(banner);
                },
                error: function (e) {
                    if (e.responseJSON && e.responseJSON.error_message === 'Banner not found') {
                        alertErrorInPage(e.responseJSON.error_message);
                    }
                }
            });
        }
    }
);
