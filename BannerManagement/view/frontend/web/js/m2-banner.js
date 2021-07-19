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
            $(".banner-wrapper").click(function () {
                $('.banner-modal').modal('openModal');
            });
        }

        function createModal() {
            let wrapper = $('<div class="banner-wrapper"></div>');
            let bannerContent = $('<div class="banner-content"></div>');
            let bannerModal = $('<div class="banner-modal"></div>');
            let bannerModalPopup = $('<div class="banner-modal-popup"></div>');
            let bannerModalPopupContent = $('<div class="banner-modal-popup_content"></div>');

            bannerModalPopup.append(bannerModalPopupContent);
            bannerModal.append(bannerModalPopup);

            wrapper.append(bannerContent);
            wrapper.append(bannerModal);
            return wrapper;
        }

        function getViewedBannersId() {
            let storage = JSON.parse(localStorage.getItem('viewedBanners'));
            return storage !== null ? storage : [];
        }

        function setViewedBannersId(id) {
            let persistedBanners = getViewedBannersId();
            persistedBanners.push(id);
            localStorage.setItem('viewedBanners', JSON.stringify(persistedBanners));
        }

        function getBannerToDisplay(banners) {
            let rand = Math.floor(Math.random() * banners.length);
            let currentBanner = banners[rand];
            if (currentBanner.show_once === '1') setViewedBannersId(currentBanner.banner_id);
            return banners[rand];
        }

        function setModalData(data) {
            let popupDiv = $('<div></div>');
            let bannerDiv = $('<div></div>');
            popupDiv.html(data.banner_popup_text_content);
            bannerDiv.html(data.banner_text_content);
            $(".banner-modal .banner-modal-popup_content").append($(popupDiv));
            $(".banner-wrapper .banner-content").append($(bannerDiv));
        }

        return function (options) {
            let URL = options.baseUrl;
            let showedBanners = getViewedBannersId();
            URL = URL + '?getBanner=true&viewedBanners=' + (showedBanners.length > 0 ? showedBanners.join() : 0);
            $.ajax({
                url: URL,
                method: 'GET',
                cache: false,
                context: $('.sections.nav-sections'),
                dataType: 'JSON',
                success: function (banners) {
                    console.log(banners)
                    let currentBanner = getBannerToDisplay(banners);
                    if (currentBanner) {
                        let modal = createModal();
                        $(this).append(modal);
                        initializeModalComponent();
                        setModalData(currentBanner);
                    }
                },
                error: function (e) {
                    // ....
                }
            });
        }
    }
);
