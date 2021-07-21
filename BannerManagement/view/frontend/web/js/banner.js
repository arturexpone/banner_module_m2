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

        function getDeviceType () {
            const ua = navigator.userAgent;
            if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
                return "tablet";
            }
            if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
                return "mobile";
            }
            return "desktop"
        }

        function setBackImageInBanner(mobile, desktop) {
            const device = getDeviceType();
            let currentImage;

            device === 'mobile' || device === 'tablet'
                ? currentImage = mobile
                : currentImage = desktop;

            $(".banner-content")
                .css('background', 'url(' + currentImage + ')')
                .parent()
                .addClass('initialize');
        }

        return function (options) {
            const {mobile_image, desktop_image} = options;
            setBackImageInBanner(mobile_image, desktop_image);
            initializeModalComponent();
        }
    }
);
