yii.allowAction = function ($e) {
    var message = $e.data('confirm');
    return message === undefined || yii.confirm(message, $e);
};

bootbox.setDefaults({
    /**
     * @optional String
     * @default: en
     * which locale settings to use to translate the three
     * standard button labels: OK, CONFIRM, CANCEL
     */
    locale: "ru"
});

yii.confirm = function (message, $e) {
    bootbox.confirm(message, function (confirmed) {
        if (confirmed) {
            yii.handleAction($e);
        }
    });
    // confirm will always return false on the first call
    // to cancel click handler
    return false;
}