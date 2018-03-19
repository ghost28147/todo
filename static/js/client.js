TodoClient = function() {};

TodoClient.prototype.endpoint = '/api/items';

TodoClient.prototype.removeItem = function (id) {
    return jQuery.ajax({
            url: this.endpoint + '?id=' + id,
            method: "DELETE"
        }
    );
};

TodoClient.prototype.toggleItem = function (id) {
    return jQuery.ajax({
            url: this.endpoint + '?state=toggle&id=' + id,
            method: "PATCH"
        }
    );
};

TodoClient.prototype.removeCompleted = function (id) {
    return jQuery.ajax({
            url: this.endpoint + '/completed',
            method: "DELETE"
        }
    );
};

TodoClient.prototype.markAll = function (yes) {
    return jQuery.ajax({
            url: this.endpoint + '?state=' + (yes? 'active' : 'completed'),
            method: "PATCH"
        }
    );
};

TodoClient.prototype.createItem = function (content) {
    return jQuery.ajax({
            url: this.endpoint + '?content=' + content,
            method: "POST"
        }
    );
};