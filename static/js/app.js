(function () {
	'use strict';

	var $todoList = $(".js-component");
	var todoClient = new TodoClient();

	var ENTER_KEY = 13;

	var handlers = [
        {
            events: "keypress",
            selector: ".js-new-item",
            handler: function (e) {
                e.keyCode === ENTER_KEY && createItem(e.target.value);
            }
        },
        {
            events: "click",
            selector: ".js-remove-item",
            handler: function (e) { removeItem( itemId(e) ); }
        },
        {
            events: "click",
            selector: ".js-toggle-item",
            handler: function (e) { toggleItem( itemId(e) ); }
        },
        {
            events: "click",
            selector: ".js-remove-completed",
            handler: removeCompleted
        },
        {
            events: "click",
            selector: ".js-toggle-all",
            handler: function (e) { markAll(!e.target.checked); }
        }];

	handlers.forEach( function(handler) {
	    $todoList.on(handler.events, handler.selector, handler.handler);
    });

    function removeItem(id) {
        act(function() {
            todoClient
                .removeItem(id)
                .done(function(data) { updateState(data); })
        })
    }

    function toggleItem(id) {
        act(function() {
            todoClient
                .toggleItem(id)
                .done(function(data) { updateState(data); })
        })
    }

    function removeCompleted() {
        act(function() {
            todoClient
                .removeCompleted()
                .done(function(data) { updateState(data); })
        })
    }

    function markAll(yes) {
        act(function() {
            todoClient
                .markAll(yes)
                .done(function(data) { updateState(data); })
        })
    }

    function createItem(content) {
        if (content.trim() === "") return;

        act(function() {
            todoClient
                .createItem(content)
                .done(function(data) { updateState(data); })
        })
    }

    function act(action) {
        $todoList.fadeTo(0, 0.5).css("pointer-events", "none");
        action();
        $todoList.fadeTo(0, 1).css("pointer-events", "");
    }

    function updateState($data) {
        $todoList.html($data);
    }

    function itemId(event) {
        var $removeButton  = $(event.target);
        var $itemContainer = $removeButton.closest(".js-item");

        return $itemContainer.attr("data-item-id");
    }

})();
