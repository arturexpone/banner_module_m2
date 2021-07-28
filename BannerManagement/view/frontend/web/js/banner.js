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

        return function (options) {
            var query = "?query={GetRandomBanner(viewed_banners: \""
                + (getViewedBannersInLS() || '0') + "\", group_code:" + "\""
                + options.groupCode + "\"," + "shown_store_id:" + "\"" + options.storeId
                + "\")"
                + "{banner_id banner_text_content banner_popup_text_content desktop_image mobile_image show_once shown_store_id}}";

            $.ajax({
                method: 'get',
                url: options.baseUrl + query,
                contentType: 'application/json',
                success: function(data){

                    if (data.errors) {
                        alert(data.errors[0].message);
                        return;
                    }

                    var banner = data.data.GetRandomBanner;

                    if (banner.show_once === '1') {
                        setBannerIdToLS(banner.banner_id);
                    }

                    initializeModalComponent();
                    setModalData(banner);
                },
                error: function(e){
                    // ...
                }
            })
        }
    }
);
