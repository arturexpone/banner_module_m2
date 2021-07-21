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
            const options = {
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
            $(".banner-wrapper").click(function () {
                $('.banner-modal').modal('openModal');
            });
        }

        function setModalData(banner) {
            let {
                banner_popup_text_content: popupContent,
                banner_text_content: bannerContent,
                desktop_image: dImg,
                mobile_image: mImg,
                banner_name
            } = banner;
            $('.banner-modal-popup_content').html(popupContent);
            $('.banner-content').html(bannerContent);
            $('.banner-background source').attr('srcset', dImg);
            $('.banner-background img').attr('src', mImg);
            $('.banner-wrapper').addClass('initialize');
        }

        function alertErrorInPage(error) {
            alert(error);
        }

        function setBannerIdToLS(id) {
            let viewedBanners = getViewedBannersInLS();
            localStorage.setItem('viewed_banners', viewedBanners ? viewedBanners + ',' + id : id);
        }

        function getViewedBannersInLS() {
            return localStorage.getItem('viewed_banners');
        }

        return function ({groupCode, baseUrl}) {
            let compiledUrl = baseUrl
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
                    const {responseJSON} = e;
                    if (responseJSON && responseJSON.error_message === 'Banner not found') {
                        alertErrorInPage(responseJSON.error_message);
                    }
                }
            });
        }
    }
);
