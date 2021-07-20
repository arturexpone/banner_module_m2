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

        return function () {
            initializeModalComponent();
        }
    }
);
